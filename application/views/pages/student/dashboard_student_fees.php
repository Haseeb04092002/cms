<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="p-4">

  <div class="row g-4">

    <?php if (!empty($fee_types)): ?>
      <?php foreach ($fee_types as $f): ?>

        <div class="col-xl-3 col-lg-4 col-md-6">
          <div class="card h-100 border-dark shadow-sm">

            <!-- HEADER -->
            <div class="card-header bg-light text-center fw-semibold">
              <?= htmlspecialchars($f['feeType']) ?>
            </div>

            <!-- BODY -->
            <div class="card-body px-3">

              <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Total Fee</span>
                <span class="fw-semibold">
                  Rs <?= number_format($f['total_fee'], 2) ?>
                </span>
              </div>

              <div class="d-flex justify-content-between mb-2">
                <span class="text-success">Paid</span>
                <span class="fw-semibold text-success">
                  Rs <?= number_format($f['paid'], 2) ?>
                </span>
              </div>

              <div class="d-flex justify-content-between mb-2">
                <span class="text-primary">Discount</span>
                <span class="fw-semibold text-primary">
                  Rs <?= number_format($f['discount'], 2) ?>
                </span>
              </div>

            </div>

            <!-- FOOTER -->
            <div class="card-footer bg-white border-top text-center">
              <div class="small text-muted">Remaining</div>
              <div class="fs-6 fw-bold text-danger">
                Rs <?= number_format($f['remaining'], 2) ?>
              </div>
            </div>

          </div>
        </div>

      <?php endforeach; ?>
    <?php else: ?>

      <div class="col-12">
        <div class="alert alert-secondary text-center">
          No fee data found
        </div>
      </div>

    <?php endif; ?>

  </div>

</div>
