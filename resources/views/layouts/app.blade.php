<!-- THIS IS FOR THE ADMIN, DOCTOR, AND STAFF LAYOUT-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/font/css/all.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/custom_dt.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/bootstrap-5.3.6-dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/boxicons-master/css/boxicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/sweetalert2.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/light.css')}}">

    <link rel="shortcut icon" href="{{asset('assets/img/Logo.png')}}" type="image/x-icon">
    <script src="{{asset('assets/js/sidebar.js')}}" defer></script>
    <script src="{{asset('assets/js/chart.js')}}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>@yield('title')</title>
</head>

<body>
    @include('layouts.side')
    <main class="main-content shadow-sm">
        @include('layouts.top')

        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="{{asset('assets/js/date.js')}}"></script>
    <script src="{{asset('assets/js/darkmode.js')}}"></script>
    <script src="{{asset('assets/js/chart.js')}}"></script>
    <script src="{{asset('assets/js/lightbox.js')}}"></script>
    <script src="{{asset('assets/js/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('assets/bootstrap-5.3.6-dist/js/bootstrap.bundle.min.js')}}"></script>
</body>

</html>