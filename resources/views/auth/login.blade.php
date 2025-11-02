<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Login - Warehouse Harem Hospital">
    <title>Login - Warehouse Harem Hospital</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/harem.png') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body class="account-page">

    <div class="main-wrapper">
        <div class="account-content">
            <div class="login-wrapper">
                <div class="login-content">

                    <div class="login-userset">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="login-logo">
                                <img src="{{ asset('assets/img/haremw.png') }}" alt="img" width="100%">
                            </div>
                            <div class="login-userheading">
                                <h3>Sign In</h3>
                                <h4>Please Login to your account 🤖</h4>
                            </div>



                            <div class="form-login">
                                <label>{{ __('Username & Email Address') }}</label>
                                <div class="form-addons">
                                    <input type="text" style="font-family: 'Times New Roman', Times, serif"
                                        id="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>


                                    @error('email')
                                        <span class="invalid-feedback " role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-login">
                                <label>Password</label>
                                <div class="pass-group">
                                    <input id="password" type="password"
                                        style="font-family: 'Times New Roman', Times, serif"
                                        class="pass-input @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    <span class="fas toggle-password fa-eye-slash"></span>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>



                            {{-- @if (Route::has('password.request'))
                                <div class="form-login">
                                    <div class="alreadyuser">
                                        <h4><a href="{{ route('password.request') }}" class="hover-a">Forgot Your
                                                Password ?</a></h4>
                                    </div>
                                </div>
                            @endif --}}
                            <div class="form-login form-login1"
                                style="justify-content: center;
                            display: flex;
                            height: 138px;">
                                <button class="btn btn-login" type="submit" id="loginButton"
                                    style="position: relative; width: max-content; height: max-content;">Sign
                                    In</button>
                            </div>
                            <div class="signinform text-center">
                                <h4>&copy; All Right Reseved <a href="signup.html" class="hover-a">Mister Team</a></h4>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="login-img">
                    <img src="{{ asset('assets/img/bg.svg') }}" alt="img">
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var hasInteracted = false;
            var initialPosition = {};

            // Store the initial position of the button
            initialPosition = $('#loginButton').position();

            $('#email, #password').on('input', function() {
        if ($('#email').val() && $('#password').val()) {
            hasInteracted = true;
            $('#loginButton').stop(true, true).css({
                'left': 0,
                'top': 0
            });
        } else {
            hasInteracted = false;

        }
    });

    // $('#email, #password').on('keyup', function() {
    //     if (!$('#email').val() || !$('#password').val()) {
    //         animateButton($('#loginButton'), $('.form-login1'));
    //     }
    // });

            // $('#loginButton').hover(
            //     function() {
            //         if (!hasInteracted) {
            //             animateButton($(this), $('.form-login1'));
            //         }
            //     },
            //     function() {
            //         stopAnimation($(this));
            //     }
            // );

            // function animateButton() {
            //     // Randomly select a direction (left, right, up, or down)
            //     var directions = ['left', 'right', 'up', 'down'];
            //     var randomDirection = directions[Math.floor(Math.random() * directions.length)];

            //     // Define the distance to move (in pixels)
            //     var distance = 100;

            //     // Animate the button in the selected direction
            //     switch (randomDirection) {
            //         case 'left':
            //             $('#loginButton').animate({
            //                 left: `-=${distance}px`
            //             }, 10);
            //             break;
            //         case 'right':
            //             $('#loginButton').animate({
            //                 left: `+=${distance}px`
            //             }, 10);
            //             break;
            //         case 'up':
            //             $('#loginButton').animate({
            //                 top: `-=${distance}px`
            //             }, 10);
            //             break;
            //         case 'down':
            //             $('#loginButton').animate({
            //                 top: `+=${distance}px`
            //             }, 10);
            //             break;
            //         default:
            //             break;
            //     }
            // }

            // function stopAnimation() {
            //     // Stop the animation and reset the button's position
            //     $('#loginButton').stop(true, true);
            // }
        });
    </script>










    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>

    <script src="{{ asset('assets/js/feather.min.js') }}"></script>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>

</html>
