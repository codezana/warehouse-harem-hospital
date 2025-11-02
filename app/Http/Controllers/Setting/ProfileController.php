<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    // View Profile
    public function home()
    {

        return view('Settings.profile');
    }

    public function profile(Request $request)
    {
        $image = $request->file('image');


        // Find the user by ID
        $user = Auth::user();



 
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

            $user->update(['file' => $fileName]);

        }
        // Save the updated user

        // Redirect back with success message
        return response()->json(['message' => 'Profile image updated successfully']);
    }

    
    //Update Info Profile
    // public function updateInfo(Request $request)
    // {
    //     $user = Auth::user();

    //     // Validate the form data
    //     $request->validate([
    //         'username' => 'required|string|max:255|unique:users,username,' . $user->id,
    //         'email' => 'required|email|unique:users,email,' . $user->id,
    //         'phone' => [
    //             'required',
    //             'string',
    //             'regex:/^\d{4} \d{3} \d{4}$/',
    //             'unique:users,phone,' . $user->id,
    //         ],
    //         'status' => 'required|in:admin,user',
    //         'password' => 'nullable|string|min:8|confirmed',
    //     ]);

    //     // Update the user's profile information
    //     $user->update([
    //         'username' => $request->input('username'),
    //         'email' => $request->input('email'),
    //         'phone' => $request->input('phone'),
    //     ]);

    //     // Update password if provided
    //     if ($request->input('password')) {
    //         $user->update([
    //             'password' => bcrypt($request->input('password')),
    //         ]);
    //     }

    //     return redirect()->back()->with('success', 'Profile information updated successfully.');
    // }




    public function infoProfile(Request $request)
    {
        $username = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $password = $request->input('password');


        $user = Auth::user();

        // Update user details
        $user->username = $username;
        $user->email = $email;
        $user->phone = $phone;

         // Update password if provided
         if ($request->input('password')) {
            $user->update([
                'password' => bcrypt($request->input('password')),
            ]);
        }


        // Redirect back with success message
        return response()->json(['message' => 'Your Info Updated successfully']);
    }

}
