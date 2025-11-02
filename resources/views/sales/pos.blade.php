@extends('sales.layout.navPos')

@section('content')
<div class="page-wrapper pos-pg-wrapper ms-0">
    <div class="content pos-design p-0">
        <div class="btn-row d-sm-flex align-items-center">

            <a class="btn btn-secondary mb-xs-3" data-bs-toggle="modal" data-bs-target="#orders"><span
                    class="me-1 d-flex align-items-center"><i data-feather="shopping-cart"
                        class="feather-16"></i></span>View Orders</a>

            <a id="resetButton" class="btn btn-info">
                <span class="me-1 d-flex align-items-center">
                    <i data-feather="rotate-cw" class="feather-16"></i>
                </span>
                Reset
            </a>
            
            <script>
                document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("resetButton").addEventListener("click", function() {
        location.reload(true); // Reload the page without using cache
    });
});

            </script>





            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#recents"><span
                    class="me-1 d-flex align-items-center"><i data-feather="refresh-ccw"
                        class="feather-16"></i></span>Transaction</a>
        </div>
        <div class="row align-items-start pos-wrapper">
            <div class="col-md-12 col-lg-8">
                <div class="tab pos-categories tabs_wrapper">
                    <h5 style="font-family:cursive;color: #007084">Categories</h5>
                    <p style="margin-bottom: 10px;font-family:'Times New Roman', Times, serif;">Select From Below
                        Categories</p>
                    <ul class="tab owl-carousel pos-category">
                        @php
                        use App\Models\Category;

                        @endphp
                        @foreach ($distinctCategories as $key => $category_id)
                        @php
                        $category = Category::find($category_id);
                        @endphp
                        <li id="{{ $category->id }}" data-tab="{{ $category_id }}" style="width: 100%">
                            <a>
                                @switch($key)
                                @case(0)
                                <img src="{{ asset('assets/pos/assets/img/categories/hospital.png') }}" alt="Category">
                                @break

                                @case(1)
                                <img src="{{ asset('assets/pos/assets/img/categories/surgery-room.png') }}"
                                    alt="Category1">
                                @break

                                @case(2)
                                <img src="{{ asset('assets/pos/assets/img/categories/3.png') }}" alt="Category2">
                                @break

                                @case(3)
                                <img src="{{ asset('assets/pos/assets/img/categories/medical.png') }}" alt="Category3">
                                @break

                                @case(4)
                                <img src="{{ asset('assets/pos/assets/img/categories/medicine.png') }}" alt="Category4">
                                @break

                                @case(5)
                                <img src="{{ asset('assets/pos/assets/img/categories/medicine1.png') }}"
                                    alt="Category5">
                                @break

                                @case(6)
                                <img src="{{ asset('assets/pos/assets/img/categories/hospital.png') }}" alt="Category6">
                                @break

                                @case(7)
                                <img src="{{ asset('assets/pos/assets/img/categories/handsanitizer.png') }}"
                                    alt="Category7">
                                @break

                                @case(8)
                                <img src="{{ asset('assets/pos/assets/img/categories/pills.png') }}" alt="Category7">
                                @break

                                @default
                                <img src="{{ asset('assets/pos/assets/img/categories/supplier.png') }}" alt="Category2">
                                @endswitch
                            </a>
                            <h6><a>{{ $category->name }}</a></h6>
                            <span>{{ $category->products->count() }} Items</span>
                        </li>
                        @endforeach





                    </ul>



                    <div class="pos-products">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="mb-3" style="font-weight: 700 ;color: #007084">🦺 Products</h5>
                        </div>
                        <div class="tabs_container">

                            <div class="tab_content active">
                                <div class="row products">
                                    @foreach ($productCategory as $productCategories)
                                    @if ($productCategories->quantity > 0)
                                    <div class="product col-sm-4 col-md-4 col-lg-4 col-xl-3"
                                        data-tab="{{ $productCategories->category_id }}">
                                        <div class="pro product-info default-cover card" style="height: 250px">
                                            <a class="img-bg" style="overflow: hidden">
                                                <img src="{{ asset('uploads/product/products/' . $productCategories->image) }}"
                                                    style="
                                                            width: 100%;
                                                            height: 100%;" alt="Products">
                                                <span><i data-feather="check" class="feather-16"></i></span>
                                            </a>
                                            <p style="font-size: 12px;font-weight: 800" class="product-name">
                                                <a>{{ $productCategories->category->name }}</a>
                                            </p>

                                            <h3 class="idproduct" style="color: #007084;font-weight: 800;display: none">
                                                <a>{{ $productCategories->id }}</a>
                                            </h3>
                                            <p class="cat-name" style="color: #007084;font-weight: 800">
                                                <a>{{ $productCategories->name }}</a>
                                            </p>

                                            <h6 class="barcode cat-name" style="display: none">
                                                <a>{{ $productCategories->barcode }}</a>
                                            </h6>



                                            <div class="d-flex align-items-center justify-content-between price" style="
                                                            display: flex !important;
                                                            position: absolute;
                                                            bottom: 10px;
                                                            width: 81%;">
                                                <span class="quantity">{{ $productCategories->quantity }}
                                                    <span>{{ $productCategories->type->type_name }}</span> </span>
                                                <p id="price">${{ number_format($productCategories->sale,0) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4 ps-0">
                <aside class="product-order-list">
                    <div class="head d-flex align-items-center justify-content-between w-100">
                        <div>
                            <h5>Order List</h5>
                            <span class="transaction">Transaction ID : # <span id="trans_id"></span></span>
                        </div>
                        
                        <script>
                            let currentTransactionId = ''; // Variable to store current transaction ID
                        
                            function updateTransaction() {
                                fetch('{{ route('fetch.transaction') }}') // Replace 'fetch.transaction' with your actual route name
                                    .then(response => response.json())
                                    .then(data => {
                                        const newTransactionId = data.transaction_id;
                                        // Check if the new transaction ID is different from the current transaction ID
                                        if (newTransactionId !== currentTransactionId) {
                                            document.getElementById('trans_id').innerText = newTransactionId;
                                            // Update the current transaction ID
                                            currentTransactionId = newTransactionId;
                                        }
                                    })
                                    .catch(error => console.error('Error fetching transaction:', error));
                            }
                        
                            // Update transaction ID every 2 seconds (2000 milliseconds)
                            setInterval(updateTransaction, 2000);
                        
                            // Initial call to update on page load
                            updateTransaction();
                        </script>
                        

                        <div class>
                            <a class="confirm-text"><i data-feather="trash-2" class="feather-16 text-danger"></i></a>
                            <a class="text-default"><i data-feather="more-vertical" class="feather-16"></i></a>
                        </div>
                    </div>
                    <div class="customer-info block-section">
                        <h6>Customer Information</h6>
                        <div class="input-block d-flex align-items-center">
                            <div class="flex-grow-1">
                                <select class="selection select" id="customerSelect">

                                </select>
                            </div>
                            <a href="#" class="btn btn-primary btn-icon" data-bs-toggle="modal"
                                data-bs-target="#create"><i data-feather="user-plus" class="feather-16"></i></a>

                            <script>
                                let currentOptionsModel = '';

                                    function updateCustomerModel() {
                                        fetch('{{ route('CustomerModel.fetch') }}')
                                            .then(response => response.json())
                                            .then(data => {
                                                const newOptions = data.CustomerOptions;
                                                // Check if the new options are different from the current options
                                                if (newOptions !== currentOptionsModel) {
                                                    // Update the select element with new options
                                                    document.getElementById('customerSelect').innerHTML = newOptions;
                                                    // Update the current options
                                                    currentOptionsModel = newOptions;
                                                }
                                            })
                                            .catch(error => console.error('Error fetching Customer:', error));
                                    }

                                    // Update categories every 4 seconds (4000 milliseconds)
                                    setInterval(updateCustomerModel, 4000);

                                    // Initial call to update on page load
                                    updateCustomerModel();
                            </script>



                        </div>
                        <div class="input-block">
                            <input type="search" class="form-control" id="barcodeInput"
                                placeholder="Scan or enter barcode">
                        </div>
                    </div>
                    <div class="product-added block-section">
                        <div class="head-text d-flex align-items-center justify-content-between">
                            <h6 class="d-flex align-items-center mb-0">Product Added<span class="count">0</span>
                            </h6>
                            <a class="clear d-flex align-items-center text-danger"><span class="me-1"><i
                                        data-feather="x" class="feather-16"></i></span>Clear
                                all</a>
                        </div>
                        <div class="product-wrap" id="product-wrap">





                        </div>
                    </div>
                    <div class="block-section">

                        <div class="order-total">
                            <table class="table table-responsive table-borderless">
                                <tr>
                                    <td>Sub Total</td>
                                    <td class="subTotal text-end">$ 0</td>
                                </tr>
                                <tr>
                                    <td>Quantity</td>
                                    <td class="totalQuantity text-end">0</td>
                                </tr>
                                <tr>
                                    <td class="danger">Total</td>
                                    <td class="total danger text-end">$ 0</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="btn-row d-sm-flex align-items-center justify-content-between">
                        {{-- <a class="btn btn-info btn-icon flex-fill" data-bs-toggle="modal"
                            data-bs-target="#hold-order"><span class="me-1 d-flex align-items-center"><i
                                    data-feather="pause" class="feather-16"></i></span>Hold</a> --}}
                        <a class="btn btn-danger btn-icon flex-fill"><span class="me-1 d-flex align-items-center"><i
                                    data-feather="trash-2" class="feather-16"></i></span>Void</a>
                        <a id="submit" class="btn btn-success btn-icon flex-fill" data-bs-toggle="modal"><span
                                class="me-1 d-flex align-items-center"><i data-feather="credit-card"
                                    class="feather-16"></i></span>Payment</a>
                    </div>
                </aside>



            </div>
        </div>
    </div>
</div>



<div class="modal fade modal-default" id="payment-completed" aria-labelledby="payment-completed">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <form action="pos.html">
                    <div class="icon-head">
                        <a>
                            <i data-feather="check-circle" class="feather-40"></i>
                        </a>
                    </div>
                    <h4>Payment Completed</h4>
                    <p class="mb-0">Do you want to Print Receipt for the Completed Order</p>
                    <div class="modal-footer d-sm-flex justify-content-between">
                        <button type="button" class="btn btn-primary flex-fill" data-bs-toggle="modal"
                            data-bs-target="#print-receipt">Print Receipt<i
                                class="feather-arrow-right-circle icon-me-5"></i></button>
                        <button type="submit" id="next-order" class="btn btn-secondary flex-fill">Next Order<i
                                class="feather-arrow-right-circle icon-me-5"></i></button>
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("next-order").addEventListener("click", function() {
                location.reload(true); // Reload the page without using cache
            });
        });
        
                    </script>
                  
                </form>
            </div>
        </div>
    </div>
</div>


<div class="invoice-print modal fade modal-default" id="print-receipt" aria-labelledby="print-receipt">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modals modal-content">
            <div class="d-flex justify-content-end">
                <button type="button" class="close p-0" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="icon-head text-center">
                    <a>
                        <img src="{{ asset('assets/img/haremw.png') }}" width="100" height="30" alt="Receipt Logo">
                    </a>
                </div>
                <div class="text-center info text-center">
                    <h6>Harem Hospital</h6>
                    <p class="mb-0">Phone Number: +964 053 334 0387</p>
                    <p class="mb-0">Email: HaremHospital@gmail.com</p>
                </div>
                <div class="tax-invoice">
                    <h6 class="text-center">Invoice Info</h6>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="invoice-user-name"><span>Name: </span><span class="invoice-name"></span>
                            </div>
                            <div class="invoice-user-name"><span>Invoice No: </span><span class="invoiceId"></span>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="invoice-user-name"><span>Customer Id: </span>#<span class="customer_id" id="customer_id"></span></div>
                            <div class="invoice-user-name"><span>Date: </span><span class="date"></span></div>
                        </div>
                    </div>
                </div>
                <table class="table-borderless w-100 table-fit">
                    <thead>
                        <tr>
                            <th># Item</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody class="invoice-order">
                    </tbody>
                </table>
                <div class="text-center invoice-bar">
                    <p>**VAT against this challan is payable through central registration. Thank you for your
                        business!</p>
                    <a>
                        <img style="
                                width: 170px;
                                height: 72px;" class="barcodes"
                            src="{{ asset('assets/pos/assets/img/barcode/barcode-03.jpg') }}" alt="Barcode">
                    </a>
                    <p>Sale 31</p>
                    <p>Thank You For Shopping With Us. Please Come Again</p>
                    <a class="print btn btn-primary">Print Receipt</a>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade modal-default pos-modal" id="products" aria-labelledby="products">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header p-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <h5 class="me-4">Products</h5>
                    <span class="badge bg-info d-inline-block mb-0">Order ID : #666614</span>
                </div>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form action="pos.html">
                    <div class="product-wrap">
                        <div class="product-list d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center flex-fill">
                                <a class="img-bg me-2">
                                    <img src="{{ asset('assets/pos/assets/img/products/pos-product-16.png') }}"
                                        alt="Products">
                                </a>
                                <div class="info d-flex align-items-center justify-content-between flex-fill">
                                    <div>
                                        <span>PT0005</span>
                                        <h6><a>Red Nike Laser</a></h6>
                                    </div>
                                    <p>$2000</p>
                                </div>
                            </div>
                        </div>
                        <div class="product-list d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center flex-fill">
                                <a class="img-bg me-2">
                                    <img src="{{ asset('assets/pos/assets/img/products/pos-product-17.png') }}"
                                        alt="Products">
                                </a>
                                <div class="info d-flex align-items-center justify-content-between flex-fill">
                                    <div>
                                        <span>PT0235</span>
                                        <h6><a>Iphone 14</a></h6>
                                    </div>
                                    <p>$3000</p>
                                </div>
                            </div>
                        </div>
                        <div class="product-list d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center flex-fill">
                                <a class="img-bg me-2">
                                    <img src="{{ asset('assets/pos/assets/img/products/pos-product-16.png') }}"
                                        alt="Products">
                                </a>
                                <div class="info d-flex align-items-center justify-content-between flex-fill">
                                    <div>
                                        <span>PT0005</span>
                                        <h6><a>Red Nike Laser</a></h6>
                                    </div>
                                    <p>$2000</p>
                                </div>
                            </div>
                        </div>
                        <div class="product-list d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center flex-fill">
                                <a class="img-bg me-2">
                                    <img src="{{ asset('assets/pos/assets/img/products/pos-product-17.png') }}"
                                        alt="Products">
                                </a>
                                <div class="info d-flex align-items-center justify-content-between flex-fill">
                                    <div>
                                        <span>PT0005</span>
                                        <h6><a>Red Nike Laser</a></h6>
                                    </div>
                                    <p>$2000</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-sm-flex justify-content-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="create" tabindex="-1" aria-labelledby="create" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create 🧑‍💻</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form id="form-data" method="POST" action="{{ route('Customer.model') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">


                    <div class="row">

                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="input-blocks">
                                <label for="customer_name">{{ __('Customer Name 💙') }}</label>
                                <input class="form-control @error('customer_name') is-invalid @enderror" type="text"
                                    value="{{ old('customer_name') }}" id="customer_name" name="customer_name"
                                    autofocus />
                                @error('customer_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="input-blocks">
                                <label for="emailcustomerinput">Email 📬</label>
                                <input class="form-control @error('emailcustomerinput') is-invalid @enderror"
                                    type="emailcustomerinput" value="{{ old('emailcustomerinput') }}"
                                    id="emailcustomerinput" name="emailcustomerinput" required>
                                @error('emailcustomerinput')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="input-blocks">
                                <label for="Phonecustomersinput">Phone ☎️</label>
                                <input class="form-control @error('Phonecustomersinput') is-invalid @enderror"
                                    type="text" value="{{ old('Phonecustomersinput') }}"
                                    oninput="formatPhoneNumber(this)" value="{{ old('phone') }}"
                                    id="Phonecustomersinput" name="Phonecustomersinput" required>
                                @error('Phonecustomersinput')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <script>
                            function formatPhoneNumber(input) {
                                    let value = input.value.replace(/\D/g, ''); // Remove non-digit characters
                                    if (value.length > 11) {
                                        value = value.substr(0, 11); // Limit to 11 digits
                                    }
                                    if (value.length > 7) {
                                        value = value.replace(/(\d{4})(\d{3})(\d{4})/, '$1 $2 $3'); // Add spaces
                                    } else if (value.length > 4) {
                                        value = value.replace(/(\d{4})(\d{0,3})/, '$1 $2'); // Add space after first 4 digits
                                    }
                                    input.value = value;
                                }
                        </script>


                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="input-blocks">
                                <label>City 🏡</label>
                                <select class="form-control select @error('city') is-invalid @enderror" id="city"
                                    name="city">
                                    <option value="sulaymaniyah">Sulaymaniyah
                                    </option>
                                    <option value="hawler">Hawler
                                    </option>
                                    <option value="halabja">Halabja
                                    </option>
                                    <option value="Duhok">Duhok
                                    </option>


                                </select>
                                @error('city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        </div>



                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="input-blocks">

                                <label for="district">{{ __('District 🏢') }}</label>

                                <input class="form-control @error('district') is-invalid @enderror" type="text"
                                    value="{{ old('district') }}" id="district" name="district" autofocus />
                                @error('district')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="input-blocks">

                                <label for="address">{{ __('Address 🗺') }}</label>

                                <input class="form-control @error('address') is-invalid @enderror" type="text"
                                    value="{{ old('address') }}" id="address" name="address" autofocus />
                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="input-blocks">
                                <label for="description">Description</label>
                                <textarea id="descriptionCustomer" name="description"
                                    class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label> Customer Image</label>
                                <div class="image-upload image-upload-new" id="image-upload">
                                    <input type="file" name="image"
                                        class="form-control @error('image') is-invalid @enderror"
                                        id="CustomerProfilePicture" onchange="displaySelectedImage()">

                                    <div class="image-uploads" id="image-uploads">
                                        <img src="{{ asset('assets/img/icons/upload.svg') }}" alt="img"
                                            id="selectedImage">
                                        <h4 id="h4">Drag and
                                            drop a
                                            file to upload</h4>
                                    </div>
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12" id="pdoductviewes" style="display: none">
                            <div class="product-list">
                                <ul class="row">
                                    <li>
                                        <div class="productviews" style="width: 250px">
                                            <div class="productviewsimg">
                                                <img src="" alt="img" id="productImage">
                                            </div>
                                            <div class="productviewscontent">
                                                <div class="productviewsname">
                                                    <h2 id="imageName">
                                                        macbookpro.jpg
                                                    </h2>
                                                    <h3 id="imageSize">
                                                        581kb</h3>
                                                </div>
                                                <a href="javascript:void(0);" class="hidesets" id="hidesets">x</a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer d-sm-flex justify-content-end">
                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" id="submitbuttonCustomer" class="btn btn-submit me-2">Submit</button>
                    </div>





                </div>
            </form>
            <!-- jQuery -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

            <script>
                $(document).ready(function() {
                        $('#submitbuttonCustomer').click(function(e) {
                            e.preventDefault();

                            var CustomerName = $('#customer_name').val();

                            if (CustomerName.trim() === '') {

                                Toastify({
                                    text: ' Name is required!',
                                    duration: 3000,
                                    gravity: 'top-left',
                                    close: true,
                                    backgroundColor: '#ff0000',
                                    className: 'toastify-custom',
                                }).showToast();
                                return;
                            }
                            // Get the value of the email input
                            var Customeremail = $('#emailcustomerinput').val();
                            if (Customeremail.trim() === '') {

                                Toastify({
                                    text: ' Email is required!',
                                    duration: 3000,
                                    gravity: 'top-left',
                                    close: true,
                                    backgroundColor: '#ff0000',
                                    className: 'toastify-custom',
                                }).showToast();
                                return;
                            }
                            // Validate the email format using a regular expression
                            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                            if (!emailRegex.test(Customeremail)) {
                                // If the email format is invalid, display an error message and return
                                $('#emailcustomerinput').addClass('is-invalid');

                                Toastify({
                                    text: ' Enter A vaild Email Address',
                                    duration: 3000,
                                    gravity: 'top-left',
                                    close: true,
                                    backgroundColor: '#ff0000',
                                    className: 'toastify-custom',
                                }).showToast();

                                return;
                            } else {
                                // If the email format is valid, remove any existing error message and continue
                                $('#emailcustomerinput').removeClass('is-invalid');
                                $('#emailError').text('');
                            }

                            // Get the value of the phone input
                            var Customerphone = $('#Phonecustomersinput').val();
                            if (Customerphone.trim() === '') {

                                Toastify({
                                    text: ' Phone number is required!',
                                    duration: 3000,
                                    gravity: 'top-left',
                                    close: true,
                                    backgroundColor: '#ff0000',
                                    className: 'toastify-custom',
                                }).showToast();
                                return;
                            }
                            // Remove any non-digit characters from the input
                            var phoneDigits = Customerphone.replace(/\D/g, '');

                            // Check if the remaining digits match the format of exactly seven digits
                            if (phoneDigits.length !== 11 || !/^\d{11}$/.test(phoneDigits)) {
                                // If the input does not match the expected format, display an error message
                                $('#Phonecustomersinput').addClass('is-invalid');

                                Toastify({
                                    text: ' Please enter a phone number with exactly seven digits',
                                    duration: 3000,
                                    gravity: 'top-left',
                                    close: true,
                                    backgroundColor: '#ff0000',
                                    className: 'toastify-custom',
                                }).showToast();
                                return;
                            } else {
                                // If the input matches the expected format, remove any existing error message
                                $('#Phonecustomersinput').removeClass('is-invalid');
                                $('#phonError').text('');
                            }

                            var Customercity = $('#city').val();
                            var Customerdistrict = $('#district').val();
                            var Customeraddress = $('#address').val();
                            var CustomerDescription = $('#descriptionCustomer').val();


                            if (Customercity.trim() === '') {

                                Toastify({
                                    text: ' City is required!',
                                    duration: 3000,
                                    gravity: 'top-left',
                                    close: true,
                                    backgroundColor: '#ff0000',
                                    className: 'toastify-custom',
                                }).showToast();
                                return;
                            }
                            if (Customerdistrict.trim() === '') {

                                Toastify({
                                    text: ' District is required!',
                                    duration: 3000,
                                    gravity: 'top-left',
                                    close: true,
                                    backgroundColor: '#ff0000',
                                    className: 'toastify-custom',
                                }).showToast();
                                return;
                            }
                            if (Customeraddress.trim() === '') {

                                Toastify({
                                    text: ' Address is required!',
                                    duration: 3000,
                                    gravity: 'top-left',
                                    close: true,
                                    backgroundColor: '#ff0000',
                                    className: 'toastify-custom',
                                }).showToast();
                                return;
                            }
                            if (CustomerDescription.trim() === '') {

                                Toastify({
                                    text: ' Description is required!',
                                    duration: 3000,
                                    gravity: 'top-left',
                                    close: true,
                                    backgroundColor: '#ff0000',
                                    className: 'toastify-custom',
                                }).showToast();
                                return;
                            }
                            // Get the file input element
                            var CustomerImageInput = $('#CustomerProfilePicture')[0];
                            var CustomerImage = CustomerImageInput.files[0];



                            // Create FormData object
                            var formData = new FormData();
                            formData.append('name', CustomerName);
                            formData.append('email', Customeremail);
                            formData.append('phone', Customerphone);
                            formData.append('city', Customercity);
                            formData.append('district', Customerdistrict);
                            formData.append('address', Customeraddress);
                            formData.append('description', CustomerDescription);
                            formData.append('image', CustomerImage);
                            // Get CSRF token value from the meta tag
                            var csrfToken = $('meta[name="csrf-token"]').attr('content');


                            // Check if the email already exists in the database
                            $.ajax({
                                url: "{{ route('checkEmailExistenceCustomer') }}",
                                type: "POST",
                                data: {
                                    email: Customeremail
                                },
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
                                },
                                success: function(response) {
                                    if (response.exists) {
                                        // If email already exists in the database, display a notification
                                        Toastify({
                                            text: 'Email already exists in the database!',
                                            duration: 3000,
                                            gravity: 'top-left', // Position the toast notification at the top left corner
                                            close: true, // Show a close button
                                            backgroundColor: '#ff0000', // Red background color for error
                                            className: 'toastify-custom', // Custom CSS class for styling
                                        }).showToast();
                                    } else {

                                        $.ajax({
                                            url: "{{ route('Customer.model') }}",
                                            type: "POST",
                                            data: formData,
                                            processData: false, // Prevent jQuery from processing the data
                                            contentType: false, // Prevent jQuery from setting content type
                                            headers: {
                                                'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
                                            },
                                            success: function(response) {
                                                Toastify({
                                                    text: 'Customer stored successfully!!',
                                                    duration: 2000,
                                                    gravity: 'top-left', // Position the toast notification at the top left corner
                                                    close: true, // Show a close button
                                                    backgroundColor: 'linear-gradient(to right, #00b09b, #96c93d)', // Custom background color
                                                    className: 'toastify-custom', // Custom CSS class for styling
                                                }).showToast();

                                                // Reset input fields after successful submission
                                                $('#customer_name').val('');
                                                $('#emailcustomerinput').val('');
                                                $('#Phonecustomersinput').val('');
                                                $('#city').val('');
                                                $('#district').val('');
                                                $('#address').val('');
                                                $('#descriptionCustomer').val('');
                                                $('#CustomerProfilePicture').val('');
                                            },
                                            error: function(xhr, status, error) {
                                                console.log("Error occurred:", xhr, status,
                                                    error);

                                            }

                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    Toastify({
                                        text: 'Chaeck Again , Error Have',
                                        duration: 3000,
                                        gravity: 'top-left', // Position the toast notification at the top left corner
                                        close: true, // Show a close button
                                        backgroundColor: '#ff0000', // Red background color for error
                                        className: 'toastify-custom', // Custom CSS class for styling
                                    }).showToast();
                                }
                            });











                        });
                    });
            </script>




        </div>
    </div>
</div>

{{-- <div class="modal fade modal-default pos-modal" id="hold-order" aria-labelledby="hold-order">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header p-4">
                <h5>Hold order</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form action="pos.html">
                    <h2 class="text-center p-4">4500.00</h2>
                    <div class="input-block">
                        <label>Order Reference</label>
                        <input class="form-control" type="text" value placeholder>
                    </div>
                    <p>The current order will be set on hold. You can retreive this order from the pending order
                        button. Providing a reference to it might help you to identify the order more quickly.</p>
                    <div class="modal-footer d-sm-flex justify-content-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> --}}


{{-- 
<div class="modal fade modal-default pos-modal" id="edit-product" aria-labelledby="edit-product">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header p-4">
                <h5>Red Nike Laser</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form action="pos.html">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="input-blocks add-product">
                                <label>Product Name <span>*</span></label>
                                <input type="text" placeholder="45">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="input-blocks add-product">
                                <label>Tax Type <span>*</span></label>
                                <select class="select">
                                    <option>Exclusive</option>
                                    <option>Inclusive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="input-blocks add-product">
                                <label>Tax <span>*</span></label>
                                <input type="text" placeholder="% 15">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="input-blocks add-product">
                                <label>Discount Type <span>*</span></label>
                                <select class="select">
                                    <option>Percentage</option>
                                    <option>Early payment discounts</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="input-blocks add-product">
                                <label>Discount <span>*</span></label>
                                <input type="text" placeholder="15">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="input-blocks add-product">
                                <label>Sale Unit <span>*</span></label>
                                <select class="select">
                                    <option>Kilogram</option>
                                    <option>Grams</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-sm-flex justify-content-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> --}}


<div class="modal fade pos-modal" id="recents" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header p-4">
                <h5 class="modal-title">Recent Transactions</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="tabs-sets">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="purchase-tab" data-bs-toggle="tab"
                                data-bs-target="#purchase" type="button" aria-controls="purchase" aria-selected="true"
                                role="tab">Purchase</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="payment-tab" data-bs-toggle="tab" data-bs-target="#payment"
                                type="button" aria-controls="payment" aria-selected="false" role="tab">Purchase Due</button>
                        </li>
                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link" id="return-tab" data-bs-toggle="tab" data-bs-target="#return"
                                type="button" aria-controls="return" aria-selected="false" role="tab">Return</button>
                        </li> --}}
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="purchase" role="tabpanel"
                            aria-labelledby="purchase-tab">
                            <div class="table-top">
                                <div class="search-set">
                                    <div class="search-input">
                                        <a class="btn btn-searchset d-flex align-items-center h-100"><img
                                                src="{{ asset('assets/pos/assets/img/icons/search-white.svg') }}"
                                                alt="img"></a>
                                    </div>
                                </div>
                                <div class="wordset">
                                    <ul>
                                        <li>
                                            <a class="d-flex align-items-center justify-content-center"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Pdf"><img
                                                    src="{{ asset('assets/pos/assets/img/icons/pdf.svg') }}"
                                                    alt="img"></a>
                                        </li>
                                        <li>
                                            <a class="d-flex align-items-center justify-content-center"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Excel"><img
                                                    src="{{ asset('assets/pos/assets/img/icons/excel.svg') }}"
                                                    alt="img"></a>
                                        </li>
                                        <li>
                                            <a class="d-flex align-items-center justify-content-center"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Print"><i
                                                    data-feather="printer" class="feather-rotate-ccw"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table datanew">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Reference</th>
                                            <th>Supplier</th>
                                            <th>Amount </th>
                                            <th class="no-sort">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($purchases->sortBy(function ($purchase) {
                                            return $purchase->first()->date;
                                        }) as $purchaseGroup)
                                            @php
                                                // Get the first purchase in the group
                                                $firstPurchase = $purchaseGroup->first();
                                            @endphp
                                            <tr>
                                                <td>{{ $firstPurchase->date }}</td>
                                                <td>{{ $firstPurchase->reference }}</td>
                                                <td>{{ $firstPurchase->supplier->supplier_name }}</td>
                                                <td>${{ $firstPurchase->totalPurchase->grand_total }}</td>
                                                <td class="action-table-data">
                                                    <div class="edit-delete-action">
                                                        <a href="{{ route('purchase.details', ['date' => $firstPurchase->date, 'reference' => $firstPurchase->reference]) }}" class="me-2 p-2"><i data-feather="eye"
                                                                class="feather-eye"></i></a>
                                                        <a  href="{{ route('edit.purchase', ['date' => $firstPurchase->date, 'reference' => $firstPurchase->reference]) }}" class="me-2 p-2"><i data-feather="edit"
                                                                class="feather-edit"></i></a>
                                                        <a href="{{ route('destroy.purchase', ['date' => $firstPurchase->date, 'reference' => $firstPurchase->reference]) }}" class="p-2 confirm-text"><i data-feather="trash-2"
                                                                class="feather-trash-2"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        


                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="payment" role="tabpanel">
                            <div class="table-top">
                                <div class="search-set">
                                    <div class="search-input">
                                        <a class="btn btn-searchset d-flex align-items-center h-100"><img
                                                src="{{ asset('assets/pos/assets/img/icons/search-white.svg') }}"
                                                alt="img"></a>
                                    </div>
                                </div>
                                <div class="wordset">
                                    <ul>
                                        <li>
                                            <a class="d-flex align-items-center justify-content-center"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Pdf"><img
                                                    src="{{ asset('assets/pos/assets/img/icons/pdf.svg') }}"
                                                    alt="img"></a>
                                        </li>
                                        <li>
                                            <a class="d-flex align-items-center justify-content-center"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Excel"><img
                                                    src="{{ asset('assets/pos/assets/img/icons/excel.svg') }}"
                                                    alt="img"></a>
                                        </li>
                                        <li>
                                            <a class="d-flex align-items-center justify-content-center"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Print"><i
                                                    data-feather="printer" class="feather-rotate-ccw"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table datanew">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Reference</th>
                                            <th>Supplier</th>
                                            <th>Amount </th>
                                            <th class="no-sort">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($purchasesDue->sortByDesc(function ($purchasesDues) {
                                            return $purchasesDues->first()->date;
                                        })->take(4) as $purchasesGroup)
                                            @php
                                                // Get the first Due in the group
                                                $firstDue = $purchasesGroup->first();
                                            @endphp
                                            <tr>
                                                <td>{{ $firstDue->date }}</td>
                                                <td>{{ $firstDue->reference }}</td>
                                                <td>
                                                    {{ $firstDue->supplier->supplier_name  }}
                                                </td>
                                                <td>$ {{ $firstDue->grand_total  }}</td>
                                                <td class="action-table-data">
                                                    <div class="edit-delete-action">
                                                        <a href="{{ route('purchase.details', ['date' => $firstDue->date, 'reference' => $firstDue->reference]) }}" class="me-2 p-2"><i data-feather="eye" class="feather-eye"></i></a>
                                                        <a href="{{ route('edit.purchase', ['date' => $firstDue->date, 'reference' => $firstDue->reference]) }}" class="me-2 p-2"><i data-feather="edit" class="feather-edit"></i></a>
                                                        <a href="{{ route('destroy.purchase', ['date' => $firstDue->date, 'reference' => $firstDue->reference]) }}" class="p-2 confirm-text"><i data-feather="trash-2" class="feather-trash-2"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        

</tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="return" role="tabpanel">
                            <div class="table-top">
                                <div class="search-set">
                                    <div class="search-input">
                                        <a class="btn btn-searchset d-flex align-items-center h-100"><img
                                                src="{{ asset('assets/pos/assets/img/icons/search-white.svg') }}"
                                                alt="img"></a>
                                    </div>
                                </div>
                                <div class="wordset">
                                    <ul>
                                        <li>
                                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Pdf"
                                                class="d-flex align-items-center justify-content-center"><img
                                                    src="{{ asset('assets/pos/assets/img/icons/pdf.svg') }}"
                                                    alt="img"></a>
                                        </li>
                                        <li>
                                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Excel"
                                                class="d-flex align-items-center justify-content-center"><img
                                                    src="{{ asset('assets/pos/assets/img/icons/excel.svg') }}"
                                                    alt="img"></a>
                                        </li>
                                        <li>
                                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Print"
                                                class="d-flex align-items-center justify-content-center"><i
                                                    data-feather="printer" class="feather-rotate-ccw"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            {{-- <div class="table-responsive">
                                <table class="table datanew">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Reference</th>
                                            <th>Customer</th>
                                            <th>Amount </th>
                                            <th class="no-sort">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>              @foreach ($purchasesReturns->sortByDesc(function ($purchaseReturn) {
                                        return $purchaseReturn->first()->date;
                                    })->take(4) as $purchaseReturnGroup)
                                        @php
                                            // Get the first purchaseReturn in the group
                                            $firstpurchaseReturn = $purchaseReturnGroup->first();
                                        @endphp
                                        <tr>
                                            <td>{{ $firstpurchaseReturn->date }}</td>
                                            <td>{{ $firstpurchaseReturn->receipt }}</td>
                                            <td>
                                                {{ $firstpurchaseReturn->supplier->supplier_name }}
                                            </td>
                                            <td>${{ $firstpurchaseReturn->totalPurchase->grand_total }}</td>
                                            <td class="action-table-data">
                                                <div class="edit-delete-action">
                                                    <a href="{{ route('sale.return.details', ['date' => $firstpurchaseReturn->date, 'reference' => $firstpurchaseReturn->reference]) }}" class="me-2 p-2"><i data-feather="eye" class="feather-eye"></i></a>
                                                    <a href="{{ route('sale.edit.return', ['date' => $firstpurchaseReturn->date, 'reference' => $firstpurchaseReturn->reference]) }}" class="me-2 p-2"><i data-feather="edit" class="feather-edit"></i></a>
                                                    <a href="{{ route('destroy.sale.return', ['date' => $firstpurchaseReturn->date, 'reference' => $firstpurchaseReturn->reference]) }}" class="p-2 confirm-text"><i data-feather="trash-2" class="feather-trash-2"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    

                                    </tbody>
                                </table>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade pos-modal" id="orders" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header p-4">
                <h5 class="modal-title">Orders</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="tabs-sets">
                    <ul class="nav nav-tabs" id="myTabs" role="tablist">
                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="onhold-tab" data-bs-toggle="tab"
                                data-bs-target="#onhold" type="button" aria-controls="onhold" aria-selected="true"
                                role="tab">Onhold</button>
                        </li> --}}
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="unpaid-tab" data-bs-toggle="tab" data-bs-target="#unpaid"
                                type="button" aria-controls="unpaid" aria-selected="false" role="tab">Unpaid</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="paid-tab" data-bs-toggle="tab" data-bs-target="#paid"
                                type="button" aria-controls="paid" aria-selected="false" role="tab">Paid</button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        {{-- <div class="tab-pane fade show active" id="onhold" role="tabpanel" aria-labelledby="onhold-tab">
                            <div class="table-top">
                                <div class="search-set w-100 search-order">
                                    <div class="search-input w-100">
                                        <a class="btn btn-searchset d-flex align-items-center h-100"><img
                                                src="{{ asset('assets/pos/assets/img/icons/search-white.svg') }}"
                                                alt="img"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="order-body">
                                <div class="default-cover p-4 mb-4">
                                    <span class="badge bg-secondary d-inline-block mb-4">Order ID : #666659</span>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 record mb-3">
                                            <table>
                                                <tr class="mb-3">
                                                    <td>Cashier</td>
                                                    <td class="colon">:</td>
                                                    <td class="text">admin</td>
                                                </tr>
                                                <tr>
                                                    <td>Customer</td>
                                                    <td class="colon">:</td>
                                                    <td class="text">Botsford</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-sm-12 col-md-6 record mb-3">
                                            <table>
                                                <tr>
                                                    <td>Total</td>
                                                    <td class="colon">:</td>
                                                    <td class="text">$900</td>
                                                </tr>
                                                <tr>
                                                    <td>Date</td>
                                                    <td class="colon">:</td>
                                                    <td class="text">29-08-2023 13:39:11</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <p class="p-4">Customer need to recheck the product once</p>
                                    <div class="btn-row d-sm-flex align-items-center justify-content-between">
                                        <a class="btn btn-info btn-icon flex-fill">Open</a>
                                        <a class="btn btn-danger btn-icon flex-fill">Products</a>
                                        <a class="btn btn-success btn-icon flex-fill">Print</a>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="tab-pane fade show active" id="unpaid" role="tabpanel">
                            <div class="table-top">
                                <div class="search-set w-100 search-order">
                                    <div class="search-input">
                                        <a class="btn btn-searchset d-flex align-items-center h-100"><img
                                                src="{{ asset('assets/pos/assets/img/icons/search-white.svg') }}"
                                                alt="img"></a>
                                    </div>
                                </div>
                            </div>

                            @foreach ($salesUnPaid->sortByDesc(function ($salesUnPaids) {
                                return $salesUnPaids->first()->date;
                            }) as $salesUnPaidsGroup)
                                @php
                                    // Get the first salesUnPaids in the group
                                    $firstsalesUnPaids = $salesUnPaidsGroup->first();
                                @endphp
                            <div class="order-body">
                                <div class="default-cover p-4 mb-4">
                                    <span class="badge bg-info d-inline-block mb-4">Order ID : #{{ $firstsalesUnPaids->receipt }}</span>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 record mb-3">
                                            <table>
                                                <tr class="mb-3">
                                                    <td>Cashier</td>
                                                    <td class="colon">:</td>
                                                    <td class="text">  {{ $firstsalesUnPaids->biller->username }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Customer</td>
                                                    <td class="colon">:</td>
                                                    <td class="text">@if ($firstsalesUnPaids->customer_id)
                                                        {{ $firstsalesUnPaids->customer->customer_name }}
                                                    @elseif ($firstsalesUnPaids->user_id)
                                                        {{ $firstsalesUnPaids->salesuser->username }}
                                                    @else
                                                        No customer or user associated
                                                    @endif</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-sm-12 col-md-6 record mb-3">
                                            <table>
                                                <tr>
                                                    <td>Total</td>
                                                    <td class="colon">:</td>
                                                    <td class="text">$ {{ $firstsalesUnPaids->total_dollar }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Date</td>
                                                    <td class="colon">:</td>
                                                    <td class="text">{{ $firstsalesUnPaids->date }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <p class="p-4">Customer need to recheck the product once</p>
                                    <div class="btn-row d-flex align-items-center justify-content-between">
                                        <a class="btn btn-info btn-icon flex-fill">Open</a>
                                        <a class="btn btn-danger btn-icon flex-fill">Products</a>
                                        <a class="btn btn-success btn-icon flex-fill">Print</a>
                                    </div>
                                </div>
                            </div>

                                
                            @endforeach
                       


                        </div>
                        <div class="tab-pane fade" id="paid" role="tabpanel">
                            <div class="table-top">
                                <div class="search-set w-100 search-order">
                                    <div class="search-input">
                                        <a class="btn btn-searchset d-flex align-items-center h-100"><img
                                                src="{{ asset('assets/pos/assets/img/icons/search-white.svg') }}"
                                                alt="img"></a>
                                    </div>
                                </div>
                            </div>
                            @foreach ($salesPaid->sortByDesc(function ($salesPaids) {
                                return $salesPaids->first()->date;
                            }) as $salesPaidsGroup)
                                @php
                                    // Get the first salesPaids in the group
                                    $firstsalesPaids = $salesPaidsGroup->first();
                                @endphp
                            <div class="order-body">
                                <div class="default-cover p-4 mb-4">
                                    <span class="badge bg-info d-inline-block mb-4">Order ID : #{{ $firstsalesPaids->receipt }}</span>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 record mb-3">
                                            <table>
                                                <tr class="mb-3">
                                                    <td>Cashier</td>
                                                    <td class="colon">:</td>
                                                    <td class="text">{{ $firstsalesPaids->biller ? $firstsalesPaids->biller->username : 'N/A' }}</td>

                                                </tr>
                                                <tr>
                                                    <td>Customer</td>
                                                    <td class="colon">:</td>
                                                    <td class="text">@if ($firstsalesPaids->customer_id)
                                                        {{ $firstsalesPaids->customer->customer_name }}
                                                    @elseif ($firstsalesPaids->user_id)
                                                        {{ $firstsalesPaids->salesuser->username }}
                                                    @else
                                                        No customer or user associated
                                                    @endif</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-sm-12 col-md-6 record mb-3">
                                            <table>
                                                <tr>
                                                    <td>Total</td>
                                                    <td class="colon">:</td>
                                                    <td class="text">$ {{ $firstsalesPaids->total_dollar }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Date</td>
                                                    <td class="colon">:</td>
                                                    <td class="text">{{ $firstsalesPaids->date }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <p class="p-4">Customer need to recheck the product once</p>
                                    <div class="btn-row d-flex align-items-center justify-content-between">
                                        <a class="btn btn-info btn-icon flex-fill">Open</a>
                                        <a class="btn btn-danger btn-icon flex-fill">Products</a>
                                        <a class="btn btn-success btn-icon flex-fill">Print</a>
                                    </div>
                                </div>
                            </div>

                                
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var storePosUrl = "{{ route('store.pos') }}";
</script>






@endsection