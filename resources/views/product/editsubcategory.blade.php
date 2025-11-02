@extends('layouts.nav')

@section('name', 'Update SubCategory')
@section('custom-css')
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">


@endsection
@section('content')


    <div class="page-wrapper page-wrapper-one">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Update SubCategory </h4>
                    <h6>Manage Your Product SubCategory</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <form action="{{ route('product.subcategory.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="id" name="id" value="{{ $subcategory->id }}">

                        <!-- --------------------------- -->
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Category 🦺</label>
                                <div class="row">
                                    <div class="col-lg-10 col-sm-10 col-12">
                                        <select name="category_id" class="select" id="categorySelects">
                                        </select>

                                    </div>
                                    <script>
                                        let currentOptions = ''; // Variable to store current options
                                        let productCategoryId = {{ $subcategory->parent_category_id ?? 'null' }}; // Product's category ID

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
                                                                                    id="nameCategory" name="nameCategory"
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
                                                                        backgroundColor: '#ff0000', // Red background color for error
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
                                                                        backgroundColor: '#ff0000', // Red background color for error
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
                                                                            text: 'Data stored successfully!!',
                                                                            duration: 2000,
                                                                            gravity: 'top-left', // Position the toast notification at the top left corner
                                                                            close: true, // Show a close button
                                                                            backgroundColor: 'linear-gradient(to right, #00b09b, #96c93d)', // Custom background color
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


                            <div class="col-lg-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="name">Subcategory Name</label>
                                    <input type="text" value="{{ $subcategory->name }}" id="name" name="name"
                                        placeholder="Entre name of Subcategory " class="form-control ">

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea value="{{ old('description') }}" id="description" name="description"
                                    placeholder="Entre description of Subcategory " class="form-control ">{{ $subcategory->description }}</textarea>


                            </div>
                        </div>



                        <div class="col-lg-12">
                            <div class="form-group">
                                <label> Subcategory Image</label>
                                <div class="image-upload image-upload-new" id="image-upload">
                                    <input type="file" name="image" class="form-control " id="profilePicture"
                                        onchange="displaySelectedImage()">

                                    <div class="image-uploads" id="image-uploads">
                                        <img src="{{ asset('assets/img/icons/upload.svg') }}" alt="img"
                                            id="selectedImage">
                                        <h4 id="h4">Drag and drop a file to upload</h4>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-12" id="pdoductviewes">
                            <div class="product-list">
                                <ul class="row">
                                    <li>
                                        <div class="productviews" style="width: 250px">
                                            <div class="productviewsimg">
                                                <img src="{{ asset('uploads/product/subcategory/' . $subcategory->subcategory_image) }}"
                                                    alt="img" id="productImage">

                                            </div>
                                            <div class="productviewscontent">
                                                <div class="productviewsname">
                                                    <h2 id="imageName">{{ $subcategory->subcategory_image }}</h2>
                                                    <h3 id="imageSize">
                                                        {{ formatBytes(filesize(public_path($subcategory->image_path))) }}
                                                    </h3>




                                                </div>
                                                <a href="javascript:void(0);" class="hidesets" id="hidesets">x</a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }} <i class='bx bx-cool'></i></div>
                        @endif

                        <div class="col-lg-12">
                            <button id="submitBtnSub" class="btn btn-submit me-2">Submit</button>
                            <a href="{{ route('product.subcategorylist') }}" class="btn btn-cancel">Cancel</a>
                        </div>
                </div>
                </form>




                <script>
                    $(document).ready(function() {
                        $('#submitBtnSub').click(function(e) {
                            e.preventDefault(); // Prevent form from submitting normally

                            // Get the value of the input field for brand name
                            var id = $('#id').val();

                            var categorySelect = $('#categorySelects').val();
                            var subName = $('#name').val();
                            var subDescription = $('#description').val();



                            if (categorySelect.trim() === '') {

                                Toastify({
                                    text: 'Parent Category is required !',
                                    duration: 3000,
                                    gravity: 'top-left', // Position the toast notification at the top left corner
                                    close: true, // Show a close button
                                    backgroundColor: '#ff0000', // Red background color for error
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
                                    backgroundColor: '#ff0000', // Red background color for error
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
                                    backgroundColor: '#ff0000', // Red background color for error
                                    className: 'toastify-custom', // Custom CSS class for styling
                                }).showToast();
                                return; // Exit function if description input is empty
                            }

                            // Get the file input element
                            var subImageInput = $('#profilePicture')[0];
                            var subImage = subImageInput.files[0];

                            // Create FormData object
                            var formData = new FormData();
                            formData.append('id', id);

                            formData.append('name', subName);
                            formData.append('categorySelect', categorySelect);

                            formData.append('description', subDescription);
                            formData.append('image', subImage);

                            // Get CSRF token value from the meta tag
                            var csrfToken = $('meta[name="csrf-token"]').attr('content');

                            // Send AJAX request
                            $.ajax({
                                url: "{{ route('product.subcategory.update') }}",
                                type: "POST",
                                data: formData,
                                processData: false, // Prevent jQuery from processing the data
                                contentType: false, // Prevent jQuery from setting content type
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
                                },
                                success: function(response) {
                                    Toastify({
                                        text: 'Subcategory Updated Successfully !',
                                        duration: 2000,
                                        gravity: 'top-left', // Position the toast notification at the top left corner
                                        close: true, // Show a close button
                                        backgroundColor: 'linear-gradient(to right, #01919C, #2B2B2B)', // Custom background color
                                        className: 'toastify-custom', // Custom CSS class for styling
                                    }).showToast();



                                    setTimeout(function() {
                                        window.location.href =
                                            '{{ route('product.subcategorylist') }}';
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

    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>
@endsection
