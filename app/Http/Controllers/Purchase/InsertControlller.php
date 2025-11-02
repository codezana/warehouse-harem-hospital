<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnTotal;
use App\Models\Supplier;
use App\Models\Total_purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InsertControlller extends Controller
{
    //Insert Purchase


    public function home()
    {

        $product = Product::all();
        $supplier = Supplier::all();
        return view('purchase.addpurchase', compact('product', 'supplier'));
    }

    public function storeTableData(Request $request)
    {
        $tableData = $request->input('tableData');

        $discountTotal = $request->input('discountTotal');
        $shippingTotal = $request->input('shippingTotal');
        $grandTotal = $request->input('grandTotal');
        $description = $request->input('description');
        $status = $request->input('status');
        $paid = $request->input('paid');
        $paid_dinar = $request->input('paid_dinar');
        $grand_dinar = $request->input('grand_dinar');
        $dolar_price = $request->input('dolar');


        $discount = $grandTotal / $discountTotal;
        // Store these totals into the total_purchase table
        $totalPurchase = Total_purchase::create([
            'discount_total' => $discountTotal,
            'shipping_total' => $shippingTotal,
            'grand_total' => $grandTotal,
            'paid' => $paid,
            'grand_dinar' => $grand_dinar,
            'paid_dinar' => $paid_dinar,
            'description' => $description,
            'status' => $status,
            'dolar_price'=>$dolar_price,
        ]);


        if (is_array($tableData) && count($tableData) > 0) {
            foreach ($tableData as $rowData) {
                $product = Product::firstOrCreate(['id' => $rowData['product_name']]);

                $supplier = Supplier::firstOrCreate(['id' => $rowData['supplier_name']]);

                $purchaseData = [
                    'total_id' => $totalPurchase->id,
                    'product_id' => $product->id,
                    'supplier_id' => $supplier->id,
                    'quantity' => $rowData['quantity'],
                    'purchase_price' => $rowData['purchase_price'],
                    'sale_price' => $rowData['sale_price'],
                    'reference' => $rowData['reference'],
                    'date' => $rowData['date'],
                    'expire_date' => $rowData['expire_date'],
                    'total_cost' => $rowData['total_cost'],
                    'biller_id'=>Auth::user()->id,
                ];

                // Create the Purchase record
                $purchase = Purchase::create($purchaseData);

                $product = Product::where('id', $product->id)->first(); // Retrieve the product instance
                $sub = $product->quantity;
                $sub += $rowData['quantity'];

                // Update the quantity attribute of the product instance
                $product->quantity = $sub;

                // Save the updated product instance
                $product->save();


                Product::where('id', $product->id)->update(['price' => $rowData['purchase_price']]);
                Product::where('id', $product->id)->update(['sale' => $rowData['sale_price']]);
            }

            return response()->json(['message' => 'Data stored successfully']);
        } else {
            return response()->json(['message' => 'No data received or invalid data format'], 400);
        }
    }


   
}
