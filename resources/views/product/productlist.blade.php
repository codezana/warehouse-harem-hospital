@extends('layouts.nav')

@section('name', 'Product List')
@section('custom-css')
<link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>


@endsection
@section('content')

    <style>
        /* Customize the success notification */
        .toast-success {
            background-color: #4CAF50 !important;
            color: white !important;
        }

        /* Customize the error notification */
        .toast-error {
            background-color: #f44336 !important;
            color: white !important;
        }

        /* Customize the notification container */
        .toast-container {
            width: 300px !important;
            /* Add more custom styles as needed */
        }

        /* Style for the modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 17% auto;
            padding: 20px;
            border: 1px solid #888;
            text-align: center;
            transition: .3s all;
            position: relative;
            display: flex;
            flex-direction: column;
            width: 30% !important;
            pointer-events: auto;

            background-clip: padding-box;

            border-radius: 0.3rem;
            outline: 0;
        }

        .close {
            align-self: end;
            float: left;
            cursor: pointer;
        }

        /* Style for the button, adjust as needed */
        .delete-button {
            cursor: pointer;
        }



        .noselect {
            align-self: center;
            width: 150px;
            height: 50px;
            cursor: pointer;
            display: flex;
            align-items: center;
            background: red;
            border: none;
            border-radius: 5px;
            box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.15);
            background: #e62222;
        }

        .noselect,
        .noselect span {
            transition: 200ms;
        }

        .noselect .text {
            transform: translateX(35px);
            color: white;
            font-weight: bold;
        }

        button .icon {
            position: absolute;
            border-left: 1px solid #c41b1b;
            transform: translateX(110px);
            height: 40px;
            width: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        button svg {
            width: 15px;
            fill: #eee;
        }

        button:hover {
            background: #ff3636;
        }

        button:hover .text {
            color: transparent;
        }

        button:hover .icon {
            width: 150px;
            border-left: none;
            transform: translateX(0);
        }

        button:focus {
            outline: none;
        }

        button:active .icon svg {
            transform: scale(0.8);
        }
    </style>





    @php
        $requiredPermissions = [
            'View Product',
            'Select all Product',
            'Delete Product',
            'Edit Product',
            'Create Product',
        ];
        $userHasPermission = false;

        $hasViewProductPermission = false;
        $hasSelectAllProductPermission = false;
        $hasEditProductPermission = false;
        $hasDeleteProductPermission = false;
        $hasCreateProductPermission = false;
        foreach ($requiredPermissions as $permission) {
            if (Auth::user()->hasPermission($permission)) {
                $userHasPermission = true;
                if ($permission === 'View Product') {
                    $hasViewProductPermission = true;
                } elseif ($permission === 'Select all Product') {
                    $hasSelectAllProductPermission = true;
                } elseif ($permission === 'Edit Product') {
                    $hasEditProductPermission = true;
                } elseif ($permission === 'Delete Product') {
                    $hasDeleteProductPermission = true;
                } elseif ($permission === 'Create Product') {
                    $hasCreateProductPermission = true;
                }
            }
        }

    @endphp


    @php
        $showActionColumn =
            $userHasPermission &&
            ($hasEditProductPermission ||
                ($hasEditProductPermission && $hasSelectAllProductPermission) ||
                $hasDeleteProductPermission ||
                ($hasDeleteProductPermission && $hasSelectAllProductPermission) ||
                $hasSelectAllProductPermission);
    @endphp

    @php
        $showAddColumn =
            $userHasPermission &&
            ($hasCreateProductPermission ||
                ($hasCreateProductPermission && $hasSelectAllProductPermission) ||
                $hasSelectAllProductPermission);
    @endphp
    @php
        $showEditColumn =
            $userHasPermission &&
            ($hasEditProductPermission ||
                ($hasEditProductPermission && $hasSelectAllProductPermission) ||
                $hasSelectAllProductPermission);
    @endphp

    @php
        $showDeleteColumn =
            $userHasPermission &&
            ($hasDeleteProductPermission ||
                ($hasDeleteProductPermission && $hasSelectAllProductPermission) ||
                $hasSelectAllProductPermission);
    @endphp
    - <div class="page-wrapper page-wrapper-one">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Product List</h4>
                    <h6>Manage your products</h6>
                </div>
                <div class="page-btn">
                    @if ($showAddColumn)
                        <a href="{{ route('productpage') }}" class="btn btn-added"><img src="assets/img/icons/plus.svg"
                                alt="img" class="me-1">Add New Product</a>
                    @endif





                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-path">
                                <a class="btn btn-filter" id="filter_search">
                                    <img src="assets/img/icons/filter.svg" alt="img">
                                    <span><img src="assets/img/icons/closes.svg" alt="img"></span>
                                </a>
                            </div>
                            <div class="search-input">
                                <a class="btn btn-searchset"><img src="assets/img/icons/search-white.svg"
                                        alt="img"></a>
                            </div>
                        </div>
                        <div class="wordset">
                            <ul>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img
                                            src="assets/img/icons/pdf.svg" alt="img"></a>
                                </li>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img
                                            src="assets/img/icons/excel.svg" alt="img"></a>
                                </li>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img
                                            src="assets/img/icons/printer.svg" alt="img"></a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card mb-0" id="filter_inputs">
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-lg-12 col-sm-12">
                                    <div class="row">

                                        <div class="col-lg col-sm-6 col-12">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="productid"
                                                    placeholder="Enter ID">
                                            </div>
                                        </div>
                                        <div class="col-lg col-sm-6 col-12">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="productName"
                                                    placeholder="Enter Product Name">
                                            </div>
                                        </div>


                                        <div class="col-lg col-sm-6 col-12">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="createdby"
                                                    placeholder="CreatedBy">
                                            </div>
                                        </div>
                                        <div class="col-lg col-sm-6 col-12 ">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="ProductCode"
                                                    placeholder="Enter product code">
                                            </div>
                                        </div>
                                        <div class="col-lg-1 col-sm-6 col-12 ms-auto">
                                            <div class="form-group">
                                                <a class="btn btn-filters ms-auto" style="background-color: #ffffff;"><img
                                                        src="assets/img/icons/clears.svg" alt="img" id="clear"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="table-responsive">
                        <table class="table  datanew" id="userTable">
                            <thead>
                                <tr>
                                    <th>
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>P.Code</th>
                                    <th>Stock</th>
                                    <th>Price</th>
                                    <th>Selling Price</th>
                                    <th>Created</th>
                                    @if ($showActionColumn)
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($products as $index => $product)
                                    <tr data-user-id="{{ $product->id }}" data-username="{{ $product->name }}">
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="productimgname">

                                            @if (isset($product->image))
                                                <a href="javascript:void(0);" class="product-img">
                                                    <img src="{{ asset('uploads/product/products/' . $product->image) }}"
                                                        alt="product">
                                                </a>
                                            @else
                                                <a href="javascript:void(0);" class="product-img">
                                                    <img src="{{ asset('assets/img/white.png') }}" alt="product"
                                                        style="border-radius: 50%">
                                                </a>
                                            @endif
                                            <a href="javascript:void(0);">{{ $product->name }}</a>
                                        </td>

                                        <td>{{ $product->sku_code }}</td>



                                        <td>
                                            {{ $product->quantity }} {{ $product->type->type_name }}


                                        </td>



                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->sale }}</td>
                                        <td>{{ $product->createdBy ? $product->createdBy->username : 'N/A' }}</td>
                                        @if ($showActionColumn)
                                            <td>

                                                @if ($showEditColumn)
                                                    <a class="me-3"
                                                        href="{{ route('product.product.details', ['id' => $product->id]) }}">
                                                        <img src="assets/img/icons/eye.svg" alt="img">
                                                    </a>
                                                    <!-- -->
                                                    <a class="me-3"
                                                        href="{{ route('product.edit', ['id' => $product->id]) }}">
                                                        <img src="assets/img/icons/edit.svg" alt="img">
                                                    </a>
                                                @endif



                                                @if ($showDeleteColumn)
                                                    <form action="{{ route('product.delete', ['id' => $product->id]) }}"
                                                        style="display: inline" method="POST" class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a class="me-3 delete-button" href="javascript:void(0);"
                                                            data-user-id="{{ $product->id }}">
                                                            <img src="assets/img/icons/delete.svg" alt="img">
                                                        </a>

                                                        <div id="deleteModal{{ $product->id }}" class="modal">
                                                            <div class="modal-content">
                                                                <span class="close">&times;</span>
                                                                <h2>Confirm Deletion</h2>
                                                                <p>Are you sure you want to delete the (
                                                                    {{ $product->name }} )
                                                                    product ?</p>
                                                                <button id="confirmDelete" class="confirmDelete noselect"
                                                                    data-user-id="{{ $product->id }}"><span
                                                                        class="text">Yes,
                                                                        Delete</span>&nbsp<span class="icon"><svg
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24"
                                                                            viewBox="0 0 24 24">
                                                                            <path
                                                                                d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z">
                                                                            </path>
                                                                        </svg></span></button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                @endif

                                            </td>
                                        @endif


                                    </tr>
                                @endforeach


                                <script>
                                    $(document).ready(function() {
                                        $('.delete-button').click(function() {
                                            var productId = $(this).data('user-id'); 
                                            
                                            $('#deleteModal' + productId).show();
                                        });

                                        $('.close').click(function() {
                                            $(this).closest('.modal').hide();
                                        });
                                        $('.confirmDelete').click(function(event) {
                                            event.preventDefault(); // Prevent default action
                                            var $form = $(this).closest('.delete-form');
                                            var productId = $(this).data('user-id');
                                           

                                            // Disable the delete button to prevent multiple requests
                                            $(this).prop('disabled', true);

                                            $.ajax({
                                                url: $form.attr('action'),
                                                type: $form.attr('method'),
                                                data: $form.serialize(),
                                                success: function(response) {
                                                    // Handle success
                                                    Toastify({
                                                        text: 'Product Deleted Successfully!',
                                                        duration: 2000,
                                                        gravity: 'top-left',
                                                        close: true,
                                                        backgroundColor: 'linear-gradient(to right, #9e0b04, #1c0805)',
                                                        className: 'toastify-custom',
                                                    }).showToast();
                                                    $('#deleteModal' + productId).hide();
                                                    setTimeout(function() {
                                                        window.location.href =
                                                            '{{ route('product.product.list') }}';
                                                    }, 2000);
                                                },
                                                error: function(xhr, status, error) {
                                                    // Handle error
                                                    var errorMessage = xhr.responseJSON.error;
                                                    Toastify({
                                                        text: errorMessage,
                                                        duration: 3000,
                                                        gravity: 'top-left',
                                                        close: true,
                                                        backgroundColor: 'linear-gradient(to right, #FF5733, #C70039)',
                                                        className: 'toastify-custom',
                                                    }).showToast();
                                                    // Re-enable the delete button on error
                                                    $('.confirmDelete').prop('disabled', false);
                                                }
                                            });
                                        });

                                    });
                                </script>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        $(document).ready(function() {
            const clearButton = $("#clear");

            // Add event listeners to filter inputs
            $("#productName, #createdby, #ProductCode,#productid").on("keyup change",
                function() {
                    const productName = $("#productName").val().toLowerCase();
                    const createdby = $("#createdby").val().toLowerCase();
                    const ProductCode = $("#ProductCode").val().toLowerCase();
                    const productid = $("#productid").val().toLowerCase();

                    $("#userTable").DataTable().columns().every(function() {
                        const columnIndex = this[0][0];
                        let inputValue = "";

                        if (columnIndex === 2) { // Product name column index
                            inputValue = productName;

                        } else if (columnIndex === 1) { // Category column index
                            inputValue = productid;
                        } else if (columnIndex === 7) { // Brand name column index
                            inputValue = createdby;
                        } else if (columnIndex === 3) { // code column index
                            inputValue = ProductCode;
                        }

                        this.search(inputValue, true, false).draw();
                    });
                });
            clearButton.on("click", function() {
                $("#productName, #createdby, #ProductCode,#productid").val(""); // Clear input values
                $("#SubCategorySelect").val(""); // Reset the selected option for SubCategorySelect
                $("#userTable").DataTable().search("").columns().search("")
                    .draw(); // Clear DataTable search and redraw
            });
        });
    </script>

@endsection


@section('custom-js')


    <script>
        const deleteButtons = document.querySelectorAll('.delete-button');
        const modals = document.querySelectorAll('.modal');
        const confirmDeleteButtons = document.querySelectorAll('.confirmDelete');

        // Function to show the modal
        function showModal(productId) {
            document.getElementById(`deleteModal${productId}`).style.display = 'block';
        }

        // Function to close the modal
        function closeModal(productId) {
            document.getElementById(`deleteModal${productId}`).style.display = 'none';
        }

        deleteButtons.forEach(deleteButton => {
            const productId = deleteButton.getAttribute('data-user-id');

            deleteButton.addEventListener('click', () => {
                showModal(productId);
            });

            const closeButton = document.querySelector(`#deleteModal${productId} .close`);
            closeButton.addEventListener('click', () => {
                closeModal(productId);
            });

            const confirmButton = document.querySelector(`#deleteModal${productId} .confirmDelete`);
            confirmButton.addEventListener('click', () => {
                // Perform the delete action here for the user with the specified productId
                // After deletion, you can close the modal
                closeModal(productId);


            });

            const overlay = document.querySelector(`#deleteModal${productId}`);
            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) {
                    // If the click was on the overlay (outside the modal content), close the modal
                    closeModal(productId);
                }
            });
        });
    </script>


    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>
@endsection
