@extends('layouts.nav')

@section('name', 'Update Product')
@section('custom-css')
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    {{-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> --}}
    <!------ Include the above in your HEAD tag ---------->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
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
                    <h4>Update Product</h4>
                    <h6>Update/Edit New product</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form method="POST" id="yourFormId" action="{{ route('product.update') }}"
                        enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" id="id" name="id" value="{{ $product->id }}">

                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Product type</label>
                                    <select name="product_type" class="select" id="product_types">
                                        <option value="standard"
                                            {{ $product->product_type == 'standard' ? 'selected' : '' }}>Standard</option>
                                        <option value="service" {{ $product->product_type == 'service' ? 'selected' : '' }}>
                                            Service</option>
                                    </select>

                                </div>

                            </div>



                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="product_name">Product Name</label>
                                    <input type="text" value="{{ $product->name }}" id="nameproducts" name="product_name"
                                        class="form-control">
                                </div>
                            </div>

                            <!-- --------------------------- -->
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Category 🦺</label>
                                    <div class="row">
                                        <div class="col-lg-10 col-sm-10 col-10">
                                            <select name="category_id" class="select" id="categorySelects">
                                            </select>

                                        </div>
                                        <script>
                                            let currentOptions = ''; // Variable to store current options
                                            let productCategoryId = {{ $product->category_id ?? 'null' }}; // Product's category ID

                                            function updateCategory() {
                                                fetch('{{ route('categories.fetch') }}')
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        const newOptions = data.categoryOptions;
                                                        // Check if the new options are different from the current options
                                                        if (newOptions !== currentOptions) {
                                                            // Update the select element with new options
                                                            document.getElementById('categorySelects').innerHTML = newOptions;
                                                            // Update the current options
                                                            currentOptions = newOptions;
                                                            // Pre-select the option based on product's category ID
                                                            if (productCategoryId !== null) {
                                                                document.querySelector(`#categorySelects option[value="${productCategoryId}"]`).selected =
                                                                    true;
                                                            }
                                                        }
                                                    })
                                                    .catch(error => console.error('Error fetching Category:', error));
                                            }

                                            // Update categories every 4 seconds (4000 milliseconds)
                                            setInterval(updateCategory, 2000);

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
                                                                                        class="form-control">

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
                                                                            backgroundColor: 'linear-gradient(to right, #910d06, #44160f)', // Red background color for error
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
                                                                            backgroundColor: 'linear-gradient(to right, #910d06, #44160f)', // Red background color for error
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
                                                                                text: 'Category stored successfully !',
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

                            <!-- --------------------------- -->
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Sub Category 🎲</label>
                                    <div class="row">

                                        <div class="col-lg-10 col-sm-10 col-10">
                                            <select name="subcategory" class="select" id="subcategorys">
                                            </select>

                                        </div>
                                        <script>
                                            let currentOptionss = ''; // Variable to store current options
                                            let productsubCategoryId = {{ $product->subcategory_id ?? 'null' }}; // Product's category ID

                                            function updateCategory() {
                                                fetch('{{ route('Subcategories.fetch') }}')
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        const newOptions = data.subcategoryOptions;
                                                        // Check if the new options are different from the current options
                                                        if (newOptions !== currentOptionss) {
                                                            // Update the select element with new options
                                                            document.getElementById('subcategorys').innerHTML = newOptions;
                                                            // Update the current options
                                                            currentOptionss = newOptions;
                                                            if (productsubCategoryId !== null) {
                                                                document.querySelector(`#subcategorys option[value="${productsubCategoryId}"]`).selected =
                                                                    true;
                                                            }
                                                        }
                                                    })
                                                    .catch(error => console.error('Error fetching Sub Category:', error));
                                            }

                                            // Update categories every 4 seconds (4000 milliseconds)
                                            setInterval(updateCategory, 2000);

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
                                                                                    <select name="category_id"
                                                                                        class="select"
                                                                                        id="categorySelectt">
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
                                                                                        class="form-control ">

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
                                                                                            id="profilePicture"
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
                                                                            backgroundColor: 'linear-gradient(to right, #910d06, #44160f)', // Red background color for error
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
                                                                            backgroundColor: 'linear-gradient(to right, #910d06, #44160f)', // Red background color for error
                                                                            className: 'toastify-custom', // Custom CSS class for styling
                                                                        }).showToast();
                                                                        return; // Exit function if name input is empty
                                                                    }



                                                                    // Check if description input is empty
                                                                    if (subDescription.trim() === '') {

                                                                        Toastify({
                                                                            text: 'Description is required !',
                                                                            duration: 3000,
                                                                            gravity: 'top-left', // Position the toast notification at the top left corner
                                                                            close: true, // Show a close button
                                                                            backgroundColor: 'linear-gradient(to right, #910d06, #44160f)', // Red background color for error
                                                                            className: 'toastify-custom', // Custom CSS class for styling
                                                                        }).showToast();
                                                                        return; // Exit function if description input is empty
                                                                    }

                                                                    // Get the file input element
                                                                    var subImageInput = $('#profilePicture')[0];
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
                                                                                text: 'Sub Category stored successfully !',
                                                                                duration: 2000,
                                                                                gravity: 'top-left', // Position the toast notification at the top left corner
                                                                                close: true, // Show a close button
                                                                                backgroundColor: 'linear-gradient(to right, #118251, #16342a)', // Custom background color
                                                                                className: 'toastify-custom', // Custom CSS class for styling
                                                                            }).showToast();
                                                                            $('#name').val('');
                                                                            $('#description').val('');
                                                                            $('#categorySelectt').val('');
                                                                            $('#profilePicture').val(''); // Reset file input

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

                            <!-- --------------------------- -->
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Brand 🥋</label>
                                    <div class="row">

                                        <div class="col-lg-10 col-sm-10 col-10">
                                            <select name="brand_id" class="select" id="brandselects">
                                            </select>

                                        </div>


                                        <script>
                                            let brandOptionsModel = '';
                                            let brandId = {{ $product->brand_id ?? 'null' }}; // Product's category ID

                                            function updatebrandModel() {
                                                fetch('{{ route('BrandModel.fetch') }}')
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        const newOptions = data.brandOptions;
                                                        // Check if the new options are different from the current options
                                                        if (newOptions !== brandOptionsModel) {
                                                            // Update the select element with new options
                                                            document.getElementById('brandselects').innerHTML = newOptions;
                                                            // Update the current options
                                                            brandOptionsModel = newOptions;

                                                            if (brandId !== null) {
                                                                document.querySelector(`#brandselects option[value="${brandId}"]`).selected = true;
                                                            }

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
                                                                                        placeholder="Entre description of your brand " class="form-control "></textarea>


                                                                                </div>
                                                                            </div>


                                                                            <div class="col-lg-12">
                                                                                <div class="form-group">
                                                                                    <label>Avatar</label>
                                                                                    <div class="image-upload image-upload-new"
                                                                                        id="image-upload">
                                                                                        <input type="file"
                                                                                            name="image"
                                                                                            class="form-control "
                                                                                            id="profilePictureBrand"
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
                                                                    var BrandImageInput = $('#profilePictureBrand')[0];
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
                                                                            $('#profilePictureBrand').val(''); // Reset file input
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



                            <!-- --------------------------- -->

                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Choose Type 📦</label>
                                    <div class="row">
                                        <div class="col-lg-10 col-sm-10 col-10">
                                            <select name="type_id" class="select " id="typeselects">
                                            </select>

                                        </div>



                                        <script>
                                            let TypeModel = '';
                                            let typeId = {{ $product->type_id ?? 'null' }}; // Product's category ID

                                            function updateTypeModel() {
                                                fetch('{{ route('TypeModel.fetch') }}')
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        const newOptions = data.typeOptions;
                                                        // Check if the new options are different from the current options
                                                        if (newOptions !== TypeModel) {
                                                            // Update the select element with new options
                                                            document.getElementById('typeselects').innerHTML = newOptions;
                                                            // Update the current options
                                                            TypeModel = newOptions;
                                                            if (brandId !== null) {
                                                                document.querySelector(`#typeselects option[value="${typeId}"]`).selected = true;
                                                            }

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

                                                                                    <input class="form-control"
                                                                                        type="text"
                                                                                        value="{{ old('type_name') }}"
                                                                                        id="type_name" name="type_name"
                                                                                        autofocus />

                                                                                </div>
                                                                            </div>



                                                                            <div class="col-lg-12">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="description">Description</label>
                                                                                    <textarea id="descriptionType" name="description" class="form-control ">{{ old('description') }}</textarea>


                                                                                </div>
                                                                            </div>



                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary"
                                                                        id="submitBtnType">Submit</button>
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>

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
                                                                                text: 'Type stored successfully !',
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
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="barcode">Product Barcode</label>
                                <input type="text" value="{{ $product->barcode }}" id="barcodes" name="barcode"
                                    class="form-control ">

                            </div>
                        </div>


                        @if ($product->productSizes->isNotEmpty())

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="quantity">Change Product Sizable ? </label>
                                <select name="product_type" class="product-size form-control">
                                    <option checked value="0">No</option>
                                    <option  value="1">Yes</option>
                                </select>
                                <script>
                                    setTimeout(() => {
                                        let sizable = document.querySelector('.product-size');
                                        let displaySize = document.querySelector('.productSize');
                                        // console.log(displaySize);
                                        sizable.addEventListener('change', (e) => {
                                            if ( e.target.value == 1) {
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
                                        let sizeIds = {!! json_encode($product->productSizes->pluck('size_id')->toArray()) !!}; // Initialize sizeIds properly
                                
                                        function updateSizeModel() {
                                            fetch('{{ route('sizeModel.fetch') }}')
                                                .then(response => {
                                                    if (!response.ok) {
                                                        throw new Error('Failed to fetch size data');
                                                    }
                                                    return response.json();
                                                })
                                                .then(data => {
                                                    const newOptions = data.SizeOptions;
                                                    document.getElementById('select2').innerHTML = newOptions;
                                                    // Select the previously selected sizes, if available
                                                    sizeIds.forEach(sizeId => {
                                                        document.querySelector(`#select2 option[value="${sizeId}"]`).selected = true;
                                                    });
                                                })
                                                .catch(error => console.error('Error fetching size data:', error.message));
                                        }
                                
                                        // Update size options when product type changes
                                        document.querySelector('.product-size').addEventListener('change', updateSizeModel);
                                
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
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"><i
                                                                class="fa-regular fa-circle-xmark"></i></button>
                                                    </div>

                                                    <form id="form-data" method="POST"
                                                        action="{{ route('size.model') }}" enctype="multipart/form-data">
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

                        @else
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
                                                    <h5 class="modal-title" id="exampleModalLabel">Create New Product Size</h5>
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

                                                                            <label
                                                                                for="type_name">Size Name</label>

                                                                            <input
                                                                                class="form-control "
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
@endif
                        {{-- dwae ama dayan bnerawa --}}

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="quantity">Quantity Product </label>
                                <input type="number" style="color: gray;" value="{{ $product->quantity }}"
                                    id="quantitys" name="quantity" class="form-control">

                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="minimum_qty">Minimum Quantity (⏰)</label>
                                <input type="number" style="color: gray;" value="{{ $product->minimum_qty }}"
                                    id="minimum_qtys" name="minimum_qty" class="form-control ">

                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="price">Product Price</label>
                                <input type="number" style="color: gray;" value="{{ $product->price }}" id="prices"
                                    name="price" class="form-control ">

                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="sale">Sale Product</label>
                                <input type="number" style="color: gray;" value="{{ $product->sale }}" id="sales"
                                    name="sale" class="form-control ">

                            </div>
                        </div>

                        @if (isset($purchases->expire_date))
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="expireDate">Expire Date</label>
                                    <input type="date" value="{{ $purchases->expire_date }}"
                                        style="font-family: 'Times New Roman', Times, serif" id="expireDates"
                                        name="expireDate" class="form-control ">

                                </div>
                            </div>
                        @endif
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="descriptionproducts" name="description" class="form-control ">{{ $product->description }}</textarea>


                            </div>
                        </div>


                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Avatar</label>
                                <div class="image-upload image-upload-new" id="image-upload">
                                    <input type="file" name="image" class="form-control "
                                        id="productProfilePicture" onchange="displaySelectedImage()">

                                    <div class="image-uploads" id="image-uploads">
                                        <img src="{{ asset('assets/img/icons/upload.svg') }}" alt="img"
                                            id="selectedImage">
                                        <h4 id="h4">Drag and drop a file to upload</h4>
                                    </div>

                                </div>
                            </div>
                        </div>




                        <div class="col-12" id="pdoductviewesproduct">
                            <div class="product-list">
                                <ul class="row">
                                    <li>
                                        <div class="productviews" style="width: 250px">
                                            <div class="productviewsimg">
                                                <img src="{{ asset('uploads/product/products/' . $product->image) }}"
                                                    alt="img" id="productImageproduct">

                                            </div>
                                            <div class="productviewscontent">
                                                <div class="productviewsname">
                                                    <h2 id="imageName">{{ $product->image }}</h2>
                                                    <h3 id="imageSize">
                                                        {{ formatBytes(filesize(public_path($product->image_path))) }}
                                                    </h3>




                                                </div>
                                                <a href="javascript:void(0);" class="hidesets" id="hidesets">x</a>
                                            </div>






                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>


                        <div class="col-lg-12">
                            <button type="submit" id="submitBtnproducts" class="btn btn-submit me-2">Submit</button>
                            <a href="{{ route('product.product.list') }}" class="btn btn-cancel">Cancel</a>
                        </div>



                </div>
                </form>


                <script>
                    $(document).ready(function() {
                        $('#submitBtnproducts').click(function(e) {
                            e.preventDefault();
                            var productIds = $('#id').val();

                            var producttypes = $('#product_types').val();
                            var names = $('#nameproducts').val();
                            var categorys = $('#categorySelects').val();

                            var subcategorys = $('#subcategorys').val();
                            var brands = $('#brandselects').val();
                            var types = $('#typeselects').val();
                            var quantitys = $('#quantitys').val();
                            var minimum_quantitys = $('#minimum_qtys').val();
                            var barcodes = $('#barcodes').val();

                            var prices = $('#prices').val();
                            var sales = $('#sales').val();
                            var productDescriptions = $('#descriptionproducts').val();
                            if (names.trim() === '') {

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
                            if (categorys.trim() === '') {

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
                            if (subcategorys.trim() === '') {

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
                            if (brands.trim() === '') {

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
                            if (types.trim() === '') {

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
                            if (quantitys.trim() === '') {

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
                            if (minimum_quantitys.trim() === '') {

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
                            if (barcodes.trim() === '') {

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
                            if (prices.trim() === '') {

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
                            if (sales.trim() === '') {

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
                            if (productDescriptions.trim() === '') {

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

                            var expireDates = $('#expireDates').val();

                            // Get the file input element
                            var productImageInput = $('#productProfilePicture')[0];
                            var productImages = productImageInput.files[0];

                            // Get CSRF token value from the meta tag
                            var csrfToken = $('meta[name="csrf-token"]').attr('content');

                            var formData = new FormData();
                            formData.append('id', productIds);
                            formData.append('brand', brands);
                            formData.append('expireDate', expireDates);
                            formData.append('category', categorys);
                            formData.append('subcategory', subcategorys);
                            formData.append('product_type', producttypes);
                            formData.append('name', names);
                            formData.append('type', types);
                            formData.append('minimum_quantitys', minimum_quantitys);
                            formData.append('barcode', barcodes);
                            formData.append('qunatity', quantitys);
                            formData.append('sale', sales);
                            formData.append('price', prices);
                            formData.append('description', productDescriptions);
                            var sizeif = $('.product-size').val();
                            if (parseInt(sizeif) === 1) {
                                var size = [];
                                $('#select2 option:selected').each(function() {
                                    size.push($(this).val());
                                });

                                formData.append('size', JSON.stringify(size));

                                // formData.append('size', size);
                            }
                   


                            formData.append('image', productImages);

                            $.ajax({
                                url: "{{ route('product.update') }}",
                                type: "POST",
                                data: formData,
                                contentType: false,
                                processData: false, // Ensure this is set to false to prevent jQuery from automatically processing the data
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
                                },
                                success: function(response) {
                                    Toastify({
                                        text: 'Product Updated Successfully !',
                                        duration: 2000,
                                        gravity: 'top-left', // Position the toast notification at the top left corner
                                        close: true, // Show a close button
                                        backgroundColor: 'linear-gradient(to right, #01919C, #2B2B2B)', // Custom background color
                                        className: 'toastify-custom', // Custom CSS class for styling
                                    }).showToast();
                                    setTimeout(function() {
                                        window.location.href =
                                            '{{ route('product.product.list') }}';
                                    }, 2000);


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
        const productviewsimg = document.getElementById("productImage");
        const productviewsdiv = document.getElementById("pdoductviewes");
        const deletingImage = document.getElementById("hidesets");
        const fileInput = document.getElementById("profilePicture");

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

                    productImage.src = imageSrc; // Set the image source
                    document.getElementById("imageName").textContent =
                        displayName; // Set the file name in an HTML element
                    document.getElementById("imageSize").textContent = Math.round(fileSize / 1024) +
                        " KB"; // Set the rounded file size in an HTML element with "KB" suffix

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

    {{-- display image while add --}}
    {{-- <script>
    const productviewsimg = document.getElementById("productImage");
        const productviewsdiv = document.getElementById("pdoductviewes");
        const deletingImage = document.getElementById("hidesets");
        const fileInput = document.getElementById("profilePicture");

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

                    productImage.src = imageSrc; // Set the image source
                    document.getElementById("imageName").textContent =
                        displayName; // Set the file name in an HTML element
                    document.getElementById("imageSize").textContent = Math.round(fileSize / 1024) +
                        " KB"; // Set the rounded file size in an HTML element with "KB" suffix

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
</script> --}}

    {{-- <script>
    function formatPhoneNumber(input) {
            let value = input.value.replace(/\D/g, ''); // Remove non-digit characters
            if (value.length > 11) {
                value = value.substr(0, 11); // Limit to 11 digits
            }
            if (value.length > 7) {
                value = value.replace(/(\d{4})(\d{3})(\d{4})/, '$1 $2 $3'); // Add spaces
            } else if (value.length > 4) {
                value = value.replace(/(\d{4})(\d{0,3})/, '$1 $2'); // Add space after first 4 digits
            }
            input.value = value;
        }
</script> --}}

    {{-- <script>
    $(document).ready(function() {
            $('.add_category').click(function() {
                // Open modal
                $('#editModal').modal('show');

                // Load content from Page 2 into modal body
                $('#editModal .modal-content').load(
                    'ediUser.blade.php'); // Replace 'page2.html' with the correct URL
            });
        });
</script> --}}

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


        // function select2_template(data) {
        //     console.log(data)
        // }
    </script>
    {{-- <script src="assets/plugins/select2/js/custom-select.js"></script>
<script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
<script src="assets/plugins/sweetalert/sweetalerts.min.js"></script> --}}



@endsection
