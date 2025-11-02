@extends('layouts.nav')

@section('name', 'Add Product')
@section('custom-css')
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    {{-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> --}}
    <!------ Include the above in your HEAD tag ---------->

    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" /> --}}
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>


    <style>
        .hover-effect:hover {
            background-color: transparent;
            width: calc(max-content + 10px);


        }



        .close {
            align-self: end;
            float: left;
            cursor: pointer;
            color: black;
        }

        /* Hide the increase and decrease buttons */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type="number"] {
            -moz-appearance: textfield;
        }

        .select2-container .select2-selection--multiple {
            border: 1px solid #ced4da;
            min-height: 39px;

        }

        body[data-theme="dark"] .select2-container--default .select2-selection--multiple {
            border: 1px solid #434764;
            min-height: 39px;
        }

        body[data-theme="dark"] .select2-container--default .select2-search--inline .select2-search__field {
            border: none !important;
        }

        body[data-theme="dark"] .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #17a2b8;
            color: white
        }

        body[data-theme="dark"] .select2-container .select2-search--inline .select2-search__field::placeholder {
            color: #97a2d2;
        }

        body[data-theme="dark"] .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #fff;
            cursor: pointer;
            display: inline-block;
            font-weight: bold;
            margin-right: 6px;
        }

        body[data-theme="dark"] .select2-container--default .select2-results__option[aria-selected=true] {
            background: #01919c !important;
            color: #fff !important;

        }
    </style>
@endsection
@section('content')
    <div class="page-wrapper page-wrapper-one">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Add Product</h4>
                    <h6>Add/Create New product</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Product type</label>
                                    <select name="product_type" class="select2 form-control" id="product_type">
                                        <option value="standard">Standard</option>
                                        <option value="service">Service</option>

                                    </select>

                                </div>

                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="nameproduct">Product Name</label>
                                    <input type="text" value="{{ old('nameproduct') }}" id="nameproduct"
                                        name="nameproduct" class="form-control">

                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Category 🦺</label>
                                    <div class="row">
                                        <div class="col-lg-10 col-sm-10 col-10">
                                            <select id="categorySelect" class="select2 " name="category_id">

                                            </select>

                                        </div>

                                        <script>
                                            let currentOptions = ''; // Variable to store current options

                                            function updateCategory() {
                                                fetch('{{ route('categories.fetch') }}')
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        const newOptions = data.categoryOptions;
                                                        // Check if the new options are different from the current options
                                                        if (newOptions !== currentOptions) {
                                                            // Update the select element with new options
                                                            document.getElementById('categorySelect').innerHTML = newOptions;
                                                            // Update the current options
                                                            currentOptions = newOptions;
                                                        }
                                                    })
                                                    .catch(error => console.error('Error fetching Category:', error));
                                            }

                                            // Update categories every 4 seconds (4000 milliseconds)
                                            setInterval(updateCategory, 4000);

                                            // Initial call to update on page load
                                            updateCategory();
                                        </script>


                                        <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                            <div class="col-lg-4 col-sm-8 col-12 ps-0" class="btn btn-primary"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal4">
                                                <div class="add-icon">
                                                    <span><img src="assets/img/icons/plus1.svg" alt="img"></span>
                                                </div>
                                            </div>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal4" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Create New
                                                                Category 🦺</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"><i
                                                                    class="fa-regular fa-circle-xmark"></i></button>
                                                        </div>
                                                        <form id="form-data-category" method="POST"
                                                            action="{{ route('category.model') }}"">
                                                            @csrf

                                                            <div class=" modal-body">
                                                                <div class="card">

                                                                    <div class="card-body">
                                                                        @if (session('success'))
                                                                            <div class="alert alert-success">
                                                                                {{ session('success') }} <i
                                                                                    class='bx bx-cool'></i>
                                                                            </div>
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


                                                                        <div class="row">
                                                                            <div class="col-lg-6 col-sm-6 col-12">
                                                                                <div class="form-group">
                                                                                    <label for="nameCategory">Category
                                                                                        Name</label>
                                                                                    <input type="text"
                                                                                        value="{{ old('nameCategory') }}"
                                                                                        id="nameCategory"
                                                                                        name="nameCategory"
                                                                                        placeholder="Enter name of Category"
                                                                                        class="form-control ">

                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-12">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="descriptionCategory">Description</label>
                                                                                    <textarea value="{{ old('descriptionCategory') }}" id="descriptionCategory" name="descriptionCategory"
                                                                                        placeholder="Enter description of Subcategory" class="form-control "></textarea>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-primary"
                                                                    id="submitBtnCategory">Submit</button>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </form>


                                                        <script>
                                                            $(document).ready(function() {
                                                                $('#submitBtnCategory').click(function(e) {
                                                                    e.preventDefault(); // Prevent form from submitting normally

                                                                    const inputValue = document.getElementById('nameCategory').value;
                                                                    const inputDesc = document.getElementById('descriptionCategory').value;

                                                                    // Check if name input is empty
                                                                    if (inputValue.trim() === '') {

                                                                        Toastify({
                                                                            text: 'Name is required!',
                                                                            duration: 3000,
                                                                            gravity: 'top-left', // Position the toast notification at the top left corner
                                                                            close: true, // Show a close button
                                                                            backgroundColor: 'linear-gradient(to right, #910d06, #44160f)', // Custom background color
                                                                            className: 'toastify-custom', // Custom CSS class for styling
                                                                        }).showToast();
                                                                        return; // Exit function if name input is empty
                                                                    }

                                                                    // Check if description input is empty
                                                                    if (inputDesc.trim() === '') {

                                                                        Toastify({
                                                                            text: 'Description is required!',
                                                                            duration: 3000,
                                                                            gravity: 'top-left', // Position the toast notification at the top left corner
                                                                            close: true, // Show a close button
                                                                            backgroundColor: 'linear-gradient(to right, #910d06, #44160f)', // Custom background color
                                                                            className: 'toastify-custom', // Custom CSS class for styling
                                                                        }).showToast();
                                                                        return; // Exit function if description input is empty
                                                                    }
                                                                    // Get CSRF token value from the meta tag
                                                                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                                                                    // Send AJAX request
                                                                    $.ajax({
                                                                        url: "{{ route('category.model') }}",
                                                                        type: "POST",
                                                                        data: {
                                                                            name: inputValue,
                                                                            description: inputDesc,


                                                                        },
                                                                        headers: {
                                                                            'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
                                                                        },
                                                                        success: function(response) {
                                                                            Toastify({
                                                                                text: 'Category stored successfully!',
                                                                                duration: 2000,
                                                                                gravity: 'top-left', // Position the toast notification at the top left corner
                                                                                close: true, // Show a close button
                                                                                backgroundColor: 'linear-gradient(to right, #118251, #16342a)', // Custom background color
                                                                                className: 'toastify-custom', // Custom CSS class for styling
                                                                            }).showToast();


                                                                            // Reset input fields to null after successful submission
                                                                            $('#nameCategory').val('');
                                                                            $('#descriptionCategory').val('');
                                                                        },
                                                                        error: function(xhr, status, error) {
                                                                            Toastify({
                                                                                text: 'Chaeck Again , Error Have',
                                                                                duration: 3000,
                                                                                gravity: 'top-left', // Position the toast notification at the top left corner
                                                                                close: true, // Show a close button
                                                                                backgroundColor: 'linear-gradient(to right, #910d06, #44160f)', // Custom background color
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
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Sub Category 🎲</label>
                                    <div class="row">
                                        <div class="col-lg-10 col-sm-10 col-10">
                                            <select class="select2 " name="subcategory_id" id="subcategory">

                                            </select>

                                        </div>

                                        <script>
                                            let currentOptionss = ''; // Variable to store current options

                                            function updateCategory() {
                                                fetch('{{ route('Subcategories.fetch') }}')
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        const newOptions = data.subcategoryOptions;
                                                        // Check if the new options are different from the current options
                                                        if (newOptions !== currentOptionss) {
                                                            // Update the select element with new options
                                                            document.getElementById('subcategory').innerHTML = newOptions;
                                                            // Update the current options
                                                            currentOptionss = newOptions;
                                                        }
                                                    })
                                                    .catch(error => console.error('Error fetching Sub Category:', error));
                                            }

                                            // Update categories every 4 seconds (4000 milliseconds)
                                            setInterval(updateCategory, 4000);

                                            // Initial call to update on page load
                                            updateCategory();
                                        </script>
                                        <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                            <div class="col-lg-4 col-sm-8 col-12 ps-0" class="btn btn-primary"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal40">
                                                <div class="add-icon">
                                                    <span><img src="assets/img/icons/plus1.svg" alt="img"></span>
                                                </div>
                                            </div>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal40" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Create New Sub
                                                                Category 🎲</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"><i
                                                                    class="fa-regular fa-circle-xmark"></i></button>
                                                        </div>
                                                        <form id="form-data-sub" method="POST"
                                                            action="{{ route('Subcategory.model') }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="card">
                                                                    <div class="card-body">


                                                                        <div class="row">

                                                                            <div class="col-lg-6 col-sm-6 col-12">
                                                                                <div class="form-group">
                                                                                    <label>Parent Category</label>
                                                                                    <select id="categorySelectt"
                                                                                        class="select2 "
                                                                                        name="category_id">

                                                                                    </select>

                                                                                </div>
                                                                            </div>


                                                                            <script>
                                                                                let currentOptionsModel = '';

                                                                                function updateCategoryModel() {
                                                                                    fetch('{{ route('categories.fetch') }}')
                                                                                        .then(response => response.json())
                                                                                        .then(data => {
                                                                                            const newOptions = data.categoryOptions;
                                                                                            // Check if the new options are different from the current options
                                                                                            if (newOptions !== currentOptionsModel) {
                                                                                                // Update the select element with new options
                                                                                                document.getElementById('categorySelectt').innerHTML = newOptions;
                                                                                                // Update the current options
                                                                                                currentOptionsModel = newOptions;
                                                                                            }
                                                                                        })
                                                                                        .catch(error => console.error('Error fetching Category:', error));
                                                                                }

                                                                                // Update categories every 4 seconds (4000 milliseconds)
                                                                                setInterval(updateCategoryModel, 4000);

                                                                                // Initial call to update on page load
                                                                                updateCategoryModel();
                                                                            </script>

                                                                            <div class="col-lg-6 col-sm-6 col-12">
                                                                                <div class="form-group">
                                                                                    <label for="name">Subcategory
                                                                                        Name</label>
                                                                                    <input type="text"
                                                                                        value="{{ old('name') }}"
                                                                                        id="name" name="name"
                                                                                        placeholder="Entre name of Subcategory "
                                                                                        class="form-control">

                                                                                </div>
                                                                            </div>


                                                                            <div class="col-lg-12">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="description">Description</label>
                                                                                    <textarea value="{{ old('description') }}" id="description" name="description"
                                                                                        placeholder="Entre description of Subcategory " class="form-control "></textarea>


                                                                                </div>
                                                                            </div>



                                                                            <div class="col-lg-12">
                                                                                <div class="form-group">
                                                                                    <label> Subcategory Image</label>
                                                                                    <div class="image-upload image-upload-new"
                                                                                        id="image-upload">
                                                                                        <input type="file"
                                                                                            name="image"
                                                                                            class="form-control "
                                                                                            id="subProfilePicture"
                                                                                            onchange="displaySelectedImage()">

                                                                                        <div class="image-uploads"
                                                                                            id="image-uploads">
                                                                                            <img src="{{ asset('assets/img/icons/upload.svg') }}"
                                                                                                alt="img"
                                                                                                id="selectedImage">
                                                                                            <h4 id="h4">Drag and
                                                                                                drop a
                                                                                                file to upload</h4>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-12" id="pdoductviewes"
                                                                                style="display: none">
                                                                                <div class="product-list">
                                                                                    <ul class="row">
                                                                                        <li>
                                                                                            <div class="productviews"
                                                                                                style="width: 250px">
                                                                                                <div
                                                                                                    class="productviewsimg">
                                                                                                    <img src=""
                                                                                                        alt="img"
                                                                                                        id="productImage">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="productviewscontent">
                                                                                                    <div
                                                                                                        class="productviewsname">
                                                                                                        <h2 id="imageName">
                                                                                                            macbookpro.jpg
                                                                                                        </h2>
                                                                                                        <h3 id="imageSize">
                                                                                                            581kb</h3>
                                                                                                    </div>
                                                                                                    <a href="javascript:void(0);"
                                                                                                        class="hidesets"
                                                                                                        id="hidesets">x</a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>



                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary"
                                                                    id="submitBtnSub">Submit</button>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>

                                                            </div>
                                                        </form>






                                                        <script>
                                                            $(document).ready(function() {
                                                                $('#submitBtnSub').click(function(e) {
                                                                    e.preventDefault(); // Prevent form from submitting normally

                                                                    // Get the value of the input field for brand name
                                                                    var categorySelect = $('#categorySelectt').val();
                                                                    var subName = $('#name').val();
                                                                    var subDescription = $('#description').val();



                                                                    if (categorySelect.trim() === '') {

                                                                        Toastify({
                                                                            text: 'Parent Category is required !',
                                                                            duration: 3000,
                                                                            gravity: 'top-left', // Position the toast notification at the top left corner
                                                                            close: true, // Show a close button
                                                                            backgroundColor: 'linear-gradient(to right, #910d06, #44160f)', // Custom background color
                                                                            className: 'toastify-custom', // Custom CSS class for styling
                                                                        }).showToast();
                                                                        return; // Exit function if description input is empty
                                                                    }
                                                                    if (subName.trim() === '') {

                                                                        Toastify({
                                                                            text: ' Name is required!',
                                                                            duration: 3000,
                                                                            gravity: 'top-left', // Position the toast notification at the top left corner
                                                                            close: true, // Show a close button
                                                                            backgroundColor: 'linear-gradient(to right, #910d06, #44160f)', // Custom background color
                                                                            className: 'toastify-custom', // Custom CSS class for styling
                                                                        }).showToast();
                                                                        return; // Exit function if name input is empty
                                                                    }



                                                                    // Check if description input is empty
                                                                    if (subDescription.trim() === '') {

                                                                        Toastify({
                                                                            text: 'Parent Category is required !',
                                                                            duration: 3000,
                                                                            gravity: 'top-left', // Position the toast notification at the top left corner
                                                                            close: true, // Show a close button
                                                                            backgroundColor: 'linear-gradient(to right, #910d06, #44160f)', // Custom background color
                                                                            className: 'toastify-custom', // Custom CSS class for styling
                                                                        }).showToast();
                                                                        return; // Exit function if description input is empty
                                                                    }

                                                                    // Get the file input element
                                                                    var subImageInput = $('#subProfilePicture')[0];
                                                                    var subImage = subImageInput.files[0];

                                                                    // Create FormData object
                                                                    var formData = new FormData();
                                                                    formData.append('name', subName);
                                                                    formData.append('categorySelect', categorySelect);

                                                                    formData.append('description', subDescription);
                                                                    formData.append('image', subImage);

                                                                    // Get CSRF token value from the meta tag
                                                                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                                                                    // Send AJAX request
                                                                    $.ajax({
                                                                        url: "{{ route('Subcategory.model') }}",
                                                                        type: "POST",
                                                                        data: formData,
                                                                        processData: false, // Prevent jQuery from processing the data
                                                                        contentType: false, // Prevent jQuery from setting content type
                                                                        headers: {
                                                                            'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
                                                                        },
                                                                        success: function(response) {
                                                                            Toastify({
                                                                                text: 'Subcategory stored successfully!',
                                                                                duration: 2000,
                                                                                gravity: 'top-left', // Position the toast notification at the top left corner
                                                                                close: true, // Show a close button
                                                                                backgroundColor: 'linear-gradient(to right, #118251, #16342a)', // Custom background color
                                                                                className: 'toastify-custom', // Custom CSS class for styling
                                                                            }).showToast();
                                                                            $('#name').val('');
                                                                            $('#description').val('');
                                                                            $('#categorySelectt').val(null).trigger('change');


                                                                            $('#subProfilePicture').val(''); // Reset file input

                                                                        },
                                                                        error: function(xhr, status, error) {
                                                                            Toastify({
                                                                                text: 'Chaeck Again , Error Have',
                                                                                duration: 3000,
                                                                                gravity: 'top-left', // Position the toast notification at the top left corner
                                                                                close: true, // Show a close button
                                                                                backgroundColor: 'linear-gradient(to right, #910d06, #44160f)', // Custom background color
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
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Brand 🥋</label>
                                    <div class="row">
                                        <div class="col-lg-10 col-sm-10 col-10">
                                            <select class="select2" name="brand_id" id="brandselect">

                                            </select>

                                        </div>



                                        <script>
                                            let brandOptionsModel = '';

                                            function updatebrandModel() {
                                                fetch('{{ route('BrandModel.fetch') }}')
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        const newOptions = data.brandOptions;
                                                        // Check if the new options are different from the current options
                                                        if (newOptions !== brandOptionsModel) {
                                                            // Update the select element with new options
                                                            document.getElementById('brandselect').innerHTML = newOptions;
                                                            // Update the current options
                                                            brandOptionsModel = newOptions;
                                                        }
                                                    })
                                                    .catch(error => console.error('Error fetching brand:', error));
                                            }

                                            // Update categories every 4 seconds (4000 milliseconds)
                                            setInterval(updatebrandModel, 4000);

                                            // Initial call to update on page load
                                            updatebrandModel();
                                        </script>
                                        <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                            <div class="col-lg-4 col-sm-8 col-12 ps-0" class="btn btn-primary"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal3">
                                                <div class="add-icon">
                                                    <span><img src="assets/img/icons/plus1.svg" alt="img"></span>
                                                </div>
                                            </div>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal3" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Create New
                                                                Brand 🥋
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"><i
                                                                    class="fa-regular fa-circle-xmark"></i></button>
                                                        </div>

                                                        <form id="form-data" method="POST"
                                                            action="{{ route('brand.model') }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="card">
                                                                    <div class="card-body">


                                                                        <div class="row">

                                                                            <div class="col-lg-6 col-sm-12 col-12">
                                                                                <div class="form-group">
                                                                                    <label for="name">Brand
                                                                                        Name</label>
                                                                                    <input type="text"
                                                                                        value="{{ old('name') }}"
                                                                                        id="nameBrand" name="name"
                                                                                        class="form-control ">

                                                                                </div>
                                                                            </div>


                                                                            <div class="col-lg-12">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="description">Description</label>
                                                                                    <textarea value="{{ old('description') }}" id="descriptionBarnd" name="description"
                                                                                        placeholder="Entre description of your brand " class="form-control"></textarea>


                                                                                </div>
                                                                            </div>

                                                                            <div class="col-lg-12">
                                                                                <div class="form-group">
                                                                                    <label> Brand Image</label>
                                                                                    <div class="image-upload image-upload-new"
                                                                                        id="image-upload">
                                                                                        <input type="file"
                                                                                            name="image"
                                                                                            class="form-control "
                                                                                            id="brandProfilePicture"
                                                                                            onchange="displaySelectedImage()">

                                                                                        <div class="image-uploads"
                                                                                            id="image-uploads">
                                                                                            <img src="{{ asset('assets/img/icons/upload.svg') }}"
                                                                                                alt="img"
                                                                                                id="selectedImage">
                                                                                            <h4 id="h4">Drag and
                                                                                                drop a
                                                                                                file to upload</h4>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-12" id="pdoductviewes"
                                                                                style="display: none">
                                                                                <div class="product-list">
                                                                                    <ul class="row">
                                                                                        <li>
                                                                                            <div class="productviews"
                                                                                                style="width: 250px">
                                                                                                <div
                                                                                                    class="productviewsimg">
                                                                                                    <img src=""
                                                                                                        alt="img"
                                                                                                        id="productImage">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="productviewscontent">
                                                                                                    <div
                                                                                                        class="productviewsname">
                                                                                                        <h2 id="imageName">
                                                                                                            macbookpro.jpg
                                                                                                        </h2>
                                                                                                        <h3 id="imageSize">
                                                                                                            581kb</h3>
                                                                                                    </div>
                                                                                                    <a href="javascript:void(0);"
                                                                                                        class="hidesets"
                                                                                                        id="hidesets">x</a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>


                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary"
                                                                        id="submitBtnBrand">Submit</button>
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>

                                                                </div>
                                                            </div>
                                                        </form>
                                                        <script>
                                                            $(document).ready(function() {
                                                                $('#submitBtnBrand').click(function(e) {
                                                                    e.preventDefault(); // Prevent form from submitting normally

                                                                    // Get the value of the input field for brand name
                                                                    var BrandName = $('#nameBrand').val();

                                                                    // Get the value of the textarea for brand description
                                                                    var BrandDescription = $('#descriptionBarnd').val();

                                                                    // Get the file input element
                                                                    var BrandImageInput = $('#brandProfilePicture')[0];
                                                                    var BrandImage = BrandImageInput.files[0];


                                                                    // Check if name input is empty
                                                                    if (BrandName.trim() === '') {

                                                                        Toastify({
                                                                            text: ' Name is required!',
                                                                            duration: 3000,
                                                                            gravity: 'top-left', // Position the toast notification at the top left corner
                                                                            close: true, // Show a close button
                                                                            backgroundColor: 'linear-gradient(to right, #910d06, #44160f)', // Red background color for error
                                                                            className: 'toastify-custom', // Custom CSS class for styling
                                                                        }).showToast();
                                                                        return; // Exit function if name input is empty
                                                                    }

                                                                    // Check if description input is empty
                                                                    if (BrandDescription.trim() === '') {

                                                                        Toastify({
                                                                            text: 'Description is required!',
                                                                            duration: 3000,
                                                                            gravity: 'top-left', // Position the toast notification at the top left corner
                                                                            close: true, // Show a close button
                                                                            backgroundColor: 'linear-gradient(to right, #910d06, #44160f)', // Red background color for error
                                                                            className: 'toastify-custom', // Custom CSS class for styling
                                                                        }).showToast();
                                                                        return; // Exit function if description input is empty
                                                                    }


                                                                    // Create FormData object
                                                                    var formData = new FormData();
                                                                    formData.append('name', BrandName);
                                                                    formData.append('description', BrandDescription);
                                                                    formData.append('image', BrandImage);

                                                                    // Get CSRF token value from the meta tag
                                                                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                                                                    // Send AJAX request
                                                                    $.ajax({
                                                                        url: "{{ route('brand.model') }}",
                                                                        type: "POST",
                                                                        data: formData,
                                                                        processData: false, // Prevent jQuery from processing the data
                                                                        contentType: false, // Prevent jQuery from setting content type
                                                                        headers: {
                                                                            'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
                                                                        },
                                                                        success: function(response) {
                                                                            Toastify({
                                                                                text: 'Brand stored successfully !',
                                                                                duration: 2000,
                                                                                gravity: 'top-left', // Position the toast notification at the top left corner
                                                                                close: true, // Show a close button
                                                                                backgroundColor: 'linear-gradient(to right, #118251, #16342a)', // Custom background color
                                                                                className: 'toastify-custom', // Custom CSS class for styling
                                                                            }).showToast();

                                                                            // Reset input fields after successful submission
                                                                            $('#nameBrand').val('');
                                                                            $('#descriptionBarnd').val('');
                                                                            $('#brandProfilePicture').val(''); // Reset file input
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
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Choose Type 📦</label>
                                    <div class="row">
                                        <div class="col-lg-10 col-sm-10 col-10">
                                            <select name="type_id" class="select " id="typeselect">
                                            </select>

                                        </div>



                                        <script>
                                            let TypeModel = '';

                                            function updateTypeModel() {
                                                fetch('{{ route('TypeModel.fetch') }}')
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        const newOptions = data.typeOptions;
                                                        // Check if the new options are different from the current options
                                                        if (newOptions !== TypeModel) {
                                                            // Update the select element with new options
                                                            document.getElementById('typeselect').innerHTML = newOptions;
                                                            // Update the current options
                                                            TypeModel = newOptions;
                                                        }
                                                    })
                                                    .catch(error => console.error('Error fetching Type:', error));
                                            }

                                            // Update categories every 4 seconds (4000 milliseconds)
                                            setInterval(updateTypeModel, 4000);

                                            // Initial call to update on page load
                                            updateTypeModel();
                                        </script>
                                        <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                            <div class="col-lg-4 col-sm-8 col-12 ps-0" class="btn btn-primary"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <div class="add-icon">
                                                    <span><img src="assets/img/icons/plus1.svg" alt="img"></span>
                                                </div>
                                            </div>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Create New Type
                                                                📦</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"><i
                                                                    class="fa-regular fa-circle-xmark"></i></button>
                                                        </div>

                                                        <form id="form-data" method="POST"
                                                            action="{{ route('Type.model') }}"
                                                            enctype="multipart/form-data">
                                                            @csrf

                                                            <div class="modal-body">
                                                                <div class="card">
                                                                    <div class="card-body">


                                                                        <div class="row">

                                                                            <div class="col-lg-8 col-sm-12 col-12">
                                                                                <div class="form-group">

                                                                                    <label
                                                                                        for="type_name">{{ __('Type Name') }}</label>

                                                                                    <input
                                                                                        class="form-control @error('type_name') is-invalid @enderror"
                                                                                        type="text"
                                                                                        value="{{ old('type_name') }}"
                                                                                        id="type_name" name="type_name"
                                                                                        autofocus />
                                                                                    @error('type_name')
                                                                                        <span class="invalid-feedback"
                                                                                            role="alert">
                                                                                            <strong>{{ $message }}</strong>
                                                                                        </span>
                                                                                    @enderror

                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-12">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="description">Description</label>
                                                                                    <textarea id="descriptionType" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                                                                    @error('description')
                                                                                        <span class="invalid-feedback"
                                                                                            role="alert">
                                                                                            <strong>{{ $message }}</strong>
                                                                                        </span>
                                                                                    @enderror

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <div class="modal-footers">
                                                                    <button type="submit" class="btn btn-primary"
                                                                        id="submitBtnType">Submit</button>
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>

                                                                </div>
                                                            </div>
                                                        </form>
                                                        <script>
                                                            $(document).ready(function() {
                                                                $('#submitBtnType').click(function(e) {
                                                                    e.preventDefault();

                                                                    var TypeNameInput = document.getElementById('type_name');
                                                                    var TypeName = TypeNameInput.value;

                                                                    var TypeDescriptionTextarea = document.getElementById('descriptionType');
                                                                    var TypeDescription = TypeDescriptionTextarea.value;

                                                                    if (TypeName.trim() === '') {

                                                                        Toastify({
                                                                            text: 'Name is required !',
                                                                            duration: 3000,
                                                                            gravity: 'top-left',
                                                                            close: true,
                                                                            backgroundColor: 'linear-gradient(to right, #910d06, #44160f)',
                                                                            className: 'toastify-custom',
                                                                        }).showToast();
                                                                        return;
                                                                    }
                                                                    if (TypeDescription.trim() === '') {

                                                                        Toastify({
                                                                            text: ' Description is required!',
                                                                            duration: 3000,
                                                                            gravity: 'top-left',
                                                                            close: true,
                                                                            backgroundColor: 'linear-gradient(to right, #910d06, #44160f)',
                                                                            className: 'toastify-custom',
                                                                        }).showToast();
                                                                        return;
                                                                    }
                                                                    // Get CSRF token value from the meta tag
                                                                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                                                                    // Send AJAX request
                                                                    $.ajax({
                                                                        url: "{{ route('Type.model') }}",
                                                                        type: "POST",
                                                                        data: {
                                                                            name: TypeName,
                                                                            description: TypeDescription,
                                                                        },
                                                                        headers: {
                                                                            'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
                                                                        },
                                                                        success: function(response) {
                                                                            Toastify({
                                                                                text: 'Type stored successfully!',
                                                                                duration: 2000,
                                                                                gravity: 'top-left', // Position the toast notification at the top left corner
                                                                                close: true,
                                                                                escape: false,
                                                                                backgroundColor: 'linear-gradient(to right, #118251, #16342a)', // Custom background color
                                                                                className: 'toastify-custom', // Custom CSS class for styling
                                                                            }).showToast();

                                                                            // Reset input fields and selected image after successful submission
                                                                            TypeNameInput.value = '';
                                                                            TypeDescriptionTextarea.value = '';

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
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="barcode">Product Barcode</label>
                                    <input type="text" value="{{ old('barcode') }}" id="barcode" name="barcode"
                                        class="form-control ">
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="quantity">Product Sizable </label>
                                    <select name="product_type" class="product-size form-control">
                                        <option checked value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                    <script>
                                        setTimeout(() => {
                                            let sizable = document.querySelector('.product-size');
                                            let displaySize = document.querySelector('.productSize');
                                            // console.log(displaySize);
                                            sizable.addEventListener('change', (e) => {
                                                if (e.target.value == 1) {
                                                    displaySize.style.display = 'block';
                                                } else {
                                                    displaySize.style.display = 'none';
                                                }
                                            });
                                        }, 250);
                                    </script>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12 productSize" style="display: none;">
                                <div class="form-group">
                                    <label for="quantity">Product Size </label>
                                    <div class="row">
                                        <div class="col-lg-10 col-sm-10 col-10">

                                            <select name="size[]" multiple id="select2" class="form-control ">
                                            </select>


                                        </div>
                                        <script>
                                            let SizeModel = '';

                                            function updateSizeModel() {
                                                fetch('{{ route('sizeModel.fetch') }}')
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        const newOptions = data.SizeOptions;
                                                        // Check if the new options are different from the current options
                                                        if (newOptions !== SizeModel) {
                                                            // Update the select element with new options
                                                            document.getElementById('select2').innerHTML = newOptions;
                                                            // Update the current options
                                                            SizeModel = newOptions;
                                                        }
                                                    })
                                                    .catch(error => console.error('Error fetching Size:', error));
                                            }

                                            // Update categories every 4 seconds (4000 milliseconds)
                                            setInterval(updateSizeModel, 4000);

                                            // Initial call to update on page load
                                            updateSizeModel();
                                        </script>
                                        <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                            <div class="col-lg-4 col-sm-8 col-12 ps-0" class="btn btn-primary"
                                                data-bs-toggle="modal" data-bs-target="#exampleModalsize">
                                                <div class="add-icon">
                                                    <span><img src="assets/img/icons/plus1.svg" alt="img"></span>
                                                </div>
                                            </div>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModalsize" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Create New
                                                                Product Size</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"><i
                                                                    class="fa-regular fa-circle-xmark"></i></button>
                                                        </div>

                                                        <form id="form-data" method="POST"
                                                            action="{{ route('size.model') }}"
                                                            enctype="multipart/form-data">
                                                            @csrf

                                                            <div class="modal-body">
                                                                <div class="card">
                                                                    <div class="card-body">


                                                                        <div class="row">

                                                                            <div class="col-lg-8 col-sm-12 col-12">
                                                                                <div class="form-group">

                                                                                    <label for="type_name">Size
                                                                                        Name</label>

                                                                                    <input class="form-control "
                                                                                        type="text"
                                                                                        value="{{ old('size_name') }}"
                                                                                        id="size_name" name="size_name"
                                                                                        autofocus />


                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <div class="modal-footers">
                                                                    <button type="submit" class="btn btn-primary"
                                                                        id="submitBtnSize">Submit</button>
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>

                                                                </div>
                                                            </div>
                                                        </form>
                                                        <script>
                                                            $(document).ready(function() {
                                                                $('#submitBtnSize').click(function(e) {
                                                                    e.preventDefault();

                                                                    var SizenameInput = document.getElementById('size_name');
                                                                    var Sizename = SizenameInput.value;


                                                                    if (Sizename.trim() === '') {

                                                                        Toastify({
                                                                            text: 'Name is required !',
                                                                            duration: 3000,
                                                                            gravity: 'top-left',
                                                                            close: true,
                                                                            backgroundColor: 'linear-gradient(to right, #910d06, #44160f)',
                                                                            className: 'toastify-custom',
                                                                        }).showToast();
                                                                        return;
                                                                    }

                                                                    // Get CSRF token value from the meta tag
                                                                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                                                                    // Send AJAX request
                                                                    $.ajax({
                                                                        url: "{{ route('size.model') }}",
                                                                        type: "POST",
                                                                        data: {
                                                                            name: Sizename,
                                                                        },
                                                                        headers: {
                                                                            'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
                                                                        },
                                                                        success: function(response) {
                                                                            Toastify({
                                                                                text: 'Size stored successfully!!',
                                                                                duration: 2000,
                                                                                gravity: 'top-left', // Position the toast notification at the top left corner
                                                                                close: true,
                                                                                escape: false,
                                                                                backgroundColor: 'linear-gradient(to right, #118251, #16342a)', // Custom background color
                                                                                className: 'toastify-custom', // Custom CSS class for styling
                                                                            }).showToast();

                                                                            // Reset input fields and selected image after successful submission
                                                                            SizenameInput.value = '';

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
                                    </div>

                                </div>





                            </div>

                            {{-- dwae ama dayan bnerawa --}}

                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="quantity">Quantity Product </label>
                                    <input type="number" style="color: gray;" value="{{ old('quantity') }}"
                                        id="quantity" name="quantity" class="form-control ">

                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="minimum_qty">Minimum Quantity</label>
                                    <input type="number" style="color: gray;" value="{{ old('minimum_qty') }}"
                                        id="minimum_qty" name="minimum_qty" class="form-control">

                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="price">Product Price</label>
                                    <input type="number" style="color: gray;" value="{{ old('price') }}"
                                        id="price" name="price" class="form-control ">

                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="sale">Sale Product</label>
                                    <input type="number" value="{{ old('sale') }}" id="sale" name="sale"
                                        class="form-control ">

                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea id="descriptionproduct" name="description" class="form-control "></textarea>


                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label> Product Image</label>
                                    <div class="image-upload image-upload-new" id="image-upload">
                                        <input type="file" name="image" class="form-control" id="profilePicture1"
                                            onchange="displaySelectedImage()">

                                        <div class="image-uploads" id="image-uploads">
                                            <img src="{{ asset('assets/img/icons/upload.svg') }}" alt="img"
                                                id="selectedImage">
                                            <h4 id="h4">Drag and drop a file to upload</h4>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-12" id="pdoductviewes1" style="display: none">
                                <div class="product-list">
                                    <ul class="row">
                                        <li>
                                            <div class="productviews" style="width: 250px">
                                                <div class="productviewsimg">
                                                    <img src="" alt="img" id="productImage1">
                                                </div>
                                                <div class="productviewscontent">
                                                    <div class="productviewsname">
                                                        <h2 id="imageName1">macbookpro.jpg</h2>
                                                        <h3 id="imageSize1">581kb</h3>
                                                    </div>
                                                    <a href="javascript:void(0);" class="hidesets" id="hidesets1">x</a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" id="submitBtnproduct" class="btn btn-submit me-2">Submit</button>
                                <button type="button" class="btn btn-cancel">Cancel</button>
                            </div>
                        </div>
                    </form>



                    <script>
                        $(document).ready(function() {
                            $('#submitBtnproduct').click(function(e) {
                                e.preventDefault();

                                var producttype = $('#product_type').val();
                                var name = $('#nameproduct').val();
                                var category = $('#categorySelect').val();

                                var subcategory = $('#subcategory').val();
                                var brand = $('#brandselect').val();
                                var type = $('#typeselect').val();

                                var quantity = $('#quantity').val();
                                var minimum_quantity = $('#minimum_qty').val();
                                var barcode = $('#barcode').val();

                                var price = $('#price').val();
                                var sale = $('#sale').val();
                                var productDescription = $('#descriptionproduct').val();




                                if (name.trim() === '') {

                                    Toastify({
                                        text: 'Name is required !',
                                        duration: 3000,
                                        gravity: 'top-left',
                                        close: true,
                                        backgroundColor: 'linear-gradient(to right, #910d06, #44160f)',
                                        className: 'toastify-custom',
                                    }).showToast();
                                    return;
                                }
                                if (category.trim() === '') {

                                    Toastify({
                                        text: ' Category is required!',
                                        duration: 3000,
                                        gravity: 'top-left',
                                        close: true,
                                        backgroundColor: 'linear-gradient(to right, #910d06, #44160f)',
                                        className: 'toastify-custom',
                                    }).showToast();
                                    return;
                                }
                                if (subcategory.trim() === '') {

                                    Toastify({
                                        text: ' Subcategory is required!',
                                        duration: 3000,
                                        gravity: 'top-left',
                                        close: true,
                                        backgroundColor: 'linear-gradient(to right, #910d06, #44160f)',
                                        className: 'toastify-custom',
                                    }).showToast();
                                    return;
                                }
                                if (brand.trim() === '') {

                                    Toastify({
                                        text: ' Brand is required!',
                                        duration: 3000,
                                        gravity: 'top-left',
                                        close: true,
                                        backgroundColor: 'linear-gradient(to right, #910d06, #44160f)',
                                        className: 'toastify-custom',
                                    }).showToast();
                                    return;
                                }
                                if (type.trim() === '') {

                                    Toastify({
                                        text: ' Type is required!',
                                        duration: 3000,
                                        gravity: 'top-left',
                                        close: true,
                                        backgroundColor: 'linear-gradient(to right, #910d06, #44160f)',
                                        className: 'toastify-custom',
                                    }).showToast();
                                    return;
                                }
                                if (quantity.trim() === '') {

                                    Toastify({
                                        text: ' Quantity is required!',
                                        duration: 3000,
                                        gravity: 'top-left',
                                        close: true,
                                        backgroundColor: 'linear-gradient(to right, #910d06, #44160f)',
                                        className: 'toastify-custom',
                                    }).showToast();
                                    return;
                                }
                                if (minimum_quantity.trim() === '') {

                                    Toastify({
                                        text: ' Minimum Quantity is required!',
                                        duration: 3000,
                                        gravity: 'top-left',
                                        close: true,
                                        backgroundColor: 'linear-gradient(to right, #910d06, #44160f)',
                                        className: 'toastify-custom',
                                    }).showToast();
                                    return;
                                }
                                if (barcode.trim() === '') {

                                    Toastify({
                                        text: ' Barcode is required!',
                                        duration: 3000,
                                        gravity: 'top-left',
                                        close: true,
                                        backgroundColor: 'linear-gradient(to right, #910d06, #44160f)',
                                        className: 'toastify-custom',
                                    }).showToast();
                                    return;
                                }
                                if (price.trim() === '') {

                                    Toastify({
                                        text: ' Price is required!',
                                        duration: 3000,
                                        gravity: 'top-left',
                                        close: true,
                                        backgroundColor: 'linear-gradient(to right, #910d06, #44160f)',
                                        className: 'toastify-custom',
                                    }).showToast();
                                    return;
                                }
                                if (sale.trim() === '') {

                                    Toastify({
                                        text: ' Sale is required!',
                                        duration: 3000,
                                        gravity: 'top-left',
                                        close: true,
                                        backgroundColor: 'linear-gradient(to right, #910d06, #44160f)',
                                        className: 'toastify-custom',
                                    }).showToast();
                                    return;
                                }
                                if (productDescription.trim() === '') {

                                    Toastify({
                                        text: ' Description is required!',
                                        duration: 3000,
                                        gravity: 'top-left',
                                        close: true,
                                        backgroundColor: 'linear-gradient(to right, #910d06, #44160f)',
                                        className: 'toastify-custom',
                                    }).showToast();
                                    return;
                                }





                                // Get the file input element
                                var productImageInput = $('#profilePicture1')[0];
                                var productImage = productImageInput.files[0];

                                // Create FormData object
                                var formData = new FormData();
                                formData.append('product_type', producttype);
                                formData.append('name', name);
                                formData.append('category', category);

                                formData.append('subcategory', subcategory);
                                formData.append('brand', brand);
                                formData.append('type', type);

                                formData.append('quantity', quantity);
                                formData.append('minimum_quantity', minimum_quantity);
                                formData.append('barcode', barcode);

                                formData.append('price', price);
                                formData.append('sale', sale);
                                formData.append('productDescription', productDescription);
                                var sizeif = $('.product-size').val();
                                if (parseInt(sizeif) === 1) {
                                    var size = [];
                                    $('#select2 option:selected').each(function() {
                                        size.push($(this).val());
                                    });

                                    formData.append('size', JSON.stringify(size));

                                    // formData.append('size', size);
                                }
                                formData.append('image', productImage);

                                // Get CSRF token value from the meta tag
                                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                                // Send AJAX request
                                $.ajax({
                                    url: "{{ route('product.store') }}",
                                    type: "POST",
                                    data: formData,
                                    processData: false, // Prevent jQuery from processing the data
                                    contentType: false, // Prevent jQuery from setting content type
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
                                    },
                                    success: function(response) {
                                        Toastify({
                                            text: 'Product stored successfully !',
                                            duration: 2000,
                                            gravity: 'top-left', // Position the toast notification at the top left corner
                                            close: true, // Show a close button
                                            backgroundColor: 'linear-gradient(to right, #118251, #16342a)', // Custom background color
                                            className: 'toastify-custom', // Custom CSS class for styling
                                        }).showToast();

                                        $('#product_type').val('');
                                        $('#nameproduct').val('');
                                        $('#categorySelect').val(null).trigger('change');

                                        $('#subcategory').val(null).trigger('change');
                                        $('#brandSelect').val(null).trigger('change');
                                        $('#typeselect').val(null).trigger('change');

                                        $('#quantity').val('');
                                        $('#minimum_qty').val('');
                                        $('#barcode').val('');

                                        $('#price').val('');
                                        $('#sale').val('');
                                        $('#descriptionproduct').val('');

                                        $('#profilePicture').val('');
                                        deletingImage.click();


                                    },
                                    error: function(xhr, status, error) {
                                        console.log(xhr, status, error);
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
    </div>
    </div>
    </div>
@endsection
@section('custom-js')
    {{-- display image while add --}}
    <script>
        const productviewsimg = document.getElementById("productImage1");
        const productviewsdiv = document.getElementById("pdoductviewes1");
        const deletingImage = document.getElementById("hidesets1");
        const fileInput = document.getElementById("profilePicture1");

        function displaySelectedImage() {

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const imageSrc = e.target.result; // Get the image data URL
                    const fileName = fileInput.files[0].name; // Get the file name
                    const fileSize = fileInput.files[0].size; // Get the file size in bytes

                    // Check if the file name is longer than 15 characters
                    let displayName = fileName.length > 15 ? fileName.substring(0, 10) + "...  " + fileName.substr(-4,
                        4) : fileName;

                    // Set the image source
                    productviewsimg.src = imageSrc;
                    // Set the file name in an HTML element
                    document.getElementById("imageName1").textContent = displayName;
                    // Set the rounded file size in an HTML element with "KB" suffix
                    document.getElementById("imageSize1").textContent = Math.round(fileSize / 1024) + " KB";
                    productviewsdiv.style.display = 'block';
                };

                deletingImage.addEventListener("click", function() {
                    // Set the src attribute to 'none' to remove the image
                    fileInput.value = '';
                    productviewsimg.src = "none";
                    productviewsdiv.style.display = 'none';
                });


                reader.readAsDataURL(fileInput.files[0]);
            }
        }
        deletingImage.addEventListener("click", function() {
            // Set the src attribute to 'none' to remove the image
            productviewsdiv.style.display = 'none';
        });


        productImage.onerror = function() {
            // If there is an error loading the image (e.g., it doesn't exist)
            productviewsdiv.style.display = 'none';
        };
    </script>


    <script src="assets/plugins/select2/js/select2.min.js"></script>


    <script>
        $('.select2').select2({});
        let getData;
        $('#select2').select2({
            placeholder: 'Select the size',
            allowClear: true,
            templateSelection: function(data) {
                // we can get the selected value in this variable : 
                getData = data.text;

                return data.text;
            }
        })
    </script>



@endsection
