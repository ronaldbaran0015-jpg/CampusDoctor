<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="{{asset('css/login.css')}}" />
    <link rel="stylesheet" href="{{asset('css/client.css')}}" />
    <link rel="stylesheet" href="{{asset('font/css/all.css')}}" />
    <link rel="stylesheet" href="{{asset('bootstrap-5.3.6-dist/css/bootstrap.min.css')}}">
    <link rel="shortcut icon" href="{{asset('img/Logo.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('boxicons-master/css/boxicons.min.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <script src="{{asset('js/eye.js')}}" defer></script>
</head>

<body>
    <!-- For mobile testing only,-->
    <!--  Remove the container-content and phone class to display desktop mode view  -->
    <!-- Also remove the client css in the head tag -->
    <div class="container-content">
        <div class="cover">
            <div class="power-btn"></div>
            <div class="volume-btn"></div>
            <div class="phone">

                <div class="d-flex align-item-center justify-content-center">
                    <div class="eyeland">
                        <div class="camera"></div>
                    </div>
                </div>

                <div class="signup-wrapper ">

                    <div class="sign-form-container">
                        <form class="form" method="POST" action="/admin_signup" enctype="multipart/form-data">
                            @csrf
                            <div class="logo text-center">
                                <img src="assets/img/logo.png" alt="" style="border-radius:50%">
                            </div>
                            <h2 class="heading">Admin Signup</h2>
                            <p>Create account in to start.</p>
                            <div class="form-step active" id="step1">
                                <div class="input-field">
                                    <input type="text" style="text-transform:capitalize;" name="adminname" placeholder="Full name" required spellcheck="false" />
                                    <i class="fa fa-user icon"></i>
                                </div>
                                <div class="input-field">
                                    <input type="tel" name="admincontact" placeholder="Contact no. (eg, 09xxxxxxxxx)" maxlength="11" pattern="[0-9]{11}" required spellcheck="false" />
                                    <i class="fa fa-phone icon"></i>
                                </div>
                                <div class="input-field">
                                    <input type="text" style="text-transform:capitalize;" name="adminusername" placeholder="Username" required spellcheck="false" />
                                    <i class="fa fa-user-tie icon"></i>
                                </div>


                                <label class="form-label ">Password</label>
                                <div class="position-relative">

                                    <input type="password" class="form-control px-5 password" name="adminpassword" spellcheck="false" required>
                                    <i class="fa fa-lock icon position-absolute top-50 ms-3 translate-middle-y"></i>
                                    <i class="fa fa-eye-slash showHidePw position-absolute top-50  me-3  end-0 translate-middle "></i>

                                </div>
                                <label class="form-label ">Confirm Password</label>
                                <div class="position-relative">

                                    <input type="password" class="form-control px-5 password" name="adminpassword_confirmation" minlength="8" spellcheck="false" required>
                                    <i class="fa fa-lock icon position-absolute top-50 ms-3 translate-middle-y"></i>
                                    <i class="fa fa-eye-slash showHidePw position-absolute top-50  me-3  end-0 translate-middle "></i>
                                </div>

                                <label class="form-label ">Upload Your Photo</label>

                                <div class="position-relative">
                                    <input type="file" class="form-control" name="adminimage">
                                </div>

                                <button type="submit" class="">Create</button>


                            </div>



                            @if ($errors->any())
                            <div class="text-center text-danger">
                                @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                                @endforeach
                            </div>
                            @endif


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Javascript files -->
    <script src="{{asset('js/stepform.js')}}"></script>

</body>

</html>