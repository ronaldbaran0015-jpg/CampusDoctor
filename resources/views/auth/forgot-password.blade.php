<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{asset('assets/css/login.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/font/css/all.css')}}" />
    <link rel="shortcut icon" href="{{asset('assets/img/Logo.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('assets/css/sweetalert2.css')}}">
    <link rel="stylesheet" href="{{asset('assets/boxicons-master/css/boxicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/bootstrap-5.3.6-dist/css/bootstrap.min.css')}}">
    <script src="{{asset('assets/js/eye.js')}}" defer></script>
    <style>
        .form-control {
            background: var(--incoming-bg);
            color: var(--txt-color);
        }

        .form-control:focus {
            box-shadow: none;
            border-color: none;
            background: none;
            color: var(--txt-color);


        }
    </style>
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
                <form method="POST" action="{{ route('patient.password.email') }}" class="form m-0">
                    @csrf
                    <h2 class="heading">
                        <x-heroicon-s-exclamation-triangle class="text-center" style="width: 32px; height: 32px;" />

                    </h2>

                    <h2 class="heading">
                        Forgot your password?
                    </h2>
                    <p>Enter your email and we’ll send you a reset link.</p>

                    @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" maxlength="50" class="form-control" required autocomplete="email" autofocus>
                    </div>
                    <div class="row flex-md-row-reverse justify-content-between">
                        <div class="col-md-4 my-1">
                            <a class="text-decoration-none btn btn-outline-secondary w-100" href="{{ route('login') }}">Back to login</a>
                        </div>
                        <div class="col-md-4 my-1">
                            <button type="submit" class="btn btn-primary px-4 w-100">Send Link</button>

                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>
    <!-- Javascript files -->
    @if (session()->has('success'))
    <script>
        window.onload = () => {
            Swal.fire({
                position: "top",
                toast: true,
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                icon: "success",
                title: "{{session()->get('success')}}"
            });
        }
    </script>
    @endif
    <script src="{{asset('assets/js/sweetalert2.all.min.js')}}"></script>
</body>

</html>