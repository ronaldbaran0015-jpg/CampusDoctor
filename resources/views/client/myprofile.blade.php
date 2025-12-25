@extends('layouts.include.dark')
@section('title','My Profile')
@section('content')
@include('layouts.base_side')
<main class="main-content shadow-sm">
  <section class="container-content" id="profile-section">
    <div class="viewport p-3 mb-2">
      <header class="header mb-3">
        <a href="{{route('myaccount')}}" class="nav-link"> <i class="fa fa-chevron-left"></i></a>
        <span class="mx-auto">My Profile</span>
      </header>
      <div class="section-card">
        <div class="text-center mb-3">
          <div class="position-relative">
            @if (!$patient->image)
            <img src="{{asset('assets/svg/man-svgrepo-com.svg')}}" class="user-img">
            @else
            <img src="{{ asset('uploads/patients/' . $patient->image) }}" class="user-img">
            @endif
          </div>
          <div class="mt-3">
            <h5 class="mb-1 user-name">{{$patient->name}}</h5>
            <p class="text mb-1 user-email">{{$patient->email}}</p>
          </div>
        </div>
        <!-- Biography -->
        <div class="mb-4 biography">
          <h6 class="sub-heading">About me</h6>
          <p class="text text">{{$patient->bio->biography ?? 'None'}}</p>
        </div>
        <h6 class="sub-heading">Completion</h6>
        <div class="profile-progress border my-3">
          <div class="card-text">
            @if($patient->getProfileCompletionPercentage() == 100)
            <div class="subtitle">Completed</div>
            @else
            <div class="subtitle">Complete your profile</div>
            @endif
            <div class="title">
              @if($patient->getProfileCompletionPercentage() == 100)
              You completed the profile <span class="fw-normal"><i class="fa fa-crown text-warning"></i> <i class="fa fa-crown text-warning"></i> <i class="fa fa-crown text-warning"> </i></span>
              @else
              Add your missing details <span class="fw-normal">→</span>
              @endif
            </div>
            <div class="description">
              This data will be helpful to your appointment applications
            </div>
          </div>
          <div class="progress-wrapper">
            <svg class="progress-ring" width="100%" height="100%">
              <circle class="bg" cx="50%" cy="50%" r="45%"></circle>
              <circle class="progress" cx="50%" cy="50%" r="45%" style="--progress: {{ $patient->getProfileCompletionPercentage() }};"></circle>
            </svg>
            <div class="progress-text">{{ $patient->getProfileCompletionPercentage() }}%</div>
          </div>
        </div>


        <div class="basic-info">
          <h6 class="sub-heading">Basic Information</h6>
          <hr class="text">
          <div class="row">

            <div class="d-flex align-items-center gap-3 col-md-4"><i class="bx bx-globe text fs-3"></i>
              <div>
                @if ($patient->address == "Not provided")
                <p class="mb-0 text"><span>Not provided</span><a href="{{route('editAddress')}}" class="link-primary"> Add new</a></p>
                @else
                <p class="mb-0 text">{{$patient->address}}</p>
                @endif
                <small class="text">Hometown</small>
              </div>
            </div>

            <div class="d-flex align-items-center gap-3 mt-3 col-md-4"><i class="bx bx-phone text fs-3"></i>
              <div>
                @if ($patient->contact == 00000000000)
                <p class="mb-0 text"><span>Not set </span><a href="{{route('editContactInfo')}}" class="link-primary"> Add new</a></p>
                @else
                <p class="mb-0 text">{{$patient->contact}}</p>

                @endif
                <small class="text">Phone Number</small>
              </div>
            </div>

            <div class="d-flex align-items-center gap-3 mt-3 col-md-4"><i class="bx bx-cake text fs-3"></i>
              <div>
                <p class="mb-0 text ">{{\Carbon\Carbon::parse($patient->dob)->format('F , d Y')}}</p>
                <small class="text">Birthday</small>
              </div>
            </div>

            <div class="d-flex align-items-center gap-3 mt-3 col-md-4"><i class="bx bx-user text fs-3"></i>
              <div>
                @if ($patient->gender == null)
                <p class="mb-0 text">Not set <a href="{{route('edit-profile')}}" class="link-primary"> Add now</a></p>
                @else
                <p class="mb-0 text">{{$patient->gender}}</p>
                @endif

                <small class="text">Gender</small>
              </div>
            </div>
          </div>
        </div>
        <a href="{{ route('edit-profile') }}" class="btn btn-primary w-100 fs-6 mt-3">Edit Profile</a>
      </div>
    </div>
  </section>

</main>

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
@endsection