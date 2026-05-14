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


<style>
    @media (max-width:768px) {

        #studentSearchForm .card-body {
            display: none;
        }

        #studentSearchForm .card-header {
            cursor: pointer;
        }

        #studentSearchForm.active .card-body {
            display: block;
        }

        /* accordion style */

        #studentSearchForm .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #studentSearchForm .card-header::after {
            content: "\f282";
            font-family: "bootstrap-icons";
            font-size: 16px;
        }

        #studentSearchForm.active .card-header::after {
            content: "\f286";
        }

        /* stack filter inputs */

        #studentSearchForm .row>div {
            width: 100%;
        }

        /* bigger search button */

        #studentSearchForm button {
            width: 100%;
            margin-top: 5px;
        }

    }


    /* Mobile Student Cards */

    .student-card {
        border-radius: 12px;
        border: 1px solid #e9ecef;
    }

    .student-card .card-body {
        padding: 14px;
    }

    .student-card .text-muted {
        font-size: 12px;
    }

    .student-card .fw-semibold {
        font-size: 14px;
    }

    .student-card .dropdown-menu {
        font-size: 14px;
    }


    @media (max-width: 768px) {
        .table-responsive {
            display: none;
        }
    }
</style>

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
                            <th>Admission Date</th>
                            <th>Education Type</th>
                            <th>Name</th>
                            <th>Class</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="studentsTableBody">
                        <?php
                        foreach ($all_students as $record) :
                        ?>
                            <tr>
                                <td><?= $record->studentId ?></td>
                                <td><?= $record->admissionNo ?></td>
                                <td><?= date('d M Y', strtotime($record->addedOn)) ?></td>
                                <td><?= $record->student_education_type ?></td>
                                <td><?= ucfirst($record->firstName) ?> <?= ucfirst($record->lastName) ?></td>
                                <td><?= $record->className ?> <?= $record->sectionName ?></td>

                                <td>
                                    <div class="d-flex gap-2">

                                        <!-- Controls Dropdown -->
                                        <div class="dropdown position-static">
                                            <button class="btn btn-sm btn-info dropdown-toggle"
                                                type="button"
                                                data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                Controls
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item navigator" href="<?= site_url('Student/student_profile/') . $record->studentId . '/' . $record->admissionNo ?>">View</a></li>
                                                <li><a class="dropdown-item navigator" href="<?= site_url('Student/student_data/') . $record->studentId . '/' . $record->admissionNo ?>">Edit</a></li>
                                                <li><a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#feeModal<?= $record->studentId ?>">Fee</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger btn-delete-student" href="javascript:void(0)" data-id="<?= $record->studentId ?>">Delete</a></li>
                                            </ul>
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
                                                            ?>

                                                            <?php endforeach; ?>

                                                        </div>
                                                        <!-- ================= END ACCORDION ================= -->

                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Reports Dropdown -->
                                        <div class="dropdown position-static">
                                            <button class="btn btn-sm btn-success dropdown-toggle"
                                                type="button"
                                                data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                Reports
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">School Leaving Certificate</a></li>
                                                <li><a class="dropdown-item" href="#">Fee Voucher</a></li>
                                                <li><a class="dropdown-item" href="#">Attendance Report</a></li>
                                            </ul>
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


    <!-- ================= MOBILE STUDENT CARDS ================= -->
    <div class="d-block d-md-none">

        <?php foreach ($all_students as $record): ?>

            <div class="card student-card mb-3 shadow-sm">

                <div class="card-body">

                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-2">

                        <div class="fw-bold fs-6">
                            <?= $record->firstName ?> <?= $record->lastName ?>
                        </div>

                        <span class="badge bg-primary">
                            ID: <?= $record->studentId ?>
                        </span>

                    </div>

                    <!-- Info Grid -->
                    <div class="row small g-2">

                        <div class="col-6">
                            <span class="text-muted">Admission</span><br>
                            <span class="fw-semibold"><?= $record->admissionNo ?></span>
                        </div>

                        <div class="col-6">
                            <span class="text-muted">Date</span><br>
                            <span class="fw-semibold"><?= date('d M Y', strtotime($record->addedOn)) ?></span>
                        </div>

                        <div class="col-6">
                            <span class="text-muted">Education</span><br>
                            <span class="fw-semibold"><?= $record->student_education_type ?></span>
                        </div>

                        <div class="col-6">
                            <span class="text-muted">Class</span><br>
                            <span class="fw-semibold"><?= $record->className ?> <?= $record->sectionName ?></span>
                        </div>

                    </div>

                    <!-- Buttons -->
                    <div class="d-grid gap-2 mt-3">

                        <!-- Controls -->
                        <div class="dropdown">
                            <button class="btn btn-info btn-sm dropdown-toggle w-100"
                                data-bs-toggle="dropdown">
                                Controls
                            </button>

                            <ul class="dropdown-menu w-100">
                                <li>
                                    <a class="dropdown-item navigator"
                                        href="<?= site_url('Student/student_profile/') . $record->studentId . '/' . $record->admissionNo ?>">
                                        View
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item navigator"
                                        href="<?= site_url('Student/student_data/') . $record->studentId . '/' . $record->admissionNo ?>">
                                        Edit
                                    </a>
                                </li>

                                <li>
                                    <button class="dropdown-item"
                                        data-bs-toggle="modal"
                                        data-bs-target="#feeModal<?= $record->studentId ?>">
                                        Fee
                                    </button>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger btn-delete-student" href="javascript:void(0)" data-id="<?= $record->studentId ?>">
                                        Delete
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Reports -->
                        <div class="dropdown">
                            <button class="btn btn-success btn-sm dropdown-toggle w-100"
                                data-bs-toggle="dropdown">
                                Reports
                            </button>

                            <ul class="dropdown-menu w-100">
                                <li><a class="dropdown-item" href="#">School Leaving Certificate</a></li>
                                <li><a class="dropdown-item" href="#">Fee Voucher</a></li>
                                <li><a class="dropdown-item" href="#">Attendance Report</a></li>
                            </ul>
                        </div>

                    </div>

                </div>
            </div>

        <?php endforeach; ?>

    </div>
</div>

<script>
    $(document).ready(function() {

        $(document).on("click", "#studentSearchForm .card-header", function() {
            $("#studentSearchForm").toggleClass("active");
        });

        // $('form').each(function() {
        //     this.reset();
        // });
        // initialize parsley ONCE
        $('.FormCollectFee').parsley();

        // remove previous handlers before binding
        $(document).off('submit', '.FormCollectFee');
        // submit handler
        $(document).off('submit', '.FormCollectFee').on('submit', '.FormCollectFee', function(e) {
            e.preventDefault();

            let form = $(this);

            if (!form.parsley().isValid()) {
                return;
            }

            $.ajax({
                url: "<?= site_url('Fee/collect_fee') ?>",
                type: "POST",
                data: form.serialize(),
                dataType: "json",
                cache: false,
                success: function(response) {

                    // close only current modal
                    let modalEl = form.closest('.modal');
                    let modal = bootstrap.Modal.getInstance(modalEl[0]);
                    if (modal) modal.hide();

                    Swal.fire({
                        title: response.status ? 'Success' : 'Error',
                        text: response.message,
                        icon: response.status ? 'success' : 'error',
                        timer: 3000,
                        showConfirmButton: true
                    });

                    if (response.status) {
                        $("#pageContent").load("<?= base_url('Student/all_students') ?>");
                    }
                }
            });
        });


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

        $(document).off('click', '.btn-delete-student').on('click', '.btn-delete-student', function(e) {
            e.preventDefault();
            let studentId = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this student?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= site_url('Student/delete_student') ?>",
                        type: "POST",
                        data: { studentId: studentId },
                        dataType: "json",
                        success: function(res) {
                            if (res.status === true) {
                                Swal.fire(
                                    'Deleted!',
                                    res.message,
                                    'success'
                                ).then(() => {
                                    $("#pageContent").load("<?= base_url('Student/all_students') ?>");
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    res.message,
                                    'error'
                                );
                            }
                        }
                    });
                }
            });
        });

    });
</script>