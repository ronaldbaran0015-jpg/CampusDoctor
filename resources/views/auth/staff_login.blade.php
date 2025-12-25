@extends('auth.auth_layout')
@section('title', 'Staff Login')
@section('content')
<form action="{{route('staff_login')}}" method="post">
    @csrf
    <p class="text-secondary">Staff Login</p>
    <div class="form-floating position-relative">
        <input type="email" class="form-control"
            name="staffemail" id="email" placeholder="Email" required>
        <label for="email"><i class="fa fa-envelope"></i> Email</label>

    </div>
    <div class="form-floating mb-3 position-relative">
        <input type="password" class="form-control password"
            name="staffpassword" id="password" placeholder="Password" required>
        <label for="password"><i class="fa fa-lock"></i> Password</label>
        <input type="checkbox" name="showpassword" id="showpassword" class="showHidePw" style="user-select: none;"> Show Password

    </div>

    <div class="link">
        <button type="submit" class="login btn-primary">Login <i class="fa fa-sign-in-alt"></i></button>
        <a href="javascript:history.back()" class="btn btn-secondary">Back</a>

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


    @if ($errors->any())
    <div class="text-center mt-4">
        @foreach ($errors->all() as $error)
        <span class="alert alert-danger">{{ $error }}</span><br>

        @endforeach
    </div>
    @endif
</form>
@endsection