<style>
    .menu-card {
        transition: 0.3s ease;
        cursor: pointer;
    }

    .menu-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        background: #f8f9ff;
    }
</style>

<div class="p-4">

    <div class="row g-4">

        <!-- Heads -->
        <div class="col-md-4 col-lg-3">
            <a href="<?= site_url('fee/heads') ?>" class="text-decoration-none navigator">
                <div class="card shadow-sm border-primary h-100 text-center menu-card">
                    <div class="card-body">
                        <i class="bi bi-list-ul fs-1 text-primary"></i>
                        <h6 class="mt-3 fw-semibold">Heads</h6>
                        <small class="text-muted d-block">Manage all fee head categories</small>
                    </div>
                </div>
            </a>
        </div>

        <!-- Structure -->
        <div class="col-md-4 col-lg-3">
            <a href="<?= site_url('fee/structure') ?>" class="text-decoration-none navigator">
                <div class="card shadow-sm border-primary h-100 text-center menu-card">
                    <div class="card-body">
                        <i class="bi bi-diagram-3 fs-1 text-primary"></i>
                        <h6 class="mt-3 fw-semibold">Structure</h6>
                        <small class="text-muted d-block">Define class-wise fee structure</small>
                    </div>
                </div>
            </a>
        </div>

        <!-- Services -->
        <div class="col-md-4 col-lg-3">
            <a href="<?= site_url('fee/services') ?>" class="text-decoration-none navigator">
                <div class="card shadow-sm border-primary h-100 text-center menu-card">
                    <div class="card-body">
                        <i class="bi bi-gear fs-1 text-primary"></i>
                        <h6 class="mt-3 fw-semibold">Services</h6>
                        <small class="text-muted d-block">Create additional fee services</small>
                    </div>
                </div>
            </a>
        </div>

        <!-- Student Services -->
        <div class="col-md-4 col-lg-3">
            <a href="<?= site_url('fee/student_services_dashboard') ?>" class="text-decoration-none navigator">
                <div class="card shadow-sm border-primary h-100 text-center menu-card">
                    <div class="card-body">
                        <i class="bi bi-person-gear fs-1 text-primary"></i>
                        <h6 class="mt-3 fw-semibold">Student Services</h6>
                        <small class="text-muted d-block">Assign services to students</small>
                    </div>
                </div>
            </a>
        </div>

        <!-- Discounts -->
        <div class="col-md-4 col-lg-3">
            <a href="<?= site_url('fee/discounts') ?>" class="text-decoration-none navigator">
                <div class="card shadow-sm border-primary h-100 text-center menu-card">
                    <div class="card-body">
                        <i class="bi bi-percent fs-1 text-primary"></i>
                        <h6 class="mt-3 fw-semibold">Discounts</h6>
                        <small class="text-muted d-block">Configure discount policies</small>
                    </div>
                </div>
            </a>
        </div>

        <!-- Student Discounts -->
        <div class="col-md-4 col-lg-3">
            <a href="<?= site_url('fee/all_students') ?>" class="text-decoration-none navigator">
                <div class="card shadow-sm border-primary h-100 text-center menu-card">
                    <div class="card-body">
                        <i class="bi bi-person-lines-fill fs-1 text-primary"></i>
                        <h6 class="mt-3 fw-semibold">Student Discounts</h6>
                        <small class="text-muted d-block">Apply discounts to students</small>
                    </div>
                </div>
            </a>
        </div>

        <!-- Generate -->
        <!-- <div class="col-md-4 col-lg-3">
            <a href="<?= site_url('fee/vouchers') ?>" class="text-decoration-none navigator">
                <div class="card shadow-sm border-primary h-100 text-center menu-card">
                    <div class="card-body">
                        <i class="bi bi-receipt fs-1 text-primary"></i>
                        <h6 class="mt-3 fw-semibold">Vouchers</h6>
                        <small class="text-muted d-block">Generate student fee vouchers</small>
                    </div>
                </div>
            </a>
        </div> -->

        <!-- Challans -->
        <div class="col-md-4 col-lg-3">
            <a href="<?= site_url('fee/challans') ?>" class="text-decoration-none navigator">
                <div class="card shadow-sm border-primary h-100 text-center menu-card">
                    <div class="card-body">
                        <i class="bi bi-file-earmark-text fs-1 text-primary"></i>
                        <h6 class="mt-3 fw-semibold">Challans</h6>
                        <small class="text-muted d-block">View and print fee challans</small>
                    </div>
                </div>
            </a>
        </div>

        <!-- Cash Counter -->
        <div class="col-md-4 col-lg-3">
            <a href="<?= site_url('fee/cash_counter') ?>" class="text-decoration-none navigator">
                <div class="card shadow-sm border-primary h-100 text-center menu-card">
                    <div class="card-body">
                        <i class="bi bi-cash-stack fs-1 text-primary"></i>
                        <h6 class="mt-3 fw-semibold">Cash Counter</h6>
                        <small class="text-muted d-block">Receive and record payments</small>
                    </div>
                </div>
            </a>
        </div>

        <!-- Bank Pending -->
        <div class="col-md-4 col-lg-3">
            <a href="<?= site_url('fee/bank_pending') ?>" class="text-decoration-none navigator">
                <div class="card shadow-sm border-primary h-100 text-center menu-card">
                    <div class="card-body">
                        <i class="bi bi-bank fs-1 text-primary"></i>
                        <h6 class="mt-3 fw-semibold">Bank Pending</h6>
                        <small class="text-muted d-block">Track pending bank deposits</small>
                    </div>
                </div>
            </a>
        </div>

        <!-- Ledger -->
        <div class="col-md-4 col-lg-3">
            <a href="<?= site_url('fee/ledger') ?>" class="text-decoration-none navigator">
                <div class="card shadow-sm border-primary h-100 text-center menu-card">
                    <div class="card-body">
                        <i class="bi bi-journal-text fs-1 text-primary"></i>
                        <h6 class="mt-3 fw-semibold">Ledger</h6>
                        <small class="text-muted d-block">View detailed student ledger</small>
                    </div>
                </div>
            </a>
        </div>

    </div>
    
</div>