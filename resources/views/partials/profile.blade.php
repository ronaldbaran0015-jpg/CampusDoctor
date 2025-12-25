@extends('layouts.app')
@section('content')
<style>
    .profile-page .profile-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1.25rem;
    }

    .profile-page .profile-header h4 {
        margin: 0;
    }

    .profile-page .card {
        border-radius: 14px;
    }

    .profile-page .avatar {
        width: 96px;
        height: 96px;
        border-radius: 999px;
        object-fit: cover;
        border: 1px solid rgba(0, 0, 0, .08);
        background: #f8f9fa;
    }

    .profile-page .field-label {
        font-weight: 600;
        margin-bottom: .35rem;
    }

    .profile-page .subtle {
        font-size: .875rem;
        color: #6c757d;
    }
</style>

@php
$avatarFallback = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='96' height='96' viewBox='0 0 96 96'%3E%3Crect width='96' height='96' rx='48' fill='%23f1f3f5'/%3E%3Cpath d='M48 48c8.284 0 15-6.716 15-15S56.284 18 48 18s-15 6.716-15 15 6.716 15 15 15Zm0 6c-14.36 0-26 7.611-26 17v1h52v-1c0-9.389-11.64-17-26-17Z' fill='%2399a1aa'/%3E%3C/svg%3E";
$guard = $guard ?? 'admin';
$user = $user ?? ($admin ?? null);
$profile = $profile ?? null;

$roleLabel = $guard === 'admin' ? 'Administrator' : ($guard === 'staff' ? 'Staff' : 'Doctor');

$nameField = $profile['model_name_field'] ?? ($guard === 'admin' ? 'adminname' : ($guard === 'staff' ? 'staffname' : 'name'));
$contactField = $profile['model_contact_field'] ?? ($guard === 'admin' ? 'admincontact' : ($guard === 'staff' ? 'staffcontact' : 'contact'));
$emailField = $profile['model_email_field'] ?? ($guard === 'doctor' ? 'email' : ($guard === 'staff' ? 'staffemail' : 'email'));
$specialtiesField = $profile['model_specialties_field'] ?? ($guard === 'doctor');
$imageField = $profile['model_image_field'] ?? ($guard === 'admin' ? 'adminimage' : ($guard === 'staff' ? 'staffimage' : 'image'));

$nameValue = $user ? ($user->{$nameField} ?? '') : '';
$contactValue = $user ? ($user->{$contactField} ?? '') : '';
$emailValue = $user ? ($user->{$emailField} ?? '') : '';

$specialtiesValue = $user && $user->specialty
? $user->specialty->sname
: '';

$imageValue = $user ? ($user->{$imageField} ?? '') : '';

$uploadDir = $profile['upload_dir'] ?? null;
$imageUrl = $imageValue ? ($uploadDir ? asset($uploadDir . '/' . $imageValue) : $imageValue) : $avatarFallback;
@endphp

<div class="container py-4 profile-page">
    <div class="profile-header">
        <div>
            <h4 class="fw-bold text">My Profile</h4>
            <div class="subtle text">Update your personal details and profile photo.</div>
        </div>
    </div>
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->has('current_password'))
    <div class="alert alert-danger">
        {{ $errors->first('current_password') }}
    </div>
    @endif


    <form action="{{ route('profile.update.current') }}" class="profile-form" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="current_password" id="current_password">

        <div class="menu-items shadow-sm border">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <img
                        src="{{ $imageUrl }}"
                        alt="Profile Picture"
                        class="avatar"
                        id="preview">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
                            <div>
                                <h5 class="mb-1 text">{{ $nameValue }}</h5>
                                <div class="subtle text-capitalize text">{{ $roleLabel }}</div>
                                @if (Auth::guard('doctor')->check())
                                <div class="subtle text-capitalize text">{{ $specialtiesValue }}</div>
                                @endif



                            </div>
                            <div class="text-end">
                                <label class="btn btn-outline-secondary btn-sm mb-1">
                                    <i class="fa fa-upload"></i> Change photo
                                    <input type="file" id="profile_image" name="image" class="d-none" accept="image/*" onchange="previewImage(event)">
                                </label>
                                <div class="subtle">PNG/JPG, up to a few MB.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="field-label text" for="profile_name">Full Name</label>
                        <input id="profile_name" type="text" name="{{ $profile['request_name_key'] ?? 'name' }}" value="{{ $nameValue }}" class="form-control" required>
                        <div class="subtle">This will be shown on your profile.</div>
                    </div>

                    <div class="col-md-6">
                        <label class="field-label text" for="profile_contact">Contact Number</label>
                        <input id="profile_contact" type="text" name="{{ $profile['request_contact_key'] ?? 'contact' }}" maxlength="11" value="{{ $contactValue }}" class="form-control" inputmode="numeric" required>
                        <div class="subtle text">Use an 11-digit number (no spaces).</div>
                    </div>
                    @if (Auth::guard('doctor')->check() || Auth::guard('staff')->check())
                    <div class="col-md-6">
                        <label class="field-label text" for="profile_email">Email </label>
                        <input id="profile_email" type="email" name="{{ $profile['request_email_key'] ?? 'email' }}" maxlength="50" value="{{ $emailValue }}" class="form-control">
                        <div class="subtle text text-warning">Updating your email may affect the next time you login</div>
                    </div>
                    @endif
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button id="update-btn" type="button" disabled
                        class="btn btn-primary px-4"
                        onclick="openPasswordModal()">
                        Save Changes
                    </button>

                </div>
            </div>
        </div>
    </form>
    <div class="modal fade" id="passwordConfirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p class="text-muted">
                        Please enter your password to confirm changes.
                    </p>

                    <input type="password"
                        id="password_input"
                        class="form-control"
                        placeholder="Current password"
                        autocomplete="current-password">
                </div>

                <div class="modal-footer">
                    <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button"
                        class="btn btn-primary"
                        onclick="confirmProfileUpdate()">
                        Confirm & Save
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    function previewImage(event) {
        if (!event || !event.target || !event.target.files || !event.target.files[0]) return;
        const reader = new FileReader();
        reader.onload = function() {
            document.getElementById('preview').src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
<script src="{{asset('assets/js/jquery-1.10.2.js')}}"></script>
<script>
    function openPasswordModal() {
        const modal = new bootstrap.Modal(
            document.getElementById('passwordConfirmModal')
        );
        modal.show();
    }

    function confirmProfileUpdate() {
        const password = document.getElementById('password_input').value;

        if (!password) {
            alert('Please enter your password.');
            return;
        }

        document.getElementById('current_password').value = password;
        document.querySelector('.profile-form').submit();
    }

    $(document).ready(function() {
        var originalName = $('#profile_name').val();
        var originalContact = $('#profile_contact').val();
        var originalEmail = $('#profile_email').val();
        var originalImage = $('#preview').attr('src');

        var imageChanged = false;

        function checkChanges() {
            var nameChanged = $('#profile_name').val() !== originalName;
            var contactChanged = $('#profile_contact').val() !== originalContact;
            var emailChanged = $('#profile_email').val() !== originalEmail;

            $('#update-btn').prop(
                'disabled',
                !(nameChanged || contactChanged || emailChanged || imageChanged)
            );
        }

        $('#profile_name, #profile_contact, #profile_email').on('input', checkChanges);

        $('#profile_image').on('change', function() {
            imageChanged = this.files && this.files.length > 0;
            checkChanges();
        });
    });
</script>





@endsection