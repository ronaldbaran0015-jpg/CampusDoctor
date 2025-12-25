@extends('layouts.app')
@section('title', 'Change Password')

@section('content')
<style>
    .form-control {
        background: var(--outgoing-bg);
        color: var(--txt-color);
    }

    .form-control:focus {
        box-shadow: none;
        border-color: none;
        background: none;
        color: var(--txt-color);
    }
</style>
<section class="content-wrapper p-3">
    <article class="d-flex justify-content-between align-items-center mb-4">
        @if (Auth::guard('admin')->id())
        <h4 class="top-heading mb-0"><a href="{{route('settings')}}" class="text-decoration-none" style="color: var(--icon-color);">Setting</a> <i class="fa fa-chevron-right fs-5"></i> <span class="fw-bold"></span>Change Password</h4>
        @else
        <h4 class="top-heading mb-0">Change Password</h4>

        @endif
    </article>
    <div class="shadow-sm border rounded p-3 py-5">
        @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
            <span class="alert alert-danger">{{ $error }}</span>
            @endforeach
        </div>
        @endif
        <form class="col-lg-6" method="POST" action="{{ route('password.updatePassword') }}">
            @csrf
            @method('PUT')
            <fieldset>
                <div class="form-group text">
                    <label for="current_password" class="fw-bold">Current Password</label> <i class="fa fa-check-circle text-success"></i>
                    <input type="password" class="form-control password" id="current_password" name="current_password" required>
                </div>
                <div class="form-group text mt-2">
                    <label for="new_password" class="fw-bold">New Password</label>
                    <input type="password" class="form-control password" id="new_password" minlength="8" maxlength="20" name="new_password" required>
                </div>

                <p class="text fw-bold text-danger">Please add the necessary characters to create a safe password</p>
                <ul class="p-0">
                    <li>* Minimum of 12 characters</li>
                    <li>* One uppercase character</li>
                    <li>* One lowercase character</li>
                    <li>* One special character</li>
                    <li>* One number</li>
                </ul>
                <div class="form-group text mt-2">
                    <label for="new_password_confirmation" class="fw-bold">Confirm New Password</label>
                    <input type="password" class="form-control password" id="new_password_confirmation" minlength="8" maxlength="20" name="new_password_confirmation" required>
                </div> <br>
                <input type="checkbox" name="showpassword" id="showpassword" class="showHidePw" style="user-select: none;">
                <label for="showpassword" class="text" style="user-select: none;">
                    Show password

                </label>
                <button type="submit" class="btn btn-primary w-100 mt-3">Change Password</button>
            </fieldset>
        </form>
    </div>
</section>
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
<script src="{{asset('assets/js/eye.js')}}"></script>


@endsection