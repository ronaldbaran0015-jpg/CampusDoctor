@extends('layouts.include.dark')
@section('title', 'Booking Success')
@section('content')
<link rel="stylesheet" href="{{asset('assets/css/qrcode.css')}}">
@include('layouts.base_side')

<main class="main-content shadow-sm">
    <section class="viewport p-3" id="appointment-details-section">

                <div class="receipt-container">
                    <div class="receipt" id="receiptElement">
                        <div class="triangle-top top" id="triangleTop"></div>
                        <div class="receipt-content">
                            <div class="text">
                                <h2 class="title">You made an appointment</h2>
                                <p class="reward">Successfully Made an Appointment</p>
                                <p class="description">Dear Customer Please present this receipt on the day of appointment. This receipt can be viewed in Schedule &gt; <i class="bx bx-qr"></i></p>
                            </div>
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

                            <form class="appointment-form" onsubmit="prevent(event)">
                                <input type="hidden" id="appoid" value="{{ $appointment->appoid }}">
                                <input type="hidden" id="patientname" value="{{ $patient->name }}">
                                <input type="hidden" id="doctor" value="{{ $doctor->name }}">
                                <input type="hidden" id="time" value="{{ request('time') }}">
                                <input type="hidden" id="date" value="{{ $appointment->appodate }}">
                            </form>
                        </div>
                        <div class="triangle-bottom bottom" id="triangleBottom"></div>

                    </div>
                    <div class="action-buttons my-3 text-center">
                        <button id="downloadBtn" class="btn btn-primary w-100 mb-2">Download Receipt (PNG)</button>
                        <a href="/myhome" class="btn btn-success w-100">Go Home <i class="fa fa-arrow-right text-light"></i></a>
                    </div>
                </div>
        

    </section>

</main>
<script>
    window.onload = () => {
        if (window.history.replaceState) {
            window.history.replaceState(null, null, '/myhome');
        }
    }
</script>
<script src="{{asset('assets/js/qr.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

@endsection