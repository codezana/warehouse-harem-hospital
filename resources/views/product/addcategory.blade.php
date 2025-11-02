@extends('layouts.nav')

@section('name', 'Add Category')
@section('custom-css')
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

 
@endsection
@section('content')


    <div class="page-wrapper page-wrapper-one">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Product Add Category</h4>
                    <h6>Create new product Category</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="name">Category Name</label>
                                    <input type="text" value="{{ old('name') }}" id="nameCategory" name="name"
                                        class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea value="{{ old('description') }}" id="descriptionCategory" name="description"
                                        placeholder="Entre description Of Category " class="form-control @error('description') is-invalid @enderror"></textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                            </div>




                            <div class="col-lg-12">
                                <button id="submitBtnCategory" class="btn btn-submit me-2">Submit</button>
                                <a href="{{ route('product.categorylist') }}" class="btn btn-cancel">Cancel</a>
                            </div>
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
                                    url: "{{ route('category.store') }}",
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


@endsection
@section('custom-js')


    {{-- display image while add
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
    </script> --}}


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

    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"
        integrity="sha512-GWzVrcGlo0TxTRvz9ttioyYJ+Wwk9Ck0G81D+eO63BaqHaJ3YZX9wuqjwgfcV/MrB2PhaVX9DkYVhbFpStnqpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>
@endsection
