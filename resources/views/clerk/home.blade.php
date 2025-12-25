@extends('layouts.app')
@section('title')
@section('content')
<div class="content-wrapper px-3">
    <div class="row mt-2">
        <div class="col-md-4 col-lg-8 ">
            <div class="greet-card d-flex col-md-6 col-lg-12 p-3 rounded mb-3">
                <div class="row">
                    <div class="col-md-7">
                        <h1 class="heading">Welcome back, {{$staff->staffname}}!</h1>
                        <p class="text">
                            Verify and update appointments for the patients. Process their transaction</p>
                        <button class="theme-btn px-3">Get updated</button>
                    </div>

                </div>
            </div>
            <h5 class="heading">Overview</h5>

            <div class="row g-2 mb-4">

                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start p-3 pb-1">
                            <div class="d-flex align-items-center gap-1">
                                <span class="fw-semibold">Scanned Appointments</span>
                            </div>
                            <button class="btn btn-sm p-0 border-0 bg-transparent ">
                                <i class=" fa fa-ellipsis-v"></i>
                            </button>
                        </div>
                        <!-- main number + percentage -->
                        <div class="d-flex justify-content-between px-3 gap-2 pt-1 pb-3">

                            <div class="stat-value">
                                <span id="scannedCount" class="status-badge success fs-3">{{$scanned ?? '0'}}</span>
                            </div>

                            <i class="bx bx-calendar-check  fa-2x"></i>

                        </div>
                        <!-- divider -->
                        <hr class="m-0 text">
                        <!-- bottom line -->
                        <div class="d-flex justify-content-between align-items-center p-2">
                            <span class="small">Today's month</span>
                            <!-- “Details →” link styled like the screenshot -->
                            <a href="#" class="btn btn-outline-primary  btn-sm bottom-link d-flex align-items-center gap-1">
                                Details <i class="fa fa-arrow-right text-primary"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="shadow-sm stat-card">
                        <div class="d-flex justify-content-between align-items-start p-3 pb-1">
                            <div class="d-flex align-items-center gap-1">
                                <span class="fw-semibold">Pending Appointment</span>
                            </div>
                            <button class="btn btn-sm p-0 border-0 bg-transparent ">
                                <i class=" fa fa-ellipsis-v"></i>
                            </button>
                        </div>
                        <!-- main number + percentage -->
                        <div class="d-flex px-3 justify-content-between gap-2 pt-1 pb-3">
                            <div class="stat-value">
                                <span id="pendingCount" class="status-badge warning fs-3">{{$pending->count() ?? '0'}}</span>
                            </div>
                            <i class="bx bx-calendar  fa-2x"></i>
                        </div>
                        <!-- divider -->
                        <hr class="m-0 text">
                        <!-- bottom line -->
                        <div class="d-flex justify-content-between align-items-center p-2">
                            <span class="small">Today's month</span>
                            <!-- “Details →” link styled like the screenshot -->
                            <a href="#" class="btn btn-outline-primary btn-sm bottom-link d-flex align-items-center gap-1">
                                Details <i class="fa fa-arrow-right text-primary"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="shadow-sm stat-card">
                        <div class="d-flex justify-content-between align-items-start p-3 pb-1">
                            <div class="d-flex align-items-center gap-1">
                                <span class="fw-semibold">Cancelled Appointment</span>
                            </div>
                            <button class="btn btn-sm p-0 border-0 bg-transparent ">
                                <i class=" fa fa-ellipsis-v"></i>
                            </button>
                        </div>
                        <!-- main number + percentage -->
                        <div class="d-flex px-3 justify-content-between gap-2 pt-1 pb-3">
                            <div class="stat-value">
                                <span id="cancelledCount" class="status-badge error fs-3">{{$cancelled ?? '0'}}</span>
                            </div>
                            <i class="bx bx-calendar-x  fa-2x"></i>
                        </div>
                        <!-- divider -->
                        <hr class="m-0 text">
                        <!-- bottom line -->
                        <div class="d-flex justify-content-between align-items-center p-2">
                            <span class="small">Today's month</span>
                            <!-- “Details →” link styled like the screenshot -->
                            <a href="#" class="btn btn-outline-primary btn-sm bottom-link d-flex align-items-center gap-1">
                                Details <i class="fa fa-arrow-right text-primary"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <h5 class="heading mt-4"> Finished Appointments</h5>
                <div class="dashboard-table-container">
                    <div class="dashboard-table-header">
                        <h3 class="dashboard-table-title">Recent tables</h3>
                        <a href="#" class="btn btn-secondary">View All</a>
                    </div>
                    <div class="table-responsive">

                        <table id="usersTable" class="dashboard-table table align-middle table-hover border">

                            <thead>
                                <tr>
                                    <th class="text-center">Patient</th>
                                    <th class="text-center">Session Title</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($appointments as $appointment)
                                @if ($appointment->status==='finished')
                                <tr class="text-start">
                                    <td>
                                        <div class="table-title-cell">
                                            <div class="table-icon">
                                                <span class="material-symbols-rounded">{{ $loop->iteration }}</span>
                                            </div>

                                            <div class="table-info">
                                                <div class="table-title-text">{{ $appointment->patient->name }}</div>

                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center"><span class="status-badge success">{{$appointment->schedule->title}}</span></td>
                                    <td class="text-center"><span class="status-badge error">{{ \Carbon\Carbon::parse($appointment->appodate)->format('F d, Y')}}</span></td>
                                    <td class="text-center">
                                        <span class="status-badge warning">
                                            {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}
                                            -
                                            {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}
                                        </span>
                                    </td>

                                </tr>
                                @endif

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>


        </div>
        <div class="col date">
            <div class="wrapper">
                <header>
                    <p class="current-date heading"></p>
                    <div class="icons">
                        <i id="prev" class="fa fa-arrow-left"></i>
                        <i id="next" class="fa fa-arrow-right"></i>
                    </div>
                </header>
                <div class="calendar">
                    <ul class="weeks">
                        <li>Sun</li>
                        <li>Mon</li>
                        <li>Tue</li>
                        <li>Wed</li>
                        <li>Thu</li>
                        <li>Fri</li>
                        <li>Sat</li>
                    </ul>
                    <ul class="days"></ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="{{asset('assets/js/jquery-1.10.2.js')}}"></script>

<script>
    function updateStats() {
        $.ajax({
            url: "{{ route('staff.stats') }}",
            method: "GET",
            type: 'GET',
            success: function(data) {
                $('#cancelledCount').text(data.cancelled);
                $('#scannedCount').text(data.scanned);
                $('#pendingCount').text(data.pending);
            }
        });
    }

    // Refresh every 3 seconds
    setInterval(updateStats, 3000);
</script>
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