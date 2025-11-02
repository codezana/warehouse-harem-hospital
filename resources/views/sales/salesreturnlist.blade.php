@extends('layouts.nav')

@section('name', 'Sales Return List')
@section('custom-css')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css" rel="stylesheet">


    <style>
        th {
            text-align: center !important;
        }

        td {

            text-align: center
        }

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
@endsection
@section('content')
    @php
        $requiredPermissions = ['View Sales', 'Select all Sales', 'Delete Sales', 'Edit Sales', 'Create Sales'];
        $userHasPermission = false;

        $hasViewSalesPermission = false;
        $hasSelectAllSalesPermission = false;
        $hasEditSalesPermission = false;
        $hasDeleteSalesPermission = false;
        $hasCreateSalesPermission = false;

        foreach ($requiredPermissions as $permission) {
            if (Auth::user()->hasPermission($permission)) {
                $userHasPermission = true;
                if ($permission === 'View Sales') {
                    $hasViewSalesPermission = true;
                } elseif ($permission === 'Select all Sales') {
                    $hasSelectAllSalesPermission = true;
                } elseif ($permission === 'Edit Sales') {
                    $hasEditSalesPermission = true;
                } elseif ($permission === 'Delete Sales') {
                    $hasDeleteSalesPermission = true;
                } elseif ($permission === 'Create Sales') {
                    $hasCreateSalesPermission = true;
                }
            }
        }

    @endphp


    @php
        $showActionColumn =
            $userHasPermission &&
            ($hasEditSalesPermission ||
                ($hasEditSalesPermission && $hasSelectAllSalesPermission) ||
                $hasDeleteSalesPermission ||
                ($hasDeleteSalesPermission && $hasSelectAllSalesPermission) ||
                $hasSelectAllSalesPermission);
    @endphp

    @php
        $showAddColumn =
            $userHasPermission &&
            ($hasCreateSalesPermission ||
                ($hasCreateSalesPermission && $hasSelectAllSalesPermission) ||
                $hasSelectAllSalesPermission);
    @endphp
    @php
        $showEditColumn =
            $userHasPermission &&
            ($hasEditSalesPermission ||
                ($hasEditSalesPermission && $hasSelectAllSalesPermission) ||
                $hasSelectAllSalesPermission);
    @endphp

    @php
        $showDeleteColumn =
            $userHasPermission &&
            ($hasDeleteSalesPermission ||
                ($hasDeleteSalesPermission && $hasSelectAllSalesPermission) ||
                $hasSelectAllSalesPermission);
    @endphp


    <div class="page-wrapper page-wrapper-one">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Sales Return List</h4>
                    <h6>Manage your Returns</h6>
                </div>
                <div class="page-btn">
                    @if ($showAddColumn)
                        <a href="{{ route('createsalesreturns.page') }}" class="btn btn-added"><img src="assets/img/icons/plus.svg"
                                alt="img" class="me-2">Add New Sales Return</a>
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

                    <div class="card" id="filter_inputs">
                        <div class="card-body pb-0">
                            <div class="row">
                             
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" placeholder="Product Name" id="productname">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" placeholder="Customer Name" id="customername">
                                    </div>
                                </div>

                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" placeholder="biller Name" id="biller">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" class="datetimepicker cal-icon" placeholder="Choose Date" id="Date">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-12">
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
                                    <th>Product Name</th>
                                    <th>Product Size</th>

                                    <th>Quantity</th>
                                    <th>Date</th>
                                    <th>Customer</th>
                                    <th>Status</th>
                                    <th>Paid ($)</th>
                                    <th>Paid (IQD)</th>
                                    <th>Biller (🧑‍💻)</th>
                                    @if ($showActionColumn)
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($sales_return as $groupedSales)
                                    @php
                                        // Get the first sale in the group
                                        $firstSale = $groupedSales->first();
                                        $totalQuantity = $groupedSales->sum('quantity');

                                    @endphp
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td class="productimgname">
                                            <a href="javascript:void(0);" class="product-img">
                                                <img src="{{ asset('uploads/product/products/' . $firstSale->product->image) }}"
                                                    alt="product">
                                            </a>
                                            <a href="javascript:void(0);">{{ $firstSale->product->name }}</a>
                                        </td>

                                        <td>
                                            @if($firstSale->product->productSizes->isNotEmpty())
                                                @foreach($firstSale->product->productSizes as $productSize)
                                                    {{ $productSize->size->name }}
                                                    @if (!$loop->last)
                                                        , <!-- Add a comma if it's not the last size -->
                                                    @endif
                                                @endforeach
                                            @else
                                                None
                                            @endif
                                        </td>
                                        <td>{{ $totalQuantity }}</td>
                                        <td>{{ $firstSale->date }}</td>
                                        <td>
                                            @if ($firstSale->customer_id)
                                                {{ $firstSale->customer->customer_name }}
                                            @elseif ($firstSale->user_id)
                                                {{ $firstSale->salesuser->username }}
                                            @else
                                                No customer or user associated
                                            @endif
                                        </td>
                                        <td>
                                            <span
                                                class="badges bg-{{ $firstSale->salesOrder->status === 'Completed' ? 'lightgreen' : 'danger' }}">{{ $firstSale->salesOrder->status }}</span>
                                        </td>
                                        <td> {{ number_format($firstSale->salesOrder->total_dollar, 2) }}</td>
                                        <td>{{ number_format($firstSale->salesOrder->total_dinar, 2) }}</td>
                                        <td>{{ $firstSale->biller ? $firstSale->biller->username : 'N/A' }}</td>
                                        @if ($showActionColumn)
                                            <td class="text-center">
                                                <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown"
                                                    aria-expanded="true">
                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    @if ($showEditColumn)
                                                        <li>
                                                            <a href="{{ route('sale.return.details', ['date' => $firstSale->date, 'receipt' => $firstSale->receipt]) }}"
                                                                class="dropdown-item">
                                                                <img src="assets/img/icons/eye1.svg" class="me-2"
                                                                    alt="img">
                                                                Sale Detail
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="{{ route('sale.edit.return', ['date' => $firstSale->date, 'receipt' => $firstSale->receipt]) }}"
                                                                class="dropdown-item"><img src="assets/img/icons/edit.svg"
                                                                    class="me-2" alt="img">Edit
                                                                Sale Return</a>
                                                        </li>
                                                    @endif

                                                    <li>
                                                        <a href="javascript:void(0);" class="dropdown-item"><img
                                                                src="assets/img/icons/download.svg" class="me-2"
                                                                alt="img">Download pdf</a>
                                                    </li>
                                                    @if ($showDeleteColumn)
                                                        <li>
                                                 
                                                                    <a href="javascript:void(0);"
                                                                    action="{{ route('destroy.sale.return', ['date' => $firstSale->date, 'receipt' => $firstSale->receipt]) }}"
                                                                    data-user-id="{{ $firstSale->id }}"
                                                                    class="dropdown-item delete-button">
                                                                    <img src="assets/img/icons/delete1.svg" class="me-2"
                                                                        alt="img">Delete Sale
                                                                </a>
                                                        </li>

                                                    @endif
                                                </ul>
                                            </td>
                                        @endif

                                    </tr>

                                                   <!-- Delete firstSale Modal -->
                                                   <div id="deleteModal{{ $firstSale->id }}" class="modal">
                                                    <div class="modal-content">
                                                        <span class="close">&times;</span>
                                                        <h2>Confirm Deletion</h2>
                                                        <form id="deleteForm{{ $firstSale->id }}"
                                                            action="{{ route('destroy.sale.return', ['date' => $firstSale->date, 'receipt' => $firstSale->receipt]) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
            
                                                            <p>Are you sure you want to {{ $firstSale->product->name }} delete this item?</p>
                                                            <button class="confirmDelete noselect"
                                                                data-type-id="{{ $firstSale->id }}">
                                                                <span class="text">Yes, Delete</span>
                                                                <span class="icon">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24">
                                                                        <path
                                                                            d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z">
                                                                        </path>
                                                                    </svg>
                                                                </span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
            
                                @endforeach
                                <script>
                                    $(document).ready(function() {
                                        $('.delete-button').click(function() {
                                            var userId = $(this).data('user-id');
                                            $('#deleteModal' + userId).show();
                                        });

                                        $('.confirmDelete').click(function(event) {
                                            event.preventDefault(); // Prevent default form submission

                                            var userId = $(this).data('type-id');
                                            var $form = $('#deleteForm' + userId); // assuming each form has a unique ID
                                            console.log("URL for AJAX request:", $form.attr('action'));

                                            $.ajax({
                                                url: $form.attr('action'),
                                                type: $form.attr('method'),
                                                data: $form.serialize(),
                                                success: function(response) {
                                                    // Handle success response
                                                    if (response.message) {
                                                        Toastify({
                                                            text: response.message,
                                                            duration: 2000,
                                                            gravity: 'top-left',
                                                            close: true,
                                                            backgroundColor: 'linear-gradient(to right, #9e0b04, #1c0805)',
                                                            className: 'toastify-custom',
                                                        }).showToast();

                                                        // Optional: Reload the page after 2000ms
                                                        setTimeout(function() {
                                                            location.reload();
                                                        }, 2000);
                                                    } else {
                                                        console.error("Unexpected response:", response);
                                                    }
                                                },
                                                error: function(xhr, status, error) {
                                                    console.log(xhr, status, error);
                                                    Toastify({
                                                        text: 'Have Error !',
                                                        duration: 2000,
                                                        gravity: 'top-left',
                                                        close: true,
                                                        backgroundColor: 'linear-gradient(to right, #9e0b04, #1c0805)',
                                                        className: 'toastify-custom',
                                                    }).showToast();
                                                }
                                            });
                                        });


                                        $('.close').click(function() {
                                            $(this).closest('.modal').hide();
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
            $("#Date").on("focusout",
                function() {
                    const Date = $("#Date").val();
                    var rtldate="";
    
               var Datetext=Date;
               for(var year=6; year<10 ;year++){
                rtldate+=Datetext[year];
    
               };
              
               for(var month=2; month<6 ;month++){
                rtldate+=Datetext[month];
               };
               for(var day=0; day<2 ;day++){
                rtldate+=Datetext[day];
               };
                    $("#userTable").DataTable().columns().every(function() {
                        const columnIndex = this[0][0];
                        let inputValue = "";
    
                        if (columnIndex === 3) { // Product name column index
                            inputValue = rtldate;
                        } 
    
    
                        this.search(inputValue, true, false).draw();
                    });
                });
               
    
                $("#customername,#productname,#biller").on("keyup change",
                function() {
                    const customername = $("#customername").val().toLowerCase();
                    const productname = $("#productname").val().toLowerCase();
                    const biller = $("#biller").val().toLowerCase();
                   
    
                    $("#userTable").DataTable().columns().every(function() {
                        const columnIndex = this[0][0];
                        let inputValue = "";
    
                        if (columnIndex === 4) { // Product name column index
                            inputValue = customername;
                        } else if(columnIndex === 1){
                            inputValue = productname;
    
                        }else if(columnIndex === 8){
                            inputValue = biller;
    
                        }
                       
    
    
                        this.search(inputValue, true, false).draw();
                    });
                });
    
    
    
    
    
    
    
            clearButton.on("click", function() {
                $("#Date,#customername,#productname,#biller").val(
                    ""); // Clear input values
                $("#userTable").DataTable().search("").columns().search("")
                    .draw(); // Clear DataTable search and redraw
            });
        });
    
    
    </script>
    












    <script>
        const deleteButtons = document.querySelectorAll('.delete-button');
        const confirmDeleteButtons = document.querySelectorAll('.confirmDelete');
    
        // Function to show the modal
        function showModal(categorysId) {
            document.getElementById(`deleteModal${categorysId}`).style.display = 'block';
        }
    
        // Function to close the modal
        function closeModal(categorysId) {
            document.getElementById(`deleteModal${categorysId}`).style.display = 'none';
        }
    
        deleteButtons.forEach(deleteButton => {
            const categorysId = deleteButton.getAttribute('data-user-id');
    
            deleteButton.addEventListener('click', () => {
                showModal(categorysId);
            });
    
            const closeButton = document.querySelector(`#deleteModal${categorysId} .close`);
            closeButton.addEventListener('click', () => {
                closeModal(categorysId);
            });
    
            const confirmButton = document.querySelector(`#deleteModal${categorysId} .confirmDelete`);
            confirmButton.addEventListener('click', () => {
                // Perform the delete action here for the user with the specified categorysId
                // After deletion, you can close the modal
                closeModal(categorysId);
    
                // // Simulate a successful delete action, you should replace this with your actual logic
                // const success = true; // Set this to true if the deletion was successful, false otherwise
                // const username = $(`tr[data-user-id="${categorysId}"]`).data("username");
                // const toastrOptions = {
                //     "closeButton": true,
                //     "debug": true,
                //     "newestOnTop": false,
                //     "progressBar": true,
                //     "positionClass": "toast-bottom-right",
                //     "preventDuplicates": false,
                //     "showDuration": "300",
                //     "hideDuration": "1000",
                //     "timeOut": "5000",
                //     "extendedTimeOut": "1000",
                //     "showEasing": "swing",
                //     "hideEasing": "linear",
                //     "showMethod": "fadeIn",
                //     "hideMethod": "fadeOut"
                // };
    
                // if (success) {
                //     toastr.success(`Category ${username} Deleted successfully!`, "Done", toastrOptions);
                // } else {
                //     toastr.error(`Deletion for ${username} failed. Please try again.`, "Error",
                //         toastrOptions);
                // }
            });
    
            const overlay = document.querySelector(`#deleteModal${categorysId}`);
            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) {
                    // If the click was on the overlay (outside the modal content), close the modal
                    closeModal(categorysId);
                }
            });
        });
    </script>
    


@endsection
@section('custom-js')

    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
