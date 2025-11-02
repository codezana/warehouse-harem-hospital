@extends('layouts.nav')

@section('name', 'Create Role & Permissions')
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endsection
@section('content')

    <div class="page-wrapper page-wrapper-one">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Create Role & Permissions</h4>
                    <h6>Manage Create Role & Permissions</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <form action="{{ route('permissions.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-lg-3 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Role Name</label>
                                    <input type="text" name="name" class="form-control" id="name">
                                </div>
                            </div>
                            <div class="col-lg-9 col-sm-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" style="height: 40px" class="" id="description"></textarea>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="input-checkset">
                                    <ul>
                                        <li>
                                            <label class="inputcheck">Select All
                                                <input type="checkbox" id="select-all">
                                                <span class="checkmark"></span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="productdetails product-respon">
                                    <ul>


                                        <li>
                                            <h4>Product</h4>
                                            <div class="input-checkset">
                                                <ul>
                                                    @foreach ($productPermissions as $permission)
                                                        <li>
                                                            <label class="inputcheck">
                                                                {{ $permission->Premission }}
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="product_permissions[]"
                                                                    value="{{ $permission->name }}">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </li>


                                        <li>
                                            <h4>Sales</h4>
                                            <div class="input-checkset">
                                                <ul>
                                                    @foreach ($salesPermissions as $permission)
                                                        <li>
                                                            <label class="inputcheck">
                                                                {{ $permission->Premission }}
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="sales_permissions[]"
                                                                    value="{{ $permission->name }}">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </li>

                                        <li>
                                            <h4>POS</h4>
                                            <div class="input-checkset">
                                                <ul>
                                                    @foreach ($posPermissions as $permission)
                                                        <li>
                                                            <label class="inputcheck">
                                                                {{ $permission->Premission }}
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="pos_permissions[]"
                                                                    value="{{ $permission->name }}">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </li>

                                        <li>
                                            <h4>Request</h4>
                                            <div class="input-checkset">
                                                <ul>
                                                    @foreach ($requestPermissions as $permission)
                                                        <li>
                                                            <label class="inputcheck">
                                                                {{ $permission->Premission }}
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="request_permissions[]"
                                                                    value="{{ $permission->name }}">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </li>

                                        <li>
                                            <h4>Purchase</h4>
                                            <div class="input-checkset">
                                                <ul>
                                                    @foreach ($purchasePermissions as $permission)
                                                        <li>
                                                            <label class="inputcheck">
                                                                {{ $permission->Premission }}
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="purchase_permissions[]"
                                                                    value="{{ $permission->name }}">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </li>



                                        <li>
                                            <h4>Notification</h4>
                                            <div class="input-checkset">
                                                <ul>
                                                    @foreach ($notificationPermissions as $permission)
                                                        <li>
                                                            <label class="inputcheck">
                                                                {{ $permission->Premission }}
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="notification_permissions[]"
                                                                    value="{{ $permission->name }}">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </li>
                                        <li>
                                            <h4>Invoices</h4>
                                            <div class="input-checkset">
                                                <ul>
                                                    @foreach ($invoicesPermissions as $permission)
                                                        <li>
                                                            <label class="inputcheck">
                                                                {{ $permission->Premission }}
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="invoices_permissions[]"
                                                                    value="{{ $permission->name }}">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </li>
                                        <li>
                                            <h4>Return</h4>
                                            <div class="input-checkset">
                                                <ul>
                                                    @foreach ($returnPermissions as $permission)
                                                        <li>
                                                            <label class="inputcheck">
                                                                {{ $permission->Premission }}
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="return_permissions[]"
                                                                    value="{{ $permission->name }}">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </li>


                                        <li>
                                            <h4>Supplier </h4>
                                            <div class="input-checkset">
                                                <ul>
                                                    @foreach ($supplierPermissions as $permission)
                                                        <li>
                                                            <label class="inputcheck">
                                                                {{ $permission->Premission }}
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="supplier_permissions[]"
                                                                    value="{{ $permission->name }}">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </li>

                                        <li>
                                            <h4>Reports</h4>
                                            <div class="input-checkset">
                                                <ul>
                                                    @foreach ($reportsPermissions as $permission)
                                                        <li>
                                                            <label class="inputcheck">
                                                                {{ $permission->Premission }}
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="reports_permissions[]"
                                                                    value="{{ $permission->name }}">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </li>


                                        <li>
                                            <h4>Users Management</h4>
                                            <div class="input-checkset">
                                                <ul>
                                                    @foreach ($userManagementPermissions as $permission)
                                                        <li>
                                                            <label class="inputcheck">
                                                                {{ $permission->Premission }}
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="userManagement_permissions[]"
                                                                    value="{{ $permission->name }}">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </li>

                                        <li>
                                            <h4>Permissions</h4>
                                            <div class="input-checkset">
                                                <ul>
                                                    @foreach ($permissions as $permission)
                                                        <li>
                                                            <label class="inputcheck">
                                                                {{ $permission->Premission }}
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="permissions[]" value="{{ $permission->name }}">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </li>
                                        <li>
                                            <h4>Model Change</h4>
                                            <div class="input-checkset">
                                                <ul>
                                                    @foreach ($modelChangePermissions as $permission)
                                                        <li>
                                                            <label class="inputcheck">
                                                                {{ $permission->Premission }}
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="modelChange_permissions[]"
                                                                    value="{{ $permission->name }}">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </li>

                                        <li>
                                            <h4>Application</h4>
                                            <div class="input-checkset">
                                                <ul>
                                                    @foreach ($applicationPermissions as $permission)
                                                        <li>
                                                            <label class="inputcheck">
                                                                {{ $permission->Premission }}
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="application_permissions[]"
                                                                    value="{{ $permission->name }}">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </li>

                                        <li>
                                            <h4>Customer</h4>
                                            <div class="input-checkset">
                                                <ul>
                                                    @foreach ($customerPermissions as $permission)
                                                        <li>
                                                            <label class="inputcheck">
                                                                {{ $permission->Premission }}
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="customer_permissions[]"
                                                                    value="{{ $permission->name }}">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </li>



                                    </ul>
                                </div>
                            </div>
                        </div>
                        <button id="submitRole" type="submit" style="font-family: 'Times New Roman', Times, serif"
                            class="btn btn-primary mt-2">Create Permission</button>
                    </form>

                    <script>
                        $(document).ready(function() {
                            $('#submitRole').click(function(e) {
                                e.preventDefault();

                                var rolename = $('#name').val();
                                var description = $('#description').val();

                                if (rolename.trim() === '') {

                                    Toastify({
                                        text: ' Boss this Role Name is required!',
                                        duration: 3000,
                                        gravity: 'top-left',
                                        close: true,
                                        backgroundColor: 'linear-gradient(to right, #910d06, #44160f)', // Custom background color
                                        className: 'toastify-custom',
                                    }).showToast();
                                    return;
                                }
                                // Set flag when role name input is focused
                                $('#name').focus(function() {
                                    isRoleNameInputFocused = true;
                                });

                                // Reset flag when role name input loses focus
                                $('#name').blur(function() {
                                    isRoleNameInputFocused = false;
                                });
                                var product_permissions = [];
                                $('input[name="product_permissions[]"]:checked').each(function() {
                                    product_permissions.push($(this).val());
                                });

                                var sales_permissions = [];
                                $('input[name="sales_permissions[]"]:checked').each(function() {
                                    sales_permissions.push($(this).val());
                                });
                                var pos_permissions = [];
                                $('input[name="pos_permissions[]"]:checked').each(function() {
                                    pos_permissions.push($(this).val());
                                });
                                var request_permissions = [];
                                $('input[name="request_permissions[]"]:checked').each(function() {
                                    request_permissions.push($(this).val());
                                });
                                var purchase_permissions = [];
                                $('input[name="purchase_permissions[]"]:checked').each(function() {
                                    purchase_permissions.push($(this).val());
                                });

                                var notification_permissions = [];
                                $('input[name="notification_permissions[]"]:checked').each(function() {
                                    notification_permissions.push($(this).val());
                                });

                                var invoices_permissions = [];
                                $('input[name="invoices_permissions[]"]:checked').each(function() {
                                    invoices_permissions.push($(this).val());
                                });

                                var return_permissions = [];
                                $('input[name="return_permissions[]"]:checked').each(function() {
                                    return_permissions.push($(this).val());
                                });
                                var supplier_permissions = [];
                                $('input[name="supplier_permissions[]"]:checked').each(function() {
                                    supplier_permissions.push($(this).val());
                                });

                                var reports_permissions = [];
                                $('input[name="reports_permissions[]"]:checked').each(function() {
                                    reports_permissions.push($(this).val());
                                });

                                var userManagement_permissions = [];
                                $('input[name="userManagement_permissions[]"]:checked').each(function() {
                                    userManagement_permissions.push($(this).val());
                                });

                                var permissions = [];
                                $('input[name="permissions[]"]:checked').each(function() {
                                    permissions.push($(this).val());
                                });

                                var modelChange_permissions = [];
                                $('input[name="modelChange_permissions[]"]:checked').each(function() {
                                    modelChange_permissions.push($(this).val());
                                });

                                var application_permissions = [];
                                $('input[name="application_permissions[]"]:checked').each(function() {
                                    application_permissions.push($(this).val());
                                });

                                var customerPermissions = [];
                                $('input[name="customer_permissions[]"]:checked').each(function() {
                                    customerPermissions.push($(this).val());
                                });

                                // Get CSRF token value from the meta tag
                                var csrfToken = $('meta[name="csrf-token"]').attr('content');


                                // Check if the email already exists in the database
                                $.ajax({
                                    url: "{{ route('checkRole') }}",
                                    type: "POST",
                                    data: {
                                        rolename: rolename
                                    },
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
                                    },
                                    success: function(response) {
                                        if (response.exists) {
                                            // If email already exists in the database, display a notification
                                            Toastify({
                                                text: 'This role name already exists in the database!',
                                                duration: 3000,
                                                gravity: 'top-left', // Position the toast notification at the top left corner
                                                close: true, // Show a close button
                                                backgroundColor: 'linear-gradient(to right, #910d06, #44160f)', // Custom background color
                                                className: 'toastify-custom', // Custom CSS class for styling
                                            }).showToast();
                                        } else {

                                            // Send AJAX request
                                            $.ajax({
                                                url: "{{ route('permissions.store') }}",
                                                type: "POST",
                                                data: {
                                                    product_permissions: product_permissions,
                                                    sales_permissions: sales_permissions,
                                                    pos_permissions: pos_permissions,
                                                    request_permissions: request_permissions,
                                                    purchase_permissions: purchase_permissions,
                                                    notification_permissions: notification_permissions,
                                                    invoices_permissions: invoices_permissions,
                                                    return_permissions: return_permissions,
                                                    supplier_permissions: supplier_permissions,
                                                    reports_permissions: reports_permissions,
                                                    userManagement_permissions: userManagement_permissions,
                                                    permissions: permissions,
                                                    modelChange_permissions: modelChange_permissions,
                                                    application_permissions: application_permissions,
                                                    customerPermissions: customerPermissions,
                                                    rolename: rolename,
                                                    description: description,
                                                },

                                                headers: {
                                                    'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
                                                },
                                                success: function(response) {
                                                    Toastify({
                                                        text: 'That Role with Primission are created !',
                                                        duration: 2000,
                                                        gravity: 'top-left', // Position the toast notification at the top left corner
                                                        close: true, // Show a close button
                                                        backgroundColor: 'linear-gradient(to right, #118251, #16342a)', // Custom background color
                                                        className: 'toastify-custom', // Custom CSS class for styling
                                                    }).showToast();

                                                    // // Reset input fields after successful submission
                                                    $('#name').val('');

                                                    $('#description').val('');
                                                    $('input[name="product_permissions[]"]').prop(
                                                        'checked', false);
                                                    $('input[name="sales_permissions[]"]').prop(
                                                        'checked', false);
                                                    $('input[name="pos_permissions[]"]').prop(
                                                        'checked', false);
                                                    $('input[name="request_permissions[]"]').prop(
                                                        'checked', false);
                                                    $('input[name="purchase_permissions[]"]').prop(
                                                        'checked', false);
                                                    $('input[name="notification_permissions[]"]')
                                                        .prop('checked', false);

                                                    $('input[name="invoices_permissions[]"]').prop(
                                                        'checked', false);
                                                    $('input[name="return_permissions[]"]').prop(
                                                        'checked', false);
                                                    $('input[name="supplier_permissions[]"]').prop(
                                                        'checked', false);
                                                    $('input[name="reports_permissions[]"]').prop(
                                                        'checked', false);

                                                    $('input[name="userManagement_permissions[]"]')
                                                        .prop('checked', false);
                                                    $('input[name="permissions[]"]').prop('checked',
                                                        false);
                                                    $('input[name="modelChange_permissions[]"]')
                                                        .prop('checked', false);
                                                    $('input[name="application_permissions[]"]')
                                                        .prop('checked', false);

                                                    $('input[name="customer_permissions[]"]').prop(
                                                        'checked', false);

                                                    if (!isRoleNameInputFocused) {
                                                        setTimeout(function() {
                                                            window.location.href =
                                                                '{{ route('grouppermissions.page') }}';
                                                        }, 3000);

                                                    }


                                                },
                                                error: function(xhr, status, error) {
                                                    Toastify({
                                                        text: 'Sorry Dear Chaeck Again , May Be error Have !',
                                                        duration: 3000,
                                                        gravity: 'top-left', // Position the toast notification at the top left corner
                                                        close: true, // Show a close button
                                                        backgroundColor: 'linear-gradient(to right, #910d06, #44160f)', // Custom background color
                                                        className: 'toastify-custom', // Custom CSS class for styling
                                                    }).showToast();
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
                                            backgroundColor: 'linear-gradient(to right, #910d06, #44160f)', // Red background color for error
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
    </div>


@endsection
@section('custom-js')


    <script src="assets/plugins/select2/js/select2.min.js"></script>

    <script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
    <script src="assets/plugins/sweetalert/sweetalerts.min.js"></script>
@endsection
