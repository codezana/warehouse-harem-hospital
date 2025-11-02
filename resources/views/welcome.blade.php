@extends('layouts.nav')

@section('name', 'WareHouse Harem Hospital')
@section('content')

    <div class="page-wrapper page-wrapper-one">
        <div class="content">


            <div class="row">
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="dash-widget">
                        <div class="dash-widgetimg">
                            <span><img src="assets/img/icons/handdue.svg" alt="img"></span>
                        </div>
                        <div class="dash-widgetcontent">
                            <h5>$<span class="counters" data-count="{{ $totalPurchaseDue }}">${{ $totalPurchaseDue }}</span></h5>
                            <h6>Total Purchase Due</h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="dash-widget dash1">
                        <div class="dash-widgetimg">
                            <span><img src="assets/img/icons/hand.svg" alt="img"></span>
                        </div>
                        <div class="dash-widgetcontent">
                            <h5>$<span class="counters" data-count="{{ $totalSaleseDue }}">${{ $totalSaleseDue }}</span></h5>
                            <h6>Total Sales Due</h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="dash-widget dash2">
                        <div class="dash-widgetimg">
                            <span><img src="assets/img/icons/qty.svg" alt="img"></span>
                        </div>
                        <div class="dash-widgetcontent">
                            <h5><span class="counters" data-count="{{ $totalQuantitySold }}">${{ $totalQuantitySold }}</span></h5>
                            <h6>Total Quantity Sold</h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="dash-widget dash3">
                        <div class="dash-widgetimg">
                            <span><img src="assets/img/icons/coins.svg" alt="img"></span>
                        </div>
                        <div class="dash-widgetcontent">
                            <h5>$<span class="counters" data-count="{{ $totalSaleAmount }}">${{ $totalSaleAmount }}</span></h5>
                            <h6>Total Sale Amount</h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12 d-flex">
                    <div class="dash-count">
                        <div class="dash-counts">
                            <h4>{{ $customerCount }}</h4>
                            <h5>Customers</h5>
                        </div>
                        <div class="dash-imgs">
                            <img src="{{ asset('assets/img/icons/cu.svg') }}" alt>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12 d-flex">
                    <div class="dash-count das1">
                        <div class="dash-counts">
                            <h4>{{ $itemsCount }}</h4>
                            <h5>Products</h5>
                        </div>
                        <div class="dash-imgs">
                            <img src="{{ asset('assets/img/icons/items.svg') }}" alt>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12 d-flex">
                    <div class="dash-count das2">
                        <div class="dash-counts">
                            <h4>{{ $purchaseCount }}</h4>
                            <h5>Purchase Invoice</h5>
                        </div>
                        <div class="dash-imgs">
                            <img src="{{ asset('assets/img/icons/purchase.svg') }}" alt>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">
                            <h4>{{ $salesCount }}</h4>
                            <h5>Sales Invoice</h5>
                        </div>
                        <div class="dash-imgs">
                            <img src="{{ asset('assets/img/icons/sales.svg') }}" alt>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Button trigger modal -->

            <div class="row">
                <div class="col-lg-7 col-sm-12 col-12 d-flex">
                    <div class="card flex-fill">
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
                                        {{ end($years) }} <img src="assets/img/icons/dropdown.svg" alt="img" class="ms-2">
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @foreach($years as $year)
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item">{{ $year }}</a>
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
                <div class="col-lg-5 col-sm-12 col-12 d-flex">
                    <div class="card flex-fill">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Recently Added Products</h4>
                            <div class="dropdown">
                                <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false"
                                    class="dropset">
                                    <i class="fa fa-ellipsis-v"></i>
                                </a>


                                <ul class="dropdown-menu">
                                 
                                        <li>
                                            <a href="{{ route('productpage') }}"
                                                class="dropdown-item">
                                                <img src="assets/img/icons/add.svg" class="me-2"
                                                    alt="img">
                                                Add Prodcut
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('product.product.list') }}"
                                                class="dropdown-item"><img
                                                    src="assets/img/icons/eye.svg" class="me-2"
                                                    alt="img">Products</a>
                                        </li>
                                  
                             
                                   
                           
                                </ul>


                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive dataview">
                                <table class="table datatable ">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Products</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($recentlyAddedProducts as $key => $recentlyAddedProduct)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td class="productimgname">
                                                    <a href="{{ route('product.product.list') }}" class="product-img">
                                                        <img src="{{ asset('uploads/product/products/' . $recentlyAddedProduct->image) }}"
                                                            alt="product">
                                                    </a>
                                                    <a href="{{ route('product.product.list') }}">{{ $recentlyAddedProduct->name }}</a>
                                                </td>
                                                <td>{{ $recentlyAddedProduct->price }}</td>
                                            </tr>
                                        @endforeach



                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-0">
                <div class="card-body">
                    <h4 class="card-title">Expired Products</h4>
                    <div class="table-responsive dataview">
                        <table class="table datatable ">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Code</th>
                                    <th>Product Name</th>
                                    <th>Brand Name</th>
                                    <th>Category Name</th>
                                    <th>Expiry Date</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    use App\Models\Product;
                                    use Carbon\Carbon;

                                @endphp
                                @foreach ($expiringPurchases as $key => $expiringPurchase)
                                    @php

                                        $product = Product::find($expiringPurchase->product_id);
                                    @endphp

                                    @if ($product && $product->quantity > 0)
                                        @php
                                            $expireDate = Carbon::createFromFormat('Y-m-d', $expiringPurchase->expire_date);
                                            $remainingDays = $expireDate->diffInDays(\Carbon\Carbon::now());
                                        @endphp
                                        @if ($remainingDays >= 0 && $remainingDays <= 30)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td><a href="javascript:void(0);">{{ $product->sku_code }}</a></td>
                                                <td class="productimgname">
                                                    <a class="product-img" href="{{ route('product.product.list') }}">
                                                        <img src="{{ asset('uploads/product/products/' . $product->image) }}"
                                                            alt="product">
                                                    </a>
                                                    <a href="{{ route('product.product.list') }}">{{ $product->name }}</a>
                                                </td>
                                                <td>{{ $product->brand->name }}</td>
                                                <td>{{ $product->category->name }}</td>
                                                <td>{{ $expiringPurchase->expire_date }}</td>
                                            </tr>
                                        @endif
                                    @endif
                                @endforeach





                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
