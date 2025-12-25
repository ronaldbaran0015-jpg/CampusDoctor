@extends('layouts.include.dark')
@section('title','Doctors')
@section('content')
<link rel="stylesheet" href="{{asset('assets/css/pop-up-menu.css')}}">
<section class="container-content doctor-info-section">
  <div class="viewport p-3">
    <header class="header">
      <a href="javascript:history.back()" class="nav-link"> <i class="fa fa-chevron-left"></i></a>
      <span class="mx-auto">Doctor Info</span>
      <button id="menuBtn"><i class="fa fa-ellipsis-v"></i></button>
    </header>
    <div class="menu" id="menu">
      <button type="button" class="fs-6"><i class="bx bx-heart"></i><small>Add to favorite</small></button>
      <button type="button" class="fs-6"><i class="bx bx-phone"></i><small>Contact</small></button>
    </div>
    @csrf
    <div class="section-card py-3">
      <div class="doctor-info">
        <div class="w-100">
          <div class="d-flex align-items-center mb-3">
            @if (!$doctor->image)
            <img src="{{ asset('assets/svg/doctor-svgrepo-com.svg') }}" class="doctor-img me-3 border">
            @else
            <img src="{{ asset('uploads/doctors/' . $doctor->image) }}" class="doctor-img me-3 border">
            @endif
            <div class="doc-info">
              <h5 class="mb-1 doctor-name">Dr. {{$doctor->name}}</h5>
              <p class="mb-1 doctor-skill">{{$doctor->specialty->sname}}</p>
              <div class="d-flex align-items-center">
                @for($i = 1; $i <=5; $i++)
                  @if ($i <=$average)
                  <span class="text-warning">&#9733;</span>
                  @elseif ($i - $average < 1 && $i - $average> 0)
                    <span class="text-warning">&#9734;</span>
                    @else
                    <span class="text-warning">&#9734;</span>
                    @endif
                    @endfor
                    <small class="rating ms-1">{{number_format($average, 1)}}</small>
              </div>
            </div>
          </div>
          <div class="cards-row gap-2">
            <div class="info-card">
              <div class="icon"><i class="bx bx-brain text-primary"></i></div>
              <div class="meta">5 yrs+</div>
              <div class="label text">Experience</div>
            </div>
            <div class="info-card">
              <div class="icon"><i class="bx bx-group text-success"></i></div>
              <div class="meta">1000+</div>
              <div class="label text">Patients</div>
            </div>
            <a href="{{route('rate.show', $doctor->docid)}}" class="info-card ">
              <div class="icon"><i class="bx bx-star text-warning"></i></div>
              <div class="meta">{{number_format($average, 1)}}</div>
              <div class="label text">Ratings</div>
            </a>
          </div>
          <!-- Specialties -->
          <div class="mb-3">
            <button type="button" class="specialty-badge">{{$doctor->specialty->sname}}</button>
          </div>
          <!-- Biography -->
          <div class="mb-4 biography">
            <h1 class="sub-heading">Doctor Biography</h6>
              <p class="doc-bio text">{{$doctor->bio->biography ?? 'None'}}.</p>
          </div>
        </div>
        <!-- Schedules -->
        <form class="w-100" action="{{ route('booking', $doctor->docid) }}" method="GET">
          <div>
            <div class="d-flex justify-content-between mb-3 align-items-center">
              <h6 class="sub-heading m-0 flex-grow-1">Choose schedule</h6>

              <select id="monthSelect" class="sub-heading outline-0 me-2" style="background: var(--outgoing-bg);">
                @foreach ($schedulesByMonth as $monthYear => $items)
                <option value="{{ $monthYear }}">{{ $monthYear }}</option>
                @endforeach
              </select>

              <button type="button" style="background: var(--outgoing-bg);" class="border-0 outline-0 m-0 p-0" id="switch-view">
                <i class="bx bx-calendar fs-1 text"></i>
              </button>
            </div>
            <!-- Choose schedule dates -->
            <div class="d-flex text-center mt-2 gap-3 schedule list-view" id="simpleView">
              @if ($schedulesByDate->isNotEmpty())
              @php $first = true; @endphp
              @foreach ($schedulesByDate as $date => $items)
              @if (\Carbon\Carbon::parse($date)->gte(\Carbon\Carbon::today()))
              <label class="schedule-date" data-month="{{ \Carbon\Carbon::parse($date)->format('F Y') }}">
                <input type="radio"
                  name="schedule_date"
                  value="{{ $date }}"
                  hidden
                  required
                  {{ $first ? 'checked' : '' }}>
                @php $first = false; @endphp

                <span>{{ \Carbon\Carbon::parse($date)->format('d') }}</span>
                <p class="text">{{ \Carbon\Carbon::parse($date)->format('l') }}</p>
              </label>
              @endif
              @endforeach
              @else
              <span class="text-warning">No schedules available</span>
              @endif

            </div>
            <!-- CALENDAR VIEW -->
            <div id="calendarView" class="d-none">
              @include('client.component.calendar', ['schedulesByDate' => $schedulesByDate])
            </div>

            <!-- Choose Times -->
            <div class="my-2">
              <h6 class="sub-heading">Choose Time</h6>

              <!-- Tabs -->
              <div class="d-flex mb-3">
                <button type="button" class="tab-btn active" data-target="Morning">Morning</button>
                <button type="button" class="tab-btn" data-target="Afternoon">Afternoon</button>
                <button type="button" class="tab-btn" data-target="Evening">Evening</button>
              </div>
              <!-- Schedules by session -->
              <h6 class="text">Time available</h6>

              <div class="d-flex flex-wrap gap-3 schedule-list">
                <!-- Time slots -->

                @foreach ($scheduleSlots as $slot)
                <label class="schedule-time {{ $slot['isDisabled'] || $slot['isFullyBooked'] ? 'disabled' : '' }}"
                  data-session="{{ $slot['session'] }}"
                  data-date="{{ $slot['date'] }}"
                  data-month="{{ $slot['month'] }}">

                  <input type="radio"
                    name="schedule_id"
                    value="{{ $slot['id'] }}"
                    data-time="{{ $slot['raw_start'].'-'.$slot['raw_end'] }}"
                    hidden
                    required
                    {{ $slot['isDisabled'] || $slot['isFullyBooked'] ? 'disabled' : '' }}>

                  <span>{{ $slot['start'] }} - {{ $slot['end'] }}</span>

                  <small class="mt-2 text">
                    Booked: <i class="bx bx-user"></i> {{ $slot['available'] }}
                    @if ($slot['isFullyBooked'])
                    <span class="text-danger">Fully booked</span>
                    @endif
                  </small>

                  @if ($slot['isDisabled'])
                  <small class="text-warning">Time has already passed</small>
                  @endif
                </label>
                @endforeach
              </div>

            </div>

          </div>
          <!-- Book Button -->
          @if ($doctor->hasSchedule->isNotEmpty())
          <button type="submit" id="book-btn" class="book-btn p-2 mb-3 fs-6">Book Appointment</button>
          @else
          <button type="btn" disabled class="book-btn btn btn-secondary mb-3 p-2 fs-6">Cannot access</button>
          @endif
        </form>
      </div>
    </div>
  </div>
</section>
<script src="{{asset('assets/js/tab.js')}}"></script>
<script src="{{asset('assets/js/pop-up-menu.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{asset('assets/js/jquery-1.10.2.js')}}"></script>
<script>
  $(document).ready(function() {
    // On schedule selection
    $('input[name="schedule_id"]').change(function() {
      var scheduleId = $(this).val();
      var btn = $('#book-btn');

      // AJAX call to check availability
      $.get('/schedule/check-availability/' + scheduleId, function(data) {
        if (data.isFullyBooked) {
          btn.prop('disabled', true);
          btn.text('Cannot Book - Fully Booked');
        } else {
          btn.prop('disabled', false);
          btn.text('Book Appointment');
        }
      });
    });

    // Trigger change on page load for pre-selected schedule
    $('input[name="schedule_id"]:checked').trigger('change');
  });
</script>
<script>
  $(document).ready(function() {
    // Month filter
    $('#monthSelect').on('change', function() {
      var selectedMonth = $(this).val();
      $('.schedule-date').each(function() {
        var scheduleMonth = $(this).data('month');
        if (selectedMonth === 'all' || scheduleMonth === selectedMonth) {
          $(this).show();
        } else {
          $(this).hide();
          $(this).find('input[name="schedule_date"]').prop('checked', false);
        }
      });

      // Auto-select first visible schedule
      var firstVisible = $('.schedule-date:visible').first();
      if (firstVisible.length) {
        firstVisible.find('input[name="schedule_date"]').prop('checked', true).trigger('change');
      }
    });

    // Trigger change on page load
    $('#monthSelect').trigger('change');
    $('.schedule-time').each(function() {
      var scheduleMonth = $(this).data('month');
      if (scheduleMonth === selectedMonth) {
        $(this).show();
      } else {
        $(this).hide();
        $(this).find('input[name="schedule_id"]').prop('checked', false);
      }
    });

  });
</script>
@endsection