@extends('layouts.app')
@section('title', 'Home')
@section('content')
<div class="content-wrapper px-3">
    <div class="row mt-2">
        <div class="col-md-4 col-lg-8 ">
            <div class="greet-card d-flex col-md-6 col-lg-12 p-3 rounded mb-3">
                <div class="row">
                    <div class="col-md-7">
                        <h1 class="heading">Welcome back, Dr. {{$doctor->name}}!</h1>
                        <p class="text"> Track your past and future appointments history for your patients. Add Schedules or your available time</p>
                        <form action="{{ route('doctor.update-status') }}" method="post">
                            @csrf
                            <select class="btn btn-primary px-3" name="status" onchange="this.form.submit()">
                                <option selected disabled>Set status</option>
                                <option value="offline" {{ $doctor->status == 'offline' ? 'selected' : '' }}>Offline ⚪</option>
                                <option value="active" {{ $doctor->status == 'active' ? 'selected' : '' }}>Active 🟢</option>
                                <option value="busy" {{ $doctor->status == 'busy' ? 'selected' : '' }}>Busy 🟡</option>
                                <option value="not available" {{ $doctor->status == 'not available' ? 'selected' : '' }}>Not available 🔴</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Card Stats  -->
            @include('doctor.component.card-stats')

        </div>
        <!-- Calendar -->
        @include('doctor.component.calendar')

        <!-- Appointment Table -->
        @include('doctor.component.appointment-table')

    </div>
</div>
@if (session()->has('success'))
<script>
    window.onload = () => {
        Swal.fire({
            position: "top",
            toast: true,
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            icon: "success",
            title: "{{session()->get('success')}}"
        });
    }
</script>
@endif
<script>
    $(document).ready(function() {
        const table = $('#usersTable').DataTable({

            pagingType: 'simple_numbers',

            pageLength: 5,
            dom: 'rt<"d-flex justify-content-between align-items-center p-2"lip>',
            columnDefs: [{
                orderable: false,
                targets: [1, 2, 3] // Make columns 1, 2, and 3 not orderable
            }, {
                type: 'num',
                targets: 0 // Treat the first column as numbers
            }],
            order: [
                [0, 'asc']
            ], // Order by the first column in ascending order
        });
        $('#tableSearch').on('keyup', function() {
            table.search(this.value).draw();
        });
    });
</script>

@endsection