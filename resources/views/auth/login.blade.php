<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <meta name="description" content="A Web Application For Booking Appointment For Doctors">
    <title>Login</title>
    <!-- Local CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/login.css')}}" />
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="{{asset('assets/css/sweetalert2.css')}}">
    <!-- Fonts And Bootstrap -->
    <link rel="stylesheet" href="{{asset('assets/boxicons-master/css/boxicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/bootstrap-5.3.6-dist/css/bootstrap.min.css')}}">
    <!-- Web Icon -->
    <link rel="shortcut icon" href="{{asset('assets/img/Logo.png')}}" type="image/x-icon">

</head>
<body>
    <section class="container-content">
        <div class="login-wrapper">
            <div class="image-panel ">
                <div class="slider">
                    <header class="d-flex justify-content-between align-items-center">
                        <span class="text-light fw-bold"><small style="font-size: 12px;">THE HEALTH PROJECT</small> </span>
                        <a href="/" class="back-btn text-light nav-link" style="font-size: 12px;">Back to website ➔</a>
                    </header>
                    <article style="text-align:center;" class="brand-logo flex-grow-1">
                        <a href="/personnels"><img src="{{asset('assets/img/Logo.png')}}" alt=""></a>
                        <h3 class="text-light fw-bold brand-name"><b>CampusDoctor</b></h3>
                    </article>
                </div>
            </div>
            <div class="login-form-container">
                <form class="form m-0" method="POST" action="{{route('login')}}" onsubmit="return validateForm()">
                    @csrf

                    <h2 class="heading">Login</h2>
                    <p>Log in to start booking appointments.</p>
                    <fieldset>
                        <div class="input-field">
                            <input type="tel" name="contact" id="contact" maxlength="11" pattern="[0-9]{11}" class="contact required" placeholder="Phone no." />
                            <i class="bx bx-phone icon">*</i>
                        </div>
                        <div class="input-field">
                            <input type="password" name="password" class="password required" placeholder="Password" />
                            <i class="bx bx-lock icon"></i>
                            <!-- Eye toggle -->
                            <span class="showHidePw" id="showHidePw">
                                <!-- Eye open (hidden by default) -->
                                <x-heroicon-o-eye class="eye-icon d-none" id="eye-open" />
                                <!-- Eye closed (visible by default) -->
                                <x-heroicon-o-eye-slash class="eye-icon" id="eye-closed" />
                            </span>
                        </div>


                        <div class="d-flex justify-content-between mt-2">
                            <label class="d-flex align-items-center" style="font-size: 14px;">
                                <input type="checkbox" name="remember" value="1" style="margin-right: 8px;">
                                Remember Me
                            </label>
                            <a href="{{ route('patient.password.request') }}" class="link-secondary text-decoration-none p-0 " style="font-size: 14px;">Forgot password?</a>

                        </div>
                        <button type="submit" class="primary-button">Continue</button>
                    </fieldset>

                    <div class="d-flex align-items-center my-3">
                        <hr class="flex-grow-1"><span class="mx-2 text-muted">OR</span>
                        <hr class="flex-grow-1">
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ route('google.login') }}" class="btn btn-light border w-100 d-flex align-items-center justify-content-center gap-2 p-2">
                            <img
                                src="{{asset('assets/svg/google-icon-logo-svgrepo-com.svg')}}"
                                alt="Google logo"
                                width="18" height="18">
                            Google
                        </a>

                        <!-- Facebook Button -->
                        <a href="{{ route('auth.facebook') }}" class="btn btn-light border w-100 d-flex align-items-center justify-content-center gap-2 p-2">
                            <span style="border-radius: 50%; height: 28px; width: 28px; background: #1877f2; display:grid; place-items: center;">
                                <svg fill="#fff" height="18px" width="18px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    viewBox="-337 273 123.5 256" xml:space="preserve">
                                    <path d="M-260.9,327.8c0-10.3,9.2-14,19.5-14c10.3,0,21.3,3.2,21.3,3.2l6.6-39.2c0,0-14-4.8-47.4-4.8c-20.5,0-32.4,7.8-41.1,19.3
c-8.2,10.9-8.5,28.4-8.5,39.7v25.7H-337V396h26.5v133h49.6V396h39.3l2.9-38.3h-42.2V327.8z" />
                                </svg>
                            </span>
                            Facebook
                        </a>
                    </div>
                    @include('client.alerts.error')
                    @if ($errors->has('email'))
                    <div class="alert alert-danger">
                        {{ $errors->first('email') }}
                    </div>
                    @endif

                    @if (session('lockout_seconds'))
                    <div class="alert alert-warning">
                        Please wait <span id="countdown">{{ session('lockout_seconds') }}</span> seconds before trying again.
                    </div>
                    @endif

                    <p class="footer">
                        Don't have an account ? <a href="/signup">Sign up</a>
                    </p>
                </form>
            </div>
        </div>
    </section>
    <!-- Javascript files -->
    @include('client.alerts.success')
    <script src="{{asset('assets/js/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('assets/js/stepform.js')}}"></script>
    <script src="{{asset('assets/js/eye.js')}}"></script>


</body>

</html>