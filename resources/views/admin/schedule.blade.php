@extends('layouts.app')
@section('title', 'Schedule')
@section('content')
<section class="content-wrapper">
    <div class="container-fluid">
        <article class="d-flex align-items-center  justify-content-between gap-5 mb-4">
            <h4 class="top-heading mb-0">Doctor Schedules</h4>
            <button class="btn btn-primary px-3" id="toggler"><i class="bx bx-plus"></i> New Session</button>
        </article>
        @if ($errors->any())
        <div class="text-center mt-4">
            @foreach ($errors->all() as $error)
            <p class="alert alert-danger">{{ $error }}</p>
            @endforeach
        </div>
        @endif


        <!-- <table class="filter-container mb-4" border="0" style="background-color: var(--outgoing-bg); color:var(--txt-color);">
            <tr>
                <td width="10%"></td>
                <td width="5%" style="text-align: center;"> Date: </td>
                <form action="" method="post">
                    <td width="30%">
                        <input type="date" name="sheduledate" id="date" class="input-text form-control border-dark rounded-0 filter-container-items" style="margin: 0;width: 95%;" value="">
                    </td>
                    <td width="5%" style="text-align: center;"> Doctor: </td>
                    <td width="30%">
                        <select name="docid" id="doctorSelect" class="box form-control border-dark rounded-0 filter-container-items"
                            style="width:90%; height: 37px; margin: 0;">
                            <option value="">Choose Doctor Name from the list</option>
                            @foreach($doctors as $doc)
                            <option value="{{ $doc->docid }}">{{ $doc->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td width="12%">
                        <button type="button" name="filter" class="btn btn-primary p-2 w-100"><i class="fa fa-filter"></i> Filter</button>
                    </td>
                </form>
            </tr>
        </table> -->
        <!-- DataTable -->
        <div class="dashboard-table-container" style="background-color: var(--outgoing-bg); color:var(--txt-color);">
            <div class="dashboard-table-header">
                <h3 class="dashboard-table-title" style="color:var(--txt-color);">Recent tables</h3>
                <a href="#" class="btn btn-secondary" id="show100">View All</a>
            </div>
            <div class="table-responsive">

                <table id="usersTable" class="dashboard-table table align-middle table-hover border">

                    <thead>
                        <tr>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Doctor</th>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Contact</th>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Specialty</th>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($doctors as $doctor)
                        <tr class="text-center">
                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);">
                                <div class="table-title-cell">
                                    <div class="table-icon">
                                        <span class="material-symbols-rounded">{{$loop->iteration}}</span>
                                    </div>
                                    @if($doctor->image)
                                    <img src="{{ asset('uploads/doctors/'.$doctor->image) }}" alt="" class="table-avatar" style="width: 100px;">
                                    @else
                                    <img src="{{ asset('assets/svg/doctor-svgrepo-com.svg') }}" alt="No Image" width="100px">
                                    @endif
                                    <div class="table-info">
                                        <div class="table-title-text" style="color:var(--txt-color);">{{ $doctor->name }}</div>
                                        <div class="table-meta-text" style="color:var(--txt-color);">{{ $doctor->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center"><span class="status-badge success">{{$doctor->contact}}</span></td>

                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">{{$doctor->specialty->sname}}</td>


                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <a href="{{route('schedule_details', $doctor->docid)}}" class="btn btn-primary p-2"><i class="fa fa-eye"></i> View Schedules</a>
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
<section class="lightbox" id="lightbox">
    <div class="lightbox-content">

        <form action="{{ route('schedule.auto') }}" method="POST">
            @csrf
            <div class="">
                <label for="docid_auto" class="form-label">Doctor</label>
                <select name="docid" id="docid_auto" class="form-control" required>
                    <option value="">-- Select Doctor --</option>
                    @foreach($doctors as $doctor)
                    <option value="{{ $doctor->docid }}">{{ $doctor->name }}</option>
                    @endforeach
                </select>
            </div>

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



        <!-- JS for dynamic slots -->


    </div>
</section>
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
         $('#show100').on('click', function() {
            table.page.len(-1).draw();
        });
    });
</script>
@endsection