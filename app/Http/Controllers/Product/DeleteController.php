<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Box;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Size;
use App\Models\Subcategory;
use App\Models\Type;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeleteController extends Controller
{


    public function deletesubcategory(Request $request)
    {
        $id = $request->input('id');

        $subcategory = Subcategory::findOrFail($id);

        // Check if the category is associated with any product
        $associatedProducts = $subcategory->products()->count();
        if ($associatedProducts > 0) {
            // Category is associated with products, return error response
            return response()->json(['error' => 'This Subcategory is associated with products and cannot be deleted.'], 400);
        }

        if ($subcategory->subcategory_image) {
            $imagePath = 'uploads/product/subcategory/' . $subcategory->subcategory_image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // No associated products, proceed with deletion
        $subcategory->delete();

        return response()->json(['message' => 'SubCategory deleted successfully.']);
    }

    //Delete Product Page 
    public function delete(Request $request)
    {
        $productId = $request->input('id');

        // Find the product by ID
        $product = Product::findOrFail($productId);

          $associations = [
            'sales' => 'sales',
            'purchase' => 'purchase',
            'order' => 'Orders',
            'invoice' => 'invoice',
        ];
    
        foreach ($associations as $relation => $entity) {
            $associationCount = $product->{$relation}()->count();
            if ($associationCount > 0) {
                return response()->json(['error' => "This Product is associated with {$entity} and cannot be deleted."], 400);
            }
        }
        $product->productSizes()->delete();

        // Delete the product
        $product->delete();

        // Optionally, you can return a response or redirect back to the previous page
        return response()->json(['message' => 'Product deleted successfully']);
    }
    //Delete category Page 
    public function deletecategory(Request $request)
    {
        $id = $request->input('id');

        $category = Category::findOrFail($id);

        // Check if the category is associated with any product
        $associatedProducts = $category->products()->count();
        if ($associatedProducts > 0) {
            // Category is associated with products, return error response
            return response()->json(['error' => 'This category is associated with products and cannot be deleted.'], 400);
        }

        // No associated products, proceed with deletion
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully.']);
    }





    // Delete Brand

    public function deleteBrand(Request $request)
    {
        $id = $request->input('id');

        $Brand = Brand::findOrFail($id);

        // Check if the category is associated with any product
        $associatedProducts = $Brand->products()->count();
        if ($associatedProducts > 0) {
            // Category is associated with products, return error response
            return response()->json(['error' => 'This Brand is associated with products and cannot be deleted.'], 400);
        }

        if ($Brand->image) {
            $imagePath = 'uploads/product/brands/' . $Brand->image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // No associated products, proceed with deletion
        $Brand->delete();

        return response()->json(['message' => 'Brand deleted successfully.']);
    }


    // Delete the Unit



    public function deleteUnit(Request $request)
    {
        $id = $request->input('id');

        // Find the unit by ID
        $unit = Type::findOrFail($id);
        $associatedProducts = $unit->products()->count();
        if ($associatedProducts > 0) {
            return response()->json(['error' => 'This Unit is associated with products and cannot be deleted.'], 400);
        }

 
        $unit->delete();

        return response()->json(['message' => 'Unit deleted successfully.']);
    }

  


    public function deletesize(Request $request)
    {
        $id = $request->input('id');

        // Find the size by ID
        $size = Size::findOrFail($id);
        $associatedProducts = $size->productSizes()->count();
        if ($associatedProducts > 0) {
            return response()->json(['error' => 'This Size is associated with products and cannot be deleted.'], 400);
        }

 
        $size->delete();

        return response()->json(['message' => 'Size deleted successfully.']);
    }



}
