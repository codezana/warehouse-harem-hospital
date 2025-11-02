@extends('layouts.nav')

@section('name', 'Add Customer')
@section('custom-css')
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">

@endsection
@section('content')


<div class="page-wrapper page-wrapper-one">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Customer Management</h4>
                <h6>Add/Update Customer</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
    
                    <form id="form-data" method="POST" action="{{ route('addcustomer.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="col-lg-4 col-sm-8 col-12">
                            <div class="form-group">

                                <label for="customer_name">Customer Name</label>

                                <input class="form-control type="text"
                                    value="{{ old('customer_name') }}" id="customer_name" name="customer_name"
                                    autofocus />
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-8 col-12">
                            <div class="form-group">
                                <label for="emailCustomer">Email Address</label>
                                <input class="form-control" type="email"
                                    value="{{ old('emailCustomer') }}" id="emailCustomer" name="emailCustomer"
                                    placeholder="Customer@example.com" />
                              
                            </div>
                        </div>






                        <div class="col-lg-4 col-sm-8 col-12">
                            <div class="form-group">
                                <label for="phone">Phone Address</label>
                                <input class="form-control "
                                    value="{{ old('phone') }}" type="text" id="phone" name="phone"
                                    placeholder="0770 111 2222" oninput="formatPhoneNumber(this)"
                                    pattern="\d{4} \d{3} \d{4}"
                                    title="Please enter a phone number in the format 0770 111 2222" />
                            </div>
                        </div>



                        <div class="col-lg-4 col-sm-8 col-12">
                            <div class="form-group">
                                <label>City</label>
                                <select class="form-control select " id="city"
                                    name="city">
                                    <option value="sulaymaniyah">Sulaymaniyah
                                    </option>
                                    <option value="hawler">Hawler
                                    </option>
                                    <option value="halabja">Halabja
                                    </option>
                                    <option value="Duhok">Duhok
                                    </option>


                                </select>
                 
                            </div>

                        </div>




                        <div class="col-lg-4 col-sm-8 col-12">
                            <div class="form-group">

                                <label for="district">District</label>

                                <input class="form-control @error('district') is-invalid @enderror" type="text"
                                    value="{{ old('district') }}" id="district" name="district" autofocus />
                                @error('district')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-8 col-12">
                            <div class="form-group">

                                <label for="address">Address</label>

                                <input class="form-control @error('address') is-invalid @enderror" type="text"
                                    value="{{ old('address') }}" id="address" name="address" autofocus />
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
                        <div class="col-12">
                            <div class="form-group">
                                <label> Avatar</label>
                                <div class="image-upload image-upload-new" id="image-upload">
                                    <input type="file" name="file" id="profilePicture" accept="image/*"
                                        onchange="displaySelectedImage()">
                                    <div class="image-uploads" id="image-uploads">
                                        <img src="assets/img/icons/upload.svg" alt="img" id="selectedImage">
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
                                                <img src="assets/img/icons/macboocck.svg" alt="img" id="productImage">
                                            </div>
                                            <div class="productviewscontent">
                                                <div class="productviewsname">
                                                    <h2 id="imageName">macbookpro.jpg</h2>
                                                    <h3 id="imageSize">581kb</h3>
                                                </div>
                                                <a href="javascript:void(0);" class="hidesets" id="hidesets">x</a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button id="submitBtnCustomer" class="btn btn-submit me-2">Submit</button>
                            <a href="{{ route('customerlist.page') }}" class="btn btn-cancel">Cancel</a>
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
                            var CustomerImageInput = $('#profilePicture')[0];
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
                                            url: "{{ route('addcustomer.store') }}",
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
                                                $('#profilePicture').val('');
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
</div>

@endsection
@section('custom-js')
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
                    let displayName = fileName.length > 15 ? fileName.substring(0, 10) + "...  " + fileName.substr(-4 , 4) : fileName;

                    productImage.src = imageSrc; // Set the image source
                    document.getElementById("imageName").textContent = displayName; // Set the file name in an HTML element
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


        productImage.onerror = function () {
    // If there is an error loading the image (e.g., it doesn't exist)
    productviewsdiv.style.display = 'none';
};


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

@endsection