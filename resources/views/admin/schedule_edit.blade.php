@extends('layouts.app')
@section('title', 'Schedule Details')
@section('content')
<section class="content-wrapper">
    <div class="container-fluid">
        <article class="d-flex align-items-center  justify-content-between gap-5 mb-4">
            <legend class="top-heading mb-0">Dr. {{$schedule->mydoctor->name ?? ''}}</legend>
        </article>

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

        <form method="post" action="{{route('schedule.update', $schedule->scheduleid)}}">
            @csrf
            <fieldset>
                <input type="hidden" id="schedule_id" name="schedule_id">
                <div class="row">
                    <div class="mb-3 col">
                        <label class="form-label text">Title</label>
                        <input type="text" id="edit_title" value="{{$schedule->title}}" name="title" class="form-control" required>
                    </div>

                    <div class="mb-3 col">
                        <label class="form-label text">Date</label>
                        <input type="date" id="edit_date" x value="{{$schedule->scheduledate}}" name="scheduledate" class="form-control" required>
                    </div>
                </div>
                <div class="row">

                    <div class="mb-3 col">
                        <label class="form-label text">Start Time</label>
                        <input type="time" id="edit_start" value="{{$schedule->start_time}}" name="start_time" class="form-control" required>
                    </div>

                    <div class="mb-3 col">
                        <label class="form-label text">End Time</label>
                        <input type="time" id="edit_end" value="{{$schedule->end_time}}" name="end_time" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text">NOP</label>
                    <input type="number" min="1" id="edit_nop" value="{{$schedule->nop}}" name="nop" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success">Update Schedule</button>
            </fieldset>
        </form>




    </div>
</section>



@endsection