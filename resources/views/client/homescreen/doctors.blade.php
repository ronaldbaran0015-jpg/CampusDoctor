@extends('layouts.base')
@section('title','Doctors')
@section('content')

<section class="viewport p-3" id="doctor-section">
  <header class="header mb-4">
    <a href="javascript:history.back()" class="nav-link"> <i class="fa fa-chevron-left"></i></a>
    <span class="mx-auto">Doctors</span>
       <button class="border-0 filter-btn" type="button" data-bs-toggle="modal"
      data-bs-target="#filterModal">
      <svg width="25px" height="25px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <title>Filter</title>
        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
          <g id="Filter">
            <rect id="Rectangle" fill-rule="nonzero" x="0" y="0" width="24" height="24">
            </rect>
            <line x1="4" y1="5" x2="16" y2="5" id="Path" stroke-width="2" stroke-linecap="round">

            </line>
            <line x1="4" y1="12" x2="10" y2="12" id="Path" stroke-width="2" stroke-linecap="round">

            </line>
            <line x1="14" y1="12" x2="20" y2="12" id="Path" stroke-width="2" stroke-linecap="round">

            </line>
            <line x1="8" y1="19" x2="20" y2="19" id="Path" stroke-width="2" stroke-linecap="round">

            </line>
            <circle id="Oval" stroke-width="2" stroke-linecap="round" cx="18" cy="5" r="2">

            </circle>
            <circle id="Oval" stroke-width="2" stroke-linecap="round" cx="12" cy="12" r="2">

            </circle>
            <circle id="Oval" stroke-width="2" stroke-linecap="round" cx="6" cy="19" r="2">

            </circle>
          </g>
        </g>
      </svg>
    </button>
  </header>
  <!-- Search Bar -->
  <form action="{{ route('doctor.searchdoctor') }}" method="GET" class="d-flex gap-2 search-bar mb-2">
    <div class="search-field">
      <input type="text" name="search" value="{{ request('search') }}" maxlength="25" class="form-control searchInput w-100" required placeholder="Search doctor, specialty">
      <i class="bx bx-search"></i>
    </div>
    <button class="btn btn-primary search-btn"><i class="fa fa-search" style="width: 20px; height: 20px;"></i></button>
 
  </form>

  <!-- <form class="d-flex gap-2 search-bar mb-2" onsubmit="event.preventDefault();">
    <div class="search-field">
      <input type="text" id="searchDoctor" maxlength="25"
        class="form-control searchInput w-100"
        placeholder="Search doctor, specialty">
      <i class="bx bx-search"></i>
    </div>
  </form> -->
  <!-- <div id="doctor-list"  class="doctor-list"  style="margin-bottom:80px;" >
    @include('partials.doctor_results', ['doctors' => $doctors])
  </div> -->
  <!-- Displaying Doctors -->
  <div id="doctor-list" class="doctor-list" style="margin-bottom:100px;">
    @forelse ($doctors as $doc)
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
          <h6>{{ $doc->name }}</h6>
          <small class="doctor-skill">{{ $doc->specialty->sname }}</small><br>
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
          <a href="{{ route('docinfo', $doc->docid) }}" class="btn btn-primary btn-sm">Book now</a>
          @endif
        </div>
      </div>
    </div>
    @empty
    <div class="d-flex flex-column align-items-center justify-content-center text-center w-100" style="min-height: 50vh;">
      <img src="{{asset('assets/svg/undraw_empty_4zx0.svg')}}" width="200px" alt="Empty image">
      <p class="text mt-3">No doctors found matching your search.</p>
    </div>
    @endforelse
  </div>
</section>
<form method="GET" action="{{ route('mydoctor') }}">

  <div class="modal fade" id="filterModal" tabindex="-1">
    <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title fw-bold">Filter Doctors</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <!-- Specialty -->
          <div class="mb-3">
            <label class="fw-semibold mb-2">Specialty</label>
            <div class="d-flex flex-wrap gap-2">

              @foreach($specialties as $specialty)
              <input type="checkbox"
                class="btn-check"
                name="specialties[]"
                value="{{ $specialty->id }}"
                id="spec{{ $specialty->id }}"
                {{ in_array($specialty->id, request('specialties', [])) ? 'checked' : '' }}>

              <label class="btn btn-outline-primary btn-sm rounded-pill"
                for="spec{{ $specialty->id }}">
                {{ $specialty->sname }}
              </label>
              @endforeach

            </div>
          </div>

          <!-- Availability -->
          <div class="mb-3">
            <label class="fw-semibold mb-2">Availability</label>
            <select class="form-select" name="availability">
              <option value="">Any</option>
              <option value="today" {{ request('availability')=='today'?'selected':'' }}>Today</option>
              <option value="week" {{ request('availability')=='week'?'selected':'' }}>This Week</option>
              <option value="morning" {{ request('availability')=='morning'?'selected':'' }}>Morning</option>
              <option value="afternoon" {{ request('availability')=='afternoon'?'selected':'' }}>Afternoon</option>
            </select>
          </div>

          <!-- Rating -->
          <div class="mb-3">
            <label class="fw-semibold mb-2">Rating</label>
            <select class="form-select" name="rating">
              <option value="">Any</option>
              <option value="4.5" {{ request('rating')=='4.5'?'selected':'' }}>⭐ 4.5+</option>
              <option value="4.0" {{ request('rating')=='4.0'?'selected':'' }}>⭐ 4.0+</option>
              <option value="3.5" {{ request('rating')=='3.5'?'selected':'' }}>⭐ 3.5+</option>
            </select>
          </div>

        </div>

        <div class="modal-footer d-flex justify-content-between">
          <a href="{{ route('mydoctor') }}" class="btn btn-outline-secondary w-50">
            Reset
          </a>
          <button type="submit" class="btn btn-primary w-50">
            Apply
          </button>
        </div>

      </div>
    </div>
  </div>

</form>
@endsection