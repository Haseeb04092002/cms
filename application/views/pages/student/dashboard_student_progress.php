<style>
    /* ===== UNIFIED MODULE BUTTON STYLE ===== */

    .module-card {
        border: 1px solid transparent;
        border-radius: 12px;
        /* background: linear-gradient(135deg, #f4f7fb, #ffffff); */
        background: linear-gradient(135deg, #ddecff, #fff);
        transition: all 0.25s ease;
        cursor: pointer;
    }

    .module-card:hover {
        transform: translateY(-4px);
        border: 1px solid #0d6efd;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }
</style>


<div class="p-4">

    <!-- ================= STUDENT ================= -->
    <div class="card mb-4 border-0 shadow-lg">
        <div class="card-body">

            <div class="d-flex align-items-center mb-4">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                    style="width:50px;height:50px;">
                    <i class="bi bi-mortarboard-fill fs-4"></i>
                </div>
                <h4 class="fw-bold mb-0">Student Reports</h4>
            </div>

            <div class="row g-3">

                <div class="col-md-4">
                    <a href="<?= site_url('Reports/student_reports/attendance') ?>" class="navigator text-decoration-none">
                        <div class="card border-primary shadow-sm h-100 text-center module-card">
                            <div class="card-body">
                                <i class="bi bi-clipboard-data fs-2 text-primary mb-3"></i>
                                <h6 class="fw-semibold">Attendance Report</h6>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="<?= site_url('Reports/student_reports/academic') ?>" class="navigator text-decoration-none">
                        <div class="card border-primary shadow-sm h-100 text-center module-card">
                            <div class="card-body">
                                <i class="bi bi-bar-chart-line fs-2 text-primary mb-3"></i>
                                <h6 class="fw-semibold">Academic Report</h6>
                            </div>
                        </div>
                    </a>
                </div>

            </div>

        </div>
    </div>

</div>