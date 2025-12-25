<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('assets/css/client.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/sweetalert2.css')}}">
    <link rel="stylesheet" href="{{asset('assets/font/css/all.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/bootstrap-5.3.6-dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/boxicons-master/css/boxicons.min.css')}}">
    <link rel="shortcut icon" href="{{asset('assets/img/Logo.png')}}" type="image/x-icon">
</head>
<body>
    <button id="darkSwitch" class="dark-mode-delegate" style="display: none;"></button>
    @yield('content')
    <script src="{{asset('assets/js/darkmode.js')}}"></script>
    <script src="{{asset('assets/js/sweetalert2.all.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.js"></script>
</body>

</html>