@extends('layouts.app')
@section('title','Failed')
@section('content')
<div class="content-wrapper px-3">
    <div class="container-fluid">
        <div class="container card shadow mx-auto p-3">
            <h1>⚠️Verification Failed</h1>
            <p class="text">{{ $message }}</p>
            <p class="text">Patient: {{ $appointment->patient->name }}</p>
            <p class="text">Time: {{ Carbon\Carbon::parse($appointment->start_time)->format('h:i a') }} - {{ Carbon\Carbon::parse($appointment->end_time)->format('h:i a') }} </p>
            <p class="text">Date: {{ Carbon\Carbon::parse($appointment->appodate)->format('F d Y') }}</p>
            @isset($appointment)
            <p><strong>Status:</strong> {{ ucfirst($appointment->status) }}</p>
            @endisset
        </div>
    </div>
</div>
@endsection