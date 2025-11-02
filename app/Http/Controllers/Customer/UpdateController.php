<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    //Update customer

    public function editcustomer(Request $request)
    {
        $id = $request->query('id');
        $customers = Customer::find($id);

        return view('people.editcustomer', compact('customers'));
    }







    public function updatecustomer(Request $request)
    {
        $id = $request->input('id');
        // Find the product by ID
        $customer = Customer::findOrFail($id);

        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $district = $request->input('district');
        $address = $request->input('address');
        $description = $request->input('description');
        $image = $request->file('image');
        $cityInput = $request->input('city');

     
        // Update the Subcategory attributes
        $customer->customer_name = $name;
        $customer->email = $email;
        $customer->phone = $phone;
        $customer->district = $district;
        $customer->address = $address;
        $customer->city = $cityInput;
        $customer->description = $description;
        // Save the product updates
        $customer->save();

        // Update the product image if provided
        if ($image) {
                    $file = $request->file('image');
                    $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move('uploads/customers', $fileName);
        
                    // Delete the old image if it exists
                    if ($customer->avatar) {
                        if (file_exists('uploads/customers/' . $customer->avatar)) {
                            unlink('uploads/customers/' . $customer->avatar);
                        }
                    }
        
                    $customer->avatar = $fileName;
                }
        
                $customer->save();
        

        // Return a success response
        return response()->json(['message' => 'Customer Updated successfully']);
    }
}
