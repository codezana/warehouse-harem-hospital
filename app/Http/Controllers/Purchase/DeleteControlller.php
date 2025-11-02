<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnTotal;
use App\Models\Total_purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeleteControlller extends Controller
{
    // Delete Set Of Purchase

    public function destroy(Request $request)
    {
        // Retrieve the date and receipt from the request
        $date = $request->query('date');
        $receipt = $request->query('reference');

        // Find the purchase records based on date and reference
        $purchases = Purchase::where('date', $date)->where('reference', $receipt)->get();

        // Initialize an array to store the total_ids of purchases
        $purchaseTotalIds = [];

        // Iterate over each purchase record
        foreach ($purchases as $purchase) {
            // Store the total_id of each purchase
            $purchaseTotalIds[] = $purchase->total_id;

            // Retrieve the product associated with the purchase
            $product = $purchase->product;

            // Update the quantity of the product
            $product->quantity -= $purchase->quantity;
            $product->save();

            // Delete the individual purchase record
            $purchase->delete();
        }

        // Delete the corresponding PurchaseTotal records based on the stored total_ids
        Total_purchase::whereIn('id', $purchaseTotalIds)->delete();

        return response()->json(['message' => 'Purchase deleted successfully.']);
    }






}
