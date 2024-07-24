<?php

namespace App\Http\Controllers;

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
            if (File::exists($filePath)){
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
}
