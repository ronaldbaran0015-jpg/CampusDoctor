@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<section class="content-wrapper px-3">
    <div class="row mt-2">
        <div class="col-md-4 col-lg-8 ">
            <div class="greet-card d-flex col-md-6 col-lg-12 p-3 rounded mb-3">
                <div class="row">
                    <article class="col-md-7">
                        <h1 class="heading">Welcome back, {{$admin->adminname}}!</h1>
                        <p class="">
                            Track your past and future appointments history for your doctor or medical consultant.</p>
                        <button class="theme-btn px-3">Get updated</button>
                    </article>
                </div>
            </div>
            <h5 class="heading">Overview</h5>

            <div class="row g-2 mb-4">
                @include('admin.components.card-stats')

            </div>
        </div>
        <!-- Calendar -->
        @include('admin.components.calendar')

        <!-- Charts  -->
        @include('admin.components.chart')

        <!-- Table -->
        @include('admin.components.appointment-table')

    </div>
</section>
<script src="{{asset('assets/js/jquery-1.10.2.js')}}"></script>
<script>
    function updateStats() {
        $.ajax({
            url: "{{ route('admin.stats') }}",
            method: "GET",
            type: 'GET',
            success: function(data) {
                $('#patientCount').text(data.patientCount);
                $('#doctorCount').text(data.doctorCount);
                $('#staffCount').text(data.staffCount);
                $('#appointmentCount').text(data.appointmentCount);
                $('#reportCount').text(data.reportCount);
            }
        });
    }
    // Refresh every 3 seconds
    setInterval(updateStats, 3000);
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetch("{{ route('chart.data') }}")
            .then(response => response.json())
            .then(result => {
                // --- Yearly (Apex Line) ---
                new ApexCharts(document.querySelector('#line-chart'), {
                    chart: {
                        height: 200,
                        type: 'line',
                        fontFamily: 'Helvetica, Arial, sans-serif',
                        foreColor: 'var(--txt-color)',
                        toolbar: {
                            show: false
                        },
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },
                    series: [{
                        name: 'Yearly Appointments',
                        data: result.yearly.data,
                        color: '#007bff'
                    }],
                    xaxis: {
                        categories: result.yearly.labels
                    },
                    title: {
                        text: 'Yearly Appointments',
                        align: 'left',
                        offsetY: 5,
                        style: {
                            fontSize: '14px',
                            fontWeight: 'bold',
                            color: 'var(--txt-color)'
                        },
                    },
                    grid: {
                        borderColor: '#D9DBF3'
                    }
                }).render();

                // --- Monthly (Apex Bar) ---
                let currentYear = new Date().getFullYear();
                const selectedYearEl = document.getElementById('selected-year');
                const monthlyChart = new ApexCharts(document.querySelector('#bar-chart'), {
                    chart: {
                        height: 260,
                        type: 'bar',
                        foreColor: 'var(--txt-color)',
                        toolbar: {
                            show: false
                        },
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 6,
                            columnWidth: '100%',
                        }
                    },
                    series: [{
                        name: 'Monthly Appointments',
                        data: result.monthly.data,
                        color: '#28a745'
                    }],
                    xaxis: {
                        categories: result.monthly.labels
                    },
                    title: {
                        text: 'Monthly Appointments',
                        align: 'left',
                        offsetY: 15,
                        style: {
                            fontSize: '14px',
                            fontWeight: 'bold',
                            color: 'var(--txt-color)'
                        },
                    },
                    grid: {
                        borderColor: '#D9DBF3'
                    }
                })
                monthlyChart.render();

                // helper to fetch and update monthly chart for a given year
                function loadMonthlyChart(year) {
                    fetch(`{{ route('chart.data') }}?year=${year}`)
                        .then(resp => resp.json())
                        .then(json => {
                            const labels = json.monthly.labels;
                            const data = json.monthly.data;
                            monthlyChart.updateOptions({
                                xaxis: {
                                    categories: labels
                                },
                            });
                            monthlyChart.updateSeries([{
                                name: 'Monthly Appointments',
                                data: data
                            }]);
                            selectedYearEl.innerText = year;
                        })
                        .catch(err => {
                            console.error('Monthly chart load error:', err);
                        });
                }

                // wire prev/next
                document.getElementById('month-prev').addEventListener('click', () => {
                    currentYear--;
                    loadMonthlyChart(currentYear);
                });
                document.getElementById('month-next').addEventListener('click', () => {
                    currentYear++;
                    loadMonthlyChart(currentYear);
                });

                // initial load
                loadMonthlyChart(currentYear);

                // --- Daily (Chart.js) ---
                const dailyLabels = result.daily.labels;
                const dailyData = result.daily.data;
                const total = dailyData.reduce((a, b) => a + b, 0);
                const ctx = document.getElementById("complaintChart").getContext("2d");
                new Chart(ctx, {
                    type: "bar",
                    data: {
                        labels: dailyLabels,
                        datasets: [{
                            data: dailyData,
                            backgroundColor: dailyData.map((_, i) => i === dailyData.length - 1 ? "#007bff" : "#10b981"),
                            borderRadius: 6,
                            barThickness: 10
                        }]
                    },
                    options: {
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: "#666"
                                }
                            },
                            y: {
                                grid: {
                                    color: "#222"
                                },
                                ticks: {
                                    color: "#888",
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            })
            .catch(err => console.error('Error loading charts:', err));
    });
</script>
@endsection