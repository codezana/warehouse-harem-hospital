<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Sale;
use App\Models\SaleReturn;
use Illuminate\Http\Request;

class ListControlller extends Controller
{




      //Sale List Page 
      public function home()
      {  
          $sales = Sale::all()->groupBy(function ($sale) {
              return $sale->date . '-' . $sale->receipt;
          });
  
          return view('sales.saleslist', compact('sales'));
      }
  

      // View  Sale Details

      public function sale_details(Request $request)
      {
          $date = $request->query('date');
          $receipt = $request->query('receipt');
      
      
          // Retrieve the sales data filtered by date and receipt
          $sales = Sale::where('date', $date)
                       ->where('receipt', $receipt)
                       ->get()
                       ->groupBy(function ($sale) {
                           return $sale->date . '-' . $sale->receipt;
                       });
  
      
          return view('sales.salesdetails', compact('sales'));
      }





       //Home Page 

    public function ViewReturn()
    {  

        $sales_return = SaleReturn::all()->groupBy(function ($sale) {
            return $sale->date . '-' . $sale->receipt;
        });
        return view('sales.salesreturnlist', compact('sales_return'));
    }




// Details Slae Return

    public function sale_return_details(Request $request)
    {
        $date = $request->query('date');
        $receipt = $request->query('receipt');
    
        // Retrieve the sales data filtered by date and receipt
        $sales_return = SaleReturn::where('date', $date)
                     ->where('receipt', $receipt)
                     ->get()
                     ->groupBy(function ($sale) {
                         return $sale->date . '-' . $sale->receipt;
                     });

        return view('sales.sales_return_details', compact('sales_return'));
    }


    

}
