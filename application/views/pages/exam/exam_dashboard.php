<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-semibold" href="#">School Management</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="topNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="#">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link active" href="#">Exams & Results</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Students</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Fees</a></li>
            </ul>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#helpPanel">Help</button>
                <button class="btn btn-outline-danger btn-sm">Logout</button>
            </div>
        </div>
    </div>
</nav>

<div class="container-fluid py-3">

    <!-- Header / Actions -->
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-2 mb-3">
        <div>
            <h4 class="mb-0">Exam & Result Management</h4>
            <div class="text-secondary small">Create exams, schedule, grading, marks entry, and result compilation.</div>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateExam">
                Create Exam
            </button>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalScheduleExam">
                Schedule Exam
            </button>
            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalGrading">
                Grading Structure
            </button>
            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalQuickMarks">
                Quick Marks Entry
            </button>
        </div>
    </div>

    <!-- Quick Filters -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <div class="row g-2 align-items-end">
                <div class="col-12 col-md-3">
                    <label class="form-label">Session</label>
                    <select class="form-select">
                        <option>2025-2026</option>
                        <option>2024-2025</option>
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label">Class</label>
                    <select class="form-select">
                        <option selected>Select Class</option>
                        <option>Play Group</option>
                        <option>Nursery</option>
                        <option>KG</option>
                        <option>1st</option>
                        <option>2nd</option>
                        <option>3rd</option>
                        <option>4th</option>
                        <option>5th</option>
                        <option>6th</option>
                        <option>7th</option>
                        <option>8th</option>
                        <option>9th</option>
                        <option>10th</option>
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label">Exam</label>
                    <select class="form-select">
                        <option selected>Select Exam</option>
                        <option>Mid Term</option>
                        <option>Final Term</option>
                        <option>Monthly Test - Jan</option>
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label">Search Student (Name / Adm#)</label>
                    <input type="text" class="form-control" placeholder="e.g. Ali / 1023">
                </div>

                <div class="col-12">
                    <div class="d-flex flex-wrap gap-2 mt-2">
                        <button class="btn btn-outline-primary">Load</button>
                        <button class="btn btn-outline-secondary">Reset</button>
                        <button class="btn btn-outline-success">Export Result (PDF)</button>
                        <button class="btn btn-outline-dark">Print</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Tabs -->
    <ul class="nav nav-pills gap-2 mb-3" id="mainTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabOverview" type="button">Overview</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabMarks" type="button">Marks Entry</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabResults" type="button">Results</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabSchedule" type="button">Schedule</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabGrading" type="button">Grading</button>
        </li>
    </ul>

    <div class="tab-content">

        <!-- OVERVIEW -->
        <div class="tab-pane fade show active" id="tabOverview">
            <div class="row g-3">
                <div class="col-12 col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="text-secondary small">Exams Created (This Session)</div>
                                    <div class="fs-3 fw-semibold">12</div>
                                </div>
                                <span class="badge text-bg-primary align-self-start">Active</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <div class="text-secondary small">Scheduled Papers</div>
                                <div class="fw-semibold">48</div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="text-secondary small">Pending Marks Entry</div>
                                <div class="fw-semibold text-warning">9</div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="text-secondary small">Results Published</div>
                                <div class="fw-semibold text-success">6</div>
                            </div>
                            <hr>
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateExam">Create New Exam</button>
                                <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalScheduleExam">Schedule Papers</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <div class="d-flex flex-column flex-md-row gap-2 justify-content-between align-items-md-center">
                                <div class="fw-semibold">Latest Exams</div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-secondary">Refresh</button>
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalCreateExam">Add Exam</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Exam</th>
                                            <th>Class</th>
                                            <th>Term</th>
                                            <th>Status</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="fw-semibold">Mid Term</td>
                                            <td>8th</td>
                                            <td>Term-1</td>
                                            <td><span class="badge text-bg-success">Published</span></td>
                                            <td class="text-end">
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-primary">View</button>
                                                    <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalQuickMarks">Marks</button>
                                                    <button class="btn btn-outline-secondary">Edit</button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Monthly Test - Jan</td>
                                            <td>6th</td>
                                            <td>Monthly</td>
                                            <td><span class="badge text-bg-warning">In Progress</span></td>
                                            <td class="text-end">
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-primary">View</button>
                                                    <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalQuickMarks">Marks</button>
                                                    <button class="btn btn-outline-secondary">Edit</button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Final Term</td>
                                            <td>10th</td>
                                            <td>Term-2</td>
                                            <td><span class="badge text-bg-secondary">Draft</span></td>
                                            <td class="text-end">
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-primary">View</button>
                                                    <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalScheduleExam">Schedule</button>
                                                    <button class="btn btn-outline-secondary">Edit</button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- MARKS ENTRY -->
        <div class="tab-pane fade" id="tabMarks">
            <div class="row g-3">
                <div class="col-12 col-lg-5">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white fw-semibold">Marks Entry Workflow</div>
                        <div class="card-body">
                            <div class="accordion" id="marksAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#mk1">
                                            Step 1: Select Exam + Class + Subject
                                        </button>
                                    </h2>
                                    <div id="mk1" class="accordion-collapse collapse show" data-bs-parent="#marksAccordion">
                                        <div class="accordion-body">
                                            <div class="row g-2">
                                                <div class="col-12">
                                                    <label class="form-label">Exam</label>
                                                    <select class="form-select">
                                                        <option selected>Mid Term</option>
                                                        <option>Final Term</option>
                                                        <option>Monthly Test</option>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label">Class</label>
                                                    <select class="form-select">
                                                        <option selected>8th</option>
                                                        <option>7th</option>
                                                        <option>6th</option>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label">Subject</label>
                                                    <select class="form-select">
                                                        <option selected>Mathematics</option>
                                                        <option>English</option>
                                                        <option>Science</option>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Max Marks</label>
                                                    <input type="number" class="form-control" value="100">
                                                </div>
                                                <div class="col-12 d-grid">
                                                    <button class="btn btn-outline-primary">Load Students</button>
                                                </div>
                                            </div>
                                            <div class="alert alert-info mt-3 mb-0">
                                                Tip: Use “Quick Marks Entry” for fast input, or enter per student below.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#mk2">
                                            Step 2: Enter Marks (Absent/Grace/Remarks)
                                        </button>
                                    </h2>
                                    <div id="mk2" class="accordion-collapse collapse" data-bs-parent="#marksAccordion">
                                        <div class="accordion-body">
                                            <div class="d-flex flex-wrap gap-2 mb-2">
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalQuickMarks">Open Quick Entry</button>
                                                <button class="btn btn-sm btn-outline-secondary">Mark All Present</button>
                                                <button class="btn btn-sm btn-outline-danger">Mark Absent Selected</button>
                                            </div>
                                            <div class="small text-secondary">
                                                Each row should support: marks, absent flag, grace marks, remarks. (Connect to DB later)
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#mk3">
                                            Step 3: Save + Lock Subject Result
                                        </button>
                                    </h2>
                                    <div id="mk3" class="accordion-collapse collapse" data-bs-parent="#marksAccordion">
                                        <div class="accordion-body">
                                            <div class="row g-2">
                                                <div class="col-12 col-md-6 d-grid">
                                                    <button class="btn btn-success">Save Marks</button>
                                                </div>
                                                <div class="col-12 col-md-6 d-grid">
                                                    <button class="btn btn-outline-dark">Lock Subject Entry</button>
                                                </div>
                                            </div>
                                            <div class="alert alert-warning mt-3 mb-0">
                                                Locking prevents accidental edits. Admin can unlock if needed.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-7">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white d-flex flex-column flex-md-row gap-2 justify-content-between align-items-md-center">
                            <div class="fw-semibold">Students Marks Sheet (Example)</div>
                            <div class="input-group input-group-sm" style="max-width: 340px;">
                                <span class="input-group-text">Search</span>
                                <input class="form-control" placeholder="Name / Adm#">
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width:1%"><input class="form-check-input" type="checkbox"></th>
                                            <th>Adm#</th>
                                            <th>Student</th>
                                            <th style="width:120px">Marks</th>
                                            <th style="width:120px">Grace</th>
                                            <th style="width:120px">Absent</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input class="form-check-input" type="checkbox"></td>
                                            <td>1023</td>
                                            <td class="fw-semibold">Ali Raza</td>
                                            <td><input type="number" class="form-control form-control-sm" value="78"></td>
                                            <td><input type="number" class="form-control form-control-sm" value="0"></td>
                                            <td>
                                                <select class="form-select form-select-sm">
                                                    <option selected>No</option>
                                                    <option>Yes</option>
                                                </select>
                                            </td>
                                            <td><input class="form-control form-control-sm" placeholder="Optional"></td>
                                        </tr>
                                        <tr>
                                            <td><input class="form-check-input" type="checkbox"></td>
                                            <td>1024</td>
                                            <td class="fw-semibold">Ayesha Khan</td>
                                            <td><input type="number" class="form-control form-control-sm" value="91"></td>
                                            <td><input type="number" class="form-control form-control-sm" value="0"></td>
                                            <td>
                                                <select class="form-select form-select-sm">
                                                    <option selected>No</option>
                                                    <option>Yes</option>
                                                </select>
                                            </td>
                                            <td><input class="form-control form-control-sm" placeholder="Optional"></td>
                                        </tr>
                                        <tr>
                                            <td><input class="form-check-input" type="checkbox"></td>
                                            <td>1025</td>
                                            <td class="fw-semibold">Usman Ahmed</td>
                                            <td><input type="number" class="form-control form-control-sm" value="0"></td>
                                            <td><input type="number" class="form-control form-control-sm" value="0"></td>
                                            <td>
                                                <select class="form-select form-select-sm">
                                                    <option>No</option>
                                                    <option selected>Yes</option>
                                                </select>
                                            </td>
                                            <td><input class="form-control form-control-sm" placeholder="Absent"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer bg-white">
                            <div class="d-flex flex-column flex-md-row gap-2 justify-content-between">
                                <div class="text-secondary small">
                                    Example only. Connect to DB for real-time load & save.
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-secondary btn-sm">Reset Changes</button>
                                    <button class="btn btn-success btn-sm">Save Marks</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <!-- RESULTS -->
        <div class="tab-pane fade" id="tabResults">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex flex-column flex-lg-row gap-2 justify-content-between align-items-lg-center">
                        <div class="fw-semibold">Result Compilation & Views</div>
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-outline-primary btn-sm">Compile Result (Selected)</button>
                            <button class="btn btn-outline-success btn-sm">Publish Result</button>
                            <button class="btn btn-outline-danger btn-sm">Unpublish</button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#resClass" type="button">Class Result</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#resStudent" type="button">Student Result</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#resExam" type="button">Exam Summary</button>
                        </li>
                    </ul>

                    <div class="tab-content pt-3">
                        <!-- Class Result -->
                        <div class="tab-pane fade show active" id="resClass">
                            <div class="row g-2 mb-3">
                                <div class="col-12 col-md-3">
                                    <label class="form-label">Class</label>
                                    <select class="form-select">
                                        <option selected>8th</option>
                                        <option>7th</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label">Exam</label>
                                    <select class="form-select">
                                        <option selected>Mid Term</option>
                                        <option>Final Term</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label">Sort By</label>
                                    <select class="form-select">
                                        <option selected>Total Marks</option>
                                        <option>Percentage</option>
                                        <option>Grade</option>
                                        <option>Position</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label">Search</label>
                                    <input class="form-control" placeholder="Student / Adm#">
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Pos</th>
                                            <th>Adm#</th>
                                            <th>Student</th>
                                            <th>Total</th>
                                            <th>%</th>
                                            <th>Grade</th>
                                            <th>Remarks</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="fw-semibold">1</td>
                                            <td>1024</td>
                                            <td class="fw-semibold">Ayesha Khan</td>
                                            <td>485/500</td>
                                            <td>97%</td>
                                            <td><span class="badge text-bg-success">A+</span></td>
                                            <td>Excellent</td>
                                            <td class="text-end">
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-primary">View</button>
                                                    <button class="btn btn-outline-secondary">Print</button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">2</td>
                                            <td>1023</td>
                                            <td class="fw-semibold">Ali Raza</td>
                                            <td>420/500</td>
                                            <td>84%</td>
                                            <td><span class="badge text-bg-primary">A</span></td>
                                            <td>Very Good</td>
                                            <td class="text-end">
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-primary">View</button>
                                                    <button class="btn btn-outline-secondary">Print</button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Student Result -->
                        <div class="tab-pane fade" id="resStudent">
                            <div class="row g-2 mb-3">
                                <div class="col-12 col-md-4">
                                    <label class="form-label">Student</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Adm#</span>
                                        <input class="form-control" placeholder="1023">
                                        <button class="btn btn-outline-primary">Load</button>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label">Exam</label>
                                    <select class="form-select">
                                        <option selected>Mid Term</option>
                                        <option>Final Term</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label">Actions</label>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-secondary w-100">Print</button>
                                        <button class="btn btn-outline-success w-100">PDF</button>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-12 col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="fw-semibold">Student Summary</div>
                                            <hr>
                                            <div class="small">
                                                <div><span class="text-secondary">Name:</span> Ali Raza</div>
                                                <div><span class="text-secondary">Class:</span> 8th</div>
                                                <div><span class="text-secondary">Exam:</span> Mid Term</div>
                                                <div><span class="text-secondary">Result:</span> <span class="badge text-bg-primary">A</span></div>
                                            </div>
                                            <hr>
                                            <div class="d-flex justify-content-between">
                                                <span class="text-secondary">Total</span>
                                                <span class="fw-semibold">420/500</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span class="text-secondary">Percentage</span>
                                                <span class="fw-semibold">84%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-8">
                                    <div class="card">
                                        <div class="card-header bg-white fw-semibold">Subject-wise Detail</div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-hover align-middle mb-0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Subject</th>
                                                            <th>Marks</th>
                                                            <th>Max</th>
                                                            <th>Grade</th>
                                                            <th>Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="fw-semibold">Math</td>
                                                            <td>78</td>
                                                            <td>100</td>
                                                            <td><span class="badge text-bg-primary">A</span></td>
                                                            <td>Good</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="fw-semibold">English</td>
                                                            <td>82</td>
                                                            <td>100</td>
                                                            <td><span class="badge text-bg-primary">A</span></td>
                                                            <td>Very Good</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="fw-semibold">Science</td>
                                                            <td>71</td>
                                                            <td>100</td>
                                                            <td><span class="badge text-bg-secondary">B+</span></td>
                                                            <td>Improve diagrams</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Exam Summary -->
                        <div class="tab-pane fade" id="resExam">
                            <div class="row g-2 mb-3">
                                <div class="col-12 col-md-4">
                                    <label class="form-label">Exam</label>
                                    <select class="form-select">
                                        <option selected>Mid Term</option>
                                        <option>Final Term</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label">Class</label>
                                    <select class="form-select">
                                        <option selected>8th</option>
                                        <option>7th</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label">Actions</label>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-primary w-100">Generate Summary</button>
                                        <button class="btn btn-outline-secondary w-100">Print</button>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-12 col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="fw-semibold">Statistics</div>
                                            <hr>
                                            <div class="d-flex justify-content-between"><span class="text-secondary">Students</span><span class="fw-semibold">32</span></div>
                                            <div class="d-flex justify-content-between"><span class="text-secondary">Pass</span><span class="fw-semibold text-success">29</span></div>
                                            <div class="d-flex justify-content-between"><span class="text-secondary">Fail</span><span class="fw-semibold text-danger">3</span></div>
                                            <div class="d-flex justify-content-between"><span class="text-secondary">Top %</span><span class="fw-semibold">97%</span></div>
                                            <div class="d-flex justify-content-between"><span class="text-secondary">Avg %</span><span class="fw-semibold">74%</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-8">
                                    <div class="card">
                                        <div class="card-header bg-white fw-semibold">Grade Distribution (Table)</div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-striped mb-0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Grade</th>
                                                            <th>Range</th>
                                                            <th>Students</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><span class="badge text-bg-success">A+</span></td>
                                                            <td>90-100</td>
                                                            <td>6</td>
                                                        </tr>
                                                        <tr>
                                                            <td><span class="badge text-bg-primary">A</span></td>
                                                            <td>80-89</td>
                                                            <td>10</td>
                                                        </tr>
                                                        <tr>
                                                            <td><span class="badge text-bg-secondary">B+</span></td>
                                                            <td>70-79</td>
                                                            <td>8</td>
                                                        </tr>
                                                        <tr>
                                                            <td><span class="badge text-bg-secondary">B</span></td>
                                                            <td>60-69</td>
                                                            <td>5</td>
                                                        </tr>
                                                        <tr>
                                                            <td><span class="badge text-bg-warning">C</span></td>
                                                            <td>50-59</td>
                                                            <td>3</td>
                                                        </tr>
                                                        <tr>
                                                            <td><span class="badge text-bg-danger">F</span></td>
                                                            <td>&lt; 50</td>
                                                            <td>3</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>

        <!-- SCHEDULE -->
        <div class="tab-pane fade" id="tabSchedule">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex flex-column flex-md-row gap-2 justify-content-between align-items-md-center">
                    <div class="fw-semibold">Exam Schedule</div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalScheduleExam">Add Schedule</button>
                        <button class="btn btn-outline-secondary btn-sm">Print</button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Exam</th>
                                    <th>Class</th>
                                    <th>Subject</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Room</th>
                                    <th>Invigilator</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-semibold">Mid Term</td>
                                    <td>8th</td>
                                    <td>Math</td>
                                    <td>10-Feb-2026</td>
                                    <td>09:00 - 12:00</td>
                                    <td>Hall A</td>
                                    <td>Sir Imran</td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-secondary">Edit</button>
                                            <button class="btn btn-outline-danger">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Mid Term</td>
                                    <td>8th</td>
                                    <td>English</td>
                                    <td>12-Feb-2026</td>
                                    <td>09:00 - 12:00</td>
                                    <td>Hall B</td>
                                    <td>Miss Sana</td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-secondary">Edit</button>
                                            <button class="btn btn-outline-danger">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white text-secondary small">
                    You can schedule by class or assign specific students if needed (special cases).
                </div>
            </div>
        </div>

        <!-- GRADING -->
        <div class="tab-pane fade" id="tabGrading">
            <div class="row g-3">
                <div class="col-12 col-lg-5">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <div class="fw-semibold">Grading Structure</div>
                            <button class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#modalGrading">Edit</button>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                Recommended to define grading per school policy. You can also set per exam type (Monthly/Term).
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Grade</th>
                                            <th>Min</th>
                                            <th>Max</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><span class="badge text-bg-success">A+</span></td>
                                            <td>90</td>
                                            <td>100</td>
                                            <td>Outstanding</td>
                                        </tr>
                                        <tr>
                                            <td><span class="badge text-bg-primary">A</span></td>
                                            <td>80</td>
                                            <td>89</td>
                                            <td>Excellent</td>
                                        </tr>
                                        <tr>
                                            <td><span class="badge text-bg-secondary">B+</span></td>
                                            <td>70</td>
                                            <td>79</td>
                                            <td>Very Good</td>
                                        </tr>
                                        <tr>
                                            <td><span class="badge text-bg-secondary">B</span></td>
                                            <td>60</td>
                                            <td>69</td>
                                            <td>Good</td>
                                        </tr>
                                        <tr>
                                            <td><span class="badge text-bg-warning">C</span></td>
                                            <td>50</td>
                                            <td>59</td>
                                            <td>Fair</td>
                                        </tr>
                                        <tr>
                                            <td><span class="badge text-bg-danger">F</span></td>
                                            <td>0</td>
                                            <td>49</td>
                                            <td>Fail</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-grid">
                                <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modalGrading">Update Grading</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-7">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white fw-semibold">Policies (Optional)</div>
                        <div class="card-body">
                            <div class="accordion" id="policyAcc">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#pl1">
                                            Pass/Fail Rules
                                        </button>
                                    </h2>
                                    <div id="pl1" class="accordion-collapse collapse show" data-bs-parent="#policyAcc">
                                        <div class="accordion-body">
                                            <div class="row g-2">
                                                <div class="col">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>