@extends('layouts.include.dark')
@section('title', 'Confirm Appointment')
@section('content')

@include('layouts.base_side')
<main class="main-content shadow-sm">
  <section class="container-content" id="booking-section">
    <div class="viewport p-3">
      <header class="header mb-3">
        <a href="javascript:history.back()" class="nav-link"> <i class="fa fa-chevron-left"></i></a>
        <span class="mx-auto">Booking</span>
      </header>
      <div class="wrapper">
        <article>
          <h1 class="top-heading">Confirm Appointment</h1>
          <p class="text fw-light"><i>Please check and verify your information</i> <i class="fa fa-check-circle text-success"></i> </p>
        </article>
        <aside>
          <p class="text"><strong>Patient:</strong> {{ $patient->name }}</p>
          <p class="text"><strong>Doctor:</strong> Dr. {{ $doctor->name }}</p>
          <p class="text"><strong>Specialty:</strong> {{ $doctor->specialty->sname }}</p>

          @if($schedule)
          <p class="text"><strong>Date:</strong> {{ \Carbon\Carbon::parse($schedule->scheduledate)->format('l, d F Y') }}</p>
          <p class="text"><strong>Time Slot:</strong>
            {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}
            -
            {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
          </p>
          @endif
        </aside>

        <!-- Booking Form -->
        <form class="form" method="post" action="{{ route('booking', $doctor->docid) }}">
          @csrf
          <input type="hidden" name="schedule_id" value="{{ $schedule->scheduleid ?? '' }}">
          <input type="hidden" name="date" value="{{ $schedule->scheduledate ?? '' }}">
          <input type="hidden" name="time" value="{{ $time ?? '' }}">
          <input type="hidden" name="patientname" value="{{ $patient->name }}">
          <input type="hidden" name="doctor" value="{{ $doctor->name }}">
          <input type="hidden" name="docid" value="{{ $doctor->docid }}">
          <label for="reason" class="text fw-bold">Reason</label>
          <textarea name="reason" class="form-control rounded-0" id="reason" rows="3" placeholder="(Optional)" style="background: var(--outgoing-bg); color: var(--txt-color); resize: none;"></textarea>
          <a href="{{route('mydoctor')}}" class="btn border-secondary w-100 my-3"><span class="text">Cancel</span></a>
          <button class="btn btn-primary w-100 " onclick="return confirm('Are you sure you want to book this appointment?')">Confirm Appointment</button>

        </form>
      </div>
    </div>
  </section>
</main>

@if (session('error'))
<script>
  window.onload = () => {
    Swal.fire({
      position: "top",
      toast: true,
      showConfirmButton: false,
      timer: 2000,
      timerProgressBar: true,
      icon: "error",
      title: "{{ session('error') }}"
    });
  }
</script>
@endif
@endsection