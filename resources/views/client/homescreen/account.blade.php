@extends('layouts.base')
@section('title', 'Account')
@section('content')
<section class="viewport" id="account-section">
    <div class="wrapper py-3">
        <header class="header">
            <a href="{{route('myhome')}}" class="text-decoration-none "> <i class="fa fa-home"></i></a>
            <span style="color: var(--txt-color);" n class="text-start">Account</span>
        </header><br>
        <div class="d-flex mb-3 align-item-center gap-2">
            @if (!$patient->image)
            <img src="{{asset('assets/svg/man-svgrepo-com.svg')}}" class="small-user-img">
            @else
            <img src="{{ asset('uploads/patients/' . $patient->image) }}" class="small-user-img">
            @endif
            <div>
                <h5 class="mb-1 user-name">{{$patient->name}}</h5>
                <span class="mb-1 user-email">{{$patient->email}}</span>
            </div>
        </div>
        <a href="/myprofile" class="menu-items text-decoration-none  d-flex justify-content-between align-items-center py-3 px-1">
            <i class="bx bx-user-circle fs-3"></i>
            <label class="ms-3" style="flex-grow: 1;">Profile</label>
            <div class="px-1">
                <i class=" fa fa-chevron-right"></i>
            </div>
        </a>


        <a href="/mysetting" class="menu-items text-decoration-none  d-flex justify-content-between align-items-center py-3 px-1">
            <i class="bx bx-cog fs-3"></i>
            <label class="ms-3" style="flex-grow: 1;">Settings</label>
            <div class="px-1">
                <i class=" fa fa-chevron-right"></i>
            </div>
        </a>
        <div class="menu-items text-decoration-none  d-flex justify-content-between align-items-center py-3 px-1">
            <i class="bx bx-moon fs-3" id="theme-icon"> </i>
            <label for="darkSwitch" style="flex-grow: 1;" class="ms-3" id="theme-txt"> Dark Mode</label>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="darkSwitch" />
            </div>
        </div>

        <a href="/help" class="menu-items text-decoration-none d-flex justify-content-between align-items-center py-3 px-1">

            <i class="bx bx-help-circle fs-3"></i>
            <label class="ms-3" style="flex-grow: 1;">Help</label>
            <div class="px-1">
                <i class=" fa fa-chevron-right"></i>
            </div>
        </a>

        <a href="{{route('about')}}" class="menu-items text-decoration-none d-flex justify-content-between align-items-center py-3 px-1">

            <i class="bx bx-info-circle fs-3"></i>
            <label class="ms-3" style="flex-grow: 1;">About</label>
            <div class="px-1">
                <i class=" fa fa-chevron-right"></i>
            </div>
        </a>
        <form method="POST" action="{{ route('logout') }}" class="menu-items d-flex justify-content-between align-items-center py-3 px-1 text-decoration-none" onsubmit="confirmAction(event)">
            @csrf
            <i class="bx bx-power-off fs-3"></i>
            <input type="radio" name="opt" checked value="logout" style="display: none;" id="logout">

            <button type="submit" class="ms-3  border-0" style="flex-grow: 1; text-align: start; background:transparent; color:var(--txt-color);"><label> Logout</label></button>
            <div class="px-1">
                <i class=" fa fa-chevron-right"></i>
            </div>
        </form>
    </div>
</section>
<script>
    function confirmAction(event) {
        event.preventDefault();
        let selectedOption = document.querySelector('input[name="opt"]:checked').value;

        let title = '';

        if (selectedOption === 'logout') {
            title = 'Are you sure you want to logout your account?';
        }
        Swal.fire({
            text: title,
            icon: 'warning',

            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            backdrop: true

        }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit();
            }
        });
    }
</script>
@endsection