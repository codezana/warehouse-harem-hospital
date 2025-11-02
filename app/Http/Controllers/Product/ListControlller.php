<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Size;
use App\Models\Subcategory;
use App\Models\Type;
use Illuminate\Http\Request;

class ListControlller extends Controller
{

    // type list Page 
    public function typelist()
    {
        $types = Type::all();
        return view('product.unitlist', compact('types'));
    }

 // size list Page 
 public function sizelist()
 {
     $sizes = Size::all();
     return view('product.productsize', compact('sizes'));
 }

    //Brand List
    public function Viewlist()
    {
        $brand = Brand::all();
        return view('product.brandlist', compact('brand'));
    }

    //Category List
    public function categorylist()
    {
        $category = Category::all();
        return view('product.categorylist', compact('category'));
    }

    //Product List

    public function list()
    {
        $products = Product::all();
        return view('product.productlist', compact('products'));
    }



    // Details Product
    public function product_details(Request $request)
    {
        $id = $request->query('id');
        $product = Product::find($id);

        return view('product.product-details', compact('product'));
    }


    // Sub Category list
    public function subcategorylist()
    {
        $subcategorys = Subcategory::with('parentCategory')->get();

        return view('product.subcategorylist', compact('subcategorys'));
    }
}
