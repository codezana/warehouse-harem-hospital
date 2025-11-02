<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class DeleteControlller extends Controller
{
      //Delete Customer 


    public function deletecustomer(Request $request)
    {
        $id = $request->input('id');

        $customer = Customer::findOrFail($id);

        // Check if the category is associated with any product
        $associatedSales = $customer->sales()->count();
        if ($associatedSales > 0) {
            // Category is associated with products, return error response
            return response()->json(['error' => 'This Customer is associated with Sales and cannot be deleted.'], 400);
        }

        if ($customer->avatar) {
            $imagePath = 'uploads/customers/' . $customer->avatar;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // No associated products, proceed with deletion
        $customer->delete();

        return response()->json(['success' => 'Customer deleted successfully.']);
    }
  
}
