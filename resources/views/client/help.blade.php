@extends('layouts.container-content')
@section('title', 'Help')
@section('content')
@include('layouts.base_side')

<main class="main-content shadow-sm">
    <div class="container-content">
        <section class="viewport p-3" id="help-section">
            <header class="header mb-3">
                <a href="javascript:history.back()" class="nav-link"> <i class="fa fa-chevron-left"></i></a>
                <span class="mx-auto">Help</span>
            </header>
            <a href="/report_issue" class="menu-items d-flex justify-content-between align-items-center py-3 px-1">
                <i class="fa fa-warning fs-5"></i>
                <label class="ms-3" style="flex-grow: 1;">Report a problem</label>
                <div class="px-1">
                    <i class=" fa fa-chevron-right"></i>
                </div>
            </a>
            <a href="/policy" class="menu-items d-flex justify-content-between align-items-center py-3 px-1">

                <i class="fa fa-info-circle fs-5"></i>
                <label class="ms-3" style="flex-grow: 1;">FAQs</label>
                <div class="px-1">
                    <i class=" fa fa-chevron-right"></i>
                </div>
            </a>


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
            <div class="text-center mt-5">
                @foreach ($errors->all() as $error)
                <p class="alert alert-danger">{{ $error }}</p>
                @endforeach
            </div>
            @endif
        </section>
        @endsection
    </div>
</main>