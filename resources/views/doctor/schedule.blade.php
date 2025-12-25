@extends('layouts.app')
@section('title', 'Schedule List')
@section('content')
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="d-flex align-items-center  justify-content-between gap-5 mb-4">
            <h4 class="top-heading mb-0 ">Doctor Schedules</h4>
            <div class="custom-dt-toolbar">
                <input type="search" id="tableSearch" class="form-control w-100" placeholder="Search...">
                <button class="btn btn-primary px-3 w-75" id="toggler"><i class="bx bx-plus"></i> New Session</button>

            </div>
        </div>
        <div class="dashboard-table-container" style="background-color: var(--outgoing-bg); color:var(--txt-color);">
            <div class="dashboard-table-header">
                <h3 class="dashboard-table-title" style="color:var(--txt-color);">Recent tables</h3>
                <a href="#" class="btn btn-secondary">View All</a>
            </div>
            <div class="table-responsive">


                <table id="usersTable" class="dashboard-table table align-middle table-hover border">
                    <thead>
                        <tr>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Title</th>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Date</th>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Time</th>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">NOP</th>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schedules as $sched)
                        <tr class="text-start">
                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);">
                                <div class="table-title-cell">
                                    <div class="table-icon">
                                        <span class="material-symbols-rounded">{{ $loop->iteration }}</span>
                                    </div>
                                    <div class="table-info">
                                        <div class="table-title-text">{{ $sched->title }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center"><span class="status-badge primary">{{ \Carbon\Carbon::parse($sched->scheduledate)->format('F d, Y')}}</span></td>
                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">
                                <span class="status-badge warning">
                                    {{ \Carbon\Carbon::parse($sched->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($sched->end_time)->format('h:i A') }}
                                </span>
                            </td>
                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center"><span class="status-badge success">{{ $sched->nop }} persons</span></td>
                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <a href="{{route('schedule.edit', $sched->scheduleid)}}" class="btn btn-success p-2"><i class="fa fa-edit"></i></a>
                                    <form action="{{route('schedule.delete', $sched->scheduleid)}}" onsubmit="return confirm('Do you want to delete this schedule')" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger p-2"><i class="fa fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="lightbox" id="lightbox">
    <div class="lightbox-content">

        <form action="{{ route('schedule.auto') }}" method="POST">
            @csrf

            <input type="hidden" name="docid" value="{{$doctor->docid}}">


            <div class="">
                <label class="form-label">Month</label>
                <input type="number" name="month" min="1" max="12" class="form-control" placeholder="e.g. 11 for November" required>
            </div>

            <div class="">
                <label class="form-label">Year</label>
                <input type="number" name="year" min="2024" value="{{ date('Y') }}" class="form-control" required>
            </div>

            <div class="">
                <label class="form-label">Session Title</label>
                <input type="text" name="title" class="form-control" value="Consultation" required>
            </div>

            <div id="timeSlots">
                <label class="form-label">Time Slots (Start-End)</label>
                <div class="d-flex gap-2 mb-2">
                    <input type="time" name="time_slots[0][start]" class="form-control" required>
                    <input type="time" name="time_slots[0][end]" class="form-control" required>
                </div>
            </div>

            <button type="button" class="btn btn-secondary btn-sm " onclick="addTimeSlot()">+ Add Time Slot</button>

            <div class="mb-2">
                <label for="nop_auto" class="form-label">Max Clients</label>
                <input type="number" name="nop" id="nop_auto" class="form-control" min="1" required>
            </div>

            <button type="submit" class="btn btn-success">Populate</button>
            <button type="button" class="btn btn-danger clear " onclick="clearTextFields('form-control')">Clear All</button>
            <button type="button" class="btn btn-secondary cancel" onclick="closeLightbox()">Cancel</button>

        </form>


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


        @if ($errors->any())
        <div class="text-center mt-4">
            @foreach ($errors->all() as $error)
            <p class="alert alert-danger">{{ $error }}</p>
            @endforeach
        </div>
        @endif
        <!-- JS for dynamic slots -->
    </div>
</div>
<script>
    let slotCount = 1;

    function addTimeSlot() {
        const container = document.getElementById('timeSlots');
        const div = document.createElement('div');
        div.classList.add('d-flex', 'gap-2', 'mb-2');
        div.innerHTML = `
        <input type="time" name="time_slots[${slotCount}][start]" class="form-control" required>
        <input type="time" name="time_slots[${slotCount}][end]" class="form-control" required>
        <button type="button" class="btn btn-danger btn-sm remove-slot">X</button>

    `;
        container.appendChild(div);
        slotCount++;
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-slot')) {
                e.target.parentElement.remove();
            }
        });
    }
</script>
<script src="{{asset('assets/js/lightbox.js')}}"></script>
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
    });
</script>

@endsection