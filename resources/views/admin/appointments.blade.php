@extends('layouts.app')
@section('title', 'Appointments')
@section('content')
<section class="content-wrapper">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="top-heading mb-0">Appointments<span class="fw-normal" id="userCount"></span></h4>
        </div>
        @if ($errors->any())
        <div>

            @foreach ($errors->all() as $error)
            <span class="alert alert-danger">{{ $error }}</span>
            @endforeach
        </div>
        @endif

        <div class="dashboard-table-container" style="background-color: var(--outgoing-bg); color:var(--txt-color);">
            <div class="dashboard-table-header">
                <h3 class="dashboard-table-title" style="background-color: var(--outgoing-bg); color:var(--txt-color);">Recent tables</h3>
                <a href="#" class="btn btn-secondary" id="show100">View All</a>
            </div>
            <div class="table-responsive">
                <table id="usersTable" class="dashboard-table table align-middle table-hover border">
                    <thead>
                        <tr>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Patient</th>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">No.</th>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Doctor</th>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Session</th>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Date Time</th>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Status</th>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointments as $appointment)
                        <tr class="text-start">
                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);">
                                <div class="table-title-cell">
                                    <div class="table-icon">
                                        <span class="material-symbols-rounded">{{ $loop->iteration }}</span>
                                    </div>

                                    <div class="table-info">
                                        <div class="table-title-text">{{ $appointment->patient->name }}</div>

                                    </div>
                                </div>
                            </td>
                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">{{$appointment->apponum}}</td>
                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">{{$appointment->schedule->mydoctor->name}}</td>
                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center"><span class="status-badge success">{{$appointment->schedule->title}}</span></td>
                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">
                                <span class="status-badge error">{{ \Carbon\Carbon::parse($appointment->appodate)->format('F d, Y')}}</span>
                                <span class="status-badge warning">
                                    {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}
                                    -
                                    {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}
                                </span>
                            </td>
                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center text-capitalize">
                                {{$appointment->status}}
                            </td>


                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    @if ($appointment->status == 'pending')
                                    <form method="post" action="{{route('markMissed', $appointment->appoid)}}}">
                                        @csrf
                                        <button class="btn btn-danger" onclick="return confirm('Mark this as missed?')">Mark missed</button>
                                    </form>
                                    @else
                                    <button class="btn btn-danger" disabled>Aleady {{$appointment->status}}</button>

                                    @endif

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        const table = $('#usersTable').DataTable({
            pagingType: 'simple_numbers',
            dom: 'rt<"d-flex justify-content-between align-items-center p-2"lip>',
            columnDefs: [{
                orderable: false,

            }],
            order: [
                [5, 'desc']
            ]
        });

        $('#tableSearch').on('keyup', function() {
            table.search(this.value).draw();
        });

        $('#show100').on('click', function() {
            table.page.len(-1).draw();
        });


    });
</script>
@endsection