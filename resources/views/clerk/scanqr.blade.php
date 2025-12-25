@extends('layouts.app')
@section('title', 'Appointment Scan')
@section('content')
<script src="https://unpkg.com/html5-qrcode"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .record-paper {
        width: 500px;
        background: var(--paper);
        padding: 1.5rem;
        margin: 0;
        border: 4px solid var(--ink);
        box-shadow: 0 10px 18px rgba(0, 0, 0, .6);
    }

    .mini-heading {
        font-size: .55rem;
        letter-spacing: .05rem;
        text-transform: uppercase;
        font-weight: 600;
    }

    hr.divider {
        border-top: 3px solid var(--ink);
        opacity: 1;
        margin: .35rem 0 .5rem;
    }

    .label {
        font-weight: 600;
    }

    .value {
        margin-left: .25rem;
    }

    .details-line {
        font-size: .85rem;
        margin-bottom: .2rem;
    }

    /* two-column layout */
    .left-col {
        flex: 1;
    }

    .right-col {
        width: 225px;
    }

    /* fingerprint table */
    .fingerprint img {
        width: 100%;
        border: 1px solid var(--ink);
    }

    /* typographic tweaks */
    h5 {
        font-size: 1.05rem;
    }

    h6 {
        font-size: .9rem;
    }

    ul {
        padding-left: 1rem;
        margin-bottom: .5rem;
    }

    ul li {
        font-size: .8rem;
    }

    #result,
    #reader {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;

    }
</style>
</head>

    <div class="container py-5">
        <h2 class="top-heading"><i class="fa fa-qrcode"></i> Scan Appointment QR</h2>
        <div class="row">
            <div class="col-md-8">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white d-flex align-items-center">
                        <i class="bi bi-qr-code-scan me-2"></i>
                        <h5 class="mb-0">Scan Appointment QR</h5>
                    </div>
                    <div class="card-body">
                        <div id="reader" class="mb-4">
                            <!-- QR scanner will be initialized here -->
                        </div>
                        <div id="result" class="text-center">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        let html5QrcodeScanner;

        function onScanSuccess(decodedText, decodedResult) {
            let qrData = {};
            try {
                qrData = JSON.parse(decodedText); // convert string to JSON
            } catch (e) {
                alert("Invalid QR format");
                return;
            }
            // ✅ Stop scanner temporarily after a successful scan
            html5QrcodeScanner.clear();
            // ✅ Display results neatly with Done button
            document.getElementById("result").innerHTML = `
              <section class="record-paper">
                <div class="content-row">
                    <!-- LEFT COLUMN -->
                    <div class="left-col">
                        <!-- logo & title -->
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/bc/Seal_of_the_Central_Intelligence_Agency.svg/80px-Seal_of_the_Central_Intelligence_Agency.svg.png" width="58" alt="CIA seal">
                            <div>
                                <div class="mini-heading">CampusDoctor Appointment</div>
                                <h5 class="mb-0">Patient Record</h5>
                                <small class="text-uppercase">ufo/DOOP-0221A</small>
                            </div>
                        </div>
                        <!-- GENERAL INFO -->
                        <div class="details mt-3">
                            <div class="details-line"><span class="label">#</span>JNK160196BP080816</div>
                            <hr class="divider">

                            <div class="details-line"><span class="label">ID:</span><span class="value">${qrData.appoid}</span></div>
                            <div class="details-line"><span class="label">Name:</span><span class="value"> ${qrData.patientname}</span></div>
                            <div class="details-line"><span class="label">Doctor:</span><span class="value">${qrData.doctor}</span></div>
                            <div class="details-line"><span class="label">Date:</span><span class="value">${qrData.date}</span></div>
                            <div class="details-line"><span class="label">Time:</span><span class="value">${qrData.time}</span></div>

                        </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-success" id="doneBtn">✅ Done</button>
                        </div>

                    </div>


                </div>
            </section>
        `;
            fetch("http://127.0.0.1:8000/verify-qr", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(qrData)
                })
                .then(res => res.json())
                .then(data => {
                    let responseBox = document.createElement("div");
                    responseBox.className = "alert alert-info mt-2";
                    responseBox.innerText = data.message;
                    document.getElementById("result").appendChild(responseBox);
                })
                .catch(err => console.error(err));

            // ✅ Attach event for Done button
            setTimeout(() => {
                document.getElementById("doneBtn").addEventListener("click", () => {
                    document.getElementById("result").innerHTML = ""; // clear results
                    restartScanner();
                });
            }, 200); // slight delay so button exists
        }

        function onScanFailure(error) {
            // ignore errors
        }

        function restartScanner() {
            html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", {
                    fps: 10,
                    qrbox: 250
                }
            );
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        }

        // ✅ Start scanner on page load
        document.addEventListener("DOMContentLoaded", restartScanner);
    </script>
    @endsection