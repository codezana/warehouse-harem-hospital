<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Subcategory;
use App\Models\Supplier;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InsertControlller extends Controller
{
    //Home 

    public function productpage()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $brands = Brand::all();
        $suppliers = Supplier::all();
        $types = Type::all();
        $parentCategories = Category::all();

        return view('product.addproduct', compact(
            'parentCategories',
            'categories',
            'subcategories',
            'brands',
            'suppliers',
            'types'
        ));
    }


    public function store(Request $request)
    {
        $product_type = $request->input('product_type');
        $name = $request->input('name');
        $category = $request->input('category');

        $subcategory = $request->input('subcategory');
        $brand = $request->input('brand');
        $type = $request->input('type');

        $quantity = $request->input('quantity');
        $minimum_quantity = $request->input('minimum_quantity');
        $barcode = $request->input('barcode');

        $price = $request->input('price');
        $sale = $request->input('sale');
        $productDescription = $request->input('productDescription');

        $image = $request->file('image');

        $sizes = json_decode($request->input('size'), true);


        $Product = new Product([
            'type' => $product_type,
            'name' => $name,
            'category_id' => $category,
            'subcategory_id' => $subcategory,
            'brand_id' => $brand,
            'type_id' => $type,
            'quantity' => $quantity,
            'minimum_qty' => $minimum_quantity,
            'barcode' => $barcode,
            'price' => $price,
            'sale' => $sale,
            'description' => $productDescription,
            'user_id' => auth()->user()->id,
        ]);

        // Generate the category code
        $productCount = Product::count();
        $Product->sku_code = 'PT' . str_pad($productCount, 3, '0', STR_PAD_LEFT);

        if ($image) {
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move('uploads/product/products', $fileName);
            $Product->image = $fileName;
        }

        $Product->save();

        // Store sizes (assuming you have a separate table for sizes)
        if ($sizes !== null) {
            foreach ($sizes as $size) {
                // Create a new ProductSize instance for each size
                $productSize = new ProductSize([
                    'size_id' => $size,
                    'product_id' => $Product->id, // Assuming you have a product_id column to associate with the product
                ]);
                // Save the product size
                $productSize->save();
            }
        }

        return response()->json(['message' => 'Product stored successfully']);
    }




    // Brand page 


    public function view()
    {
        return view('product.addbrand');
    }

    public function create(Request $request)
    {
        $name = $request->input('name');
        $description = $request->input('description');
        $image = $request->file('image');

        // Create a new brand
        $brand = Brand::create([
            'name' => $name,
            'description' => $description,
            'user_id' => auth()->user()->id,
        ]);

        if ($image) {
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move('uploads/product/brands', $fileName); // Store the file
            $brand->image = $fileName;
        }

        // Save the changes to the brand model
        $brand->save();

        // You can return a response if needed
        return response()->json(['message' => 'brand stored successfully']);
    }


    // Category Page 

    public function Viewpage()
    {
        return view('product.addcategory');
    }



    public function storePage(Request $request)
    {


        $inputval = $request->input('name');
        $inputdesc = $request->input('description');


        // Create a new category
        $category = Category::create([
            'name' => $inputval,
            'description' => $inputdesc,
            'user_id' => auth()->user()->id,
        ]);
        // You can return a response if needed
        return response()->json(['message' => 'Category stored successfully']);
    }


    //Sub Category Page 

    public function Viewcreate()
    {
        $parentCategories = Category::all();


        return view('product.subaddcategory', compact('parentCategories'));
    }

    public function storeView(Request $request)
    {

        $category_id = $request->input('categorySelect');
        $name = $request->input('name');
        $description = $request->input('description');
        $image = $request->file('image');

        // Create the subcategory
        $subcategory = new Subcategory();
        $subcategory->name = $name;
        $subcategory->description = $description;
        $subcategory->parent_category_id = $category_id;
        $subcategory->user_id = auth()->user()->id;

        // Upload and store subcategory image if provided
        if ($image) {
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move('uploads/product/subcategory', $fileName); // Store the file
            $subcategory->subcategory_image = $fileName;
        }

        $subcategory->save();
        // You can return a response if needed
        return response()->json(['message' => 'Sub Category stored successfully']);
    }
}
