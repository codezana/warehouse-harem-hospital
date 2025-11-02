<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\Role;
use App\Models\Sale;
use App\Models\SaleReturn;
use App\Models\SalesOrder;
use App\Models\Total_purchase;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {


        // Retrieve recently added products
        $recentlyAddedProducts = Product::orderBy('created_at', 'desc')->take(4)->get();



        $expiringPurchases = Purchase::whereNotNull('expire_date')->orderBy('created_at', 'desc')->take(4)->get();

        $customerCount = Customer::all()->count();
        $itemsCount = Product::all()->count();
        $purchaseCount = Purchase::all()->count();
        $salesCount = Sale::all()->count();

        $totalPurchaseDue = Total_purchase::where('status', 'Inprogress')->sum('grand_total');


        $totalSaleseDue = SalesOrder::where('status', 'Inprogress')->sum('total_dollar');
        $totalSaleAmount = SalesOrder::where('status', 'Completed')->sum('total_dollar');
        $totalQuantitySold = Sale::sum('quantity');

        // Define an array of all months within the desired range
        $allMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']; // Abbreviated month names

        // Retrieve sales data grouped by month (using SQLite strftime for month ordering)
        $salesData = Sale::selectRaw("
            CASE strftime('%m', date)
            WHEN '01' THEN 'Jan' WHEN '02' THEN 'Feb' WHEN '03' THEN 'Mar'
            WHEN '04' THEN 'Apr' WHEN '05' THEN 'May' WHEN '06' THEN 'Jun'
            WHEN '07' THEN 'Jul' WHEN '08' THEN 'Aug' WHEN '09' THEN 'Sep'
            WHEN '10' THEN 'Oct' WHEN '11' THEN 'Nov' WHEN '12' THEN 'Dec'
            END AS month,
            SUM(quantity) AS total_amount
        ")
            ->groupBy(DB::raw("strftime('%m', date)"))
            ->orderBy(DB::raw("strftime('%m', date)"))
            ->pluck('total_amount', 'month')->toArray();

        // Retrieve purchase data grouped by month (using SQLite strftime for month ordering)
        $purchaseData = Purchase::selectRaw("
            CASE strftime('%m', date)
            WHEN '01' THEN 'Jan' WHEN '02' THEN 'Feb' WHEN '03' THEN 'Mar'
            WHEN '04' THEN 'Apr' WHEN '05' THEN 'May' WHEN '06' THEN 'Jun'
            WHEN '07' THEN 'Jul' WHEN '08' THEN 'Aug' WHEN '09' THEN 'Sep'
            WHEN '10' THEN 'Oct' WHEN '11' THEN 'Nov' WHEN '12' THEN 'Dec'
            END AS month,
            SUM(quantity) AS total_amount
        ")
            ->groupBy(DB::raw("strftime('%m', date)"))
            ->orderBy(DB::raw("strftime('%m', date)"))
            ->pluck('total_amount', 'month')->toArray();

        // Fill in missing months with zero values
        foreach ($allMonths as $index => $month) {
            $formattedMonth = date('M', mktime(0, 0, 0, $index + 1, 1)); // Getting abbreviated month name from index

            if (!isset($salesData[$formattedMonth])) {
                $salesData[$formattedMonth] = 0;
            }
            if (!isset($purchaseData[$formattedMonth])) {
                $purchaseData[$formattedMonth] = 0;
            }
        }

        // Custom sorting function to sort months in the desired order
        $customSort = function ($a, $b) use ($allMonths) {
            $aIndex = array_search($a, $allMonths);
            $bIndex = array_search($b, $allMonths);
            return $aIndex - $bIndex;
        };

        // Sort the data by month in the custom order
        uksort($salesData, $customSort);
        uksort($purchaseData, $customSort);

        // Now $salesData and $purchaseData will contain data for all months within the desired range, with zero values for months without sales or purchases.
        // Convert data arrays to indexed arrays to match chart.js format
        $salesDataIndexed = array_values($salesData);
        $purchaseDataIndexed = array_values($purchaseData);




        // Retrieve unique years from the date column of both sales and purchases (SQLite-compatible)
        $saleYears = Sale::selectRaw("strftime('%Y', date) AS year")
            ->distinct()
            ->pluck('year')->toArray();

        $purchaseYears = Purchase::selectRaw("strftime('%Y', date) AS year")
            ->distinct()
            ->pluck('year')->toArray();

        // Merge the arrays and remove duplicates
        $years = array_unique(array_merge($saleYears, $purchaseYears));

        // Sort the years in descending order
        rsort($years);

        // Check if the authenticated user is not an admin

        if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('cashier')) {
            return view('welcome', compact(
                'recentlyAddedProducts',
                'expiringPurchases',
                'customerCount',
                'itemsCount',
                'purchaseCount',
                'salesCount',
                'totalPurchaseDue',
                'totalSaleseDue',
                'totalSaleAmount',
                'totalQuantitySold',
                'salesData',
                'purchaseData',
                'years',
                'salesDataIndexed',
                'purchaseDataIndexed',

            ));
        } elseif (!Auth::user()->hasRole('admin') || !Auth::user()->hasRole('cashier')) {
            return redirect()->route('request.page');
        }
    }


    // Sales Dashboard

    public function dashboard()
    {

        // Calculate the start and end dates of the current week
        $startDateCurrentWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
        $endDateCurrentWeek = Carbon::now()->endOfWeek()->format('Y-m-d');

        // Calculate the start and end dates of the previous week
        $startDatePreviousWeek = Carbon::now()->startOfWeek()->subWeek()->format('Y-m-d');
        $endDatePreviousWeek = Carbon::now()->startOfWeek()->subDay()->format('Y-m-d');

        // Retrieve the sale orders for the current week
        $saleOrdersCurrentWeek = SalesOrder::whereBetween('created_at', [$startDateCurrentWeek, $endDateCurrentWeek])->get();
        // Calculate the total earnings for the current week
        $totalEarningsCurrentWeek = $saleOrdersCurrentWeek->sum('total_dollar');

        // Retrieve the sale orders for the previous week
        $saleOrdersPreviousWeek = SalesOrder::whereBetween('created_at', [$startDatePreviousWeek, $endDatePreviousWeek])->get();
        // Calculate the total earnings for the previous week
        $totalEarningsPreviousWeek = $saleOrdersPreviousWeek->sum('total_dollar');

        // Calculate the percentage increase
        $percentageIncrease = 0;
        if ($totalEarningsPreviousWeek != 0) {
            $percentageIncrease = (($totalEarningsCurrentWeek - $totalEarningsPreviousWeek) / $totalEarningsPreviousWeek) * 100;
        }


        // Calculate the start and end dates of the past week
        $startDate = Carbon::now()->startOfWeek()->subWeek()->format('Y-m-d');
        $endDate = Carbon::now()->startOfWeek()->subDay()->format('Y-m-d');

        // Retrieve the sale orders for the past week
        $saleOrders = SalesOrder::whereBetween('created_at', [$startDate, $endDate])->get();

        // Calculate the total earnings for the past week
        $totalEarnings = $saleOrders->sum('total_dollar');


        $totalQuantitySold = Sale::sum('quantity');
        $totalSaleseDue = SalesOrder::where('status', 'Inprogress')->sum('total_dollar');


        $recentTransactions = Sale::orderBy('created_at', 'desc')
            ->distinct('date', 'receipt')
            ->take(5)
            ->get();


        // Define an array of all months within the desired range
        $allMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']; // Abbreviated month names

        // Retrieve sales data grouped by month
        $salesData = Sale::selectRaw('DATE_FORMAT(date, "%b") AS month, SUM(quantity) AS total_amount')
            ->groupBy(DB::raw('DATE_FORMAT(date, "%m"), DATE_FORMAT(date, "%b")'))
            ->orderBy(DB::raw('DATE_FORMAT(date, "%m")'))
            ->pluck('total_amount', 'month')->toArray();

        // Retrieve purchase data grouped by month
        $purchaseData = Purchase::selectRaw('DATE_FORMAT(date, "%b") AS month, SUM(quantity) AS total_amount')
            ->groupBy(DB::raw('DATE_FORMAT(date, "%m"), DATE_FORMAT(date, "%b")'))
            ->orderBy(DB::raw('DATE_FORMAT(date, "%m")'))
            ->pluck('total_amount', 'month')->toArray();

        // Fill in missing months with zero values
        foreach ($allMonths as $index => $month) {
            $formattedMonth = date('M', mktime(0, 0, 0, $index + 1, 1)); // Getting abbreviated month name from index

            if (!isset($salesData[$formattedMonth])) {
                $salesData[$formattedMonth] = 0;
            }
            if (!isset($purchaseData[$formattedMonth])) {
                $purchaseData[$formattedMonth] = 0;
            }
        }

        // Custom sorting function to sort months in the desired order
        $customSort = function ($a, $b) use ($allMonths) {
            $aIndex = array_search($a, $allMonths);
            $bIndex = array_search($b, $allMonths);
            return $aIndex - $bIndex;
        };

        // Sort the data by month in the custom order
        uksort($salesData, $customSort);
        uksort($purchaseData, $customSort);

        // Now $salesData and $purchaseData will contain data for all months within the desired range, with zero values for months without sales or purchases.
        // Convert data arrays to indexed arrays to match chart.js format
        $salesDataIndexed = array_values($salesData);
        $purchaseDataIndexed = array_values($purchaseData);




        // Retrieve unique years from the date column of both sales and purchases
        $saleYears = Sale::selectRaw('YEAR(date) AS year')
            ->distinct()
            ->pluck('year')->toArray();

        $purchaseYears = Purchase::selectRaw('YEAR(date) AS year')
            ->distinct()
            ->pluck('year')->toArray();

        // Merge the arrays and remove duplicates
        $years = array_unique(array_merge($saleYears, $purchaseYears));

        // Sort the years in descending order
        rsort($years);





        $salecount = Sale::all()->count();
        $saleReturncount = SaleReturn::all()->count();
        $purchasecount = Purchase::all()->count();
        $total = $salecount + $saleReturncount + $purchasecount ;


        $products = Product::all()->take(5);


        return view('sales-dashboard', compact('total', 'purchasecount', 'saleReturncount', 'salecount', 'salesData', 'purchaseDataIndexed', 'salesDataIndexed', 'years', 'products', 'totalEarnings', 'percentageIncrease', 'totalQuantitySold', 'totalSaleseDue', 'recentTransactions'));
    }



    //Refresh For Slaes dahsboard 

    public function getTotalQuantitySold()
    {
        // Logic to fetch the total quantity sold
        $totalQuantitySold = Sale::sum('quantity');

        return response()->json(['totalQuantitySold' => $totalQuantitySold]);
    }


    //2
    public function getTotalSalesDue()
    {
        // Logic to fetch the total Slaes Due
        $totalSaleDue = SalesOrder::where('status', 'Inprogress')->sum('total_dollar');

        return response()->json(['totalSaleDue' => $totalSaleDue]);
    }




    //Expire List Refersh 

    public function getExpireCountAndList(Request $request)
    {
        // Retrieve purchases with expiration dates
        $expiringPurchases = Purchase::whereNotNull('expire_date')->get();
        // Initialize a variable to count the number of expiring products
        $numExpiringProducts = 0;
        $notificationList = '';

        $user = Auth::user();
        $role = $user->roles()->first();

        if ($role && ($role->name === 'admin' || $role->name === 'cashier')) {
            foreach ($expiringPurchases as $purchase) {
                // Retrieve the product associated with the purchase
                $product = Product::find($purchase->product_id);
                // Check if the product exists and has a quantity greater than zero
                if ($product && $product->quantity > 0) {
                    $expireDate = Carbon::createFromFormat('Y-m-d', $purchase->expire_date);
                    $remainingDays = $expireDate->diffInDays(\Carbon\Carbon::now());
                    if ($remainingDays >= -30 && $remainingDays <= 30) {
                        $numExpiringProducts++;
                        // Build HTML markup for notification list
                        $notificationMessage = '';
                        if ($remainingDays == 0) {
                            $notificationMessage = 'Product <span class="noti-title">' . $product->name . '</span> is expiring today';
                        } elseif ($remainingDays == 1) {
                            $notificationMessage = 'Product <span class="noti-title">' . $product->name . '</span> will expire tomorrow';
                        } else {
                            $notificationMessage = ($remainingDays >= -30) ? 'Product <span class="noti-title">' . $product->name . '</span> has expired ' . abs($remainingDays) . ' days ago' : 'Product <span class="noti-title">' . $product->name . '</span> will expire in ' . $remainingDays . ' days';
                        }
                        $notificationList .= '<li class="notification-message">';
                        $notificationList .= '<a href="#">';
                        $notificationList .= '<div class="media d-flex">';
                        $notificationList .= '<span class="avatar flex-shrink-0">';
                        $notificationList .= '<img alt src="' . asset('uploads/product/products/' . $product->image) . '">';
                        $notificationList .= '</span>';
                        $notificationList .= '<div class="media-body flex-grow-1">';
                        $notificationList .= '<p class="noti-details">' . $notificationMessage . '</p>';
                        $notificationList .= '<p class="noti-time" ><span class="notification-time" style="color: red">' . $expireDate->diffForHumans() . '</span></p>';
                        $notificationList .= '</div>';
                        $notificationList .= '</div>';
                        $notificationList .= '</a>';
                        $notificationList .= '</li>';
                    }
                }
            }
        }

        // Return JSON response with updated count and list
        return response()->json([
            'expireCount' => $numExpiringProducts,
            'notificationList' => $notificationList,
        ]);
    }



    // Sale request Refresh 

    public function getOrderCountAndList(Request $request)
    {
        // Fetch all active orders
        $orders = Order::where('is_active', 1)->orderByDesc('created_at')->get();

        // Group active orders by request_id
        $groupedOrders = $orders->groupBy('request_id');

        // Extract request IDs from grouped active orders
        $requestIds = $groupedOrders->keys()->toArray();

        // Generate HTML markup for notification list
        $notificationList = '';
        foreach ($requestIds as $requestId) {
            $user = User::find($groupedOrders[$requestId]->first()->customer_id);
            $roleName = $user ? $user->roles()->first()->name : 'Role not found';
            if ($user && isset($user->file)) {
                $imageSrc = asset('uploads/users/' . $user->file);
            } elseif ($user && $user->roles()->first()->name == 'admin') {
                $imageSrc = asset('assets/img/admin.jpg');
            } elseif ($user && $user->roles()->first()->name == 'cashier') {
                $imageSrc = asset('assets/img/cashier.png');
            } else {
                $imageSrc = asset('assets/img/user.png');
            }
      
        

            $notificationList .= '<li class="notification-message">';
            $notificationList .= '<a href="' . route('show_sales', ['request_id' => $requestId]) . '">';
            $notificationList .= '<div class="media d-flex">';
            $notificationList .= '<span class="avatar flex-shrink-0">';
            $notificationList .= '<img alt="" src="' . $imageSrc . '">';
            $notificationList .= '</span>';
            $notificationList .= '<div class="media-body flex-grow-1">';
            $notificationList .= '<p class="noti-details">';
            $notificationList .= '<span class="noti-title">The ' . $roleName . ' ' . ($user ? $user->username : '') . '</span>';
            $notificationList .= ' ordered <span class="noti-title">' . $groupedOrders[$requestId]->count() . ' requests</span>';
            $notificationList .= '</p>';
            $notificationList .= '<p class="noti-time">';
            $notificationList .= '<span class="notification-time">' . \Carbon\Carbon::parse($groupedOrders[$requestId]->first()->created_at)->diffForHumans() . '</span>';
            $notificationList .= '</p>';
            $notificationList .= '</div>';
            $notificationList .= '</div>';
            $notificationList .= '</a>';
            $notificationList .= '</li>';
        }

        // Return JSON response with updated count and list
        return response()->json([
            'orderCount' => count($requestIds),
            'notificationList' => $notificationList,
        ]);
    }


    // Minumn quantiy Refresh 

    public function alert(Request $request)
    {
        // Fetch all products where quantity is less than or equal to the minimum quantity threshold
        $products = Product::whereRaw('quantity >= minimum_qty')->get();
        // Count the number of products below the minimum quantity threshold
        $alertCount = $products->count();
   
        // Generate HTML markup for notification list
        $notificationListQuanitty = '';
        foreach ($products as $product) {
            // Assuming you have the image field in your product table
            $imageSrc = $product ? asset('uploads/product/products/' . $product->image) : '';

            $notificationListQuanitty .= '<li class="notification-message">';
            $notificationListQuanitty .= '<a href="' . route('product.product.details', ['id' => $product->id]) . '">';
            $notificationListQuanitty .= '<div class="media d-flex">';
            $notificationListQuanitty .= '<span class="avatar flex-shrink-0">';
            $notificationListQuanitty .= '<img alt="" src="' . $imageSrc . '">';
            $notificationListQuanitty .= '</span>';
            $notificationListQuanitty .= '<div class="media-body flex-grow-1">';
            $notificationListQuanitty .= '<p class="noti-details">';
            $notificationListQuanitty .= '<span class="noti-title">The product ' . $product->name . ' quantity' . '</span>';
            $notificationListQuanitty .= ' almost exhausted with <span class="noti-title">' . $product->quantity . ' ' . $product->type->type_name . ' left</span>';
            $notificationListQuanitty .= '</p>';
            $notificationListQuanitty .= '<p class="noti-time">';
            $notificationListQuanitty .= '<span class="notification-time">' . \Carbon\Carbon::parse($product->updated_at)->diffForHumans() . '</span>';
            $notificationListQuanitty .= '</p>';
            $notificationListQuanitty .= '</div>';
            $notificationListQuanitty .= '</div>';
            $notificationListQuanitty .= '</a>';
            $notificationListQuanitty .= '</li>';
        }

        // Return JSON response with updated count and list
        return response()->json([
            'alretcount' => $alertCount,
            'notificationListQuanitty' => $notificationListQuanitty,
        ]);
    }
}
