<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class DeleteControlller extends Controller
{
      //Delete Supplier 



      public function deletesupplier(Request $request)
      {
          $id = $request->input('id');
  
          $supplier = Supplier::find($id);
  
          // Check if the category is associated with any product
          $associatedpurchases = $supplier->purchases()->count();
          if ($associatedpurchases > 0) {
              return response()->json(['error' => 'This Supplier is associated with Purchases and cannot be deleted.'], 400);
          }
  
          if ($supplier->avatar) {
              $imagePath = 'uploads/suppliers/' . $supplier->avatar;
              if (file_exists($imagePath)) {
                  unlink($imagePath);
              }
          }
  
          $supplier->delete();
  
          return response()->json(['success' => 'Supplier deleted successfully.']);
      }
    



}
