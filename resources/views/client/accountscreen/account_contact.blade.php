@extends('layouts.container-content')
@section('title', 'Change Contact')
@section('content')
<style>
    .form-control {
        background: var(--incoming-bg);
        color: var(--txt-color);
    }

    .form-control:focus {
        box-shadow: none;
        border-color: none;
        background: none;
        color: var(--txt-color);
    }
</style>
@include('layouts.base_side')

<main class="main-content shadow-sm">
    <div class="container-content">
        <section class="viewport p-3" id="account-contact-section">
            <header class="header d-flex mb-4">
                <a href="{{route('showPersonalDetailsPage')}}" class="nav-link"> <i class="fa fa-chevron-left"></i></a>
            </header>
            <div class="container-fluid">
                <h1 class="fw-bold top-heading"> <i class="fa fa-user-circle"></i> Update Contact Info</h1>
                <p class="text fw-light">Manage your mobile number and email. Your new contact must be different from previous used.</p>
                <form method="POST" action="{{route('updateContactInfo')}}">
                    @csrf
                    @method('PATCH')
                    <div class="text">
                        <label for="contact text">Phone</label>
                        <input type="tel" value="{{$contact}}" class="form-control" id="contact" name="contact" pattern="{0-9}[11]" min="11" required>
                    </div>
                    <div class="text mt-2">
                        <label for="email text">Email</label>
                        <input type="email" class="form-control" value="{{$email}}" id="email" name="email" max="50" spellcheck="false" autocomplete="email" required>
                    </div>


                    <button type="submit" id="update-btn" disabled class="btn btn-primary w-100 my-3">Update</button>
                    <a href="{{route('showPersonalDetailsPage')}}" class="btn btn-outline-secondary w-100"><span class="text">Cancel</span></a>


                </form>
                @if ($errors->any())
                <div class="text-center text-danger">
                    @foreach ($errors->all() as $error)
                    <span>{{ $error }}</span>
                    @endforeach
                </div>
                @endif
                @if (session('success'))
                <div class="text-center text-danger">
                    <span class="alert alert-success">Success</span>
                </div>
                @endif
            </div>
        </section>
        <script src="{{asset('assets/js/jquery-1.10.2.js')}}"></script>
        <script>
            $(document).ready(function() {
                var originalContact = $('#contact').val();
                var originalEmail = $('#email').val();
                $('#contact, #email').on('input', function() {
                    var contactChanged = $('#contact').val() != originalContact;
                    var emailChanged = $('#email').val() != originalEmail;
                    $('#update-btn').prop('disabled', !(contactChanged || emailChanged));
                });
            });
        </script>
    </div>
</main>
@endsection