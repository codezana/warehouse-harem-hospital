@extends('layouts.nav')

@section('name', 'Add New sales')
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    {{-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> --}}
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>


    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>









@endsection
@section('content')

    <style>
        .custom-select {
            position: relative;
            width: 200px;
            border: 1px solid #ccc;
            padding: 5px;
            cursor: pointer;
        }

        .select-header {
            background-color: #f5f5f5;
            padding: 5px;
        }

        .options {
            display: none;
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            width: 100%;
        }

        .option {
            padding: 5px;
            cursor: pointer;
        }

        .option:hover {
            background-color: #f0f0f0;
        }

        body[data-theme="dark"] .select2-search--dropdown {
            background: #1d1d42ff;
        }

        body[data-theme="dark"] .select2-search__field {
            background: #1d1d42ff;
            color: white;
            border: none;
        }

        .form-group input[type="number"],
        input[type="number"],
        .form-group input[type="password"],
        input[type="text"] {
            border: 1px solid rgba(145, 158, 171, 0.32);
            height: 40px;
            width: 100%;
            font-size: 14px;
            font-weight: 500;
            color: #637381;
            padding: 10px 15px;
            border-radius: 5px;
        }

        body[data-theme="dark"] .form-group input[type="number"],
        body[data-theme="dark"] input[type="number"] {
            background: #1d1d42 !important;
            color: #97a2d2;
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


        td,
        th {
            text-align: center
        }
    </style>


    <div class="page-wrapper page-wrapper-one">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Add Sale</h4>
                    <h6>Add your new sale</h6>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row" style="position: relative">

                        <!-- --------------------------- -->
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Product Name 🚚</label>
                                <div class="row">
                                    <div class="col-lg-10 col-sm-10 col-10">
                                        <select class="name_select select2 @error('product_id') is-invalid @enderror"
                                            name="product_id" id="productselect">

                                        </select>
                                        @error('product_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>



                                    <script>
                                        let productOptionsModel = '';

                                        function updateproductModel() {
                                            fetch('{{ route('ProductModelsale.fetch') }}')
                                                .then(response => response.json())
                                                .then(data => {
                                                    const newOptions = data.ProductOptions;
                                                    // Check if the new options are different from the current options
                                                    if (newOptions !== productOptionsModel) {
                                                        // Update the select element with new options
                                                        document.getElementById('productselect').innerHTML = newOptions;
                                                        // Update the current options
                                                        productOptionsModel = newOptions;
                                                    }
                                                })
                                                .catch(error => console.error('Error fetching product:', error));
                                        }

                                        // Update categories every 4 seconds (4000 milliseconds)
                                        setInterval(updateproductModel, 4000);

                                        // Initial call to update on page load
                                        updateproductModel();
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
                                                            Product 🚚
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"><i
                                                                class="fa-regular fa-circle-xmark"></i></button>
                                                    </div>

                                                    <form id="form-data" method="POST"
                                                        action="{{ route('Product.model') }}" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="card">
                                                                <div class="card-body">


                                                                    <div class="row">
                                                                        <div class="col-lg-3 col-sm-6 col-12">
                                                                            <div class="form-group">
                                                                                <label>Product type</label>
                                                                                <select name="product_type"
                                                                                    id="product_type"
                                                                                    class="select2 form-control @error('product_type') is-invalid @enderror">

                                                                                    <option value="standard">Standard
                                                                                    </option>
                                                                                    <option value="service">Service</option>

                                                                                </select>
                                                                                @error('product_type')
                                                                                    <span class="invalid-feedback"
                                                                                        role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>

                                                                        </div>



                                                                        <div class="col-lg-3 col-sm-6 col-12">
                                                                            <div class="form-group">
                                                                                <label for="name">Product
                                                                                    Name</label>
                                                                                <input type="text"
                                                                                    value="{{ old('name') }}"
                                                                                    id="nameproduct" name="name"
                                                                                    class="form-control @error('name') is-invalid @enderror">
                                                                                @error('name')
                                                                                    <span class="invalid-feedback"
                                                                                        role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>


                                                                        <div class="col-lg-3 col-sm-6 col-12">
                                                                            <div class="form-group">
                                                                                <label>Category 🦺</label>
                                                                                <select name="categorySelect"
                                                                                    id="categorySelect"
                                                                                    class="select2 form-control @error('categorySelect') is-invalid @enderror">

                                                                                </select>
                                                                                @error('categorySelect')
                                                                                    <span class="invalid-feedback"
                                                                                        role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>

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

                                                                        <div class="col-lg-3 col-sm-6 col-12">
                                                                            <div class="form-group">
                                                                                <label>Sub Category 🎲</label>
                                                                                <select name="product_subcategory"
                                                                                    id="subcategorySelect"
                                                                                    class="select2 form-control @error('product_subcategory') is-invalid @enderror">

                                                                                </select>
                                                                                @error('product_subcategory')
                                                                                    <span class="invalid-feedback"
                                                                                        role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>

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
                                                                                            document.getElementById('subcategorySelect').innerHTML = newOptions;
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

                                                                        <div class="col-lg-3 col-sm-6 col-12">
                                                                            <div class="form-group">
                                                                                <label>Brand 🥋</label>
                                                                                <select name="product_brand"
                                                                                    id="brandSelectts"
                                                                                    class="select2 form-control @error('product_brand') is-invalid @enderror">

                                                                                </select>
                                                                                @error('product_brand')
                                                                                    <span class="invalid-feedback"
                                                                                        role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>

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
                                                                                            document.getElementById('brandSelectts').innerHTML = newOptions;
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

                                                                        <div class="col-lg-3 col-sm-6 col-12">
                                                                            <div class="form-group">
                                                                                <label>Choose Type 📦</label>
                                                                                <select name="typeselect" id="typeselect"
                                                                                    class="select2 form-control @error('typeselect') is-invalid @enderror">

                                                                                </select>
                                                                                @error('typeselect')
                                                                                    <span class="invalid-feedback"
                                                                                        role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>
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


                                                                        <div class="col-lg-3 col-sm-6 col-12">
                                                                            <div class="form-group">
                                                                                <label for="quantity">Quantity Product
                                                                                </label>
                                                                                <input type="number"
                                                                                    value="{{ old('quantity') }}"
                                                                                    id="quantity" name="quantity"
                                                                                    class="form-control @error('quantity') is-invalid @enderror">
                                                                                @error('quantity')
                                                                                    <span class="invalid-feedback"
                                                                                        role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-3 col-sm-6 col-12">
                                                                            <div class="form-group">
                                                                                <label for="minimum_qty">Minimum
                                                                                    Quantity (⏰)</label>
                                                                                <input type="number"
                                                                                    value="{{ old('minimum_qty') }}"
                                                                                    id="minimum_qty" name="minimum_qty"
                                                                                    class="form-control @error('minimum_qty') is-invalid @enderror">
                                                                                @error('minimum_qty')
                                                                                    <span class="invalid-feedback"
                                                                                        role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>


                                                                        <div class="col-lg-3 col-sm-6 col-12">
                                                                            <div class="form-group">
                                                                                <label for="barcode">Product
                                                                                    Barcode</label>
                                                                                <input type="text"
                                                                                    value="{{ old('barcode') }}"
                                                                                    id="barcode" name="barcode"
                                                                                    class="form-control @error('barcode') is-invalid @enderror">
                                                                                @error('barcode')
                                                                                    <span class="invalid-feedback"
                                                                                        role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-3 col-sm-6 col-12">
                                                                            <div class="form-group">
                                                                                <label for="price">Product Price</label>
                                                                                <input type="number"
                                                                                    value="{{ old('price') }}"
                                                                                    id="price" name="price"
                                                                                    class="form-control @error('price') is-invalid @enderror">
                                                                                @error('price')
                                                                                    <span class="invalid-feedback"
                                                                                        role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-3 col-sm-6 col-12">
                                                                            <div class="form-group">
                                                                                <label for="sale">Sale Product</label>
                                                                                <input type="number"
                                                                                    value="{{ old('sale') }}"
                                                                                    id="sale" name="sale"
                                                                                    class="form-control @error('sale') is-invalid @enderror">
                                                                                @error('sale')
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
                                                                                <textarea value="{{ old('description') }}" id="descriptionproduct" name="description"
                                                                                    placeholder="Entre description of your product " class="form-control @error('description') is-invalid @enderror"></textarea>
                                                                                @error('description')
                                                                                    <span class="invalid-feedback"
                                                                                        role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror

                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label> Product Image</label>
                                                                                <div class="image-upload image-upload-new"
                                                                                    id="image-upload">
                                                                                    <input type="file" name="image"
                                                                                        class="form-control @error('image') is-invalid @enderror"
                                                                                        id="productProfilePicture"
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
                                                                                    @error('image')
                                                                                        <span class="invalid-feedback"
                                                                                            role="alert">
                                                                                            <strong>{{ $message }}</strong>
                                                                                        </span>
                                                                                    @enderror
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
                                                                                            <div class="productviewsimg">
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
                                                                    id="submitBtnproduct">Submit</button>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>

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

                                                                var subcategory = $('#subcategorySelect').val();
                                                                var brand = $('#brandSelectts').val();
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
                                                                        backgroundColor: '#ff0000',
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
                                                                        backgroundColor: '#ff0000',
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
                                                                        backgroundColor: '#ff0000',
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
                                                                        backgroundColor: '#ff0000',
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
                                                                        backgroundColor: '#ff0000',
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
                                                                        backgroundColor: '#ff0000',
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
                                                                        backgroundColor: '#ff0000',
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
                                                                        backgroundColor: '#ff0000',
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
                                                                        backgroundColor: '#ff0000',
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
                                                                        backgroundColor: '#ff0000',
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
                                                                        backgroundColor: '#ff0000',
                                                                        className: 'toastify-custom',
                                                                    }).showToast();
                                                                    return;
                                                                }





                                                                // Get the file input element
                                                                var productImageInput = $('#productProfilePicture')[0];
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

                                                                formData.append('image', productImage);

                                                                // Get CSRF token value from the meta tag
                                                                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                                                                // Send AJAX request
                                                                $.ajax({
                                                                    url: "{{ route('Product.model') }}",
                                                                    type: "POST",
                                                                    data: formData,
                                                                    processData: false, // Prevent jQuery from processing the data
                                                                    contentType: false, // Prevent jQuery from setting content type
                                                                    headers: {
                                                                        'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
                                                                    },
                                                                    success: function(response) {
                                                                        Toastify({
                                                                            text: 'Product stored successfully!!',
                                                                            duration: 2000,
                                                                            gravity: 'top-left', // Position the toast notification at the top left corner
                                                                            close: true, // Show a close button
                                                                            backgroundColor: 'linear-gradient(to right, #118251, #16342a)', // Custom background color
                                                                            className: 'toastify-custom', // Custom CSS class for styling
                                                                        }).showToast();

                                                                        $('#product_type').val('');
                                                                        $('#nameproduct').val('');
                                                                        $('#categorySelect').val('');

                                                                        $('#subcategorySelect').val('');
                                                                        $('#brandSelectts').val('');
                                                                        $('#typeselect').val('');

                                                                        $('#quantity').val('');
                                                                        $('#minimum_qty').val('');
                                                                        $('#barcode').val('');

                                                                        $('#price').val('');
                                                                        $('#sale').val('');
                                                                        $('#descriptionproduct').val('');

                                                                        $('#productProfilePicture').val('');


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


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Number Of Product</label>
                                <div class="input-groupicon">
                                    <input type="text" id="numberOfProduct" placeholder="" readonly
                                        style="text-align: center" class="NOP">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Price</label>
                                <div class="input-groupicon">
                                    <input type="text" id="productPrice" placeholder="" readonly
                                        style="text-align: center" class="price">
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Quantity</label>
                                <div class="input-groupicon">
                                    <input class="quantity" type="number" placeholder="Quantity">
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Resicpt</label>
                            <div class="input-groupicon">
                                <input class="Resicpt" type="text" name="resicpt" placeholder="number of resicpt">

                            </div>
                        </div>
                    </div> --}}
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Date</label>
                                <div class="input-groupicon">
                                    <input type="text" placeholder="Choose Date" name="date"
                                        class="datetimepicker Date">
                                    <a class="addonset">
                                        <img src="assets/img/icons/calendars.svg" alt="img">
                                    </a>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Customer </label>
                                <div class="row">
                                    <div class="col-lg-10 col-sm-10 col-10">
                                        <select id="customerSelect" class="Customer_name select2 form-control"
                                            name="customer_id">

                                        </select>


                                    </div>

                                    <script>
                                        let currentOptionsModel = '';

                                        function updateCustomerModel() {
                                            fetch('{{ route('CustomerModel.fetch') }}')
                                                .then(response => response.json())
                                                .then(data => {
                                                    const newOptions = data.CustomerOptions;
                                                    // Check if the new options are different from the current options
                                                    if (newOptions !== currentOptionsModel) {
                                                        // Update the select element with new options
                                                        document.getElementById('customerSelect').innerHTML = newOptions;
                                                        // Update the current options
                                                        currentOptionsModel = newOptions;
                                                    }
                                                })
                                                .catch(error => console.error('Error fetching Customer:', error));
                                        }

                                        // Update categories every 4 seconds (4000 milliseconds)
                                        setInterval(updateCustomerModel, 4000);

                                        // Initial call to update on page load
                                        updateCustomerModel();
                                    </script>
                                    <div class="col-lg-2 col-sm-2 col-2 ps-0" class="btn btn-primary"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <div class="add-icon">
                                            <span><img src="assets/img/icons/plus1.svg" alt="img"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Customer Form</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"><i class="fa-regular fa-circle-xmark"></i></button>
                                        </div>
                                        <form id="form-data" method="POST" action="{{ route('Customer.model') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="card">
                                                    <div class="card-body">


                                                        <div class="row">

                                                            <div class="col-lg-6 col-sm-12 col-12">
                                                                <div class="form-group">

                                                                    <label
                                                                        for="customer_name">{{ __('Customer Name') }}</label>

                                                                    <input
                                                                        class="form-control @error('customer_name') is-invalid @enderror"
                                                                        type="text" value="{{ old('customer_name') }}"
                                                                        id="customer_name" name="customer_name"
                                                                        autofocus />
                                                                    @error('customer_name')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror

                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-sm-12 col-12">
                                                                <div class="form-group">
                                                                    <label for="email">Email Address</label>
                                                                    <input
                                                                        class="form-control @error('email') is-invalid @enderror"
                                                                        type="email" value="{{ old('email') }}"
                                                                        id="emailCustomer" name="email"
                                                                        placeholder="Customer@example.com" required>
                                                                    @error('email')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>






                                                            <div class="col-lg-6 col-sm-12 col-12">
                                                                <div class="form-group">
                                                                    <label for="phone">Phone Address</label>
                                                                    <input
                                                                        class="form-control @error('phone') is-invalid @enderror"
                                                                        value="{{ old('phone') }}" type="text"
                                                                        id="phone" name="phone"
                                                                        placeholder="0770 111 2222"
                                                                        oninput="formatPhoneNumber(this)"
                                                                        pattern="\d{4} \d{3} \d{4}"
                                                                        title="Please enter a phone number in the format 0770 111 2222" />
                                                                    @error('phone')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>



                                                            <div class="col-lg-6 col-sm-12 col-12">
                                                                <div class="form-group">
                                                                    <label>City</label>
                                                                    <select
                                                                        class="form-control select @error('city') is-invalid @enderror"
                                                                        id="city" name="city">
                                                                        <option value="sulaymaniyah">Sulaymaniyah
                                                                        </option>
                                                                        <option value="hawler">Hawler
                                                                        </option>
                                                                        <option value="halabja">Halabja
                                                                        </option>
                                                                        <option value="Duhok">Duhok
                                                                        </option>


                                                                    </select>
                                                                    @error('city')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>

                                                            </div>




                                                            <div class="col-lg-6 col-sm-12 col-12">
                                                                <div class="form-group">

                                                                    <label for="district">{{ __('District') }}</label>

                                                                    <input
                                                                        class="form-control @error('district') is-invalid @enderror"
                                                                        type="text" value="{{ old('district') }}"
                                                                        id="district" name="district" autofocus />
                                                                    @error('district')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror

                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-sm-12 col-12">
                                                                <div class="form-group">

                                                                    <label for="address">{{ __('Address') }}</label>

                                                                    <input
                                                                        class="form-control @error('address') is-invalid @enderror"
                                                                        type="text" value="{{ old('address') }}"
                                                                        id="address" name="address" autofocus />
                                                                    @error('address')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror

                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label for="description">Description</label>
                                                                    <textarea id="descriptionCustomer" name="description"
                                                                        class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                                                    @error('description')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror

                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label> Customer Image</label>
                                                                    <div class="image-upload image-upload-new"
                                                                        id="image-upload">
                                                                        <input type="file" name="image"
                                                                            class="form-control @error('image') is-invalid @enderror"
                                                                            id="CustomerProfilePicture"
                                                                            onchange="displaySelectedImage()">

                                                                        <div class="image-uploads" id="image-uploads">
                                                                            <img src="{{ asset('assets/img/icons/upload.svg') }}"
                                                                                alt="img" id="selectedImage">
                                                                            <h4 id="h4">Drag and
                                                                                drop a
                                                                                file to upload</h4>
                                                                        </div>
                                                                        @error('image')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12" id="pdoductviewes" style="display: none">
                                                                <div class="product-list">
                                                                    <ul class="row">
                                                                        <li>
                                                                            <div class="productviews"
                                                                                style="width: 250px">
                                                                                <div class="productviewsimg">
                                                                                    <img src="" alt="img"
                                                                                        id="productImage">
                                                                                </div>
                                                                                <div class="productviewscontent">
                                                                                    <div class="productviewsname">
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
                                                        id="submitBtnCustomer">Submit</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>

                                                </div>
                                            </div>
                                        </form>
                                        <script>
                                            $(document).ready(function() {
                                                $('#submitBtnCustomer').click(function(e) {
                                                    e.preventDefault();

                                                    var CustomerName = $('#customer_name').val();

                                                    if (CustomerName.trim() === '') {

                                                        Toastify({
                                                            text: ' Name is required!',
                                                            duration: 3000,
                                                            gravity: 'top-left',
                                                            close: true,
                                                            backgroundColor: '#ff0000',
                                                            className: 'toastify-custom',
                                                        }).showToast();
                                                        return;
                                                    }
                                                    // Get the value of the email input
                                                    var Customeremail = $('#emailCustomer').val();

                                                    // Validate the email format using a regular expression
                                                    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                                                    if (!emailRegex.test(Customeremail)) {
                                                        // If the email format is invalid, display an error message and return
                                                        $('#emailCustomer').addClass('is-invalid');

                                                        Toastify({
                                                            text: ' Enter A vaild Email Address',
                                                            duration: 3000,
                                                            gravity: 'top-left',
                                                            close: true,
                                                            backgroundColor: '#ff0000',
                                                            className: 'toastify-custom',
                                                        }).showToast();

                                                        return;
                                                    } else {
                                                        // If the email format is valid, remove any existing error message and continue
                                                        $('#emailCustomer').removeClass('is-invalid');
                                                        $('#emailError').text('');
                                                    }

                                                    // Get the value of the phone input
                                                    var Customerphone = $('#phone').val();

                                                    // Remove any non-digit characters from the input
                                                    var phoneDigits = Customerphone.replace(/\D/g, '');

                                                    // Check if the remaining digits match the format of exactly seven digits
                                                    if (phoneDigits.length !== 11 || !/^\d{11}$/.test(phoneDigits)) {
                                                        // If the input does not match the expected format, display an error message
                                                        $('#phone').addClass('is-invalid');

                                                        Toastify({
                                                            text: ' Please enter a phone number with exactly seven digits',
                                                            duration: 3000,
                                                            gravity: 'top-left',
                                                            close: true,
                                                            backgroundColor: '#ff0000',
                                                            className: 'toastify-custom',
                                                        }).showToast();
                                                        return;
                                                    } else {
                                                        // If the input matches the expected format, remove any existing error message
                                                        $('#phone').removeClass('is-invalid');
                                                        $('#phoneError').text('');
                                                    }

                                                    var Customercity = $('#city').val();
                                                    var Customerdistrict = $('#district').val();
                                                    var Customeraddress = $('#address').val();
                                                    var CustomerDescription = $('#descriptionCustomer').val();


                                                    if (Customercity.trim() === '') {

                                                        Toastify({
                                                            text: ' City is required!',
                                                            duration: 3000,
                                                            gravity: 'top-left',
                                                            close: true,
                                                            backgroundColor: '#ff0000',
                                                            className: 'toastify-custom',
                                                        }).showToast();
                                                        return;
                                                    }
                                                    if (Customerdistrict.trim() === '') {

                                                        Toastify({
                                                            text: ' District is required!',
                                                            duration: 3000,
                                                            gravity: 'top-left',
                                                            close: true,
                                                            backgroundColor: '#ff0000',
                                                            className: 'toastify-custom',
                                                        }).showToast();
                                                        return;
                                                    }
                                                    if (Customeraddress.trim() === '') {

                                                        Toastify({
                                                            text: ' Address is required!',
                                                            duration: 3000,
                                                            gravity: 'top-left',
                                                            close: true,
                                                            backgroundColor: '#ff0000',
                                                            className: 'toastify-custom',
                                                        }).showToast();
                                                        return;
                                                    }
                                                    if (CustomerDescription.trim() === '') {

                                                        Toastify({
                                                            text: ' Description is required!',
                                                            duration: 3000,
                                                            gravity: 'top-left',
                                                            close: true,
                                                            backgroundColor: '#ff0000',
                                                            className: 'toastify-custom',
                                                        }).showToast();
                                                        return;
                                                    }
                                                    // Get the file input element
                                                    var CustomerImageInput = $('#CustomerProfilePicture')[0];
                                                    var CustomerImage = CustomerImageInput.files[0];



                                                    // Create FormData object
                                                    var formData = new FormData();
                                                    formData.append('name', CustomerName);
                                                    formData.append('email', Customeremail);
                                                    formData.append('phone', Customerphone);
                                                    formData.append('city', Customercity);
                                                    formData.append('district', Customerdistrict);
                                                    formData.append('address', Customeraddress);
                                                    formData.append('description', CustomerDescription);
                                                    formData.append('image', CustomerImage);
                                                    // Get CSRF token value from the meta tag
                                                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                                                    console.log(csrfToken)


                                                    // Check if the email already exists in the database
                                                    $.ajax({
                                                        url: "{{ route('checkEmailExistenceCustomer') }}",
                                                        type: "POST",
                                                        data: {
                                                            email: Customeremail
                                                        },
                                                        headers: {
                                                            'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
                                                        },
                                                        success: function(response) {
                                                            if (response.exists) {
                                                                // If email already exists in the database, display a notification
                                                                Toastify({
                                                                    text: 'Email already exists in the database!',
                                                                    duration: 3000,
                                                                    gravity: 'top-left', // Position the toast notification at the top left corner
                                                                    close: true, // Show a close button
                                                                    backgroundColor: '#ff0000', // Red background color for error
                                                                    className: 'toastify-custom', // Custom CSS class for styling
                                                                }).showToast();
                                                            } else {

                                                                // Send AJAX request
                                                                $.ajax({
                                                                    url: "{{ route('Customer.model') }}",
                                                                    type: "POST",
                                                                    data: formData,
                                                                    processData: false, // Prevent jQuery from processing the data
                                                                    contentType: false, // Prevent jQuery from setting content type
                                                                    headers: {
                                                                        'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
                                                                    },
                                                                    success: function(response) {
                                                                        Toastify({
                                                                            text: 'Customer stored successfully!!',
                                                                            duration: 2000,
                                                                            gravity: 'top-left', // Position the toast notification at the top left corner
                                                                            close: true, // Show a close button
                                                                            backgroundColor: 'linear-gradient(to right, #118251, #16342a)', // Custom background color
                                                                            className: 'toastify-custom', // Custom CSS class for styling
                                                                        }).showToast();

                                                                        // Reset input fields after successful submission
                                                                        $('#customer_name').val('');
                                                                        $('#emailCustomer').val('');
                                                                        $('#phone').val('');
                                                                        $('#city').val('');
                                                                        $('#district').val('');
                                                                        $('#address').val('');
                                                                        $('#descriptionCustomer').val('');
                                                                        $('#CustomerProfilePicture').val('');
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
                                                            }
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












                                    </div>
                                </div>

                            </div>

                        </div>









                        <div class="col-lg-1 col-sm-6 col-12 ms-auto"
                            style="cursor: pointer; margin-top: 30px ; width:127px;">
                            <div class="add-icon">
                                <button id="add-item-button" class="btn btn-submit" style="color: white;width:100px;">Add
                                    Item</button>
                            </div>
                        </div>





                        <form action="{{ route('store_sales') }}" method="POST">


                            <div class="row">
                                <div class="table-responsive mb-3">
                                    <table id="item-table" class="table">
                                        <!-- Add your table headers here -->
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Product Name</th>
                                                <th style="display: none">Product ID</th>
                                                <th>QTY</th>
                                                <th>Price</th>
                                                <th>Subtotal</th>
                                                <th>Date</th>
                                                <th>Customer</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <div class="row">
                                <!-- Shipping -->
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Shipping</label>
                                        <input type="number" id="shippingInput">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select id="statusSelect" class="form-control">
                                            {{-- <option>Choose Status</option> --}}
                                            <option>Completed</option>
                                            <option selected>Inprogress</option>
                                        </select>
                                    </div>
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-lg-6 ">
                                    <div class="total-order w-100 max-widthauto m-auto mb-4">
                                        <ul>
                                            <li>
                                                <h4>Dollar Price</h4>
                                                <div class="input-groupicon" style="width: 50%;">
                                                    <input id="dinar" style="text-align: right;border: none"
                                                        type="number" placeholder="Dollar price">
                                                </div>
                                            </li>
                                            <li>
                                                <h4>Total Dinar</h4>
                                                <h5 id="grand-total-dinar">0</h5>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-6 ">
                                    <div class="total-order w-100 max-widthauto m-auto mb-4">
                                        <ul>
                                            <li>
                                                <h4>Total Quantity</h4>
                                                <h5 id="quantityDisplay">0</h5>
                                            </li>
                                            <li class="total">
                                                <h4>Total Dollar</h4>
                                                <h5 id="grand-total">$ 0.00</h5>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                            <!-- Form contents go /addsales/storehere -->

                            <div class="col-lg-12">
                                <button type="submit" id="submit-button" class="btn btn-submit me-2">Submit</button>
                                <a href="{{ route('saleslist.page') }}" id="cancel-button" class="btn btn-cancel">Cancel</a>
                            </div>


                        </form>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                $('.select2').select2();
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('custom-js')






    <!-- Cheack quantity -->
    <script>
        $(document).ready(function() {
            // Disable the "Add Item" button initially
            $('#add-item-button').prop('disabled', true);

            function checkFields() {
                var productName = $('.name_select').val();
                var numberOfProduct = $('#numberOfProduct').val();
                var productPrice = $('#productPrice').val();
                var customer = $('#customerSelect').val();
                var quantity = $('.quantity').val();
                // var resicpt = $('.Resicpt').val();
                var date = $('.Date').val();

                // Check if all necessary fields are filled
                if (productName && numberOfProduct && productPrice && customer && quantity && date) {
                    $('#add-item-button').prop('disabled', false);
                } else {
                    $('#add-item-button').prop('disabled', true);
                }
            }

            // Listen for input changes in various fields
            $('.name_select, #numberOfProduct, #productPrice, #customerSelect, .quantity, .Date').on(
                'input change',
                function() {
                    checkFields();
                });

            // Disable the "Add Item" button when there's an error initially
            checkFields();
        });


        $(document).ready(function() {
            // Disable the "Add Item" button initially
            $('#add-item-button').prop('disabled', true);

            $('.quantity').on('input', function() {
                var enteredQuantity = $(this).val();
                var availableQuantity = $('.name_select option:selected').data('quantity');

                if (!enteredQuantity) {
                    hideError($(this));
                    $('#add-item-button').prop('disabled', true);
                } else if (isNaN(enteredQuantity) || parseInt(enteredQuantity) <= 0) {
                    showError($(this), 'Quantity must be a positive number');
                    $('#add-item-button').prop('disabled', true);
                } else if (parseInt(enteredQuantity) > availableQuantity) {
                    showError($(this), 'You can\'t get this many');
                    $('#add-item-button').prop('disabled', true);
                } else {
                    hideError($(this));
                    $('#add-item-button').prop('disabled', false);
                }
            });

            // Disable the "Add Item" button when there's an error initially
            $('.quantity').trigger('input');

            // Rest of your code...

            function showError(element, message) {
                var errorElement = $('<span class="error-message text-danger">' + message + '</span>');
                element.parent().find('.error-message').remove();
                element.parent().append(errorElement);
            }

            function hideError(element) {
                element.parent().find('.error-message').remove();
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#submit-button').click(function(event) {
                event.preventDefault(); // Prevent the default form submission

                var tableData = [];

                $('#item-table tbody tr').each(function() {
                    var dateText = $(this).find('td:nth-child(7)').text().trim();
                    var parts = dateText.split('-');
                    var date = null;

                    // Check if dateText is not empty and has three parts
                    if (dateText && parts.length === 3) {
                        // Construct a new date string in YYYY-MM-DD format
                        date = parts[2] + '-' + parts[1] + '-' + parts[0];

                        // Check if the constructed date string is valid
                        var parsedDate = new Date(date);
                        if (isNaN(parsedDate.getTime())) {
                            console.error('Invalid date:', dateText);
                            date = null; // Reset date to null if it's invalid
                        }
                    } else {
                        console.error('Invalid date format:', dateText);
                    }
                    var rowData = {
                        product_id: $(this).find('td:nth-child(3)').text(),
                        quantity: parseInt($(this).find('td:nth-child(4)').text()),
                        price: parseFloat($(this).find('td:nth-child(5)').text()),
                        subtotal: parseFloat($(this).find('td:nth-child(6)').text()),
                        date: date,
                        customer_id: $(this).find('td:nth-child(8)').text()
                    };
                    console.log('Date:', rowData.date);

                    tableData.push(rowData);
                });
                var grandTotalDinar = $('#grand-total-dinar').text().replace(/,/g, '');
                var grandTotalDollarText = $('#grand-total').text().replace('$', '').replace(/,/g, '');
                var grandTotalDollar = parseFloat(grandTotalDollarText);
                var dolar = $('#dinar').val();


                var shipping = $('#shippingInput').val(); // Get the shipping value
                var status = $('#statusSelect').val(); // Get the status value


                $.ajax({
                    type: 'POST',
                    url: '{{ route('store_sales') }}',
                    data: {
                        tableData: tableData,
                        grandTotalDinar: grandTotalDinar,
                        grandTotalDollar: grandTotalDollar,
                        shipping: shipping,
                        dolar: dolar,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Toastify({
                            text: 'Sale stored successfully !',
                            duration: 2000,
                            gravity: 'top-left', // Position the toast notification at the top left corner
                            close: true, // Show a close button
                            backgroundColor: 'linear-gradient(to right, #118251, #16342a)', // Custom background color
                            className: 'toastify-custom', // Custom CSS class for styling
                        }).showToast();

                        // Refresh the page after a delay
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);


                    },
                    error: function(error) {
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

                $('#item-table tbody').empty();
            });

            // Your other JavaScript code goes here...
        });
    </script>


    <!--Cheack price and qauantity from product name -->
    <script>
        $(document).ready(function() {
            $('.name_select').on('change', function() {
                var selectedOption = $(this).find(':selected');
                var selectedQuantity = selectedOption.data('quantity');
                var selectedPrice = selectedOption.data('price');

                $('#numberOfProduct').val(selectedQuantity);
                $('#productPrice').val(selectedPrice);

            });
        });
    </script>





    <script>
        $(document).ready(function() {
            var dollarPrice = 0; // Initialize with a default value
            var total = 0;

            // Add an event listener to update the variable when the input changes
            document.getElementById('dinar').addEventListener('input', function() {
                var total = 0;
                var shipping = parseFloat($('#shippingInput').val()) || 0;

                $('tbody tr').each(function() {
                    var price = parseFloat($(this).find('td:nth-child(6)')
                        .text());
                    total += price;
                });
                var inputValue = parseFloat(this.value);
                if (!isNaN(inputValue)) {
                    dollarPrice = inputValue;
                    total += shipping;
                    // Update the grand total when the dollar price changes
                    $('#grand-total-dinar').text((total * dollarPrice).toFixed(0).replace(
                        /\B(?=(\d{3})+(?!\d))/g, ","));
                } else {
                    $('#grand-total-dinar').text(0)
                }
            });

            function updateTotalDinar() {
                var total = 0;
                var shipping = parseFloat($('#shippingInput').val()) || 0;

                $('tbody tr').each(function() {
                    var price = parseFloat($(this).find('td:nth-child(6)')
                        .text());
                    total += price;
                });
                var inputValue = document.getElementById('dinar').value;
                if (!isNaN(inputValue)) {
                    dollarPrice = inputValue;
                    total += shipping;
                    // Update the grand total when the dollar price changes
                    $('#grand-total-dinar').text((total * dollarPrice).toFixed(0).replace(
                        /\B(?=(\d{3})+(?!\d))/g, ","));
                } else {
                    $('#grand-total-dinar').text(0)
                }
            };

            function updateTotal() {
                let quantityDisplay = document.querySelector('#quantityDisplay');
                var totalQuantity = 0;
                var total = 0;

                $('tbody tr').each(function() {
                    var price = parseFloat($(this).find('td:nth-child(6)')
                        .text()); // Assuming price is in the 5th column
                    total += price;
                });
                $('tbody tr').each(function() {
                    var quantity = parseFloat($(this).find('td:nth-child(4)')
                        .text()); // Assuming price is in the 5th column
                    totalQuantity += quantity;
                });
                quantityDisplay.textContent = totalQuantity;

                var shipping = parseFloat($('#shippingInput').val()) ||
                    0; // Get the shipping value, default to 0 if not a valid number
                var grandTotal = total + shipping;

                $('#grand-total').text('$ ' + grandTotal.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            }

            // Add event listener for the change event on the shipping input
            $('#shippingInput').on('input', function() {
                updateTotalDinar()
                updateTotal();
            });






            $('#add-item-button').click(function() {
                var productName = $('.name_select option:selected').text();
                var productId = $('.name_select option:selected').val();
                var quantity = $('.quantity[type="number"]').val();
                var NOP = $('.NOP').val();
                var price = $('.price').val();
                // var Receipt = $('.Resicpt').val();
                var selectedDate = $('.datetimepicker.Date')
                    .val(); // corrected class name and added .Date for the input field
                var Customer = $('.Customer_name option:selected').val();

                // Assuming you have a variable to keep track of the item count
                var itemCount = $('tbody tr').length + 1;



                // Check if both product and quantity are selected
                if (productName && quantity) {
                    var newRow = '<tr>' +
                        '<td>' + itemCount + '</td>' + // You can increment the item number using JavaScript
                        '<td>' +
                        '<a href="javascript:void(0);">' + productName + '</a>' +
                        '</td>' +
                        '<td style="display: none">' + productId + '</td>' +
                        '<td>' + quantity + '</td>' + '<td>' + price + '</td>' + '<td>' + (quantity * price)
                        .toFixed(2) + '</td>' + '<td>' + selectedDate + '</td>' +
                        '<td>' + Customer + '</td>' + '<td>' +
                        '<a href="javascript:void(0);" class="delete-set"><img src="assets/img/icons/delete.svg" alt="svg"></a>' +
                        '</td>' +
                        '</tr>';


                    $('tbody').append(newRow);
                    updateTotal();
                    updateTotalDinar()


                    // Clear the input fields
                    $('.name_select').val('').trigger('change');
                    $('.quantity[type="number"]').val('');
                    $('.NOP').val('');
                    $('.price').val('');

                    // ... Your existing code to add a new row ...
                }
            });
            $('tbody tr').remove(); // Example: Remove all rows
            updateTotalDinar()
            updateTotal();

            $(document).on('click', '.delete-set', function() {
                $(this).closest('tr').remove(); // Remove the row
                updateTotalDinar()
                updateTotal(); // Update the total after removing a row
            });


        });
    </script>



    <script>
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
    </script>










    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/plugins/select2/js/select2.min.js"></script>

    <script src="assets/js/feather.min.js"></script>

    <script src="assets/js/jquery.slimscroll.min.js"></script>

    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>


    <script src="assets/plugins/select2/js/select2.min.js"></script>

    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>

    <script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
    <script src="assets/plugins/sweetalert/sweetalerts.min.js"></script>

@endsection
