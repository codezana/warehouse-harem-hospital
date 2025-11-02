<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="WareHouse Harem Hospital">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('name')</title>

    @yield('custom-css')
    {{-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/harem.png') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- Include the Toastify library -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <!-- Include the Fontawesome library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .toastify-custom {
            border-radius: 13px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 15px;
            font-weight: 500;
            color: #fff;
            padding: 15px 20px;
            background-color: #4CAF50;
            /* Green */
        }

        .toastify-custom i {
            margin-right: 10px;
        }

        .toastify-custom.toastify-error {
            background-color: #f44336;
            /* Red */
        }

        .toastify-custom.toastify-info {
            background-color: #2196F3;
            /* Blue */
        }

        .toastify-custom.toastify-warning {
            background-color: #ff9800;
            /* Orange */
        }

        .toastify-custom.toastify-success {
            background-color: #4CAF50;
            /* Green */
        }
    </style>
</head>

<!-- Role and primmssion -->
<?php
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

// Get the role_id for the authenticated user
$roleId = Auth::user()->roles()->first()->id;

// Get the permissions associated with the role
$permissionsForRole = Role::find($roleId)->permissions;

?>

<!-- Expire Notification -->
<?php

use Carbon\Carbon;
use App\Models\Purchase;
use App\Models\Product; // Import the Product model

$user = Auth::user();
$role = $user->roles()->first();

if ($role && ($role->name === 'admin' || $role->name === 'cashier')) {
    if (Auth::check() && !session('expired_products_notified')) {
        // Retrieve purchases with expiration dates
        $expiringPurchases = \App\Models\Purchase::whereNotNull('expire_date')->get();
        // Initialize a variable to count the number of expiring products
        $numExpiringProducts = 0;

        foreach ($expiringPurchases as $purchase) {
            // Retrieve the product associated with the purchase
            $product = \App\Models\Product::find($purchase->product_id);
            // Check if the product exists and has a quantity greater than zero
            if ($product && $product->quantity > 0) {
                // Convert the expire_date to a Carbon instance
                $expireDate = \Carbon\Carbon::createFromFormat('Y-m-d', $purchase->expire_date);
                // Calculate the difference in days from now
                $remainingDays = $expireDate->diffInDays(\Carbon\Carbon::now());
                // Check if the remaining days are within the range of 0 to 30 days
                if ($remainingDays >= 0 && $remainingDays <= 30) {
                    // Increment the count of expiring products
                    $numExpiringProducts++;
                }
            }
        }

        if ($numExpiringProducts > 0) {
            // Echo the JavaScript code within the Blade syntax
            echo '
                <script>
                    setTimeout(function() {
                        var numExpiringProducts = ' .
                $numExpiringProducts .
                ';
                        if (numExpiringProducts > 0) {
                            var toast = Toastify({
                                text: numExpiringProducts + " products are expired",
                                duration: 4000,
                                gravity: "top-left", // Position the toast notification at the top left corner
                                close: true, // Show a close button
                                backgroundColor: "#f44336", // Set the background color to a specific color (e.g., red)
                                className: "toastify-custom", // Custom CSS class for styling
                            }).showToast();

                            // Fade out the toast when the duration is finished
                            toast.options.callback = function() {
                                toast.hideToast();
                            };

                            // Set session variable to indicate that the notification has been shown
                            fetch("/set-expired-products-notified");
                        }
                    }, 10000); // Wait for 10 seconds (10000 milliseconds) before showing the notification
                </script>
            ';
            // Set session variable to indicate that the notification has been shown
            session(['expired_products_notified' => true]);
        }
    }
}
?>

<!--       -->

<body>


    {{--
    <div id="global-loader">
        <div class="whirly-loader"> </div>
    </div> --}}

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        <div class="header header-one">

            <!-- Logo -->
            @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('cashier'))
                <div class="header-left active">
                    <a href="{{ route('home.page') }}" class="logo logo-normal">
                        <img src="assets/img/haremw.png" loading="lazy">
                    </a>
                    <a href="{{ route('home.page') }}" class="logo logo-white">
                        <img src="assets/img/haremd.png" loading="lazy">
                    </a>
                    <a href="{{ route('home.page') }}" class="logo-small">
                        <img src="assets/img/harem-bg.png" loading="lazy">
                    </a>


                </div>
            @else
                <div class="header-left active">
                    <a href="{{ route('dashboard') }}" class="logo logo-normal">
                        <img src="assets/img/haremw.png" alt>
                    </a>
                    <a href="{{ route('dashboard') }}" class="logo logo-white">
                        <img src="assets/img/haremd.png" alt>
                    </a>
                    <a href="{{ route('dashboard') }}" class="logo-small">
                        <img src="assets/img/harem-bg.png" alt>
                    </a>


                </div>
            @endif

            <!-- /Logo -->

            <a id="mobile_btn" class="mobile_btn" href="#sidebar">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>

            <!-- Header Menu -->
            <ul class="nav user-menu">



                <!-- Search -->
                <li class="nav-item nav-searchinputs">
                    <div class="top-nav-search">

                        <a href="javascript:void(0);" class="responsive-search">
                            <i class="fa fa-search"></i>
                        </a>
                        <form action="#">
                            <div class="searchinputs">
                                <input type="text" placeholder="Search">
                                <div class="search-addon">
                                    <span><i data-feather="search" class="feather-14"></i></span>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
                <!-- /Search -->


                <!-- Flag -->
                <li class="nav-item dropdown has-arrow flag-nav nav-item-box">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="javascript:void(0);"
                        role="button">
                        <i data-feather="globe"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="javascript:void(0);" class="dropdown-item active">
                            <img src="assets/img/flags/us.png" alt height="16"> English
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="assets/img/flags/iq.png" alt height="16"> Arabic
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="assets/img/flags/ku.png" alt height="16"> Kurdish
                        </a>

                    </div>
                </li>
                <!-- /Flag -->


                @php
                    $hasViewModelChangePermission = false;
                    $userHasPermission = false;
                @endphp

                @php

                    $requiredPermissions = ['View ModelChange'];
                    $hasViewModelChangePermission = false;
                    foreach ($requiredPermissions as $permission) {
                        if (Auth::user()->hasPermission($permission)) {
                            $userHasPermission = true;
                            if ($permission === 'View ModelChange') {
                                $hasViewModelChangePermission = true;
                            }
                        }
                    }
                @endphp
                <!-- /Model change system -->

                @if ($hasViewModelChangePermission)
                    <li class="nav-item nav-item-box">
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#exampleModal130">
                            <i class="fa-solid fa-bolt"></i> </a>
                    </li>
                @endif

                <!-- /  Full screen -->

                <li class="nav-item nav-item-box">
                    <a href="javascript:void(0);" id="btnFullscreen">
                        <i data-feather="maximize"></i>
                    </a>
                </li>

                <!-- Expire Notification -->
                <?php
                use App\Models\Order;
                
                $user = Auth::user();
                $role = $user->roles()->first();
                
                if ($role && ($role->name === 'admin' || $role->name === 'cashier')) {
                    // Fetch all active orders
                    $orders = Order::where('is_active', 1)->orderByDesc('created_at')->get();
                
                    // Group active orders by request_id
                    $groupedOrders = $orders->groupBy('request_id');
                
                    // Extract request IDs from grouped active orders
                    $requestIds = $groupedOrders->keys()->toArray();
                } else {
                    $requestIds = [];
                }
                ?>
                @php
                    $hasViewModelChangePermission = false;

                @endphp

                @php
                    $requiredPermissions = ['View Notification', 'Select all Notification'];
                    $userHasPermission = false;

                    $hasViewNotificationPermission = false;
                    $hasSelectAllNotificationPermission = false;

                    foreach ($requiredPermissions as $permission) {
                        if (Auth::user()->hasPermission($permission)) {
                            $userHasPermission = true;
                            if ($permission === 'View Notification') {
                                $hasSelectAllNotificationPermission = true;
                            } elseif ($permission === 'Select all Notification') {
                                $hasSelectAllNotificationPermission = true;
                            }
                        }
                    }
                @endphp

                @if (
                    $hasViewNotificationPermission ||
                        ($hasViewNotificationPermission && $hasSelectAllNotificationPermission) ||
                        $hasSelectAllNotificationPermission)
                    <!-- Notifications Minumim Quanatity -->

                    <!-- Notifications -->
                    <li class="nav-item dropdown nav-item-box">
                        <a href="javascript:void(0);" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-radiation" style="color: #63737f;"></i>
                            <span id="minumQuanitty" class="badge rounded-pill"></span>
                        </a>
                        <script>
                            let lastUpdateTimeQuanity = Date.now(); // Initialize last update time to current time

                            function updateAlret() {
                                fetch('{{ route('alret.quantity') }}?lastUpdateTimeQuanity=' + lastUpdateTimeQuanity)
                                    .then(response => response.json())
                                    .then(data => {
                                        // Check if there is any data returned from the server
                                        if (Object.keys(data).length !== 0) {
                                            document.getElementById('minumQuanitty').innerText = data.alretcount;
                                            document.getElementById('notification-list-quanity').innerHTML = data.notificationListQuanitty;
                                            lastUpdateTimeQuanity = data.lastUpdateTimeQuanity; // Update last update time

                                            // Show or hide order count badge based on order count
                                            if (data.alretcount === 0) {
                                                document.getElementById('minumQuanitty').style.display = 'none';
                                            } else {
                                                document.getElementById('minumQuanitty').style.display =
                                                    'inline'; // or 'block' depending on your styling
                                            }
                                        }
                                    })
                                    .catch(error => console.error('Error fetching prouct count and list:', error));
                            }

                            // Update order count and list every 10 seconds (10000 milliseconds)
                            setInterval(updateAlret, 10000);

                            // Initial call to update count and list on page load
                            updateAlret();
                        </script>



                        <div class="dropdown-menu notifications">
                            <div class="topnav-dropdown-header">
                                <span class="notification-title">Warning</span>
                                <a href="javascript:void(0)" class="clear-noti"> Close </a>
                            </div>
                            <div class="noti-content">
                                <ul class="notification-list" id="notification-list-quanity">
                                    <!--  notifications will be populated dynamically here -->
                                </ul>
                            </div>
                            <div class="topnav-dropdown-footer">
                                <a href="{{ route('product.product.list') }}">View all Products</a>
                            </div>
                        </div>
                    </li>
                    <!-- /Notifications -->





                    <li class="nav-item dropdown nav-item-box">

                        <a href="javascript:void(0);" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                            <i data-feather="alert-circle"></i>
                            <span id="expireproduct" class="badge rounded-pill"></span>
                        </a>
                        <div class="dropdown-menu notifications">
                            <div class="topnav-dropdown-header">
                                <span class="notification-title">Expired Item</span>
                                <a href="javascript:void(0)" class="clear-noti"> Close </a>
                            </div>
                            <div class="noti-content">
                                <ul class="notification-list" id="expire">


                                </ul>
                            </div>
                            <div class="topnav-dropdown-footer">
                                <a href="{{ route('expiredlist.page') }}">View all Expired Items</a>
                            </div>
                        </div>

                        <script>
                            let previousExpireCount = 0;
                            let previousNotificationList = '';

                            function updateExpireCountAndList() {
                                fetch('{{ route('getExpireCountAndList') }}')
                                    .then(response => response.json())
                                    .then(data => {
                                        const currentExpireCount = data.expireCount;
                                        const currentNotificationList = data.notificationList;

                                        // Compare current count and list with previous state
                                        if (currentExpireCount !== previousExpireCount || currentNotificationList !==
                                            previousNotificationList) {
                                            if (data.expireCount === 0) {
                                                document.getElementById('expireproduct').style.display = 'none';
                                            } else {
                                                document.getElementById('expireproduct').style.display =
                                                    'inline'; // or 'block' depending on your styling
                                            }
                                            // Update DOM only if there are new expiring products
                                            document.getElementById('expireproduct').innerText = currentExpireCount;
                                            document.querySelector('#expire').innerHTML = currentNotificationList;

                                            // Update previous state
                                            previousExpireCount = currentExpireCount;
                                            previousNotificationList = currentNotificationList;

                                            // Show or hide order count badge based on order count

                                        }
                                    })
                                    .catch(error => console.error('Error fetching expiring products count and list:', error));
                            }

                            // Update expiring products count and list every 10 seconds (10000 milliseconds)
                            setInterval(updateExpireCountAndList, 10000);

                            // Initial call to update count and list on page load
                            updateExpireCountAndList();
                        </script>


                    </li>




                    <!-- Sale Request Notification -->
                    <li class="nav-item dropdown nav-item-box">
                        <a href="javascript:void(0);" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                            <i data-feather="bell"></i>
                            <span id="orderCountBadge" class="badge rounded-pill"></span>
                        </a>
                        <script>
                            let lastUpdateTime = Date.now(); // Initialize last update time to current time

                            function updateOrderCountAndList() {
                                fetch('{{ route('getOrderCountAndList') }}?lastUpdateTime=' + lastUpdateTime)
                                    .then(response => response.json())
                                    .then(data => {
                                        // Check if there is any data returned from the server
                                        if (Object.keys(data).length !== 0) {
                                            document.getElementById('orderCountBadge').innerText = data.orderCount;
                                            document.getElementById('notification-list').innerHTML = data.notificationList;
                                            lastUpdateTime = data.lastUpdateTime; // Update last update time

                                            // Show or hide order count badge based on order count
                                            if (data.orderCount === 0) {
                                                document.getElementById('orderCountBadge').style.display = 'none';
                                            } else {
                                                document.getElementById('orderCountBadge').style.display =
                                                    'inline'; // or 'block' depending on your styling
                                            }
                                        }
                                    })
                                    .catch(error => console.error('Error fetching order count and list:', error));
                            }

                            // Update order count and list every 10 seconds (10000 milliseconds)
                            setInterval(updateOrderCountAndList, 10000);

                            // Initial call to update count and list on page load
                            updateOrderCountAndList();
                        </script>



                        <div class="dropdown-menu notifications">
                            <div class="topnav-dropdown-header">
                                <span class="notification-title">Notifications</span>
                                <a href="javascript:void(0)" class="clear-noti"> Close </a>
                            </div>
                            <div class="noti-content">
                                <ul class="notification-list" id="notification-list">
                                    <!-- Sale request notifications will be populated dynamically here -->
                                </ul>
                            </div>
                            <div class="topnav-dropdown-footer">
                                <a href="{{ route('activities.page') }}">View all Notifications</a>
                            </div>
                        </div>
                    </li>
                    <!-- /Notifications  -->
                @endif

                <li class="nav-item nav-item-box">
                    <a href="{{ route('comming') }}"><i data-feather="settings"></i></a>
                </li>


                <!-- User wire:Profile -->
                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                        <span class="user-info">
                            <span class="user-letter">
                                <img src="
                                @if (isset(Auth::user()->file)) {{ asset('uploads/users/' . Auth::user()->file) }}

                                @elseif (Auth::user()->hasRole('admin'))
                                {{ asset('assets/img/admin.jpg') }}
                                @elseif (Auth::user()->hasRole('cashier'))
                                {{ asset('assets/img/cashier.png') }}
@else
{{ asset('assets/img/user.png') }} @endif
                                
                                "
                                    alt="" style="border-radius: 50%" class="img-fluid">
                            </span>
                            <span class="user-detail">
                                <span class="user-name">{{ Auth::user()->username }}</span>
                                @foreach (Auth::user()->roles as $role)
                                    <span class="user-role">{{ $role->name }}</span>
                                @endforeach
                            </span>
                        </span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilename">
                            <div class="profileset">
                                <span class="user-img"><img
                                        src="            @if (isset(Auth::user()->file)) {{ asset('uploads/users/' . Auth::user()->file) }}
    
                                    @elseif (Auth::user()->hasRole('admin'))
                                    {{ asset('assets/img/admin.jpg') }}
                                    @elseif (Auth::user()->hasRole('cashier'))
                                    {{ asset('assets/img/cashier.png') }}
    @else
    {{ asset('assets/img/user.png') }} @endif"
                                        alt="">
                                    <span class="status online"></span></span>
                                <div class="profilesets">
                                    <h6>{{ Auth::user()->username }}</h6>
                                    @foreach (Auth::user()->roles as $role)
                                        <h5>{{ $role->name }}</h5>
                                    @endforeach
                                </div>
                            </div>
                            <hr class="m-0">
                            <a class="dropdown-item" href="{{ route('profile.page') }}"> <i class="me-2"
                                    data-feather="user"></i> My
                                Profile</a>
                            <a class="dropdown-item" href="{{ route('comming') }}"><i class="me-2"
                                    data-feather="settings"></i>Settings</a>
                            <hr class="m-0">
                            <form action="logout" method="POST">
                                @csrf
                                <button class="dropdown-item logout pb-0"><img
                                        src="{{ asset('assets/img/icons/log-out.svg') }}" class="me-2"
                                        alt="img">Logout</button>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
            <!-- /Header Menu -->

            <!-- Mobile Menu -->
            <div class="dropdown mobile-user-menu">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('profile.page') }}">My Profile</a>
                    <a class="dropdown-item" href="{{ route('comming') }}">Settings</a>
                    <form action="logout" method="POST">
                        @csrf
                        <button class="dropdown-item logout pb-0">Logout</button>
                    </form>
                </div>
            </div>
            <!-- /Mobile Menu -->


        </div>



        <!-- Side bar Serve Menu -->

        <div class="sidebar new-header sidebar-one">
            <div id="sidebar-menu" class="sidebar-menu">
                <ul class="nav">



                    @php
                        $requiredPermissions = ['View Application', 'Select all Application'];
                        $userHasPermission = false;

                        $hasViewApplicationPermission = false;
                        $hasSelectAllApplicationPermission = false;

                        foreach ($requiredPermissions as $permission) {
                            if (Auth::user()->hasPermission($permission)) {
                                $userHasPermission = true;
                                if ($permission === 'View Application') {
                                    $hasViewApplicationPermission = true;
                                } elseif ($permission === 'Select all Application') {
                                    $hasSelectAllApplicationPermission = true;
                                }
                            }
                        }
                    @endphp






                    <li class="submenu">
                        <a href="./"><img src="assets/img/icons/main.svg" alt="img"><span> Main
                                Menu</span> <span class="menu-arrow"></span></a>
                        <ul>
                            @if (!Auth::user()->hasRole('admin'))
                                <li><a href="{{ route('dashboard') }}"><img src="assets/img/icons/dashboard.svg"
                                            alt="img"><span>
                                            Dashboard</span> </a></li>
                            @else
                                <li class="submenu">
                                    <a href="javascript:void(0);"><img src="assets/img/icons/salesdash.svg"
                                            alt="img"><span>
                                            Dashboards</span> <span class="menu-arrow"></span></a>
                                    <ul>
                                        <li><a href="{{ route('home.page') }}">Admin Dahboard</a></li>
                                        <li><a href="{{ route('dashboard') }}">Sales Dashboard</a></li>
                                    </ul>
                                </li>
                            @endif


                            @if (
                                $hasViewApplicationPermission ||
                                    ($hasViewApplicationPermission && $hasSelectAllApplicationPermission) ||
                                    $hasSelectAllApplicationPermission)
                                <li class="submenu">
                                    <a href="javascript:void(0);"><img src="assets/img/icons/product.svg"
                                            alt="img"><span>
                                            Application</span> <span class="menu-arrow"></span></a>
                                    <ul>
                                        <li><a href="{{ route('comming') }}">Chat</a></li>
                                        <li><a href="{{ route('comming') }}">Calendar</a></li>
                                        <li><a href="{{ route('comming') }}">Email</a></li>
                                    </ul>
                                </li>
                            @endif


                        </ul>
                    </li>




                    @php
                        $requiredPermissions = ['View Product', 'Select all Product'];
                        $userHasPermission = false;

                        $hasViewProductPermission = false;
                        $hasSelectAllProductPermission = false;

                        foreach ($requiredPermissions as $permission) {
                            if (Auth::user()->hasPermission($permission)) {
                                $userHasPermission = true;
                                if ($permission === 'View Product') {
                                    $hasViewProductPermission = true;
                                } elseif ($permission === 'Select all Product') {
                                    $hasSelectAllProductPermission = true;
                                }
                            }
                        }
                    @endphp


                    @if (
                        $hasViewProductPermission ||
                            ($hasViewProductPermission && $hasSelectAllProductPermission) ||
                            $hasSelectAllProductPermission)
                        <li class="submenu">
                            <a href="javascript:void(0);" class="subdrop"><img src="assets/img/icons/inventory.svg"
                                    alt="img"><span>
                                    Inventory</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="{{ route('product.product.list') }}">Products</a></li>
                                <li><a href="{{ route('product.categorylist') }}">Category</a></li>
                                <li><a href="{{ route('product.subcategorylist') }}">Sub Category</a></li>
                                <li><a href="{{ route('product.brand.list') }}">Brand</a></li>
                                <li><a href="{{ route('typelist.page') }}">Units</a></li>
                                <li><a href="{{ route('sizelist.page') }}">Sizes</a></li>
                                <li><a href="{{ route('expiredlist.page') }}">Expired Product</a></li>

                            </ul>
                        </li>
                    @endif



                    @php
                        $requiredPermissions = [
                            'View Sales',
                            'Select all Sales',
                            'View POS',
                            'Select all POS',
                            'View Request',
                            'Select all Request',
                            'View Purchase',
                            'Select all Purchase',
                            'View Invoices',
                            'Select all Invoices',
                        ];
                        $userHasPermission = false;

                        $hasViewSalesPermission = false;
                        $hasSelectAllSalesPermission = false;

                        $hasViewPurchasePermission = false;
                        $hasSelectAllPurchasePermission = false;

                        $hasViewPOSPermission = false;
                        $hasSelectAllPOSPermission = false;

                        $hasViewRequestPermission = false;
                        $hasSelectAllRequestPermission = false;
                        $hasViewInvoicesPermission = false;
                        $hasSelectAllInvoicesPermission = false;
                        
                        foreach ($requiredPermissions as $permission) {
                            if (Auth::user()->hasPermission($permission)) {
                                $userHasPermission = true;
                                if ($permission === 'View Sales') {
                                    $hasViewSalesPermission = true;
                                } elseif ($permission === 'Select all Sales') {
                                    $hasSelectAllSalesPermission = true;
                                } elseif ($permission === 'View Purchase') {
                                    $hasViewPurchasePermission = true;
                                } elseif ($permission === 'Select all Purchase') {
                                    $hasSelectAllPurchasePermission = true;
                                } elseif ($permission === 'View POS') {
                                    $hasViewPOSPermission = true;
                                } elseif ($permission === 'Select all POS') {
                                    $hasSelectAllPOSPermission = true;
                                } elseif ($permission === 'View Request') {
                                    $hasViewRequestPermission = true;
                                } elseif ($permission === 'Select all Request') {
                                    $hasSelectAllRequestPermission = true;
                                }
                                elseif ($permission === 'View Invoices') {
                                    $hasViewInvoicesPermission = true;
                                } elseif ($permission === 'Select all Invoices') {
                                    $hasSelectAllInvoicesPermission = true;
                                }
                            }
                        }
                    @endphp


                    @if (
                        $hasViewSalesPermission ||
                            ($hasViewSalesPermission && $hasSelectAllSalesPermission) ||
                            $hasSelectAllSalesPermission ||
                            $hasViewPOSPermission ||
                            ($hasViewPOSPermission && $hasSelectAllPOSPermission) ||
                            $hasSelectAllPOSPermission ||
                            $hasViewRequestPermission ||
                            ($hasViewRequestPermission && $hasSelectAllRequestPermission) ||
                            $hasSelectAllRequestPermission ||
                            $hasViewPurchasePermission ||
                            ($hasViewPurchasePermission && $hasSelectAllPurchasePermission) ||
                            $hasSelectAllPurchasePermission ||
                            ($hasViewInvoicesPermission && $hasSelectAllInvoicesPermission) ||
                            $hasSelectAllInvoicesPermission)
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/sale.svg" alt="img"><span>
                                    Sales & Purchases</span> <span class="menu-arrow"></span></a>
                            <ul>



                                <li class="submenu">
                                    <a href="javascript:void(0);"><span> Sales</span> <span
                                            class="menu-arrow"></span></a>
                                    <ul>
                                        @if (
                                            $hasViewSalesPermission ||
                                                ($hasViewSalesPermission && $hasSelectAllSalesPermission) ||
                                                $hasSelectAllSalesPermission)
                                            <li><a href="{{ route('saleslist.page') }}">Sales List</a></li>
                                            <li><a href="{{ route('salesreturnlist.page') }}">Sales Return</a></li>
                                        @endif
                                        @if ($hasViewPOSPermission || ($hasViewPOSPermission && $hasSelectAllPOSPermission) || $hasSelectAllPOSPermission)
                                            <li><a href="{{ route('pos.page') }}">POS</a></li>
                                        @endif
                                        @if (
                                            $hasViewRequestPermission ||
                                                ($hasViewRequestPermission && $hasSelectAllRequestPermission) ||
                                                $hasSelectAllRequestPermission)
                                            <li><a href="{{ route('request.page') }}">Request</a></li>
                                        @endif



                                    </ul>
                                </li>





                                @if (
                                    $hasViewPurchasePermission ||
                                        ($hasViewPurchasePermission && $hasSelectAllPurchasePermission) ||
                                        $hasSelectAllPurchasePermission)
                                    <li class="submenu">
                                        <a href="javascript:void(0);"><span> Purchase</span> <span
                                                class="menu-arrow"></span></a>
                                        <ul>
                                            <li><a href="{{ route('purchaselistpage') }}">Purchase List</a></li>

                                        </ul>
                                    </li>
                                @endif

                                @if (
                                    $hasViewInvoicesPermission ||
                                        ($hasViewInvoicesPermission && $hasSelectAllInvoicesPermission) ||
                                        $hasSelectAllInvoicesPermission)
                                    <li class="submenu">
                                        <a href="javascript:void(0);"><span> Invoices</span> <span
                                                class="menu-arrow"></span></a>
                                        <ul>
                                            <li><a href="{{ route('invoice.page') }}">Invoices List</a></li>

                                        </ul>
                                    </li>
                                @endif
                            </ul>
                        </li>

                    @endif





                    @php
                        $requiredPermissions = [
                            'View User Management',
                            'Select all User Management',
                            'View Customer',
                            'Select all Customer',
                            'View Supplier',
                            'Select all Supplier',
                        ];
                        $userHasPermission = false;
                        $hasViewCustomerPermission = false;
                        $hasSelectAllCustomerPermission = false;

                        $hasViewUserPermission = false;
                        $hasSelectAllUserPermission = false;

                        $hasViewSupplierPermission = false;
                        $hasSelectAllSupplierPermission = false;

                        foreach ($requiredPermissions as $permission) {
                            if (Auth::user()->hasPermission($permission)) {
                                $userHasPermission = true;
                                if ($permission === 'View Customer') {
                                    $hasViewCustomerPermission = true;
                                } elseif ($permission === 'Select all Customer') {
                                    $hasSelectAllCustomerPermission = true;
                                } elseif ($permission === 'View User Management') {
                                    $hasViewUserPermission = true;
                                } elseif ($permission === 'Select all User Management') {
                                    $hasSelectAllUserPermission = true;
                                } elseif ($permission === 'View Supplier') {
                                    $hasViewSupplierPermission = true;
                                } elseif ($permission === 'Select all Supplier') {
                                    $hasSelectAllSupplierPermission = true;
                                }
                            }
                        }
                    @endphp

                    @if (
                        $hasViewUserPermission ||
                            ($hasViewUserPermission && $hasSelectAllUserPermission) ||
                            $hasSelectAllUserPermission ||
                            $hasViewCustomerPermission ||
                            ($hasViewCustomerPermission && $hasSelectAllCustomerPermission) ||
                            $hasSelectAllCustomerPermission ||
                            $hasViewSupplierPermission ||
                            ($hasViewSupplierPermission && $hasSelectAllSupplierPermission) ||
                            $hasSelectAllSupplierPermission)
                        <li class="submenu">
                            <a href="#"><img src="assets/img/icons/entity.svg" alt="img"><span>Entity
                                    Management</span>
                                <span class="menu-arrow"></span></a>
                            <ul>
                                @if ($hasViewUserPermission || ($hasViewUserPermission && $hasSelectAllUserPermission) || $hasSelectAllUserPermission)
                                    <li class="submenu">
                                        <a href="javascript:void(0);"><span>Users</span> <span
                                                class="menu-arrow"></span></a>
                                        <ul>
                                            <li><a href="{{ route('newuser') }}">New User</a></li>
                                            <li><a href="{{ route('userlists') }}">Users List</a></li>

                                        </ul>
                                    </li>
                                @endif

                                @if (
                                    $hasViewCustomerPermission ||
                                        ($hasViewCustomerPermission && $hasSelectAllCustomerPermission) ||
                                        $hasSelectAllCustomerPermission)
                                    <li class="submenu">
                                        <a href="javascript:void(0);"><span>Customers</span> <span
                                                class="menu-arrow"></span></a>
                                        <ul>
                                            <li><a href="{{ route('addcustomer.page') }}">New Customer</a></li>
                                            <li><a href="{{ route('customerlist.page') }}">Customer List</a></li>


                                        </ul>
                                    </li>
                                @endif

                                @if (
                                    $hasViewSupplierPermission ||
                                        ($hasViewSupplierPermission && $hasSelectAllSupplierPermission) ||
                                        $hasSelectAllSupplierPermission)
                                    <li class="submenu">
                                        <a href="javascript:void(0);"><span>Suppliers</span> <span
                                                class="menu-arrow"></span></a>
                                        <ul>
                                            <li><a href="{{ route('addsupplier.page') }}">New Supplier</a></li>
                                            <li><a href="{{ route('supplierlist.page') }}">Supplier List</a></li>


                                        </ul>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif







                    @php
                        $requiredPermissions = ['View Reports', 'Select all Reports'];
                        $userHasPermission = false;

                        $hasViewReportsPermission = false;
                        $hasSelectAllReportsPermission = false;

                        foreach ($requiredPermissions as $permission) {
                            if (Auth::user()->hasPermission($permission)) {
                                $userHasPermission = true;
                                if ($permission === 'View Reports') {
                                    $hasViewReportsPermission = true;
                                } elseif ($permission === 'Select all Reports') {
                                    $hasSelectAllReportsPermission = true;
                                }
                            }
                        }
                    @endphp

                    @if (
                        $hasViewReportsPermission ||
                            ($hasViewReportsPermission && $hasSelectAllReportsPermission) ||
                            $hasSelectAllReportsPermission)
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/time.svg" alt="img"><span>
                                    Report</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="{{ route('request.report') }}">Request report</a></li>
                                <li><a href="{{ route('inventory.report') }}">Inventory Report</a></li>
                                <li><a href="{{ route('sales.report') }}">Sales Report</a></li>
                                <li><a href="{{ route('invoice.report') }}">Invoice Report</a></li>
                                <li><a href="{{ route('purchase.report') }}">Purchase Report</a></li>
                                <li><a href="{{ route('supplier.report') }}">Supplier Report</a></li>
                                <li><a href="{{ route('customer.report') }}">Customer Report</a></li>
                            </ul>
                        </li>
                    @endif



                    @php
                        $requiredPermissions = ['View Premission', 'Select all Premission'];
                        $userHasPermission = false;

                        $hasViewPermission = false;
                        $hasSelectAllPermission = false;

                        foreach ($requiredPermissions as $permission) {
                            if (Auth::user()->hasPermission($permission)) {
                                $userHasPermission = true;
                                if ($permission === 'View Premission') {
                                    $hasViewPermission = true;
                                } elseif ($permission === 'Select all Premission') {
                                    $hasSelectAllPermission = true;
                                }
                            }
                        }
                    @endphp

                    <li class="submenu">
                        <a href="javascript:void(0);"><img src="assets/img/icons/settings.svg" alt="img"><span>
                                Settings</span> <span class="menu-arrow"></span></a>
                        <ul>

                            <li><a href="{{ route('comming') }}">General Settings</a></li>


                            @if ($hasViewPermission || ($hasViewPermission && $hasSelectAllPermission) || $hasSelectAllPermission)
                                <li class="submenu">
                                    <a href="javascript:void(0);"><span>Role & Permissions</span> <span
                                            class="menu-arrow"></span></a>
                                    <ul>
                                        <li><a href="{{ route('createpermission.page') }}">Create Permissions</a></li>

                                        <li><a href="{{ route('grouppermissions.page') }}">Role & Permissions</a></li>

                                    </ul>
                                </li>
                            @endif

                        </ul>
                    </li>




                </ul>
            </div>
        </div>
        <!-- /Sidebar -->













        <div class="customizer-links" style="display:flex; justify-content:center; align-items:center;">
            <ul class="sticky-sidebar">
                <li class="sidebar-icons">
                    <a href="#" class="add-setting" data-bs-toggle="tooltip" data-bs-placement="left">
                        <img src="assets/img/icons/sidebar-icon-01.svg" class="feather-five" alt="">
                    </a>
                </li>


                <li class="sidebar-icons">
                    <a href="{{ route('stickynote.page') }}">
                        <img src="assets/img/icons/note.svg" alt="Sticky Note">
                    </a>
                </li>

                {{-- <li class="sidebar-icons">
                    <a href="#" class="navigation-add" data-bs-toggle="tooltip" data-bs-placement="left">
                        <img src="assets/img/icons/sidebar-icon-02.svg" class="feather-five" alt="">
                    </a>
                </li> --}}

                @php
                    $requiredPermissions = ['View POS', 'Select all POS'];
                    $userHasPermission = false;

                    $hasViewPosPermission = false;
                    $hasSelectAllPosPermission = false;

                    foreach ($requiredPermissions as $permission) {
                        if (Auth::user()->hasPermission($permission)) {
                            $userHasPermission = true;
                            if ($permission === 'View POS') {
                                $hasViewPosPermission = true;
                            } elseif ($permission === 'Select all POS') {
                                $hasSelectAllPosPermission = true;
                            }
                        }
                    }
                @endphp


                @if ($hasViewPosPermission || ($hasViewPosPermission && $hasSelectAllPosPermission) || $hasSelectAllPosPermission)
                    <li class="sidebar-icons" style="">
                        <a href="{{ Request::is('pos') ? route('home.page') : (Auth::user()->hasRole('admin') || Auth::user()->hasRole('cashier') ? route('pos.page') : route('request.page')) }}"
                            data-bs-toggle="tooltip" data-bs-placement="left">
                            <img src="assets/img/icons/sidebar-icon-03.svg" class="feather-five" alt="">
                        </a>
                    </li>
                @endif






            </ul>
        </div>



        <div class="sidebar-settings preview-toggle" style="transition: all 1s ease;">
            <div class="sidebar-content sticky-sidebar-one">
                <div class="sidebar-header">
                    <h5>Preview Settings</h5>
                    <a class="sidebar-close" href="#"><img src="assets/img/icons/close-icon.svg"
                            alt=""></a>
                </div>
                <div class="sidebar-body">
                    <h6 class="theme-title">Choose Mode</h6>
                    <div class="switch-wrapper">
                        <div id="dark-mode-toggle">
                            <span class="light-mode active"> <img src="assets/img/icons/sun-icon.svg" class="me-2"
                                    alt="">
                                Light</span>
                            <span class="dark-mode"><i class="far fa-moon me-2"></i> Dark</span>
                        </div>
                    </div>
                    <div class="row  " style="display:none;">
                        <div class="col-xl-6 ere">
                            <div class="layout-wrap">
                                <div class="d-flex align-items-center">
                                    <div class="status-toggle d-flex align-items-center me-2">
                                        <input type="checkbox" id="1" class="check">
                                        <label for="1" class="checktoggle"><a href="index"
                                                class="layout-link">checkbox</a>
                                        </label>
                                    </div>
                                    <span class="status-text">LTR</span>
                                </div>
                                <div class="layout-img">
                                    <img class="img-fliud" src="assets/img/layout-ltr.png" alt="layout">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 ere">
                            <div class="layout-wrap">
                                <div class="d-flex align-items-center">
                                    <div class="status-toggle d-flex align-items-center me-2">
                                        <input type="checkbox" id="1" class="check">
                                        <label for="1" class="checktoggle"><a href="../template-rtl/index"
                                                class="layout-link">checkbox</>
                                        </label>
                                    </div>
                                    <span class="status-text">RTL</span>
                                </div>
                                <div class="layout-img">
                                    <img class="img-fliud" src="assets/img/layout-rtl.png" alt="layout">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row  " style="display:none;">
                        <div class="col-xl-6 ere">
                            <div class="layout-wrap">
                                <div class="d-flex align-items-center">
                                    <div class="status-toggle d-flex align-items-center me-2">
                                        <input type="checkbox" id="3" class="check">
                                        <label for="3" class="checktoggle"><a href="index-three"
                                                class="layout-link">checkbox</a> </label>
                                    </div>
                                    <span class="status-text">Boxed</span>
                                </div>
                                <div class="layout-img">
                                    <img class="img-fliud" src="assets/img/layout-04.png" alt="layout">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 ere">
                            <div class="layout-wrap">
                                <div class="d-flex align-items-center">
                                    <div class="status-toggle d-flex align-items-center me-2">
                                        <input type="checkbox" id="3" class="check">
                                        <label for="3" class="checktoggle"><a
                                                href="{{ asset('views/layouts/nav1.blade.php') }}"
                                                class="layout-link">checkbox</a> </label>
                                    </div>
                                    <span class="status-text">Collapsed</span>
                                </div>
                                <div class="layout-img">
                                    <img class="img-fliud" src="assets/img/layout-01.png" alt="layout">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="sidebar-settings nav-toggle" style="display: none">
            <div class="sidebar-content sticky-sidebar-one">
                <div class="sidebar-header">
                    <h5>Navigation Settings</h5>
                    <a class="sidebar-close" href="#"><img src="assets/img/icons/close-icon.svg"
                            alt=""></a>
                </div>
                <div class="sidebar-body">
                    <h6 class="theme-title">Navigation Type</h6>
                    <div class="row  ">
                        <div class="col-xl-6 ere">
                            <div class="layout-wrap">
                                <div class="d-flex align-items-center">
                                    <div class="status-toggle d-flex align-items-center me-2">
                                        <input type="checkbox" id="1" class="check">
                                        <label for="1" class="checktoggle"><a href="index"
                                                class="layout-link">checkbox</a>
                                        </label>
                                    </div>
                                    <span class="status-text">Vertical</span>
                                </div>
                                <div class="layout-img">
                                    <img class="img-fliud" src="assets/img/layout-03.png" alt="layout">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 ere">
                            <div class="layout-wrap">
                                <div class="d-flex align-items-center">
                                    <div class="status-toggle d-flex align-items-center me-2">
                                        <input type="checkbox" id="2" class="check">
                                        <label for="2" class="checktoggle"><a href="index-one"
                                                class="layout-link">checkbox</a> </label>
                                    </div>
                                    <span class="status-text">Horizontal</span>
                                </div>
                                <div class="layout-img">
                                    <img class="img-fliud" src="assets/img/layout-01.png" alt="layout">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 ere">
                            <div class="layout-wrap">
                                <div class="d-flex align-items-center">
                                    <div class="status-toggle d-flex align-items-center me-2">
                                        <input type="checkbox" id="3" class="check">
                                        <label for="3" class="checktoggle"><a href="nav1.blade.php"
                                                class="layout-link">checkbox</a> </label>
                                    </div>
                                    <span class="status-text">Collapsed</span>
                                </div>
                                <div class="layout-img">
                                    <img class="img-fliud" src="assets/img/layout-01.png" alt="layout">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 ere">
                            <div class="layout-wrap">
                                <div class="d-flex align-items-center">
                                    <div class="status-toggle d-flex align-items-center me-2">
                                        <input type="checkbox" id="3" class="check">
                                        <label for="3" class="checktoggle"><a href="index-three"
                                                class="layout-link">checkbox</a> </label>
                                    </div>
                                    <span class="status-text">Modern</span>
                                </div>
                                <div class="layout-img">
                                    <img class="img-fliud" src="assets/img/layout-04.png" alt="layout">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 ere">
                            <div class="layout-wrap">
                                <div class="d-flex align-items-center">
                                    <div class="status-toggle d-flex align-items-center me-2">
                                        <input type="checkbox" id="3" class="check">
                                        <label for="3" class="checktoggle"><a href="index-two"
                                                class="layout-link">checkbox</a> </label>
                                    </div>
                                    <span class="status-text">Boxed</span>
                                </div>
                                <div class="layout-img">
                                    <img class="img-fliud" src="assets/img/layout-03.png" alt="layout">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>







        <!-- Sidebar -->
        <div class="sidebar sidebar-one hide-sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">

                    <ul>

                        @php
                            $requiredPermissions = ['View Application', 'Select all Application'];
                            $userHasPermission = false;

                            $hasViewApplicationPermission = false;
                            $hasSelectAllApplicationPermission = false;

                            foreach ($requiredPermissions as $permission) {
                                if (Auth::user()->hasPermission($permission)) {
                                    $userHasPermission = true;
                                    if ($permission === 'View Application') {
                                        $hasSelectAllApplicationPermission = true;
                                    } elseif ($permission === 'Select all Application') {
                                        $hasSelectAllApplicationPermission = true;
                                    }
                                }
                            }
                        @endphp

                        <li class="submenu">
                            <a href="./"><img src="assets/img/icons/main.svg" alt="img"><span> Main
                                    Menu</span> <span class="menu-arrow"></span></a>
                            <ul>



                                @if (!Auth::user()->hasRole('admin'))
                                    <li><a href="{{ route('dashboard') }}"><img src="assets/img/icons/dashboard.svg"
                                                alt="img"><span>
                                                Dashboard</span> </a></li>
                                @else
                                    <li class="submenu">
                                        <a href="javascript:void(0);"><span>
                                                Dashboards</span> <span class="menu-arrow"></span></a>
                                        <ul>
                                            <li><a href="{{ route('home.page') }}">Admin Dahboard</a></li>
                                            <li><a href="{{ route('dashboard') }}">Sales Dashboard</a></li>
                                        </ul>
                                    </li>
                                @endif

                                @if (
                                    $hasViewApplicationPermission ||
                                        ($hasViewApplicationPermission && $hasSelectAllApplicationPermission) ||
                                        $hasSelectAllApplicationPermission)
                                    <li class="submenu">
                                        <a href="javascript:void(0);"><span> Application</span> <span
                                                class="menu-arrow"></span></a>
                                        <ul>
                                            <li><a href="{{ route('comming') }}">Chat</a></li>
                                            <li><a href="{{ route('comming') }}">Calendar</a></li>
                                            <li><a href="{{ route('comming') }}">Email</a></li>
                                        </ul>
                                    </li>
                                @endif


                            </ul>
                        </li>











                        @php
                            $requiredPermissions = ['View Product', 'Select all Product'];
                            $userHasPermission = false;

                            $hasViewProductPermission = false;
                            $hasSelectAllProductPermission = false;

                            foreach ($requiredPermissions as $permission) {
                                if (Auth::user()->hasPermission($permission)) {
                                    $userHasPermission = true;
                                    if ($permission === 'View Product') {
                                        $hasViewProductPermission = true;
                                    } elseif ($permission === 'Select all Product') {
                                        $hasSelectAllProductPermission = true;
                                    }
                                }
                            }
                        @endphp


                        @if (
                            $hasViewProductPermission ||
                                ($hasViewProductPermission && $hasSelectAllProductPermission) ||
                                $hasSelectAllProductPermission)
                            <li class="submenu">
                                <a href="javascript:void(0);"><img src="assets/img/icons/product.svg"
                                        alt="img"><span>
                                        Inventory</span> <span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{ route('product.product.list') }}">Products</a></li>
                                    <li><a href="{{ route('product.categorylist') }}">Category</a></li>
                                    <li><a href="{{ route('product.subcategorylist') }}">Sub Category</a></li>
                                    <li><a href="{{ route('product.brand.list') }}">Brand</a></li>
                                    <li><a href="{{ route('typelist.page') }}">Units</a></li>
                                    <li><a href="{{ route('sizelist.page') }}">Sizes</a></li>

                                    <li><a href="{{ route('expiredlist.page') }}">Expired Product</a></li>

                                </ul>
                            </li>
                        @endif







                        @php
                            $requiredPermissions = [
                                'View Sales',
                                'Select all Sales',
                                'View POS',
                                'Select all POS',
                                'View Request',
                                'Select all Request',
                                'View Purchase',
                                'Select all Purchase',
                                'View Invoices',
                                'Select all Invoices',
                            ];
                            $userHasPermission = false;

                            $hasViewSalesPermission = false;
                            $hasSelectAllSalesPermission = false;

                            $hasViewPurchasePermission = false;
                            $hasSelectAllPurchasePermission = false;

                            $hasViewPOSPermission = false;
                            $hasSelectAllPOSPermission = false;

                            $hasViewRequestPermission = false;
                            $hasSelectAllRequestPermission = false;

                            $hasViewInvoicesPermission = false;
                            $hasSelectAllInvoicesPermission = false;

                            foreach ($requiredPermissions as $permission) {
                                if (Auth::user()->hasPermission($permission)) {
                                    $userHasPermission = true;
                                    if ($permission === 'View Sales') {
                                        $hasViewSalesPermission = true;
                                    } elseif ($permission === 'Select all Sales') {
                                        $hasSelectAllSalesPermission = true;
                                    } elseif ($permission === 'View Purchase') {
                                        $hasViewPurchasePermission = true;
                                    } elseif ($permission === 'Select all Purchase') {
                                        $hasSelectAllPurchasePermission = true;
                                    } elseif ($permission === 'View POS') {
                                        $hasViewPOSPermission = true;
                                    } elseif ($permission === 'Select all POS') {
                                        $hasSelectAllPOSPermission = true;
                                    } elseif ($permission === 'View Request') {
                                        $hasViewRequestPermission = true;
                                    } elseif ($permission === 'Select all Request') {
                                        $hasSelectAllRequestPermission = true;
                                    } elseif ($permission === 'View Invoices') {
                                        $hasViewInvoicesPermission = true;
                                    } elseif ($permission === 'Select all Invoices') {
                                        $hasSelectAllInvoicesPermission = true;
                                    }
                                }
                            }
                        @endphp





                        @if (
                            $hasViewSalesPermission ||
                                ($hasViewSalesPermission && $hasSelectAllSalesPermission) ||
                                $hasSelectAllSalesPermission ||
                                $hasViewPOSPermission ||
                                ($hasViewPOSPermission && $hasSelectAllPOSPermission) ||
                                $hasSelectAllPOSPermission ||
                                $hasViewRequestPermission ||
                                ($hasViewRequestPermission && $hasSelectAllRequestPermission) ||
                                $hasSelectAllRequestPermission ||
                                $hasViewInvoicesPermission ||
                                ($hasViewInvoicesPermission && $hasSelectAllInvoicesPermission) ||
                                $hasSelectAllInvoicesPermission)
                            <li class="submenu">
                                <a href="javascript:void(0);"><img src="assets/img/icons/sale.svg"
                                        alt="img"><span>
                                        Sales</span>
                                    <span class="menu-arrow"></span></a>
                                <ul>

                                    @if (
                                        $hasViewSalesPermission ||
                                            ($hasViewSalesPermission && $hasSelectAllSalesPermission) ||
                                            $hasSelectAllSalesPermission)
                                        <li><a href="{{ route('saleslist.page') }}">Sales List</a></li>
                                        <li><a href="{{ route('salesreturnlist.page') }}">Sales Return</a></li>
                                    @endif
                                    @if ($hasViewPOSPermission || ($hasViewPOSPermission && $hasSelectAllPOSPermission) || $hasSelectAllPOSPermission)
                                        <li><a href="{{ route('pos.page') }}">POS</a></li>
                                    @endif
                                    @if (
                                        $hasViewRequestPermission ||
                                            ($hasViewRequestPermission && $hasSelectAllRequestPermission) ||
                                            $hasSelectAllRequestPermission)
                                        <li><a href="{{ route('request.page') }}">Request</a></li>
                                    @endif
                                </ul>
                            </li>
                        @endif





                        @if (
                            $hasViewPurchasePermission ||
                                ($hasViewPurchasePermission && $hasSelectAllPurchasePermission) ||
                                $hasSelectAllPurchasePermission)
                            <li class="submenu">
                                <a href="javascript:void(0);"><img src="assets/img/icons/dolar.svg"
                                        alt="img"><span>
                                        Purchase</span> <span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{ route('purchaselistpage') }}">Purchase List</a></li>

                                </ul>
                            </li>
                        @endif



                        @if (
                            $hasViewInvoicesPermission ||
                                ($hasViewInvoicesPermission && $hasSelectAllInvoicesPermission) ||
                                $hasSelectAllInvoicesPermission)
                            <li class="submenu">
                                <a href="javascript:void(0);"><img src="assets/img/icons/dolar.svg"
                                        alt="img"><span>
                                        Invoices</span> <span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{ route('invoice.page') }}">Invoices List</a></li>

                                </ul>
                            </li>
                        @endif







                        @php
                            $requiredPermissions = [
                                'View User Management',
                                'Select all User Management',
                                'View Customer',
                                'Select all Customer',
                                'View Supplier',
                                'Select all Supplier',
                            ];
                            $userHasPermission = false;
                            $hasViewCustomerPermission = false;
                            $hasSelectAllCustomerPermission = false;

                            $hasViewUserPermission = false;
                            $hasSelectAllUserPermission = false;

                            $hasViewSupplierPermission = false;
                            $hasSelectAllSupplierPermission = false;

                            foreach ($requiredPermissions as $permission) {
                                if (Auth::user()->hasPermission($permission)) {
                                    $userHasPermission = true;
                                    if ($permission === 'View Customer') {
                                        $hasViewCustomerPermission = true;
                                    } elseif ($permission === 'Select all Customer') {
                                        $hasSelectAllCustomerPermission = true;
                                    } elseif ($permission === 'View User Management') {
                                        $hasViewUserPermission = true;
                                    } elseif ($permission === 'Select all User Management') {
                                        $hasSelectAllUserPermission = true;
                                    } elseif ($permission === 'View Supplier') {
                                        $hasViewSupplierPermission = true;
                                    } elseif ($permission === 'Select all Supplier') {
                                        $hasSelectAllSupplierPermission = true;
                                    }
                                }
                            }
                        @endphp


                        @if (
                            $hasViewUserPermission ||
                                ($hasViewUserPermission && $hasSelectAllUserPermission) ||
                                $hasSelectAllUserPermission ||
                                $hasViewCustomerPermission ||
                                ($hasViewCustomerPermission && $hasSelectAllCustomerPermission) ||
                                $hasSelectAllCustomerPermission ||
                                $hasViewSupplierPermission ||
                                ($hasViewSupplierPermission && $hasSelectAllSupplierPermission) ||
                                $hasSelectAllSupplierPermission)
                            <li class="submenu">
                                <a href="javascript:void(0);"><img src="assets/img/icons/entity.svg"
                                        alt="img"><span> Entity
                                        Management </span> <span class="menu-arrow"></span></a>
                                <ul>
                                    @if ($hasViewUserPermission || ($hasViewUserPermission && $hasSelectAllUserPermission) || $hasSelectAllUserPermission)
                                        <li class="submenu">
                                            <a href="javascript:void(0);"><span>Users</span> <span
                                                    class="menu-arrow"></span></a>
                                            <ul>
                                                <li><a href="{{ route('newuser') }}">New User</a></li>
                                                <li><a href="{{ route('userlists') }}">Users List</a></li>

                                            </ul>
                                        </li>
                                    @endif

                                    @if (
                                        $hasViewCustomerPermission ||
                                            ($hasViewCustomerPermission && $hasSelectAllCustomerPermission) ||
                                            $hasSelectAllCustomerPermission)
                                        <li class="submenu">
                                            <a href="javascript:void(0);"><span>Customers</span> <span
                                                    class="menu-arrow"></span></a>
                                            <ul>
                                                <li><a href="{{ route('addcustomer.page') }}">New Customer</a></li>
                                                <li><a href="{{ route('customerlist.page') }}">Customer List</a></li>


                                            </ul>
                                        </li>
                                    @endif


                                    @if (
                                        $hasViewSupplierPermission ||
                                            ($hasViewSupplierPermission && $hasSelectAllSupplierPermission) ||
                                            $hasSelectAllSupplierPermission)
                                        <li class="submenu">
                                            <a href="javascript:void(0);"><span>Suppliers</span> <span
                                                    class="menu-arrow"></span></a>
                                            <ul>
                                                <li><a href="{{ route('addsupplier.page') }}">New Supplier</a></li>
                                                <li><a href="{{ route('supplierlist.page') }}">Supplier List</a></li>


                                            </ul>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif




                        @php
                            $requiredPermissions = ['View Reports', 'Select all Reports'];
                            $userHasPermission = false;

                            $hasViewReportsPermission = false;
                            $hasSelectAllReportsPermission = false;

                            foreach ($requiredPermissions as $permission) {
                                if (Auth::user()->hasPermission($permission)) {
                                    $userHasPermission = true;
                                    if ($permission === 'View Reports') {
                                        $hasViewReportsPermission = true;
                                    } elseif ($permission === 'Select all Reports') {
                                        $hasSelectAllReportsPermission = true;
                                    }
                                }
                            }
                        @endphp




                        @if (
                            $hasViewReportsPermission ||
                                ($hasViewReportsPermission && $hasSelectAllReportsPermission) ||
                                $hasSelectAllReportsPermission)
                            <li class="submenu">
                                <a href="javascript:void(0);"><img src="assets/img/icons/time.svg"
                                        alt="img"><span>
                                        Report</span> <span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{ route('request.report') }}">Request report</a></li>
                                    <li><a href="{{ route('inventory.report') }}">Inventory Report</a></li>
                                    <li><a href="{{ route('sales.report') }}">Sales Report</a></li>
                                    <li><a href="{{ route('invoice.report') }}">Invoice Report</a></li>
                                    <li><a href="{{ route('purchase.report') }}">Purchase Report</a></li>
                                    <li><a href="{{ route('supplier.report') }}">Supplier Report</a></li>
                                    <li><a href="{{ route('customer.report') }}">Customer Report</a></li>
                                </ul>
                            </li>
                        @endif



                        @php
                            $requiredPermissions = ['View Premission', 'Select all Premission'];
                            $userHasPermission = false;

                            $hasViewPermission = false;
                            $hasSelectAllPermission = false;

                            foreach ($requiredPermissions as $permission) {
                                if (Auth::user()->hasPermission($permission)) {
                                    $userHasPermission = true;
                                    if ($permission === 'View Premission') {
                                        $hasViewPermission = true;
                                    } elseif ($permission === 'Select all Premission') {
                                        $hasSelectAllPermission = true;
                                    }
                                }
                            }
                        @endphp


                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/settings.svg"
                                    alt="img"><span>
                                    Settings</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="{{ route('comming') }}">General Settings</a></li>

                                @if ($hasViewPermission || ($hasViewPermission && $hasSelectAllPermission) || $hasSelectAllPermission)
                                    <li class="submenu">
                                        <a href="javascript:void(0);"><span>Role & Permissions</span> <span
                                                class="menu-arrow"></span></a>
                                        <ul>
                                            <li><a href="{{ route('createpermission.page') }}">Create Permissions</a>
                                            </li>

                                            <li><a href="{{ route('grouppermissions.page') }}">Role & Permissions</a>
                                            </li>

                                        </ul>
                                    </li>
                                @endif


                            </ul>
                        </li>



                    </ul>
                    </li>






                    </ul>



                </div>
            </div>
        </div>
        <!-- /Sidebar -->









        @yield('content')







    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar-settings');
            const sidebarContent = document.querySelector('.sidebar-content');

            document.addEventListener('click', function(event) {
                const isClickInsideSidebar = sidebar.contains(event.target);
                if (isClickInsideSidebar && sidebar.classList.contains('show-settings')) {
                    sidebar.classList.remove('show-settings');
                }
            });
        });
    </script>



    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>

    <script src="{{ asset('assets/js/feather.min.js') }}"></script>

    <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexchart/chart-data.js') }}"></script>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"
        integrity="sha512-GWzVrcGlo0TxTRvz9ttioyYJ+Wwk9Ck0G81D+eO63BaqHaJ3YZX9wuqjwgfcV/MrB2PhaVX9DkYVhbFpStnqpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @yield('custom-js')




</body>

</html>
