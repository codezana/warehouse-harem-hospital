<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Sale;
use App\Models\SalesOrder;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InsertControlller extends Controller
{
    public function submitOrders(Request $request)
    {
        // Retrieve the order data from the request
        $orderData = $request->input('orderData');

        // Check if the order data is not empty
        if (empty($orderData)) {
            throw new \Exception('No order data found.');
        }

        // Generate a new request_id for the batch of orders
        $requestId = Order::max('request_id') + 1;


        // Generate order and receipt numbers for the batch
        $orderNumber = str_pad($requestId, 4, '0', STR_PAD_LEFT);
        $receiptNumber = 'SR' . str_pad($requestId, 3, '0', STR_PAD_LEFT);

        // Iterate over each item in the order data
        foreach ($orderData as $item) {
            // Extract product ID, quantity, and size name from the item
            $productId = $item['product_id'];
            $quantity = $item['qty'];
            $sizeName = $item['size'];

            // Find the product by its ID
            $product = Product::where('name', $productId)->firstOrFail();


            $size = Size::where('name', $sizeName)->firstOrFail();


            // Now you can use $product and $productSize in your logic

            // Create the order with the same request_id, order number, and receipt number
            $order = Order::create([
                'product_id' => $product->id,
                'qty' => $quantity,
                'size_id' => $size->id,
                'customer_id' => Auth::id(),
                'request_id' => $requestId,
                'order' => $orderNumber,
                'receipt' => $receiptNumber,
            ]);
            $product->quantity -= $quantity;
            $product->save();
        }

        // Return a success response with a message
        return response()->json([
            'message' => 'Orders submitted successfully',
        ]);
    }






    // Store request in clciked :

    public function view(Request $request)
    {
        $requestId = $request->input('request_id');

        // Retrieve orders for the specified request_id
        $orders = Order::where('is_active', 1)->where('request_id', $requestId)->orderByDesc('created_at')->get();

        // You can then pass $orders to your view and handle it as required
        return view('sales.salesrequest', compact('orders', 'requestId'));
    }



    //Store Requests

    public function storeRequests(Request $request)
    {
        $tableData = $request->input('tableData');
        $grandTotalDinar = $request->input('grandTotalDinar');
        $grandTotalDollar = $request->input('grandTotalDollar');

        $shipping = $request->input('shipping');
        $status = $request->input('status');
        $dolar_price = $request->input('dolar');




        // Create a new SalesOrder
        $salesOrder = SalesOrder::create([
            'shipping' => $shipping,
            'status' => $status,
            'dolar_price' => $dolar_price,

            'total_dinar' => $grandTotalDinar,
            'total_dollar' => $grandTotalDollar,

        ]);


        foreach ($tableData as $rowData) {
            // Now $index is defined as the loop index

            $customerId = $rowData['customer_id'];

            $sizeName = $rowData['size'];

    
            $size = Size::where('name', $sizeName)->firstOrFail();

            $saleData = [
                'product_id' => $rowData['product_id'],
                'size_id'=>$size->id,
                'quantity' => $rowData['quantity'],
                'price' => $rowData['price'],
                'subtotal' => $rowData['subtotal'],
                'receipt' => $rowData['receipt'],
                'date' => $rowData['date'],
                'biller_id' => Auth::user()->id,
                'sales_order_id' => $salesOrder->id, // Associate the Sale with the SalesOrder
                'user_id' => $customerId, // Set user_id from customer_id

            ];

            $sale = Sale::create($saleData);


            $productName = $rowData['product_id'];

            $product = Product::where('id', $productName)->first();
            $quantity = $rowData['quantity'];
            $product->quantity -= $quantity;
            $product->save();
        }
        // Update the is_active column to 0 for the corresponding request_ids
        $requestIds = collect($tableData)->pluck('request_id')->unique();
        Order::whereIn('request_id', $requestIds)->update(['is_active' => 0]);

        return response()->json(['message' => 'Data stored successfully']);
    }
}
