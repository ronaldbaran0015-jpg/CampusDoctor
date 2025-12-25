<h5 class="heading">Featured Analysis</h5>
<div class="row g-2">
    <div class="col-md-4">
        <div class="border p-3">
            <h6 class="sub-heading">Yearly Appointments</h6>
            <div class="chart-container">
                <div id="line-chart"></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="border p-3">
            <h6 class="sub-heading">Monthly Appointments</h6>
            <div class="d-flex justify-content-between align-items-center mb-2" style="background-color: var(--outgoing-bg); color:var(--txt-color);">
                <i id="month-prev" class="fa fa-arrow-left" style="cursor:pointer;"></i>
                <h5 id="selected-year" class="m-0"></h5>
                <i id="month-next" class="fa fa-arrow-right" style="cursor:pointer;"></i>
            </div>
            <div class="chart-container">
                <div id="bar-chart"></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="border p-3">
            <h6 class="sub-heading">Daily Appointments</h6>
            <div class="chart-container">
                <canvas id="complaintChart" height="180"></canvas>
            </div>
        </div>
    </div>
</div>