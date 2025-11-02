<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class UpdateControlller extends Controller
{
    //Update supplier

    public function editsupplier(Request $request)
    {
        $id = $request->query('id');
        $suppliers = Supplier::find($id);
        
        return view('people.editsupplier', compact('suppliers'));
    }


    public function updatesupplier(Request $request)
    {
        $id = $request->input('id');
        // Find the product by ID
        $supplier = Supplier::findOrFail($id);

        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $district = $request->input('district');
        $address = $request->input('address');
        $description = $request->input('description');
        $image = $request->file('image');
        $cityInput = $request->input('city');

     
        // Update the Subcategory attributes
        $supplier->supplier_name = $name;
        $supplier->email = $email;
        $supplier->phone = $phone;
        $supplier->district = $district;
        $supplier->address = $address;
        $supplier->city = $cityInput;
        $supplier->description = $description;
        // Save the product updates
        $supplier->save();

        // Update the product image if provided
        if ($image) {
                    $file = $request->file('image');
                    $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move('uploads/suppliers', $fileName);
        
                    // Delete the old image if it exists
                    if ($supplier->avatar) {
                        if (file_exists('uploads/suppliers/' . $supplier->avatar)) {
                            unlink('uploads/suppliers/' . $supplier->avatar);
                        }
                    }
        
                    $supplier->avatar = $fileName;
                }
        
                $supplier->save();
        

        // Return a success response
        return response()->json(['message' => 'Customer Updated successfully']);
    }


 
}
