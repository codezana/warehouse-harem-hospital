<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdateControlller extends Controller
{
    //Update User 

    public function editusers(Request $request)
    {
        $id = $request->query('id');
        $user = User::find($id);
        $roles = Role::all();

        return view('users.edituser', compact('user', 'roles'));
    }




    public function updateusers(Request $request)
    {
        $id = $request->input('id');
        $username = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $roles = $request->input('roles');
        $password = $request->input('password');
        $image = $request->file('image');


        // Find the user by ID
        $user = User::findOrFail($id);

        // Update user details
        $user->username = $username;
        $user->email = $email;
        $user->phone = $phone;
        $user->roles()->sync($roles);

        // Update password if provided
        if ($password) {
            $user->password = Hash::make($password);
        }

 
        if ($image) {
            $file = $request->file('image');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/users', $fileName);

            // Delete the old image if it exists
            if ($user->file) {
                if (file_exists('uploads/users/' . $user->file)) {
                    unlink('uploads/users/' . $user->file);
                }
            }

            $user->file = $fileName;
        }
        // Save the updated user
        $user->save();

        // Redirect back with success message
        return response()->json(['message' => 'User Updated successfully']);
    }
}
