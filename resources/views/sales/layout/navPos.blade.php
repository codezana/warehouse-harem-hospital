<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Warehouse Harem Hospital">
    <meta name="author" content="POS - Warehouse Harem Hospital">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>POS - Warehouse Harem Hospital</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/harem.png') }}">

    <link rel="stylesheet" href="{{ asset('assets/pos/assets/css/bootstrap.min.css') }}">


    <link rel="stylesheet" href="{{ asset('assets/pos/assets/plugins/select2/css/select2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/pos/assets/css/dataTables.bootstrap5.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/pos/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/pos/assets/plugins/fontawesome/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/pos/assets/plugins/owlcarousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/pos/assets/plugins/owlcarousel/owl.theme.default.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/pos/assets/css/style.css') }}">
  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>


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

    {{-- <div id="global-loader">
        <div class="whirly-loader"> </div>
    </div> --}}

    <div class="main-wrapper">

        <div class="header">

           <!-- Logo -->
           @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('cashier'))

           <div class="header-left active">
            <a href="{{ route('home.page') }}" class="logo logo-normal">
                <img src="assets/img/haremw.png" alt>
            </a>
            <a href="{{ route('home.page') }}" class="logo logo-white">
                <img src="assets/img/haremd.png" alt>
            </a>
            <a href="{{ route('home.page') }}" class="logo-small">
                <img src="assets/img/harem-bg.png" alt>
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

            <a id="mobile_btn" class="mobile_btn d-none" href="#sidebar">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>

            <ul class="nav user-menu">

                <li class="nav-item nav-searchinputs">
                    <div class="top-nav-search">
                        <a class="responsive-search">
                            <i class="fa fa-search"></i>
                        </a>
                        <form action="#" class="dropdown">
                            <div class="searchinputs dropdown-toggle" id="dropdownMenuClickable"
                                data-bs-toggle="dropdown" data-bs-auto-close="false">
                                <input type="text" placeholder="Search">
                                <div class="search-addon">
                                    <span><i data-feather="x-circle" class="feather-14"></i></span>
                                </div>
                            </div>
                            <div class="dropdown-menu search-dropdown" aria-labelledby="dropdownMenuClickable">
                                <div class="search-info">
                                    <h6><span><i data-feather="search" class="feather-16"></i></span>Recent Searches
                                    </h6>
                                    <ul class="search-tags">
                                        <li><a>Products</a></li>
                                        <li><a>Sales</a></li>
                                        <li><a>Applications</a></li>
                                    </ul>
                                </div>
                                <div class="search-info">
                                    <h6><span><i data-feather="help-circle" class="feather-16"></i></span>Help</h6>
                                    <p>How to Change Product Volume from 0 to 200 on Inventory management</p>
                                    <p>Change Product Name</p>
                                </div>
                                <div class="search-info">
                                    <h6><span><i data-feather="user" class="feather-16"></i></span>Customers</h6>
                                    <ul class="customers">
                                        <li><a>Aron Varu<img
                                                    src="{{ asset('assets/pos/assets/img/profiles/avator1.jpg') }}" alt
                                                    class="img-fluid"></a>
                                        </li>
                                        <li><a>Jonita<img
                                                    src="{{ asset('assets/pos/assets/img/profiles/avator1.jpg') }}" alt
                                                    class="img-fluid"></a>
                                        </li>
                                        <li><a>Aaron<img src="{{ asset('assets/pos/assets/img/profiles/avator1.jpg') }}"
                                                    alt class="img-fluid"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </form>
                    </div>
                </li>





                <li class="nav-item dropdown has-arrow flag-nav nav-item-box">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button">
                        <i data-feather="globe"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item active">
                            <img src="{{ asset('assets/pos/assets/img/flags/us.png') }}" alt height="16"> English
                        </a>
                        <a class="dropdown-item">
                            <img src="assets/img/flags/iq.png" alt height="16"> Arabic
                        </a>
                        <a class="dropdown-item">
                            <img src="assets/img/flags/ku.png" alt height="16"> Kurdish
                        </a>

                    </div>
                </li>


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
                    <a>
                        <i class="fa-solid fa-bolt" style="font-size: 14px;color: rgb(99,115,127)"></i>
                    </a>
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
                          <ul class="notification-list">


                          </ul>
                      </div>
                      <div class="topnav-dropdown-footer">
                          <a href="E{{ route('expiredlist.page') }}">View all Expired Items</a>
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
                                      document.querySelector('.notification-list').innerHTML = currentNotificationList;

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




          


             
                    <!-- Notifications -->
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
                    <!-- /Notifications -->
                @endif

                <li class="nav-item nav-item-box">
                    <a href="{{ route('comming') }}"><i data-feather="settings"></i></a>
                </li>


                     <!-- User wire:Profile -->
                     <li class="nav-item dropdown has-arrow main-drop">
                        <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                            <span class="user-info">
                                <span class="user-letter">
                                    <img src="     @if (isset(Auth::user()->file)) {{ asset('uploads/users/' . Auth::user()->file) }}
    
                                    @elseif (Auth::user()->hasRole('admin'))
                                    {{ asset('assets/img/admin.jpg') }}
                                    @elseif (Auth::user()->hasRole('cashier'))
                                    {{ asset('assets/img/cashier.png') }}
    @else
    {{ asset('assets/img/user.png') }} @endif"" alt=""
                                        style="border-radius: 50%" class="img-fluid">
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
                                    <span class="user-img"><img src="{     @if (isset(Auth::user()->file)) {{ asset('uploads/users/' . Auth::user()->file) }}
    
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





        @yield('content')




    </div>



    <div class="customizer-links" id="setdata">
        <ul class="sticky-sidebar">
            <li class="sidebar-icons">
                <a href="#" class="navigation-add" data-bs-toggle="tooltip" data-bs-placement="left"
                    data-bs-original-title="Theme">
                    <i data-feather="settings" class="feather-five"></i>
                </a>
            </li>
        </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>


    <script src="{{asset('assets/pos/assets/js/jquery-3.7.1.min.js')}}" type="41a3c2473be9a3ef9cecf223-text/javascript"></script>

    <script src="{{asset('assets/pos/assets/js/feather.min.js')}}" type="41a3c2473be9a3ef9cecf223-text/javascript"></script>

    <script src="{{asset('assets/pos/assets/js/jquery.dataTables.min.js')}}" type="41a3c2473be9a3ef9cecf223-text/javascript"></script>

    <script src="{{asset('assets/pos/assets/js/bootstrap.bundle.min.js')}}" type="41a3c2473be9a3ef9cecf223-text/javascript"></script>
    <script src="{{asset('assets/pos/assets/plugins/owlcarousel/owl.carousel.min.js')}}" type="41a3c2473be9a3ef9cecf223-text/javascript">
    </script>

    <script src="{{asset('assets/pos/assets/plugins/select2/js/select2.min.js')}}" type="41a3c2473be9a3ef9cecf223-text/javascript"></script>

    <script src="{{asset('assets/pos/assets/plugins/sweetalert/sweetalert2.all.min.js')}}" type="41a3c2473be9a3ef9cecf223-text/javascript">
    </script>
    <script src="{{asset('assets/pos/assets/plugins/sweetalert/sweetalerts.min.js')}}" type="41a3c2473be9a3ef9cecf223-text/javascript"></script>
    <script src="{{asset('assets/pos/assets/js/theme-script.js')}}" type="41a3c2473be9a3ef9cecf223-text/javascript"></script>
    <script src="{{asset('assets/pos/assets/js/script.js')}}" type="41a3c2473be9a3ef9cecf223-text/javascript"></script>
    <script src="{{ asset('assets/pos/assets/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js') }}"
        data-cf-settings="41a3c2473be9a3ef9cecf223-|49" defer></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="{{asset('assets/pos/assets/js/pos-script.js')}}" type="41a3c2473be9a3ef9cecf223-text/javascript"></script>


</body>

</html>





