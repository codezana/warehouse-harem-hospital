<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class ListControlller extends Controller
{
      //Home page
      public function customerlist()
      {
          $customers = Customer::all();
          return view('people.customerlist', compact('customers'));
      }

}
