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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{asset('assets/img/Logo.png')}}" type="image/x-icon">
</head>
<body>
    <div class="container-content position-fixed w-100">
        <div class="cover">
            <div class="power-btn"></div>
            <div class="volume-btn"></div>
            <div class="phone">
                <div class="d-flex align-item-center justify-content-center">
                    <div class="eyeland">
                        <div class="camera"></div>
                    </div>
                </div>
                <button id="darkSwitch" class="dark-mode-delegate" style="display: none;"></button>

                @yield('content')
            </div>
        </div>
    </div>
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
    <script src="{{asset('assets/js/darkmode.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.js"></script>

</body>

</html>