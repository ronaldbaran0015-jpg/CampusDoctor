<h5 class="heading">Overview</h5>
<aside class="row g-2 mb-4">

    <div class="col-md-4">
        <div class="stat-card shadow-sm">
            <div class="d-flex justify-content-between align-items-start p-3 pb-1">
                <div class="d-flex align-items-center gap-1">
                    <span class="fw-semibold">Finished Appointment</span>
                </div>
               
            </div>

            <div class="d-flex justify-content-between px-3 gap-2 pt-1 pb-3">
                <div class="stat-value"><span class="status-badge primary fs-3">0</span></div>

                <i class="bx bx-calendar-check fa-2x"></i>
            </div>
            <!-- divider -->
            <hr class="m-0 text">
            <!-- bottom line -->
            <div class="d-flex justify-content-between align-items-center p-2">
                <span class="small">This Month</span>
                <!-- “Details →” link styled like the screenshot -->
                <a href="#" class="btn btn-outline-primary  btn-sm bottom-link d-flex align-items-center gap-1">
                    Details <i class="fa fa-arrow-right text-primary"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="shadow-sm stat-card shadow-sm">
            <div class="d-flex justify-content-between align-items-start p-3 pb-1">
                <div class="d-flex align-items-center gap-1">
                    <span class="fw-semibold">Total Appointments</span>
                </div>
               
            </div>

            <div class="d-flex px-3 justify-content-between gap-2 pt-1 pb-3">
                <div class="stat-value"><span class="status-badge royal fs-3">{{$appointmentCount}}</span></div>

                <i class="bx bx-bookmark fa-2x"></i>
            </div>
            <!-- divider -->
            <hr class="m-0 text">
            <!-- bottom line -->
            <div class="d-flex justify-content-between align-items-center p-2">
                <span class="small">This Month</span>
                <!-- “Details →” link styled like the screenshot -->
                <a href="#" class="btn btn-outline-primary btn-sm bottom-link d-flex align-items-center gap-1">
                    Details <i class="fa fa-arrow-right text-primary"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="shadow-sm stat-card shadow-sm">
            <div class="d-flex justify-content-between align-items-start p-3 pb-1">
                <div class="d-flex align-items-center gap-1">
                    <span class="fw-semibold">Total Schedule</span>
                </div>
               
            </div>

            <div class="d-flex px-3 justify-content-between gap-2 pt-1 pb-3">
                <div class="stat-value"><span class="status-badge success fs-3">{{$scheduleCount}}</span></div>
                <i class=" bx bx-calendar fa-2x"></i>
            </div>
            <!-- divider -->
            <hr class="m-0 text">
            <!-- bottom line -->
            <div class="d-flex justify-content-between align-items-center p-2">
                <span class="small">This Month</span>
                <!-- “Details →” link styled like the screenshot -->
                <a href="#" class="btn btn-outline-primary btn-sm bottom-link d-flex align-items-center gap-1">
                    Details <i class="fa fa-arrow-right text-primary"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="shadow-sm stat-card shadow-sm">
            <div class="d-flex justify-content-between align-items-start p-3 pb-1">
                <div class="d-flex align-items-center gap-1">
                    <span class="fw-semibold">Today's Appointment</span>
                </div>
               
            </div>

            <div class="d-flex px-3 justify-content-between gap-2 pt-1 pb-3">
                <div class="stat-value"><span class="status-badge error fs-3">{{$current ?? 0}}</span></div>

                <i class="bx bx-bookmark fa-2x"></i>
            </div>
            <!-- divider -->
            <hr class="m-0 text">
            <!-- bottom line -->
            <div class="d-flex justify-content-between align-items-center p-2">
                <span class="small">This Day</span>
                <!-- “Details →” link styled like the screenshot -->
                <a href="#" class="btn btn-outline-primary btn-sm bottom-link d-flex align-items-center gap-1">
                    Details <i class="fa fa-arrow-right text-primary"></i>
                </a>
            </div>
        </div>
    </div>

</aside>