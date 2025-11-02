@extends('layouts.nav')

@section('name', 'Update Supplier')
@section('custom-css')

    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">

@endsection
@section('content')

    <div class="page-wrapper page-wrapper-one">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Supplier Management</h4>
                    <h6>Edit/Update Supplier</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('updatesupplier') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" id="id" name="id" value="{{ $suppliers->id }}">

                        <div class="row">

                            <div class="col-lg-4 col-sm-8 col-12">
                                <div class="form-group">

                                    <label for="supplier_name">{{ __('Supplier Name') }}</label>

                                    <input class="form-control " type="text" value="{{ $suppliers->supplier_name }}"
                                        id="supplier_name" name="supplier_name" autofocus />

                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-8 col-12">
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input class="form-control " type="email" value="{{ $suppliers->email }}" id="emailSupplier"
                                        name="email" />

                                </div>
                            </div>






                            <div class="col-lg-4 col-sm-8 col-12">
                                <div class="form-group">
                                    <label for="phone">Phone Address</label>
                                    <input class="form-control " value="{{ $suppliers->phone }}" type="text" id="phone"
                                        name="phone" placeholder="0770 111 2222" oninput="formatPhoneNumber(this)"
                                        pattern="\d{4} \d{3} \d{4}"
                                        title="Please enter a phone number in the format 0770 111 2222" />
                                </div>
                            </div>



                            <div class="col-lg-4 col-sm-8 col-12">
                                <div class="form-group">
                                    <label>City</label>
                                    <select class="form-control select " id="city"
                                        name="city">
    
                                        <option value="sulaymaniyah" {{ $suppliers->city =='sulaymaniyah' ? 'selected' : '' }}>Sulaymaniyah
                                        </option>
                                        <option value="hawler" {{ $suppliers->city =='hawler' ? 'selected' : '' }}>Hawler
                                        </option>
                                        <option value="halabja" {{ $suppliers->city =='halabja' ? 'selected' : '' }}>Halabja
                                        </option>
                                        <option value="Duhok" {{ $suppliers->city =='Duhok' ? 'selected' : '' }}>Duhok
                                        </option>
    
    
                                    </select>
                     
                                </div>
    
                            </div>
    
    

                          
                        <div class="col-lg-4 col-sm-8 col-12">
                            <div class="form-group">

                                <label for="district">District</label>

                                <input class="form-control " type="text"
                                    value="{{ $suppliers->district }}" id="district" name="district" autofocus />
                             
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-8 col-12">
                            <div class="form-group">

                                <label for="address">Address</label>

                                <input class="form-control" type="text"
                                    value="{{ $suppliers->address }}" id="address" name="address" autofocus />
                              

                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="descriptionSupplier" name="description"
                                    class="form-control ">{{ $suppliers->description }}</textarea>
                               

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
                                                <img src="{{ asset('uploads/suppliers/' . $suppliers->avatar) }}"
                                                    alt="img" id="productImage">

                                            </div>
                                            <div class="productviewscontent">
                                                <div class="productviewsname">
                                                    <h2 id="imageName">{{ $suppliers->avatar }}</h2>
                                                    <h3 id="imageSize">
                                                        {{ formatBytes(filesize(public_path($suppliers->image_path))) }}
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
                                <button id="submitBtn-supplier" class="btn btn-submit me-2">Submit</button>
                                <a href="{{ route('supplierlist.page') }}" class="btn btn-cancel">Cancel</a>
                            </div>
                    </form>
                    <script>
                        $(document).ready(function() {
                            $('#submitBtn-supplier').click(function(e) {
                                e.preventDefault();
                                var id = $('#id').val();

                                var SupplierName = $('#supplier_name').val();
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
                                var SupplierImageInput = $('#profilePicture')[0];
                                var SupplierImage = SupplierImageInput.files[0];





                                // Create FormData object
                                var formData = new FormData();
                                formData.append('id', id);
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


                                            // Send AJAX request
                                            $.ajax({
                                                url: "{{ route('updatesupplier') }}",
                                                type: "POST",
                                                data: formData,
                                                processData: false,
                                                contentType: false,
                                                headers: {
                                                    'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
                                                },
                                                success: function(response) {
                                                    Toastify({
                                        text: 'Supplier Updated Successfully !',
                                        duration: 2000,
                                        gravity: 'top-left', // Position the toast notification at the top left corner
                                        close: true, // Show a close button
                                        backgroundColor: 'linear-gradient(to right, #01919C, #2B2B2B)', // Custom background color
                                        className: 'toastify-custom', // Custom CSS class for styling
                                    }).showToast();



                                    setTimeout(function() {
                                        window.location.href =
                                            '{{ route('supplierlist.page') }}';
                                    }, 2000);
                                                },
                                                error: function(xhr, status, error) {
                                                    console.error(xhr.responseText);


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
