@extends('layouts.app')
@section('title', 'Specialty')
@section('content')
<section class="content-wrapper">
    <div class="container-fluid">
        <article class="d-flex align-items-center  justify-content-between gap-5 mb-4">
            <h4 class="top-heading mb-0">Doctor Specialty</h4>
            <button class="btn btn-primary px-3" id="toggler"><i class="bx bx-plus"></i>New</button>

        </article>
        @if ($errors->any())
        <div class="text-center mt-4">
            @foreach ($errors->all() as $error)
            <p class="alert alert-danger">{{ $error }}</p>
            @endforeach
        </div>
        @endif
        <!-- DataTable -->
        <div class="dashboard-table-container" style="background-color: var(--outgoing-bg); color:var(--txt-color);">
            <div class="dashboard-table-header">
                <h3 class="dashboard-table-title" style="color:var(--txt-color);">Recent tables</h3>
                <a href="#" class="btn btn-secondary">View All</a>
            </div>
            <div class="table-responsive">
                <table id="usersTable" class="dashboard-table table align-middle table-hover border">
                    <thead>
                        <tr>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Expertise Name</th>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Icon</th>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Created at</th>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Updated At</th>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($specialties as $spe)
                        <tr class="text-center">
                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);">
                                <div class="table-title-cell">
                                    <div class="table-icon">
                                        <span class="material-symbols-rounded">{{$loop->iteration}}</span>
                                    </div>

                                    <div class="table-info">
                                        <div class="table-title-text" style="color:var(--txt-color);">{{ $spe->sname }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center"><span class="status-badge success fa-2x "><i class="fa fa-{{$spe->icon}}"></i></span></td>
                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center"><span class="status-badge success">{{$spe->created_at}}</span></td>
                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center"><span class="status-badge success">{{$spe->updated_at}}</span></td>


                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <a href="{{route('specialty.edit', $spe->id)}}" class="btn btn-primary p-2"><i class="fa fa-edit"></i> Edit</a>
                                    <form action="{{route('specialty.delete', $spe->id)}}" method="post" onsubmit="return confirm('Do you want to delete this specialization, deleting may affect doctors')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
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
</section>
<section class="lightbox" id="lightbox">
    <div class="lightbox-content">

        <form action="{{route('specialty.add')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="specialty" class="form-label"></label>
                <label for="sname">Expertise Name</label>
                <input type="text" class="form-control" name="sname" required placeholder="New Specialization/ Expertise">
            </div>
            <div class="mb-3">
                <label for="icon">Select icon</label>
                <select name="icon" id="icon" class="form-control form-select">
                    <option value="">Select Icon</option>
                    <option value="heart-pulse">Heart</option>
                    <option value="brain">Brain</option>
                    <option value="ribbon">Ribbon</option>
                    <option value="child">Child</option>
                    <option value="user">User</option>
                    <option value="bone">Bone</option>
                    <option value="female">Female</option>
                    <option value="stethoscope">Stethoscope</option>
                    <option value="eye">Eye</option>
                    <option value="body">Body</option>
                    <option value="user">User</option>
                    <option value="medkit">Medkit</option>
                    <option value="syringe">Syringe</option>
                    <option value="laptop-medical">Laptop Medical</option>
                    <option value="x-ray">X Ray</option>
                    <option value="toilet">Toilet</option>
                    <option value="tooth">Tooth</option>
                    <option value="kidney">Kidney</option>
                    <option value="thermometer">Thermometer</option>
                    <option value="stomach">Stomach</option>
                    <option value="lungs">Lungs</option>
                    <option value="hand-holding-medical">Hand Holding Medical</option>
                    <option value="blood-drop">Blood Drop</option>
                </select>
            </div>


            <button type="submit" class="btn btn-success">Save</button>
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
    </div>
</section>

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