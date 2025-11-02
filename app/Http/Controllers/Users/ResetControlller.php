<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ResetControlller extends Controller
{
       //Reset Password
       public function reset(Request $request)
       {
           $id = $request->query('id');
   
           $user = User::findOrFail($id);
           $user->password = bcrypt('12345678');
           $user->save();
   
           return back()->with('success', 'Password reset successfully.');
       }
   
}
