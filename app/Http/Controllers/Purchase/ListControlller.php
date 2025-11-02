<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ListControlller extends Controller
{
    //Home Page 

    public function home()
    {
        $purchase = Purchase::all()->groupBy(function ($purchase) {
            return $purchase->date . '-' . $purchase->reference;
        });

        return view('purchase.purchaselist', compact('purchase'));
    }


    // Expiring List 

    public function expiredlist()
    {
        $expiringPurchases = Purchase::whereNotNull('expire_date')->get();

        // Pass the array of expiring products data to the view
        return view('purchase.expiredlist', compact('expiringPurchases'));
    }

    



    // View  Purchase Details

    public function details(Request $request)
    {
        $date = $request->query('date');
        $receipt = $request->query('reference');


        // Retrieve the purchases data filtered by date and receipt
        $purchases = Purchase::where('date', $date)
            ->where('reference', $receipt)
            ->get()
            ->groupBy(function ($purchases) {
                return $purchases->date . '-' . $purchases->reference;
            });


        return view('purchase.purchasedetails', compact('purchases'));
    }

    
}
