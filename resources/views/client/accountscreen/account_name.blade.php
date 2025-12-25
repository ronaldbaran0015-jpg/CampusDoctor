@extends('layouts.container-content')
@section('title', 'Change Name')
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
        <section class="viewport p-3" id="account-name-section">
            <header class="header d-flex mb-4">
                <a href="{{route('account_center')}}" class="nav-link"> <i class="fa fa-chevron-left"></i></a>
            </header>
            <div class="container-fluid">
                <h1 class="fw-bold top-heading"> <i class="fa fa-user-circle"></i> Name</h1>
                <p class="text fw-light">Use your real name and the new name must be different from previous used. Don't add any unusal capitalization, punctuation, characters or random words. <a href="link-primary fw-bold">Learn More <i class="fa fa-arrow-right" style="transform: rotate(-45deg); font-size:11px"></i></a></p>

                <!-- Blade template -->
                <form method="POST" action="{{route('updateName')}}">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="name" class="text">Full Name</label>
                        <input type="text" value="{{$name}}" class="form-control" id="name" name="name" max="50" required>
                    </div>
                    <button type="submit" id="update-btn" disabled class="btn btn-primary w-100 my-3">Update</button>
                    <a href="{{route('account_center')}}" class="btn btn-outline-secondary w-100"><span class="text">Cancel</span></a>


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
                var originalName = $('#name').val();
                $('#name').on('input', function() {
                    $('#update-btn').prop('disabled', $(this).val() == originalName);
                });
            });
        </script>
    </div>
</main>
@endsection