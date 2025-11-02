<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UpdateControlller extends Controller
{
      // Update Order  Record
      public function updateOrderRecord(Request $request)
      {
          try {
              // Retrieve the request_id from the request
              $requestId = $request->input('request_id');
      
              // Update the is_active column to 0 for all orders with the specified request_id
              Order::where('request_id', $requestId)->update(['is_active' => 0]);
      
              $order = Order::where('request_id', $requestId)->first();

              // Retrieve the product related to the order
              $product = Product::find($order->product_id);
      
              // Update the product's quantity based on the quantity of the order
              $product->quantity += $order->qty;
              $product->save();

              
              return response()->json(['message' => 'Order records updated successfully']);
          } catch (\Exception $e) {
              // Log the error
              Log::error('Failed to update order records: ' . $e->getMessage());
      
              // Handle any errors
              return response()->json(['error' => 'Failed to update order records'], 500);
          }
      }
  
}
