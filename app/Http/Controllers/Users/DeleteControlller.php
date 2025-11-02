<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeleteControlller extends Controller
{

 


    public function distroy(Request $request)
    {
        $id = $request->input('id');
        $user = User::findOrFail($id);
   
        // // // Check associations
        $associations = [
            'customers' => 'Customers',
            'suppliers' => 'Suppliers',
            'order' => 'Orders',
            'salesuser' => 'Sales users',
        ];
    
        foreach ($associations as $relation => $entity) {
            $associationCount = $user->{$relation}()->count();
            if ($associationCount > 0) {
                return response()->json(['error' => "This User is associated with {$entity} and cannot be deleted."], 400);
            }
        }
    
        // Delete associated image file if exists
        if ($user->file) {
            $imagePath = 'uploads/users/' . $user->file;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
    
        // Delete the user
        $user->delete();
    
        // Return success response
        return response()->json(['success' => 'User deleted successfully.']);
    }
    
    

}
