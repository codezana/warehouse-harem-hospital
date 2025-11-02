<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\InvoiceItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ListControlller extends Controller
{
    //Customer Report

    public function showcustomer()
    {

        $sales = Sale::all();
        return view('report.customerreport', compact('sales'));
    }


    //invoice Report

    public function showinvoice()
    {
        $users = User::all();

        $customers = Customer::all();
        $suppliers = Supplier::all();
        $users = User::all();
        
        // Merge customers, suppliers, and users with a label to differentiate them
        $contacts = $customers->map(function ($customer) {
            return [
                'id' => $customer->id,
                'name' => $customer->customer_name,
                'type' => 'Customer',
            ];
        })->merge($suppliers->map(function ($supplier) {
            return [
                'id' => $supplier->id,
                'name' => $supplier->supplier_name,
                'type' => 'Supplier',
            ];
        }))->merge($users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->username, // Change this to the appropriate attribute representing the user's name
                'type' => 'Requests',
            ];
        }));
        

        $products = Product::all();
        return view('report.invoicereport', compact('contacts', 'users', 'products'));
    }



    //inventory Report

    public function showinventory()
    {
        $products = Product::all();
        return view('report.inventoryreport', compact('products'));
    }


    //Sales Report

    public function showsales()
    {

        $sales = Sale::all();
        return view('report.salesreport', compact('sales'));
    }


    //Sales Report

    public function showsupplier()
    {

        $supplier = Supplier::all();
        $purchase = Purchase::all();
        $suppliers = Supplier::all();
        return view('report.supplierreport', compact('supplier', 'purchase', 'suppliers'));
    }

    //Request Report

    public function showrequest()
    {

        $Orders = Order::all()->groupBy(function ($Orders) {
            return $Orders->order . '-' . $Orders->receipt;
        });

        return view('report.requestreport', compact('Orders'));
    }

    //Request Report 2

    public function toggleStatusorder(Request $request)
    {
        $id = $request->input('id');

        $orders = Order::where('request_id', $id)->get();


        foreach ($orders as $order) {
            $oldStatus = $order->is_active;
            $newStatus = !$oldStatus;

            // Update the status
            $order->update(['is_active' => $newStatus]);
        }


        return redirect()->route('showrequest')->with('success', 'This status toggled successfully');
    }


    //Purchase Report

    public function showpurchase()
    {
        $purchases = Purchase::all();

        return view('report.purchasereport', compact('purchases'));
    }
}
