<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImportproductController extends Controller
{
    public function importproduct(){

        return view('product.importproduct');
       }
}
