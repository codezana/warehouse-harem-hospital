<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Box;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Purchase;
use App\Models\Role;
use App\Models\Size;
use App\Models\Subcategory;
use App\Models\Type;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class updateController extends Controller
{



    //update Product

    public function editproduct(Request $request)
    {
        $id = $request->query('id');
        $product = Product::find($id);
        $purchases = Purchase::all()->where('product_id', $id)->first();


        $categories = Category::all();
        $types = Type::all();
        $subcategories = Subcategory::all();
        $brands = Brand::all();

        $sizes = ProductSize::where('product_id', $product->id)->get();

        return view('product.updateproduct', compact('sizes', 'purchases', 'product', 'types', 'categories', 'subcategories', 'brands'));
    }




    public function updateproduct(Request $request)
    {
        $id = $request->input('id');
        // Find the product by ID
        $product = Product::find($id);

        $product_type = $request->input('product_type');
        $name = $request->input('name');
        $category = $request->input('category');
        $subcategory = $request->input('subcategory');
        $brand = $request->input('brand');
        $type = $request->input('type');
        $quantity = $request->input('qunatity');

        $min_qty = $request->input('minimum_quantitys');
        $barcode = $request->input('barcode');
        $price = $request->input('price');
        $sale = $request->input('sale');
        $description = $request->input('description');
        $expireDates = $request->input('expireDate');
        $sizes = json_decode($request->input('size'), true);

        $image = $request->file('image');

        // Update the product attributes
        $product->product_type = $product_type;
        $product->name = $name;
        $product->category_id = $category;
        $product->subcategory_id = $subcategory;
        $product->brand_id = $brand;
        $product->type_id = $type;
        $product->quantity = $quantity;
        $product->minimum_qty = $min_qty;
        $product->barcode = $barcode;
        $product->price = $price;
        $product->sale = $sale;
        $product->description = $description;
        $product->user_id = auth()->user()->id;

        // Save the product updates
        $product->save();

        // Update the product image if provided
        if ($image) {
            $file = $request->file('image');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/product/products', $fileName);

            // Delete the old image if it exists
            if ($product->image) {
                if (file_exists('uploads/product/products/' . $product->image)) {
                    unlink('uploads/product/products/' . $product->image);
                }
            }

            $product->image = $fileName;
            $product->save();
        }

        $purchases = Purchase::where('product_id', $id)->first();
        if ($purchases) {
            $purchases->expire_date = $expireDates;
            $purchases->save();
        }

        // Update the product's associated sizes
        if ($sizes !== null) {
            // Delete existing product sizes
            $product->productSizes()->delete();

            // Attach the new product sizes
            foreach ($sizes as $sizeId) {
                $product->productSizes()->create(['size_id' => $sizeId]);
            }
        }



        // Return a success response
        return response()->json(['message' => 'Product Updated successfully']);
    }





    //Category Page

    public function editcategory(Request $request)
    {
        $id = $request->query('id');
        $category = Category::find($id);

        return view('product.editcategory', compact('category'));
    }



    public function updatecategory(Request $request)
    {

        $id = $request->input('id');

        $category = Category::find($id);

        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->user_id = Auth::id();



        $category->save();

        return response()->json(['message' => 'Category Updated successfully']);
    }


    //Subcategory Page
    public function editsubcategory(Request $request)
    {
        $parentCategories = Category::all();
        $id = $request->query('id');
        $subcategory = Subcategory::find($id);

        return view('product.editsubcategory', compact('subcategory', 'parentCategories'));
    }



    public function updatesubcategory(Request $request)
    {
        $id = $request->input('id');
        // Find the product by ID
        $subcategory = Subcategory::find($id);

        $categorySelect = $request->input('categorySelect');
        $name = $request->input('name');
        $description = $request->input('description');
        $image = $request->file('image');


        // Update the Subcategory attributes
        $subcategory->name = $name;
        $subcategory->description = $description;
        $subcategory->parent_category_id = $categorySelect;
        $subcategory->user_id = Auth::id();
        // Save the product updates
        $subcategory->save();

        // Update the product image if provided
        if ($image) {
            $file = $request->file('image');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/product/subcategory', $fileName);

            // Delete the old image if it exists
            if ($subcategory->subcategory_image) {
                if (file_exists('uploads/product/subcategory/' . $subcategory->subcategory_image)) {
                    unlink('uploads/product/subcategory/' . $subcategory->subcategory_image);
                }
            }

            $subcategory->subcategory_image = $fileName;
        }

        $subcategory->save();


        // Return a success response
        return response()->json(['message' => 'SubCategory Updated successfully']);
    }


    //Update Brand 

    public function editBrand(Request $request)
    {
        $id = $request->query('id');
        $brand = Brand::find($id);

        return view('product.editbrand', compact('brand'));
    }

    public function updateBrand(Request $request)
    {
        $id = $request->input('id');

        $brand = Brand::find($id);

        $name = $request->input('name');
        $description = $request->input('description');
        $image = $request->file('image');


        // Update the Subcategory attributes
        $brand->name = $name;
        $brand->description = $description;
        $brand->user_id = Auth::id();
        // Save the product updates
        $brand->save();

        // Update the product image if provided
        if ($image) {
            $file = $request->file('image');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/product/brands', $fileName);

            // Delete the old image if it exists
            if ($brand->image) {
                if (file_exists('uploads/product/brands/' . $brand->image)) {
                    unlink('uploads/product/brands/' . $brand->image);
                }
            }

            $brand->image = $fileName;
        }

        $brand->save();


        // Return a success response
        return response()->json(['message' => 'Brand Updated successfully']);
    }



    // Unit Upate


    public function updateUnit(Request $request)
    {


        $id = $request->input('id');
        $name = $request->input('name');
        $description = $request->input('description');

        $type = Type::findOrFail($id);
        $type->type_name = $name;
        $type->description = $description;
        $type->save();
        return response()->json(['message' => 'Unit Updated successfully']);
    }



      // Size Update

      public function updatesize(Request $request)
      {
  
  
          $id = $request->input('id');
          $name = $request->input('name');
  
          $size = Size::findOrFail($id);
          $size->name = $name;
          $size->save();
          return response()->json(['message' => 'Size Updated successfully']);
      }
}
