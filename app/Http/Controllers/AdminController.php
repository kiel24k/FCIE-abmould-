<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Material;
use App\Models\Scanned_Items;
use App\Models\ScannedItemsOut;
use App\Models\Schedule;
use App\Models\Tool_Inventory;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    public function userList(Request $request)
    {
        $sortName = $request->query('sort', 'first_name');
        $sortOrder = $request->query('order', 'asc');
        if ($request->role) {
            $table = User::where('role', '=', $request->role)
                ->orderBy($sortName, $sortOrder)
                ->paginate(3);
            return response()->json($table);
        } else if (!$request->category) {
            return response()->json(User::orderBy($sortName, $sortOrder)->paginate(10));
        } else if ($request->category) {
            return response()->json(User::orderBy($sortName, $sortOrder)->paginate(10));
        }
    }
    public function userListSearch(Request $request)
    {
        if (!$request->role) {
            $allUser = User::where('first_name', 'LIKE', '%' . $request->search . '%')
                ->latest()->paginate(10);
            return response()->json($allUser);
        } else if ($request->role) {
            $user = User::where('role', '=', $request->role)
                ->where('first_name', 'LIKE', '%' . $request->search . '%')
                ->latest()->paginate(10);
            return response()->json($user);
        }
    }
    public function deleteUser($id)
    {
        $deleteUser = User::find($id);
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

    public function userUpdatedData($id)
    {
        $user = User::find($id);
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
            'supplier_name' => 'nullable',
            'unit_cost'     => 'numeric',
            'quantity'      => 'numeric',
            'category'      => 'required',
            'description'   => 'required',
        ]);

        $item = new Item();
        $item->user_id       = $request->user_id;
        $item->item_code     = $request->item_code;
        $item->supplier_name = $request->supplier_name;
        $item->unit_cost     = $request->unit_cost;
        $item->quantity      = $request->quantity;
        $item->category      = $request->category;
        $item->description   = $request->description;
        $item->brand         = $request->brand;
        // $item->barcode       = $request->barcode;
        $item->save();
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
                        ->orWhere('brand', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
                })
                ->paginate(10);
            return response()->json($item);
        }
    }
    public function deleteItem($id)
    {
        $item = Item::find($id)->delete();
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
        // Validate the input
        $request->validate([
            'date_schedule' => 'required|date',
            'items'         => 'required|array|min:1', // Ensure items is an array with at least one item
            'items.*.item_code' => 'required|string', // Validate each item's code
            'items.*.quantity'  => 'required|integer|min:1', // Validate each item's quantity
        ]);

        // Loop through the items and save each schedule
        $schedules = [];
        foreach ($request->items as $item) {
            $schedule = new Schedule();
            $schedule->supplier_name = $request->supplier_name ?? 'Unknown'; // Default if not provided
            $schedule->item_code     = $item['item_code'];
            $schedule->quantity      = $item['quantity'];
            $schedule->date_schedule = $request->date_schedule;
            $schedule->status        = 'pending';
            $schedule->save();

            $schedules[] = $schedule;
        }

        // Return all created schedules as a response
        return response()->json($schedules, 201);
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

    public function category()
    {
        $items = Item::select('category')
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json($items);
    }
    public function getItem(Request $request)
    {
        if (!$request->category) {
            $allItem = Item::latest()
                ->paginate(10);
            return response()->json($allItem);
        } else if ($request->category) {
            $item = Item::where('category', '=', $request->category)
                ->latest()
                ->paginate(10);
            return response()->json($item);
        }
    }
    public function itemSearchlist(Request $request)
    {
        if (!$request->category) {
            $allItem = Item::where('item_code', 'LIKE', '%' . $request->search . '%')
                ->latest()
                ->paginate(10);
            return response()->json($allItem);
        } else if ($request->category) {
            $item = Item::where('category', '=', $request->category)
                ->where('item_code', 'LIKE', '%' . $request->search . '%')
                ->latest()
                ->paginate(10);
            return response()->json($item);
        }
    }

    public function getDateSchedule()
    {
        $data = Schedule::select('date_schedule')->get();
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

    public function lowStockAlert () {
        $data = DB::table('items')->sum('quantity');
        $alert = new AnnouncementController();
        if($data <= 30){
            $alert->lowStockAlert();
        }else{
            return response()->json([
                'status' => 200
            ]);
        }
    }
}
