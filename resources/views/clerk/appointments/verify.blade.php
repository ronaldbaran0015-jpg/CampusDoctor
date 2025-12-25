@extends('layouts.app')
@section('title','Success')
@section('content')
<div class="container mt-5">
    <div class="card shadow p-4">
        <h3 class="text-success mb-3">Appointment Verification</h3>
        <p><strong>Patient:</strong> {{ $appointment->patient->name ?? 'N/A' }}</p>
        <p><strong>Doctor:</strong> {{ $appointment->doctor->name ?? 'N/A' }}</p>
        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appodate)->format('F d, Y') }}</p>
        <p><strong>Time:</strong> {{ $appointment->start_time }} - {{ $appointment->end_time }}</p>
        <p><strong>Status:</strong>
            <span class="badge bg-{{ $appointment->status === 'finished' ? 'success' : 'warning' }}">
                {{ ucfirst($appointment->status) }}
            </span>
        </p>

        @if ($appointment->status === 'pending')
        <form action="{{ route('appointments.finish', $appointment->appoid) }}" method="POST">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-success w-100 mt-3">
                ✅ Mark as Finished
            </button>
        </form>
        @else
        <div class="alert alert-info mt-3">This appointment is marked as finished.</div>
        <a href="javascript:history.back()" class="btn">Go Back</a>

        @endif
    </div>


</div>
@endsection