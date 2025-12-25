<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/splash.css" />
    <link rel="shortcut icon" href="{{asset('assets/img/Logo.png')}}" type="image/x-icon">
</head>
<body>
    <main class="bg">
        <img src="{{asset('assets/img/Logo.png')}}" class="app-logo border" alt="App Logo">
        <h1 class="app-title">CampusDoctor</h1>
    </main>
    <script>
        // Redirect after 3 seconds (adjust as needed)
        setTimeout(() => {
            window.location.href = "/campusdoctor.com";
        }, 5000);
    </script>
</body>

</html>