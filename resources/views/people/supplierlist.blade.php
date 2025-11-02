@extends('layouts.nav')

@section('name', 'Supplier List')
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



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
            'View Supplier',
            'Select all Supplier',
            'Delete Supplier',
            'Edit Supplier',
            'Create Supplier',
        ];
        $userHasPermission = false;

        $hasViewSupplierPermission = false;
        $hasSelectAllSupplierPermission = false;
        $hasEditSupplierPermission = false;
        $hasDeleteSupplierPermission = false;
        $hasCreateSupplierPermission = false;

        foreach ($requiredPermissions as $permission) {
            if (Auth::user()->hasPermission($permission)) {
                $userHasPermission = true;
                if ($permission === 'View Supplier') {
                    $hasViewSupplierPermission = true;
                } elseif ($permission === 'Select all Supplier') {
                    $hasSelectAllSupplierPermission = true;
                } elseif ($permission === 'Edit Supplier') {
                    $hasEditSupplierPermission = true;
                } elseif ($permission === 'Delete Supplier') {
                    $hasDeleteSupplierPermission = true;
                } elseif ($permission === 'Create Supplier') {
                    $hasCreateSupplierPermission = true;
                }
            }
        }

    @endphp


    @php
        $showActionColumn =
            $userHasPermission &&
            ($hasEditSupplierPermission ||
                ($hasEditSupplierPermission && $hasSelectAllSupplierPermission) ||
                $hasDeleteSupplierPermission ||
                ($hasDeleteSupplierPermission && $hasSelectAllSupplierPermission) ||
                $hasSelectAllSupplierPermission);
    @endphp

    @php
        $showAddColumn =
            $userHasPermission &&
            ($hasCreateSupplierPermission ||
                ($hasCreateSupplierPermission && $hasSelectAllSupplierPermission) ||
                $hasSelectAllSupplierPermission);
    @endphp
    @php
        $showEditColumn =
            $userHasPermission &&
            ($hasEditSupplierPermission ||
                ($hasEditSupplierPermission && $hasSelectAllSupplierPermission) ||
                $hasSelectAllSupplierPermission);
    @endphp

    @php
        $showDeleteColumn =
            $userHasPermission &&
            ($hasDeleteSupplierPermission ||
                ($hasDeleteSupplierPermission && $hasSelectAllSupplierPermission) ||
                $hasSelectAllSupplierPermission);
    @endphp
    <div class="page-wrapper page-wrapper-one">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Supplier List</h4>
                    <h6>Manage your Suppliers</h6>
                </div>
                <div class="page-btn">
                    @if ($showAddColumn)
                        <a href="{{ route('addsupplier.page') }}" class="btn btn-added"><img src="assets/img/icons/plus.svg" alt="img">Add
                            Supplier</a>
                    @endif

                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }} <i class='bx bx-cool'></i></div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
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

                    <div class="card" id="filter_inputs">
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" placeholder="Supplier id" id="supplierid">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" placeholder="Supplier Name" id="supplierName">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" placeholder="Phone Number" id="supplierPhone">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" placeholder="Supplier Email" id="supplierEmail">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" placeholder="Supplier City" id="supplierCity">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" placeholder="created by" id="CreatedBy">
                                    </div>
                                </div>
                            
                               <div class="col-lg-2 col-sm-6 col-12 ms-auto">
                                    <div class="form-group">
                                        <a class="btn btn-filters ms-auto" style="background-color: #ffffff;"><img
                                                src="assets/img/icons/clears.svg" alt="img" id="clear"></a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table datanew" id="userTable">
                            <thead>
                                <tr>
                                    <th>
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th>
                                    <th>ID</th>
                                    <th>Avatar</th>
                                    <th>Supplier Name</th>
                                    <th>Phone</th>
                                    <th>email</th>
                                    <th>City</th>
                                    <th>Created By</th>
                                    @if ($showActionColumn)

                                    <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($suppliers as $index => $supplier)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="productimgname">


                               

                                            <a href="javascript:void(0);" class="product-img">
                                                @if ($supplier->avatar==null)
                                                <img src="{{ asset('assets/img/white.png') }}"
                                                alt="supplier Pic" style="border-radius: 50%">
                                                @else
                                                <img src="{{ asset('uploads/suppliers/' . $supplier->avatar) }}"
                                                alt="supplier Pic">
                                                @endif
                                               
                                            </a>


                                        </td>
                                        <td>{{ $supplier->supplier_name }}</td>
                                        <td>{{ $supplier->phone }}</td>
                                        <td>{{ $supplier->email }}</td>
                                        <td>{{ $supplier->city }}</td>
                                        <td>{{ $supplier->createdBy ? $supplier->createdBy->username : 'N/A' }}</td>

                                        @if ($showActionColumn)

                                        <td>

                                            @if($showEditColumn)
                                            <a class="me-3"
                                            href="{{ route('editsupplier.page', ['id' => $supplier->id]) }}">
                                            <img src="assets/img/icons/edit.svg" alt="Edit">
                                        </a>       
                                            @endif
                                            @if ($showDeleteColumn)
                                            <form action="{{ route('supplier.delete', ['id' => $supplier->id]) }}"
                                                style="display: inline" method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <a class="me-3 delete-button" href="javascript:void(0);"
                                                    data-user-id="{{ $supplier->id }}">
                                                    <img src="assets/img/icons/delete.svg" alt="img">
                                                </a>

                                                <div id="deleteModal{{ $supplier->id }}" class="modal">
                                                    <div class="modal-content">
                                                        <span class="close">&times;</span>
                                                        <h2>Confirm Deletion</h2>
                                                        <p>Are you sure you want to delete the (
                                                            {{ $supplier->supplier_name }} )
                                                            supplier ?</p>
                                                        <button id="confirmDelete" class="confirmDelete noselect"
                                                            data-user-id="{{ $supplier->id }}"><span
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
                                            var supplierId = $(this).data('user-id'); // Retrieve product ID from data-user-id attribute
                                            $('#deleteModal' + supplierId).show();
                                        });

                                        $('.close').click(function() {
                                            $(this).closest('.modal').hide();
                                        });
                                        $('.confirmDelete').click(function(event) {
                                            event.preventDefault(); // Prevent default action
                                            var $form = $(this).closest('.delete-form');
                                            var supplierId = $(this).data('user-id');

                                            // Disable the delete button to prevent multiple requests
                                            $(this).prop('disabled', true);

                                            $.ajax({
                                                url: $form.attr('action'),
                                                type: $form.attr('method'),
                                                data: $form.serialize(),
                                                success: function(response) {
                                                    // Handle succes
                                                    Toastify({
                                                        text: 'Supplier Deleted Successfully!',
                                                        duration: 2000,
                                                        gravity: 'top-left',
                                                        close: true,
                                                        backgroundColor: 'linear-gradient(to right, #9e0b04, #1c0805)',
                                                        className: 'toastify-custom',
                                                    }).showToast();
                                                    $('#deleteModal' + supplierId).hide();


                                                    setTimeout(function() {
                                            window.location.href =
                                            '{{ route('supplierlist.page') }}';
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
                                                    // // Re-enable the delete button on error
                                                    $('.confirmDelete').prop('disabled', false);
                                                    $('#deleteModal' + supplierId).hide();

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



@endsection
@section('custom-js')



    <script>
        $(document).ready(function() {
            const clearButton = $("#clear");

            // Add event listeners to filter inputs
            $("#supplierName, #supplierPhone, #supplierEmail, #supplierCity,#CreatedBy,#supplierid").on("keyup change",
                function() {
                    const supplierName = $("#supplierName").val().toLowerCase();
                    const supplierPhone = $("#supplierPhone").val();
                    const supplierEmail = $("#supplierEmail").val().toLowerCase();
                    const supplierCIty = $("#supplierCity").val().toLowerCase();
                    const CreatedBy = $("#CreatedBy").val().toLowerCase();
                    const supplierid = $("#supplierid").val().toLowerCase();

                    $("#userTable").DataTable().columns().every(function() {
                        const columnIndex = this[0][0];
                        let inputValue = "";

                        if (columnIndex === 3) { // Product name column index
                            inputValue = supplierName;
                        } else if (columnIndex === 4) { // Category column index
                            inputValue = supplierPhone;
                        }else if (columnIndex === 1) { // Category column index
                            inputValue = supplierid;
                        } else if (columnIndex === 5) { // Brand name column index
                            inputValue = supplierEmail;
                        } else if (columnIndex === 6) { // SubCategory column index
                            inputValue = supplierCIty;
                        }
                        else if (columnIndex === 7) { // SubCategory column index
                            inputValue = CreatedBy;
                        }


                        this.search(inputValue, true, false).draw();
                    });
                });
            clearButton.on("click", function() {
                $("#supplierName, #supplierPhone, #supplierEmail, #supplierCIty,#CreatedBy,#CreatedBy,#supplierid").val(
                    ""); // Clear input values
                $("#userTable").DataTable().search("").columns().search("")
                    .draw(); // Clear DataTable search and redraw
            });
        });
    </script>
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
            // confirmButton.addEventListener('click', () => {
            //     // Perform the delete action here for the user with the specified productId
            //     // After deletion, you can close the modal
            //     closeModal(productId);

            //     // Simulate a successful delete action, you should replace this with your actual logic
            //     const success = true; // Set this to true if the deletion was successful, false otherwise
            //     const username = $(`tr[data-user-id="${productId}"]`).data("username");
            //     const toastrOptions = {
            //         "closeButton": true,
            //         "debug": true,
            //         "newestOnTop": false,
            //         "progressBar": true,
            //         "positionClass": "toast-bottom-right",
            //         "preventDuplicates": false,
            //         "showDuration": "300",
            //         "hideDuration": "1000",
            //         "timeOut": "5000",
            //         "extendedTimeOut": "1000",
            //         "showEasing": "swing",
            //         "hideEasing": "linear",
            //         "showMethod": "fadeIn",
            //         "hideMethod": "fadeOut"
            //     };

            //     if (success) {
            //         toastr.success(`supplier ${username} Deleted successfully!`, "Done", toastrOptions);
            //     } else {
            //         toastr.error(`Deletion for ${username} failed. Please try again.`, "Error",
            //             toastrOptions);
            //     }
            // });

            const overlay = document.querySelector(`#deleteModal${productId}`);
            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) {
                    // If the click was on the overlay (outside the modal content), close the modal
                    closeModal(productId);
                }
            });
        });
    </script>


    <script src="assets/plugins/select2/js/select2.min.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
    <script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
    <script src="assets/plugins/sweetalert/sweetalerts.min.js"></script>

@endsection
