@extends('layouts.include.dark')
@section('title', 'System Notification')
@section('content')
@include('layouts.base_side')

<main class="main-content shadow-sm">
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
                <div class="viewport p-3">
                    <header class="header mb-3">
                        <a href="javascript:history.back()" class="nav-link"> <i class="fa fa-chevron-left"></i></a>
                        <span class="mx-auto">Notification</span>
                    </header>
                    @if ($appointments)
                    @forelse ($appointments as $appointment )
                    <a href="#" class="border menu-items mt-2 position-relative px-3 d-flex notification justify-content-between gap-3 align-items-center shadow-sm">
                        <i class="bx bx-envelope icon-sm"></i>
                        @if ($appointment->status == 'pending')
                        <div class="position-absolute end-0 top-0 m-3"><span class="status-badge warning px-2">{{$appointment->status}}</span></div>
                        @elseif ($appointment->status == 'finished')
                        <div class="position-absolute end-0 top-0 m-3"><span class="status-badge success px-2">{{$appointment->status}}</span></div>
                        @else
                        <div class="position-absolute end-0 top-0 m-3"><span class="status-badge error px-2">{{$appointment->status}}</span></div>
                        @endif
                        <div class="text-start" style="flex-grow: 1;">
                            <label class="heading fw-bold mt-3">Dr. {{$appointment->schedule->mydoctor->name}}</label>
                            <p class="text">You have an appointment with this doctor on <span class="text-primary">{{\Carbon\Carbon::parse($appointment->appodate)->format('F d Y')}}</span> </p>
                            @if ($appointment->status == 'pending')
                            <p class="text">Time left: {{ $appointment->time_left }}</p>
                            @endif
                        </div>
                        <div class="px-1">
                            <i class=" fa fa-chevron-right"></i>
                        </div>
                    </a>
                    @empty
                    <div class="text-center">
                        <img src="{{asset('assets/svg/undraw_empty_4zx0.svg')}}" width="60%" alt="">
                        <p class="text">Nothing to show</p>
                    </div>
                    @endforelse
                    @endif


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
                </div>
            </div>
        </div>
    </div>
</main>
@endsection