<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AdvancedControlller extends Controller
{


    public function purchaseAdvanced(Request $request)
    {
        // Retrieve selected options
        $customersAndSuppliers = $request->input('customersAndSuppliers');
        $users = $request->input('users');
        $dateRange = $request->input('dateRange');
        $products = $request->input('products');
    
        // Initialize the query builder
        $query = Purchase::query();
    
        // Apply filters based on selected options
        if ($customersAndSuppliers !== 'All') {
            // Apply filter based on customers or suppliers
            // Assuming you have a relationship between Purchase and Customer/Supplier models
            $query->whereHas('supplier', function ($query) use ($customersAndSuppliers) {
                $query->where('id', $customersAndSuppliers);
            });
        }
    
        if ($users !== 'All') {
            // Apply filter based on users
            // Assuming you have a relationship between Purchase and User model
            $query->whereHas('biller', function ($query) use ($users) {
                $query->where('id', $users);
            });
        }
    
        if (!empty($dateRange)) {
            // Extract start and end dates from the date range
            [$startDate, $endDate] = explode(' - ', $dateRange);
    
            // Apply filter based on date range
            $query->whereBetween('created_at', [Carbon::parse($startDate), Carbon::parse($endDate)]);
        }
    
        if ($products !== 'All') {
            // Apply filter based on products
            // Assuming you have a relationship between Purchase and Product model
            $query->whereHas('product', function ($query) use ($products) {
                $query->where('id', $products);
            });
        }
    
        // Retrieve the filtered purchases
        $filteredPurchases = $query->get();

        Session::flash('filteredPurchases', $filteredPurchases);
        if ($filteredPurchases === null || $filteredPurchases->isEmpty()) {
            return response()->json(['error' => 'No filtered sales found.'], 404);
        }
        // Redirect to the route where you want to display the filtered data
        return view('report.advance.invoicePurchase',compact('filteredPurchases'));
    }
    

    public function purchaseview()
    {
        // Retrieve the filtered purchases from session flash data
        $filteredPurchases = Session::get('filteredPurchases');
    
        // Check if filteredPurchases is null and handle accordingly
        if ($filteredPurchases === null) {
            // Handle the case where no filtered purchases are found
            // For example, redirect back with a flash message
            return redirect()->back()->with('error', 'No filtered purchases found.');
        }
    
        // Return the view with filtered purchases
        return view('report.advance.invoicePurchase', compact('filteredPurchases'));
    }
    




    public function salesAdvanced(Request $request)
    {
        // Retrieve selected options
        $customers = $request->input('customers');
        $users = $request->input('users');
        $dateRange = $request->input('dateRange');
        $products = $request->input('products');
    
        // Initialize the query builder
        $query = Sale::query();
    
        // Apply filters based on selected options
        if ($customers !== 'All') {
            // Apply filter based on customers or suppliers
            // Assuming you have a relationship between Purchase and Customer/Supplier models
            $query->where(function ($query) use ($customers) {
                $query->whereHas('customer', function ($query) use ($customers) {
                    $query->where('id', $customers);
                })->orWhereHas('salesuser', function ($query) use ($customers) {
                    $query->where('id', $customers);
                });
            });

            
        }
    
        if ($users !== 'All') {
            // Apply filter based on users
            // Assuming you have a relationship between Purchase and User model
            $query->whereHas('biller', function ($query) use ($users) {
                $query->where('id', $users);
            });
          
        }
    
        if (!empty($dateRange)) {
            // Extract start and end dates from the date range
            [$startDate, $endDate] = explode(' - ', $dateRange);
    
            // Apply filter based on date range
            $query->whereBetween('created_at', [Carbon::parse($startDate), Carbon::parse($endDate)]);
        }
    
        if ($products !== 'All') {
            // Apply filter based on products
            // Assuming you have a relationship between Purchase and Product model
            $query->whereHas('product', function ($query) use ($products) {
                $query->where('id', $products);
            });
        }
    
        // Retrieve the filtered Sales
        $filteredSales = $query->get();

        Session::flash('filteredSales', $filteredSales);

        if ($filteredSales === null || $filteredSales->isEmpty()) {
            return response()->json(['error' => 'No filtered sales found.'], 404);
        }
        // Redirect to the route where you want to display the filtered data
        return view('report.advance.invoiceSales',compact('filteredSales'));
    }
    

    public function salesview()
    {
        $filteredSales = Session::get('filteredSales');
        logger()->info('Filtered Sales:', ['value' => $filteredSales]);

        if ($filteredSales === null || $filteredSales->isEmpty()) {
            return response()->json(['error' => 'No filtered sales found.'], 404);
        }
    
        // Return the view with filtered purchases
        return view('report.advance.invoiceSales', compact('filteredSales'));
    }
    



    
    public function soldAdvanced(Request $request)
    {
        // Retrieve selected options
        $customers = $request->input('customers');
        $users = $request->input('users');
        $dateRange = $request->input('dateRange');
        $products = $request->input('products');
    
        // Initialize the query builder
        $query = Sale::query();
    
        // Apply filters based on selected options
        if ($customers !== 'All') {
            // Apply filter based on customers or suppliers
            // Assuming you have a relationship between Purchase and Customer/Supplier models
            $query->where(function ($query) use ($customers) {
                $query->whereHas('customer', function ($query) use ($customers) {
                    $query->where('id', $customers);
                })->orWhereHas('salesuser', function ($query) use ($customers) {
                    $query->where('id', $customers);
                });
            });

            
        }
    
        if ($users !== 'All') {
            // Apply filter based on users
            // Assuming you have a relationship between Purchase and User model
            $query->whereHas('biller', function ($query) use ($users) {
                $query->where('id', $users);
            });
          
        }
    
        if (!empty($dateRange)) {
            // Extract start and end dates from the date range
            [$startDate, $endDate] = explode(' - ', $dateRange);
    
            // Apply filter based on date range
            $query->whereBetween('created_at', [Carbon::parse($startDate), Carbon::parse($endDate)]);
        }
    
        if ($products !== 'All') {
            // Apply filter based on products
            // Assuming you have a relationship between Purchase and Product model
            $query->whereHas('product', function ($query) use ($products) {
                $query->where('id', $products);
            });
        }
    
        // Retrieve the filtered Sales
        $filteredSold = $query->get();

        Session::flash('filteredSold', $filteredSold);

        if ($filteredSold === null || $filteredSold->isEmpty()) {
            return response()->json(['error' => 'No filtered sales found.'], 404);
        }
        // Redirect to the route where you want to display the filtered data
        return view('report.advance.invoiceSold',compact('filteredSold'));
    }
    

    public function soldview()
    {
        $filteredSold = Session::get('filteredSold');
        logger()->info('Filtered Sales:', ['value' => $filteredSold]);

        if ($filteredSold === null || $filteredSold->isEmpty()) {
            return response()->json(['error' => 'No filtered sales found.'], 404);
        }
    
        // Return the view with filtered purchases
        return view('report.advance.invoiceSold', compact('filteredSold'));
    }



    
    public function qtyAdvanced(Request $request)
    {
        // Retrieve selected options
        $customersAndSuppliers = $request->input('suppliers');
        $users = $request->input('users');
        $dateRange = $request->input('dateRange');
        $products = $request->input('products');
    
        // Initialize the query builder
        $query = Purchase::query();
    
        // Apply filters based on selected options
        if ($customersAndSuppliers !== 'All') {
            // Apply filter based on customers or suppliers
            // Assuming you have a relationship between Purchase and Customer/Supplier models
            $query->whereHas('supplier', function ($query) use ($customersAndSuppliers) {
                $query->where('id', $customersAndSuppliers);
            });
        }
    
        if ($users !== 'All') {
            // Apply filter based on users
            // Assuming you have a relationship between Purchase and User model
            $query->whereHas('biller', function ($query) use ($users) {
                $query->where('id', $users);
            });
        }
    
        if (!empty($dateRange)) {
            // Extract start and end dates from the date range
            [$startDate, $endDate] = explode(' - ', $dateRange);
    
            // Apply filter based on date range
            $query->whereBetween('created_at', [Carbon::parse($startDate), Carbon::parse($endDate)]);
        }
    
        if ($products !== 'All') {
            // Apply filter based on products
            // Assuming you have a relationship between Purchase and Product model
            $query->whereHas('product', function ($query) use ($products) {
                $query->where('id', $products);
            });
        }
    
        // Retrieve the filtered purchases
        $filteredPurchases = $query->get();

        Session::flash('filteredPurchases', $filteredPurchases);
        if ($filteredPurchases === null || $filteredPurchases->isEmpty()) {
            return response()->json(['error' => 'No filtered sales found.'], 404);
        }
        // Redirect to the route where you want to display the filtered data
        return view('report.advance.invoicePurchaseQty',compact('filteredPurchases'));
    }
    

    public function qtyview()
    {
        // Retrieve the filtered purchases from session flash data
        $filteredPurchases = Session::get('filteredPurchases');
    
        // Check if filteredPurchases is null and handle accordingly
        if ($filteredPurchases === null) {
            // Handle the case where no filtered purchases are found
            // For example, redirect back with a flash message
            return redirect()->back()->with('error', 'No filtered purchases found.');
        }
    
        // Return the view with filtered purchases
        return view('report.advance.invoicePurchaseQty', compact('filteredPurchases'));
    }
    
}
