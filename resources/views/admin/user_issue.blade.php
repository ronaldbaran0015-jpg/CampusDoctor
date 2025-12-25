@extends('layouts.app')
@section('title', 'User Issue')
@section('content')
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="top-heading mb-0">Reported Issues <span class="fw-normal" id="userCount"></span></h4>
            <div class="custom-dt-toolbar">
                <input type="search" id="tableSearch" class="form-control w-100" placeholder="Search...">
            </div>
        </div>
        <div class="dashboard-table-container" style="background-color: var(--outgoing-bg); color:var(--txt-color);">
            <div class="dashboard-table-header">
                <h3 class="dashboard-table-title" style="color:var(--txt-color);">Recent tables</h3>
                <a href="#" class="btn btn-secondary">View All</a>
            </div>
            <div class="table-responsive">
                <table id="usersTable" class="dashboard-table table align-middle table-hover">

                    <thead>
                        <tr>
                            <th  style="background-color: var(--outgoing-bg); color:var(--txt-color);">Name</th>
                            <th  style="background-color: var(--outgoing-bg); color:var(--txt-color);">Category</th>
                            <th  style="background-color: var(--outgoing-bg); color:var(--txt-color);">Status</th>
                            <th  style="background-color: var(--outgoing-bg); color:var(--txt-color);">Date Reported</th>
                            <th  style="background-color: var(--outgoing-bg); color:var(--txt-color);">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($problemReports as $problemReport)

                        <tr>
                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);">
                                <div class="table-title-cell">
                                    <div class="table-icon">
                                        <span class="material-symbols-rounded">{{$loop->iteration}}</span>
                                    </div>
                                    @if($problemReport->patient->image )
                                    <img src="{{ asset('uploads/patients/'.$problemReport->patient->image ) }}" alt="" class="table-avatar" style="width: 100px;">
                                    @else
                                    <img src="{{ asset('assets/svg/man-svgrepo-com.svg') }}" alt="No Image" width="100">
                                    @endif
                                    <div class="table-info">
                                        <div class="table-title-text">{{$problemReport->patient->name }}</div>
                                        <div class="table-meta-text"></div>
                                    </div>
                                </div>
                            </td>

                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);"><span class="status-badge primary">{{ $problemReport->category }} issue</span></td>

                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);"><span class="status-badge warning">Pending</span></td>

                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);"><span class="status-badge error">{{\Carbon\Carbon::parse($problemReport->created_at)->format('F d, Y') }}</span></td>




                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <a href="{{route('admin.problem-reports.show', $problemReport->id) }}" class="btn btn-primary p-2"><i class="fa fa-eye"></i> Details</a>
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
    });
</script>

@endsection