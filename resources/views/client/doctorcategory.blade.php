@extends('layouts.container-content')
@section('title','Doctor Category')
@section('content')
<style>
    .form-control:focus {
        box-shadow: none;
        border-color: none;
    }
</style>
@include('layouts.base_side')

<main class="main-content shadow-sm">
    <div class="container-content">
<div class="viewport p-3">
    <header class="header mb-4">
        <a href="javascript:history.back()" class="nav-link"> <i class="fa fa-chevron-left"></i></a>
        <span class="mx-auto"> Doctor Category</span>
    </header>
    <div class="d-flex gap-2 search-bar mb-2">
        <div class="search-field">
            <input type="text" class="searchInput w-100" placeholder="Search doctors..." autocomplete="off">
            <i class="bx bx-search"></i>
        </div>
          <button class="btn btn-outline-primary filter-btn" type="submit">
                <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
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
    </div>

    <div class="grid-container">
         @foreach ($specialties as $spe )

        <a href="{{ route('doctor.searchdoctor', ['search' => $spe->sname]) }}" class="chip text-decoration-none">
          <span class="icon"><i class="fa fa-{{$spe->icon}}" style="color: var(--txt-color);"></i></span><small class="text">{{$spe->sname}}</small>
        </a>


        @endforeach
    </div>
</div>
</div>
</main>

@endsection