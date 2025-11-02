<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InsertControlller extends Controller
{
    
    public function newuser()
    {
        $roles = Role::all();

        return view('users.newuser', compact('roles'));
    }

    public function checkEmailExistenceuser(Request $request)
    {
        // Retrieve the email from the request
        $email = $request->input('email');
   
        // Check if the email exists in the database
        $exists = User::where('email', $email)->exists();

        // Return a JSON response indicating whether the email exists
        return response()->json(['exists' => $exists]);
    }


    public function storeUser(Request $request)
    {
 
       $username=$request->input('name');
       $email=$request->input('email');
       $phone=$request->input('phone');
       $roles=$request->input('roles');
       $password=$request->input('password');
       $image=$request->file('image');

        // Create the new user
        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->phone = $phone;
        $user->password = bcrypt($password);
        $user->created_by_user_id = Auth::id();


        if ($image) {
            $file = $request->file('image');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/users', $fileName);
            $user->file = $fileName;
        }
        $user->save();
        $user->roles()->attach($roles);

        // Redirect back with success message
        return response()->json(['message' => 'User stored successfully']);
    }

}
