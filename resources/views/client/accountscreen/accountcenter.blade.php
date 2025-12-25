@extends('layouts.container-content')
@section('title', 'Account Center')
@section('content')
<style>
    .meta-header {
        text-align: center;
        padding: 0 15px 15px;
    }

    .meta-header img {
        width: 65px;
        margin-bottom: 8px;
    }

    .meta-header h5 {
        font-weight: 600;
        margin-bottom: 8px;
    }

    .section-title {
        font-weight: 600;
        margin-top: 20px;
        font-size: 1rem;
        color: var(--txt-color);
    }

    .prof-card,
    .setting-card {
        background: var(--outgoing-bg);
        color: var(--txt-color);
        border: 1px solid #e4e4e4;
        border-radius: 10px;
        padding: 12px 15px;
        margin-top: 10px;
    }



    .prof-card:hover,
    .setting-card:hover {
        background: var(--incoming-border);
    }

    .profile-img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 10px;
    }

    .add-account {
        color: #007bff;
        text-align: center;
        display: block;
        margin-top: 10px;
        font-weight: 500;
        cursor: pointer;
    }

    .arrow {
        color: #888;
    }

    .icon-box {
        width: 36px;
        height: 36px;
        background: var(--incoming-border);
        border-radius: 50%;
        display: flex;
        align-items: center;

        justify-content: center;
        margin-right: 10px;
    }
</style>
@include('layouts.base_side')

<main class="main-content shadow-sm">
    <div class="container-content">
        <section class="viewport p-3" id="account-center-section">
            <header class="header">
                <a href="{{route('showSetting')}}" class="menu-items"> <i class="fa fa-chevron-left"></i></a>
                <span class="mx-auto">Account Center</span>
            </header><br>
            <div class="meta-container p-3">
                <div class="meta-header">
                    <img src="{{asset('assets/img/com.png')}}" alt="Meta logo">

                    <p class="text small mb-0 ">
                        Manage your account settings across Unicare
                        <a href="#" class="link-primary ">Learn more<i class="fa fa-arrow-right" style="transform: rotate(-45deg); font-size:11px""></i></a>
            </p>
        </div>
        <div>
            <p class=" section-title">Profiles
                    </p>
                    <a href="{{route('editName')}}" class="prof-card menu-items d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            @if (!$patient->image)
                            <img src="{{asset('assets/svg/man-svgrepo-com.svg')}}" class="profile-img" alt="Profile">
                            @else
                            <img src="{{ asset('uploads/patients/' . $patient->image) }}" class="profile-img" alt="Profile">
                            @endif
                            <div>
                                <span>{{$patient->name}}</span><br>
                            </div>
                        </div>
                        <i class="fa fa-chevron-right arrow"></i>
                    </a>
                </div>

                <div>
                    <p class="section-title">Account settings</p>

                    <a href="{{route('showPersonalDetailsPage')}}" class="setting-card menu-items d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="icon-box"><i class="fa fa-user"></i></div>
                            <span>Personal details</span>
                        </div>
                        <i class="fa fa-chevron-right arrow"></i>
                    </a>
                    <a href="{{route('changepassword')}}" class="setting-card menu-items d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="icon-box"><i class="fa fa-lock"></i></div>
                            <span>Password and security</span>
                        </div>
                        <i class="fa fa-chevron-right arrow"></i>
                    </a>

                    
                    <a href="{{route('changepassword')}}" class="setting-card menu-items d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="icon-box"><i class="fa fa-file-alt"></i></div>
                            <span>Export Data</span>
                        </div>
                        <i class="fa fa-chevron-right arrow"></i>
                    </a>

                    
                </div>
            </div>
        </section>
    </div>
</main>

        @endsection