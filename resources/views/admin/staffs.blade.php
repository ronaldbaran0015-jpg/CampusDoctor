@extends('layouts.app')
@section('title', 'Staffs')
@section('content')

<head>
    <link rel="stylesheet" href="{{asset('assets/css/light.css')}}">
</head>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="top-heading mb-0">Registered Staffs <span class="fw-normal" id="userCount">({{$staffCount}})</span></h4>
            <div class="custom-dt-toolbar">
                <input type="search" id="tableSearch" class="form-control w-100" placeholder="Search...">
                <button class="btn btn-primary w-50" id="toggler"><i class="bi bi-plus-lg"></i>Add</button>
            </div>
        </div>

        <div class="dashboard-table-container" style="background-color: var(--outgoing-bg); color:var(--txt-color);">
            <div class="dashboard-table-header">
                <h3 class="dashboard-table-title" style="background-color: var(--outgoing-bg); color:var(--txt-color);">Recent tables</h3>
                <a href="#" class="btn btn-secondary">View All</a>
            </div>
            <div class="table-responsive">

                <table id="usersTable" class="dashboard-table table align-middle table-hover">

                    <thead>
                        <tr>

                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Name</th>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Role</th>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Contact</th>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($staffs as $staff)
                        <tr>
                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);">
                                <div class="table-title-cell">
                                    <div class="table-icon">
                                        <span class="material-symbols-rounded">{{$staff->staffid}}</span>
                                    </div>
                                    @if($staff->staffimage)
                                    <img src="{{ asset('uploads/staff/'.$staff->staffimage) }}" alt="" class="table-avatar" style="width: 100px;">
                                    @else
                                    <figcaption>
                                        <img src="{{ asset('assets/img/clerk-with-tie-svgrepo-com.svg') }}" alt="No Image" width="90">
                                        <p class="text-center">No Picture</p>
                                    </figcaption>
                                    @endif
                                    <div class="table-info">
                                        <div class="table-title-text text">{{ $staff->staffname }}</div>
                                        <div class="table-meta-text text">{{ $staff->staffemail }}</div>
                                    </div>
                                </div>
                            </td>

                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center"><span class="status-badge success">{{$staff->staffrole}}</span></td>

                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center text">{{$staff->staffcontact}}</td>

                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">

                                    <a href="{{route('staffs.edit', $staff->staffid )}}" class="btn btn-success p-2"><i class="fa fa-edit"></i></a>

                                    <form action="{{route('staffs.delete', $staff->staffid)}}" method="post">
                                        @csrf
                                        <button class="btn btn-danger p-2"><i class="fa fa-trash" onclick="return confirm('Do you want to delete this staff named: {{$staff->staffname}}')"></i></button>
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
        <form action="{{route('staffs.add')}}" method="POST" class="input-form" enctype="multipart/form-data">
            @csrf
            <h4>Add New Staff</h4>
            <label for="staffname">Name:</label>
            <input type="text" name="staffname" id="staffname" required spellcheck="false">

            <label for="staffemail">Email:</label>
            <input type="email" name="staffemail" id="staffemail" maxlength="100" required spellcheck="false">

            <label for="staffcontact">Contact no:</label>
            <input type="text" name="staffcontact" id="staffcontact" maxlength="11" required spellcheck="false">
            <label for="">Role:</label>
            <select name="staffrole" id="staffrole" required class="form-select">
                <option value="">Select Role</option>
                <option value="Receptionist">Receptionist</option>
                <option value="Office Clerk">Office Clerk</option>
                <option value="Security">Security</option>
            </select>
            <label for="staffimage">Staff's Picture (Optional)</label>
            <input type="file" accept="image/*" name="staffimage">

            <label for="staffpassword">Password:</label>
            <input type="password" name="staffpassword" id="staffpassword" minlength="8" required spellcheck="false">

            <label for="staffpassword_confirmation">Confirm:</label>
            <input type="password" name="staffpassword_confirmation" id="staffpassword_confirmation" minlength="8" required spellcheck="false">

            <div class="actions w-100">
                <button type="button" class="btn btn-secondary cancel btn" onclick="closeLightbox()">Cancel</button>
                <button type="submit" class="btn btn-primary">Create</button>
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
            @if ($errors->any())
            <div>

                @foreach ($errors->all() as $error)
                <span class="text-center">{{ $error }}</span>
                @endforeach
            </div>

            @endif

        </form>
    </div>
</div>

<script src="{{asset('assets/js/lightbox.js')}}"></script>
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

        });

        $('#tableSearch').on('keyup', function() {
            table.search(this.value).draw();
        });
    });
</script>
@endsection