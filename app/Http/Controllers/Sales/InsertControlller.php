<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleReturn;
use App\Models\SaleReturnOrder;
use App\Models\SalesOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InsertControlller extends Controller
{
      //Home Page 

      public function view(Request $request)
      {
  
          $products = Product::all();
          $customers = Customer::all();
  
          return view('sales.addsales', compact('products', 'customers'));
      }



      public function storeTableData(Request $request)
      {
          $tableData = $request->input('tableData');
          $grandTotalDinar = $request->input('grandTotalDinar');
          $grandTotalDollar = $request->input('grandTotalDollar');
          $shipping = $request->input('shipping');
          $status = $request->input('status');
          $dolar_price = $request->input('dolar');

          
          // Retrieve the maximum receipt value starting with "SR"
          $maxReceipt = Sale::where('receipt', 'LIKE', 'SR%')->max('receipt');
  
          $maxNumericReceipt = (int) substr($maxReceipt, 2);
          $nextNumericReceipt = $maxNumericReceipt + 1;
  
          // Format the next receipt with leading zeros
          $receipt = 'SR' . str_pad($nextNumericReceipt, 3, '0', STR_PAD_LEFT);
  
          // Create a new SalesOrder
          $salesOrder = SalesOrder::create([
              'shipping' => $shipping,
              'status' => $status,
              'dolar_price'=>$dolar_price,
              'total_dinar' => $grandTotalDinar,
              'total_dollar' => $grandTotalDollar,
          ]);
  
          foreach ($tableData as $rowData) {
              $saleData = [
                  'product_id' => $rowData['product_id'],
                  'quantity' => $rowData['quantity'],
                  'price' => $rowData['price'],
                  'subtotal' => $rowData['subtotal'],
                  'receipt' => $receipt,
                  'date' => $rowData['date'],
                  'customer_id' => $rowData['customer_id'],
                  'biller_id' => Auth::user()->id,
                  'sales_order_id' => $salesOrder->id,
              ];
  
              Sale::create($saleData);
  
              // Reduce product quantity
              $product = Product::find($rowData['product_id']);
              $product->quantity -= $rowData['quantity'];
              $product->save();
          }
  
          return response()->json(['message' => 'Data stored successfully']);
      }
  




      // Sale Return Insert

    public function home(Request $request)
    {
        $products = Product::all();
        $customers = Customer::all();

        return view('sales.createsalesreturns', compact('products', 'customers'));
    }


    public function storeTableReturn(Request $request)
    {
        $tableData = $request->input('tableData');
        $grandTotalDinar = $request->input('grandTotalDinar');
        $grandTotalDollar = $request->input('grandTotalDollar');
        $shipping = $request->input('shipping');
        $status = $request->input('status');
        $dolar_price = $request->input('dolar');

            // Retrieve the maximum receipt value starting with "SR"
            $maxReceipt = SaleReturn::where('receipt', 'LIKE', 'SR%')->max('receipt');
  
            $maxNumericReceipt = (int) substr($maxReceipt, 2);
            $nextNumericReceipt = $maxNumericReceipt + 1;
    
            // Format the next receipt with leading zeros
            $receipt = 'SR' . str_pad($nextNumericReceipt, 3, '0', STR_PAD_LEFT);
    
        // Create a new SalesOrder
        $salesOrder = SaleReturnOrder::create([
            'shipping' => $shipping,
            'status' => $status,
            'dolar_price'=>$dolar_price,
            'total_dinar' => $grandTotalDinar,
            'total_dollar' => $grandTotalDollar,
        ]);

        foreach ($tableData as $rowData) {
            $saleData = [
                'product_id' => $rowData['product_id'],
                'quantity' => $rowData['quantity'],
                'price' => $rowData['price'],
                'subtotal' => $rowData['subtotal'],
                'receipt' => $receipt,
                'date' => $rowData['date'],
                'customer_id' => $rowData['customer_id'],
                'biller_id' => Auth::user()->id,
                'sales_order_id' => $salesOrder->id,
            ];

            SaleReturn::create($saleData);

            // Reduce product quantity
            $product = Product::find($rowData['product_id']);
            $product->quantity += $rowData['quantity'];
            $product->save();
        }

        return response()->json(['message' => 'Data stored successfully']);
    }
    


}
