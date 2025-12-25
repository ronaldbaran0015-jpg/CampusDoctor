@extends('layouts.container-content')
@section('title', 'Settings')
@section('content')
@include('layouts.base_side')

<main class="main-content shadow-sm">
    <div class="container-content">

        <section class="viewport p-3" id="setting-section">
            <header class="header">
                <a href="{{route('myaccount')}}" class="nav-link"> <i class="fa fa-chevron-left"></i></a>
                <span class="mx-auto">Settings</span>
            </header><br>
            <a href="/account_center" class="menu-items d-flex justify-content-between align-items-center py-3 px-1">
                <i class=" fa fa-user-circle fs-5"></i>
                <label class="ms-3" style="flex-grow: 1;">Account Center</label>
                <div class="px-1">
                    <i class=" fa fa-chevron-right"></i>
                </div>
            </a>
          

        </section>
    </div>
</main>

@endsection