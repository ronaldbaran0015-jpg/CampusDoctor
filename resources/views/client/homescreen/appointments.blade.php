@extends('layouts.base')
@section('title', 'Schedules')
@section('content')
<style>
  .tab-pane {
    display: none;
    color: var(--txt-color);
  }

  .tab-pane.active {
    display: block;

  }

  .prox-tab-btn.active {
    background-color: #407ef8;
    color: #fff;
  }
</style>
<section class="viewport p-3" id="schedule-section">
  <div class="wrapper">
    <header class="header mb-4">
      <a href="javascript:history.back()" class="nav-link">
        <i class="fa fa-chevron-left"></i>
      </a>
      <span class="mx-auto">Appointments</span>
    </header>
    <div class="tab-heading d-flex mb-5 p-0 border">
      <button class="prox-tab-btn" onclick="openTab(event, 'past')">Past</button>
      <button class="prox-tab-btn active" onclick="openTab(event, 'upcoming')">Upcoming</button>
      <button class="prox-tab-btn" onclick="openTab(event, 'cancelled')">Canceled</button>
    </div>
    <div class="tab-content my-schedule">
      <div id="past" class="tab-pane">
        @php($pastAppointments = $appointments->whereIn('status', ['finished', 'missed']))
        @if($pastAppointments->count() > 0)
        @foreach($pastAppointments as $appointment)
        <div class="appointment my-3">
          <div class="border-bottom border-muted py-2">
            <div class="doc-item">
              <div class="profile">
                @if (!$appointment->schedule->mydoctor->image)
                <img src="{{asset('assets/svg/doctor-svgrepo-com.svg')}}" class="doc-photo">
                @else
                <img src="{{asset('uploads/doctors/' . $appointment->schedule->mydoctor->image)}}" class="doc-photo">

                @endif
              </div>
              <div class="doc-info text-start">
                <h6>Dr. {{ $appointment->schedule->mydoctor->name }}</h6>
                <small class="status-badge success">{{\Carbon\Carbon::parse( $appointment->appodate)->format('F d, Y') }}</small><br>
                <span class="status-badge warning">{{\Carbon\Carbon::parse( $appointment->start_time)->format('h:i') }}-{{\Carbon\Carbon::parse( $appointment->end_time)->format('h:i A') }}</span>
              </div>
              <div class="text-end text-capitalize">
                @if($appointment->status == 'missed')
                <span class="status-badge error">
                  {{$appointment->status}}
                </span>
                @else
                <span class="status-badge primary">
                  {{$appointment->status}}
                </span>
                @endif
              </div>


            </div>
          </div>

        </div>
        @endforeach
        @else
        <div class="my-schedule">
          <img src="{{asset('assets/svg/undraw_no-data_ig65.svg')}}" width="200" alt="">
          <p class="text">Nothing to show in past</p>
        </div>
        @endif
      </div>
      <div id="upcoming" class="tab-pane active">
        @if($appointments->where('status', 'pending')->count() > 0)
        @foreach($appointments->where('status', 'pending') as $appointment)
        <div class="appointment my-3">
          <div class="border-bottom border-muted py-2">
            <div class="doc-item">
              <div class="profile">
                @if (!$appointment->schedule->mydoctor->image)
                <img src="{{asset('assets/svg/doctor-svgrepo-com.svg')}}" class="doc-photo">
                @else
                <img src="{{asset('uploads/doctors/' . $appointment->schedule->mydoctor->image)}}" class="doc-photo">

                @endif
              </div>

              <div class="doc-info text-start">
                <h6>Dr. {{ $appointment->schedule->mydoctor->name }}</h6>
                <small class="status-badge warning">{{\Carbon\Carbon::parse( $appointment->appodate)->format('F d, Y') }}</small><br>
                <span class="status-badge success">{{\Carbon\Carbon::parse( $appointment->start_time)->format('h:i') }} - {{\Carbon\Carbon::parse( $appointment->end_time)->format('h:i A') }}</span>
              </div>
              <div class="text-end">
                <a href="{{ route('appointments.detail', $appointment->appoid) }}" class="btn btn-primary"><i class="fa fa-qrcode"></i></a>
              </div>

            </div>
          </div>

        </div>
        @endforeach
        @else
        <div class="my-schedule" id="">
          <img src="{{asset('assets/svg/undraw_no-data_ig65.svg')}}" width="200" alt="">
          <p class="text">Nothing to show in upcoming</p>
             <a href="{{route('mydoctor')}}" class="btn btn-primary link">+ Choose a Doctor</a>
          
        </div>
        @endif
      </div>
      <div id="cancelled" class="tab-pane">
        @if($appointments->where('status', 'cancelled')->count() > 0)
        @foreach($appointments->where('status', 'cancelled') as $appointment)
        <div class="appointment my-3">
          <div class="border-bottom border-muted py-2">
            <div class="doc-item">
              <div class="profile">
                @if (!$appointment->schedule->mydoctor->image)
                <img src="{{asset('assets/svg/doctor-svgrepo-com.svg')}}" class="doc-photo">
                @else
                <img src="{{asset('uploads/doctors/' . $appointment->schedule->mydoctor->image)}}" class="doc-photo">

                @endif
              </div>
              <div class="doc-info text-start">
                <h6>Dr. {{ $appointment->schedule->mydoctor->name }}</h6>
                <small class="status-badge warning">{{\Carbon\Carbon::parse( $appointment->appodate)->format('F d, Y') }}</small><br>
                <span class="status-badge success">{{\Carbon\Carbon::parse( $appointment->start_time)->format('h:i') }}-{{\Carbon\Carbon::parse( $appointment->end_time)->format('h:i A') }}</span>
              </div>

              <div class="text-end text-capitalize">
                <span class="status-badge error">
                  {{$appointment->status}}
                </span>
              </div>
            </div>
          </div>

        </div>
        @endforeach
        @else
        <div class="my-schedule">
          <img src="{{asset('assets/svg/undraw_no-data_ig65.svg')}}" width="200" alt="">
          <p class="text">Nothing to show in cancelled</p>
        </div>
        @endif
      </div>
    </div>
  </div>
</section>


<script>
  function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tab-pane");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].classList.remove("active");
    }
    tablinks = document.getElementsByClassName("prox-tab-btn");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].classList.remove("active");
    }
    document.getElementById(tabName).classList.add("active");
    evt.currentTarget.classList.add("active");
  }
</script>

@endsection