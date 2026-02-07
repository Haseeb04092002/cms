<!-- ===============================
     CALENDAR VIEW
     =============================== -->

<!-- ================= PARENT TABS ================= -->
<ul class="nav nav-pills nav-fill mb-3 pwa-calendar-parent-tabs">
    <li class="nav-item">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#lecturesTab">
            Lectures
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#examsTab">
            Exams
        </button>
    </li>
</ul>

<div class="tab-content">

    <!-- ================= LECTURES ================= -->
    <div class="tab-pane fade show active" id="lecturesTab">

        <!-- CHILD TABS -->
        <ul class="nav nav-pills nav-fill mb-2 pwa-calendar-child-tabs">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#lectureToday">
                    Today
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#lectureWeek">
                    This Week
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#lectureMonth">
                    This Month
                </button>
            </li>
        </ul>

        <div class="tab-content">

            <!-- ===== TODAY ===== -->
            <div class="tab-pane fade show active" id="lectureToday">

                <div class="pwa-timetable-wrapper">

                    <div class="pwa-timetable-header">
                        <div class="pwa-day-col">Day</div>
                        <div class="pwa-period-col">08–09</div>
                        <div class="pwa-period-col">09–10</div>
                    </div>

                    <div class="pwa-timetable-row">
                        <div class="pwa-day-col">Mon</div>

                        <div class="pwa-lecture-card">
                            <strong>Computer</strong>
                            <small>Usman</small>
                        </div>

                        <div class="pwa-lecture-card">
                            <strong>Math</strong>
                            <small>Usman</small>
                        </div>
                    </div>

                </div>

            </div>

            <!-- ===== THIS WEEK ===== -->
            <div class="tab-pane fade" id="lectureWeek">

                <div class="pwa-timetable-wrapper">

                    <div class="pwa-timetable-header">
                        <div class="pwa-day-col">Day</div>
                        <div class="pwa-period-col">08–09</div>
                        <div class="pwa-period-col">09–10</div>
                    </div>

                    <div class="pwa-timetable-row">
                        <div class="pwa-day-col">Tue</div>
                        <div class="pwa-lecture-card">
                            <strong>English</strong>
                            <small>Ali</small>
                        </div>
                        <div class="pwa-lecture-card">
                            <strong>Science</strong>
                            <small>Ali</small>
                        </div>
                    </div>

                </div>

            </div>

            <!-- ===== THIS MONTH ===== -->
            <div class="tab-pane fade" id="lectureMonth">
                <div class="text-center pwa-muted p-4">
                    Monthly lecture view will appear here
                </div>
            </div>

        </div>
    </div>

    <!-- ================= EXAMS ================= -->
    <div class="tab-pane fade" id="examsTab">

        <!-- CHILD TABS -->
        <ul class="nav nav-pills nav-fill mb-2 pwa-calendar-child-tabs">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#examToday">
                    Today
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#examWeek">
                    This Week
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#examMonth">
                    This Month
                </button>
            </li>
        </ul>

        <div class="tab-content">

            <div class="tab-pane fade show active" id="examToday">
                <div class="card pwa-exam-card mb-3">
                    <div class="card-body">
                        <h6 class="mb-1">Mathematics</h6>
                        <div class="small pwa-muted">10:00 – 12:00</div>
                        <div class="small">Hall A</div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="examWeek">
                <div class="card pwa-exam-card mb-3">
                    <div class="card-body">
                        <h6 class="mb-1">English</h6>
                        <div class="small pwa-muted">Mon • 09:00 – 11:00</div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="examMonth">
                <div class="text-center pwa-muted p-4">
                    Monthly exam schedule will appear here
                </div>
            </div>

        </div>
    </div>

</div>