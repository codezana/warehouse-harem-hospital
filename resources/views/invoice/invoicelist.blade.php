@extends('layouts.nav')

@section('name', 'Invoice List')


@section('custom-css')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">






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
            'View Invoices',
            'Select all Invoices',
            'Delete Invoices',
            'Edit Invoices',
            'Create Invoices',
        ];
        $userHasPermission = false;

        $hasViewInvoicesPermission = false;
        $hasSelectAllInvoicesPermission = false;
        $hasEditInvoicesPermission = false;
        $hasDeleteInvoicesPermission = false;
        $hasCreateInvoicesPermission = false;

        foreach ($requiredPermissions as $permission) {
            if (Auth::user()->hasPermission($permission)) {
                $userHasPermission = true;
                if ($permission === 'View Invoices') {
                    $hasViewInvoicesPermission = true;
                } elseif ($permission === 'Select all Invoices') {
                    $hasSelectAllInvoicesPermission = true;
                } elseif ($permission === 'Edit Invoices') {
                    $hasEditInvoicesPermission = true;
                } elseif ($permission === 'Delete Invoices') {
                    $hasDeleteInvoicesPermission = true;
                } elseif ($permission === 'Create Invoices') {
                    $hasCreateInvoicesPermission = true;
                }
            }
        }

    @endphp


    @php
        $showActionColumn =
            $userHasPermission &&
            ($hasEditInvoicesPermission ||
                ($hasEditInvoicesPermission && $hasSelectAllInvoicesPermission) ||
                $hasDeleteInvoicesPermission ||
                ($hasDeleteInvoicesPermission && $hasSelectAllInvoicesPermission) ||
                $hasSelectAllInvoicesPermission);
    @endphp


    @php
        $showEditColumn =
            $userHasPermission &&
            ($hasEditInvoicesPermission ||
                ($hasEditInvoicesPermission && $hasSelectAllInvoicesPermission) ||
                $hasSelectAllInvoicesPermission);
    @endphp

    @php
        $showDeleteColumn =
            $userHasPermission &&
            ($hasDeleteInvoicesPermission ||
                ($hasDeleteInvoicesPermission && $hasSelectAllInvoicesPermission) ||
                $hasSelectAllInvoicesPermission);
    @endphp
    <div class="page-wrapper page-wrapper-one">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Invoice List</h4>
                    <h6>Manage your Invoice</h6>
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
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" placeholder="Enter id" id="Invoiceid">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" placeholder="Enter Invoice Name" id="Invoicename">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" placeholder="Enter Invoice code" id="Invoicecode">
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <a class="btn btn-filters ms-auto" style="background-color: #ffffff;"><img
                                                src="assets/img/icons/clears.svg" alt="img" id="clear"></a>
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
                                    <th>Customer</th>
                                    <th>Invoice Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>SubTotal</th>
                                    <th>Amount</th>
                                    @if ($showActionColumn)
                                        <th class="text-center">Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $index => $invoice)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $invoice->invoice->customer->customer_name }}</td>
                                        <td> {{ $invoice->product->name }}</td>
                                        <td>{{ $invoice->quantity }}</td>
                                        <td>{{ $invoice->price_per_unit }}</td>
                                        <td>{{ $invoice->total_amount }}</td>
                                        <th>{{ $invoice->invoice->total_amount }}</th>


                                        <td class="text-center">
                                            <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown"
                                                aria-expanded="true">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </a>
                                            <ul class="dropdown-menu">

                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#createpayment{{ $invoice->id }}"><img
                                                            src="assets/img/icons/update.svg" class="me-2"
                                                            alt="img">Edit Invoice</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item"><img
                                                            src="assets/img/icons/download.svg" class="me-2"
                                                            alt="img">Download pdf</a>
                                                </li>


                                                <li>
                                                    <a href="javascript:void(0);"
                                                        action="{{ route('invoice.delete', ['id' => $invoice->id]) }}"
                                                        data-user-id="{{ $invoice->id }}"
                                                        class="dropdown-item delete-button">
                                                        <img src="assets/img/icons/delete1.svg" class="me-2"
                                                            alt="img">Delete Invoice
                                                    </a>
                                                </li>



                                            </ul>
                                        </td>
                                    </tr>

                                    <!-- Delete type Modal -->
                                    <div id="deleteModal{{ $invoice->id }}" class="modal">
                                        <div class="modal-content">
                                            <span class="close">&times;</span>
                                            <h2>Confirm Deletion</h2>
                                            <form id="deleteForm{{ $invoice->id }}"
                                                action="{{ route('invoice.delete', ['id' => $invoice->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <p>Are you sure you want to {{ $invoice->type_name }} delete this item?</p>
                                                <button class="confirmDelete noselect"
                                                    data-type-id="{{ $invoice->id }}">
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


                                    <div class="modal fade" id="createpayment{{ $invoice->id }}" tabindex="-1"
                                        aria-labelledby="createpayment{{ $invoice->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <form id="form-data" method="POST"
                                                    action="{{ route('invoice.update') }}">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Update Invoice 📦</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"><span aria-hidden="true">×</span></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="row">
                                                            <input type="hidden" id="id" name="id"
                                                                value="{{ $invoice->id }}">

                                                            <div class="col-lg-6 col-sm-12 col-12">
                                                                <div class="form-group">

                                                                    <label for="type_name">{{ __('Type Name') }}</label>

                                                                    <input class="form-control" type="text"
                                                                        value="{{ $invoice->type_name }}" id="type_name"
                                                                        name="type_name" autofocus />


                                                                </div>
                                                            </div>



                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label for="description">Description</label>
                                                                    <textarea id="description" name="description" class="form-control ">{{ $invoice->description }}</textarea>


                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button id="submitBtnInvoice" type="submit"
                                                            class="btn btn-submit">Submit</button>
                                                        <button type="button" class="btn btn-cancel"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </form>
                                            </div>
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
                                                    var errorMessage = xhr.responseJSON.error;
                                                    Toastify({
                                                        text: errorMessage,
                                                        duration: 3000,
                                                        gravity: 'top-left',
                                                        close: true,
                                                        backgroundColor: 'linear-gradient(to right, #FF5733, #C70039)',
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
    </div>




    <script>
        $(document).ready(function() {
            $('#submitBtnInvoice').click(function(e) {
                e.preventDefault(); // Prevent form from submitting normally

                var id = $('#id').val();
                var InvoiceName = $('#type_name').val();

                // Get the value of the textarea for Invoice description
                var InvoiceDescription = $('#description').val();


                // Check if name input is empty
                if (InvoiceName.trim() === '') {

                    Toastify({
                        text: ' Name is required!',
                        duration: 3000,
                        gravity: 'top-left', // Position the toast notification at the top left corner
                        close: true, // Show a close button
                        backgroundColor: '#ff0000', // Red background color for error
                        className: 'toastify-custom', // Custom CSS class for styling
                    }).showToast();
                    return; // Exit function if name input is empty
                }

                // Check if description input is empty
                if (InvoiceDescription.trim() === '') {

                    Toastify({
                        text: 'Description is required!',
                        duration: 3000,
                        gravity: 'top-left', // Position the toast notification at the top left corner
                        close: true, // Show a close button
                        backgroundColor: '#ff0000', // Red background color for error
                        className: 'toastify-custom', // Custom CSS class for styling
                    }).showToast();
                    return; // Exit function if description input is empty
                }


                // Create FormData object
                var formData = new FormData();
                formData.append('id', id);

                formData.append('name', InvoiceName);
                formData.append('description', InvoiceDescription);

                // Get CSRF token value from the meta tag
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                // Send AJAX request
                $.ajax({
                    url: "{{ route('invoice.update') }}",
                    type: "POST",
                    data: formData,
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false, // Prevent jQuery from setting content type
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
                    },
                    success: function(response) {
                        Toastify({
                            text: 'Invoice Updated Successfully !',
                            duration: 2000,
                            gravity: 'top-left', // Position the toast notification at the top left corner
                            close: true, // Show a close button
                            backgroundColor: 'linear-gradient(to right, #01919C, #2B2B2B)', // Custom background color
                            className: 'toastify-custom', // Custom CSS class for styling
                        }).showToast();



                        setTimeout(function() {
                            window.location.href =
                                '{{ route('typelist.page') }}';
                        }, 2000);
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









@endsection

@section('custom-js')







    <script>
        $(document).ready(function() {
            const clearButton = $("#clear");

            // Add event listeners to filter inputs
            $("#Invoiceid, #Invoicename, #Invoicecode").on("keyup change",
                function() {
                    const Invoiceid = $("#Invoiceid").val().toLowerCase();
                    const Invoicename = $("#Invoicename").val().toLowerCase();
                    const Invoicecode = $("#Invoicecode").val().toLowerCase();

                    $("#userTable").DataTable().columns().every(function() {
                        const columnIndex = this[0][0];
                        let inputValue = "";

                        if (columnIndex === 1) { // Invoices name column index
                            inputValue = Invoiceid;

                        } else if (columnIndex === 2) { // Category column index
                            inputValue = Invoicename;

                        } else if (columnIndex === 3) { // code column index
                            inputValue = Invoicecode;
                        }

                        this.search(inputValue, true, false).draw();
                    });
                });
            clearButton.on("click", function() {
                $("#Invoiceid, #Invoicename, #Invoicecode").val(""); // Clear input values
                $("#SubCategorySelect").val(""); // Reset the selected option for SubCategorySelect
                $("#userTable").DataTable().search("").columns().search("")
                    .draw(); // Clear DataTable search and redraw
            });
        });
    </script>










    <script>
        // Redirect to the print page














        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('print-button').addEventListener('click', function() {
                let selectedRows = [];

                document.querySelectorAll('#data-table tbody input[type="checkbox"]').forEach(function(
                    checkbox) {
                    if (checkbox.checked) {
                        let row = checkbox.closest('tr');
                        let rowData = [];

                        // Skip the checkbox column (start loop from 1)
                        for (let i = 1; i < row.cells.length - 1; i++) {
                            rowData.push(row.cells[i].innerText);
                        }

                        selectedRows.push(rowData);
                    }
                });

                localStorage.setItem('printData', JSON.stringify(selectedRows));
                var url = "{{ asset('print') }}";

                // Redirect to the print page
                window.open(url, '_blank');
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


    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>


@endsection
