@extends('layouts.app')
@section('title','Create Appointment')
@section('content')

<section class="content-wrapper p-3">

    <div class="container-fluid">
        <article class="d-flex align-items-center  justify-content-between gap-5 mb-4">
            <h4 class="top-heading mb-0">New Appointment</h4>
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
        <div class="section-card mt-3 shadow-sm border rounded p-3 ">
            <form action="{{ route('appointments.add') }}" method="POST" class="row g-3">
                @csrf

                <!-- Doctor (hidden) -->
                <input type="hidden" name="doctor_id" value="{{ Auth::guard('doctor')->user()->docid }}">

                <!-- Patient details -->
                <div class="col-12">
                    <h6 class="sub-heading">Patient Details</h6>
                </div>


                <div class="col-md-6 position-relative">
                    <label class="form-label text">Full name<span class="text-danger">*</span></label>
                    <input type="text" id="patient_name" name="name" class="form-control" placeholder="Patient Name" autocomplete="off" value="{{ old('name') }}" required>
                    @error('name') <div class="text-danger small">{{ $message }}</div> @enderror

                    <!-- Suggestions box -->
                    <div id="name-suggestions" class="list-group position-absolute w-100 shadow-sm"
                        style="z-index: 1000; display: none; max-height: 200px; overflow-y: auto;">
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label text">Email</label>
                    <input type="email" id="patient_email" name="email" class="form-control" value="{{ old('email') }}">
                    @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label text">Contact</label>
                    <input type="text" id="patient_contact" name="contact" class="form-control" value="{{ old('phone') }}">
                    @error('contact') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label text">Address</label>
                    <input type="text" id="patient_address" name="address" class="form-control" value="{{ old('address') }}">
                    @error('address') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>



                <!-- Appointment details -->
                <div class="col-12 mt-2">
                    <h6 class="sub-heading">Appointment</h6>
                </div>

                <div class="col-12">
                    <label class="form-label text">Select Schedule<span class="text-danger">*</span></label>

                    <select name="schedule_id" class="form-select" required>
                        <option value="">-- Select Schedule --</option>

                        @foreach($schedules as $s)
                        <option value="{{ $s->scheduleid }}">
                            {{ \Carbon\Carbon::parse($s->scheduledate)->format('F d, Y') }}
                            — {{ \Carbon\Carbon::parse($s->start_time)->format('h:i A') }}
                            to {{ \Carbon\Carbon::parse($s->end_time)->format('h:i A') }}
                            (Slots: {{ $s->nop }})
                        </option>
                        @endforeach
                    </select>

                    @error('schedule_id') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>


                <div class="col-12">
                    <label class="form-label text">Reason (optional)</label>
                    <textarea name="reason" class="form-control" rows="3">{{ old('reason') }}</textarea>
                    @error('reason') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="col-12 d-flex justify-content-end gap-2">
                    <a href="javascript:history.back()" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary" id="book-btn">Create Appointment</button>
                </div>
            </form>
        </div>
    </div>
</section>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('patient_name');
        const suggestionBox = document.getElementById('name-suggestions');
        const emailInput = document.getElementById('patient_email');
        const phoneInput = document.getElementById('patient_contact');
        const addressInput = document.getElementById('patient_address');

        input.addEventListener('keyup', function() {
            const query = this.value.trim();
            if (query.length < 2) {
                suggestionBox.style.display = 'none';
                return;
            }

            fetch("{{ route('patients.search') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        search: query
                    })
                })
                .then(res => res.json())
                .then(data => {
                    suggestionBox.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(patient => {
                            const item = document.createElement('button');
                            item.type = 'button';
                            item.className = 'list-group-item list-group-item-action';
                            item.textContent = patient.name + " (" + patient.address + ")";
                            item.addEventListener('click', function() {
                                input.value = patient.name;
                                emailInput.value = patient.email ?? '';
                                phoneInput.value = patient.contact ?? '';
                                addressInput.value = patient.address ?? '';
                                suggestionBox.style.display = 'none';
                            });
                            suggestionBox.appendChild(item);
                        });
                        suggestionBox.style.display = 'block';
                    } else {
                        suggestionBox.innerHTML = '<div class="list-group-item text-muted">No matching patients found</div>';
                        suggestionBox.style.display = 'block';
                    }
                })
                .catch(err => console.error(err));
        });

        document.addEventListener('click', function(e) {
            if (!input.contains(e.target) && !suggestionBox.contains(e.target)) {
                suggestionBox.style.display = 'none';
            }
        });
    });
</script>
@endsection