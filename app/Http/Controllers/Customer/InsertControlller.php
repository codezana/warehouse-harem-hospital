<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InsertControlller extends Controller
{
    //Home Page 

    public function home()
    {
        return view('people.addcustomer');
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


        // Create the customer
        $customer = Customer::create([
            'customer_name' => $name,
            'email' => $email,
            'phone' => $phone,
            'district' => $district,
            'address' => $address,
            'description' => $description,
            'city' => $cityInput,
            'user_id' => auth()->id(),
        ]);

        // Upload and store customer avatar if provided
        if ($image) {
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move('uploads/customers', $fileName); // Store the file
            $customer->avatar = $fileName;
        }

        $customer->save();

        return response()->json(['message' => 'Customer stored successfully']);
    }



}
