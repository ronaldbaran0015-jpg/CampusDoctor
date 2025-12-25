<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <link rel="stylesheet" href="{{asset('assets/css/index.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="shortcut icon" href="{{asset('img/Logo.png')}}" type="image/x-icon">
    <title>CampusDoctor Landing Page</title>
</head>

<body>
    <!-- HEADER -->
    @include('partials.header')

    <!-- MAIN HERO BACKGROUND -->
    <main class="hero-bg">
        <!-- DARK OVERLAY -->
        <section class="hero-overlay">
            <!-- CENTERED CONTENT -->
            <article class="hero-content">
                <h1 class="hero-title">Avoid Hassles & Delays.</h1>
                <p class="hero-subtext">
                    Don't worry. Find your doctor online. Book as you wish with CampusDoctor.
                    We offer you a free doctor channeling service — make your appointment now.
                </p>
                <a href="/login" class="btn btn-primary px-5 py-2">Get Started</a>
            </article>
        </section>
    </main>
    <!-- FOOTER -->
    <footer class="site-footer">
        <p class="hero-subtext text-center">A Web Solution By Team RJ45</p>
    </footer>
    <script src="{{asset('assets/bootstrap-5.3.6-dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.14.1/dist/gsap.min.js"></script>
    <script>
        gsap.set(".hero-title, .hero-subtext, .hero-content .btn", {
            opacity: 0,
            y: 30
        });

        gsap.timeline({
                defaults: {
                    ease: "power3.out"
                }
            })
            .fromTo(".hero-overlay", {
                opacity: 0
            }, {
                opacity: 1,
                duration: 1
            })
            .to(".hero-title", {
                opacity: 1,
                y: 0,
                duration: 0.8
            })
            .to(".hero-subtext", {
                opacity: 1,
                y: 0,
                duration: 0.8
            }, "-=0.4")
            .to(".hero-content .btn", {
                opacity: 1,
                y: 0,
                scale: 1.05,
                duration: 0.6
            }, "-=0.3")

            .to(".hero-content .btn", {
                scale: 1,
                duration: 0.2
            });
    </script>
    <script>
        gsap.set(".site-header", {
            y: -40,
            opacity: 0
        });

        gsap.to(".site-header", {
            y: 0,
            opacity: 1,
            duration: 0.8,
            ease: "power3.out",
            delay: 0.2
        });
    </script>


</body>


</html>