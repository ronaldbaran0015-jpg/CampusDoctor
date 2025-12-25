<div class="col-md-4">
    <div class="stat-card">
        <div class="d-flex justify-content-between align-items-start p-3 pb-1">
            <div class="d-flex align-items-center gap-1">
                <span class="fw-semibold">Patients</span>
            </div>
            <button class="btn btn-sm p-0 border-0 bg-transparent ">
                <i class=" fa fa-ellipsis-v"></i>
            </button>
        </div>
        <!-- main number + percentage -->
        <div class="d-flex justify-content-between px-3 gap-2 pt-1 pb-3">
            <div class="stat-value"><span class="status-badge success fs-3" id="patientCount">{{$patientCount ?? '0'}}</span></div>

            <i class="bx bx-user fa-2x"></i>
        </div>
        <!-- divider -->
        <hr class="m-0">
        <!-- bottom line -->
        <div class="d-flex justify-content-between align-items-center p-2">
            <span class="small">Registered patient</span>
            <!-- “Details →” link styled like the screenshot -->
            <a href="{{route('patients.show')}}" class="btn btn-outline-primary  btn-sm bottom-link d-flex align-items-center gap-1">
                Details <i class="fa fa-arrow-right text-primary"></i>
            </a>
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="shadow-sm stat-card">
        <div class="d-flex justify-content-between align-items-start p-3 pb-1">
            <div class="d-flex align-items-center gap-1">
                <span class="fw-semibold">Doctors</span>
            </div>
            <button class="btn btn-sm p-0 border-0 bg-transparent ">
                <i class=" fa fa-ellipsis-v"></i>
            </button>
        </div>
        <!-- main number + percentage -->
        <div class="d-flex justify-content-between px-3 gap-2 pt-1 pb-3">
            <div class="stat-value"><span class="status-badge primary fs-3" id="doctorCount">{{$doctorCount ??'0'}}</span></div>

            <i class="bx bx-group fa-2x"></i>
        </div>
        <!-- divider -->
        <hr class="m-0">
        <!-- bottom line -->
        <div class="d-flex justify-content-between align-items-center p-2">
            <span class="small">Registered Doctors</span>
            <!-- “Details →” link styled like the screenshot -->
            <a href="{{route('doctors.show')}}" class="btn btn-outline-primary btn-sm bottom-link d-flex align-items-center gap-1">
                Details <i class="fa fa-arrow-right text-primary"></i>
            </a>
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="shadow-sm stat-card">
        <div class="d-flex justify-content-between align-items-start p-3 pb-1">
            <div class="d-flex align-items-center gap-1">
                <span class="fw-semibold">Staff</span>
            </div>
            <button class="btn btn-sm p-0 border-0 bg-transparent ">
                <i class=" fa fa-ellipsis-v"></i>
            </button>
        </div>
        <!-- main number + percentage -->
        <div class="d-flex justify-content-between px-3 gap-2 pt-1 pb-3">
            <div class="stat-value"><span class="status-badge warning fs-3" id="staffCount">{{$staffCount ??'0'}}</span></div>

            <i class="bx bx-group fa-2x"></i>
        </div>
        <!-- divider -->
        <hr class="m-0">
        <!-- bottom line -->
        <div class="d-flex justify-content-between align-items-center p-2">
            <span class="small">Registered Staff</span>
            <!-- “Details →” link styled like the screenshot -->
            <a href="{{route('staffs.show')}}" class="btn btn-outline-primary btn-sm bottom-link d-flex align-items-center gap-1">
                Details <i class="fa fa-arrow-right text-primary"></i>
            </a>
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="shadow-sm stat-card">
        <div class="d-flex justify-content-between align-items-start p-3 pb-1">
            <div class="d-flex align-items-center gap-1">
                <span class="fw-semibold">Appointment</span>
            </div>
            <button class="btn btn-sm p-0 border-0 bg-transparent ">
                <i class=" fa fa-ellipsis-v"></i>
            </button>
        </div>
        <!-- main number + percentage -->
        <div class="d-flex px-3 justify-content-between gap-2 pt-1 pb-3">
            <div class="stat-value"><span class="status-badge royal fs-3" id="appointmentCount">{{$appointmentCount}}</span></div>
            <i class="bx bx-calendar  fa-2x"></i>
        </div>
        <!-- divider -->
        <hr class="m-0">
        <!-- bottom line -->
        <div class="d-flex justify-content-between align-items-center p-2">
            <span class="small">Last month</span>
            <!-- “Details →” link styled like the screenshot -->
            <a href="{{route('appointments.show')}}" class="btn btn-outline-primary btn-sm bottom-link d-flex align-items-center gap-1">
                Details <i class="fa fa-arrow-right text-primary"></i>
            </a>
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="shadow-sm stat-card">
        <div class="d-flex justify-content-between align-items-start p-3 pb-1">
            <div class="d-flex align-items-center gap-1">
                <span class="fw-semibold">Reports</span>
            </div>
            <button class="btn btn-sm p-0 border-0 bg-transparent ">
                <i class=" fa fa-ellipsis-v"></i>
            </button>
        </div>
        <!-- main number + percentage -->
        <div class="d-flex px-3 justify-content-between gap-2 pt-1 pb-3">
            <div class="stat-value"><span class="status-badge error fs-3" id="reportCount">{{$reportCount ?? '0'}}</span></div>
            <i class="bx bx-file  fa-2x"></i>
        </div>
        <!-- divider -->
        <hr class="m-0">
        <!-- bottom line -->
        <div class="d-flex justify-content-between align-items-center p-2">
            <span class="small">Last month</span>
            <!-- “Details →” link styled like the screenshot -->
            <a href="{{route('user_issue.show')}}" class="btn btn-outline-primary btn-sm bottom-link d-flex align-items-center gap-1">
                Details <i class="fa fa-arrow-right text-primary"></i>
            </a>
        </div>
    </div>
</div>