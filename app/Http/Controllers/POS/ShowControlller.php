<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShowControlller extends Controller
{

 //Pos page 

 public function view()
 {
     $categories = Category::all();


     // Now $formattedCount will contain the desired format, e.g., '0001', '0011', etc.

     $productCategory = Product::all();

     $distinctCategories = Product::distinct('category_id')->pluck('category_id');


     $purchases = Purchase::join('total_purchase', 'purchase.total_id', '=', 'total_purchase.id')
         ->where('total_purchase.status', 'Completed')
         ->get()
         ->groupBy(function ($purchase) {
             return $purchase->date . '-' . $purchase->reference;
         });

     $purchasesDue = Purchase::join('total_purchase', 'purchase.total_id', '=', 'total_purchase.id')
         ->where('total_purchase.status', 'Inprogress')
         ->get()
         ->groupBy(function ($purchase) {
             return $purchase->date . '-' . $purchase->reference;
         });




     $salesPaid = Sale::join('sales_orders', 'sales.sales_order_id', '=', 'sales_orders.id')
         ->where('sales_orders.status', 'Completed')
         ->get()
         ->groupBy(function ($sales) {
             return $sales->date . '-' . $sales->receipt;
         });
         $salesUnPaid = Sale::join('sales_orders', 'sales.sales_order_id', '=', 'sales_orders.id')
         ->where('sales_orders.status', 'Inprogress')
         ->get()
         ->groupBy(function ($sales) {
             return $sales->date . '-' . $sales->receipt;
         });

     return view('sales.pos', compact('salesUnPaid','salesPaid', 'purchasesDue', 'purchases', 'distinctCategories', 'productCategory', 'categories'));
 }




 public function fetchTransaction()
    {

        $counttransaction = Sale::distinct('receipt')->count();

        // Increment the order count by 1
        $count = $counttransaction + 1;
   
        // Format the count with leading zeros to make it a four-digit number
        $transactionId = str_pad($count, 4, '0', STR_PAD_LEFT);
   
        // Return the transaction ID in JSON format
        return response()->json(['transaction_id' => $transactionId]);
    }

}
