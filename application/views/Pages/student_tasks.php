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
    <div class="d-flex justify-content-between mb-3">
        <h4 class="fw-bold">Assign Tasks to Students</h4>
    </div>

    <!-- Search Student Card -->
    <div class="card mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">Search Student</h5>
        </div>
        <div class="card-body">
            <form id="FindStudentForm" data-parsley-validate>
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
                        <input type="text" class="form-control" name="student_name" data-parsley-required-message="Student Name is required">
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
                <button class="btn btn-primary mt-3 ms-3" type="reset" id="resetBtn">Reset</button>

            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">

                <table class="table table-hover mb-0 table-bordered align-middle">

                    <colgroup>
                        <col style="width:5%"> <!-- Student ID -->
                        <col style="width:10%"> <!-- Admission No -->
                        <col style="width:10%"> <!-- Education -->
                        <col style="width:15%"> <!-- Name -->
                        <col style="width:15%"> <!-- Class -->
                        <col style="width: 5%"> <!-- Total -->
                        <col style="width: 5%"> <!-- Completed -->
                        <col style="width: 5%"> <!-- Pending -->
                        <col style="width:10%"> <!-- Actions -->
                    </colgroup>

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Admission No</th>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Class</th>
                            <th>Tasks</th>
                            <th>Completed</th>
                            <th>Pending</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($all_students as $record): ?>
                            <tr>
                                <td><?= $record->studentId ?></td>
                                <td><?= $record->admissionNo ?></td>
                                <td><?= $record->student_education_type ?></td>
                                <td><?= $record->firstName ?> <?= $record->lastName ?></td>
                                <td><?= $record->className ?> <?= $record->sectionName ?></td>
                                <td>5</td>
                                <td>3</td>
                                <td>2</td>
                                <td>
                                    <!-- Controls Dropdown -->
                                    <div class="dropdown position-static">
                                        <button class="btn btn-sm btn-info dropdown-toggle"
                                            type="button"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            Controls
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item navigator" href="">
                                                    <i class="bi bi-list-check me-2 text-primary"></i>
                                                    View all tasks
                                                </a>
                                            </li>

                                            <li>
                                                <a class="dropdown-item navigator" href="">
                                                    <i class="bi bi-person-badge me-2 text-success"></i>
                                                    Student profile
                                                </a>
                                            </li>

                                            <li>
                                                <a class="dropdown-item navigator" href="<?= site_url('Cms/upload_task') ?>">
                                                    <i class="bi bi-plus-square me-2 text-warning"></i>
                                                    Assign tasks
                                                </a>
                                            </li>

                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="bi bi-arrow-up-circle me-2 text-info"></i>
                                                    Promote
                                                </a>
                                            </li>
                                        </ul>

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

        // $('form').each(function() {
        //     this.reset();
        // });
        // initialize parsley ONCE
        $('.FormCollectFee').parsley();

        // remove previous handlers before binding
        $(document).off('submit', '.FormCollectFee');
        // submit handler
        $(document).on('submit', '.FormCollectFee', function(e) {
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
                        $("#pageContent").load("<?= base_url('Cms/all_students') ?>");
                    }
                }
            });
        });

    });
</script>