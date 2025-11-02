<?php

namespace App\Http\Controllers\Models;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Size;
use App\Models\Subcategory;
use App\Models\Supplier;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InsertControlller extends Controller
{

    // Product page Model

    //1 Model Category
    public function storeCategory(Request $request)
    {

        $inputval = $request->input('name');
        $inputdesc = $request->input('description');


        // Create a new category
        $category = Category::create([
            'name' => $inputval,
            'description' => $inputdesc,
            'user_id' => Auth::user()->id,
        ]);
        // You can return a response if needed
        return response()->json(['message' => 'Category stored successfully']);
    }

    public function fetchCategories(Request $request)
    {
        // Fetch categories from the database
        $categories = Category::all(); // Adjust this query based on your actual needs

        $categoryOptions = '<option value="">Choose Category</option>';
        foreach ($categories as $category) {
            $categoryOptions .= "<option value='{$category->id}'>{$category->name}</option>";
        }

        // Return categories as JSON response
        return response()->json(['categoryOptions' => $categoryOptions]);
    }


    //2 Model Sub Category

    public function storeSubCategory(Request $request)
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



    public function fetchsubCategory(Request $request)
    {
        // Fetch subCategory from the database
        $subCategory = Subcategory::all(); // Adjust this query based on your actual needs

        $subcategoryOptions = '<option value="">Choose Sub Category</option>';
        foreach ($subCategory as $Subcategory) {
            $subcategoryOptions .= "<option value='{$Subcategory->id}'>{$Subcategory->name}</option>";
        }

        // Return subCategory as JSON response
        return response()->json(['subcategoryOptions' => $subcategoryOptions]);
    }


    //3 Model brand
    public function storebrand(Request $request)
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



    public function fetchBrand(Request $request)
    {
        // Fetch brand from the database
        $brands = Brand::all();

        $brandOptions = '<option value="">Choose Brand</option>';
        foreach ($brands as $brand) {
            $brandOptions .= "<option value='{$brand->id}'>{$brand->name}</option>";
        }

        // Return brand as JSON response
        return response()->json(['brandOptions' => $brandOptions]);
    }



    //3 Model Type
    public function storetype(Request $request)
    {

        $name = $request->input('name');
        $description = $request->input('description');


        // Create a new type
        $type = Type::create([
            'type_name' => $name,
            'description' => $description,
        ]);
        // You can return a response if needed
        return response()->json(['message' => 'Type stored successfully']);
    }


    public function fetchtype(Request $request)
    {
        // Fetch type from the database
        $types = Type::all();

        $typeOptions = '<option value="">Choose Unit</option>';
        foreach ($types as $type) {
            $typeOptions .= "<option value='{$type->id}'>{$type->type_name}</option>";
        }

        // Return type as JSON response
        return response()->json(['typeOptions' => $typeOptions]);
    }


    //3 Model Type
    public function storesize(Request $request)
    {

        $name = $request->input('name');


        // Create a new size
        $size = Size::create([
            'name' => $name,
        ]);
        // You can return a response if needed
        return response()->json(['message' => 'Size stored successfully']);
    }


    public function fetchsize(Request $request)
    {
        // Fetch size from the database
        $sizes = Size::all();

        $sizeOptions = '';
        foreach ($sizes as $size) {
            $sizeOptions .= "<option value='{$size->id}'>{$size->name}</option>";
        }

        // Return size as JSON response
        return response()->json(['SizeOptions' => $sizeOptions]);
    }


    

    // 4 Customer model

    public function storeCustomer(Request $request)
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


    public function checkEmailExistenceCustomer(Request $request)
    {
        // Retrieve the email from the request
        $email = $request->input('email');
   
        // Check if the email exists in the database
        $exists = Customer::where('email', $email)->exists();

        // Return a JSON response indicating whether the email exists
        return response()->json(['exists' => $exists]);
    }



    public function fetchCustomer(Request $request)
    {
        // Fetch Customer from the database
        $Customers = Customer::all();

        $CustomerOptions = '<option value="">Choose Customer</option>';
        foreach ($Customers as $Customer) {
            $CustomerOptions .= "<option value='{$Customer->id}'>{$Customer->customer_name}</option>";
        }

        // Return Customer as JSON response
        return response()->json(['CustomerOptions' => $CustomerOptions]);
    }


    // 4 Supplier model

    public function storeSupplier(Request $request)
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


    public function checkEmailExistence(Request $request)
    {
        // Retrieve the email from the request
        $email = $request->input('email');

        // Check if the email exists in the database
        $exists = Supplier::where('email', $email)->exists();

        // Return a JSON response indicating whether the email exists
        return response()->json(['exists' => $exists]);
    }


    public function fetchSupplier(Request $request)
    {
        // Fetch Supplier from the database
        $Suppliers = Supplier::all();

        $SupplierOptions = '<option value="">Choose Supplier</option>';
        foreach ($Suppliers as $Supplier) {
            $SupplierOptions .= "<option value='{$Supplier->id}'>{$Supplier->supplier_name}</option>";
        }

        // Return Supplier as JSON response
        return response()->json(['SupplierOptions' => $SupplierOptions]);
    }


    //last Model Product

    public function fetchProduct(Request $request)
    {
        // Fetch Product from the database
        $Products = Product::all();

        $ProductOptions = '<option value="">Choose Product</option>';
        foreach ($Products as $Product) {
            $ProductOptions .= "<option value='{$Product->id}'>{$Product->name}</option>";
        }

        // Return Product as JSON response
        return response()->json(['ProductOptions' => $ProductOptions]);
    }

    public function fetchProductsale(Request $request)
    {
        // Fetch Product from the database
        $Products = Product::all();

        $ProductOptions = '<option value="">Choose Product</option>';
        foreach ($Products as $Product) {
            $ProductOptions .= "<option value='{$Product->id}' data-quantity=' $Product->quantity ' data-price=' $Product->price '>{$Product->name}</option>";
        }

        // Return Product as JSON response
        return response()->json(['ProductOptions' => $ProductOptions]);
    }





    public function storeProduct(Request $request)
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



        $Product = new Product([
            'product_type' => $product_type,
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

        return response()->json(['message' => 'Product stored successfully']);
    }
}
