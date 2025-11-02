<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class ViewControlller extends Controller
{
    public function view()
    {

        $categories = Category::all();

        // Count the number of active orders with distinct request_id
        $activeOrderCount = Order::where('is_active', 1)->distinct('request_id')->count();

        if ($activeOrderCount > 0) {
            // Retrieve the last order number for active orders
            $lastOrder = Order::where('is_active', 1)->distinct('request_id')->latest()->first();

            // Get the last order number
            $lastOrderNumber = $lastOrder->order;

            // Count the distinct request IDs of active orders
            $distinctRequestIdsCount = Order::where('is_active', 1)->distinct('request_id')->count();

            // Increment the last order number
            $newOrderNumber = sprintf('%04d', $lastOrderNumber + 1); // Ensure it's 4 digits with leading zeros
        } else {
            // If no active orders exist, set initial values
            $lastOrderNumber = 0;
            $distinctRequestIdsCount = 0;
            $newOrderNumber = '0001'; // Initial order number
        }


        $orderCount = Order::where('is_active', 1)->distinct('request_id')->count();

        // Increment the order count by 1
        $count = $orderCount + 1;
        
        // Format the count with leading zeros to make it a four-digit number
        $formattedCount = str_pad($count, 4, '0', STR_PAD_LEFT);
        $formattedCount2 = str_pad($count, 2, '0', STR_PAD_LEFT);

        $productCategory = Product::all();


        $distinctCategories = Product::distinct('category_id')->pluck('category_id');
      
 

            return view('sales.request', compact( 'distinctCategories','productCategory', 'categories', 'formattedCount2', 'formattedCount'));
     
      
    }

    // All Sale Requests 
    public function activities()
    {
        // Fetch all active orders
        $orders = Order::where('is_active', 1)->orderByDesc('created_at')->get();

        // Group active orders by request_id
        $groupedOrders = $orders->groupBy('request_id');

        return view('sales.activities', compact('groupedOrders'));
    }





}
