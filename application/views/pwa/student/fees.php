<!-- ===============================
     FEES VIEW
     =============================== -->

<!-- SEARCH / FILTER (OPTIONAL) -->
<div class="mb-3">
    <input type="text"
        class="form-control pwa-fee-search"
        placeholder="Search by month, voucher or amount">
</div>

<!-- FEE TABS -->
<ul class="nav nav-pills nav-fill mb-3 small pwa-fee-tabs">
    <li class="nav-item">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#paidTab">
            Paid
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#unpaidTab">
            Unpaid
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#historyTab">
            History
        </button>
    </li>
</ul>

<!-- TAB CONTENT -->
<div class="tab-content">

    <!-- ================= PAID ================= -->
    <div class="tab-pane fade show active" id="paidTab">

        <div class="card mb-3 pwa-fee-card">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-start mb-1">
                    <div>
                        <h6 class="pwa-fee-title mb-0">January 2026</h6>
                        <small class="pwa-muted">Voucher #FEE-1021</small>
                    </div>
                    <span class="badge pwa-fee-badge-paid">Paid</span>
                </div>

                <div class="pwa-fee-meta mb-2">
                    <div><strong>Amount:</strong> Rs. 4,500</div>
                    <div><strong>Paid On:</strong> 10 Jan 2026</div>
                    <div><strong>Mode:</strong> Cash</div>
                </div>

                <button class="btn btn-outline-secondary btn-sm w-100"
                    data-bs-toggle="modal"
                    data-bs-target="#voucherModal">
                    View Fee Voucher
                </button>

            </div>
        </div>

    </div>

    <!-- ================= UNPAID ================= -->
    <div class="tab-pane fade" id="unpaidTab">

        <div class="card mb-3 pwa-fee-card">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-start mb-1">
                    <div>
                        <h6 class="pwa-fee-title mb-0">February 2026</h6>
                        <small class="pwa-muted">Due Date: 15 Feb 2026</small>
                    </div>
                    <span class="badge pwa-fee-badge-unpaid">Unpaid</span>
                </div>

                <div class="pwa-fee-meta mb-2">
                    <div><strong>Amount:</strong> Rs. 4,500</div>
                    <div><strong>Fine:</strong> Rs. 200</div>
                </div>

                <button class="btn btn-outline-primary btn-sm w-100">
                    Pay Now
                </button>

            </div>
        </div>

    </div>

    <!-- ================= HISTORY ================= -->
    <div class="tab-pane fade" id="historyTab">

        <div class="card mb-3 pwa-fee-card">
            <div class="card-body">

                <div class="d-flex justify-content-between mb-1">
                    <div>
                        <h6 class="pwa-fee-title mb-0">December 2025</h6>
                        <small class="pwa-muted">Voucher #FEE-0987</small>
                    </div>
                    <span class="badge pwa-fee-badge-history">Archived</span>
                </div>

                <div class="pwa-fee-meta">
                    <div><strong>Amount:</strong> Rs. 4,300</div>
                    <div><strong>Status:</strong> Paid</div>
                </div>

            </div>
        </div>

    </div>

</div>

<!-- ================= FEE VOUCHER MODAL ================= -->
<div class="modal fade pwa-modal" id="voucherModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down">
        <div class="modal-content">

            <div class="modal-header">
                <h6 class="modal-title">
                    <i class="bi bi-receipt me-1"></i>
                    Fee Voucher
                </h6>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="text-center mb-3">
                    <strong>School Name</strong><br>
                    <small class="pwa-muted">Fee Voucher</small>
                </div>

                <div class="pwa-fee-voucher-row">
                    <span>Student Name</span>
                    <strong>Zia Ali</strong>
                </div>

                <div class="pwa-fee-voucher-row">
                    <span>Class</span>
                    <strong>Grade 5</strong>
                </div>

                <div class="pwa-fee-voucher-row">
                    <span>Month</span>
                    <strong>January 2026</strong>
                </div>

                <div class="pwa-fee-voucher-row">
                    <span>Total Amount</span>
                    <strong>Rs. 4,500</strong>
                </div>

                <div class="pwa-fee-voucher-row">
                    <span>Status</span>
                    <strong>Paid</strong>
                </div>

            </div>

        </div>
    </div>
</div>