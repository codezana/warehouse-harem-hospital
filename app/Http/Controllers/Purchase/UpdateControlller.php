<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnTotal;
use App\Models\Total_purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UpdateControlller extends Controller
{


      // Edit Purchase 

      public function edit(Request $request)
      {
          $date = $request->query('date');
          $receipt = $request->query('reference');
   
          // Retrieve the Purchase data filtered by date and reference
          $purchases = Purchase::where('date', $date)
              ->where('reference', $receipt)
              ->get();
   
   
          $shipping = $purchases->first()->totalPurchase->shipping_total;
          $grandTotal = $purchases->first()->totalPurchase->grand_total;
          $grand_dinar = $purchases->first()->totalPurchase->grand_dinar;
          $status = $purchases->first()->totalPurchase->status;
          $paid = $purchases->first()->totalPurchase->paid;
          $paid_dinar = $purchases->first()->totalPurchase->paid_dinar;
          $purchasesOrderId = $purchases->first()->totalPurchase->id;
          $dolar = $purchases->first()->totalPurchase->dolar_price;

   
          return view('purchase.editpurchase', compact('dolar','date', 'receipt','paid','paid_dinar', 'purchases', 'shipping', 'grandTotal', 'grand_dinar', 'status', 'purchasesOrderId'));
      }


      public function update(Request $request)
      {
  
          // Retrieve the request data
          $tableData = $request->input('tableData');
  
  
          $grandTotalDinar = $request->input('grand_dinar');
          $grandTotalDollar = $request->input('grandTotal');
          $shipping = $request->input('shippingValue');


          $status = $request->input('selectedStatus');

          $paid = $request->input('paid');
          $paid_dinar = $request->input('paid_dinar');
          $dolar_price = $request->input('dolar');

  
  
          $purchasesOrderId = $request->input('purchasesOrderId');
  
          $date_sale = $request->input('date_sale');
          $receipt_sale = $request->input('receipt_sale');
  
  
          // Convert $salesOrderIds to an array if it's not already
          if (!is_array($purchasesOrderId)) {
              $purchasesOrderId = [$purchasesOrderId];
          }
  
          // Find the existing sales orders based on the provided IDs
          $purchasetotal = Total_purchase::whereIn('id', $purchasesOrderId)->get();
  
          // Check if sales orders exist
          if ($purchasetotal->isEmpty()) {
              return response()->json(['error' => 'Total Purchase not found'], 404);
          }
          foreach ($purchasetotal as $purchasesTotal) {

                $purchasesTotal->update([
                    'shipping_total' => $shipping,
                    'status' => $status,
                    'grand_dinar' => $grandTotalDinar,
                    'grand_total' => $grandTotalDollar,
                    'paid' => $paid,
                    'paid_dinar' => $paid_dinar,
                    'dolar_price'=>$dolar_price,
                ]);
        
        
        }
        
          // Process each row of tableData
          foreach ($tableData as $rowData) {
              $product_id = $rowData['product_id'];
  
              $purchase = Purchase::where('product_id', $product_id)
                  ->where('reference', $receipt_sale)
                  ->first();
  
              if ($purchase) {
                  // Get the difference in quantity
                  $oldQuantity = $purchase->quantity;
                  $newQuantity = $rowData['quantity'];
                  $quantityDifference = $newQuantity - $oldQuantity;
  
                  // Update the existing purchase record
                  $purchase->update([
                      'quantity' => $rowData['quantity'],
                      'total_cost' => $rowData['total_cost'],
                      'reference' => $rowData['reference'],
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
              }
          }
  
          return response()->json(['message' => 'Data updated successfully']);
      }
  







}
