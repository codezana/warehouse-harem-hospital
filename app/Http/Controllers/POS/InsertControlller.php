<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SalesOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InsertControlller extends Controller
{
    public function storeOrderpos(Request $request)
    {
        $totalDanger = str_replace(['$', ' '], '', $request->input('totalDanger')); 

        // Convert to decimal
        $totalDanger = (float) $totalDanger;
        $orderInvoice = json_decode($request->input('orderInvoice'), true);

        $customer = $request->input('customerSelect');
        // Log the request data for debugging
        // Log::debug('Order data received:', [
        //     'orderInvoice' => $orderInvoice,
        //     'totalDanger' => $totalDanger,
        //     'Customer ' => $customer,
        // ]);
        
        $Invoicenumber = $request->input('Invoicenumber');
        $date = $request->input('date');


        $invoice=[
            'invoice_number'=>$Invoicenumber,
            'customer_id'=>$customer,
            'invoice_date'=>$date,
            'total_amount'=>$totalDanger,
        ];

       $invoiceId= Invoice::create($invoice);

        $salesOrder = SalesOrder::create([
            'total_dollar' => $totalDanger,
        ]);

        $receiptIDs = Sale::distinct('receipt')->pluck('receipt')->toArray();
        $receiptIDCount = count($receiptIDs);
        $receiptNumber = 'SR' . str_pad($receiptIDCount, 3, '0', STR_PAD_LEFT);


        // Example:
        foreach ($orderInvoice as $item) {
            $productName = $item['name'];
            $product = Product::where('name', $productName)->first();
            $id = $product->id;


            $invoiceItem=[
                'invoice_id'=>$invoiceId->id,
                'product_id'=> $id,
                'quantity'=>$item['quantity'],
                'price_per_unit'=>$item['price'],
                'total_amount'=>$item['price']*$item['quantity'],
            ];
            InvoiceItem::create($invoiceItem);

            $subTotal = $item['price']*$item['quantity'];
            $saleData = [
                'product_id' => $id,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'receipt' => $receiptNumber,
                'subtotal' => $subTotal,
                'date' => Carbon::now(),
                'biller_id' => Auth::user()->id,
                'sales_order_id' => $salesOrder->id,
                'customer_id' => $customer,
                'invoice_id'=>$invoiceId->id,
            ];

            $sale = Sale::create($saleData);



            $quantity = $item['quantity'];
            $product->quantity -= $quantity;
            $product->save();

 

        }



        // Return a response indicating success
        return response()->json(['message' => 'Order stored successfully'], 200);
    }
    
}
