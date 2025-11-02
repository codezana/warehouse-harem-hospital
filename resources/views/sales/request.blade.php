<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Warehouse Harem Hospital">
    <title>Request - Warehouse Harem Hospital</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/harem.png') }}">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="{{ asset('assets/request/assets/css/vendor.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/request/assets/css/app.min.css') }}" rel="stylesheet">
    <style>
        .toastify-custom {
            border-radius: 10px;
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


<body class="pace-top">

    <div id="app" class="app app-content-full-height app-without-sidebar app-without-header">

        <div id="content" class="app-content p-0">

            <div class="pos pos-with-menu pos-with-sidebar" id="pos">
                <div class="pos-container">

                    <div class="pos-menu">

                        <div class="logo">



                            <!-- Logo -->
                            @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('cashier'))
                                <a href="./home">
                                    <div class="logo-img"><i class="fa-solid fa-code-pull-request"></i></div>
                                    <div class="logo-text">Request Order</div>
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}">
                                    <div class="logo-img"><i class="fa-solid fa-code-pull-request"></i></div>
                                    <div class="logo-text">Request Order</div>
                                </a>
                            @endif

                        </div>


                        <div class="nav-container">
                            <div class="h-100" data-scrollbar="true" data-skip-mobile="true">
                                <ul class="nav nav-tabs">
                                    @foreach ($categories as $key => $category)
                                        <li class="nav-item">
                                            <a class="nav-link " href="#" data-filter="{{ $category->name }}">
                                                @php
                                                    $icons = [
                                                        'fa-virus-covid',
                                                        'fa-hand-holding-droplet',
                                                        'fa-capsules',
                                                        'fa-stethoscope',
                                                        'fa-dna',
                                                        'fa-microscope',
                                                        'fa-heartbeat',
                                                        'fa-syringe',
                                                        'fa-briefcase-medical',
                                                        'fa-tractor-trailer',
                                                    ];
                                                    $iconIndex = $key % count($icons);
                                                @endphp
                                                <i class="fa-solid {{ $icons[$iconIndex] }}"></i>


                                                {{ $category->name }}
                                            </a>
                                        </li>
                                    @endforeach

                                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                    <script>
                                        $(document).ready(function() {
                                            $('.nav-link').on('click', function(e) {
                                                e.preventDefault(); // Prevent default link behavior

                                                // Remove 'active' class from all links
                                                $('.nav-link').removeClass('active');

                                                // Add 'active' class to the clicked link
                                                $(this).addClass('active');

                                                // Get the data-filter attribute value of the clicked link
                                                var filter = $(this).data('filter');

                                                // Perform actions with the filter value, for example:
                                                // You can use 'filter' value to filter content based on the category
                                                // console.log('Filter:', filter);

                                                // Or you can redirect to a specific page related to the category
                                                // window.location.href = '/category/' + filter;
                                            });
                                        });
                                    </script>

                                </ul>
                            </div>
                        </div>

                    </div>

                    <div class="pos-content">
                        <div class="pos-content-container h-100">
                            <div class="row gx-4">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="fas fa-barcode"></i> <!-- Font Awesome barcode icon -->
                                    </span>
                                    <input type="search" class="form-control" id="barcodeInput"
                                        placeholder="Scan or enter barcode">
                                </div>










                                @foreach ($categories as $category)
                                    @foreach ($category->products as $product)
                                        @if ($product->quantity > 0)
                                            <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-4 col-sm-6 pb-4"
                                                data-type="{{ $category->name }}">
                                                <a href="#" class="pos-product" data-bs-toggle="modal"
                                                    data-bs-target="#modalPosItem-{{ $product->id }}">
                                                    <div class="img"
                                                        style="background-image: url({{ asset('uploads/product/products/' . $product->image) }})">
                                                    </div>
                                                    <div class="info">
                                                        <div class="barcode" style="display: none">
                                                            {{ $product->barcode }}</div>
                                                        <div class="title">{{ $product->name }}</div>
                                                        {{-- <div class="desc">{{ $product->description }}</div> --}}
                                                        <div class="price">{{ $product->quantity }}
                                                            {{ $product->type->type_name }}
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @else
                                            <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-4 col-sm-6 pb-4"
                                                data-type="{{ $category->name }}">
                                                <div class="pos-product not-available">
                                                    <div class="img"
                                                        style="background-image: url({{ asset('uploads/product/products/' . $product->image) }})">
                                                    </div>
                                                    <div class="info">
                                                        <div class="title">{{ $product->name }}</div>
                                                        <div class="desc">{{ $product->description }} </div>
                                                        <div class="price">${{ sprintf('%0.2f', $product->price) }}
                                                        </div>
                                                    </div>
                                                    <div class="not-available-text">
                                                        <div>Not Available</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endforeach









                            </div>
                        </div>
                    </div>



                    <div class="pos-sidebar" id="pos-sidebar">
                        <div class="h-100 d-flex flex-column p-0">

                            <div class="pos-sidebar-header">
                                <div class="back-btn">
                                    <button type="button" data-toggle-class="pos-mobile-sidebar-toggled"
                                        data-toggle-target="#pos" class="btn">
                                        <i class="fa fa-chevron-left"></i>

                                    </button>
                                </div>
                                <div class="icon"><i class="fa-solid fa-capsules"></i></div>
                                <div class="title">Table {{ $formattedCount2 }}</div>
                                <div class="order small">Order: <span class="fw-semibold">#{{ $formattedCount }}</span>
                                </div>
                            </div>


                            <div class="pos-sidebar-nav small">
                                <ul class="nav nav-tabs nav-fill">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="neworder" href="#" data-bs-toggle="tab"
                                            data-bs-target="#newOrderTab">New Order (0)</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" data-bs-toggle="tab"
                                            data-bs-target="#orderHistoryTab">Order History (0)</a>
                                    </li>
                                </ul>
                            </div>

                            <form action="{{ route('submitOrder') }}" method="POST" style="height: 65%;">
                                @csrf


                                <div class="pos-sidebar-body tab-content" data-scrollbar="true" data-height="100%">

                                    <div class="tab-pane fade h-100 show active" id="newOrderTab">
                                        <div class="h-100 d-flex align-items-center justify-content-center text-center p-20"
                                            id="newOrderItems">
                                            <div>
                                                <div class="mb-3 mt-n5">


                                                    <svg xmlns="http://www.w3.org/2000/svg" width="6em"
                                                        height="6em" viewBox="0 0 640 512" class="text-gray-300"
                                                        fill="currentColor">
                                                        <path
                                                            d="M112 0C85.5 0 64 21.5 64 48V96H16c-8.8 0-16 7.2-16 16s7.2 16 16 16H64 272c8.8 0 16 7.2 16 16s-7.2 16-16 16H64 48c-8.8 0-16 7.2-16 16s7.2 16 16 16H64 240c8.8 0 16 7.2 16 16s-7.2 16-16 16H64 16c-8.8 0-16 7.2-16 16s7.2 16 16 16H64 208c8.8 0 16 7.2 16 16s-7.2 16-16 16H64V416c0 53 43 96 96 96s96-43 96-96H384c0 53 43 96 96 96s96-43 96-96h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V288 256 237.3c0-17-6.7-33.3-18.7-45.3L512 114.7c-12-12-28.3-18.7-45.3-18.7H416V48c0-26.5-21.5-48-48-48H112zM544 237.3V256H416V160h50.7L544 237.3zM160 368a48 48 0 1 1 0 96 48 48 0 1 1 0-96zm272 48a48 48 0 1 1 96 0 48 48 0 1 1 -96 0z" />
                                                    </svg>
                                                </div>
                                                <h5>No order Added</h5>
                                            </div>
                                        </div>





                                    </div>


                                    <div class="tab-pane fade h-100" id="orderHistoryTab">
                                        <div
                                            class="h-100 d-flex align-items-center justify-content-center text-center p-20">
                                            <div>
                                                <div class="mb-3 mt-n5">
                                                    <svg width="6em" height="6em" viewBox="0 0 16 16"
                                                        class="text-gray-300" fill="currentColor"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M14 5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5zM1 4v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4H1z" />
                                                        <path
                                                            d="M8 1.5A2.5 2.5 0 0 0 5.5 4h-1a3.5 3.5 0 1 1 7 0h-1A2.5 2.5 0 0 0 8 1.5z" />
                                                    </svg>
                                                </div>
                                                <h5>No order history found</h5>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <div class="pos-sidebar-footer"
                                    style="position: absolute;
                                           bottom: 0;
                                           width:100%">

                                    <hr class="opacity-1 my-10px">
                                    <div class="d-flex align-items-center mb-2">
                                        <div>Total</div>
                                        <div id="total" class="flex-1 text-end h4 mb-0">0</div>
                                    </div>
                                    <div class="mt-3">
                                        <div class="d-flex">

                                            <button type="submit" id="submitOrderBtn"
                                                class="btn btn-theme flex-fill d-flex align-items-center justify-content-center">
                                                <span>
                                                    <i class="fa fa-cash-register fa-lg my-10px d-block"></i>
                                                    <span class="small fw-semibold">Submit Order</span>
                                                </span>
                                            </button>

                            </form>


                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    </div>


    <a href="#" class="pos-mobile-sidebar-toggler" data-toggle-class="pos-mobile-sidebar-toggled"
        data-toggle-target="#pos">
        <i class="fa fa-shopping-bag"></i>
        <span id="orderBadge" class="badge">0</span>
    </a>


    </div>


    <div class="theme-panel">
        <a href="javascript:;" data-click="theme-panel-expand" class="theme-collapse-btn"><i
                class="fa fa-cog"></i></a>
        <div class="theme-panel-content">
            <ul class="theme-list clearfix">
                <li><a href="javascript:;" class="bg-red" data-theme="theme-red" data-click="theme-selector"
                        data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body"
                        data-bs-title="Red" data-original-title title>&nbsp;</a></li>
                <li><a href="javascript:;" class="bg-pink" data-theme="theme-pink" data-click="theme-selector"
                        data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body"
                        data-bs-title="Pink" data-original-title title>&nbsp;</a></li>
                <li><a href="javascript:;" class="bg-orange" data-theme="theme-orange" data-click="theme-selector"
                        data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body"
                        data-bs-title="Orange" data-original-title title>&nbsp;</a></li>
                <li><a href="javascript:;" class="bg-yellow" data-theme="theme-yellow" data-click="theme-selector"
                        data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body"
                        data-bs-title="Yellow" data-original-title title>&nbsp;</a></li>
                <li><a href="javascript:;" class="bg-lime" data-theme="theme-lime" data-click="theme-selector"
                        data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body"
                        data-bs-title="Lime" data-original-title title>&nbsp;</a></li>
                <li><a href="javascript:;" class="bg-green" data-theme="theme-green" data-click="theme-selector"
                        data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body"
                        data-bs-title="Green" data-original-title title>&nbsp;</a></li>
                <li><a href="javascript:;" class="bg-teal" data-theme="theme-teal" data-click="theme-selector"
                        data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body"
                        data-bs-title="Teal" data-original-title title>&nbsp;</a></li>
                <li><a href="javascript:;" class="bg-cyan" data-theme="theme-cyan" data-click="theme-selector"
                        data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body"
                        data-bs-title="Aqua" data-original-title title>&nbsp;</a></li>
                <li class="active"><a href="javascript:;" class="bg-blue" data-theme data-click="theme-selector"
                        data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body"
                        data-bs-title="Default" data-original-title title>&nbsp;</a></li>
                <li><a href="javascript:;" class="bg-purple" data-theme="theme-purple" data-click="theme-selector"
                        data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body"
                        data-bs-title="Purple" data-original-title title>&nbsp;</a></li>
                <li><a href="javascript:;" class="bg-indigo" data-theme="theme-indigo" data-click="theme-selector"
                        data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body"
                        data-bs-title="Indigo" data-original-title title>&nbsp;</a></li>
                <li><a href="javascript:;" class="bg-gray-600" data-theme="theme-gray-600"
                        data-click="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-container="body" data-bs-title="Gray" data-original-title title>&nbsp;</a></li>
            </ul>
            <hr class="mb-0">
            <div class="row mt-10px pt-3px">
                <div class="col-9 control-label text-body-emphasis fw-bold">
                    <div>Dark Mode <span class="badge bg-theme text-theme-color ms-1 position-relative py-4px px-6px"
                            style="top: -1px"></span></div>
                    <div class="lh-sm fs-13px fw-semibold">
                        <small class="text-body-emphasis opacity-50">
                            Adjust the appearance to reduce glare and give your eyes a break.
                        </small>
                    </div>
                </div>
                <div class="col-3 d-flex">
                    <div class="form-check form-switch ms-auto mb-0 mt-2px">
                        <input type="checkbox" class="form-check-input" name="app-theme-dark-mode"
                            id="appThemeDarkMode" value="1">
                        <label class="form-check-label" for="appThemeDarkMode">&nbsp;</label>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <a href="#" data-click="scroll-top" class="btn-scroll-top fade"><i class="fa fa-arrow-up"></i></a>

    </div>
    @foreach ($categories as $category)
        @foreach ($category->products as $product)
            <div class="modal modal-pos fade" id="modalPosItem-{{ $product->id }}"
                data-type="{{ $category->name }}">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content border-0">
                        <a href="#" data-bs-dismiss="modal"
                            class="btn-close position-absolute top-0 end-0 m-4"></a>
                        <div class="modal-pos-product">

                            <div class="modal-pos-product-img">
                                <div class="img"
                                    style="background-image: url({{ asset('uploads/product/products/' . $product->image) }})">
                                </div>
                            </div>

                            <div class="modal-pos-product-info">
                                <div class="fs-4 fw-semibold">{{ $product->name }}</div>
                                <div class="text-body text-opacity-50 mb-2">
                                    {{ $product->description }}
                                </div>
                                <div class="fs-3 fw-bold mb-3">{{ $product->quantity }}
                                    {{ $product->type->type_name }}</div>
                                <div class="d-flex mb-3">
                                    <a href="#" class="btn btn-secondary"
                                        onclick="decreaseQuantity('{{ $product->id }}')"><i
                                            class="fa fa-minus"></i></a>
                                    <input type="text" class="form-control w-50px fw-bold mx-2 text-center"
                                        name="qty" id="quantity-{{ $product->id }}" value="1"
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                        oninput="validateQuantityInput(event, {{ $product->quantity }})">
                                    <a href="#" class="btn btn-secondary"
                                        onclick="increaseQuantity('{{ $product->id }}', {{ $product->quantity }})"><i
                                            class="fa fa-plus"></i></a>

                                </div>
                                <hr class="opacity-1">
                                <div class="mb-2">
                                    <div class="fw-bold">Size:</div>
                                    <div class="option-list">






                                        @if ($product->productSizes->isNotEmpty())
                                            @foreach ($product->productSizes as $productSize)
                                                <div class="option">
                                                    <input type="radio"
                                                        id="size{{ $productSize->id }}-{{ $product->id }}"
                                                        name="size-{{ $product->id }}"
                                                        value="{{ $productSize->size->name }}" class="option-input">
                                                    <label class="option-label"
                                                        for="size{{ $productSize->id }}-{{ $product->id }}">
                                                        <span
                                                            class="option-text">{{ $productSize->size->name }}</span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        @endif


                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <a href="#" class="btn btn-default fw-semibold mb-0 d-block py-3"
                                            data-bs-dismiss="modal">Cancel</a>
                                    </div>
                                    <div class="col-8">
                                        <a href="#"
                                            class="btn btn-theme fw-semibold d-flex justify-content-center align-items-center py-3 m-0"
                                            onclick="addToOrder('{{ $product->id }}', '{{ $product->name }}', '{{ $product->price }}', '{{ $product->size }}', 1, {{ $product->quantity }}, '{{ $product->type->type_name }}', '{{ asset('uploads/product/products/' . $product->image) }}')">
                                            Add to cart <i class="fa fa-plus ms-2 my-n3"></i>
                                        </a>



                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    function increaseQuantity(productId, maxQuantity) {
                        var quantityInput = document.getElementById('quantity-' + productId);
                        var newQuantity = parseInt(quantityInput.value) + 1;

                        // Check if the new quantity is less than or equal to the maximum quantity before updating
                        if (newQuantity <= maxQuantity) {
                            quantityInput.value = newQuantity;
                        }
                    }

                    function decreaseQuantity(productId) {
                        var quantityInput = document.getElementById('quantity-' + productId);
                        var newQuantity = parseInt(quantityInput.value) - 1;

                        // Check if the new quantity is greater than or equal to 1 before updating
                        if (newQuantity >= 1) {
                            quantityInput.value = newQuantity;
                        }
                    }

                    function validateQuantityInput(event, maxQuantity) {
                        var inputElement = event.target;
                        var enteredValue = parseInt(inputElement.value);

                        // Check if the entered value is within the valid range
                        if (enteredValue < 1 || enteredValue > maxQuantity) {
                            // Reset the input value to the current quantity if it's outside the valid range
                            inputElement.value = inputElement.defaultValue;
                        }
                    }
                </script>
            </div>
        @endforeach
    @endforeach






    <script>
        // Assuming you have a global variable to store the order items
        var orderItems = [];

        function addToOrder(productId, productName, productPrice, productSize, productQuantity, availableQuantity,
            productType,
            productImage) {
            // Get product details based on parameters
            var quantityInput = document.getElementById('quantity-' + productId);
            var productQuantity = parseInt(quantityInput.value);
            let checkedSize = document.querySelector(`input[name="size-${productId}"]:checked`);
            let sizeChecked = checkedSize ? checkedSize.value : null;
            var productDetails = {
                id: productId,
                name: productName,
                price: productPrice,
                size: sizeChecked,
                quantity: productQuantity || 1, // Default to 1 if productQuantity is not provided 
                availableQuantity: availableQuantity,
                type: productType,
                imgurl: productImage
            };

            // Check if the product is already in the order
            var existingItem = orderItems.find(item => item.id === productId);

            if (existingItem) {
                // If the product is already in the order, increase the quantity
                if (existingItem.quantity < existingItem.availableQuantity) {
                    existingItem.quantity++;
                }
            } else {
                // If the product is not in the order, add it
                orderItems.push(productDetails);
            }

            // Close the modal after adding the product
            $('#modalPosItem-' + productId).modal('hide');

            // Call a function to update the displayed order on the POS sidebar
            updateOrderDisplay();

            // Call a function to update the total and other order-related information in the POS sidebar
            updateOrderSummary();
            updateOrderBadge();

        }
        console.log(orderItems);
        // Function to decrease the quantity of an item in the order
        function decreaseOrderQuantity(productId) {
            var item = orderItems.find(item => item.id === productId);

            if (item && item.quantity > 1) {
                item.quantity--;
            }

            updateOrderDisplay();
        }

        // Function to increase the quantity of an item in the order
        function increaseOrderQuantity(productId) {
            var item = orderItems.find(item => item.id === productId);

            // Check if the increased quantity is less than or equal to the available quantity
            if (item && item.quantity < item.availableQuantity) {
                item.quantity++;
            }

            updateOrderDisplay();
        }

        // Function to validate the quantity input for an item in the order
        function validateQuantityInput(event, maxQuantity) {
            var inputElement = event.target;
            var enteredValue = parseInt(inputElement.value);
            if (enteredValue) {
                let newQty = Math.min(Math.max(enteredValue, 1), maxQuantity);
                inputElement.value = newQty;
            } else {
                inputElement.value = 0;
            }
        }

        // Function to remove an item from the order
        function removeFromOrder(productId) {
            orderItems = orderItems.filter(item => item.id !== productId);
            updateOrderDisplay();
            updateOrderBadge();

        }

        // Function to update the displayed order on the POS sidebar


        function updateOrderDisplay() {
            var orderList = document.getElementById('newOrderTab');
            orderList.innerHTML = '';


            if (orderItems.length === 0) {
                // Display the "No order added" message
                var noOrderHtml = `
            <div class="h-100 d-flex align-items-center justify-content-center text-center p-20">
                <div>
                    <div class="mb-3 mt-n5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="6em" height="6em"
                            viewBox="0 0 640 512" class="text-gray-300" fill="currentColor">
                            <path
                                d="M112 0C85.5 0 64 21.5 64 48V96H16c-8.8 0-16 7.2-16 16s7.2 16 16 16H64 272c8.8 0 16 7.2 16 16s-7.2 16-16 16H64 48c-8.8 0-16 7.2-16 16s7.2 16 16 16H64 240c8.8 0 16 7.2 16 16s-7.2 16-16 16H64 16c-8.8 0-16 7.2-16 16s7.2 16 16 16H64 208c8.8 0 16 7.2 16 16s-7.2 16-16 16H64V416c0 53 43 96 96 96s96-43 96-96H384c0 53 43 96 96 96s96-43 96-96h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V288 256 237.3c0-17-6.7-33.3-18.7-45.3L512 114.7c-12-12-28.3-18.7-45.3-18.7H416V48c0-26.5-21.5-48-48-48H112zM544 237.3V256H416V160h50.7L544 237.3zM160 368a48 48 0 1 1 0 96 48 48 0 1 1 0-96zm272 48a48 48 0 1 1 96 0 48 48 0 1 1 -96 0z" />
                        </svg>
                    </div>
                    <h5>No order Added</h5>
                </div>
            </div>
        `;
                orderList.innerHTML = noOrderHtml;
            } else {

                orderItems.forEach(function(item) {
                    var orderHtml = `
            <div class="pos-order">
                <div class="pos-order-product">
                    <div class="img" style="background-image: url(${item.imgurl})"></div>
                    <div class="flex-1">
                        <div class="h6 mb-1" id="product_name">${item.name}</div>
                        ${item.size ? `<div class="small" style="margin-bottom: 10px">${item.size}</div>` : `<br>`}
                        <div class="d-flex">
                            <a href="#" class="btn btn-secondary btn-sm" onclick="decreaseOrderQuantity('${item.id}')"><i class="fa fa-minus"></i></a>
                            <input onClick="inputs();" data-id="${item.id}" type="text" id="qty" class="form-control w-50px form-control-sm mx-2 bg-white bg-opacity-25 bg-white bg-opacity-25 text-center" value="${item.quantity}">
                            <a href="#" class="btn btn-secondary btn-sm" onclick="increaseOrderQuantity('${item.id}', ${item.availableQuantity})"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </div>
                <div class="pos-order-price d-flex flex-column">
                    <div class="availableQuantity flex-1">${item.availableQuantity} ${item.type}</div>
                    <div class="text-end">
                        <a href="#" class="btn btn-default btn-sm" onclick="removeFromOrder('${item.id}')"><i class="fa fa-trash"></i></a>
                    </div>
                </div>
            </div>
        `;
                    orderList.innerHTML += orderHtml;
                });
            }

            updateOrderSummary();
        }



        function updateOrderBadge() {
            var totalOrders = orderItems.length; // Count the number of unique products in the order
            var badgeElement = document.getElementById('orderBadge');

            // Update the badge with the total number of orders
            badgeElement.textContent = totalOrders;

            // Update the tab link text with the total number of orders in parentheses
            var tabLinkElement = document.getElementById('neworder');
            tabLinkElement.textContent = 'New Order (' + totalOrders + ')';
            // You can also hide the badge if there are no items in the order
            badgeElement.style.display = totalOrders > 0 ? 'inline-block' : 'none';
        }


        function updateOrderSummary() {
            // Assuming you have DOM elements to display total

            var totalElement = document.getElementById('total');

            // Check if the elements are found before updating
            if (totalElement) {
                // Calculate subtotal
                var subtotal = orderItems.reduce((total, item) => total + item.quantity, 0);

                // Calculate total
                var total = subtotal;

                // Update the displayed values
                totalElement.textContent = `${total} Pcs`;
            }
        }
    </script>

    <!-- Include the Toastify library -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        // Add an event listener to the "Submit Order" button
        $(document).ready(function() {
            $('#submitOrderBtn').click(function() {
                submitOrder();

            });
        });

        let addSubmit = document.querySelector('#submitOrderBtn');
        addSubmit.addEventListener('click', (e) => {
            e.preventDefault();
        });


        let orderData = [];

        // Function to submit the order
        function submitOrder() {
            if (orderItems.length > 0) {
                document.querySelectorAll('.pos-order').forEach(element => {
                    var product_id = element.querySelector('#product_name').textContent.trim();
                    var qty = element.querySelector('#qty').value.trim();
                    var sizeElement = element.querySelector('.small');
                    var size = sizeElement ? sizeElement.textContent.trim() : null; // Get size if it exists

                    var orderItem = {
                        product_id: product_id,
                        qty: qty
                    };

                    // Only add size property if it's not null
                    if (size !== null) {
                        orderItem.size = size;
                    }

                    orderData.push(orderItem);
                });

                console.log(orderData);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('submitOrder') }}',
                    data: {
                        orderData: orderData,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Display a customized toast notification with an icon at the top left corner
                        Toastify({
                            text: 'Request sent successfully !',
                            duration: 2000,
                            gravity: 'top-left', // Position the toast notification at the top left corner
                            close: true, // Show a close button
                            backgroundColor: 'linear-gradient(to right, #01919C, #2B2B2B)', // Custom background color
                            className: 'toastify-custom', // Custom CSS class for styling
                        }).showToast();

                        // Refresh the page after a delay
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000); // Adjust the delay as needed
                    },
                    error: function(error) {

                        console.error(error);
                        // Handle error response here
                    }
                });
            } else {
                Toastify({
                    text: 'Add More Than One Item!',
                    duration: 2000,
                    position: 'center',
                    gravity: 'top-left', // Position the toast notification at the top left corner
                    close: true, // Show a close button
                    backgroundColor: 'linear-gradient(to right, #e73e3e, e96060)', // Custom background color
                    className: 'toastify-custom', // Custom CSS class for styling
                }).showToast();
            }

            let noOrder = `
                <div class="h-100 d-flex align-items-center justify-content-center text-center p-20" id="newOrderItems">
                    <div>
                        <div class="mb-3 mt-n5">


                            <svg xmlns="http://www.w3.org/2000/svg" width="6em"
                                height="6em" viewBox="0 0 640 512" class="text-gray-300"
                                fill="currentColor">
                                <path
                                    d="M112 0C85.5 0 64 21.5 64 48V96H16c-8.8 0-16 7.2-16 16s7.2 16 16 16H64 272c8.8 0 16 7.2 16 16s-7.2 16-16 16H64 48c-8.8 0-16 7.2-16 16s7.2 16 16 16H64 240c8.8 0 16 7.2 16 16s-7.2 16-16 16H64 16c-8.8 0-16 7.2-16 16s7.2 16 16 16H64 208c8.8 0 16 7.2 16 16s-7.2 16-16 16H64V416c0 53 43 96 96 96s96-43 96-96H384c0 53 43 96 96 96s96-43 96-96h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V288 256 237.3c0-17-6.7-33.3-18.7-45.3L512 114.7c-12-12-28.3-18.7-45.3-18.7H416V48c0-26.5-21.5-48-48-48H112zM544 237.3V256H416V160h50.7L544 237.3zM160 368a48 48 0 1 1 0 96 48 48 0 1 1 0-96zm272 48a48 48 0 1 1 96 0 48 48 0 1 1 -96 0z" />
                            </svg>
                        </div>
                        <h5>No order Added</h5>
                    </div>
                </div>
                `;

            $('#newOrderTab').html(noOrder);
            orderItems = [];
            updateOrderBadge();
            updateOrderDisplay();
            updateOrderSummary();
        }

        function inputs() {
            let inputQtys = document.querySelectorAll('#qty');
            inputQtys.forEach(inputQty => {
                inputQty.addEventListener('input', () => {
                    let qtyInput = parseInt(inputQty.value);
                    let maxQuantity = parseInt(inputQty.parentNode.parentNode.parentNode.parentNode
                        .querySelector('.availableQuantity').textContent.replace('Pcs', '').trim());

                    // Ensure that the input value is a valid number
                    if (!isNaN(qtyInput)) {
                        // Adjust the input value based on available quantity
                        let newQty = Math.min(Math.max(qtyInput, 0), maxQuantity);
                        inputQty.value = newQty;

                        // Update the quantity in the orderItems array
                        let productId = inputQty.getAttribute('data-id');
                        let item = orderItems.find(item => item.id === productId);
                        if (item) {
                            item.quantity = newQty;
                        } else {
                            console.error('Item not found in orderItems array.');
                        }
                    } else {
                        // Reset input value to 0 if it's not a valid number
                        inputQty.value = 0;
                    }
                    updateOrderSummary();
                });
            });
        }
    </script>

    {{-- find product by search --}}

    <script>
        let searchInput = document.querySelector('#barcodeInput');
        let infos = document.querySelectorAll('.info');

        searchInput.addEventListener('input', e => {
            let inputValue = e.target.value
                .toLowerCase(); // Get the input value and convert it to lowercase for case-insensitive comparison
            infos.forEach(info => {
                let title = info.querySelector('.title');
                let barcode = info.querySelector('.barcode');
                if (title.textContent.toLowerCase().includes(inputValue) || barcode.textContent
                    .toLowerCase().includes(inputValue)) {
                    title.parentNode.parentNode.parentNode.style.display = 'block';
                } else {
                    title.parentNode.parentNode.parentNode.style.display = 'none';
                }
            });
        });
    </script>
    <script src="{{ asset('assets/request/assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/request/assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/request/assets/js/demo/pos-customer-order.demo.js') }}"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-Y3Q0VGQKY3"></script>



</body>

</html>
