@extends('layouts.app')
@section('title', 'User Issue')
@section('content')
<div class="content-wrapper">

    <div class="setting-section container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="top-heading">Issue Details</h4>
        </div>
        <br>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Issue Details</h5>
                <p class="card-text">User: {{ $problemReport->patient->name }}</p>
                <p class="card-text">Category: {{ $problemReport->category }}</p>
                <p class="card-text">Description: {{ $problemReport->description }}</p>

                <div class="accordion" id="accordionExample">

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseOne"
                                aria-expanded="false"
                                aria-controls="collapseOne">
                                Screenshot
                            </button>
                        </h2>
                        <div id="collapseOne"
                            class="accordion-collapse collapse"
                            aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="border p-3">
                                    @if (!$problemReport->screenshot)
                                    <p>No screenshots uploaded</p>
                                    @else
                                    <img src="{{ asset('storage/' . $problemReport->screenshot) }}" alt="Screenshot" width="30%">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div><br>

                <h5 class="card-title">Replies</h5>
                @foreach($problemReport->replies as $reply)
                <p class="card-text">{{ $reply->reply }} ({{ $reply->admin->adminname }})</p>
                @endforeach

                <form action="{{ route('admin.problem-report-reply.store', $problemReport->id) }}" method="post">
                    @csrf
                    <textarea name="reply" placeholder="Add a reply..." class="form-control"></textarea><br>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>








    </div>





</div>




<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


@endsection