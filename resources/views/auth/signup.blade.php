<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="{{asset('assets/css/login.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/sweetalert2.css')}}">
    <link rel="stylesheet" href="{{asset('assets/bootstrap-5.3.6-dist/css/bootstrap.min.css')}}">
    <link rel="shortcut icon" href="{{asset('assets/img/Logo.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('assets/boxicons-master/css/boxicons.min.css')}}">
    <script src="{{asset('assets/js/eye.js')}}" defer></script>

</head>

<body>
    
    <section class="container-content" id="sign-up-section">
        <div class="signup-wrapper">
            <div class="image-panel">
                <div class="slider">
                    <header style="display:flex;justify-content:space-between;align-items:center;">
                        <span class="text-light fw-bold"><small style="font-size: 12px;">THE HEALTH PROJECT</small> </span>
                        <a href="/" class="back-btn text-light nav-link" style="font-size: 12px;">Back to website ➔</a>
                    </header>
                    <article style="text-align:center;" class="brand-logo flex-grow-1">
                        <a href="/personnels"><img src="{{asset('assets/img/Logo.png')}}" alt=""></a>

                        <h3 class="text-light fw-bold brand-name"><b>CampusDoctor</b></h3>
                    </article>
                </div>
            </div>
            <div class="sign-form-container ">
                <form class="form" method="POST" action="{{route('signup')}}">
                    @csrf
                    <h2 class="heading">Signup</h2>
                    <p>Create account in to start.</p>
                    <div class="form-step active" id="step1">
                        <div class="input-field">
                            <input type="text" style="text-transform:capitalize;" name="name" placeholder="Full name" required spellcheck="false" />
                            <i class="bx bx-user icon"><span>*</span></i>
                        </div>
                        <div class="input-field">
                            <input type="text" style="text-transform:capitalize;" name="address" placeholder="Address" required spellcheck="false" />
                            <i class="bx bx-globe icon"><span>*</span></i>
                        </div>

                        <div class="input-field">
                            <input type="email" name="email" placeholder="Email" class="show" required spellcheck="false" />
                            <i class="bx bx-envelope icon"><span>*</span></i>
                        </div>
                        <div class="input-field">
                            <input type="tel" name="contact" placeholder="Phone no. (09xxxxxxxxx)" maxlength="11" pattern="[0-9]{11}" id="contact" required>

                            <i class="bx bx-phone icon"><span>*</span></i>
                        </div>
                        <button type="button" id="nextBtn" class="primary-button d-flex align-items-center justify-content-center"><span>Next</span><i class="bx bx-right-arrow-alt"></i></button>
                    </div>
                    <div class="form-step" id="step2">
                        <div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Date of Birth</label>
                                <div class="d-flex gap-2">
                                    <div class="mb-3 col-md-6">

                                        <select class="form-select" name="dob_month" required>
                                            <option value="">Month</option>
                                            @foreach(['January','February','March','April','May','June','July','August','September','October','November','December'] as $index => $month)
                                            <option value="{{ $index + 1 }}">{{ $month }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-6">

                                        <select class="form-select" name="dob_day" required>
                                            <option value="">Day</option>
                                            @for($i = 1; $i <= 31; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-6">

                                        <select class="form-select" name="dob_year" required>
                                            <option value="">Year</option>
                                            @for($i = date('Y'); $i >= 1900; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" d-flex gap-2 justify-content-between">
                            <button type="button" class="secondary-button" style=" background: gray;" id="prevBtn"><i class="bx bx-arrow-left"></i> Previous</button>
                            <button type="button" id="nextBtn2" class="primary-button d-flex align-items-center justify-content-center"><span>Next</span><i class="bx bx-right-arrow-alt"></i></button>
                        </div>
                    </div>
                    <div class="form-step" id="step3">

                        <div class="form-floating mb-4 position-relative">
                            <input type="password" class="px-4 form-control password @error('password') is-invalid @enderror"
                                name="password" id="password" placeholder="Password" required>
                            <label for="password" class="ms-2">Password</label>
                            <span class="position-absolute top-50 start-0 translate-middle-y me-2 password-toggle">
                                <i class="bx bx-lock"></i>
                            </span>
                            @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-floating mb-3 position-relative">
                            <input type="password" class="px-4 form-control password  @error('password_confirmation') is-invalid @enderror"
                                name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required>
                            <label for="password_confirmation" class="ms-2">Confirm Password</label>
                            <span class="position-absolute top-50 start-0 translate-middle-y me-2 password-toggle">
                                <i class="bx bx-lock"></i>
                            </span>
                            @error('password_confirmation')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <input type="checkbox" class="showHidePw" id="showpassword"> <label for="showpassword"> Show Password</label>

                        <div class="d-flex gap-2 justify-content-between">
                            <button type="button" class="secondary-button" style="background: gray;" id="prevBtn2"><i class="bx bx-arrow-left"></i> Previous</button>
                            <button type="submit" class="primary-button">Create</button>
                        </div>
                        <label class="d-flex align-items-center fw-normal my-3  w-100" style="font-size: 14px;">
                            <input type="checkbox" name="terms" value="1" required style="margin-right: 8px;">
                            <span class="text">I agree to the <a href="link-primary">Terms and condition </a> of campusdoctor lorem, ipsum dolor sit amet consectetur adipisicing elit.</span>
                        </label>

                    </div>
                    @include('client.alerts.error')
                    <p class="footer">
                        Already have an account ? <a href="/login">Login</a>
                    </p>
                </form>
            </div>
        </div>
    </section>
    <!-- Javascript files -->
    <script src="{{asset('assets/js/stepform.js')}}"></script>
    <script src="{{asset('assets/js/sweetalert2.all.min.js')}}"></script>


</body>

</html>