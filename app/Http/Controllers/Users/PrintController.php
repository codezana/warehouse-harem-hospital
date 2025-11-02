<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Models\User; // Adjust the model namespace based on your project
use App\Http\Controllers\Controller; // Make sure you're extending the base controller class

class PrintController extends Controller
{
    public function generatePrint()
    {
        $users = User::all(); // Fetch the data you want to include in the print version

        return view('print.print-view', compact('users')); // Pass data to the view
    }
}
