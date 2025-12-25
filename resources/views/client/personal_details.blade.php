@extends('layouts.container-content')
@section('title', 'Personal Details')
@section('content')
<style>
    .prof-card,
    .setting-card {
        background: var(--outgoing-bg);
        color: var(--txt-color);
        border: 1px solid #e4e4e4;
        border-radius: 10px;
        margin-top: 10px;
    }
</style>
@include('layouts.base_side')

<main class="main-content shadow-sm">
    <div class="container-content">
        <section class="viewport p-3" id="personal-details-section">
            <header class="header d-flex mb-4">
                <a href="{{route('account_center')}}" class="nav-link"> <i class="fa fa-chevron-left"></i></a>
            </header>
            <div class="container-fluid">
                <h1 class="fw-bold top-heading"> <i class="fa fa-user-alt"></i> Personal Details</h1>

                <p class="text fw-normal">Unicare uses this information to verify your identity and keep our community safe.</p>
                <div class="setting-card rounded p-3">
                    <a href="{{route('editContactInfo')}}" class="nav-link d-flex align-items-center gap-3 justify-content-between">
                        <i class="fa fa-phone"></i>

                        <aside class="flex-grow-1">
                            <h1 class="sub-heading">Contact</h1>
                            <p class="text fw-normal">{{$patient->contact}} <br> {{$patient->email}}</p>
                        </aside>
                        <i class="fa fa-chevron-right"></i>
                    </a>
                    <a href="{{route('editAddress')}}" class="nav-link d-flex align-items-center gap-3 justify-content-between">
                        <i class="fa fa-globe"></i>
                        <aside class="flex-grow-1">
                            <h1 class="sub-heading">Address</h1>
                            <p class="text fw-normal">{{$patient->address}}</p>
                        </aside>
                        <i class="fa fa-chevron-right"></i>
                    </a>
                    <a href="{{route('editDob')}}" class="nav-link d-flex align-items-center gap-3 justify-content-between">
                        <i class="fa fa-cake"></i>
                        <aside class="flex-grow-1">
                            <h1 class="sub-heading">Birthday</h1>
                            <p class="text fw-normal">{{\Carbon\Carbon::parse($patient->dob)->format('F d, Y')}}</p>
                        </aside>
                        <i class="fa fa-chevron-right"></i>
                    </a>
                    <hr>
                    <a href="{{route('showAccControlPage')}}" class="nav-link d-flex align-items-center justify-content-between">
                        <aside>
                            <h1 class="sub-heading">Account Ownership and control</h1>
                            <p class="text fw-normal">Manage your data, modify your contact, deactivate or delete your account</p>
                        </aside>
                        <i class="fa fa-chevron-right"></i>
                    </a>
                </div>
                @if ($errors->any())
                <div class="text-center mt-4">
                    @foreach ($errors->all() as $error)
                    <p class="alert alert-danger">{{ $error }}</p>
                    @endforeach
                </div>
                @endif
            </div>
        </section>
    </div>
</main>
@endsection