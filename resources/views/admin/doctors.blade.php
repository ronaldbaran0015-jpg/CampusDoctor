@extends('layouts.app')
@section('title', 'Doctors')
@section('content')

<head>
    <link rel="stylesheet" href="{{asset('assets/css/light.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/dataTables/dataTables.bootstrap.css')}}">
</head>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="top-heading mb-0">Registered Doctors <span class="fw-normal" id="userCount">({{$doctorCount}})</span></h4>
            <div class="custom-dt-toolbar">
                <input type="search" id="tableSearch" class="form-control w-100" placeholder="Search...">
                <button class="btn btn-primary w-50" id="toggler"><i class="bi bi-plus-lg"></i>Add</button>
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
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Contact</th>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Specialty</th>
                            <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($doctors as $doc)
                        <tr>
                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);">
                                <div class="table-title-cell">
                                    <div class="table-icon" style="color:var(--txt-color);">
                                        <span class="material-symbols-rounded">{{$loop->iteration}}</span>
                                    </div>
                                    @if($doc->image)
                                    <img src="{{ asset('uploads/doctors/'.$doc->image) }}" alt="" class="table-avatar" style="width: 100px;">
                                    @else
                                    <img src="{{ asset('assets/svg/doctor-svgrepo-com.svg') }}" alt="No Image" width="100px">
                                    @endif
                                    <div class="table-info">
                                        <div style="color:var(--txt-color);" class="table-title-text">{{ $doc->name }}</div>
                                        <div style="color:var(--txt-color);" class="table-meta-text">{{ $doc->email }}</div>
                                    </div>
                                </div>
                            </td>

                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center"><span class="status-badge success">{{$doc->contact ?? 'None'}}</span></td>

                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">{{$doc->specialty->sname ?? 'None'}}</td>

                            <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <a href="{{route('doctor_info', $doc->docid)}}" class="btn btn-primary p-2"><i class="fa fa-eye"></i> </a>

                                    <a href="{{route('show_edit_form',$doc->docid )}}" class="btn btn-success p-2"><i class="fa fa-edit"></i></a>
                                    <form action="{{route('delete_doctor', $doc->docid)}}" method="post" onsubmit="return confirm('Do you want to delete this doctor named: {{$doc->name}}')">
                                        @csrf
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
        <form action="{{route('doctor.add')}}" method="POST" class="input-form" enctype="multipart/form-data">
            @csrf
            <h4>Add New Doctor</h4>
            <label class="fw-bold" for="name">Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" required spellcheck="false">



            <div class="d-flex gap-2">
                <fieldset>
                    <label class="fw-bold" for="email">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email" maxlength="100" required spellcheck="false">
                </fieldset>
                <fieldset>
                    <label class="fw-bold" for="doctel">Contact no <span class="text-danger">*</span></label>
                    <input type="tel" maxlength="11" pattern="[0-9]{11}" name="contact" id="doctel" required spellcheck="false">
                </fieldset>
            </div>
            <label class="fw-bold" for="specialties">Specialty <span class="text-danger">*</span></label>
            <select name="specialties" id="specialties" class="form-select">
                <option value="">Select specialty</option>
                @foreach($special as $sp)
                <option value="{{$sp->id}}">{{$sp->sname}}</option>
                @endforeach
            </select>
            <label class="fw-bold" for="image">Doctor's Picture (Optional)</label>
            <input type="file" accept="image/*" required name="image">
            <label class="fw-bold" for="bio">Bio (Optional)</label>
            <textarea name="bio" id="bio" rows="5" class="form-control" style="resize: none;" placeholder="Add short description" required></textarea>

            <label class="fw-bold" for="password">Password:</label>
            <input type="password" name="password" id="password" minlength="8" required spellcheck="false">

            <label class="fw-bold" for="password_confirmation">Confirm:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" minlength="8" required spellcheck="false">
            <div class="actions w-100">
                <button type="button" class="btn btn-secondary cancel btn" onclick="closeLightbox()">Cancel</button>
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
            @if ($errors->any())
            <div>

                @foreach ($errors->all() as $error)
                <span>{{ $error }}</span>
                @endforeach
            </div>
            @endif
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
        </form>
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