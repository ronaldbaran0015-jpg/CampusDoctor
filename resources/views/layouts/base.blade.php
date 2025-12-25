<!-- THIS IS FOR THE ADMIN, DOCTOR, AND STAFF LAYOUT -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/assets/css/client.css">
    <link rel="stylesheet" href="{{asset('assets/css/sweetalert2.css')}}">
    <link rel="stylesheet" href="{{asset('assets/font/css/all.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/bootstrap-5.3.6-dist/css/bootstrap.min.css')}}">
    <link rel="shortcut icon" href="{{asset('assets/img/Logo.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('assets/boxicons-master/css/boxicons.min.css')}}">
    <link rel="shortcut icon" href="{{asset('assets/img/Logo.png')}}" type="image/x-icon">
    <style>
        @media(max-width:768px) {
            .home-header {
                display: block;
            }

            .side-bar,
            .top-bar,
            .mobile-search {
                display: none;
            }
        }
    </style>
</head>

<body>
    @include('layouts.base_side')
    @include('layouts.base_top')
    <main class="main-content shadow-sm">
        <div class="container-content">
            <div class="phone">

                @yield('content')

                @include('layouts.bottom-nav')
                <button id="darkSwitch" class="dark-mode-delegate" style="display: none;"></button>
            </div>
        </div>
    </main>

    <script src="{{asset('assets/js/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('assets/js/profilecard.js')}}"></script>
    <script src="{{asset('assets/js/darkmode.js')}}"></script>
    <script src="{{asset('assets/bootstrap-5.3.6-dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.js"></script>
</body>

</html>