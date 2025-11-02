<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Sale;
use Illuminate\Http\Request;

class UpdateControlller extends Controller
{


    public function print(Request $request)
    {
        $invoiceid = $request->input('invoice');
        $invoice = Sale::where('invoice_id', $invoiceid)->get();

        $invoiceSale = InvoiceItem::where('invoice_id', $invoiceid)->get();
        return view('print.invoice-solid', compact('invoice', 'invoiceSale'));
    }


    public function saleInvoice(Request $request)
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


        return view('print.invoice-sale', compact('sales'));
    }




    //Invoice List

    public function view()
    {

        $invoices=InvoiceItem::all();
        return view('invoice.invoicelist',compact('invoices'));
    }
}
