<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Schedule;
use App\Models\Tool_Inventory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function userList()
    {
        $table = User::latest()->paginate(5);
        return response()->json($table);
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
            'first_name' => 'required|string',
            'middle_name' => 'required|string',
            'last_name' => 'required|string',
            'tel_no' => 'required|numeric',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role' => 'required',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'tel_no' => $request->tel_no,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
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
            'first_name' => 'required|string',
            'middle_name' => 'required|string',
            'last_name' => 'required|string',
            'tel_no' => 'required|numeric',
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required',
        ]);

        $user = User::find($id);
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->last_name = $request->last_name;
        $user->tel_no = $request->tel_no;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
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

    public function newItemTools(Request $request)
    {
        $request->validate([
            'item_code' => 'required | unique:tools_inventories,item_code',
            'brand' => 'required',
            'supplier_name' => 'nullable',
            'unit_cost' => 'numeric',
            'quantity' => 'numeric',
            'item_type' => 'required',
            'description' => 'required',
        ]);

        $tools_inventory = new Tool_Inventory();
        $tools_inventory->item_code = $request->item_code;
        $tools_inventory->brand = $request->brand;
        $tools_inventory->supplier_name = $request->supplier_name;
        $tools_inventory->unit_cost = $request->unit_cost;
        $tools_inventory->quantity = $request->quantity;
        $tools_inventory->item_type = $request->item_type;
        $tools_inventory->description = $request->description;
        $tools_inventory->save();
        return response()->json($tools_inventory);
    }

    public function newMaterial(Request $request)
    {
        $request->validate([
            'item_code' => 'required | unique:materials,item_code',
            'supplier_name' => 'nullable',
            'unit_cost' => 'numeric',
            'quantity' => 'numeric',
            'item_type' => 'required',
            'description' => 'required',
        ]);

        $material = new Material();
        $material->item_code = $request->item_code;
        $material->supplier_name = $request->supplier_name;
        $material->unit_cost = $request->unit_cost;
        $material->quantity = $request->quantity;
        $material->item_type = $request->item_type;
        $material->description = $request->description;
        $material->save();
        return response()->json($material);
    }

    public function getMaterials()
    {
        $material = Material::paginate(8);
        return response()->json($material);
    }
    public function deleteMaterial($id)
    {
        $material = Material::find($id)->delete();
        return response()->json($material);
    }
    public function updatedMaterial($id)
    {
        $material = Material::find($id);
        return response()->json($material);
    }
    public function updateMaterial(Request $request, $id)
    {
        $request->validate([
            'item_code' => 'required',
            'supplier_name' => 'nullable',
            'unit_cost' => 'numeric',
            'quantity' => 'numeric',
            'item_type' => 'required',
            'description' => 'required',
        ]);

        $material = Material::find($id);
        $material->item_code = $request->item_code;
        $material->supplier_name = $request->supplier_name;
        $material->unit_cost = $request->unit_cost;
        $material->quantity = $request->quantity;
        $material->item_type = $request->item_type;
        $material->description = $request->description;
        $material->update();
        return response()->json($material);
    }
    public function scheduledDate($date) {
        $schedule = Schedule::where('date_schedule', $date)->get();
        return response()->json([
            'data' => $schedule,
            'message' => '200'
        ]);
    }
    public function addSchedule(Request $request) {
        $request->validate([
            'supplier_name' => 'required',
            'item_code' => 'required',
            'quantity' => 'required',
            'date_schedule' => 'required'
        ]);
        $schedule = new Schedule();
        $schedule->supplier_name = $request->supplier_name;
        $schedule->item_code = $request->item_code;
        $schedule->quantity = $request->quantity;
        $schedule->date_schedule = $request->date_schedule;
        $schedule->status = 'pending';
        $schedule->save();
        return response()->json($schedule);
    }
}
