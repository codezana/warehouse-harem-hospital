<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\SaleReturn;
use App\Models\SaleReturnOrder;
use App\Models\SalesOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UpdateControlller extends Controller
{

    // Edit Sale 

    public function editsale(Request $request)
    {
        $date = $request->query('date');
        $receipt = $request->query('receipt');

        // Retrieve the sales data filtered by date and receipt
        $sales = Sale::where('date', $date)
            ->where('receipt', $receipt)
            ->get();


        $shipping = $sales->first()->salesOrder->shipping;
        $total_dinar = $sales->first()->salesOrder->total_dinar;
        $total_dollar = $sales->first()->salesOrder->total_dollar;
        $status = $sales->first()->salesOrder->status;
        $dolar = $sales->first()->salesOrder->dolar_price;

        $salesOrderId = $sales->first()->salesOrder->id;

        return view('sales.editsales', compact('dolar','date', 'receipt', 'sales', 'shipping', 'total_dinar', 'total_dollar', 'status', 'salesOrderId'));
    }



    public function update(Request $request)
    {

        // Retrieve the request data
        $tableData = $request->input('tableData');


        $grandTotalDinar = $request->input('grandTotalDinar');
        $grandTotalDollar = $request->input('grandTotalDollar');
        $shipping = $request->input('shippingValue');
        $status = $request->input('selectedStatus');
        $dolar = $request->input('dolar');



        $salesOrderIds = $request->input('salesOrderIds');

        $date_sale = $request->input('date_sale');
        $receipt_sale = $request->input('receipt_sale');


        // Convert $salesOrderIds to an array if it's not already
        if (!is_array($salesOrderIds)) {
            $salesOrderIds = [$salesOrderIds];
        }

        // Find the existing sales orders based on the provided IDs
        $salesOrders = SalesOrder::whereIn('id', $salesOrderIds)->get();

        // Check if sales orders exist
        if ($salesOrders->isEmpty()) {
            return response()->json(['error' => 'Sales orders not found'], 404);
        }

        // Update each sales order
        foreach ($salesOrders as $salesOrder) {
            $salesOrder->update([
                'shipping' => $shipping,
                'status' => $status,
                'dolar_price'=>$dolar,
                'total_dinar' => $grandTotalDinar,
                'total_dollar' => $grandTotalDollar,
            ]);
        }

        // Process each row of tableData
        foreach ($tableData as $rowData) {
            $product_id = $rowData['product_id'];

            $sale = Sale::where('product_id', $product_id)
                ->where('receipt', $receipt_sale)
                ->first();

            if ($sale) {
                // Get the difference in quantity
                $oldQuantity = $sale->quantity;
                $newQuantity = $rowData['quantity'];
                $quantityDifference = $newQuantity - $oldQuantity;

                // Update the existing sale record
                $sale->update([
                    'quantity' => $rowData['quantity'],
                    'subtotal' => $rowData['subtotal'],
                    'receipt' => $rowData['receipt'],
                    'biller_id' => Auth::user()->id,
                ]);


                // Update product quantity
                $product = Product::find($product_id);
                if ($product) {
                    $product->quantity -= $quantityDifference;
                    $product->save();
                } else {
                    // Handle the case where the product is not found
                    Log::warning('Product not found for product_id: ' . $product_id);
                }
            }
        }

        return response()->json(['message' => 'Data updated successfully']);
    }


    // Edit Sale return 

    public function editreturn(Request $request)
    {
        $date = $request->query('date');
        $receipt = $request->query('receipt');

        // Retrieve the sales data filtered by date and receipt
        $sales = SaleReturn::where('date', $date)
            ->where('receipt', $receipt)
            ->get();

        $salesId = $sales->first()->id;
        $shipping = $sales->first()->salesOrder->shipping;
        $dolar = $sales->first()->salesOrder->dolar_price;
        $total_dollar = $sales->first()->salesOrder->total_dollar;
        $status = $sales->first()->salesOrder->status;


        $salesOrderId = $sales->first()->salesOrder->id;

        return view('sales.editsalesreturns', compact('date', 'receipt', 'salesId', 'sales', 'shipping', 'dolar', 'total_dollar', 'status', 'salesOrderId'));
    }






    public function updatereturn(Request $request)
    {
        // Retrieve the request data
        $tableData = $request->input('tableData');

        $grandTotalDinar = $request->input('grandTotalDinar');
        $grandTotalDollar = $request->input('grandTotalDollar');
        $shipping = $request->input('shippingValue');
        $status = $request->input('selectedStatus');
        $dolar = $request->input('dolar');

        $salesReturnOrderIds = $request->input('salesReturnOrderIds');

        // Retrieve the date and receipt from the request
        $date_sale = $request->input('date_sale');
        $receipt_sale = $request->input('receipt_sale');

        // Log::info('Date: ' . $date_sale);
        // Log::info('Receipt: ' . $receipt_sale);



        // Convert $salesReturnOrderIds to an array if it's not already
        if (!is_array($salesReturnOrderIds)) {
            $salesReturnOrderIds = [$salesReturnOrderIds];
        }

        // Find the existing sales return orders based on the provided IDs
        $salesOrders = SaleReturnOrder::whereIn('id', $salesReturnOrderIds)->get();

        // Check if all provided sales return order IDs were found
        $foundIds = $salesOrders->pluck('id')->toArray();
        $missingIds = array_diff($salesReturnOrderIds, $foundIds);
        if (!empty($missingIds)) {
            return response()->json(['error' => 'Sales return orders not found for IDs: ' . implode(', ', $missingIds)], 404);
        }

        // Update each sales return order
        foreach ($salesOrders as $salesOrder) {
            $salesOrder->update([
                'shipping' => $shipping,
                'status' => $status,
                'dolar_price'=>$dolar,
                'total_dinar' => $grandTotalDinar,
                'total_dollar' => $grandTotalDollar,
            ]);
        }

        // Process each row of tableData
        foreach ($tableData as $rowData) {
            $product_id = $rowData['product_id'];
            $quantity = $rowData['quantity'];
            $subtotal = $rowData['subtotal'];
            $receipts = $rowData['receipt'];

            // Retrieve the sale record based on product_id and receipt
            $sale = SaleReturn::where('product_id', $product_id)
                ->where('receipt', $receipt_sale)
                ->first();

            // Check if sale record exists
            if ($sale) {
                // Get the difference in quantity
                $oldQuantity = $sale->quantity;
                $newQuantity = $rowData['quantity'];
                $quantityDifference = $newQuantity - $oldQuantity;

                // Update the sale record
                $sale->update([
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                    'receipt' => $receipts,
                    'biller_id' => Auth::user()->id,
                ]);
                // Update product quantity
                $product = Product::find($product_id);
                if ($product) {
                    $product->quantity += $quantityDifference;
                    $product->save();
                } else {
                    // Handle the case where the product is not found
                    Log::warning('Product not found for product_id: ' . $product_id);
                }
            } else {
                // Sale record not found, you may handle this case accordingly
                Log::warning('Sale record not found for product_id: ' . $product_id . ' and receipt: ' . $receipt_sale);
            }
        }



        return response()->json(['message' => 'Data updated successfully']);
    }





    // refresh Code :
    public function getOrderCount()
    {
        $orderCount = Order::where('is_active', 1)->distinct('request_id')->count();
        return response()->json(['orderCount' => $orderCount]);
    }

       //2

       public function getexpireCount()
       {
                    // Retrieve purchases with expiration dates
                    $expiringPurchases = Purchase::whereNotNull('expire_date')->get();
                    // Initialize a variable to count the number of expiring products
                    $expireCount = 0;
                    
                    $user = Auth::user();
                    $role = $user->roles()->first();
                    
                    if ($role && ($role->name === 'admin' || $role->name === 'cashier')) {
                        foreach ($expiringPurchases as $purchase) {
                            // Retrieve the product associated with the purchase
                            $product = Product::find($purchase->product_id);
                            // Check if the product exists and has a quantity greater than zero
                            if ($product && $product->quantity > 0) {
                                // Convert the expire_date to a Carbon instance
                                $expireDate = Carbon::createFromFormat('Y-m-d', $purchase->expire_date);
                                // Calculate the difference in days from now
                                $remainingDays = $expireDate->diffInDays(\Carbon\Carbon::now());
                                // Check if the remaining days are within the range of 0 to 30 days
                                if ($remainingDays >= 0 && $remainingDays <= 30) {
                                    // Increment the count of expiring products
                                    $expireCount++;
                                }
                            }
                        }
                    }
           return response()->json(['expireCount' => $expireCount]);
       }
}
