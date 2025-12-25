@extends('layouts.include.dark')
@section('title','Update Profile')
@section('content')

<head>
    <style>
        .icon-box {
            width: 36px;
            height: 36px;
            background: #f1f3f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
        }

        .menu {
            position: fixed;
            bottom: 0;
            right: 0;
            background: var(--incoming-bg);
            border-top-left-radius: 24px;
            border-top-right-radius: 24px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: none;
            flex-direction: column;
            width: 100%;
            padding: 10px;
            text-align: center;
            animation: fadeIn 0.2s ease;
            overflow: hidden;
            z-index: 999;
        }

        .menu.show {
            display: flex;
        }
    </style>
</head>
@include('layouts.base_side')
<main class="main-content shadow-sm">
    <section class="container-content" id="edit-profile-section">
        <div class="menu shadow-lg" id="menu" style="z-index:1045">
            <span class="text">____</span><br>
            <p class="text">From now on, visit <a href="{{route('account_center')}}" class="link-primary fw-bold">Account Center </a> to manage your contacts, name, birthday and address. You can find them in Settings > Account Center > Personal Details </p>
            <a href="{{route('account_center')}}" class="btn btn-primary my-2">Continue</a>
        </div>
        <div class="viewport p-3 mb-2">
            <header class="header mb-3">
                <a href="javascript:history.back()" class="nav-link"> <i class="fa fa-chevron-left"></i></a>
                <span class="mx-auto">Edit Profile</span>
            </header>

            <div class="section-card">
                <form method="POST" action="{{ route('update-profile') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')


                    <div class="border p-3">

                        @if (!$patient->image)
                        <img id="preview" src="{{asset('assets/svg/man-svgrepo-com.svg')}}" class="small-user-img" class="ui-w-80 rounded-circle" alt="Profile" style="width:100px; height:100px; object-fit:cover ; border-radius:50%; border:1px solid
                                black;">
                        @else
                        <img id="preview" src="{{ asset('uploads/patients/' . $patient->image) }}"
                            class="ui-w-80 rounded-circle" alt="Profile" style="width:100px; height:100px; object-fit:cover ; border-radius:50%; border:1px solid
                                black;">
                        @endif
                        <label class="text" class="text"> Upload photo
                            <input type="file" id="imageInput" class="form-control btn btn-outline-secondary" accept="image/*" name="image"
                                onchange="previewImage(event)">
                        </label> &nbsp;
                    </div>
                    <div class="form-group">
                        <label class="text my-3" for="biography">Add Bio</label>
                        <textarea name="biography" id="biography" rows="5" maxlength="120" minlength="3" style="resize: vertical; background: var(--outgoing-bg); color:var(--txt-color)" class="border w-100 outline-0 px-2">{{$patient->bio->biography ?? 'No bio is set please add some'}}</textarea>
                        <p class="text"><i>Try adding a short bio to describe more about yourself. Your Bio is limited to 120 characters</i></p>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label class="text">Gender</label>
                            <select name="gender" class="form-select" required>
                                <option value="">Select gender</option>
                                <option value="Male" {{ $patient->gender === 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ $patient->gender === 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>


                        <div class="form-group col-md-4">
                            <label class="text">Relationship</label>
                            <select name="relationship" class="form-select">
                                <option value="">Select relationship</option>

                                <option value="Single" {{ $patient->relationship === 'Single' ? 'selected' : '' }}>Single</option>
                                <option value="In a relationship" {{ $patient->relationship === 'In a relationship' ? 'selected' : '' }}>
                                    In a relationship
                                </option>
                                <option value="It's complicated" {{ $patient->relationship === "It's complicated" ? 'selected' : '' }}>
                                    It's complicated
                                </option>
                                <option value="Married" {{ $patient->relationship === 'Married' ? 'selected' : '' }}>Married</option>
                                <option value="Engaged" {{ $patient->relationship === 'Engaged' ? 'selected' : '' }}>Engaged</option>
                                <option value="Separated" {{ $patient->relationship === 'Separated' ? 'selected' : '' }}>Separated</option>
                            </select>
                        </div>

                    </div>
                    <button type="submit" id="update-btn" disabled class="btn btn-success w-25 my-2">Save</button>
                </form>
                <hr class="text">
                <h1 class="sub-heading">Address</h1>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="icon-box"><i class="fa fa-map-marker-alt"></i></div>
                    <aside class="flex-grow-1">
                        <p class="text  my-auto">{{$patient->address}}</p>
                    </aside>
                    <button class="nav-link menuBtn"><i class="fa fa-edit fs-4"></i></button>
                </div>

                <hr class="text">
                <h1 class="sub-heading">Contact info</h1>
                <div class="d-flex align-items-center justify-content-between  m-0">
                    <div class="icon-box"><i class="fa fa-user"></i></div>
                    <aside class="flex-grow-1 m-0">
                        <p class="text my-auto">{{$patient->contact}}</p>
                    </aside>
                    <button class=" nav-link menuBtn"><i class="fa fa-edit fs-4"></i></button>
                </div>

                <hr class="text">
                <h1 class="sub-heading">Birthday</h1>
                <div class="d-flex align-items-center justify-content-between mb-5">
                    <div class="icon-box"><i class="fa fa-cake"></i></div>
                    <aside class="flex-grow-1">
                        <p class="text my-auto">{{ \Carbon\Carbon::parse($patient->dob)->format('F d, Y') }}</p>
                    </aside>
                    <button class="nav-link menuBtn"><i class="fa fa-edit fs-4"></i></button>
                </div>
            </div>
        </div>
    </section>
</main>
@include('client.alerts.success')
@include('client.alerts.error')
<script src="{{asset('assets/js/image-preview.js')}}"></script>
<script src="{{asset('assets/js/jquery-1.10.2.js')}}"></script>
<script>
    const menu = document.getElementById('menu');
    const buttons = document.querySelectorAll('.menuBtn');
    // Function to toggle menu
    function openMenu(event) {
        event.stopPropagation(); // Prevent closing immediately
        menu.classList.toggle('show');
    }

    // Attach same listener to all buttons
    buttons.forEach(button => {
        button.addEventListener('click', openMenu);
    });

    // Hide menu when clicking outside
    document.addEventListener('click', () => {
        menu.classList.remove('show');
    });

    // Initialize progress circle
    document.addEventListener('DOMContentLoaded', function() {
        const progressCircle = document.querySelector('.progress-ring .progress');
        if (progressCircle) {
            const radius = progressCircle.r.baseVal.value;
            const circumference = 2 * Math.PI * radius;
            const progress = parseFloat(progressCircle.style.getPropertyValue('--progress') || 0);
            const offset = circumference - (progress / 100) * circumference;
            progressCircle.style.strokeDasharray = `${circumference} ${circumference}`;
            progressCircle.style.strokeDashoffset = offset;
        }
    });

    $(document).ready(function() {
        var originalBio = $('#biography').val();
        var originalGender = $('#gender').val();
        var originalRelationship = $('#relationship').val();
        var originalImage = $('#preview').attr('src');

        var imageChanged = false;

        function checkChanges() {
            var bioChanged = $('#biography').val() !== originalBio;
            var genderChanged = $('#gender').val() !== originalGender;
            var relationshipChanged = $('#relationship').val() !== originalRelationship;

            $('#update-btn').prop(
                'disabled',
                !(bioChanged || genderChanged || relationshipChanged || imageChanged)
            );
        }

        $('#biography, #gender, #relationship').on('input', checkChanges);

        $('#imageInput').on('change', function() {
            imageChanged = this.files && this.files.length > 0;
            checkChanges();
        });
    });
</script>
@endsection