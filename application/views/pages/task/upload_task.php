<style>
    .task-card-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .task-card {
        transition: background-color .2s ease,
            transform .2s ease,
            box-shadow .2s ease;
    }

    .task-card:hover {
        background-color: var(--bs-light);
        transform: scale(1.015);
        box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .08);
    }

    .task-arrow {
        font-size: 1.25rem;
        transition: transform .2s ease, color .2s ease;
    }

    .task-card:hover .task-arrow {
        transform: translateX(4px);
        color: var(--bs-primary);
    }
</style>



<div class="container-fluid p-4">

    <div class="row">

        <!-- ================= LEFT SIDEBAR : OLD TASKS ================= -->
        <div class="col-lg-3 mb-4">

            <!-- Student Intro -->
            <div class="card mb-3">
                <div class="card-body text-center">
                    <?php if (!empty($student->documentPath)): ?>
                        <img src="<?= base_url($student->documentPath); ?>"
                            alt="Profile Image"
                            class="img-thumbnail rounded-circle"
                            width="75">
                    <?php else: ?>
                        <img src="<?= base_url('assets/images/default-avatar.png'); ?>"
                            class="img-thumbnail rounded-circle"
                            width="75">
                    <?php endif; ?>

                    <h6 class="fw-bold mb-0"><?= $student->firstName ?> <?= $student->lastName ?></h6>
                    <small class="text-muted"><?= $student->className ?> - <?= $student->sectionName ?></small><br>
                    <small class="text-muted">Education: <?= $student->education_type ?></small>
                </div>
            </div>

            <!-- Old Tasks -->
            <div class="d-none card">
                <div class="card-header fw-bold">
                    <i class="bi bi-clock-history me-1"></i> Previous Tasks
                </div>

                <div class="card-body p-2" style="max-height: 75vh; overflow-y: auto;">

                    <?php if (!empty($tasks)): ?>
                        <?php foreach ($tasks as $task): ?>

                            <div class="card mb-3 border-0 shadow-sm task-card-corporate">
                                <div class="card-body py-3 px-4">

                                    <div class="d-flex justify-content-between align-items-center">

                                        <!-- LEFT CONTENT -->
                                        <div>

                                            <h6 class="mb-2 fw-semibold text-dark">
                                                <?= $task->taskTitle ?>
                                            </h6>

                                            <div class="small text-muted mb-1">
                                                Assigned: <?= date('d M Y', strtotime($task->startDate)) ?>
                                            </div>

                                            <div class="small text-muted">
                                                Deadline: <?= date('d M Y', strtotime($task->endDate)) ?>
                                            </div>

                                        </div>

                                        <!-- RIGHT SIDE -->
                                        <div class="text-end">

                                            <div class="mb-2">
                                                <?php
                                                $statusClass = 'bg-secondary';
                                                if ($task->status == 'completed') $statusClass = 'bg-success';
                                                elseif ($task->status == 'pending') $statusClass = 'bg-warning';
                                                elseif ($task->status == 'overdue') $statusClass = 'bg-danger';
                                                ?>
                                                <span class="badge <?= $statusClass ?> px-3 py-2">
                                                    <?= ucfirst($task->status) ?>
                                                </span>
                                            </div>

                                            <button class="btn btn-outline-dark btn-sm px-3"
                                                data-bs-toggle="modal"
                                                data-bs-target="#taskModal<?= $task->taskId ?>">
                                                View
                                            </button>

                                        </div>

                                    </div>

                                </div>
                            </div>

                            <div class="modal fade" id="taskModal<?= $task->taskId ?>" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content border-0 shadow">

                                        <!-- HEADER -->
                                        <div class="modal-header bg-white border-bottom">
                                            <div>
                                                <h5 class="modal-title fw-semibold mb-1">
                                                    <?= $task->taskTitle ?>
                                                </h5>
                                                <small class="text-muted">
                                                    Task Details
                                                </small>
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <!-- BODY -->
                                        <div class="modal-body px-4 py-3">

                                            <!-- Description -->
                                            <div class="mb-4">
                                                <label class="small text-muted mb-1">Description</label>
                                                <div class="border rounded p-3 bg-light small">
                                                    <?= $task->taskDescription ?>
                                                </div>
                                            </div>

                                            <!-- Dates -->
                                            <div class="row mb-4">
                                                <div class="col-md-6">
                                                    <label class="small text-muted">Assigned Date</label>
                                                    <div class="fw-semibold">
                                                        <?= date('d M Y', strtotime($task->startDate)) ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="small text-muted">Deadline</label>
                                                    <div class="fw-semibold text-danger">
                                                        <?= date('d M Y', strtotime($task->endDate)) ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Marks Section -->
                                            <div class="row mb-4">
                                                <div class="col-md-4">
                                                    <label class="small text-muted">Total Marks</label>
                                                    <div class="fw-semibold"><?= $task->totalMarks ?></div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="small text-muted">Passing Marks</label>
                                                    <div class="fw-semibold"><?= $task->passingMarks ?></div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="small text-muted">Weightage</label>
                                                    <div class="fw-semibold"><?= $task->weightage ?>%</div>
                                                </div>
                                            </div>

                                            <!-- Reference Link -->
                                            <?php if (!empty($task->referenceLink)): ?>
                                                <div class="mb-4">
                                                    <label class="small text-muted">Reference Link</label>
                                                    <div>
                                                        <a href="<?= $task->referenceLink ?>" target="_blank" class="text-decoration-none">
                                                            <?= $task->referenceLink ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <!-- Attachments -->
                                            <?php if (!empty($task->documents)): ?>
                                                <div class="mb-3">
                                                    <label class="small text-muted mb-2">Attachments</label>

                                                    <div class="list-group list-group-flush border rounded">
                                                        <?php foreach ($task->documents as $doc): ?>
                                                            <a href="<?= base_url($doc->documentPath) ?>"
                                                                target="_blank"
                                                                class="list-group-item list-group-item-action small d-flex justify-content-between align-items-center">
                                                                <?= $doc->documentTitle ?>
                                                                <i class="bi bi-box-arrow-up-right small"></i>
                                                            </a>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                        </div>

                                        <!-- FOOTER -->
                                        <div class="modal-footer bg-white border-top">

                                            <a href="<?= site_url('Tasks/edit/' . $task->taskId) ?>"
                                                class="btn btn-outline-secondary btn-sm px-3">
                                                Edit
                                            </a>

                                            <a href="<?= site_url('Tasks/delete/' . $task->taskId) ?>"
                                                class="btn btn-outline-danger btn-sm px-3"
                                                onclick="return confirm('Delete this task?')">
                                                Delete
                                            </a>

                                            <button class="btn btn-dark btn-sm px-3"
                                                data-bs-dismiss="modal">
                                                Close
                                            </button>

                                        </div>

                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </div>
            </div>

        </div>

        <!-- ================= RIGHT SECTION : YOUR EXISTING FORM ================= -->
        <div class="col-lg-9">
            <!-- <form class="FormSaveTask" enctype="multipart/form-data" data-parsley-validate> -->
            <form class="FormSaveTask"
                method="post"
                enctype="multipart/form-data"
                data-parsley-validate>


                <input type="hidden" name="classId" value="<?= $student->classId ?>">
                <input type="hidden" name="studentId" value="<?= $student->studentId ?>">

                <!-- ================= BASIC INFO ================= -->
                <div class="card mb-3">
                    <div class="card-header fw-bold">
                        <i class="bi bi-info-circle me-1"></i> Task Information
                    </div>

                    <div class="card-body">
                        <div class="row mb-3">

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Task Title <span class="fs-5 text-danger">*</span></label>
                                <input type="text"
                                    name="task_title"
                                    class="form-control"
                                    placeholder="Enter task title"
                                    required
                                    data-parsley-required-message="Task title is required">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Subject / Course <span class="fs-5 text-danger">*</span></label>
                                <select class="form-select"
                                    name="subject"
                                    required
                                    data-parsley-required-message="Please select a subject">
                                    <option value="">-- Select --</option>
                                    <?php if (!empty($subjects)): ?>
                                        <?php foreach ($subjects as $subject): ?>
                                            <option value="<?= $subject->subjectId ?>">
                                                <?= $subject->subjectName ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- ================= TASK DESCRIPTION ================= -->
                <div class="card mb-3">
                    <div class="card-header fw-bold">
                        <i class="bi bi-textarea-t me-1"></i> Task Description
                    </div>

                    <div class="card-body">

                        <!-- Toolbar (unchanged) -->

                        <textarea class="form-control"
                            rows="6"
                            name="task_description"
                            placeholder="Write task details, instructions, references..."></textarea>

                    </div>
                </div>

                <!-- ================= ATTACHMENTS ================= -->
                <div class="card mb-3">
                    <div class="card-header fw-bold">
                        <i class="bi bi-paperclip me-1"></i> Attachments & Resources
                    </div>

                    <div class="card-body">
                        <div class="row mb-3">

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Upload Files</label>
                                <input type="file"
                                    class="form-control"
                                    multiple
                                    name="attachments[]">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Reference Link</label>
                                <input type="url"
                                    class="form-control"
                                    placeholder="https://example.com"
                                    name="reference_link">
                            </div>

                        </div>
                    </div>
                </div>

                <!-- ================= DATES ================= -->
                <div class="card mb-3">
                    <div class="card-header fw-bold">
                        <i class="bi bi-calendar-event me-1"></i> Schedule
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Starting Date <span class="fs-5 text-danger">*</span></label>
                                <input type="date"
                                    class="form-control"
                                    required
                                    name="start_date"
                                    data-parsley-required-message="Starting date is required">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Deadline / Ending Date</label>
                                <input type="date"
                                    class="form-control"
                                    name="end_date">
                            </div>

                        </div>
                    </div>
                </div>

                <!-- ================= MARKS ================= -->
                <!-- <div class="card mb-3">
                    <div class="card-header fw-bold">
                        <i class="bi bi-award me-1"></i> Marks & Evaluation
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Total Marks</label>
                                <input type="number"
                                    class="form-control"
                                    placeholder="100"
                                    required
                                    name="total_marks"
                                    data-parsley-required-message="Total marks are required">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Passing Marks</label>
                                <input type="number"
                                    class="form-control"
                                    placeholder="40"
                                    required
                                    name="passing_marks"
                                    data-parsley-required-message="Passing marks are required">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Weightage (%)</label>
                                <input type="number"
                                    class="form-control"
                                    placeholder="10"
                                    required
                                    name="weightage"
                                    data-parsley-required-message="Weightage is required">
                            </div>

                        </div>
                    </div>
                </div> -->

                <!-- ================= ACTIONS ================= -->
                <div class="text-end">
                    <button type="reset" class="btn btn-secondary me-2">
                        <i class="bi bi-x-circle"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send-check"></i> Assign Task
                    </button>
                </div>

            </form>

        </div>

    </div>



</div>



<script>
    $(document).ready(function() {

        // $('form').each(function() {
        //     this.reset();
        // });
        // initialize parsley ONCE
        $('.FormSaveTask').parsley();

        $(document).off('submit', '.FormSaveTask');
        $(document).on('submit', '.FormSaveTask', function(e) {
            e.preventDefault();

            let form = $(this);

            if (!form.parsley().isValid()) {
                return;
            }

            let formData = new FormData(this);

            // formData.delete('checkStudent[]');

            // $('.student-checkbox:checked').each(function() {
            //     formData.append('checkStudent[]', $(this).val());
            // });

            // if ($('.student-checkbox:checked').length === 0) {
            //     Swal.fire({
            //         icon: 'warning',
            //         title: 'No Student Selected',
            //         text: 'Please select at least one student'
            //     });
            //     return;
            // }


            if (!form.parsley().isValid()) {
                return;
            }

            $.ajax({
                url: "<?= site_url('Tasks/individual_save_task') ?>",
                type: "POST",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {

                    let modalEl = form.closest('.modal');
                    let modal = bootstrap.Modal.getInstance(modalEl[0]);
                    if (modal) modal.hide();

                    Swal.fire({
                        title: response.status ? 'Success' : 'Error',
                        text: response.message,
                        icon: response.status ? 'success' : 'error',
                        timer: 300000,
                        showConfirmButton: true
                    });

                    if (response.status) {
                        $("#pageContent").load("<?= base_url('Tasks/individual_task_upload') ?>");
                    }
                }
            });
        });

    });
</script>