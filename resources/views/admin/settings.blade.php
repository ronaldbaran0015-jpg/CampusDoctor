@extends('layouts.app')
@section('title', 'Setting')
@section('content')
<section class="content-wrapper">

    <div class="setting-section container-fluid">
        <article class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="top-heading">Settings</h4>
        </article>
        @if (Auth::guard('admin')->id())

        <span>Work Environment</span>
        <a href="{{route('account.manage')}}" class="border p-3 text-muted d-flex justify-content-between align-items-center text-decoration-none">

            <i class="fa fa-user fs-3 mt-0 "> </i>
            <span for="receiveFilesSwitch" style="flex-grow: 1;" class="ms-3 ">Account Control <br> <small>Activation & Deletion of accounts</small></span>

</a>

        <div class="border border-top-0 p-3  text-muted d-flex justify-content-between align-items-center">
            <i class="fa fa-save fs-3"></i>
            <span for="saveSwitch" style="flex-grow: 1;" class="ms-3">Save Work When Existing <br><small>Keep the last opened document and resume autmatically</small></span>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="saveSwitch" />
            </div>
        </div>
        <div class="border border-top-0 p-3  text-muted d-flex justify-content-between align-items-center">
            <i class="fa fa-cloud-upload-alt  fs-3"> </i>
            <span for="backupSwitch" style="flex-grow: 1;" class="ms-3"> Auto Backup to Cloud <br> <small>Lorem, ipsum dolor sit amet</small></span>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="backupSwitch" />
            </div>
        </div>
        @endif
        <br>
        <span>My Account</span>
        <div class="border p-3 text-muted d-flex justify-content-between align-items-center">
            <i class="fa fa-user-edit fs-3 mt-0 "> </i>
            <span for="receiveFilesSwitch" style="flex-grow: 1;" class="ms-3 ">Profile <br> <small>Edit your profile</small></span>

        </div>
        <br>
        <span>Security</span>
        <a href="{{route('personnel.changePassword')}}" class="border p-3 text-muted  d-flex justify-content-between align-items-center mb-5" style="text-decoration: none;">
            <i class="fa fa-lock  fs-3"></i>
            <span class="ms-3" style="flex-grow: 1;">Change Password</span>
            <div class="px-1">
                <i class=" fa fa-chevron-right"></i>
            </div>
        </a>
    </div>





</section>




<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


@endsection