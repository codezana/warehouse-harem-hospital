<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ListControlller extends Controller
{


    //Supplier List
    public function supplierlist()
    {

        $suppliers = Supplier::all();
        return view('people.supplierlist', compact('suppliers'));
    }


    // Supplier Details
    public function show(Request $request)
    {
        // Get the ID from the 'id' query parameter
        $id = $request->query('id');

        $supplier = Supplier::findOrFail($id);
        return view('people.supplierdetails', compact('supplier'));
    }
}
