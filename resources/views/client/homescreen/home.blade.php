@extends('layouts.base')
@section('title','Home')
@section('content')
<section class="viewport" id="home-section">
  <div class="home-header">
    <header class="d-flex justify-content-between align-items-center mt-3">
      <div class="d-flex align-items-center gap-2">
        @if (!$patient->image)
        <a href="/myprofile"><img src="{{asset('assets/svg/man-svgrepo-com.svg')}}" class="small-user-img"></a>
        @else
        <a href="/myprofile"><img src="{{ asset('uploads/patients/' . $patient->image) }}" class="avatar" alt=""></a>
        @endif
        <div>
          <small class="text">Welcome</small><br>
          <strong class="sub-heading">{{$patient->name}}</strong>
        </div>
      </div>
      <div class="d-flex header-icon mb-0">
        <a href="{{route('message.show')}}" class="notification text-dark trailing"><i class="bx bx-envelope fs-2 mx-2 icon"></i>@if (!empty($message_count))<span class="badge">{{$message_count}}</span>@endif</a>
        @if ($upcoming)
        <a href="{{route('notif.show')}}" class="notification text-dark trailing"><i class="bx bx-bell fs-2 icon"></i><small class="badge">{{$upcomingCount}}</small></a>
        @else
        <a href="{{route('notif.show')}}" class="notification text-dark trailing"><i class="bx bx-bell fs-2 icon"></i> <small class="badge"></small></a>
        @endif
      </div>
    </header>
  </div>
  <!-- Mobile Overlay -->
  <form action="{{ route('doctor.searchdoctor') }}" method="GET" name="form_search" class="d-flex ">
    <div class="search-overlay" id="mobileSearchOverlay">
      <div class="close-btn" id="closeSearch"><i class="fas fa-times"></i></div>
      <input type="search" name="search" value="{{ request('search') }}" maxlength="25" id="mobileSearchInput" placeholder="Search by name or specialization">
    </div>
  </form>

  <div class="row mt-3">
    <div class="hero col-md-6">
      <h2>Looking for<br>desired doctor?</h2>
      <button class="searchToggle"><i class="bx bx-search"></i> Search for</button>
      <img src="{{asset('assets/img/foc.png')}}" class="doctor-hero-img">
    </div>
    <div class="col-md-6">
      <div class="section-title ">
        <span class="sub-heading">Find your doctor</span>
        <div class="d-flex justify-content-end align-items-center text">
          <a href="{{route('doctor.category')}}" class="nav-link">See all</a>
          <i class="bx bx-chevron-right fs-3"></i>
        </div>
      </div>
      <div class="d-flex justify-content-between gap-3 fs-6 no-scroll" style="overflow-y: auto;">
        @foreach ($specialties as $spe )

        <a href="{{ route('doctor.searchdoctor', ['search' => $spe->sname]) }}" class="chip text-decoration-none">
          <span class="icon"><i class="fa fa-{{$spe->icon}}" style="color: var(--txt-color);"></i></span><small class="text">{{$spe->sname}}</small>
        </a>


        @endforeach



      </div>
    </div>
  </div>

  @if ($appointments->where('status', 'pending')->count() > 0)
  <div class="section-title">
    <span class="sub-heading">Upcoming Appointment</span>
    <div class="d-flex justify-content-end align-items-center text">
      <a href="#" class="nav-link">See all</a>
      <i class="bx bx-chevron-right fs-3"></i>
    </div>
  </div>
  @endif
  <div class="d-flex gap-3" style="overflow-y: scroll; margin: 0; padding: 0;">
    @php
    $showids = [];
    @endphp

    @forelse ($appointments as $appointment)
    @php

    $docId = $appointment->schedule->mydoctor->docid;
    @endphp

    {{-- Check: only show if status is pending or this doctor hasn't been displayed yet --}}
    @if ($appointment->status == 'pending' && !in_array($docId, $showids))

    <div class="hero flex-shrink-0 w-100" style="margin: 0;">
      <div class="d-flex justify-content-between gap-3">
        @if (!$appointment->schedule->mydoctor->image)
        <img src="{{asset('assets/svg/doctor-svgrepo-com.svg')}}" class="doctor-avatar">
        @else
        <img src="{{asset('uploads/doctors/'. $appointment->schedule->mydoctor->image)}}" class="doctor-avatar">
        @endif
        <div class="doc-info">
          <h6>
            Dr. {{ $appointment->schedule->mydoctor->name }}
          </h6>
          <small class="">Cardiology</small><br>
        </div>
        <a class="trailing chat-link" href="{{route('chat.show', $appointment->schedule->mydoctor->docid)}}">
          <i class="bx bx-message icon bg-light border-0 text-dark"></i>
        </a>
      </div>
      <hr>
      <div class="d-flex gap-3 mt-2">
        <div>
          <i class="bx bx-calendar"></i>
          <small class="">{{\Carbon\Carbon::parse($appointment->appodate)->format('M d Y')}}</small><br>
        </div>
        <div>
          <i class="bx bx-alarm"></i>
          <small class="">{{\Carbon\Carbon::parse($appointment->start_time)->format('h:i a')}} - {{\Carbon\Carbon::parse($appointment->end_time)->format('h:i a')}}</small><br>
        </div>
      </div>
      <div class="d-flex  gap-3 mt-2">
        <form method="POST" action="{{ route('appointment.cancelled', $appointment->appoid) }}">
          @csrf
          <button type="submit" class="btn btn-light  text-danger" style="border-radius: 24px;"
            onclick="return confirm('Cancel this appointment?')">
            Cancel
          </button>
        </form>
        <a href="{{route('docinfo', $appointment->schedule->mydoctor->docid)}}" class="btn btn-outline bg-primary text-light" style="border-radius: 24px;">View Profile</a>
      </div>
    </div>

    {{-- Add doctor id to the shown list --}}
    @php
    $showids[] = $docId;
    @endphp
    @endif
    @empty

    @endforelse
  </div>
  <div class="section-title">
    <span class="sub-heading">Popular Doctors</span>
    <div class="d-flex justify-content-end align-items-center text">
      <a href="{{route('mydoctor')}}" class="nav-link">See all</a>
      <i class="bx bx-chevron-right fs-3"></i>
    </div>
  </div>
  <div id="doctor-list" class="doctor-list">
    @foreach ($doctors as $doc )
    <div class="doc-card">
      <div class="doc-item">
        <div class="profile">
          @if (!$doc->image)
          <img src="{{ asset('assets/svg/doctor-svgrepo-com.svg') }}" class="doc-photo">
          @else
          <img src="{{ asset('uploads/doctors/' . $doc->image) }}" class="doc-photo">
          @endif

          @if ($doc->status =='active')
          <span class="doctor-status-badge active-badge"></span>
          @elseif($doc->status =='busy')
          <span class="doctor-status-badge busy-badge"></span>
          @elseif($doc->status =='offline')
          <span class="doctor-status-badge offline-badge"></span>
          @elseif($doc->status =='not available')
          <span class="doctor-status-badge not-available-badge"></span>
          @endif
        </div>
        <div class="doc-info">
          <h6 class="sub-heading">{{$doc->name}}</h6>
          <small class="doctor-skill">{{$doc->specialty->sname}}</small><br>
          <span class="rating"><i class="fa fa-star"></i> {{ number_format((float) ($doc->reviews_avg_rating ?? 0), 1) }} ({{ $doc->reviews_count ?? 0 }})</span>
        </div>
        <div class="text-center">
          @if ($doc->status =='active')
          <div class="status text-success">{{$doc->status}}</div>
          @elseif ($doc->status =='offline')
          <div class="status text-dark">{{$doc->status}}</div>
          @elseif ($doc->status =='busy')
          <div class="status text-warning">{{$doc->status}}</div>
          @elseif ($doc->status =='not available')
          <div class="status text-danger">{{$doc->status}}</div>
          @endif
          @if ($doc->status =='not available')
          <button class="btn btn-primary btn-sm" disabled>Book now</button>
          @else
          <a href="{{route('docinfo', $doc->docid)}}" class="btn btn-primary btn-sm">Book now</a>

          @endif

        </div>
      </div>
    </div>
    @endforeach
  </div>
</section>
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
<script src="{{asset('assets/js/search.js')}}"></script>


@endsection