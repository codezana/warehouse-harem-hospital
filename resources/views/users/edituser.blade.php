@extends('layouts.nav')

@section('name', 'Update Users - Admin')
@section('custom-css')
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="assets/plugins/scrollbar/scroll.min.css">
    <link rel="stylesheet" href="assets/plugins/alertify/alertify.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <style>
        .hover-effect:hover {
            background-color: transparent;
            width: calc(max-content + 10px);


        }
    </style>
@endsection
@section('content')


    <div class="page-wrapper page-wrapper-one">
        <div class="content">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('UpdateUser') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="id" name="id" value="{{ $user->id }}">

                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">

                                    <label for="username">{{ __('User Name') }}</label>

                                    <input class="form-control " type="text" value="{{ $user->username }}" id="username"
                                        name="username" placeholder="Username" autofocus />

                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input class="form-control" type="text" value="{{ $user->email }}" id="email"
                                        name="email" placeholder="someone@example.com" />

                                </div>
                            </div>






                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="phone">Phone Address</label>
                                    <input class="form-control " value="{{ $user->phone }}" type="text" id="phone"
                                        name="phone" placeholder="0770 111 2222" oninput="formatPhoneNumber(this)"
                                        pattern="\d{4} \d{3} \d{4}"
                                        title="Please enter a phone number in the format 0770 111 2222" />

                                </div>
                            </div>


                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="form-control select @error('roles') is-invalid @enderror" id="roles"
                                        name="roles[]">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ $user->roles->contains($role->id) ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('roles')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <div class="pass-group">
                                        <input type="password" class=" pass-input form-control " id="password"
                                            name="password" required autocomplete="new-password">
                                        <span class="fas toggle-password fa-eye-slash"></span>


                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="password-confirm">Confirm Password</label>
                                    <div class="pass-group">
                                        <input type="password" required id="password-confirm"
                                            class=" pass-input form-control " name="password_confirmation"
                                            autocomplete="new-password">
                                        <span class="fas toggle-password fa-eye-slash"></span>


                                    </div>
                                </div>
                            </div>



                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label> Product Image</label>
                                    <div class="image-upload image-upload-new" id="image-upload">
                                        <input type="file" name="image"
                                            class="form-control @error('image') is-invalid @enderror" id="profilePicture"
                                            onchange="displaySelectedImage()">

                                        <div class="image-uploads" id="image-uploads">
                                            <img src="{{ asset('assets/img/icons/upload.svg') }}" alt="img"
                                                id="selectedImage">
                                            <h4 id="h4">Drag and drop a file to upload</h4>
                                        </div>
                                        @error('image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-12" id="pdoductviewes">
                                <div class="product-list">
                                    <ul class="row">
                                        <li>
                                            <div class="productviews" style="width: 250px">
                                                <div class="productviewsimg">
                                                    <img src="{{ asset('uploads/users/' . $user->file) }}" alt="img"
                                                        id="productImage">

                                                </div>
                                                <div class="productviewscontent">
                                                    <div class="productviewsname">
                                                        <h2 id="imageName">{{ $user->file }}</h2>
                                                        <h3 id="imageSize">
                                                            {{ formatBytes(filesize(public_path($user->image_path))) }}
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
                                <button id="submitUser" class="btn btn-submit me-2">Submit</button>
                                <a href="{{ route('userlists') }}" class="btn btn-cancel">Cancel</a>
                            </div>
                        </div>
                    </form>

                    <script>
                        $(document).ready(function() {
                            $('#submitUser').click(function(e) {
                                e.preventDefault();
var id=$('#id').val();
                                var username = $('#username').val();
                                if (username.trim() === '') {

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
                                var email = $('#email').val();

                                // Validate the email format using a regular expression
                                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                                if (!emailRegex.test(email)) {
                                    // If the email format is invalid, display an error message and return
                                    $('#email').addClass('is-invalid');

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
                                    $('#email').removeClass('is-invalid');
                                    $('#emailError').text('');
                                }

                                // Get the value of the phone input
                                var userphone = $('#phone').val();

                                // Remove any non-digit characters from the input
                                var phoneDigits = userphone.replace(/\D/g, '');

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
                                var roles = $('#roles').val();
                                var password = $('#password').val();
                                var passwordConfirm = $('#password-confirm').val();

                                if (roles.trim() === '') {

                                    Toastify({
                                        text: ' Role is required!',
                                        duration: 3000,
                                        gravity: 'top-left',
                                        close: true,
                                        backgroundColor: '#ff0000',
                                        className: 'toastify-custom',
                                    }).showToast();
                                    return;
                                }
                                if (password.trim() === '') {

                                    Toastify({
                                        text: ' Password is required!',
                                        duration: 3000,
                                        gravity: 'top-left',
                                        close: true,
                                        backgroundColor: '#ff0000',
                                        className: 'toastify-custom',
                                    }).showToast();
                                    return;
                                }
                                if (passwordConfirm.trim() === '') {

                                    Toastify({
                                        text: ' Password Confirm is required!',
                                        duration: 3000,
                                        gravity: 'top-left',
                                        close: true,
                                        backgroundColor: '#ff0000',
                                        className: 'toastify-custom',
                                    }).showToast();
                                    return;
                                }
                                // Check if passwords match
                                if (password.trim() !== passwordConfirm.trim()) {
                                    Toastify({
                                        text: 'Passwords do not match!',
                                        duration: 3000,
                                        gravity: 'top-left',
                                        close: true,
                                        backgroundColor: 'linear-gradient(to right, #01919C, #2B2B2B)', // Custom background color
                                        className: 'toastify-custom',
                                    }).showToast();
                                    return;
                                }


                                // Get the file input element
                                var UserImageInput = $('#profilePicture')[0];
                                var UserImage = UserImageInput.files[0];



                                // Create FormData object
                                var formData = new FormData();
                                formData.append('id', id);
                                formData.append('name', username);
                                formData.append('email', email);
                                formData.append('phone', userphone);
                                formData.append('roles', roles);
                                formData.append('password', password);
                                formData.append('image', UserImage);
                                // Get CSRF token value from the meta tag
                                var csrfToken = $('meta[name="csrf-token"]').attr('content');



                                // Send AJAX request
                                $.ajax({
                                    url: "{{ route('UpdateUser') }}",
                                    type: "POST",
                                    data: formData,
                                    processData: false, // Prevent jQuery from processing the data
                                    contentType: false, // Prevent jQuery from setting content type
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
                                    },
                                    success: function(response) {
                                        Toastify({
                                            text: 'User Updated Successfully !',
                                            duration: 2000,
                                            gravity: 'top-left', // Position the toast notification at the top left corner
                                            close: true, // Show a close button
                                            backgroundColor: 'linear-gradient(to right, #01919C, #2B2B2B)', // Custom background color
                                            className: 'toastify-custom', // Custom CSS class for styling
                                        }).showToast();



                                        setTimeout(function() {
                                            window.location.href =
                                                '{{ route('userlists') }}';
                                        }, 2000);

                                    },
                                    error: function(xhr, status, error) {
                                        Toastify({
                                            text: 'Sorry Dear Chaeck Again , May Be error Have !',
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
    <script src="assets/plugins/select2/js/select2.min.js"></script>
    <script src="assets/plugins/select2/js/custom-select.js"></script>
    <script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
    <script src="assets/plugins/sweetalert/sweetalerts.min.js"></script>

@endsection
