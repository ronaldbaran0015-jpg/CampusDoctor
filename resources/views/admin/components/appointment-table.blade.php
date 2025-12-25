<div class="col">
    <h5 class="heading mt-3"> Finished Appointments</h5>
    <div class="dashboard-table-container" style="background-color: var(--outgoing-bg); color:var(--txt-color);">
        <div class="dashboard-table-header">
            <h3 class="dashboard-table-title" style="background-color: var(--outgoing-bg); color:var(--txt-color);">Appointment table</h3>
            <a href="#" class="btn btn-secondary" id="show100">View All</a>
        </div>
        <div class="table-responsive">

            <table id="usersTable" class="dashboard-table table align-middle table-hover border">

                <thead>
                    <tr>
                        <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Patient</th>
                        <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Session Title</th>
                        <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Date</th>
                        <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Time</th>
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
                        <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center"><span class="status-badge success">{{$appointment->schedule->title}}</span></td>
                        <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center"><span class="status-badge primary">{{ \Carbon\Carbon::parse($appointment->appodate)->format('F d, Y')}}</span></td>
                        <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">
                            <span class="status-badge warning">
                                {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}
                                -
                                {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}
                            </span>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        const table = $('#usersTable').DataTable({

            scrollX: false,
            pagingType: 'simple_numbers',
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

        $('#show100').on('click', function() {
            table.page.len(-1).draw();
        });
    });
</script>