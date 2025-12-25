@extends('layouts.app')
@section('title', 'Update Staff Info')
@section('content')


<div class="content-wrapper">
    <header class="header mb-3 p-3">
        <a href="javascript:history.back()" class="nav-link"> <i class="fa fa-chevron-left text"></i></a>
        <span class="mx-auto">Edit</span>
    </header>
    <div class="document">
        <div class="record-paper">

            <h4 class="label top-heading"> Edit Specializiation/Expertise</h4>
            <hr class="divider">
            <div class="">
                <!-- LEFT COLUMN -->
                <div class="left-col">
                    <div class="details mt-3">

                    </div>
                </div>
                <div class="">
                    <form action="{{route('specialty.update', $specialty->id)}}" method="post">

                        @csrf
                        @method('PATCH')

                        <div class="details-line">
                            <label class="label">Name:</label>
                            <input type="text" name="sname" class="value px-2 fs-6 form-control" value="{{$specialty->sname}}" />
                        </div>
                        <div class="details-line">
                            <label class="icon">Icon:</label>
                            <select name="icon" id="icon" class="form-control form-select">
                                <option value="">Select Icon</option>
                                <option value="heart-pulse">Heart</option>
                                <option value="brain">Brain</option>
                                <option value="ribbon">Ribbon</option>
                                <option value="child">Child</option>
                                <option value="user">User</option>
                                <option value="bone">Bone</option>
                                <option value="female">Female</option>
                                <option value="stethoscope">Stethoscope</option>
                                <option value="eye">Eye</option>
                                <option value="body">Body</option>
                                <option value="user">User</option>
                                <option value="medkit">Medkit</option>
                                <option value="syringe">Syringe</option>
                                <option value="laptop-medical">Laptop Medical</option>
                                <option value="x-ray">X Ray</option>
                                <option value="toilet">Toilet</option>
                                <option value="tooth">Toilet</option>
                                <option value="kidney">Kidney</option>
                                <option value="thermometer">Thermometer</option>
                                <option value="stomach">Stomach</option>
                                <option value="lungs">Lungs</option>
                                <option value="hand-holding-medical">Hand Holding Medical</option>
                                <option value="blood-drop">Blood Drop</option>
                            </select>
                        </div>

                        <button class="btn btn-primary my-3">Save</button>
                        @if ($errors->any())
                        <div>

                            @foreach ($errors->all() as $error)
                            <span class="text-center">{{ $error }}</span>
                            @endforeach
                        </div>

                        @endif
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection