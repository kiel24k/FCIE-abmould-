<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Material;
use App\Models\Scanned_Items;
use App\Models\ScannedItemsOut;
use App\Models\Schedule;
use App\Models\Tool_Inventory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{

    public function userListCategory()
    {
        $category = User::select('role')->distinct()->get();
        return response()->json($category);
    }
    public function userList(Request $request)
    {
        $sortName = $request->query('sortName', 'id');
        $sortOrder = $request->query('sortOrder', 'DESC');
        if (empty($request->category) && empty($request->search)) {
            $data = User::orderBy($sortName, $sortOrder)
                ->paginate(9);
            return response()->json($data);
        } else if (isset($request->category) && empty($request->search)) {
            $data = User::where('role', $request->category)
                ->orderBy($sortName, $sortOrder)
                ->paginate(9);
            return response()->json($data);
        } else if (empty($request->category) && isset($request->search)) {
            $data = User::where('first_name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('last_name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('middle_name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('email', 'LIKE', '%' . $request->search . '%')
                ->orWhere('tel_no', 'LIKE', '%' . $request->search . '%')
                ->orderBy($sortName, $sortOrder)
                ->paginate(9);
            return response()->json($data);
        } else if (isset($request->category) && isset($request->search)) {
            $data = User::where('role', $request->category)
                ->where(function ($query) use ($request) {
                    $query->where('first_name', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('middle_name', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('email', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('tel_no', 'LIKE', '%' . $request->search . '%');
                })
                ->orderBy($sortName, $sortOrder)
                ->paginate(9);
            return response()->json($data);
        }
    }

    public function viewUser(Request $request)
    {
        $data = User::find($request->id);
        return response()->json($data);
    }

    public function deleteUser(Request $request)
    {
        $deleteUser = User::find($request->id);
        $deleteUser->delete();
        return response()->json($deleteUser);
    }

    public function addUser(Request $request)
    {
        $request->validate([
            'first_name'  => 'required|string',
            'middle_name' => 'required|string',
            'last_name'   => 'required|string',
            'tel_no'      => 'required|numeric',
            'email'       => 'required|email|unique:users',
            'password'    => 'required',
            'role'        => 'required',
        ]);

        $user = User::create([
            'first_name'  => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name'   => $request->last_name,
            'tel_no'      => $request->tel_no,
            'email'       => $request->email,
            'password'    => bcrypt($request->password),
            'role'        => $request->role,
        ]);
        $image = $request->file('image');
        $fileName = $image->hashName();
        $request->image->move(public_path('UserImage'), $fileName);
        $user->image = $fileName;
        $user->save();
        return response()->json($user);
    }

    public function userUpdatedData(Request $request, $id)
    {
        $user = User::find($request->id);
        return response()->json($user);
    }
    public function userUpdateData(Request $request, $id)
    {
        $request->validate([
            'first_name'  => 'required|string',
            'middle_name' => 'required|string',
            'last_name'   => 'required|string',
            'tel_no'      => 'required|numeric',
            'email'       => 'required|email',
            'password'    => 'required',
            'role'        => 'required',
        ]);

        $user = User::find($id);
        $user->first_name  = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->last_name   = $request->last_name;
        $user->tel_no      = $request->tel_no;
        $user->email       = $request->email;
        $user->password    = bcrypt($request->password);
        $user->role        = $request->role;
        if ($request->hasFile('image')) {
            $filePath = 'UserImage/' . $user->image;
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
            $image = $request->file('image');
            $fileName = $image->hashName();
            $image->move(public_path('UserImage'), $fileName);
            $user->image = $fileName;
            $user->update();
        }
        $user->update();
        return response()->json($user);
    }
    public function newitem(Request $request)
    {
        $request->validate([
            'item_code'     => 'required | unique:items,item_code',
            'unit_cost'     => 'numeric',
            'quantity'      => "numeric|max:$request->treshold ",
            'treshold' => 'required|numeric',
            'category'      => 'required',
            'description'   => 'required',
        ]);
        $userId = $request->user_id;
        $item = new Item();
        $item->user_id       = $request->user_id;
        $item->item_code     = $request->item_code;
        $item->supplier_name = $request->supplier_name;
        $item->unit_cost     = $request->unit_cost;
        $item->quantity      = $request->quantity;
        $item->category      = $request->category;
        $item->treshold     = $request->treshold;
        $item->description   = $request->description;
        $item->brand         = $request->brand;
        $item->release_date = Carbon::now()->format('y/m/d');
        // $item->barcode       = $request->barcode;
        $item->save();
        NotificationController::addItemNotification($request->user_id);
        LogsController::createdLogs($userId);

        return response()->json($item);
    }

    public function itemCategory(Request $request)
    {
        $sortBy = $request->query('sort_by', 'brand'); // default brand request 
        $sortOrder = $request->query('sort_order', 'asc');
        if ($request->category) {
            $item = Item::where('category', '=', $request->category)
                ->orderBy($sortBy, $sortOrder)
                ->paginate(2);
            return response()->json($item);
        }
        if (!$request->category) {
            return response()->json(
                Item::orderBy($sortBy, $sortOrder)
                    ->paginate(10)
            );
        }
        if ($request->category) {
            return response()->json(Item::orderBy($sortBy, $sortOrder)->paginate(2));
        }
    }
    public function itemsSearch(Request $request)
    {
        $searchTerm = $request->search;

        if (empty($request->category)) {
            $allItem = Item::where(function ($query) use ($searchTerm) {
                $query->where('item_code', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('supplier_name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('unit_cost', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('quantity', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('category', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('treshold', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('brand', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
            })
                ->paginate(10);
            return response()->json($allItem);
        } else if ($searchTerm) {
            $item = Item::where('category', '=', $request->category)
                ->where(function ($query) use ($searchTerm) {
                    $query->where('item_code', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('supplier_name', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('unit_cost', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('quantity', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('category', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('treshold', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('brand', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
                })
                ->paginate(10);
            return response()->json($item);
        }
    }
    public function deleteItem(Request $request, $id)
    {
        $item = Item::find($id)->delete();
        LogsController::itemDeletedLogs($request->userId);
        return response()->json($item);
    }
    public function updatedItem($id)
    {
        $item = Item::find($id);
        return response()->json($item);
    }
    public function updateItem(Request $request, $id)
    {
        $request->validate([
            'item_code'     => 'required',
            'supplier_name' => 'nullable',
            'unit_cost'     => 'numeric',
            'quantity'      => 'numeric',
            'category'      => 'required',
            'description'   => 'required',
        ]);

        $material = Item::find($id);
        $material->item_code     = $request->item_code;
        $material->supplier_name = $request->supplier_name;
        $material->unit_cost     = $request->unit_cost;
        $material->quantity      = $request->quantity;
        $material->category      = $request->category;
        $material->description   = $request->description;
        $material->brand         = $request->brand;
        $material->update();
        LogsController::updateItemLogs($request->userId);
        return response()->json($material);
    }

    public function viewItem($id)
    {
        return response()->json(Item::find($id));
    }
    public function scheduledDate($date)
    {
        $schedule = Schedule::where('date_schedule', $date)->get();
        return response()->json([
            'data' => $schedule,
            'message' => '200'
        ]);
    }
    public function addSchedule(Request $request)
    {
        $request->validate([
            'supplier_name' => 'required',
            'item_code'     => 'required',
            'quantity'      => 'required',
            'date_schedule' => 'required'
        ]);
        $schedule = new Schedule();
        $schedule->supplier_name = $request->supplier_name;
        $schedule->item_code     = $request->item_code;
        $schedule->quantity      = $request->quantity;
        $schedule->date_schedule = $request->date_schedule;
        $schedule->status        = 'pending';
        $schedule->save();
        return response()->json($schedule);
    }
    // public function generateBarcode()
    // {
    //     $a = mt_rand(100000, 999999);
    //     if ($this->generateBarcodeExist($a)) {
    //         return $this->generateBarcode();
    //     } else {
    //         return response()->json($a);
    //     }
    // }
    public function generateBarcodeExist($number)
    {
        $number = Item::where('barcode', $number)->exists();
        return $number;
    }
    public function viewScanBarcode($barcode)
    {
        $item = Item::where('item_code', '=', $barcode)->get();
        return response()->json($item);
    }
    public function editQuantity($id)
    {
        $item = Item::find($id);
        return response()->json($item);
    }
    public function addQuantitySubmit(Request $request, $id)
    {
        $item = Item::find($id);
        $item->quantity = $request->quantity;
        $item->update();
        return response()->json($item);
    }
    public function reduceQuantity(Request $request, $id)
    {
        $item = Item::find($id);
        $item->quantity = $request->quantity;
        $item->update();
        return response()->json($item);
    }
    public function saveScannedItems(Request $request)
    {

        $request->validate([
            'item_code' => 'unique:scanned__items,item_code'
        ]);
        $item = new Scanned_Items();
        $item->user_id = $request->user_id;
        $item->item_id =  $request->item_id;
        $item->category =  $request->category;
        $item->item_code = $request->item_code;
        $item->brand =  $request->brand;
        $item->supplier_name =  $request->supplier_name;
        $item->unit_cost =  $request->unit_cost;
        $item->quantity =  $request->quantity;
        $item->description =  $request->description;
        $item->save();
        // Return the response with the validated data
        return response()->json(['message' => 'success'], 200);
    }

    public function getScannedItems($id)
    {
        $scannedItems = DB::table('scanned__items')
            ->select('*')
            ->where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($scannedItems);
    }

    public function saveScannedItemsOut(Request $request)
    {
        $request->validate([
            'item_code' => 'unique:scanned_items_outs,item_code'
        ]);
        $item = new ScannedItemsOut();
        $item->user_id = $request->user_id;
        $item->item_id =  $request->item_id;
        $item->category =  $request->category;
        $item->item_code = $request->item_code;
        $item->brand =  $request->brand;
        $item->supplier_name =  $request->supplier_name;
        $item->unit_cost =  $request->unit_cost;
        $item->quantity =  $request->quantity;
        $item->description =  $request->description;
        $item->save();
        return response()->json(['message' => 'success'], 200);
    }
    public function getScannedItemsOut($id)
    {
        $scannedItems = DB::table('scanned_items_outs')
            ->select('*')
            ->where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($scannedItems);
    }

    //////testsraasesaeae///////////////

    public function itemListCategory()
    {
        $data = Item::select('release_date')
            ->orderBy('id', 'DESC')
            ->distinct()
            ->get();

        return response()->json($data);
    }
    public function getItemList(Request $request)
    {
        $sortName = $request->query('sortName', 'id');
        $sortBy = $request->query('sortBy', 'DESC');
        if (empty($request->category) && empty($request->search)) {
            $data = Item::orderBy($sortName, $sortBy)->paginate(9);
            return response()->json($data);
        } else if (isset($request->category) && empty($request->search)) {
            $data = Item::where('release_date', $request->category)
                ->orderBy($sortName, $sortBy)
                ->paginate(9);
            return response()->json($data);
        } else if (empty($request->category) && isset($request->search)) {
            $data = Item::where('item_code', 'LIKE', '%' . $request->search . '%')
                ->orWhere('category', 'LIKE', '%' . $request->search . '%')
                ->orWhere('item_code', 'LIKE', '%' . $request->search . '%')
                ->orWhere('brand', 'LIKE', '%' . $request->search . '%')
                ->orWhere('supplier_name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('unit_cost', 'LIKE', '%' . $request->search . '%')
                ->orWhere('quantity', 'LIKE', '%' . $request->search . '%')
                ->orWhere('treshold', 'LIKE', '%' . $request->search . '%')
                ->orWhere('description', 'LIKE', '%' . $request->search . '%')
                ->orderBy($sortName, $sortBy)
                ->paginate(9);
            return response()->json($data);
        } else if (isset($request->category) && isset($request->search)) {
            $data = Item::where('release_date', $request->category)
                ->where(function ($query) use ($request) {
                    $query->where('item_code', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('category', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('item_code', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('brand', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('supplier_name', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('unit_cost', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('quantity', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('treshold', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('description', 'LIKE', '%' . $request->search . '%');
                })
                ->orderBy($sortName, $sortBy)
                ->paginate(9);
            return response()->json($data);
        }
    }



    public function getDateSchedule()
    {
        $data = Schedule::select('date_schedule')->distinct()->get();
        $data->prepend(['date_schedule' => 'all']); // Add 'all' at the beginning

        return response()->json($data);
    }
    public function scheduleList(Request $request)
    {
        $search = $request->search;
        $category = $request->category;
        if ((empty($category) || $category == 'all') && empty($search)) {
            $item = Schedule::get();
            return response()->json($item);
        } else if ((empty($category) || $category == 'all' && !empty($search))) {
            $item = Schedule::where(function ($query) use ($search) {
                $query->where('supplier_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('item_code', 'LIKE', '%' .  $search . '%')
                    ->orWhere('quantity', 'LIKE', '%' .  $search . '%')
                    ->orWhere('status', 'LIKE', '%' .  $search . '%')
                    ->orWhere('date_schedule', 'LIKE', '%' .  $search . '%');
            })->get();
            return response()->json($item);
        } else if ((!empty($category) && empty($search))) {
            $item = Schedule::where('date_schedule', $category)->get();
            return response()->json($item);
        } else if ((!empty($category) && !empty($search))) {
            $item = Schedule::where('date_schedule', '=', $category)
                ->where(function ($query) use ($search) {
                    $query->where('supplier_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('item_code', 'LIKE', '%' .  $search . '%')
                        ->orWhere('quantity', 'LIKE', '%' .  $search . '%')
                        ->orWhere('status', 'LIKE', '%' .  $search . '%')
                        ->orWhere('date_schedule', 'LIKE', '%' .  $search . '%');
                })->get();
            return response()->json($item);
        }
    }
    public function updateScheduleStatus(Request $request)
    {
        $schedule = Schedule::find($request->id);
        $schedule->status = $request->status;
        $schedule->update();
        return response()->json($schedule);
    }

    public function countStatus()
    {
        $data = DB::table('schedules')
            ->select('status')
            ->selectRaw('COUNT(*) as status_count')
            ->groupBy('status')
            ->get();
        return response()->json($data);
    }

    public function lowStockAlert()
    {
        $data = DB::table('items')->sum('quantity');
        $alert = new AnnouncementController();
        if ($data <= 30) {
            $alert->lowStockAlert();
        } else {
            return response()->json([
                'status' => 200
            ]);
        }
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8',]
        ]);

        $currentPasswordStatus = Hash::check($request->current_password, $request->old_password);
        if (!$currentPasswordStatus) {
            return response()->json([
                'message' => "Password Doesn't match!",
                'status' => 401
            ]);
        } else {
            User::findOrFail($request->id)->update([
                'password' => Hash::make($request->new_password)
            ]);
            return response()->json([
                'message' => 'Password Update Change',
                'status' => 200
            ]);
        }
    }

    public function stockCategory()
    {
        $data = Item::select('release_date')
            ->orderBy('release_date', 'ASC')
            ->distinct()
            ->get();
        return response()->json($data);
    }

    public function getStock(Request $request)
    {
        $sort = $request->query('sort', 'ASC');
        $sortedName = $request->query('sortedName', 'category');
        $paginate = 10;
        if (empty($request->category) && empty($request->search)) {
            $data = DB::table('items')
                ->orderBy($sortedName, $sort)
                ->paginate($paginate);
            return response()->json($data);
        } else if (isset($request->category) && empty($request->search)) {
            $data = DB::table('items')
                ->where('release_date', $request->category)
                ->orderBy($sortedName, $sort)
                ->paginate($paginate);
            return response()->json($data);
        } else if (empty($request->category) && isset($request->search)) {
            $data = DB::table('items')
                ->where('item_code', 'LIKE', '%' . $request->search . '%')
                ->orWhere('supplier_name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('unit_cost', 'LIKE', '%' . $request->search . '%')
                ->orWhere('quantity', 'LIKE', '%' . $request->search . '%')
                ->orWhere('treshold', 'LIKE', '%' . $request->search . '%')
                ->orWhere('category', 'LIKE', '%' . $request->search . '%')
                ->orWhere('description', 'LIKE', '%' . $request->search . '%')
                ->orWhere('brand', 'LIKE', '%' . $request->search . '%')
                ->orderBy($sortedName, $sort)
                ->paginate($paginate);
            return response()->json($data);
        } else if (isset($request->category) && isset($request->search)) {
            $data = DB::table('items')
                ->where('release_date', $request->category)
                ->where(function ($query) use ($request) {
                    $query->where('supplier_name', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('item_code', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('unit_cost', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('quantity', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('treshold', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('category', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('description', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('brand', 'LIKE', '%' . $request->search . '%');
                })
                ->orderBy($sortedName, $sort)
                ->paginate($paginate);
            return response()->json($data);
        }
    }

    public function postCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
            'details' => 'required'
        ]);
        $category = new Category();
        $category->name = $request->name;
        $category->details = $request->details;
        $category->release_date = Carbon::now()->format('y/m/d');
        $category->save();
        return response()->json($category);
    }

    public function categoryListCategory()
    {
        $data = Category::select('release_date')
            ->orderBy('release_date')->get();
        return response()->json($data);
    }

    public function categoryListTable(Request $request)
    {

        $sortOrder = $request->query('sortOrder', 'ASC');
        $sortName = $request->query('sortName', 'name');
        if (empty($request->category) && empty($request->search)) {
            $data = Category::orderBy($sortName, $sortOrder)->paginate(5);
            return response()->json($data);
        } else if (isset($request->category) && empty($request->search)) {
            $data = Category::where('release_date', $request->category)
                ->orderBy($sortName, $sortOrder)
                ->paginate(5);
            return response()->json($data);
        } else if (empty($request->category) && isset($request->search)) {
            $data = Category::where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('details', 'LIKE', '%' . $request->search . '%')
                ->orderBy($sortName, $sortOrder)
                ->paginate(5);
            return response()->json($data);
        } else if (isset($request->search) && isset($request->category)) {
            $data = Category::where('release_date', $request->category)
                ->where(function ($query) use ($request) {
                    $query->where('name', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('details', 'LIKE',  '%' . $request->search  . '%');
                })
                ->orderBy($sortName, $sortOrder)
                ->paginate(5);
            return response()->json($data);
        }
    }

    public function getUpdateCategoryList(Request $request)
    {
        $category = Category::find($request->id);
        return response()->json($category);
    }

    public function updateCategoryLIst(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'details' => 'required'
        ]);
        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->details = $request->details;
        $category->update();

        return response()->json($category);
    }

    public function deleteCategory(Request $request)
    {
        $category = Category::find($request->id)->delete();
        return response()->json($category);
    }

    public function getTreshold(Request $request)
    {
        $treshold = Item::find($request->id);
        return response()->json($treshold);
    }

    public function updateTreshold(Request $request)
    {
        $userId = $request->userId;
        $request->validate([
            'treshold' => 'required|numeric'
        ]);
        $treshold = Item::find($request->id);
        $treshold->treshold = $request->treshold;
        $treshold->update();
        LogsController::tresholdLogs($userId);
        return response()->json($treshold);
    }

    public function getQuantity(Request $request)
    {
        $stock = Item::find($request->id);
        return response()->json($stock);
    }

    public function updateQuantity(Request $request)
    {
        $userId = $request->userId;
        $request->validate([
            'quantity' => 'required|numeric'
        ]);
        $stock = Item::find($request->id);
        $stock->quantity = $request->quantity;
        $stock->update();
        LogsController::quantityLogs($userId);
        return response()->json($stock);
    }
}
