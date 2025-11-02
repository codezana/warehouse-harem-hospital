@extends('layouts.nav')

@section('name', 'User Lists')
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.7/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="toastr.min.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- Add Bootstrap JavaScript (usually before closing </body>) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
            'View User Management',
            'Select all User Management',
            'Delete User Management',
            'Edit User Management',
            'Create User Management',
        ];
        $userHasPermission = false;

        $hasViewUserPermission = false;
        $hasSelectAllUserPermission = false;
        $hasEditUserPermission = false;
        $hasDeleteUserPermission = false;
        $hasCreateUserPermission = false;

        foreach ($requiredPermissions as $permission) {
            if (Auth::user()->hasPermission($permission)) {
                $userHasPermission = true;
                if ($permission === 'View User Management') {
                    $hasViewUserPermission = true;
                } elseif ($permission === 'Select all User Management') {
                    $hasSelectAllUserPermission = true;
                } elseif ($permission === 'Edit User Management') {
                    $hasEditUserPermission = true;
                } elseif ($permission === 'Delete User Management') {
                    $hasDeleteUserPermission = true;
                } elseif ($permission === 'Create User Management') {
                    $hasCreateUserPermission = true;
                }
            }
        }

    @endphp


    @php
        $showActionColumn =
            $userHasPermission &&
            ($hasEditUserPermission ||
                ($hasEditUserPermission && $hasSelectAllUserPermission) ||
                $hasDeleteUserPermission ||
                ($hasDeleteUserPermission && $hasSelectAllUserPermission) ||
                $hasSelectAllUserPermission);
    @endphp

    @php
        $showAddColumn =
            $userHasPermission &&
            ($hasCreateUserPermission ||
                ($hasCreateUserPermission && $hasSelectAllUserPermission) ||
                $hasSelectAllUserPermission);
    @endphp
    @php
        $showEditColumn =
            $userHasPermission &&
            ($hasEditUserPermission ||
                ($hasEditUserPermission && $hasSelectAllUserPermission) ||
                $hasSelectAllUserPermission);
    @endphp

    @php
        $showDeleteColumn =
            $userHasPermission &&
            ($hasDeleteUserPermission ||
                ($hasDeleteUserPermission && $hasSelectAllUserPermission) ||
                $hasSelectAllUserPermission);
    @endphp
    <div class="page-wrapper page-wrapper-one">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>User List</h4>
                    <h6>Manage your User</h6>
                </div>
                <div class="page-btn">
                    @if ($showAddColumn)
                        <a href="{{ route('newuser') }}" class="btn btn-added"><img src="assets/img/icons/plus.svg"
                                alt="img" class="me-2">Add User</a>
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
                                <a class="btn btn-searchset">
                                    <img src="assets/img/icons/search-white.svg" alt="img">
                                </a>
                            </div>
                        </div>
                        <div class="wordset">
                            <ul>
                                <li>
                                    <a href="{{ route('generatePDF') }}" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="pdf"><img src="assets/img/icons/pdf.svg" alt="img"></a>
                                </li>
                                <li>
                                    <a href="{{ route('generateExcel') }}" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="excel"><img src="assets/img/icons/excel.svg" alt="img"></a>
                                </li>
                                <li>
                                    <a href="{{ route('generatePrint') }}" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="print"><img src="assets/img/icons/printer.svg" alt="img"></a>
                                </li>
                            </ul>
                        </div>
                    </div>


                    <div class="card" id="filter_inputs">
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="filterUsername"
                                            placeholder="Enter Username">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="filterPhone"
                                            placeholder="Enter Phone">

                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="filterEmail"
                                            placeholder="Enter Email">

                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="createdBy" placeholder="Created By">

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

                <div class="table-responsive">
                    <table class="table  datanew" id="userTable">

                        <thead>
                            <tr>
                                <th>
                                    <label class="checkboxs">
                                        <input type="checkbox" id="masterCheckbox">
                                        <span class="checkmarks" style="margin-left: 9px;"></span>
                                    </label>
                                </th>
                                <th>Profile</th>
                                <th id="username">User name </th>
                                <th>Phone</th>
                                <th>email</th>
                                <th>Created</th>
                                <th>Status</th>
                                @if ($showActionColumn)
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox" class="subCheckbox">
                                            <span class="checkmarks" style="margin-left: 9px;"></span>
                                        </label>
                                    </td>
                                    <td class="productimgname">
                                        <a href="javascript:void(0);" class="product-img" data-toggle="modal"
                                            data-target="#userImageModal" data-image="{{ $user->file }}">
                                            @if ($user->file)
                                                <img src="{{ asset('uploads/users/' . $user->file) }}"
                                                    style="border-radius: 50%; width: 50px; height: 50px; background-color: #ccc; text-align: center; line-height: 50px;">
                                            @else
                                                <div class="avatar"
                                                    style="border-radius: 50%; width: 50px; height: 50px; background-color: #007083; text-align: center; line-height: 50px;">
                                                    <?php $first_letter = substr($user->username, 0, 1);
                                                    $last_letter = substr($user->username, -1);
                                                    
                                                    echo "{$first_letter}{$last_letter}";
                                                    ?>
                                                </div>
                                            @endif
                                        </a>

                                    </td>
                                    </td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->email }} </td>
                                    <td>{{ optional($user->createdBy)->username }}</td>


                                    <td>
                                        @if ($user->is_enabled)
                                            <a href="{{ route('toggleStatus', ['id' => $user->id]) }}"
                                                class="bg-lightgreen badges">Enable</a>
                                        @else
                                            <a href="{{ route('toggleStatus', ['id' => $user->id]) }}"
                                                class="bg-lightred badges">Disable</a>
                                        @endif
                                    </td>
                                    @if ($showActionColumn)
                                        <td>



                                            <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown"
                                                aria-expanded="true">
                                                <i class="fa fa-ellipsis-v" style="font-size: 1rem"
                                                    aria-hidden="true"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                @if ($showEditColumn)
                                                    <li>
                                                        <a href="{{ route('users.edit', ['id' => $user->id]) }}"
                                                            class="dropdown-item"><img style="filter: contrast(.4);"
                                                                src="assets/img/icons/edit.svg" class="me-2"
                                                                alt="img">Edit User</a>


                                                    </li>


                                                    <li>
                                                        <a href="javascript:void(0);"
                                                            class="dropdown-item reset-passwords"
                                                            data-user-name="{{ $user->username }}">
                                                            <img src="assets/img/icons/reset.svg" class="me-2"
                                                                alt="img">Reset Password
                                                        </a>
                                                    </li>
                                                @endif
                                                @if (!$user->roles->contains('name', 'admin'))
                                                    @if ($showDeleteColumn)
                                                        <li>
                                                            <a href="javascript:void(0);"
                                                                action="{{ route('distroy.user', ['id' => $user->id]) }}"
                                                                data-user-id="{{ $user->id }}"
                                                                class="dropdown-item delete-button">
                                                                <img src="assets/img/icons/delete1.svg" class="me-2"
                                                                    alt="img">Delete User
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endif


                                            </ul>
                                        </td>
                                    @endif
                                </tr>







                                <!-- Reset Password Modal -->
                                <div id="resetPasswordModal{{ $user->username }}" class="modal">
                                    <div class="modal-content">
                                        <span class="close">&times;</span>
                                        <h2>Reset Password</h2>
                                        <!-- Add your reset password content here -->
                                        <form method="POST" action="{{ route('resetPassword', ['id' => $user->id]) }}">
                                            @csrf
                                            @method('PUT')
                                            <p>Are you sure you want to reset {{ $user->username }} the password?</p>
                                            <button class="confirmReset noselect" data-user-name="{{ $user->username }}">
                                                <span class="text">Yes, Reset</span>
                                                <span class="icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24">
                                                        <path
                                                            d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z">
                                                        </path>
                                                    </svg>
                                                </span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <!-- Delete type Modal -->
                                <div id="deleteModal{{ $user->id }}" class="modal">
                                    <div class="modal-content">
                                        <span class="close">&times;</span>
                                        <h2>Confirm Deletion</h2>
                                        <form id="deleteForm{{ $user->id }}" action="{{ route('distroy.user', ['id' => $user->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <p>Are you sure you want to {{ $user->username }} delete this item?</p>
                                            <button class="confirmDelete noselect" data-type-id="{{ $user->id }}">
                                                <span class="text">Yes, Delete</span>
                                                <span class="icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24">
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
                                                if (response.success) {
                                                    Toastify({
                                                        text: response.success,
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
    </div>


    <script>
        $(document).ready(function() {
            // Handle click on "Edit" button using event delegation
            $(document).on("click", ".edit-user", function() {
                const row = $(this).closest("tr");

                // Toggle visibility of username, phone, and email cells between text and input elements
                row.find(".username-cell").toggle();
                row.find(".phone-cell").toggle();
                row.find(".email-cell").toggle();

                // Replace the password cell with a "Reset Password" button
                row.find(".password-cell").html(
                    '<style>.reset-password:hover{transition:all .5s; color: red !important; background-color: white !important ; border: red 1px solid !important;}</style>' +
                    '<button class="btn reset-password" style="transition:all .5s;transform: translateX(-15px);font-size: 11px;border: white 1px solid; color: white;background: red;">Reset Password</button>'
                );

                // Toggle visibility of the "Edit" and "Delete" buttons
                row.find(".edit-user").toggle();
                row.find(".confirm-text").toggle();

            });

            // Handle click on "Save" button using event delegation
            $(document).on("click", ".save-user", function() {
                const row = $(this).closest("tr");

                // Toggle visibility of username, phone, and email cells between text and input elements
                row.find(".username-cell").toggle();
                row.find(".phone-cell").toggle();
                row.find(".email-cell").toggle();

                // Toggle visibility of the password cell between button and text
                row.find(".password-cell").html('********'); // Display asterisks

                // Toggle visibility of the "Edit" and "Delete" buttons
                row.find(".edit-user").toggle();
                row.find(".confirm-text").toggle();

                // Get the updated values
                const updatedUsername = row.find('input[name="username"]').val();
                const updatedPhone = row.find('input[name="phone"]').val();
                const updatedEmail = row.find('input[name="email"]').val();

                // Update the TD elements with the updated values
                row.find(".username-cell").text(updatedUsername);
                row.find(".phone-cell").text(updatedPhone);
                row.find(".email-cell").text(updatedEmail);

                // You can also send the updated data to your server via an AJAX request here

            });

            // Handle click on "Cancel" button using event delegation
            $(document).on("click", ".cancel-user", function() {
                const row = $(this).closest("tr");

                // Toggle visibility of username, phone, and email cells between text and input elements
                row.find(".username-cell").toggle();
                row.find(".phone-cell").toggle();
                row.find(".email-cell").toggle();

                // Toggle visibility of the password cell between button and text
                row.find(".password-cell").html('********'); // Display asterisks

                // Toggle visibility of the "Edit" and "Delete" buttons
                row.find(".edit-user").toggle();
                row.find(".confirm-text").toggle();
            });

            // Handle click on "Reset Password" button using event delegation




        });
    </script>













    <script>
        $(document).ready(function() {
            const clearButton = $("#clear");

            // Add event listeners to filter inputs
            $("#filterUsername, #filterPhone, #filterEmail,#createdBy").on("keyup", function() {
                $("#userTable").DataTable().columns().every(function() {
                    const columnIndex = this[0][0];
                    let inputValue = "";

                    if (columnIndex === 2) { // Username column index
                        inputValue = $("#filterUsername").val().toLowerCase();
                    } else if (columnIndex === 3) { // Phone column index
                        inputValue = $("#filterPhone").val().toLowerCase();
                    } else if (columnIndex === 4) { // Email column index
                        inputValue = $("#filterEmail").val().toLowerCase();
                    } else if (columnIndex === 5) { // Email column index
                        inputValue = $("#createdBy").val().toLowerCase();
                    }

                    this.search(inputValue, true, false).draw();
                });
            });

            // Add event listener to clear button
            clearButton.on("click", function() {
                $("#filterUsername, #filterPhone, #filterEmail,#createdBy").val(""); // Clear input values
                $("#userTable").DataTable().search("").columns().search("")
                    .draw(); // Clear DataTable search and redraw
            });
        });

        $(document).on("click", ".confirmReset", function() {
            const row = $(this).closest("tr");
            const userId = row.data("user-id");

        });

        $(document).on("click", ".confirmDelete", function() {
            const modal = $(this).closest('.modal');
            const userId = modal.attr('id').replace('deleteModal', '');

            // // Simulate a successful user deletion, you should replace this with your actual logic
            // const success = true; // Set this to true if the deletion was successful, false otherwise

            // toastr.options = {
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
            // }

            if (success) {
                toastr.success("User {{ $user->username }} Deleted successfully!", "Done");
            } else {
                toastr.error("User deletion failed. Please try again.", "Error");
            }

            closeModal(modal.attr('id'));
        });

        // Rest of the code remains unchanged


        const deleteButtons = document.querySelectorAll('.delete-button');
        const resetButtons = document.querySelectorAll('.reset-passwords');


        const modals = document.querySelectorAll('.modal');

        function showModal(elementId) {
            document.getElementById(elementId).style.display = 'block';
        }

        function closeModal(elementId) {
            document.getElementById(elementId).style.display = 'none';
        }

        deleteButtons.forEach(deleteButton => {
            const userId = deleteButton.getAttribute('data-user-id');
            deleteButton.addEventListener('click', () => showModal(`deleteModal${userId}`));
        });

        resetButtons.forEach(resetButton => {
            const userName = resetButton.getAttribute('data-user-name');
            resetButton.addEventListener('click', () => {
                showModal(`resetPasswordModal${userName}`);
            });
        });

        modals.forEach(modal => {
            const closeButton = modal.querySelector('.close');
            const confirmButton = modal.querySelector('.confirmDelete') || modal.querySelector('.confirmReset');
            const overlay = modal;

            closeButton.addEventListener('click', () => closeModal(modal.id));

            confirmButton.addEventListener('click', () => {
                // Perform the action here (delete or reset)
                // After completion, close the modal
                closeModal(modal.id);
            });
            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) {
                    closeModal(modal.id);
                }
            });
        });
    </script>






    <script>
        const masterCheckbox = document.getElementById("masterCheckbox");
        const subCheckboxes = document.querySelectorAll(".subCheckbox");


        // Add a click event listener to the master checkbox
        masterCheckbox.addEventListener("click", function() {
            // Loop through all sub checkboxes and set their checked state to match the master checkbox
            subCheckboxes.forEach(function(checkbox) {
                checkbox.checked = masterCheckbox.checked;
            });
        });
    </script>



@endsection
@section('custom-js')
    <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>


    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>
@endsection
