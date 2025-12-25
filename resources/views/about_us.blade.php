<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <link rel="stylesheet" href="{{asset('assets/css/index.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/font/css/all.min.css')}}">
    <link rel="shortcut icon" href="{{asset('img/Logo.png')}}" type="image/x-icon">
    <title>CampusDoctor Landing Page</title>
    <style>
        .core-values {
            display: flex;
            gap: 1.5rem;
        }

        .core-card {
            flex: 1 1 220px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
            padding: 20px;
            text-align: center;
            border: 1px solid #e0e0e0;
        }

        .core-card i {
            font-size: 2rem;
            color: var(--accent-color);
            margin-bottom: 10px;
        }

        .core-card h6 {
            font-weight: 600;
            margin-bottom: 5px;
            color: #335f8f;
        }

        .core-card p {
            font-size: 0.95rem;
            color: #666;
        }

        @media(max-width:768px) {
            .core-values .core-card {
                flex: 1;
                

            }

        }
    </style>
</head>

<body>
    <!-- HEADER -->
    @include('partials.header')
    <!-- MAIN HERO BACKGROUND -->
    <main class="hero-bg">
        <!-- DARK OVERLAY -->
        <section class="hero-overlay">
            <!-- CENTERED CONTENT -->
            <div class="hero-content">
                <div class="about-left">
                    <img src="" alt="" class="about-img">
                </div>


                <p class="hero-subtext ">

                    <strong>CampusDoctor </strong> is an innovative digital platform developed to make booking of medical appointments faster and easier with just a few taps. Book as you wish with CampusDoctor.
                    We offer you a free doctor channeling service — make your appointment now.

                </p>


                <div class="core-values d-flex">
                    <div class="core-card">
                        <i class="fa fa-laptop"></i>
                        <h6>Innovation</h6>
                        <p>Using technology to modernize Health care.</p>
                    </div>
                    <div class="core-card">
                        <i class="fa fa-tachometer"></i>
                        <h6>Faster</h6>
                        <p>Ensuring impartial and just handling of every appointment.</p>
                    </div>
                    <div class="core-card">
                        <i class="fa fa-handshake"></i>
                        <h6>Easy</h6>
                        <p>Encouraging user to transition in the digital health access .</p>
                    </div>

                </div>

            </div>

        </section>
    </main>
    <!-- FOOTER -->
    <footer class="site-footer">
        <p class="hero-subtext text-center">A Web Solution By Team RJ45</p>
    </footer>
</body>

</html>