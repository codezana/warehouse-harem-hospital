@extends('layouts.nav')

@section('name', 'Category List')
@section('custom-css')
<link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>


@endsection
@section('content')
<style>
    .description-cell {
        position: relative;
        cursor: pointer;
        max-height: 1.5em;
        /* Adjust this value to control initial height */
        overflow: hidden;
        transition: max-height 0.3s ease;
        /* Add smooth transition effect */
    }

    .full-description {
        display: inline-block;
        /* Initially hide full description */
    }

    .description-cell.expanded {
        max-height: none;
        /* Expand to show full description */
    }

    /* Styles for the modal */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fff;
        margin: 15% auto;
        padding: 20px;
        border-radius: 5px;
        width: 60%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .close-modal {

        position: absolute;
        top: 10px;
        /* vertical-align: top; */
        right: 15px;
        font-size: 27px;
        font-weight: bold;
        text-align: center;
        height: 40px;
        cursor: pointer;
        width: 34px;
    }

    p:last-child {
        margin-bottom: 0;
        padding: 27px;
        text-align: justify;
    }

    .close-modal:hover {
        background-color: red;
        color: white
    }

    /* Truncated description in the table cell */
    .truncated-description {
        display: block;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .show-description-modal {
        color: blue;
        cursor: pointer;
    }

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
<div class="page-wrapper page-wrapper-one">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Product Category list</h4>
                <h6>View/Search product Category</h6>
            </div>
            <div class="page-btn">
                @if ($showAddColumn)
                <a href="{{ route('categorypage') }}" class="btn btn-added">
                    <img src="assets/img/icons/plus.svg" class="me-1" alt="img">Add Category
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
                            <a class="btn btn-searchset"><img src="assets/img/icons/search-white.svg" alt="img"></a>
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
                                    <input type="text" id="CategoryName" class="form-control"
                                        placeholder="Enter Category Name">
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-6 col-12">
                                <div class="form-group">
                                    <input type="text" id="categoryCode" class="form-control"
                                        placeholder="Enter Category Code">
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
                                <th>Category name</th>
                                <th>Category Code</th>
                                <th>Description</th>
                                <th>Created By</th>
                                @if ($showActionColumn)
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($category as $categorys)
                            <tr>
                                <td>
                                    <label class="checkboxs">
                                        <input type="checkbox">
                                        <span class="checkmarks"></span>
                                    </label>
                                </td>
                                <td>

                                    <a href="javascript:void(0);">{{ $categorys->name }}</a>
                                </td>

                                <td>{{ $categorys->category_code }}</td>
                                <td class="description-cell" id="description-cell-{{ $loop->index }}">
                                    <span class="truncated-description">{{ Str::limit($categorys->description, 25)
                                        }}</span>
                                    @if (strlen($categorys->description) > 25)
                                    <a href="#" class="show-description-modal"
                                        data-modal-id="modal-{{ $loop->index }}">Read More</a>
                                    @endif
                                </td>
                                <td>{{ $categorys->createdBy ? $categorys->createdBy->username : 'N/A' }}</td>

                                @if ($showActionColumn)
                                <td>
                                    @if ($showEditColumn)
                                    <a class="edit-user me-3"
                                        href="{{ route('product.category.edit', ['id' => $categorys->id]) }}">
                                        <img src="assets/img/icons/edit.svg" alt="Edit">
                                    </a>
                                    @endif

                                    @if ($showDeleteColumn)
                                    <form action="{{ route('category.delete', ['id' => $categorys->id]) }}"
                                        style="display: inline" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <a class="me-3 delete-button" href="javascript:void(0);"
                                            data-user-id="{{ $categorys->id }}">
                                            <img src="assets/img/icons/delete.svg" alt="img">
                                        </a>
                                
                                        <div id="deleteModal{{ $categorys->id }}" class="modal">
                                            <div class="modal-content">
                                                <span class="close">&times;</span>
                                                <h2>Confirm Deletion</h2>
                                                <p>Are you sure you want to delete the (
                                                    {{ $categorys->name }} )
                                                    categorys ?</p>
                                                <button id="confirmDelete" class="confirmDelete noselect"
                                                    data-user-id="{{ $categorys->id }}"><span class="text">Yes,
                                                        Delete</span>&nbsp<span class="icon"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
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
                            <div id="modal-{{ $loop->index }}" class="modal">
                                <div class="modal-content">
                                    <span class="close-modal">&times;</span>
                                    <p class="full-description">{{ $categorys->description }}</p>
                                </div>
                            </div>
                            @endforeach
                            <script>
                                $(document).ready(function() {
                                    $('.delete-button').click(function() {
                                        var categoryId = $(this).data('user-id'); // Retrieve product ID from data-user-id attribute
                                        $('#deleteModal' + categoryId).show();
                                    });
                        
                                    $('.close').click(function() {
                                        $(this).closest('.modal').hide();
                                    });
                                    $('.confirmDelete').click(function(event) {
                                        event.preventDefault(); // Prevent default action
                                        var $form = $(this).closest('.delete-form');
                                        var categoryId = $(this).data('user-id');
                        
                                        // Disable the delete button to prevent multiple requests
                                        $(this).prop('disabled', true);
                        
                                        $.ajax({
                                            url: $form.attr('action'),
                                            type: $form.attr('method'),
                                            data: $form.serialize(),
                                            success: function(response) {
                                                // Handle success
                                                Toastify({
                                                    text: 'Category Deleted Successfully!',
                                                    duration: 2000,
                                                    gravity: 'top-left',
                                                    close: true,
                                                    backgroundColor: 'linear-gradient(to right, #9e0b04, #1c0805)',
                                                    className: 'toastify-custom',
                                                }).showToast();
                                                $('#deleteModal' + categoryId).hide();
                                                setTimeout(function() {
                                            window.location.href =
                                            '{{ route('product.categorylist') }}';
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

{{-- filter category --}}

<script>
    $(document).ready(function() {
            const clearButton = $("#clear");

            // Add event listeners to filter inputs
            $("#CategoryName, #categoryCode").on("keyup change",
                function() {
                    const CategoryName = $("#CategoryName").val().toLowerCase();
                    const categoryCode = $("#categoryCode").val().toLowerCase();

                    $("#userTable").DataTable().columns().every(function() {
                        const columnIndex = this[0][0];
                        let inputValue = "";

                        if (columnIndex === 1) { // Product name column index
                            inputValue = CategoryName;
                        } else if (columnIndex === 2) { // code column index
                            inputValue = categoryCode;
                        }

                        this.search(inputValue, true, false).draw();
                    });
                });
            clearButton.on("click", function() {
                $("#CategoryName,#categoryCode").val(""); // Clear input values
                $("#userTable").DataTable().search("").columns().search("")
                    .draw(); // Clear DataTable search and redraw
            });
        });
</script>


{{-- showing modal for discription --}}
<script>
    const modals = document.querySelectorAll('.modal');
        const showModalLinks = document.querySelectorAll('.show-description-modal');
        const closeModalBtns = document.querySelectorAll('.close-modal');

        showModalLinks.forEach(link => {
            link.addEventListener('click', () => {
                const modalId = link.getAttribute('data-modal-id');
                const modal = document.getElementById(modalId);
                modal.style.display = 'block';
            });
        });

        closeModalBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const modal = btn.closest('.modal');
                modal.style.display = 'none';
            });
        });

        window.addEventListener('click', event => {
            modals.forEach(modal => {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });
</script>

{{-- showing modal for delete button --}}

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



<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>
@endsection