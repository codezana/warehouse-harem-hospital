@extends('layouts.nav')

@section('name', 'Sales Dashboard')
@section('custom-css')

    <link rel="stylesheet" href="{{ asset('assets/css/nesesarydashborad.css') }}">

@endsection
@section('content')

    <style>
        #refreshIcon,
        #refreshIconDue {
            position: absolute;
            right: 5px;
            top: 5px;
        }



        #card {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>





    <div class="page-wrapper page-wrapper-one">
        <div class="content">
            <div class="welcome d-lg-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center welcome-text">
                    <h3 class="d-flex align-items-center"><img src="dashboard/assets/img/icons/hi.svg" alt="img">&nbsp;Hi
                        {{ Auth::user()->username }},</h3>&nbsp;<h6> See here's what's happening with your
                        Warehouse today.</h6>
                </div>

                <div class="d-flex align-items-center">
                    <div class="position-relative daterange-wraper me-2">
                        <div class="input-group icon calender-input">
                            <input type="text" class="form-control date-range bookingrange" id="currentDateTime"
                                placeholder="Select">
                        </div>
                        <i data-feather="calendar" class="feather-14"></i>
                    </div>
                    <script>
                        // Function to update the current date and time in the input field
                        function updateDateTime() {
                            var currentDateTime = new Date().toLocaleString(); // Get the current date and time
                            document.getElementById('currentDateTime').value = currentDateTime; // Update the input field value
                        }

                        // Call the function initially to set the initial date and time
                        updateDateTime();

                        // Update the date and time every second
                        setInterval(updateDateTime, 1000); // Update every second (1000 milliseconds)
                    </script>



                    <button id="refreshButton" type="button" data-toggle="tooltip"
                        class="btn btn-white-outline d-none d-md-inline-block" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Refresh">
                        <i data-feather="rotate-ccw" class="feather-16"></i>
                    </button>

                    <script>
                        // Function to refresh the content
                        function refreshContent() {
                            // Add your logic here to refresh the content dynamically
                            // For example, you can update the content of a specific element or make an AJAX request to fetch new data

                            // For demonstration purposes, let's reload the page after 1 second
                            setTimeout(function() {
                                location.reload();
                            }, 500); // Refresh after 1 second
                        }

                        // Add an event listener to the refresh button
                        document.getElementById('refreshButton').addEventListener('click', function() {
                            refreshContent();
                        });
                    </script>


                </div>
            </div>



            <div class="row sales-cards">
                <div class="col-xl-6 col-sm-12 col-12">
                    <div class="card d-flex align-items-center justify-content-between default-cover mb-4">
                        <div>
                            <h6>Weekly Earning</h6>
                            <h3>$<span id="weeklyEarning" class="counters"
                                    data-count="{{ $totalEarnings }}">{{ $totalEarnings }}</span></h3>
                            <p class="sales-range">
                                @if ($percentageIncrease > 0)
                                    <span class="text-success"><i data-feather="chevron-up" class="feather-16"></i></span>
                                @elseif ($percentageIncrease < 0)
                                    <span class="text-danger"><i data-feather="chevron-down" class="feather-16"></i></span>
                                @endif
                                {{ abs(round($percentageIncrease, 2)) }}%&nbsp;
                                @if ($percentageIncrease != 0)
                                    @if ($percentageIncrease > 0)
                                        Increase compared to last week
                                    @else
                                        Decrease compared to last week
                                    @endif
                                @else
                                    compared to last week
                                @endif
                            </p>

                        </div>
                        <img src="dashboard/assets/img/icons/weekly-earning.svg" alt="img">
                    </div>
                </div>


                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card color-info bg-primary mb-4">
                        <img src="dashboard/assets/img/icons/qty.svg" alt="img">
                        <h3 id="totalQuantity" class="counters" data-count="{{ $totalQuantitySold }}">
                            {{ $totalQuantitySold }}+</h3>
                        <p>Total Quantity Sold</p>
                        <i id="refreshIcon" data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"
                            class="feather-16" style="cursor: pointer;">&#10227;</i>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card color-info bg-secondary mb-4">
                        <img src="dashboard/assets/img/icons/hand.svg" alt="img">
                        <h3 id="totalsalesDue" class="counters" data-count="{{ $totalSaleseDue }}">{{ $totalSaleseDue }}+
                        </h3>
                        <p>Total Sales Due</p>
                        <i id="refreshIconDue" data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"
                            class="feather-16" style="cursor: pointer;">&#10227;</i>
                    </div>
                </div>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        document.getElementById('refreshIcon').addEventListener('click', function() {
                            // Send AJAX request to fetch updated total quantity sold
                            fetch('{{ route('getTotalQuantitySold') }}')
                                .then(response => response.json())
                                .then(data => {
                                    // Update the content of total quantity sold element
                                    document.getElementById('totalQuantity').innerText = data.totalQuantitySold;
                                })
                                .catch(error => console.error('Error:', error));
                        });

                        document.getElementById('refreshIconDue').addEventListener('click', function() {
                            // Send AJAX request to fetch updated total sales due
                            fetch('{{ route('getTotalSalesDue') }}')
                                .then(response => response.json())
                                .then(data => {
                                    // Update the content of total sales due element
                                    document.getElementById('totalsalesDue').innerText = data.totalSaleDue;
                                })
                                .catch(error => console.error('Error:', error));
                        });
                    });
                </script>



            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-4 d-flex">
                    <div class="card flex-fill default-cover w-100 mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Qty 10-20 Take(5)</h4>
                            <div class="dropdown">
                                <a href="javascript:void(0);" class="view-all d-flex align-items-center">
                                    View All<span class="ps-2 d-flex align-items-center"><i data-feather="arrow-right"
                                            class="feather-16"></i></span>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless best-seller">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Order Details</th>
                                            <th>Sales</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $counter = 0;
                                        @endphp
                                        @foreach ($products as $product)
                                            @if ($product->quantity >= 10 && $product->quantity <= 20)
                                                @php
                                                    $counter++;
                                                @endphp
                                                <tr>
                                                    <td>{{ $counter }}</td>
                                                    <td>
                                                        <div class="product-info">
                                                            <a href="#" class="product-img">
                                                                <img src="{{ asset('uploads/product/products/' . $product->image) }}"
                                                                    alt="product" style="border-radius: 50%;">
                                                            </a>
                                                            <div class="info">
                                                                <a href="#">{{ $product->name }}</a>
                                                                <p class="dull-text">${{ $product->price }}</p>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <p class="head-text">Sales</p>
                                                        {{ $product->sales->sum('quantity') }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach


                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-xl-8 d-flex">
                    <div class="card flex-fill default-cover w-100 mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Recent Transactions</h4>
                            <div class="dropdown">
                                <a href="javascript:void(0);" class="view-all d-flex align-items-center">
                                    View All<span class="ps-2 d-flex align-items-center"><i data-feather="arrow-right"
                                            class="feather-16"></i></span>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless recent-transactions">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Order Details</th>
                                            <th>Request</th>
                                            <th>Status</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentTransactions as $key => $transaction)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    <div class="product-info">
                                                        <a href="#" class="product-img">
                                                            <img src="{{ asset('uploads/product/products/' . $transaction->product->image) }}"
                                                                style="border-radius: 50%;" alt="product">
                                                        </a>
                                                        <div class="info">
                                                            <a href="#">{{ $transaction->product->name }}</a>
                                                            <span class="dull-text d-flex align-items-center"><i
                                                                    data-feather="clock" class="feather-14"></i>
                                                                {{ $transaction->created_at->diffForHumans() }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="d-block head-text">
                                                        @if ($transaction->customer_id)
                                                            {{ $transaction->customer->customer_name }}
                                                        @elseif ($transaction->user_id)
                                                            {{ $transaction->salesuser->username }}
                                                        @else
                                                            No customer or user associated
                                                        @endif
                                                    </span>
                                                    <span class="text-blue">#{{ $transaction->receipt }}</span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badges bg-{{ $transaction->salesOrder->status === 'Completed' ? 'lightgreen' : 'danger' }}"
                                                        style="font-family: cursive;font-size: 12px">{{ $transaction->salesOrder->status }}</span>
                                                </td>
                                                <td>${{ $transaction->salesOrder->total_dollar }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row sales-board">
                <div class="col-lg-7 col-sm-12 col-12 ">
                    <div class="card flex-fill" style="height: 100%">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Purchase & Sales</h5>
                            <div class="graph-sets">
                                <ul>
                                    <li>
                                        <span>Sales</span>
                                    </li>
                                    <li>
                                        <span>Purchase</span>
                                    </li>
                                </ul>
                                <div class="dropdown">
                                    <button class="btn btn-white btn-sm dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ end($years) }} <img src="assets/img/icons/dropdown.svg" alt="img"
                                            class="ms-2">
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @foreach ($years as $year)
                                            <li>
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item">{{ $year }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                            <div id="sales_charts"></div>
                        </div>
                        <script>
                            var salesData = {!! json_encode($salesDataIndexed) !!};
                            var purchaseData = {!! json_encode($purchaseDataIndexed) !!};
                            var months = {!! json_encode(array_keys($salesData)) !!}; // Assuming $salesData will have all months
                        </script>

                    </div>
                </div>
                <div class="col-lg-5 col-sm-12 col-12 ">
                    <div class="card" id="card" style="height: 100%;">
                        <div class="card-header">
                            <h5 class="card-title">Radial Chart Count All</h5>
                        </div>
                        <div class="card-body" id="card-body"
                            style="width: 400px;padding-top: 0px;justify-content: center;padding: 20px">
                            <div id="radial-chart" class="chart-set"></div>
                        </div>
                    </div>

                    <script>
                        var total = {!! json_encode($total) !!};

                        var salecount = {!! json_encode($salecount) !!};
                        var saleReturncount = {!! json_encode($saleReturncount) !!};
                        var purchasecount = {!! json_encode($purchasecount) !!};
                    </script>
                </div>
            </div>
        </div>
    </div>





@endsection
@section('custom-js')

    <script src="dashboard/assets/js/theme-script.js" type="0b97a43b091998887bbc89c4-text/javascript"></script>


    <script src="dashboard/assets/plugins/apexchart/apexcharts.min.js" type="0b97a43b091998887bbc89c4-text/javascript"></script>
    <script src="dashboard/assets/plugins/apexchart/chart-data.js" type="0b97a43b091998887bbc89c4-text/javascript"></script>

@endsection
