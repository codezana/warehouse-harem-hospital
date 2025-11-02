<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleReturn;
use App\Models\SaleReturnOrder;
use App\Models\SalesOrder;
use Illuminate\Http\Request;

class DeleteControlller extends Controller
{


    public function deleteSet(Request $request)
    {
        // Retrieve the date and receipt from the request
        $date = $request->query('date');
        $receipt = $request->query('receipt');

        // Find the Sale records based on date and receipt
        $sales = Sale::where('date', $date)->where('receipt', $receipt)->get();

        // Initialize an array to store the total_ids of Sales
        $saleTotalIds = [];

        // Iterate over each Sale record
        foreach ($sales as $sale) {
            // Store the total_id of each Sale
            $saleTotalIds[] = $sale->sales_order_id;

            // Retrieve the product associated with the sale
            $product = $sale->product;

            // Update the quantity of the product
            $product->quantity += $sale->quantity;
            $product->save();

            // Delete the individual Sale record
            $sale->delete();
        }

        // Delete the corresponding Sale Total records based on the stored total_ids
        SalesOrder::whereIn('id', $saleTotalIds)->delete();

        return response()->json(['message' => 'Sale deleted successfully.']);
    }




    // Delete Set Of Sale Return

    public function destroy(Request $request)
    {
        // Retrieve the date and receipt from the request
        $date = $request->query('date');
        $receipt = $request->query('receipt');

        // Find the Sale Return  records based on date and receipt
        $saleReturn = SaleReturn::where('date', $date)->where('receipt', $receipt)->get();

        // Initialize an array to store the total_ids of Sale Return s
        $saleReturnTotalIds = [];

        // Iterate over each Sale Return  record
        foreach ($saleReturn as $saleReturns) {
            // Store the total_id of each Sale Return 
            $saleReturnTotalIds[] = $saleReturns->sales_order_id;


            // Retrieve the product associated with the sale
            $product = $saleReturns->product;

            // Update the quantity of the product
            $product->quantity -= $saleReturns->quantity;
            $product->save();

            // Delete the individual Sale Returns  record
            $saleReturns->delete();
        }

        // Delete the corresponding Sale ReturnTotal records based on the stored total_ids
        SaleReturnOrder::whereIn('id', $saleReturnTotalIds)->delete();

        return response()->json(['message' => 'Sale Return deleted successfully.']);
    }
}
