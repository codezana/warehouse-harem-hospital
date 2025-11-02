@extends('layouts.nav')

@section('name', 'Purchase List')
@section('custom-css')
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">
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
        $requiredPermissions = [
            'View Purchase',
            'Select all Purchase',
            'Delete Purchase',
            'Edit Purchase',
            'Create Purchase',
        ];
        $userHasPermission = false;

        $hasViewPurchasePermission = false;
        $hasSelectAllPurchasePermission = false;
        $hasEditPurchasePermission = false;
        $hasDeletePurchasePermission = false;
        $hasCreatePurchasePermission = false;

        foreach ($requiredPermissions as $permission) {
            if (Auth::user()->hasPermission($permission)) {
                $userHasPermission = true;
                if ($permission === 'View Purchase') {
                    $hasViewPurchasePermission = true;
                } elseif ($permission === 'Select all Purchase') {
                    $hasSelectAllPurchasePermission = true;
                } elseif ($permission === 'Edit Purchase') {
                    $hasEditPurchasePermission = true;
                } elseif ($permission === 'Delete Purchase') {
                    $hasDeletePurchasePermission = true;
                } elseif ($permission === 'Create Purchase') {
                    $hasCreatePurchasePermission = true;
                }
            }
        }

    @endphp


    @php
        $showActionColumn =
            $userHasPermission &&
            ($hasEditPurchasePermission ||
                ($hasEditPurchasePermission && $hasSelectAllPurchasePermission) ||
                $hasDeletePurchasePermission ||
                ($hasDeletePurchasePermission && $hasSelectAllPurchasePermission) ||
                $hasSelectAllPurchasePermission);
    @endphp

    @php
        $showAddColumn =
            $userHasPermission &&
            ($hasCreatePurchasePermission ||
                ($hasCreatePurchasePermission && $hasSelectAllPurchasePermission) ||
                $hasSelectAllPurchasePermission);
    @endphp
    @php
        $showEditColumn =
            $userHasPermission &&
            ($hasEditPurchasePermission ||
                ($hasEditPurchasePermission && $hasSelectAllPurchasePermission) ||
                $hasSelectAllPurchasePermission);
    @endphp

    @php
        $showDeleteColumn =
            $userHasPermission &&
            ($hasDeletePurchasePermission ||
                ($hasDeletePurchasePermission && $hasSelectAllPurchasePermission) ||
                $hasSelectAllPurchasePermission);
    @endphp
    <div class="page-wrapper page-wrapper-one">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>PURCHASE LIST</h4>
                    <h6>Manage your purchases</h6>
                </div>
                <div class="page-btn">
                    @if ($showAddColumn)
                        <a href="{{ route('addpurchasepage') }}" class="btn btn-added">
                            <img src="assets/img/icons/plus.svg" alt="img">Add New Purchases
                        </a>
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
                              
                                <div class="col-lg col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" placeholder="Enter ProductName" id="productname">
                                    </div>
                                </div>
                                <div class="col-lg col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" placeholder="Enter SupplierName" id="suppliername">
                                    </div>
                                </div> 
                                
                                <div class="col-lg col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" placeholder="Enter refference" id="refference">
                                    </div>
                                </div>
                                <div class="col-lg col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" placeholder="Enter biller" id="biller">
                                    </div>
                                </div>
                                
                                <div class="col-lg col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" class="datetimepicker cal-icon" placeholder="Choose Date" id="Date">
                                    </div>
                                </div>
                                <div class="col-lg col-sm-6 col-12">
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
                                    <th>Supplier Name</th>

                                    <th>Reference</th>
                                    <th>Date</th>
                                    <th>Grand Total</th>
                                    <th>Paid</th>
                                    <th>Shipping</th>
                                    <th>Payment Status</th>
                                    <th>Biller</th>
                                    @if ($showActionColumn)
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($purchase as $purchases)
                                    @php
                                        // Get the first sale in the group
                                        $firstPurchase = $purchases->first();
                                        $totalQuantity = $purchases->sum('quantity');
                                
                                  

                                    @endphp
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td class="text-bolds">{{ $firstPurchase->product->name }}</td>
                                        <td>{{ $firstPurchase->supplier->supplier_name }}</td>
                                        <td>{{ $firstPurchase->product->sku_code }}</td>
                                        <td>{{ $firstPurchase->date }}</td>
                                        <td>{{ $firstPurchase->totalPurchase->grand_total }}</td>
                                        <td>{{ $firstPurchase->totalPurchase->paid }}</td>
                                        <td>{{ $firstPurchase->totalPurchase->shipping_total }}</td>

                                        <td>
                                            <span
                                                class="badges bg-{{ $firstPurchase->totalPurchase->status === 'Completed' ? 'lightgreen' : 'danger' }}">{{ $firstPurchase->totalPurchase->status === 'Completed' ? 'Paid' : 'Unpaid' }}</span>
                                        </td>
                                        <td>{{ $firstPurchase->biller ? $firstPurchase->biller->username : 'N/A' }}</td>

                                        @if ($showActionColumn)
                                            <td class="text-center">
                                                <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown"
                                                    aria-expanded="true">
                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    @if ($showEditColumn)
                                                    <li>
                                                        <a href="{{ route('purchase.details', ['date' => $firstPurchase->date, 'reference' => $firstPurchase->reference]) }}"
                                                            class="dropdown-item">
                                                            <img src="assets/img/icons/eye1.svg" class="me-2"
                                                                alt="img">
                                                            Purchase Detail
                                                        </a>
                                                    </li>
                                                        <li>
                                                            <a href="{{ route('edit.purchase', ['date' => $firstPurchase->date, 'reference' => $firstPurchase->reference]) }}"
                                                                class="dropdown-item"><img src="assets/img/icons/update.svg"
                                                                    class="me-2" alt="img">Edit
                                                                Purchase</a>
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
                                                                    action="{{ route('destroy.purchase', ['date' => $firstPurchase->date, 'reference' => $firstPurchase->reference]) }}"
                                                                    data-user-id="{{ $firstPurchase->id }}"
                                                                    class="dropdown-item delete-button">
                                                                    <img src="assets/img/icons/delete1.svg" class="me-2"
                                                                        alt="img">Delete Purchase
                                                                </a>
                                                        </li>

                                                 
                                                    @endif
                                                </ul>
                                            </td>
                                        @endif
                                    </tr>




                                       <!-- Delete firstPurchase Modal -->
                                       <div id="deleteModal{{ $firstPurchase->id }}" class="modal">
                                        <div class="modal-content">
                                            <span class="close">&times;</span>
                                            <h2>Confirm Deletion</h2>
                                            <form id="deleteForm{{ $firstPurchase->id }}"
                                                action="{{ route('destroy.purchase', ['date' => $firstPurchase->date, 'reference' => $firstPurchase->reference]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <p>Are you sure you want to {{ $firstPurchase->product->name }} delete this item?</p>
                                                <button class="confirmDelete noselect"
                                                    data-type-id="{{ $firstPurchase->id }}">
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





















@endsection















@section('custom-js')



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

                    if (columnIndex === 4) { // Product name column index
                        inputValue = rtldate;
                    } 


                    this.search(inputValue, true, false).draw();
                });
            });
           

            $("#productname,#suppliername,#refference,#biller").on("keyup change",
            function() {
                const productname = $("#productname").val().toLowerCase();
                const suppliername = $("#suppliername").val().toLowerCase();
                const refference = $("#refference").val().toLowerCase();
                const biller = $("#biller").val().toLowerCase();
               

                $("#userTable").DataTable().columns().every(function() {
                    const columnIndex = this[0][0];
                    let inputValue = "";

                    if (columnIndex === 1) { // Product name column index
                        inputValue = productname;
                    } else if(columnIndex===2){
                        inputValue=suppliername;
                    } else if(columnIndex===3){
                        inputValue=refference;
                    } else if(columnIndex===9){
                        inputValue=biller;
                    }
                   


                    this.search(inputValue, true, false).draw();
                });
            });







        clearButton.on("click", function() {
            $("#Date,#productname,#suppliername,#biller").val(
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



    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>
@endsection
