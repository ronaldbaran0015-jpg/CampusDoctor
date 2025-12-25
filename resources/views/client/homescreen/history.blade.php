@extends('layouts.base')
@section('title', 'History')
@section('content')

<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{asset('assets/css/pop-up-menu.css')}}">
</head>
<section class="viewport p-3 mb-4" id="history-section">
  <header class="header mb-4 d-flex justify-content-between align-items-center">
    <a href="javascript:history.back()" class="nav-link">
      <i class="fa fa-chevron-left"></i>
    </a>
    <span class="mx-auto">History</span>
    <button id="menuBtn"><i class="fa fa-ellipsis-v"></i></button>
  </header>
  <!-- Menus -->
  <div class="menu" id="menu">
    <button type="button"><i class="bx bx-globe"></i><small>Select all</small></button>
    <button type="button"><i class="bx bx-trash"></i><small>Delete</small></button>
    <button type="button" id="read-aloud-btn"><i class="bx bx-filter"></i><small>Sort By</small></button></button>
  </div>

  @if($appointments->count() > 0)
  @foreach($appointments as $appointment)
  <div class="border menu-items shadow-sm p-2 mt-2 appointment-item" id="appointment-{{ $appointment->appoid }}">
    <a href="{{ route('appointments.detail', $appointment->appoid) }}" class="d-flex align-items-center gap-3 text-decoration-none">
      <div class="icon">
        @if($appointment->status === 'finished')
        <i class="fa fa-check-circle text-success fs-4"></i>

        @elseif($appointment->status === 'pending')
        <i class="fa fa-clock text-warning fs-4"></i>
        @else
        <i class="fa fa-times-circle text-danger fs-4"></i>
        @endif
      </div>

      <div class="flex-grow-1 text">
        @if($appointment->status == 'cancelled')
        <span>Appointment cancelled with </span>
        @elseif($appointment->status == 'pending')
        <span>Made an appointment with </span>
        @else
        <span>Finished an appointment with </span>
        @endif
        <h5 class="fs-6">
          @if($appointment->schedule && $appointment->schedule->mydoctor)
          Dr. {{ $appointment->schedule->mydoctor->name }}
          @else
          Doctor not available
          @endif
        </h5>
        <small>{{ \Carbon\Carbon::parse($appointment->appodate)->format('F d, Y') }}</small><br>
        <small class="fee">{{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }} -{{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}</small>
      </div>

      <div class="text">
        <i class="fa fa-chevron-right"></i>
      </div>
    </a>
  </div>
  @endforeach
  @else
  <div class="text-center">
    <img src="{{ asset('assets/svg/notfound.svg') }}" width="240px" alt="">
    <p class="text">Nothing to show in history</p>
  </div>
  @endif
</section>

{{-- 🔹 Swipe to delete using Hammer.js --}}
<script src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8/hammer.min.js"></script>
<script>
  document.querySelectorAll('.appointment-item').forEach(function(item) {
    const id = item.id.replace('appointment-', ''); // ✅ Corrected ID
    const hammer = new Hammer(item);

    hammer.on('swipeleft', function() {
      item.style.transition = 'transform 0.3s ease-out, opacity 0.3s ease-out';
      item.style.transform = 'translateX(-100%)';
      item.style.opacity = '0';

      setTimeout(() => {
        fetch(`/delete_appointments/${id}`, { // ✅ Corrected variable name (was appoid)
            method: 'DELETE',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              item.remove();

              // ✅ If no more items, show empty message
              if (document.querySelectorAll('.appointment-item').length === 0) {
                const viewport = document.querySelector('.viewport');
                const emptyDiv = document.createElement('div');
                emptyDiv.className = 'text-center';
                emptyDiv.innerHTML = `
                <img src="{{ asset('assets/svg/notfound.svg') }}" width="240px" alt="">
                <h6>Nothing to show</h6>
              `;
                viewport.appendChild(emptyDiv);
              }
            } else {
              alert('Failed to delete appointment.');
              item.style.transform = '';
              item.style.opacity = '';
            }
          })
          .catch(err => {
            console.error(err);
            alert('An error occurred.');
            item.style.transform = '';
            item.style.opacity = '';
          });
      }, 100);
    });
  });
</script>
<script>
  const menuBtn = document.getElementById('menuBtn');
  const menu = document.getElementById('menu');

  menuBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    menu.classList.toggle('show');
  });

  // Hide menu when clicking outside
  document.addEventListener('click', () => {
    menu.classList.remove('show');
  });
</script>
@endsection