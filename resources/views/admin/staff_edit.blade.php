@extends('layouts.app')
@section('title', 'Update Staff Info')
@section('content')


<div class="content-wrapper">
    <header class="header mb-3 p-3">
        <a href="javascript:history.back()" class="nav-link"> <i class="fa fa-chevron-left text"></i></a>
        <span class="mx-auto">Edit Staff</span>
    </header>
    <div class="document">
        <div class="record-paper">

            <h4 class="label top-heading"> Staff Details</h4>
                <hr class="divider">
                <div class="">
                    <!-- LEFT COLUMN -->
                    <div class="left-col">
                        <div class="details mt-3">
                            <div class="d-flex align-items-center gap-3 mb-5">
                                @if (!$staff->staffimage)
                                <img id="preview" src="{{ asset('assets/img/clerk_10487891.png') }}" width="100" alt="staff default image">
                                @else
                                <img id="preview" src="{{ asset('uploads/staff/' . $staff->staffimage ) }}" width="100" alt="">
                                @endif
                            </div>

                        </div>
                    </div>
                    <div class="">
                        <form action="{{route('staffs.update', $staff->staffid)}}" method="post" enctype="multipart/form-data">

                            @csrf
                            <input type="file" id="imageInput" class="form-control" name="staffimage" accept="image/*" onchange="previewImage(event)">

                            <div class="details-line">
                                <label class="label">Name:</label>
                                <input type="text" name="staffname" class="value px-2 fs-6 form-control" value="{{$staff->staffname}}" />
                            </div>
                            <div class="details-line">
                                <label class="label">Email:</label>
                                <input type="email" name="staffemail" class="value px-2 fs-6 form-control" value="{{$staff->staffemail}}" />
                            </div>
                            <div class="details-line">
                                <label class="label">Contact:</label>
                                <input type="tel" name="staffcontact" class="value px-2 fs-6 form-control" value="{{$staff->staffcontact}}" maxlength="11" pattern="{0-9}[11]" />
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

<script>
    document.getElementById("imageInput").onchange = function(event) {
        const [file] = event.target.files;
        if (file) {
            const preview = document.getElementById("preview");
            preview.src = URL.createObjectURL(file);
            preview.style.display = "block";
        }
    };
</script>

@endsection