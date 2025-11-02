@extends('layouts.nav')

@section('name', 'Update Category')
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
                <h4>Product Update Category</h4>
                <h6>Manage Your Product Category</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('product.category.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id" name="id" value="{{ $category->id }}">

                    <div class="row">
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="name">Category Name</label>
                                <input type="text" value="{{ $category->name }}" id="nameCategory" name="name"
                                    class="form-control ">

                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="descriptionCategory" name="description"
                                    placeholder="Entre description Of Category "
                                    class="form-control @error('description') is-invalid @enderror">{{ $category->description }}</textarea>


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

var id=$('#id').val();
                                // Get CSRF token value from the meta tag
                                var csrfToken = $('meta[name="csrf-token"]').attr('content');


                                var formData = new FormData();
                                formData.append('id', id);
                                formData.append('name', inputValue);
                                formData.append('description', inputDesc);
                                // Send AJAX request
                                $.ajax({
                                    url: "{{ route('product.category.update') }}",
                                    type: "POST",
                                    data: formData,
                                    contentType: false,
                                    processData: false, // Ensure this is set to false to prevent jQuery from automatically processing the data
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
                                    },
                                    success: function(response) {
                                        Toastify({
                                            text: 'Category Updated Successfully !',
                                            duration: 2000,
                                            gravity: 'top-left', // Position the toast notification at the top left corner
                                            close: true, // Show a close button
                                            backgroundColor: 'linear-gradient(to right, #01919C, #2B2B2B)', // Custom background color
                                            className: 'toastify-custom', // Custom CSS class for styling
                                        }).showToast();
                                        setTimeout(function() {
                                            window.location.href =
                                            '{{ route('product.categorylist') }}';
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