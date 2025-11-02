@extends('layouts.nav')

@section('name', 'Role & Permissions')
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
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
            'View Premission',
            'Select all Premission',
            'Delete Premission',
            'Edit Premission',
            'Create Premission',
        ];
        $userHasPermission = false;

        $hasViewPremissionPermission = false;
        $hasSelectAllPremissionPermission = false;
        $hasEditPremissionPermission = false;
        $hasDeletePremissionPermission = false;
        $hasCreatePremissionPermission = false;

        foreach ($requiredPermissions as $permission) {
            if (Auth::user()->hasPermission($permission)) {
                $userHasPermission = true;
                if ($permission === 'View Premission') {
                    $hasViewPremissionPermission = true;
                } elseif ($permission === 'Select all Premission') {
                    $hasSelectAllPremissionPermission = true;
                } elseif ($permission === 'Edit Premission') {
                    $hasEditPremissionPermission = true;
                } elseif ($permission === 'Delete Premission') {
                    $hasDeletePremissionPermission = true;
                } elseif ($permission === 'Create Premission') {
                    $hasCreatePremissionPermission = true;
                }
            }
        }

    @endphp


    @php
        $showActionColumn =
            $userHasPermission &&
            ($hasEditPremissionPermission ||
                ($hasEditPremissionPermission && $hasSelectAllPremissionPermission) ||
                $hasDeletePremissionPermission ||
                ($hasDeletePremissionPermission && $hasSelectAllPremissionPermission) ||
                $hasSelectAllPremissionPermission);
    @endphp

    @php
        $showAddColumn =
            $userHasPermission &&
            ($hasCreatePremissionPermission ||
                ($hasCreatePremissionPermission && $hasSelectAllPremissionPermission) ||
                $hasSelectAllPremissionPermission);
    @endphp
    @php
        $showEditColumn =
            $userHasPermission &&
            ($hasEditPremissionPermission ||
                ($hasEditPremissionPermission && $hasSelectAllPremissionPermission) ||
                $hasSelectAllPremissionPermission);
    @endphp

    @php
        $showDeleteColumn =
            $userHasPermission &&
            ($hasDeletePremissionPermission ||
                ($hasDeletePremissionPermission && $hasSelectAllPremissionPermission) ||
                $hasSelectAllPremissionPermission);
    @endphp

    <div class="page-wrapper page-wrapper-one">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Role & Permissions</h4>
                    <h6>Manage Role & Permissions</h6>
                </div>
                <div class="page-btn">
                    @if ($showAddColumn)
                        <a class="btn btn-added" href="{{ route('createpermission.page') }}"><img
                                src="assets/img/icons/plus.svg" alt="img" class="me-1">Add Role & Permissions</a>
                    @endif

                </div>
            </div>
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
            <div class="card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
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
                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead>
                                <tr>
                                    <th>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th>
                                    <th>Role</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    @if ($showActionColumn)
                                        <th class="text-end">Action</th>
                                    @endif

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->description }}</td>
                                        <td>

                                            @if ($role->active)
                                                <span class="badges bg-lightgreen">Active</span>
                                            @else
                                                <span class="badges bg-lightred">Inactive</span>
                                            @endif
                                        </td>


                                        @if ($showActionColumn)
                                            <td class="text-end">
                                                @if ($showEditColumn)
                                                    <a class="me-3"
                                                        href="{{ route('editPremission.page', ['id' => $role->id]) }}">
                                                        <img src="assets/img/icons/edit.svg" alt="Edit">
                                                    </a>
                                                @endif


                                                @if ($showDeleteColumn)
                                                    <form action="{{ route('Premission.delete', ['id' => $role->id]) }}"
                                                        style="display: inline" method="POST" class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a class="me-3 delete-button" href="javascript:void(0);"
                                                            data-user-id="{{ $role->id }}">
                                                            <img src="assets/img/icons/delete.svg" alt="img">
                                                        </a>

                                                        <div id="deleteModal{{ $role->id }}" class="modal">
                                                            <div class="modal-content">
                                                                <span class="close">&times;</span>
                                                                <h2>Confirm Deletion</h2>
                                                                <p>Are you sure you want to delete the (
                                                                    {{ $role->name }} )
                                                                    role ?</p>
                                                                <button id="confirmDelete" class="confirmDelete noselect"
                                                                    data-user-id="{{ $role->id }}"><span
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
                                            var roleId = $(this).data('user-id'); // Retrieve product ID from data-user-id attribute
                                            $('#deleteModal' + roleId).show();
                                        });

                                        $('.close').click(function() {
                                            $(this).closest('.modal').hide();
                                        });
                                        $('.confirmDelete').click(function(event) {
                                            event.preventDefault(); // Prevent default action
                                            var $form = $(this).closest('.delete-form');
                                            var roleId = $(this).data('user-id');

                                            // Disable the delete button to prevent multiple requests
                                            $(this).prop('disabled', true);

                                            $.ajax({
                                                url: $form.attr('action'),
                                                type: $form.attr('method'),
                                                data: $form.serialize(),
                                                success: function(response) {
                                                    // Handle succes
                                                    Toastify({
                                                        text: 'Role with Primission Deleted Successfully!',
                                                        duration: 2000,
                                                        gravity: 'top-left',
                                                        close: true,
                                                        backgroundColor: 'linear-gradient(to right, #9e0b04, #1c0805)'                                                        className: 'toastify-custom',
                                                    }).showToast();
                                                    $('#deleteModal' + roleId).hide();


                                                    setTimeout(function() {
                                                        window.location.href =
                                                            '{{ route('grouppermissions.page') }}';
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
        const deleteButtons = document.querySelectorAll('.delete-button');
        const confirmDeleteButtons = document.querySelectorAll('.confirmDelete');

        // Function to show the modal
        function showModal(subcategoryId) {
            document.getElementById(`deleteModal${subcategoryId}`).style.display = 'block';
        }

        // Function to close the modal
        function closeModal(subcategoryId) {
            document.getElementById(`deleteModal${subcategoryId}`).style.display = 'none';
        }

        deleteButtons.forEach(deleteButton => {
            const subcategoryId = deleteButton.getAttribute('data-user-id');

            deleteButton.addEventListener('click', () => {
                showModal(subcategoryId);
            });

            const closeButton = document.querySelector(`#deleteModal${subcategoryId} .close`);
            closeButton.addEventListener('click', () => {
                closeModal(subcategoryId);
            });

            const confirmButton = document.querySelector(`#deleteModal${subcategoryId} .confirmDelete`);
            confirmButton.addEventListener('click', () => {
                // Perform the delete action here for the user with the specified subcategoryId
                // After deletion, you can close the modal
                closeModal(subcategoryId);

                // Simulate a successful delete action, you should replace this with your actual logic
                const success = true; // Set this to true if the deletion was successful, false otherwise
                const username = $(`tr[data-user-id="${subcategoryId}"]`).data("username");
                const toastrOptions = {
                    "closeButton": true,
                    "debug": true,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-bottom-right",
                    "preventDuplicates": false,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };

                if (success) {
                    toastr.success(`subcategory ${username} Deleted successfully!`, "Done", toastrOptions);
                } else {
                    toastr.error(`Deletion for ${username} failed. Please try again.`, "Error",
                        toastrOptions);
                }
            });

            const overlay = document.querySelector(`#deleteModal${subcategoryId}`);
            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) {
                    // If the click was on the overlay (outside the modal content), close the modal
                    closeModal(subcategoryId);
                }
            });
        });
    </script>


    <script src="assets/plugins/select2/js/select2.min.js"></script>

    <script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
    <script src="assets/plugins/sweetalert/sweetalerts.min.js"></script>
@endsection
