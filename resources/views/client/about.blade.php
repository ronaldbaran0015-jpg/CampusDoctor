@extends('layouts.container-content')
@section('title', 'About us')
@section('content')
@include('layouts.base_side')

<main class="main-content shadow-sm">
    <div class="container-content">
        <section class="viewport p-3" id="about-section">
            <header class="header mb-3">
                <a href="javascript:history.back()" class="nav-link"> <i class="fa fa-chevron-left"></i></a>
                <span class="mx-auto">About us</span>
            </header>
            <div class="container text-center  py-5">
                <img src="{{asset('assets/img/Logo.png')}}" class="mb-3" style="width:100px;height:100px; border-radius: 50%;" alt="Logo">
                <h3 class="fw-bold heading">CampusDoctor</h3>
                <p class="text fw-light">Version: 1.0</p>
                <p class="text">Declaration <a href="{{route('policy')}}" class="link-primary">Privacy Policy</a></p>
            </div>
        </section>
        <footer class="text-center py-3  border-top position-fixed bottom-0 w-100">
            <a href="#" class="btn btn-outline-primary mb-2">Like us on Facebook <i class="fab fa-facebook"></i></a>
            <p class="text fw-light small mb-0">Copyright ©2025 CampusDoctor All Rights Reserved</p>
        </footer>
        @endsection
    </div>
</main>