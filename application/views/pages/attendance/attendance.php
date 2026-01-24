<div class="p-4">

    <!-- Header + Actions -->
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-2 mb-3">
        <div>
            <h4 class="mb-0 fw-bold">Student Attendance</h4>
            <div class="text-muted small">Mark daily attendance, manage reasons, and view summaries.</div>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#importModal">
                Import (CSV)
            </button>
            <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#historyModal">
                View History
            </button>
            <button class="btn btn-outline-secondary btn-sm" type="button">
                Export
            </button>
            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="window.print()">
                Print
            </button>
            <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#saveConfirmModal">
                Save Attendance
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <div class="row g-2 g-lg-3 align-items-end">

                <div class="col-12 col-md-6 col-lg-2">
                    <label class="form-label mb-1">Date</label>
                    <input type="date" class="form-control" value="">
                </div>

                <div class="col-12 col-md-6 col-lg-2">
                    <label class="form-label mb-1">Session</label>
                    <select class="form-select">
                        <option selected>2025-26</option>
                        <option>2024-25</option>
                    </select>
                </div>

                <div class="col-12 col-md-6 col-lg-2">
                    <label class="form-label mb-1">Class</label>
                    <select class="form-select">
                        <option selected>8th</option>
                        <option>9th</option>
                        <option>10th</option>
                    </select>
                </div>

                <div class="col-12 col-md-6 col-lg-2">
                    <label class="form-label mb-1">Section</label>
                    <select class="form-select">
                        <option selected>A</option>
                        <option>B</option>
                        <option>C</option>
                    </select>
                </div>

                <div class="col-12 col-md-6 col-lg-2">
                    <label class="form-label mb-1">Status Filter</label>
                    <select class="form-select">
                        <option selected>All</option>
                        <option>Present</option>
                        <option>Absent</option>
                        <option>Late</option>
                        <option>Leave</option>
                    </select>
                </div>

                <div class="col-12 col-md-6 col-lg-2">
                    <label class="form-label mb-1">Search</label>
                    <input type="text" class="form-control" placeholder="Adm#, Name, Mobile">
                </div>

                <div class="col-12 d-flex flex-wrap gap-2 mt-2">
                    <button class="btn btn-outline-primary btn-sm" type="button">Apply Filters</button>
                    <button class="btn btn-outline-secondary btn-sm" type="button">Reset</button>

                    <div class="vr d-none d-md-inline-block mx-2"></div>

                    <button class="btn btn-success btn-sm" type="button">Mark All Present</button>
                    <button class="btn btn-outline-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#bulkModal">
                        Bulk Set (Selected)
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Accordion: Daily Marking + Summary -->
    <div class="accordion" id="attendanceAccordion">

        <!-- Daily Attendance -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingDaily">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDaily" aria-expanded="true">
                    Daily Attendance Marking
                </button>
            </h2>
            <div id="collapseDaily" class="accordion-collapse collapse show" data-bs-parent="#attendanceAccordion">
                <div class="accordion-body">

                    <!-- Stats -->
                    <div class="row g-2 mb-3">
                        <div class="col-6 col-lg-3">
                            <div class="card border-0 bg-white shadow-sm">
                                <div class="card-body py-3">
                                    <div class="text-muted small">Total Students</div>
                                    <div class="fs-4 fw-bold">42</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="card border-0 bg-white shadow-sm">
                                <div class="card-body py-3">
                                    <div class="text-muted small">Present</div>
                                    <div class="fs-4 fw-bold text-success">0</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="card border-0 bg-white shadow-sm">
                                <div class="card-body py-3">
                                    <div class="text-muted small">Absent</div>
                                    <div class="fs-4 fw-bold text-danger">0</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="card border-0 bg-white shadow-sm">
                                <div class="card-body py-3">
                                    <div class="text-muted small">Late / Leave</div>
                                    <div class="fs-4 fw-bold text-warning">0</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Table -->
                    <div class="card shadow-sm">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="text-center" style="width: 48px;">
                                                <input class="form-check-input" type="checkbox" aria-label="Select all">
                                            </th>
                                            <th>Adm #</th>
                                            <th>Student</th>
                                            <th class="d-none d-md-table-cell">Father</th>
                                            <th class="d-none d-lg-table-cell">Mobile</th>
                                            <th style="min-width: 280px;">Attendance</th>
                                            <th class="d-none d-md-table-cell">Reason / Note</th>
                                            <th class="text-end" style="min-width: 160px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <!-- Row 1 -->
                                        <tr>
                                            <td class="text-center">
                                                <input class="form-check-input" type="checkbox" aria-label="Select row">
                                            </td>
                                            <td class="fw-semibold">1001</td>
                                            <td>
                                                <div class="fw-semibold">Ali Khan</div>
                                                <div class="text-muted small">Class 8th-A</div>
                                            </td>
                                            <td class="d-none d-md-table-cell">Imran Khan</td>
                                            <td class="d-none d-lg-table-cell">0300-1234567</td>
                                            <td>
                                                <div class="btn-group w-100" role="group" aria-label="Attendance options">
                                                    <input type="radio" class="btn-check" name="att_1001" id="p_1001" autocomplete="off">
                                                    <label class="btn btn-outline-success btn-sm" for="p_1001">Present</label>

                                                    <input type="radio" class="btn-check" name="att_1001" id="a_1001" autocomplete="off">
                                                    <label class="btn btn-outline-danger btn-sm" for="a_1001">Absent</label>

                                                    <input type="radio" class="btn-check" name="att_1001" id="l_1001" autocomplete="off">
                                                    <label class="btn btn-outline-warning btn-sm" for="l_1001">Late</label>

                                                    <input type="radio" class="btn-check" name="att_1001" id="lv_1001" autocomplete="off">
                                                    <label class="btn btn-outline-primary btn-sm" for="lv_1001">Leave</label>
                                                </div>
                                            </td>
                                            <td class="d-none d-md-table-cell">
                                                <span class="text-muted">—</span>
                                            </td>
                                            <td class="text-end">
                                                <div class="d-flex justify-content-end gap-2 flex-wrap">
                                                    <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#reasonModal">
                                                        Reason
                                                    </button>
                                                    <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#studentModal">
                                                        Profile
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Row 2 -->
                                        <tr>
                                            <td class="text-center">
                                                <input class="form-check-input" type="checkbox" aria-label="Select row">
                                            </td>
                                            <td class="fw-semibold">1002</td>
                                            <td>
                                                <div class="fw-semibold">Hira Malik</div>
                                                <div class="text-muted small">Class 8th-A</div>
                                            </td>
                                            <td class="d-none d-md-table-cell">Naveed Malik</td>
                                            <td class="d-none d-lg-table-cell">0333-9876543</td>
                                            <td>
                                                <div class="btn-group w-100" role="group" aria-label="Attendance options">
                                                    <input type="radio" class="btn-check" name="att_1002" id="p_1002" autocomplete="off">
                                                    <label class="btn btn-outline-success btn-sm" for="p_1002">Present</label>

                                                    <input type="radio" class="btn-check" name="att_1002" id="a_1002" autocomplete="off">
                                                    <label class="btn btn-outline-danger btn-sm" for="a_1002">Absent</label>

                                                    <input type="radio" class="btn-check" name="att_1002" id="l_1002" autocomplete="off">
                                                    <label class="btn btn-outline-warning btn-sm" for="l_1002">Late</label>

                                                    <input type="radio" class="btn-check" name="att_1002" id="lv_1002" autocomplete="off">
                                                    <label class="btn btn-outline-primary btn-sm" for="lv_1002">Leave</label>
                                                </div>
                                            </td>
                                            <td class="d-none d-md-table-cell">
                                                <span class="text-muted">—</span>
                                            </td>
                                            <td class="text-end">
                                                <div class="d-flex justify-content-end gap-2 flex-wrap">
                                                    <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#reasonModal">
                                                        Reason
                                                    </button>
                                                    <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#studentModal">
                                                        Profile
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Add more rows from DB -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer d-flex flex-column flex-md-row gap-2 justify-content-between align-items-md-center">
                            <div class="small text-muted">
                                Tip: Use <span class="fw-semibold">Bulk Set</span> for selected students to mark quickly.
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-secondary btn-sm" type="button">Prev</button>
                                <button class="btn btn-outline-secondary btn-sm" type="button">Next</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Monthly Summary -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingSummary">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSummary">
                    Monthly Summary & Reports
                </button>
            </h2>
            <div id="collapseSummary" class="accordion-collapse collapse" data-bs-parent="#attendanceAccordion">
                <div class="accordion-body">

                    <div class="row g-3">
                        <div class="col-12 col-lg-5">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-2">Summary Filters</h6>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <label class="form-label mb-1">Month</label>
                                            <select class="form-select">
                                                <option selected>January</option>
                                                <option>February</option>
                                                <option>March</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label mb-1">Year</label>
                                            <select class="form-select">
                                                <option selected>2026</option>
                                                <option>2025</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label mb-1">Student (optional)</label>
                                            <input type="text" class="form-control" placeholder="Adm#, Name">
                                        </div>
                                        <div class="col-12 d-flex gap-2">
                                            <button class="btn btn-primary btn-sm" type="button">Generate</button>
                                            <button class="btn btn-outline-secondary btn-sm" type="button">Export</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-7">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-2">Monthly Totals (Sample)</h6>

                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Adm#</th>
                                                    <th>Student</th>
                                                    <th class="text-center">P</th>
                                                    <th class="text-center">A</th>
                                                    <th class="text-center">Late</th>
                                                    <th class="text-center">Leave</th>
                                                    <th class="text-end">%</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="fw-semibold">1001</td>
                                                    <td>Ali Khan</td>
                                                    <td class="text-center">18</td>
                                                    <td class="text-center">2</td>
                                                    <td class="text-center">0</td>
                                                    <td class="text-center">1</td>
                                                    <td class="text-end fw-semibold">90.0%</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold">1002</td>
                                                    <td>Hira Malik</td>
                                                    <td class="text-center">20</td>
                                                    <td class="text-center">0</td>
                                                    <td class="text-center">1</td>
                                                    <td class="text-center">0</td>
                                                    <td class="text-end fw-semibold">95.0%</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="alert alert-info mb-0">
                                        You can add: <span class="fw-semibold">Defaulters list</span> (below 75%) and <span class="fw-semibold">SMS/WhatsApp notice</span> actions here.
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

<!-- ===================== MODALS ===================== -->

<!-- Reason Modal -->
<div class="modal fade" id="reasonModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Reason / Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <label class="form-label">Student</label>
                    <input class="form-control" value="(auto fill from row)" readonly>
                </div>
                <div class="mb-2">
                    <label class="form-label">Attendance Status</label>
                    <select class="form-select">
                        <option>Absent</option>
                        <option>Late</option>
                        <option>Leave</option>
                        <option>Present</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Reason / Note</label>
                    <textarea class="form-control" rows="4" placeholder="e.g., Fever, Family function, Late bus..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="button">Save Note</button>
            </div>
        </div>
    </div>
</div>

<!-- Student Profile Modal -->
<div class="modal fade" id="studentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Student Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="fw-bold">Ali Khan</div>
                                <div class="text-muted small">Adm#: 1001</div>
                                <hr>
                                <div class="small">
                                    <div><span class="fw-semibold">Class:</span> 8th-A</div>
                                    <div><span class="fw-semibold">Father:</span> Imran Khan</div>
                                    <div><span class="fw-semibold">Mobile:</span> 0300-1234567</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="fw-bold">Attendance Snapshot (Sample)</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Note</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>2026-01-22</td>
                                                <td><span class="badge text-bg-success">Present</span></td>
                                                <td>—</td>
                                            </tr>
                                            <tr>
                                                <td>2026-01-21</td>
                                                <td><span class="badge text-bg-danger">Absent</span></td>
                                                <td>Fever</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="button">Open Full Student File</button>
            </div>
        </div>
    </div>
</div>

<!-- History Modal -->
<div class="modal fade" id="historyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Attendance History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-2 mb-2">
                    <div class="col-12 col-md-3">
                        <input type="date" class="form-control">
                    </div>
                    <div class="col-12 col-md-3">
                        <input type="date" class="form-control">
                    </div>
                    <div class="col-12 col-md-4">
                        <input type="text" class="form-control" placeholder="Search Adm#, Name">
                    </div>
                    <div class="col-12 col-md-2 d-grid">
                        <button class="btn btn-primary">Load</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Date</th>
                                <th>Class</th>
                                <th>Adm#</th>
                                <th>Student</th>
                                <th>Status</th>
                                <th>Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2026-01-21</td>
                                <td>8th-A</td>
                                <td>1001</td>
                                <td>Ali Khan</td>
                                <td><span class="badge text-bg-danger">Absent</span></td>
                                <td>Fever</td>
                            </tr>
                            <tr>
                                <td>2026-01-22</td>
                                <td>8th-A</td>
                                <td>1002</td>
                                <td>Hira Malik</td>
                                <td><span class="badge text-bg-success">Present</span></td>
                                <td>—</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-outline-secondary" type="button">Export</button>
                <button class="btn btn-primary" type="button">Print</button>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Modal -->
<div class="modal fade" id="bulkModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bulk Set Attendance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    This will apply to <span class="fw-semibold">selected students</span> only.
                </div>
                <label class="form-label">Set status</label>
                <select class="form-select">
                    <option>Present</option>
                    <option>Absent</option>
                    <option>Late</option>
                    <option>Leave</option>
                </select>
                <div class="mt-2">
                    <label class="form-label">Optional note</label>
                    <input class="form-control" placeholder="e.g., Sports event">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-danger" type="button">Apply</button>
            </div>
        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Attendance (CSV)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    CSV columns example: <span class="fw-semibold">date, adm_no, status, note</span>
                </div>
                <input type="file" class="form-control">
                <div class="form-text">Upload CSV file and map fields in backend later.</div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="button">Upload</button>
            </div>
        </div>
    </div>
</div>

<!-- Save Confirm Modal -->
<div class="modal fade" id="saveConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Save</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-secondary mb-0">
                    Save attendance for selected <span class="fw-semibold">date/class/section</span>?
                    This will update existing entries for the same date.
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" type="button">Yes, Save</button>
            </div>
        </div>
    </div>
</div>