<?php
$UserId = '';
$UserName = '';
$UserEmail = '';
$UserRole = '';
$StationId = '';
$UserId = $this->session->userdata('user_id') ?? '';
$UserName = $this->session->userdata('user_name') ?? '';
$UserEmail = $this->session->userdata('user_email') ?? '';
$UserRole = $this->session->userdata('user_role') ?? '';
$StationId = $this->session->userdata('station_id') ?? '';
?>

<div class="p-4">

    <div class="card mb-3 border-dark">
        <form id="studentSearchForm">
            <div class="card-header p-1 ps-2">
                <h6 class="mb-0">Search Students</h6>
            </div>
            <div class="card-body p-3">
                <div class="row g-2 align-items-end">

                    <!-- Education Type -->
                    <div class="col-md-2">
                        <label class="form-label mb-1">Education Type</label>
                        <select class="form-select form-select-sm" name="education_type">
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

                    <!-- Class -->
                    <div class="col-md-2">
                        <label class="form-label mb-1">Class</label>
                        <select class="form-select form-select-sm" name="class_id">
                            <option value="">--Select--</option>
                            <?php if (!empty($all_classes)): ?>
                                <?php foreach ($all_classes as $type): ?>
                                    <option value="<?= $type->classId ?>"
                                        <?= (!empty($student->classId) && $student->classId == $type->classId) ? 'selected' : '' ?>>
                                        <?= $type->className ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Section -->
                    <div class="col-md-2">
                        <label class="form-label mb-1">Section</label>
                        <select class="form-select form-select-sm" name="section_id">
                            <option value="">--Select--</option>
                            <?php if (!empty($all_classes)): ?>
                                <?php foreach ($all_classes as $type): ?>
                                    <option value="<?= $type->classId ?>"
                                        <?= (!empty($student->classId) && $student->classId == $type->classId) ? 'selected' : '' ?>>
                                        <?= $type->sectionName ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Student Name -->
                    <div class="col-md-3">
                        <label class="form-label mb-1">Student Name</label>
                        <input type="text"
                            name="student_name"
                            class="form-control form-control-sm"
                            placeholder="Type student name">
                    </div>

                    <!-- Batch Year -->
                    <div class="col-md-2">
                        <label class="form-label mb-1">Batch Year</label>
                        <select class="form-select form-select-sm" name="batchYear">
                            <option value="">--Select--</option>
                            <?php
                            if (!empty($all_batch_year)): ?>
                                <?php foreach ($all_batch_year as $type): ?>
                                    <?php
                                    $selected =
                                        (!empty($student->batchYear) && $student->batchYear == $type)
                                        ? 'selected'
                                        : '';
                                    ?>
                                    <option value="<?= $type ?>" <?= $selected ?>>
                                        <?= $type ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Search Button -->
                    <div class="col-md-1 text-end">
                        <button type="submit" class="btn btn-dark btn-sm w-100">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>

                </div>
            </div>
        </form>
    </div>


    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Student ID</th>
                            <th>Admission No</th>
                            <th>Education Type</th>
                            <th>Name</th>
                            <th>Class</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="studentsTableBody">
                        <?php foreach ($grouped as $sid => $data):
                            $student = $data['student'];
                            $fee_structure = $data['fee_structure']; // This contains heads, amounts, and discounts
                        ?>
                            <tr>
                                <td><?= $student->studentId ?></td>
                                <td><?= $student->admissionNo ?></td>
                                <td><?= $student->student_education_type ?></td>
                                <td><?= $student->firstName . ' ' . $student->lastName ?></td>
                                <td><?= $student->className . ' ' . $student->sectionName ?></td>

                                <td>
                                    <?php
                                    $hasAnyDiscount = false;
                                    foreach ($fee_structure as $head):
                                        if ($head['discountAmount'] > 0): $hasAnyDiscount = true; ?>
                                            <span class="badge bg-success me-1 mb-1">
                                                <?= $head['headName'] ?>: -<?= $head['discountAmount'] ?>
                                            </span>
                                        <?php endif;
                                    endforeach;

                                    if (!$hasAnyDiscount): ?>
                                        <span class="badge bg-secondary">No Discounts</span>
                                    <?php endif; ?>

                                    <br>
                                    <button class="btn btn-sm btn-primary mt-2"
                                        data-bs-toggle="modal"
                                        data-bs-target="#discountModal<?= $student->studentId ?>">
                                        Manage
                                    </button>

                                    <div class="modal fade" id="discountModal<?= $student->studentId ?>">
                                        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title">Manage Fees: <?= $student->firstName ?></h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body text-start">
                                                    <h5 class="mb-3">Fee Structure & Discounts</h5>
                                                    <table class="table table-bordered table-sm align-middle">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Fee Head</th>
                                                                <th>Original Amount</th>
                                                                <th>Discount Applied</th>
                                                                <th>Final Amount</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($all_fee_heads as $fh):
                                                                // Link the master fee head to this student's specific structure
                                                                $info = $fee_structure[$fh->feeHeadId] ?? null;
                                                            ?>
                                                                <tr>
                                                                    <td>
                                                                        <strong><?= $fh->headName ?></strong>
                                                                        <small class="text-muted">(<?= $fh->headType ?>)</small>
                                                                    </td>

                                                                    <td>
                                                                        <?= $info ? number_format($info['originalAmount'], 2) : '<span class="text-danger">Not Set</span>' ?>
                                                                    </td>

                                                                    <td>
                                                                        <?php if ($info && $info['discountAmount'] > 0): ?>
                                                                            <!-- <span class="badge bg-success"> -->
                                                                            <?= number_format($info['discountAmount'], 2) ?>
                                                                            <!-- </span> -->
                                                                        <?php else: ?>
                                                                            <span class="text-muted">No Discount</span>
                                                                        <?php endif; ?>
                                                                    </td>

                                                                    <td>
                                                                        <strong><?= $info ? number_format($info['finalAmount'], 2) : '-' ?></strong>
                                                                    </td>

                                                                    <td>
                                                                        <?php if ($info && $info['discountAmount'] > 0): ?>
                                                                            <button type="button"
                                                                                class="btn btn-sm btn-danger removeDiscountBtn"
                                                                                data-student="<?= $student->studentId ?>"
                                                                                data-head="<?= $fh->feeHeadId ?>">
                                                                                Remove
                                                                            </button>
                                                                        <?php elseif ($info): ?>
                                                                            <form class="assignDiscountForm d-flex gap-2">
                                                                                <input type="hidden" name="studentId" value="<?= $student->studentId ?>">
                                                                                <input type="hidden" name="feeHeadId" value="<?= $fh->feeHeadId ?>">
                                                                                <select name="discountId" class="form-select form-select-sm" required>
                                                                                    <option value="">Apply Discount...</option>
                                                                                    <?php foreach ($all_discounts as $disc): ?>
                                                                                        <option value="<?= $disc->discountId ?>">
                                                                                            <?= $disc->discountName ?> (<?= $disc->discountValue ?><?= $disc->discountType == 'Percentage' ? '%' : '' ?>)
                                                                                        </option>
                                                                                    <?php endforeach; ?>
                                                                                </select>
                                                                                <button type="submit" class="btn btn-sm btn-success">Apply</button>
                                                                            </form>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
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

<script>
    $(document).ready(function() {


        $('#studentSearchForm').off('submit').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            Swal.fire({
                title: 'Searching...',
                text: 'Please wait',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            console.log("form data = ", formData);

            $.ajax({
                url: "<?= site_url('Student/find_student') ?>",
                type: "POST",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,

                success: function(res) {

                    Swal.close();

                    if (res.status === true) {

                        $('#studentsTableBody').html(res.html);

                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'No Data',
                            text: 'No students found'
                        });
                    }
                }
            });
        });


        $(document).off('submit', '.assignDiscountForm').on('submit', '.assignDiscountForm', function(e) {

            console.log('here');


            e.preventDefault();

            let formData = new FormData(this);

            Swal.fire({
                title: 'Saving...',
                text: 'Please wait',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });


            $.ajax({
                url: "<?= site_url('Fee/save_student_discount') ?>",
                type: "POST",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,

                success: function(res) {

                    Swal.close();

                    if (res.status === true) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: res.message,
                            timer: 1200,
                            showConfirmButton: false
                        });

                        // setTimeout(function() {
                        //     location.reload();
                        // }, 1200);
                        closeAllModals();

                        $("#pageContent").load("<?= base_url('Fee/all_students') ?>");

                    } else {

                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning',
                            text: res.message
                        });
                        closeAllModals();
                        $("#pageContent").load("<?= base_url('Fee/all_students') ?>");
                    }
                },

                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Something went wrong.'
                    });
                }
            });
        });


        $(document).on('click', '.removeDiscountBtn', function() {
            let studentId = $(this).data('student');
            let feeHeadId = $(this).data('head');

            Swal.fire({
                title: 'Remove Discount?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Remove'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= site_url('Fee/delete_student_discount') ?>",
                        type: "POST",
                        data: {
                            studentId: studentId,
                            feeHeadId: feeHeadId
                        },
                        dataType: "json",
                        success: function(res) {
                            // Close everything BEFORE reloading content
                            closeAllModals();

                            if (res.status === true) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Removed',
                                    text: res.message,
                                    timer: 1200,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: res.message
                                });
                            }

                            // Reload the table/page content here
                            $("#pageContent").load("<?= base_url('Fee/all_students') ?>");
                        }
                    });
                }
            });
            // REMOVE the .load() from here! It must stay inside success.
        });


        function closeAllModals() {
            // 1. Hide the Bootstrap Modal instances
            document.querySelectorAll('.modal.show').forEach(function(modalEl) {
                let modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) {
                    modal.hide();
                }
            });

            // 2. Remove the stuck dark overlay (backdrop)
            $('.modal-backdrop').remove();

            // 3. Restore scrolling to the body
            $('body').removeClass('modal-open').css({
                'overflow': '',
                'padding-right': ''
            });
        }

    });
</script>