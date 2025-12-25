<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('assets/font/css/all.css')}}">
    <link rel="stylesheet" href="{{asset('assets/bootstrap-5.3.6-dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/sweetalert2.css')}}">
    <link rel="stylesheet" href="{{asset('assets/boxicons-master/css/boxicons.min.css')}}">
    <link rel="shortcut icon" href="{{asset('assets/img/Logo.png')}}" type="image/x-icon">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        .flex {
            display: flex;
            align-items: center;
        }

        .container {
            padding: 0 15px;
            min-height: 100vh;
            justify-content: center;
            background: #fff;
        }

        .page {
            justify-content: space-between;
            max-width: 1000px;
            width: 100%;
        }

        .page .text {
            margin-bottom: 90px;
            text-align: center;
        }

        .page h1 {
            color: #1877f2;
            font-size: 4rem;
            margin-bottom: 10px;
        }



        .page p {
            font-size: 1.55rem;
            white-space: nowrap;
        }

        form {
            display: flex;
            flex-direction: column;
            background: #fff;
            border-radius: 8px;
            padding: 50px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1),
                0 8px 16px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        form i, p {
            text-align: center;
        }

        form input[type="text"],
        input[type="email"],
        input[type="password"] {
            height: 55px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 1rem;
            padding: 0 14px;
        }

        form input:focus {
            outline: none;
            border-color: #1877f2;
        }

        input::placeholder {
            color: #777;
            font-size: 1.063rem;
        }

        .link {
            display: flex;
            flex-direction: column;
            text-align: center;
            gap: 15px;
        }

        .link button,
        .link a {
            border: none;
            outline: none;
            cursor: pointer;
            padding: 10px 0;
            border-radius: 6px;
            color: #fff;
            font-size: 1.25rem;
            font-weight: 600;
            transition: 0.2s ease;
        }

        .link .btn-primary {
            background: #1877f2;
        }

        .link .btn-success {
            background: #10b981;
        }

        .link .btn-warning {
            background: #f59e0b;
        }

        .link .btn-royal {
            background: #8b5cf6;
        }

        .link .btn-secondary {
            background: #777;
        }



        form a {
            text-decoration: none;
        }

        .link .forgot {
            color: #1877f2;
            font-size: 0.875rem;
        }

        .link .forgot:hover {
            text-decoration: underline;
        }

        hr {
            border: none;
            height: 1px;
            background-color: #ccc;
            margin-bottom: 20px;
            margin-top: 20px;
        }

        .button {
            margin-top: 25px;
            text-align: center;
            margin-bottom: 20px;
        }

        .button a {
            padding: 15px 20px;
            background: #42b72a;
            border-radius: 6px;
            color: #fff;
            font-size: 1.063rem;
            font-weight: 600;
            transition: 0.2s ease;
        }

        .button a:hover {
            background: #3ba626;
        }

        @media (max-width: 900px) {
            .page {
                flex-direction: column;
            }

            .page h1 {
                font-size: 3rem;
            }

            .page .text {
                margin-bottom: 30px;
            }
        }

        @media (max-width: 768px) {
            .page h1 {
                font-size: 2rem;
            }

            .page .text p {
                font-size: 1.10rem;
                margin: 0;

            }

            form {
                padding: 15px;
            }
        }

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
    <main class="container flex">
        <section class="page flex">
            <div class="text">
                <a href="/"><img src="{{asset('assets/img/Logo.png')}}" style="width: 100px; height: 100px; border-radius: 50%;" alt=""></a>
                <h1>CampusDoctor</h1>
                <p class="text-muted">Find your doctor online</p>
                <p class="text-muted">Book as you wish with CampusDoctor </p>
            </div>
            @yield('content')

        </section>
    </main>
    <script src="{{asset('js/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('assets/js/eye.js')}}"></script>

</body>

</html>