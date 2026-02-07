<?php if (!empty($records)): ?>
    <?php
    // echo "<br>";
    // echo "<pre>";
    // print_r($all_students);
    // die();
    foreach ($records as $record) :
    ?>
        <tr>
            <td><?= $record->studentId ?></td>
            <td><?= $record->admissionNo ?></td>
            <td><?= date('d M Y', strtotime($record->addedOn)) ?></td>
            <td><?= $record->student_education_type ?></td>
            <td><?= $record->firstName ?> <?= $record->lastName ?></td>
            <td><?= $record->className ?> <?= $record->sectionName ?></td>
            <!-- <td><span class="badge bg-warning text-dark"><?= $record->status ?></span></td> -->

            <td>
                <div class="d-flex gap-2">

                    <a class="btn btn-info" type="button" data-bs-toggle="modal" data-bs-target="#feeModal<?= $record->studentId ?>">Fee</a>

                    <!-- Fee Modal -->
                    <div class="modal fade" id="feeModal<?= $record->studentId ?>" tabindex="-1">
                        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">

                                <!-- Header -->
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title">
                                        <i class="bi bi-cash-stack me-1"></i> Student Fee Management
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">

                                    <!-- STUDENT INFO -->
                                    <div class="alert alert-info d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <strong><?= $record->firstName ?> <?= $record->lastName ?></strong><br>
                                            Class: <?= $record->className ?> <?= $record->sectionName ?>
                                        </div>
                                        <div>
                                            Adm #: <?= $record->admissionNo ?>
                                        </div>
                                    </div>

                                    <!-- ACCORDION -->
                                    <div class="accordion" id="feeAccordion<?= $record->studentId ?>">

                                        <?php
                                        $feeTypes = ['admission', 'tuition', 'annual', 'security'];

                                        foreach ($feeTypes as $type):

                                            $feeStructure = $this->db
                                                ->where('education_type', $record->student_education_type)
                                                ->where('stationId', $record->stationId)
                                                ->where('classId', $record->classId)
                                                ->where('feeType', $type)
                                                ->get('tbl_fee_structure')
                                                ->row();

                                            $fees = $this->db
                                                ->where('education_type', $record->student_education_type)
                                                ->where('stationId', $record->stationId)
                                                ->where('studentId', $record->studentId)
                                                ->where('classId', $record->classId)
                                                ->where('feeType', $type)
                                                ->get('tbl_fees')
                                                ->row();

                                            $totalFee = $feeStructure->amount ?? 0;
                                            $paidFee  = $fees->paidAmount ?? 0;
                                            $discount = $fees->discountAmount ?? 0;

                                            $dueFee = max(0, ($totalFee - $discount) - $paidFee);

                                            if ($paidFee <= 0) {
                                                $status = 'Unpaid';
                                                $badge  = 'danger';
                                            } elseif ($paidFee < ($totalFee - $discount)) {
                                                $status = 'Partially Paid';
                                                $badge  = 'warning text-dark';
                                            } else {
                                                $status = 'Paid';
                                                $badge  = 'success';
                                            }

                                            $defined = !empty($feeStructure);
                                        ?>

                                            <!-- ACCORDION ITEM -->
                                            <div class="accordion-item mb-2">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed"
                                                        type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#fee<?= $type ?><?= $record->studentId ?>">

                                                        <div class="w-100 d-flex justify-content-between align-items-center">
                                                            <span class="fw-bold text-capitalize">
                                                                <?= $type ?> Fee
                                                            </span>
                                                            <span class="badge bg-<?= $badge ?>">
                                                                <?= $status ?>
                                                            </span>
                                                        </div>

                                                    </button>
                                                </h2>

                                                <div id="fee<?= $type ?><?= $record->studentId ?>"
                                                    class="accordion-collapse collapse"
                                                    data-bs-parent="#feeAccordion<?= $record->studentId ?>">

                                                    <div class="accordion-body">

                                                        <?php if (!$defined): ?>

                                                            <div class="alert alert-warning">
                                                                <strong>Fee Structure is not Defined</strong>
                                                            </div>

                                                        <?php else: ?>

                                                            <!-- SUMMARY -->
                                                            <div class="row mb-3">
                                                                <div class="col-md-3">
                                                                    <label class="form-label fw-bold">Total Fee</label>
                                                                    <input class="form-control" readonly
                                                                        value="PKR <?= number_format($totalFee) ?>">
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label class="form-label fw-bold">Discount</label>
                                                                    <input class="form-control" readonly
                                                                        value="PKR <?= number_format($discount) ?>">
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label class="form-label fw-bold">Paid</label>
                                                                    <input class="form-control" readonly
                                                                        value="PKR <?= number_format($paidFee) ?>">
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label class="form-label fw-bold">Remaining</label>
                                                                    <input class="form-control" readonly
                                                                        value="PKR <?= number_format($dueFee) ?>">
                                                                </div>
                                                            </div>

                                                            <?php if ($status !== 'Paid'): ?>
                                                                <!-- PAYMENT FORM -->
                                                                <form class="FormCollectFee" data-parsley-validate>

                                                                    <input type="hidden" name="studentId" value="<?= $record->studentId ?>">
                                                                    <input type="hidden" name="classId" value="<?= $record->classId ?>">
                                                                    <input type="hidden" name="education_type" value="<?= $record->student_education_type ?>">
                                                                    <input type="hidden" name="feeType" value="<?= $type ?>">

                                                                    <div class="row g-3">

                                                                        <div class="col-md-3">
                                                                            <label class="form-label fw-bold">Discount</label>
                                                                            <input type="number"
                                                                                name="discount_value"
                                                                                class="form-control"
                                                                                placeholder="0">
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <label class="form-label fw-bold">Paying Amount</label>
                                                                            <input type="number"
                                                                                name="payAmount"
                                                                                class="form-control"
                                                                                required>
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <label class="form-label fw-bold">Payment Mode</label>
                                                                            <select name="paymentMode"
                                                                                class="form-select"
                                                                                required>
                                                                                <option value="cash">Cash</option>
                                                                                <option value="bank">Bank Transfer</option>
                                                                                <option value="online">Online</option>
                                                                                <option value="cheque">Cheque</option>
                                                                            </select>
                                                                        </div>

                                                                    </div>

                                                                    <div class="mt-3">
                                                                        <button class="btn btn-success">
                                                                            Submit Payment
                                                                        </button>
                                                                    </div>

                                                                </form>
                                                            <?php endif; ?>

                                                        <?php endif; ?>

                                                    </div>
                                                </div>
                                            </div>

                                        <?php endforeach; ?>

                                    </div>
                                    <!-- END ACCORDION -->

                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </td>

        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="9" class="text-center text-muted">
            No data found
        </td>
    </tr>
<?php endif; ?>