@extends('layouts.app')
@section('title', 'Patients')
@section('content')
@if (session()->has('success'))

<head>
    <link rel="stylesheet" href="{{asset('assets/css/light.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/dataTables/dataTables.bootstrap.css')}}">
</head>
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

<div class="patient-section content-wrapper">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="top-heading mb-0">Registered Patients <span class="fw-normal" id="userCount">({{$patientCount}})</span></h4>
            <div class="custom-dt-toolbar">
                <input type="search" minlength="20" id="tableSearch" class="form-control w-100" placeholder="Search...">
            </div>
        </div>
        <div class="dashboard-table-container" style="background-color: var(--outgoing-bg); color:var(--txt-color);">
            <div class="dashboard-table-header">
                <h3 class="dashboard-table-title" style="color:var(--txt-color);">Recent tables</h3>
                <a href="#" class="btn btn-secondary" id="show100">View All</a>
            </div>
            <div class="table-responsive">
                <table id="usersTable" class="dashboard-table table align-middle table-hover">

                    <thead>
                        <tr>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Name</th>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Address</th>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Phone</th>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patients as $patient)
                        <tr>
                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">
                                <div class="table-title-cell">
                                    <div class="table-icon">
                                        <span class="material-symbols-rounded">{{$loop->iteration}}</span>
                                    </div>
                                    @if($patient->image)
                                    <img src="{{ asset('uploads/patients/'.$patient->image) }}" alt="" class="table-avatar" style="width: 100px;">
                                    @else
                                    <img src="{{ asset('assets/svg/man-svgrepo-com.svg') }}" alt="No Image" width="100px">
                                    @endif
                                    <div class="table-info">
                                        <div class="table-title-text" style="color:var(--txt-color);">{{ $patient->name }}</div>
                                        <div class="table-meta-text" style="color:var(--txt-color);">{{ $patient->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center"><span class="status-badge success"> {{$patient->address}}</span></td>
                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center"><span class="">{{$patient->contact}}</span></td>

                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">
                                <div class="d-flex gap-2">
                                    <a href="{{route('patient_info', $patient->pid)}}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                    <a href="{{route('patient_edit', $patient->pid)}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                    <!-- <form action="{{route('patient_delete', $patient->pid )}}" method="post" onsubmit="return confirm('Do you want to delete this patient named: {{$patient->name}}')">
                                        @csrf
                                        <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                    </form> -->
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
</main>

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