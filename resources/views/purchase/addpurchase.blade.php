@extends('layouts.nav')

@section('name', 'Add Purchase')
@section('custom-css')
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/harem.png') }}">

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
            text-align: center !important;
        }
    </style>


    <div class="page-wrapper page-wrapper-one">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Purchase Add</h4>
                    <h6>Add/Update Purchase</h6>
                </div>
            </div>
            <div class="card">
                <div class="card-body carding">

                    <div class="row">
                        <!-- --------------------------- -->
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
                                                                            text: 'Product stored successfully !',
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
                                <label>Purchase Date </label>
                                <div class="input-groupicon">
                                    <input type="text" placeholder="DD-MM-YYYY" class="datetimepicker"
                                        id="purchaseDate">
                                    <div class="addonset">
                                        <img src="assets/img/icons/calendars.svg" alt="img">
                                    </div>
                                </div>
                            </div>
                        </div>









                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Supplier Name 🚛 </label>
                                <div class="row">
                                    <div class="col-lg-10 col-sm-10 col-10">
                                        <select id="SupplierSelect" class="Supplier_name select2 form-control"
                                            name="Supplier_id">

                                        </select>


                                    </div>

                                    <script>
                                        let currentOptionsModel = '';

                                        function updateSupplierModel() {
                                            fetch('{{ route('SupplierModel.fetch') }}')
                                                .then(response => response.json())
                                                .then(data => {
                                                    const newOptions = data.SupplierOptions;
                                                    // Check if the new options are different from the current options
                                                    if (newOptions !== currentOptionsModel) {
                                                        // Update the select element with new options
                                                        document.getElementById('SupplierSelect').innerHTML = newOptions;
                                                        // Update the current options
                                                        currentOptionsModel = newOptions;
                                                    }
                                                })
                                                .catch(error => console.error('Error fetching Supplier:', error));
                                        }

                                        // Update categories every 4 seconds (4000 milliseconds)
                                        setInterval(updateSupplierModel, 4000);

                                        // Initial call to update on page load
                                        updateSupplierModel();
                                    </script>
                                    <div class="col-lg-2 col-sm-2 col-2 ps-0" class="btn btn-primary"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal1">
                                        <div class="add-icon">
                                            <span><img src="assets/img/icons/plus1.svg" alt="img"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal1" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Supplier Form 🚛</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"><i class="fa-regular fa-circle-xmark"></i></button>
                                        </div>
                                        <form id="form-data" method="POST" action="{{ route('Supplier.model') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="card">
                                                    <div class="card-body">


                                                        <div class="row">

                                                            <div class="col-lg-6 col-sm-12 col-12">
                                                                <div class="form-group">

                                                                    <label
                                                                        for="Supplier_name">{{ __('Supplier Name') }}</label>

                                                                    <input
                                                                        class="form-control @error('Supplier_name') is-invalid @enderror"
                                                                        type="text" value="{{ old('Supplier_name') }}"
                                                                        id="Supplier_name" name="Supplier_name"
                                                                        autofocus />
                                                                    @error('Supplier_name')
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
                                                                        id="emailSupplier" name="email"
                                                                        placeholder="Supplier@example.com" required>
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
                                                                    <textarea id="descriptionSupplier" name="description"
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
                                                                    <label> Supplier Image</label>
                                                                    <div class="image-upload image-upload-new"
                                                                        id="image-upload">
                                                                        <input type="file" name="image"
                                                                            class="form-control @error('image') is-invalid @enderror"
                                                                            id="SupplierProfilePicture"
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
                                                        id="submitBtn-supplier">Submit</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>

                                                </div>
                                            </div>
                                        </form>
                                        <script>
                                            $(document).ready(function() {
                                                $('#submitBtn-supplier').click(function(e) {
                                                    e.preventDefault();

                                                    var SupplierName = $('#Supplier_name').val();
                                                    if (SupplierName.trim() === '') {

                                                        Toastify({
                                                            text: ' Supplier Name is required!',
                                                            duration: 3000,
                                                            gravity: 'top-left',
                                                            close: true,
                                                            backgroundColor: '#ff0000',
                                                            className: 'toastify-custom',
                                                        }).showToast();
                                                        return;
                                                    }

                                                    // Get the value of the email input
                                                    var Supplieremail = $('#emailSupplier').val();

                                                    // Validate the email format using a regular expression
                                                    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                                                    if (!emailRegex.test(Supplieremail)) {
                                                        // If the email format is invalid, display an error message and return
                                                        $('#emailSupplier').addClass('is-invalid');
                                                        Toastify({
                                                            text: ' Please enter a valid email address.',
                                                            duration: 3000,
                                                            gravity: 'top-left',
                                                            close: true,
                                                            backgroundColor: '#ff0000',
                                                            className: 'toastify-custom',
                                                        }).showToast();
                                                        return;
                                                    } else {
                                                        // If the email format is valid, remove any existing error message and continue
                                                        $('#emailSupplier').removeClass('is-invalid');
                                                        $('#emailError').text('');
                                                    }

                                                    // Get the value of the phone input
                                                    var Supplierphone = $('#phone').val();

                                                    // Remove any non-digit characters from the input
                                                    var phoneDigits = Supplierphone.replace(/\D/g, '');

                                                    // Check if the remaining digits match the format of exactly seven digits
                                                    if (phoneDigits.length !== 11 || !/^\d{11}$/.test(phoneDigits)) {
                                                        // If the input does not match the expected format, display an error message
                                                        $('#phone').addClass('is-invalid');

                                                        Toastify({
                                                            text: ' Please enter a phone number with exactly seven digits.',
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

                                                    var Suppliercity = $('#city').val();
                                                    var Supplierdistrict = $('#district').val();
                                                    var Supplieraddress = $('#address').val();
                                                    var SupplierDescription = $('#descriptionSupplier').val();

                                                    if (Suppliercity.trim() === '') {

                                                        Toastify({
                                                            text: ' Supplier city is required!',
                                                            duration: 3000,
                                                            gravity: 'top-left',
                                                            close: true,
                                                            backgroundColor: '#ff0000',
                                                            className: 'toastify-custom',
                                                        }).showToast();
                                                        return;
                                                    }
                                                    if (Supplierdistrict.trim() === '') {

                                                        Toastify({
                                                            text: ' Supplier District is required!',
                                                            duration: 3000,
                                                            gravity: 'top-left',
                                                            close: true,
                                                            backgroundColor: '#ff0000',
                                                            className: 'toastify-custom',
                                                        }).showToast();
                                                        return;
                                                    }
                                                    if (Supplieraddress.trim() === '') {

                                                        Toastify({
                                                            text: ' Supplier Address is required!',
                                                            duration: 3000,
                                                            gravity: 'top-left',
                                                            close: true,
                                                            backgroundColor: '#ff0000',
                                                            className: 'toastify-custom',
                                                        }).showToast();
                                                        return;
                                                    }
                                                    if (SupplierDescription.trim() === '') {

                                                        Toastify({
                                                            text: ' Supplier Description is required!',
                                                            duration: 3000,
                                                            gravity: 'top-left',
                                                            close: true,
                                                            backgroundColor: '#ff0000',
                                                            className: 'toastify-custom',
                                                        }).showToast();
                                                        return;
                                                    }
                                                    // Get the file input element
                                                    var SupplierImageInput = $('#SupplierProfilePicture')[0];
                                                    var SupplierImage = SupplierImageInput.files[0];





                                                    // Create FormData object
                                                    var formData = new FormData();
                                                    formData.append('name', SupplierName);
                                                    formData.append('email', Supplieremail);
                                                    formData.append('phone', Supplierphone);
                                                    formData.append('city', Suppliercity);
                                                    formData.append('district', Supplierdistrict);
                                                    formData.append('address', Supplieraddress);
                                                    formData.append('description', SupplierDescription);
                                                    formData.append('image', SupplierImage);
                                                    // Get CSRF token value from the meta tag
                                                    var csrfToken = $('meta[name="csrf-token"]').attr('content');



                                                    // Check if the email already exists in the database
                                                    $.ajax({
                                                        url: "{{ route('checkEmailExistence') }}", // Replace with your route for checking email existence
                                                        type: "POST",
                                                        data: {
                                                            email: Supplieremail
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
                                                                    url: "{{ route('Supplier.model') }}",
                                                                    type: "POST",
                                                                    data: formData,
                                                                    processData: false,
                                                                    contentType: false,
                                                                    headers: {
                                                                        'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
                                                                    },
                                                                    success: function(response) {
                                                                        Toastify({
                                                                            text: 'Supplier stored successfully !',
                                                                            duration: 2000,
                                                                            gravity: 'top-left', // Position the toast notification at the top left corner
                                                                            close: true, // Show a close button
                                                                            backgroundColor: 'linear-gradient(to right, #118251, #16342a)', // Custom background color
                                                                            className: 'toastify-custom', // Custom CSS class for styling
                                                                        }).showToast();

                                                                        // Reset input fields after successful submission
                                                                        $('#Supplier_name').val('');
                                                                        $('#emailSupplier').val('');
                                                                        $('#phone').val('');
                                                                        $('#city').val('');
                                                                        $('#district').val('');
                                                                        $('#address').val('');
                                                                        $('#descriptionSupplier').val('');
                                                                        $('#SupplierProfilePicture').val('');
                                                                    },
                                                                    error: function(xhr, status, error) {
                                                                        console.error(xhr.responseText);


                                                                    }
                                                                });
                                                            }
                                                        },
                                                        error: function(xhr, status, error) {
                                                            console.error(xhr.responseText);
                                                            // Handle error response
                                                        }
                                                    });

                                                });
                                            });
                                        </script>












                                    </div>
                                </div>

                            </div>
                        </div>








                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Reference No.</label>
                                <input type="text" id="Reference">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="number" id="quantitypur">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" id="pricepur">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Sale</label>
                                <input type="number" id="salepur">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Expire Date </label>
                                <div class="input-groupicon">
                                    <input type="text" placeholder="DD-MM-YYYY" class="datetimepicker"
                                        id="ExpireDate">
                                    <div class="addonset">
                                        <img src="assets/img/icons/calendars.svg" alt="img">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-12 col-12"
                            style="display: flex; justify-content: end; align-items: center; margin-bottom: 10px">
                            <button class="btn btn-primary" onclick="addItem()">Add Item</button>
                        </div>

                    </div>
                    

                    <form action="{{ route('purchase.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="table-responsive">
                                <table class="table" id="itemTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Product Name</th>
                                            <th>QTY</th>
                                            <th>Purchase Price($) </th>
                                            <th>Sale Price($) </th>
                                            <th>Reference</th>
                                            <th>Date</th>
                                            <th>Expire Date</th>
                                            <th>Supplier</th>
                                            <th>Total Cost ($) </th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 5%;">

                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Paid</label>
                                    <input type="number" id="paid">
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Discount</label>
                                    <input type="number" id="discount">
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Shipping</label>
                                    <input type="number" id="shipping">
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select id="status" class="select">
                                        <option>Choose Status</option>
                                        <option>Completed</option>
                                        <option>Inprogress</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- total-order summary goes here -->
                        <div class="row">
                            <div class="col-lg-6 float-md-right">
                                <div class="col-lg-6 total-order w-100 max-widthauto m-auto mb-4">
                                    <ul>
                                        <li>
                                            <h4>Dollar Price </h4>
                                            <div style="width: 50%"><input style="text-align: right;border:none;"
                                                    id="dollarPrice" type="number" placeholder="0"></input></div>
                                        </li>
                                        <li>
                                            <h4>Paid Dinar</h4>
                                            <h5 id="paidDinar">0</h5>
                                        </li>
                                        <li class="total">
                                            <h4>Grand Total Dinar</h4>
                                            <h5 id="grandTotalDinar">0</h5>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6 float-md-right">

                                <div class="col-lg-6 total-order w-100 max-widthauto m-auto mb-4">
                                    <ul>
                                        <li>
                                            <h4>Paid </h4>
                                            <h5 id="paidSummary">$ 0.00</h5>
                                        </li>
                                        <li>
                                            <h4>Quantity</h4>
                                            <h5 id="quantitySummary">0</h5>
                                        </li>
                                        <li class="total">
                                            <h4>Grand Total</h4>
                                            <h5 id="grandTotal">$ 0.00</h5>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div style="display: none" class="col-lg-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="descriptions" name="description" class="form-control @error('description') is-invalid @enderror"></textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button id="submit-button" class="btn btn-submit me-2">Submit</button>
                            <a href="{{ route('purchaselistpage') }}" class="btn btn-cancel">Cancel</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#submit-button').click(function(event) {
            event.preventDefault();

            var tableData = [];

            $('#itemTable tbody tr').each(function() {
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


                //expire date
                var expireDateText = $(this).find('td:nth-child(8)').text().trim();
                var parts = expireDateText.split('-');
                var expire_date = null;

                // Check if expireDateText is not empty and has three parts
                if (expireDateText && parts.length === 3) {
                    // Construct a new date string in YYYY-MM-DD format
                    expire_date = parts[2] + '-' + parts[1] + '-' + parts[0];

                    // Check if the constructed date string is valid
                    var parsedDate = new Date(expire_date);
                    if (isNaN(parsedDate.getTime())) {
                        console.error('Invalid expire_date :', expireDateText);
                        expire_date = null; // Reset date to null if it's invalid
                    }
                } else {
                    console.error('Invalid expire_date format:', expireDateText);
                }
                var rowData = {
                    product_name: $(this).find('td:nth-child(2)').text(),
                    quantity: $(this).find('td:nth-child(3)').text(),
                    purchase_price: $(this).find('td:nth-child(4)').text(),
                    sale_price: $(this).find('td:nth-child(5)').text(),
                    reference: $(this).find('td:nth-child(6)').text(),
                    date: date,
                    expire_date: expire_date,
                    supplier_name: $(this).find('td:nth-child(9)').text(),
                    total_cost: $(this).find('td:nth-child(10)').text().replace(/,/g, ''),
                };

                tableData.push(rowData);
            });


            var shippingTotal = document.getElementById("shipping").value;
            var grandTotalText = $('#grandTotal').text().replace(/[$,]/g, '');
            var grandTotal = parseFloat(grandTotalText);


            var paid = document.getElementById("paid").value;
            var grand_dinarText = $('#grandTotalDinar').text().replace(/[$,]/g, '');
            var grand_dinar = parseFloat(grand_dinarText);
            var paid_dinar = $('#paidDinar').text().replace(/[$,]/g, '');
            var paid_dinar = parseFloat(paid_dinar);
            var dolar = $('#dollarPrice').val();



            var discountTotal = document.getElementById("discount").value;

            discountTotal = isNaN(discountTotal) ? 0 : discountTotal;
            shippingTotal = isNaN(shippingTotal) ? 0 : shippingTotal;
            grandTotal = isNaN(grandTotal) ? 0 : grandTotal;
            paid = isNaN(paid) ? 0 : paid;
            grand_dinar = isNaN(grand_dinar) ? 0 : grand_dinar;
            paid_dinar = isNaN(paid_dinar) ? 0 : paid_dinar;


            var status = $('#status').val();


            $.ajax({
                type: 'POST',
                url: '{{ route('purchase.store') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    discountTotal: discountTotal,
                    shippingTotal: shippingTotal,
                    grandTotal: grandTotal,
                    paid: paid,
                    dolar: dolar,
                    grand_dinar: grand_dinar,
                    paid_dinar: paid_dinar,
                    status: status,
                    tableData: tableData,
                },
                success: function(response) {
                    Toastify({
                        text: 'Purchase stored successfully !',
                        duration: 2000,
                        gravity: 'top-left', // Position the toast notification at the top left corner
                        close: true, // Show a close button
                        backgroundColor: 'linear-gradient(to right, #118251, #16342a)', // Custom background color
                        className: 'toastify-custom', // Custom CSS class for styling
                    }).showToast();

                    // Refresh the page after a delay
                    setTimeout(function() {
                        window.location.reload();
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

            $('#itemTable tbody').empty();
        });
    });
</script>



<script>
    // Initialize item ID
    var itemId = 1;

    function addItem() {
        // Get values from form fields
        var productName = document.querySelector('#productselect').value;
        var qty = document.querySelector('#quantitypur').value;
        var purchasePrice = document.querySelector('#pricepur').value;
        var salePrice = document.querySelector('#salepur').value;
        var Reference = document.querySelector('#Reference')
            .value; // You can add logic to get the discount value if needed
        var purchaseDate = document.querySelector('#purchaseDate').value;
        var ExpireDate = document.querySelector('#ExpireDate').value;
        var supplier = document.querySelector('#SupplierSelect').value;

        // Calculate total cost
        var totalCost = calculateTotalCost(qty, purchasePrice);

        // Create a new table row
        var newRow = document.createElement('tr');
        newRow.innerHTML = `
        <td id="itemId-${itemId}">${itemId}</td>
        <td>${productName}</td>
        <td class="quantity">${qty}</td>
        <td class="purchase">${purchasePrice}</td>
        <td>${salePrice}</td>
        <td>${Reference }</td>
        <td>${purchaseDate}</td>
        <td>${ExpireDate}</td>
        <td>${supplier}</td>
        <td class="total-cost">${totalCost.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
        <td>
            <a onclick="deleteRow(this)" class="delete-set"><img src="assets/img/icons/delete.svg" alt="svg"></a>
        </td>
    `;

        // Append the new row to the table
        document.querySelector('#itemTable tbody').appendChild(newRow);

        // Increment item ID for the next item
        itemId++;
        // Clear form fields after adding an item
        document.querySelector('#productselect').value = '';
        document.querySelector('#quantity').value = '';
        document.querySelector('#price').value = '';
        document.querySelector('#sale').value = '';
        document.querySelector('#ExpireDate').value = '';
        // document.querySelector('#supplier').value = 'Select';
        calculateTotalCostFromItems();
    }


    function calculateTotalCostFromItems() {
        // Calculate total cost from the items in the table
        let totalCost = 0;
        let total = document.querySelector('#grandTotal');
        let tableRows = document.querySelectorAll('#itemTable tbody tr .total-cost');
        // var discount = document.getElementById('discount').value || 0;
        // var shipping = document.getElementById('shipping').value || 0;

        tableRows.forEach(function(row) {
            totalCost += parseFloat(row.textContent.replace(/,/g, '')); // Convert string to number
        });
        total.textContent = '$ ' + ((totalCost) || 0).toFixed(2);

    }



    function deleteRow(element) {
        // Delete the corresponding row when the delete button is clicked
        var row = element.closest('tr');
        row.remove();

        // Update totals after deleting a row
        calculateTotalCostFromItems()
    }

    function calculateTotalCost(qty, purchasePrice) {
        // Perform any calculations here
        // For example, calculate total cost based on quantity, purchase price, and discount
        // You can customize this calculation based on your requirements
        return (qty * purchasePrice);
    }
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


<script>
    document.addEventListener('DOMContentLoaded', () => {
        function updatePaidSummary() {
            let paidText = document.getElementById('paidSummary');
            let paid = document.getElementById('paid');
            paid.addEventListener('input', (e) => {
                paidText.textContent = '$ ' + paid.value;
            });
        }

        // function updateTotalWithDiscount() {
        //     var discount = document.getElementById('discount');
        //     var totalText = document.querySelector('#grandTotal');

        //     discount.addEventListener('input', () => {
        //         calculateTotalCostFromItems();
        //         let total = parseFloat($('#grandTotal').text().replace(/[$,]/g, '') || 0);
        //         total = ((1 - (discount.value / 100)) * total);
        //         totalText.textContent = '$ ' + parseFloat(total).toFixed(2);
        //         if (discount.value <= 0) {
        //             calculateTotalCostFromItems();
        //         }
        //     });
        // }

        function updateTotalWithShipping() {
            var shipping = document.getElementById('shipping');
            var totalText = document.querySelector('#grandTotal');

            shipping.addEventListener('input', () => {
                calculateTotalCostFromItems();
                let total = parseFloat($('#grandTotal').text().replace(/[$,]/g, '') || 0);
                total += parseFloat(shipping.value);
                totalText.textContent = '$ ' + total.toFixed(2);
                if (shipping.value <= 0) {
                    calculateTotalCostFromItems();
                }
            });
        }

        let total = $('#grandTotal').text().replace(/[$,]/g, '') || 0;

        updatePaidSummary();
        // updateTotalWithDiscount();
        updateTotalWithShipping();



        let dollarPrice = document.getElementById('dollarPrice');
        let paidDinar = document.getElementById('paidDinar');
        let paidDollar = document.getElementById('paidSummary');
        let GrandTotalDinar = document.getElementById('grandTotalDinar');

        dollarPrice.addEventListener('input', () => {
            dollarText = dollarPrice.value;
            let total = $('#grandTotal').text().replace(/[$,]/g, '') || 0;
            paidDinar.textContent = dollarPrice.value * parseFloat(paidDollar.textContent.replace(
                /[$]/g, ''));
            GrandTotalDinar.textContent = dollarPrice.value * parseFloat(total);
        })








        // function updateTotals() {
        //     // Calculate grand total
        //     var grandTotal = calculateGrandTotal(discount, shipping);
        //     document.getElementById('grandTotal').textContent = '$ ' + grandTotal.toFixed(2).replace(
        //         /\B(?=(\d{3})+(?!\d))/g, ",");
        // }
    })
</script>

@section('custom-js')
<script src="assets/js/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script src="assets/plugins/select2/js/select2.min.js"></script>

    <script src="assets/js/feather.min.js"></script>

    <script src="assets/js/jquery.slimscroll.min.js"></script>

    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>

    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script src="assets/plugins/select2/js/select2.min.js"></script>

    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>

    <script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
    <script src="assets/plugins/sweetalert/sweetalerts.min.js"></script>
    <script src="assets/plugins/select2/js/select2.min.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>

    <script>
        // Apply select2 plugin to elements with class 'select2'
        $('.select2').select2();
    </script>



@endsection
