@extends('layouts.nav')

@section('name', 'Profile User')
@section('custom-css')
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
    <!-- Add this in your head or body section -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>




@endsection
@section('content')
    <style>
        .modal-content {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Ensure the image takes up the full width */
        #image {
            max-width: 100%;
            height: auto;
        }

        .cropper-container {
            width: 100%;
            height: 100%;
        }

        .modal-body {
            width: 100%;
            /* position: relative; */
            flex: 1 1 auto;
            padding: 1rem;
            height: 436px;
            /* height: 100%; */
        }

        .modal-dialog {
            display: flex;
            justify-content: center;
            /* max-height: 120%; */
            max-width: 80%;
            align-items: center;
        }

        /* Close button */
        .close {
            position: absolute;
            top: 0;
            right: 0;
            padding: 10px;
            cursor: pointer;
        }

        /* Profile image */
        #profileImage {
            max-width: 400px;
            max-height: 400px;
            margin: 0 auto;
            display: block;
        }

        /* Modal options */
        .modal-options {
            margin-top: 20px;
        }

        /* Modal buttons */
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            margin: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .cropper-view-box,
        .cropper-face {
            border-radius: 50%;
        }
    </style>
    <div class="page-wrapper page-wrapper-one">
        <div class="content">
            <div class="page-header">
                {{-- <div class="page-title">
                <h4>Profile User</h4>
                <h6>{{ Auth::user()->username }} Its Your Profile 🤖</h6>
            </div> --}}
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="profile-set">
                        <div class="profile-head">
                        </div>
                        <div class="profile-top">
                            <form action="{{ route('profile.update.image') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="profile-contentimg" style="margin-left: 23px;">
                                    <img src="@if (isset(Auth::user()->file)) {{ asset('uploads/users/' . Auth::user()->file) }}
          @elseif (Auth::user()->hasRole('admin')) {{ asset('assets/img/admin.jpg') }}
          @elseif (Auth::user()->hasRole('cashier')) {{ asset('assets/img/cashier.png') }}
          @else {{ asset('assets/img/user.png') }} @endif"
                                        alt="img" id="blah" style="max-width: 110px !important; height: 110px;"
                                        data-initial-src="@if (isset(Auth::user()->file)) {{ asset('uploads/users/' . Auth::user()->file) }}
                             @elseif (Auth::user()->hasRole('admin')) {{ asset('assets/img/admin.jpg') }}
                             @elseif (Auth::user()->hasRole('cashier')) {{ asset('assets/img/cashier.png') }}
                             @else {{ asset('assets/img/user.png') }} @endif">
                                    <div class="profileupload" style="position: absolute; right: 66px; bottom: -10px;">
                                        <a href="javascript:void(0);">
                                            <label for="imgInp" style="cursor: pointer">
                                                <img src="assets/img/icons/edit-set.svg" alt="img">
                                            </label>
                                        </a>
                                        <input type="file" name="file" id="imgInp" style="display:none;">
                                    </div>
                                </div>







                                <div class="profile-contentname" style="position: relative;top: 14px;">
                                    <h2>{{ Auth::user()->username }}</h2>
                                    <h4>Updates Your Photo and Personal Details.</h4>
                                </div>
                        </div>
                        <div class="ms-auto"
                            style="   position: absolute;
                        right: 26px;
                        top: 220px;
                        margin-right: 20px;">
                            <button id="profile" class="btn btn-submit me-2">Save</button>
                            <a href="javascript:void(0);"  class="btn btn-cancel">Cancel</a>
                        </div>
                        </form>
                       
                       
                       <script>
                            $(document).ready(function() {
                                // Reset input file field and image when "Cancel" button is clicked
                                $('.btn-cancel').click(function() {
                                    $('#imgInp').val(''); // Reset input file field
                                    $('#blah').attr('src', $('#blah').data('initial-src')); // Reset image to initial source
                                });
                            });
                        </script>


                        <script>
                            $(document).ready(function() {
                                $('#profile').click(function(e) {
                                    e.preventDefault();
                                    var id = $('#id').val();



                                    // Get the file input element
                                    var ImageInput = $('#imgInp')[0];
                                    var Image = ImageInput.files[0];



                                    // Create FormData object
                                    var formData = new FormData();
                                    formData.append('id', id);
                                    formData.append('image', Image);
                                    // Get CSRF token value from the meta tag
                                    var csrfToken = $('meta[name="csrf-token"]').attr('content');



                                    // Send AJAX request
                                    $.ajax({
                                        url: "{{ route('profile.update.image') }}",
                                        type: "POST",
                                        data: formData,
                                        processData: false, // Prevent jQuery from processing the data
                                        contentType: false, // Prevent jQuery from setting content type
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
                                        },
                                        success: function(response) {
                                            Toastify({
                                                text: 'Your Image Updated Successfully !',
                                                duration: 2000,
                                                gravity: 'top-left', // Position the toast notification at the top left corner
                                                close: true, // Show a close button
                                                backgroundColor: 'linear-gradient(to right, #01919C, #2B2B2B)', // Custom background color
                                                className: 'toastify-custom', // Custom CSS class for styling
                                            }).showToast();



                                            setTimeout(function() {
                                                window.location.href =
                                                    '{{ route('profile.page') }}';
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
                <div class="row" style="z-index: 1;margin-left: 20px;margin-right: 20px;position: relative;top: -48px">
                    <form action="{{ route('profile.update.info') }}" method="POST"
                        style="display: flex; flex-wrap:wrap; margin-top: 40px;">
                        @csrf

                        <div class="col-lg-3 col-sm-6 col-12" style="padding-left:10px">
                            <div class="form-group">

                                <label for="username">{{ __('Username') }}</label>
                                <input class="form-control" type="text" value="{{ Auth::user()->username }}"
                                    id="username" name="username" placeholder="Username" autofocus />


                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12" style="padding-left:10px">
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input class="form-control " type="text" value="{{ Auth::user()->email }}"
                                    id="email" name="email" placeholder="someone@example.com" />

                            </div>
                        </div>


                        <div class="col-lg-3 col-sm-6 col-12" style="padding-left:10px">
                            <div class="form-group">
                                <label for="phone">Phone Address</label>
                                <input class="form-control" value="{{ Auth::user()->phone }}" type="text" id="phone"
                                    name="phone" placeholder="0770 111 2222" oninput="formatPhoneNumber(this)"
                                    pattern="\d{4} \d{3} \d{4}"
                                    title="Please enter a phone number in the format 0770 111 2222" />

                            </div>
                        </div>


                        <div class="col-lg-3 col-sm-6 col-12" style="padding-left:10px">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="pass-group">
                                    <input type="password" class=" pass-input form-control" name="password" required
                                        autocomplete="new-password" id="password">
                                    <span class="fas toggle-password fa-eye-slash"></span>


                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12" style="padding-left:10px">
                            <div class="form-group">
                                <label for="password-confirm">Confirm Password</label>
                                <div class="pass-group">
                                    <input type="password" required id="password-confirm" class=" pass-input form-control "
                                        name="password_confirmation" autocomplete="new-password">
                                    <span class="fas toggle-password fa-eye-slash"></span>


                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <button id="profileinfo" class="btn btn-submit me-2">Submit</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-cancel">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#profileinfo').click(function(e) {
                e.preventDefault();
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
                var password = $('#password').val();
                var passwordConfirm = $('#password-confirm').val();


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



                // Create FormData object
                var formData = new FormData();
                formData.append('name', username);
                formData.append('email', email);
                formData.append('phone', userphone);
                formData.append('password', password);

                // Get CSRF token value from the meta tag
                var csrfToken = $('meta[name="csrf-token"]').attr('content');



                // Send AJAX request
                $.ajax({
                    url: "{{ route('profile.update.info') }}",
                    type: "POST",
                    data: formData,
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false, // Prevent jQuery from setting content type
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
                    },
                    success: function(response) {
                        Toastify({
                            text: 'Your profile Updated Successfully !',
                            duration: 2000,
                            gravity: 'top-left', // Position the toast notification at the top left corner
                            close: true, // Show a close button
                            backgroundColor: 'linear-gradient(to right, #01919C, #2B2B2B)', // Custom background color
                            className: 'toastify-custom', // Custom CSS class for styling
                        }).showToast();



                        setTimeout(function() {
                            window.location.href =
                                '{{ route('profile.page') }}';
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


@endsection
@section('custom-js')

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



    {{--
<!-- Modal for image cropping -->
<div class="modal fade" id="cropModal" tabindex="-1" aria-labelledby="cropModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cropModalLabel">Crop Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-regular fa-circle-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <img id="image" src="" alt="Cropped Image" style="height: 838px;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="crop">Crop</button>
            </div>
        </div>
    </div>
</div> --}}





    <script>
        $(document).ready(function() {
            const input = document.getElementById('imgInp');
            const preview = document.getElementById('blah');
            let cropper;

            input.addEventListener('change', function(event) {
                if (cropper) {
                    cropper.destroy(); // Destroy the previous cropper instance
                }

                const file = event.target.files[0];
                const reader = new FileReader();

                reader.onload = function() {
                    const img = new Image();
                    img.src = reader.result;

                    img.onload = function() {
                        $('#cropModal').modal('show');
                        cropper = new Cropper(document.getElementById('image'), {
                            aspectRatio: 1, // Set aspect ratio to 1 for a circle
                            viewMode: 1,
                            autoCropArea: 1,
                            responsive: true,
                            restore: false,
                            guides: false,
                            center: false,
                            highlight: false,
                            dragMode: 'move',
                            cropBoxMovable: false,
                            cropBoxResizable: false,
                            toggleDragModeOnDblclick: false,
                            crop: function(event) {}
                        });

                        cropper.replace(img.src);
                    }
                }

                reader.readAsDataURL(file);
            });

            $('#crop').click(function() {
                const canvas = cropper.getCroppedCanvas({
                    width: 200,
                    height: 200
                });
                preview.src = canvas.toDataURL('image/jpeg');
                $('#cropModal').modal('hide');
            });
        });
    </script>

    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>
@endsection
