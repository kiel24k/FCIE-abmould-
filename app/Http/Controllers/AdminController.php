<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Material;
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
        if ($request->role) {
            $table = User::where('role', '=', $request->role)
                ->latest()->paginate(5);
            return response()->json($table);
        } else if (!$request->category) {
            return response()->json(User::latest()->paginate(10));
        } else if ($request->category) {
            return response()->json(User::latest()->paginate(10));
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
        $item->item_code     = $request->item_code;
        $item->supplier_name = $request->supplier_name;
        $item->unit_cost     = $request->unit_cost;
        $item->quantity      = $request->quantity;
        $item->category      = $request->category;
        $item->description   = $request->description;
        $item->brand         = $request->brand;
        $item->barcode       = $request->barcode;
        $item->save();
        return response()->json($item);
    }

    public function itemCategory(Request $request)
    {
        if ($request->category) {
            $item = Item::where('category', '=', $request->category)
                ->paginate(10);
            return response()->json($item);
        } else if (!$request->category) {
            return response()->json(Item::latest()->paginate(10));
        } else if ($request->category) {
            return response()->json(Item::latest()->paginate(10));
        }
    }
    public function itemsSearch(Request $request)
    {
        if (!$request->category) {
            $allItem = Item::where('item_code', 'LIKE', '%' . $request->search . '%')
                ->paginate(10);
            return response()->json($allItem);
        } else if ($request->search) {
            $item = Item::where('category', '=', $request->category)
                ->where('item_code', 'LIKE', '%' . $request->search . '%')
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
    public function generateBarcode()
    {
        $a = mt_rand(100000, 999999);
        if ($this->generateBarcodeExist($a)) {
            return $this->generateBarcode();
        } else {
            return response()->json($a);
        }
    }
    public function generateBarcodeExist($number)
    {
        $number = Item::where('barcode', $number)->exists();
        return $number;
    }
    public function viewScanBarcode($barcode)
    {
        $item = Item::where('barcode', '=', $barcode)->get();
        return response()->json($item);
    }
    public function editQuantity($id){
        $item = Item::find($id);
        return response()->json($item);
    }
    public function addQuantitySubmit (Request $request, $id){
        $item = Item::find($id);
        $item->quantity = $request->quantity;
        $item->update();
        return response()->json($item);
    }
    public function reduceQuantity(Request $request, $id){
        $item = Item::find($id);
        $item->quantity = $request->quantity;
        $item->update();
        return response()->json($item);
    }
    // public function test(){

    //     return response()->json(Schema::getColumnListing('items'));

    // }
}
