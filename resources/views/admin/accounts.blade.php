@extends('layouts.app')
@section('title', 'Doctors')
@section('content')

@php
    $rows = collect();

   

    foreach (($doctors ?? []) as $d) {
        $rows->push([
            'role' => 'Doctor',
            'name' => $d->name ?? '—',
            'email' => $d->email ?? '—',
            'contact' => $d->contact ?? '—',
            'image' => !empty($d->image) ? asset('uploads/doctors/' . $d->image) : asset('assets/svg/doctor-svgrepo-com.svg'),
            'type' => 'doctor',
            'id' => $d->docid ?? null,
            'specialty' => optional($d->specialty)->sname,
            'status' => $d->status ?? null,
        ]);
    }

    foreach (($staffs ?? []) as $s) {
        $rows->push([
            'role' => 'Staff',
            'name' => $s->staffname ?? '—',
            'email' => $s->staffemail ?? '—',
            'contact' => $s->staffcontact ?? '—',
            'image' => !empty($s->staffimage) ? asset('uploads/staff/' . $s->staffimage) : asset('assets/svg/clerk-with-tie-svgrepo-com.svg'),
            'type' => 'staff',
            'id' => $s->staffid ?? null,
            'status' => $s->status ?? null,
        ]);
    }

    foreach (($patients ?? []) as $p) {
        $rows->push([
            'role' => 'Patient',
            'name' => $p->name ?? '—',
            'email' => $p->email ?? '—',
            'contact' => $p->contact ?? '—',
            'image' => !empty($p->image) ? asset('uploads/patients/' . $p->image) : asset('assets/img/Jimmy_McGill_BCS_S3.png'),
            'type' => 'patient',
            'id' => $p->pid ?? null,
            'status' => $p->status ?? null,
        ]);
    }
@endphp

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="top-heading mb-0">Registered Users <span class="fw-normal" id="userCount"></span></h4>
            <div class="custom-dt-toolbar">
                <input type="search" id="tableSearch" class="form-control w-100" placeholder="Search...">
                <button class="btn btn-primary w-50" id="toggler"><i class="bi bi-plus-lg"></i>Add</button>
            </div>
        </div>
          @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
        <div class="dashboard-table-container" style="background-color: var(--outgoing-bg); color:var(--txt-color);">
            <div class="dashboard-table-header">
                <h3 class="dashboard-table-title" style="color:var(--txt-color);">Recent tables</h3>
                <a href="#" class="btn btn-secondary" id="show100">View All</a>
            </div>
            <div class="table-responsive">

                <table id="usersTable" class="dashboard-table table align-middle table-hover">
                    <thead>
                        <tr>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Role</th>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">User</th>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Contact</th>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rows as $row)
                        <tr>
                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">
                                <span class="status-badge primary">{{ $row['role'] }}</span>
                            </td>

                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);">
                                <div class="table-title-cell">
                                    <div class="table-icon" style="color:var(--txt-color);">
                                        <span class="material-symbols-rounded">{{$loop->iteration}}</span>
                                    </div>
                                    <img src="{{ $row['image'] }}" alt="" class="table-avatar" style="width: 100px;">
                                    <div class="table-info">
                                        <div style="color:var(--txt-color);" class="table-title-text">{{ $row['name'] }}</div>
                                        <div style="color:var(--txt-color);" class="table-meta-text">{{ $row['email'] }}</div>
                                        @if(!empty($row['specialty']))
                                        <div style="color:var(--txt-color);" class="table-meta-text">{{ $row['specialty'] }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center"><span class="status-badge success">{{ $row['contact'] }}</span></td>

                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    @if(in_array($row['type'], ['doctor','patient', 'staff']) && !empty($row['status']))
                                    @php($toggleLabel = $row['status'] === 'deactivated' ? 'Activate' : 'Deactivate')
                                    <form action="{{ route('account.updateStatus') }}" method="post" onsubmit="return confirm('{{$toggleLabel}} {{$row['role']}}: {{$row['name']}}?')">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $row['id'] }}">
                                        <input type="hidden" name="user_type" value="{{ $row['type'] }}">
                                        <input type="hidden" name="opt" value="toggle">
                                        <button class="btn btn-secondary"><i class="fa fa-ban"></i> {{ $toggleLabel }}</button>
                                    </form>
                                    @endif

                                    @if(in_array($row['type'], ['doctor','patient','staff']))
                                    <form action="{{ route('account.updateStatus') }}" method="post" onsubmit="return confirm('Delete {{$row['role']}}: {{$row['name']}}? This cannot be undone.')">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $row['id'] }}">
                                        <input type="hidden" name="user_type" value="{{ $row['type'] }}">
                                        <input type="hidden" name="opt" value="delete">
                                        <button class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                                    </form>
                                    @else
                                    <span class="text-muted">—</span>
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
</div>
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
                targets: [3] // Make actions not orderable
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