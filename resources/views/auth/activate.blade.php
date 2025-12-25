@extends('auth.auth_layout')
@section('title', 'Activate Account')
@section('content')
<form method="POST" action="{{ route('activate-account.post') }}">
    @if ($errors->any())
    <div class="text-center mt-4">
        @foreach ($errors->all() as $error)
        <p class="alert alert-danger fs-6" id="alert">{{ $error }}</p>
        @endforeach
    </div>
    @endif
    @if (session('success'))
    <div class="text-center text-danger">
        <span class="alert alert-success">{{session()->get('success')}}</span>
    </div>
    @endif
    @csrf
    <i class="fa fa-user-tie fs-1 mb-3"></i>
    <p class="text">Activate Account</p>
    <div class="form-floating mb-3 position-relative">
        <input type="email" class="form-control"
            name="email" id="email" placeholder="Enter email" required>
        <label for="contact"> <i class="fa fa-envelope"></i> Email</label>
    </div>
    <div class="form-floating mb-3 position-relative">
        <input type="password" min="8" class="form-control"
            name="password" id="password" placeholder=" Your password" required>
        <label for="password"> <i class="fa fa-lock"></i> Password.</label>
    </div>
    <div class="link">
        <button type="submit" class="login btn-primary">Activate account</button>
        <a href="{{route('login')}}" class="link-primary">Login</a>
    </div>
</form>
@endsection