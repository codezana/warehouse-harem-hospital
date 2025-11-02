<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class PrintControlller extends Controller
{

    // Print product
    public function printProduct($productId)
    {
        $product = Product::find($productId);

        return view('product.barcodeproduct', compact('product'));
    }


    //Page Print barcode for product
    public function printbarcode()
    {

        return view('product.barcode');
    }



}
