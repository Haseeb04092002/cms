<div class="p-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Fee Collection / Payment</h3>
    </div>

    <!-- Search Student Card -->
    <div class="card mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">Search Student</h5>
        </div>
        <div class="card-body">
            <form id="FindStudentForm">
                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">Education Type</label>
                        <select class="form-select" name="education_type" required data-parsley-required-message="Education Type is required">
                            <option value="">-- Select --</option>

                            <?php if (!empty($all_education_type)): ?>
                                <?php foreach ($all_education_type as $type): ?>
                                    <option value="<?= $type ?>"
                                        <?= (!empty($student->education_type) && $student->education_type == $type) ? 'selected' : '' ?>>
                                        <?= $type ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Student Name</label>
                        <input type="text" class="form-control" name="student_name">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Class</label>
                        <select class="form-select" name="class_section" required data-parsley-required-message="Class & Section is required">
                            <option value="">--Select--</option>
                            <?php if (!empty($all_classes)): ?>
                                <?php foreach ($all_classes as $type): ?>
                                    <option value="<?= $type->classId ?>"
                                        <?= (!empty($student->classId) && $student->classId == $type->classId) ? 'selected' : '' ?>>
                                        <?= $type->className ?> <?= $type->sectionName ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                </div>

                <button class="btn btn-primary mt-3" type="submit">Search</button>

            </form>
        </div>
    </div>


    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Student ID</th>
                            <th>Image</th>
                            <th>Admission No</th>
                            <th>Admission Date</th>
                            <th>Education Type</th>
                            <th>Name</th>
                            <th>Class</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // echo "<br>";
                        // echo "<pre>";
                        // print_r($all_students);
                        // die();
                        foreach ($all_students as $record) :
                        ?>
                            <tr>
                                <td><?= $record->studentId ?></td>
                                <td>
                                    <?php if (!empty($record->documentPath)): ?>
                                        <img src="<?= base_url($record->documentPath); ?>"
                                            alt="Profile Image"
                                            class="img-thumbnail rounded-circle"
                                            width="75">
                                    <?php else: ?>
                                        <img src="<?= base_url('assets/images/default-avatar.png'); ?>"
                                            class="img-thumbnail rounded-circle"
                                            width="75">
                                    <?php endif; ?>
                                </td>
                                <td><?= $record->admissionNo ?></td>
                                <td><?= date('d M Y g:i A', strtotime($record->addedOn)) ?></td>
                                <td><?= $record->student_education_type ?></td>
                                <td><?= $record->firstName ?> <?= $record->lastName ?></td>
                                <td><?= $record->className ?> <?= $record->sectionName ?></td>
                                <td><span class="badge bg-warning text-dark"><?= $record->status ?></span></td>

                                <td>
                                    <div class="d-flex gap-2">

                                        <!-- Controls Dropdown -->
                                        <div class="dropdown position-static">
                                            <button class="btn btn-sm btn-info dropdown-toggle"
                                                type="button" data-bs-toggle="modal" data-bs-target="#feeModal<?= $record->studentId ?>">
                                                Fee
                                            </button>
                                            <!-- <ul class="dropdown-menu">
                                                <li><a class="dropdown-item navigator" href="<?= site_url('Student/student_profile/') . $record->studentId . '/' . $record->admissionNo ?>">View</a></li>
                                                <li><a class="dropdown-item navigator" href="<?= site_url('Student/student_data/') . $record->studentId . '/' . $record->admissionNo ?>">Edit</a></li>
                                                <li><a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#feeModal<?= $record->studentId ?>">Fee</a></li>
                                                <li><a class="dropdown-item" href="#">Promote</a></li>
                                            </ul> -->
                                        </div>

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

                                                        <!-- ================= STUDENT INFO BAR ================= -->
                                                        <div class="alert alert-info d-flex justify-content-between align-items-center mb-3">
                                                            <div>
                                                                <strong><?= $record->firstName ?> <?= $record->lastName ?></strong><br>
                                                                Class: <?= $record->className ?> <?= $record->sectionName ?>
                                                            </div>
                                                            <div>
                                                                Adm #: <?= $record->admissionNo ?>
                                                            </div>
                                                        </div>

                                                        <!-- ================= FEE ACCORDION ================= -->
                                                        <div class="accordion" id="feeAccordion<?= $record->studentId ?>">

                                                            <?php
                                                            $feeTypes = ['admission', 'tuition', 'annual', 'security'];

                                                            foreach ($feeTypes as $index => $type):
                                                                $definedFeeStructure = false;
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
                                                                    ->where('classId', $record->classId)
                                                                    ->where('feeType', $type)
                                                                    ->get('tbl_fees')
                                                                    ->row();
                                                                // print_r($this->db->last_query());
                                                                // echo "<br>";
                                                                // echo "<pre>";
                                                                // print_r($fees);
                                                                if ($feeStructure) {
                                                                    $definedFeeStructure = true;
                                                                }
                                                                $totalFee = $feeStructure->amount ?? 0;
                                                                $paidFee  = $fees->paidAmount ?? 0;
                                                                $discountAmount  = $fees->discountAmount ?? 0;
                                                                $dueFee   = ($totalFee - $discountAmount) - $paidFee;
                                                                if ($dueFee < 0) $dueFee = 0;

                                                                if ($paidFee <= 0) {
                                                                    $status = 'Unpaid';
                                                                    $badge  = 'danger';
                                                                    $canOpen = true;
                                                                } elseif ($paidFee < ($totalFee - $discountAmount)) {
                                                                    $status = 'Partially Paid';
                                                                    $badge  = 'warning text-dark';
                                                                    $canOpen = true;
                                                                } else {
                                                                    $status = 'Paid';
                                                                    $badge  = 'success';
                                                                    $canOpen = true;
                                                                }
                                                            ?>


                                                                <!-- ================= ONE FEE ACCORDION ITEM ================= -->
                                                                <div class="accordion-item mb-2">
                                                                    <h2 class="accordion-header">
                                                                        <button class="accordion-button <?= !$canOpen ? 'collapsed bg-light' : 'collapsed' ?>"
                                                                            type="button"
                                                                            data-bs-toggle="collapse"
                                                                            data-bs-target="#fee<?= $type ?><?= $record->studentId ?>"
                                                                            <?= !$canOpen ? 'disabled' : '' ?>>

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

                                                                            <!-- ================= defined Fee Structure ================= -->
                                                                            <div class="<?= ($definedFeeStructure == false) ? 'd-block' : 'd-none' ?> alert alert-warning justify-content-center align-items-center mb-3">
                                                                                <div>
                                                                                    <strong>Fee Structure is not Defined</strong><br>
                                                                                    <!-- <a class="btn btn-sm btn-primary navigator" href="<?= site_url('Cms/fees_structure') ?>">Go to Fee Structure</a> -->
                                                                                </div>
                                                                            </div>

                                                                            <div class="<?= ($definedFeeStructure == false) ? 'd-none' : 'd-block' ?>">

                                                                                <!-- Fee Summary -->
                                                                                <div class="row mb-3">
                                                                                    <div class="col-md-3">
                                                                                        <label class="form-label fw-bold">Total Fee</label>
                                                                                        <input type="text"
                                                                                            class="form-control"
                                                                                            value="PKR <?= number_format($totalFee) ?>"
                                                                                            readonly>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <label class="form-label fw-bold">Discounted </label>
                                                                                        <input type="text"
                                                                                            class="form-control"
                                                                                            value="PKR <?= number_format($discountAmount) ?>"
                                                                                            readonly>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <label class="form-label fw-bold">Paid</label>
                                                                                        <input type="text"
                                                                                            class="form-control"
                                                                                            value="PKR <?= number_format($paidFee) ?>"
                                                                                            readonly>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <label class="form-label fw-bold">Remaining</label>
                                                                                        <input type="text"
                                                                                            class="form-control"
                                                                                            value="PKR <?= number_format($dueFee) ?>"
                                                                                            readonly>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="<?= ($status == 'Paid') ? 'd-none' : 'd-block' ?>">
                                                                                    <!-- Payment Form -->
                                                                                    <form class="FormCollectFee" data-parsley-validate>

                                                                                        <input type="hidden" name="studentId" value="<?= $record->studentId ?>">
                                                                                        <input type="hidden" name="feeId" value="<?= $record->feeId ?? '' ?>">
                                                                                        <input type="hidden" name="classId" value="<?= $record->classId ?>">
                                                                                        <input type="hidden" name="education_type" value="<?= $record->education_type ?>">
                                                                                        <input type="hidden" name="feeType" value="<?= $type ?>">

                                                                                        <div class="row g-3">

                                                                                            <!-- Discount Type -->
                                                                                            <div class="col-md-3">
                                                                                                <label class="form-label fw-bold">Discount Type</label>
                                                                                                <div class="btn-group w-100" role="group">
                                                                                                    <input type="radio" class="btn-check" name="discount_type"
                                                                                                        id="disc_amt_<?= $type ?><?= $record->studentId ?>"
                                                                                                        value="amount" checked>
                                                                                                    <label class="btn btn-outline-secondary"
                                                                                                        for="disc_amt_<?= $type ?><?= $record->studentId ?>">PKR</label>

                                                                                                    <input type="radio" class="btn-check" name="discount_type"
                                                                                                        id="disc_pct_<?= $type ?><?= $record->studentId ?>"
                                                                                                        value="percent">
                                                                                                    <label class="btn btn-outline-secondary"
                                                                                                        for="disc_pct_<?= $type ?><?= $record->studentId ?>">%</label>
                                                                                                </div>
                                                                                            </div>

                                                                                            <!-- Discount Value -->
                                                                                            <div class="col-md-3">
                                                                                                <label class="form-label fw-bold">Discount</label>
                                                                                                <input type="number"
                                                                                                    name="discount_value"
                                                                                                    class="form-control"
                                                                                                    placeholder="0">
                                                                                            </div>

                                                                                            <!-- Paying Amount -->
                                                                                            <div class="col-md-3">
                                                                                                <label class="form-label fw-bold">Paying Amount</label>
                                                                                                <input type="number"
                                                                                                    name="payAmount"
                                                                                                    class="form-control"
                                                                                                    required required data-parsley-required-message="Paying Amount is required">
                                                                                            </div>

                                                                                            <!-- Payment Mode -->
                                                                                            <div class="col-md-3">
                                                                                                <label class="form-label fw-bold">Payment Mode</label>
                                                                                                <select name="paymentMode" class="form-select" required required data-parsley-required-message="Payment Mode is required">
                                                                                                    <option value="cash">Cash</option>
                                                                                                    <option value="bank">Bank Transfer</option>
                                                                                                    <option value="online">Online</option>
                                                                                                    <option value="cheque">Cheque</option>
                                                                                                </select>
                                                                                            </div>

                                                                                        </div>

                                                                                        <!-- Submit -->
                                                                                        <div class="justify-content-start text-start mt-4">
                                                                                            <button class="btn btn-success w-25" type="submit">
                                                                                                Submit Payment
                                                                                            </button>
                                                                                        </div>

                                                                                    </form>
                                                                                </div>

                                                                            </div>

                                                                        </div>

                                                                    </div>
                                                                </div>

                                                            <?php endforeach; ?>

                                                        </div>
                                                        <!-- ================= END ACCORDION ================= -->

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>