<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ListControlller extends Controller
{
    public function userlists()
    {
        $users = User::all()->map(function ($user) {
            if ($user->created_at !== null) {
                $user->formatted_created_at = $user->created_at->format('Y-m-d');
            } else {
                $user->formatted_created_at = null; // Handle null created_at
            }
            return $user;
        });

        return view('users.userlists', compact('users'));
    }

    public function toggleStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->is_enabled = !$user->is_enabled;
        $user->save();

        return redirect()->route('userlists')->with('status', 'User status updated successfully.');
    }



}
