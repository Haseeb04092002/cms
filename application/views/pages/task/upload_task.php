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

    <div class="row mb-3">
        <div class="col">
            <h4 class="fw-bold">
                <i class="bi bi-clipboard-check me-2 text-primary"></i>
                Assign Task to Student
            </h4>
        </div>
    </div>

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
            <div class="card">
                <div class="card-header fw-bold">
                    <i class="bi bi-clock-history me-1"></i> Previous Tasks
                </div>

                <div class="card-body p-2" style="max-height: 75vh; overflow-y: auto;">

                    <?php if (!empty($tasks)): ?>
                        <?php foreach ($tasks as $task): ?>

                            <a href="<?= site_url('Tasks/individual_task_view/' . $task->taskId) ?>" class="task-card-link">
                                <div class="card mb-2 border task-card">
                                    <div class="card-body p-2 d-flex justify-content-between align-items-start">

                                        <div>
                                            <h6 class="fw-bold mb-1">
                                                <?= $task->taskTitle ?>
                                            </h6>

                                            <small class="text-muted d-block">
                                                Assigned: <?= date('d M Y', strtotime($task->startDate)) ?>
                                            </small>

                                            <small class="text-muted d-block">
                                                Deadline: <?= date('d M Y', strtotime($task->endDate)) ?>
                                            </small>

                                            <span class="badge <?= $task->status == 'completed' ? 'bg-success' : 'bg-warning' ?>">
                                                <?= ucfirst($task->status) ?>
                                            </span>
                                        </div>

                                        <!-- CLICK INDICATOR -->
                                        <div class="ms-2 text-muted task-arrow">
                                            <i class="bi bi-chevron-right"></i>
                                        </div>

                                    </div>
                                </div>
                            </a>

                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#taskDetailModal">
                                View Task
                            </button>


                            <div class="modal fade" id="taskDetailModal" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">

                                        <!-- MODAL HEADER -->
                                        <div class="modal-header bg-light">
                                            <h5 class="modal-title fw-bold">
                                                Task Details
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <!-- MODAL BODY -->
                                        <div class="modal-body">

                                            <!-- TASK TITLE -->
                                            <h4 class="fw-bold mb-2">
                                                Web Development Assignment
                                            </h4>

                                            <!-- SUBJECT / COURSE -->
                                            <span class="badge bg-primary mb-3">
                                                Computer Science
                                            </span>

                                            <!-- DESCRIPTION -->
                                            <div class="mb-4">
                                                <h6 class="fw-bold">Task Description</h6>
                                                <p class="text-muted mb-0">
                                                    Create a responsive webpage using HTML5 and CSS3.
                                                    The layout must be mobile-friendly and follow
                                                    best UI/UX practices.
                                                </p>
                                            </div>

                                            <!-- DATES -->
                                            <div class="row mb-4">
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block">Start Date</small>
                                                    <span class="fw-semibold">05 Feb 2026</span>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block">Deadline</small>
                                                    <span class="fw-semibold text-danger">
                                                        15 Feb 2026
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- MARKS -->
                                            <div class="row mb-4">
                                                <div class="col-md-4">
                                                    <small class="text-muted d-block">Total Marks</small>
                                                    <span class="fw-bold">100</span>
                                                </div>
                                                <div class="col-md-4">
                                                    <small class="text-muted d-block">Passing Marks</small>
                                                    <span class="fw-bold">40</span>
                                                </div>
                                                <div class="col-md-4">
                                                    <small class="text-muted d-block">Weightage</small>
                                                    <span class="fw-bold">20%</span>
                                                </div>
                                            </div>

                                            <!-- ATTACHMENTS -->
                                            <div class="mb-4">
                                                <h6 class="fw-bold mb-3">Attachments</h6>

                                                <div class="row g-3">

                                                    <div class="col-md-6">
                                                        <a href="uploads/assignment_instructions.pdf"
                                                            target="_blank"
                                                            class="text-decoration-none">
                                                            <div class="card border shadow-sm h-100">
                                                                <div class="card-body">
                                                                    <h6 class="fw-semibold mb-1">
                                                                        assignment_instructions.pdf
                                                                    </h6>
                                                                    <small class="text-muted">
                                                                        Click to open
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <a href="uploads/sample_layout.zip"
                                                            target="_blank"
                                                            class="text-decoration-none">
                                                            <div class="card border shadow-sm h-100">
                                                                <div class="card-body">
                                                                    <h6 class="fw-semibold mb-1">
                                                                        sample_layout.zip
                                                                    </h6>
                                                                    <small class="text-muted">
                                                                        Click to open
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>

                                                </div>
                                            </div>

                                            <!-- REFERENCE LINK -->
                                            <div class="mb-2">
                                                <h6 class="fw-bold">Reference Link</h6>
                                                <a href="https://developer.mozilla.org"
                                                    target="_blank">
                                                    https://developer.mozilla.org
                                                </a>
                                            </div>

                                        </div>

                                        <!-- MODAL FOOTER -->
                                        <div class="modal-footer bg-light">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">
                                                Close
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>


                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted text-center small mb-0">
                            No previous tasks found
                        </p>
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
                                <label class="form-label fw-bold">Task Title</label>
                                <input type="text"
                                    name="task_title"
                                    class="form-control"
                                    placeholder="Enter task title"
                                    required
                                    data-parsley-required-message="Task title is required">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Subject / Course</label>
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
                            placeholder="Write task details, instructions, references..."
                            required
                            data-parsley-required-message="Task description is required"></textarea>

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
                                    required
                                    name="attachments[]"
                                    data-parsley-required-message="Please upload at least one file">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Reference Link</label>
                                <input type="url"
                                    class="form-control"
                                    placeholder="https://example.com"
                                    required
                                    name="reference_link"
                                    data-parsley-required-message="Reference link is required">
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
                                <label class="form-label fw-bold">Starting Date</label>
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
                                    required
                                    name="end_date"
                                    data-parsley-required-message="Deadline date is required">
                            </div>

                        </div>
                    </div>
                </div>

                <!-- ================= MARKS ================= -->
                <div class="card mb-3">
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
                </div>

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