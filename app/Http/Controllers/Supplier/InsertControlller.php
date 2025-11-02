<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class InsertControlller extends Controller
{
    
    public function home()
    { 
        return view('people.addsupplier');
    }


    public function store(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $district = $request->input('district');
        $address = $request->input('address');
        $description = $request->input('description');
        $image = $request->file('image');
        $cityInput = $request->input('city');


        // Create the supplier
        $supplier = Supplier::create([
            'supplier_name' => $name,
            'email' => $email,
            'phone' => $phone,
            'district' => $district,
            'address' => $address,
            'description' => $description,
            'city' => $cityInput,
            'user_id' => auth()->id(),
        ]);

        // Upload and store supplier avatar if provided
        if ($image) {
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move('uploads/suppliers', $fileName); // Store the file
            $supplier->avatar = $fileName;
        }

        $supplier->save();

        return response()->json(['message' => 'supplier stored successfully']);
    }

}
