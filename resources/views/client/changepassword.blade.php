@extends('layouts.container-content')
@section('title', 'Change Password')
@section('content')
<style>
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
@include('layouts.base_side')
<main class="main-content shadow-sm">
    <div class="container-content">
        <section class="viewport p-3" id="change-password-section">
            <header class="header d-flex mb-4">
                <a href="javascript:history.back()" class="nav-link"> <i class="fa fa-chevron-left"></i></a>
            </header>
            <div class="container-fluid">
                <h1 class="fw-bold top-heading"> <i class="fa fa-unlock"></i> Change Password</h1>
                <p class="text fw-light">Your new password must be different from previous used passwords <i class="fa fa-check-circle text-success"></i></p>
                <form method="POST" action="{{ route('password.updatePassword') }}" onsubmit="return confirm('Confirm this action?')">
                    @csrf
                    @method('PUT')
                    <div class="form-group text">
                        <label for="current_password" class="">Current Password</label>
                        <input type="password" class="form-control password" id="current_password" maxlength="50" name="current_password" required>
                    </div>
                    <div class="form-group text mt-2">
                        <label for="new_password">New Password</label>
                        <input type="password" class="form-control password" id="new_password" minlength="8" maxlength="50" name="new_password" required>
                    </div>
                    <p class="text fw-bold text-danger m-0">Please add the necessary characters to create a safe password</p>
                    <ul class="p-0">
                        <li style="list-style-type: none;"><i class="fa fa-check-circle text-success"></i> Minimum of 12 characters</li>
                        <li style="list-style-type: none;"><i class="fa fa-check-circle text-success"></i> One uppercase character</li>
                        <li style="list-style-type: none;"><i class="fa fa-check-circle text-success"></i> One lowercase character</li>
                        <li style="list-style-type: none;"><i class="fa fa-check-circle text-success"></i> One special character</li>
                        <li style="list-style-type: none;"><i class="fa fa-check-circle text-success"></i> One number</li>
                    </ul>
                    <div class="form-group text mt-2">
                        <label for="new_password_confirmation">Confirm New Password</label>
                        <input type="password" class="form-control password" id="new_password_confirmation" minlength="8" maxlength="50" name="new_password_confirmation" required>
                    </div>
                    <div class="d-flex align-items-center my-3 gap-1">
                        <input type="checkbox" name="showpassword" id="showpassword" class="showHidePw " style="user-select: none;">
                        <label for="showpassword" class="text" style="user-select: none;">
                            Show password
                        </label>
                    </div>
                    @if ($errors->any())
                    <div class="text-center text-danger">
                        @foreach ($errors->all() as $error)
                        <span>{{ $error }}</span>
                        @endforeach
                    </div>
                    @endif
                    <button type="submit" class="btn btn-primary w-100">Update Password</button>
                </form>


            </div>
        </section>
        <script src="{{asset('assets/js/eye.js')}}"></script>
    </div>
</main>
@endsection