<!-- ===============================
     PROGRESS VIEW – MOBILE APP UI
     =============================== -->

<!-- DATE FILTERS -->
<div class="card pwa-card pwa-card-shadow mb-3 pwa-progress-filters">

    <div class="card-body">

        <div class="row g-2 mb-2">
            <div class="col-6">
                <input type="date" class="form-control">
            </div>
            <div class="col-6">
                <input type="date" class="form-control">
            </div>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm w-100">Last Week</button>
            <button class="btn btn-outline-secondary btn-sm w-100">Last Month</button>
            <button class="btn btn-outline-secondary btn-sm w-100">Last Year</button>
        </div>

    </div>
</div>

<!-- PROGRESS TYPE TABS -->
<ul class="nav nav-pills nav-fill mb-3 small pwa-progress-tabs">
    
    <li class="nav-item">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#academicTab">
            Academic
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#attendanceTab">
            Attendance
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#medicalTab">
            Medical
        </button>
    </li>
</ul>

<!-- TAB CONTENT -->
<div class="tab-content">

    <!-- ================= ACADEMIC ================= -->
    <div class="tab-pane fade show active" id="academicTab">

        <div class="card mb-3 pwa-progress-card">
            
            <div class="card-body">

                <h6 class="mb-2">Mathematics</h6>

                <div class="small pwa-muted mb-1">Marks</div>
                <div class="progress mb-2" style="height:10px;">
                    <div class="progress-bar bg-success" style="width:85%"></div>
                </div>

                <div class="d-flex justify-content-between small">
                    <span>85 / 100</span>
                    <span>Grade A</span>
                </div>

            </div>
        </div>

        <div class="card mb-3 pwa-progress-card">

            <div class="card-body">

                <h6 class="mb-2">English</h6>

                <div class="small pwa-muted mb-1">Marks</div>
                <div class="progress mb-2" style="height:10px;">
                    <div class="progress-bar bg-warning" style="width:72%"></div>
                </div>

                <div class="d-flex justify-content-between small">
                    <span>72 / 100</span>
                    <span>Grade B</span>
                </div>

            </div>
        </div>

    </div>

    <!-- ================= ATTENDANCE ================= -->
    <div class="tab-pane fade" id="attendanceTab">

        <div class="card mb-3 pwa-progress-card">

            <div class="card-body text-center">

                <h6 class="mb-2">Overall Attendance</h6>

                <div class="progress mb-2" style="height:14px;">
                    <div class="progress-bar bg-success" style="width:92%"></div>
                </div>

                <strong>92%</strong>

            </div>
        </div>

        <div class="card mb-3 pwa-progress-card">

            <div class="card-body">

                <div class="d-flex justify-content-between mb-2">
                    <span>Total Days</span>
                    <strong>180</strong>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span>Present</span>
                    <strong class="text-success">166</strong>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span>Absent</span>
                    <strong class="text-danger">14</strong>
                </div>

            </div>
        </div>

    </div>

    <!-- ================= MEDICAL ================= -->
    <div class="tab-pane fade" id="medicalTab">

        <div class="card mb-3 pwa-progress-card">

            <div class="card-body">

                <div class="d-flex justify-content-between mb-2">
                    <span>Blood Group</span>
                    <strong>B+</strong>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span>Allergies</span>
                    <strong>None</strong>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span>Medical Notes</span>
                    <strong>Fit for School</strong>
                </div>

            </div>
        </div>

        <div class="card mb-3 pwa-progress-card">

            <div class="card-body">

                <h6 class="mb-2">Medical Visits</h6>

                <ul class="list-group list-group-flush small">
                    <li class="list-group-item">
                        12 Jan 2026 – Fever
                    </li>
                    <li class="list-group-item">
                        03 Mar 2026 – Routine Checkup
                    </li>
                </ul>

            </div>
        </div>

    </div>

</div>