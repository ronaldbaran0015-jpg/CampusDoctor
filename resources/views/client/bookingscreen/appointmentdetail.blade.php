@extends('layouts.include.dark')
@section('title', 'Appointment details')
@section('content')
<style>
    @media(min-width:1024px) {

        .action-buttons button,
        .action-buttons a {
            width: 25%;
        }
    }

    .action-buttons button,
    .action-buttons a {
        width: 75%;
    }
</style>
<link rel="stylesheet" href="{{ asset('assets/css/qrcode.css') }}">
@include('layouts.base_side')

<main class="main-content shadow-sm">
    <section class="viewport p-3" id="appointment-details-section">

        <header class="header">
            <a href="javascript:history.back()" class="nav-link">
                <i class="fa fa-chevron-left"></i>
            </a>
            <span class="mx-auto"></span>
        </header>

        <br>

        <div class="receipt-container">

            <!-- RECEIPT -->
            <div class="receipt" id="receiptElement">
                <div class="triangle-top top" id="triangleTop"></div>
                <div class="receipt-content">

                    <div class="text">
                        <h2 class="title">You made an appointment</h2>
                        <p class="reward">Successfully Made an Appointment</p>
                        <p class="description">
                            Dear Customer, please present this receipt on the day of appointment.
                            You can also view this in Schedule > <i class="bx bx-qr"></i>
                        </p>
                    </div>

                    <!-- Appointment Details -->
                    <div class="appointment-details d-flex align-items-start justify-content-between mb-2">
                        <div class="text-start">
                            <p class="label mb-1">NAME</p>
                            <p class="label mb-1">APPOINTMENT NO.</p>
                        </div>
                        <div class="text-end">
                            <p class="value mb-1">{{ $patient->name }}</p>
                            <p class="value mb-1">{{ $appointment->apponum }}</p>
                        </div>
                    </div>

                    <!-- QR Section -->
                    <div class="qr-code p-2 text-center">
                        <div id="qrImage"></div>
                        <img src="{{ asset('assets/img/Logo.png') }}" class="qr-logo" alt="">
                    </div>

                    <!-- Hidden Inputs -->
                    <input type="hidden" id="appoid" value="{{ $appointment->appoid }}">
                    <input type="hidden" id="patientname" value="{{ $patient->name }}">
                    <input type="hidden" id="doctor" value="{{ $appointment->schedule->mydoctor->name }}">
                    <input type="hidden" id="date" value="{{ $appointment->appodate }}">
                    <input type="hidden" id="time" value="{{ $appointment->start_time }} - {{ $appointment->end_time }}">

                </div>

                <div class="triangle-bottom bottom" id="triangleBottom"></div>

            </div>

            <!-- ACTION BUTTONS -->
            <div class="action-buttons my-3 text-center">
                <button id="downloadBtn" class="btn btn-primary  mb-2">Download Receipt (PNG)</button>

                <form method="POST" action="{{ route('appointment.cancelled', $appointment->appoid) }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger"
                        onclick="return confirm('Cancel this appointment?')">
                        Cancel this Appointment
                    </button>
                </form>
            </div>
        </div>
    </section>
</main>

<script src="{{asset('assets/js/qr.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

@endsection