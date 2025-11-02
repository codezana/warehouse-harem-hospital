@extends('layouts.nav')

@section('name', 'Product Details')
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/owlcarousel/owl.carousel.min.css') }}">


@endsection
@section('content')

    <style>
        .printimg {
            position: absolute;
            left: 211px;
            padding: 10px;
        }
    </style>


<div class="page-wrapper page-wrapper-one">
    <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Product Details</h4>
                    <h6>Full details of a product</h6>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="bar-code-view">
                                @php
                                    $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
                                    $barcodeImage = $generatorPNG->getBarcode($product->barcode, $generatorPNG::TYPE_CODE_128);
                                @endphp

                                <img src="data:image/png;base64,{{ base64_encode($barcodeImage) }}" alt="barcode"
                                    style="height: 55px;width: 160px;margin-top: -7px">
                                <br>
                                <span class="barcode-number"
                                    style="position: absolute;
                                margin-right: 25px;
                                margin-bottom: -73px;
                                font-weight: bolder;">No:
                                    {{ $product->barcode }}</span>

                                <a class="printimg" href="{{ route('print.product', ['productId' => $product->id]) }}" target="_blank">
                                    <img src="{{ asset('assets/img/icons/printer.svg') }}"  alt="print">
                                </a>
                            </div>








                            <div class="productdetails">
                                <ul class="product-bar">
                                    <li>
                                        <h4>Product Type</h4>
                                        <h6>{{ $product->product_type }}</h6>
                                    </li>
                                    <li>
                                        <h4>Product</h4>
                                        <h6>{{ $product->name }}</h6>
                                    </li>
                                    <li>
                                        <h4>Category</h4>
                                        <h6>{{ $product->category ? $product->category->name : 'N/A' }}</h6>
                                    </li>
                                    <li>
                                        <h4>Sub Category</h4>
                                        <h6>{{ $product->subcategory ? $product->subcategory->name : 'N/A' }}</h6>
                                    </li>
                                    <li>
                                        <h4>Brand</h4>
                                        <h6>{{ $product->brand ? $product->brand->name : 'N/A' }}</h6>
                                    </li>
                              
                                    <li>
                                        <h4>SKU</h4>
                                        <h6>{{ $product->sku_code }}</h6>
                                    </li>
                                    <li>
                                        <h4>Minimum Qty</h4>
                                        <h6>{{ $product->minimum_qty }}</h6>
                                    </li>
                                    <li>
                                        <h4>Quantity</h4>
                                        <h6>{{ $product->quantity }} {{ $product->type->type_name }}</h6>
                                    </li>
                                    <li>
                                        <h4>Price</h4>
                                        <h6>${{ $product->price }}</h6>
                                    </li>
                                    <li>
                                        <h4>Sale Price</h4>
                                        <h6>${{ $product->sale }}</h6>
                                    </li>
                                
                                    <li>
                                        <h4>Description</h4>
                                        <h6>{{ $product->description }}</h6>
                                    </li>
                                    <li>
                                        <h4>Product Size</h4>
                                        <h6>
                                            @foreach ($product->productSizes as $key => $productSize)
                                                {{ $productSize->size->name }}
                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </h6>
                                        
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="slider-product-details">
                                <div class="owl-carousel owl-theme product-slide">
                                    <div class="slider-product">
                                        <img src="{{ asset('uploads/product/products/' . $product->image) }}"
                                            alt="img">
                                        <h4>{{ $product->image }}</h4>
                                        <h6>
                                            @if ($product->image)
                                                @php
                                                    $imagePath = public_path($product->image_path);
                                                @endphp

                                                @if (file_exists($imagePath))
                                                    <h6>{{ formatBytes(filesize($imagePath)) }}</h6>
                                                @else
                                                    <p>Image file not found.</p>
                                                @endif
                                            @else
                                                <p>No image available.</p>
                                            @endif
                                        </h6>
                                    </div>
                                    <div class="slider-product">
                                        <img src="{{ asset('uploads/product/products/' . $product->image) }}"
                                            alt="img">
                                        <h4>{{ $product->image }}</h4>
                                        <h6>
                                            @if ($product->image)
                                                @php
                                                    $imagePath = public_path($product->image_path);
                                                @endphp

                                                @if (file_exists($imagePath))
                                                    <h6>{{ formatBytes(filesize($imagePath)) }}</h6>
                                                @else
                                                    <p>Image file not found.</p>
                                                @endif
                                            @else
                                                <p>No image available.</p>
                                            @endif
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
@section('custom-js')



    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/owlcarousel/owl.carousel.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>
@endsection
