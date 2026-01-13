<div class="p-4">
    <h3 class="fw-bold mb-4 text-start">Fees Management Modules</h3>

    <div class="row g-4">

        <!-- Fee Structure -->
        <div class="col-md-6">
            <a href="<?= site_url('Fee/fees_structure') ?>" class="navigator text-decoration-none">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">
                            <i class="bi bi-table me-2 text-primary"></i>Fee Structure
                        </h5>
                        <p class="small text-muted">
                            Create and manage fee categories, class-wise fee structures, and installment plans.
                        </p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Fee Collection -->
        <div class="col-md-6">
            <a href="<?= site_url('Fee/fees_collection') ?>" class="navigator text-decoration-none">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">
                            <i class="bi bi-cash-stack me-2 text-success"></i>Fee Collection / Payment
                        </h5>
                        <p class="small text-muted">
                            Collect fees online or at counter, manage transactions, and generate payment confirmations.
                        </p>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>