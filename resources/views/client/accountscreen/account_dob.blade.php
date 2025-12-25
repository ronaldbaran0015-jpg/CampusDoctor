@extends('layouts.container-content')
@section('title', 'Change Birthday')
@section('content')
@include('layouts.base_side')

<main class="main-content shadow-sm">
    <div class="container-content">
        <section class="viewport p-3" id="account-dob-section">
            <header class="header d-flex mb-4">
                <a href="{{route('showPersonalDetailsPage')}}" class="nav-link"> <i class="fa fa-chevron-left"></i></a>
            </header>
            <div class="container-fluid">
                <h1 class="fw-bold top-heading"> <i class="fa fa-calendar"></i> Update Your Birthday</h1>
                <p class="text fw-light">Manage your Birthday. Make sure to use your real birthday for accuracy of information</p>
                <form method="POST" action="{{route('updateDob')}}">
                    @csrf
                    @method('PATCH')
                    <div class="form-group text">
                        <label for="current_phone">Birthday</label>
                        @php
                        if ($dob) {
                        $carbonDob = \Carbon\Carbon::parse($dob);
                        } else {
                        $carbonDob = null;
                        }
                        @endphp
                        <div class="d-flex gap-2">
                            <div class="mb-3 col-md-4">
                                <select class="form-select form-control" name="dob_month" id="dob_month" required>
                                    <option value="">Month</option>
                                    @foreach(range(1, 12) as $month)
                                    <option value="{{ $month }}" {{ old('dob_month', $carbonDob->format('m') ?? '') == $month ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('m', $month)->format('F') }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <select class="form-select form-control" name="dob_day" id="dob_day" required>
                                    <option value="">Day</option>
                                    @for($i = 1; $i <= 31; $i++)
                                        <option value="{{ $i }}" {{ old('dob_day', $carbonDob->format('d') ?? '') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <select class="form-select form-control" name="dob_year" id="dob_year" required>
                                    <option value="">Year</option>
                                    @for($i = date('Y'); $i >= 1900; $i--)
                                    <option value="{{ $i }}" {{ old('dob_year', $carbonDob->format('Y') ?? '') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
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
                var originalMonth = $('#dob_month').val();
                var originalDay = $('#dob_day').val();
                var originalYear = $('#dob_year').val();

                $('#dob_month, #dob_day, #dob_year').on('input', function() {
                    var monthChanged = $('#dob_month').val() != originalMonth;
                    var dayChanged = $('#dob_day').val() != originalDay;
                    var yearChanged = $('#dob_year').val() != originalYear;

                    $('#update-btn').prop('disabled', !(monthChanged || dayChanged || yearChanged));
                });
            });
        </script>
    </div>
</main>
@endsection