@extends('auth.auth_layout')
@section('title')
@section('content')
<form action="#">
    <i class="fa fa-user-tie fa-3x"></i>
    <p>Personnel Login</p>
    <div class="link">
        <a href="/doctor_login" class="login btn-primary">Doctor</a>
        <a href="/staff_login" class="login btn-warning">Staff</a>
        <a href="/admin_login" class="login btn-success">Admin</a>
    </div>
</form>
@endsection
