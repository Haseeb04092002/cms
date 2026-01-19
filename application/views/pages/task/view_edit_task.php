<?php
$readOnly = true;
if ($case == 'edit') {
    $readOnly = false;
}
?>

<style>
    .preview-file {
        cursor: pointer;
    }

    .preview-file:hover {
        text-decoration: underline;
    }
</style>

<div class="container-fluid p-4">

    <div class="mb-3 justify-content-between align-items-center d-flex">
        <div class="">
            <h4 class="fw-bold text-uppercase">
                <i class="bi bi-clipboard-check me-2 text-primary"></i>
                <?= $case ?> Task
            </h4>
        </div>
        <div class="<?= ($readOnly ? 'd-block' : 'd-none') ?>">
            <button class="btn btn-warning" id="editTaskBtn">Edit Task</button>
        </div>
    </div>

    <div class="row">

        <div class="col-lg-12">
            <!-- <form class="FormSaveTask" enctype="multipart/form-data" data-parsley-validate> -->
            <form class="FormSaveTask"
                method="post"
                enctype="multipart/form-data"
                data-parsley-validate>


                <input type="hidden" name="classId" value="<?= $classId ?? '' ?>">
                <input type="hidden" name="taskId" value="<?= $task->taskId ?? '' ?>">
                <input type="hidden" name="studentId" value="<?= $studentId ?? '' ?>">

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
                                    value="<?= $task->taskTitle ?>"
                                    <?= ($readOnly ? 'readonly' : '') ?>
                                    data-parsley-required-message="Task title is required">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Subject / Course</label>
                                <select class="form-select"
                                    name="subject"
                                    required
                                    <?= ($readOnly ? 'readonly' : '') ?>
                                    data-parsley-required-message="Please select a subject">
                                    <option value="">-- Select --</option>
                                    <?php if (!empty($subjects)): ?>
                                        <?php foreach ($subjects as $subject): ?>
                                            <option value="<?= $subject->subjectId ?>"
                                                <?= (!empty($task->subjectId) && $task->subjectId == $subject->subjectId) ? 'selected' : '' ?>>
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
                            <?= ($readOnly ? 'readonly' : '') ?>
                            placeholder="Write task details, instructions, references..."
                            required
                            data-parsley-required-message="Task description is required"><?= $task->taskDescription ?? '' ?></textarea>

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

                                <input type="hidden" name="existing_attachments" id="existingAttachments"
                                    value='<?= json_encode($documents) ?>'>

                                <script>
                                    $(document).on('click', '.remove-doc', function() {

                                        let docItem = $(this).closest('.doc-item');
                                        let path = docItem.data('path');

                                        // Remove visually
                                        docItem.remove();

                                        // Update hidden input
                                        let existing = JSON.parse($('#existingAttachments').val() || '[]');
                                        existing = existing.filter(item => item !== path);
                                        $('#existingAttachments').val(JSON.stringify(existing));
                                    });


                                    $(document).on('click', '.preview-file', function() {

                                        let fileUrl = $(this).data('path');
                                        let fileName = $(this).data('name');
                                        let ext = fileName.split('.').pop().toLowerCase();

                                        $('#previewTitle').text(fileName);

                                        let previewHtml = '';

                                        // IMAGE
                                        if (['jpg', 'jpeg', 'png'].includes(ext)) {
                                            previewHtml = `
                                                <img src="${fileUrl}" class="img-fluid rounded" alt="">
                                            `;
                                        }
                                        // PDF
                                        else if (ext === 'pdf') {
                                            previewHtml = `
                                                <iframe src="${fileUrl}"
                                                        style="width:100%; height:80vh;"
                                                        frameborder="0"></iframe>
                                            `;
                                        }
                                        // VIDEO
                                        else if (['mp4', 'webm', 'ogg'].includes(ext)) {
                                            previewHtml = `
                                                <video controls style="width:100%; max-height:80vh;">
                                                    <source src="${fileUrl}">
                                                    Your browser does not support video preview.
                                                </video>
                                            `;
                                        }
                                        // OTHER FILE TYPES
                                        else {
                                            previewHtml = `
                                                <div class="p-5">
                                                    <i class="bi bi-file-earmark-arrow-down fs-1"></i>
                                                    <p class="mt-3">Preview not available</p>
                                                    <a href="${fileUrl}" target="_blank" class="btn btn-primary">
                                                        Download File
                                                    </a>
                                                </div>
                                            `;
                                        }

                                        $('#previewBody').html(previewHtml);

                                        let modal = new bootstrap.Modal(document.getElementById('filePreviewModal'));
                                        modal.show();
                                    });
                                </script>

                                <?php if (!empty($all_docs)): ?>
                                    <div class="col-12 mt-3">
                                        <label class="form-label fw-bold">Uploaded Files</label>

                                        <div class="row g-2" id="uploadedDocs">
                                            <?php foreach ($all_docs as $doc): ?>
                                                <div class="col-md-4 doc-item" data-path="<?= $doc ?>">
                                                    <div class="border rounded p-2 position-relative bg-light">

                                                        <!-- Remove Button -->
                                                        <button type="button"
                                                            class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-doc"
                                                            style="border-radius:0 6px 0 6px;">
                                                            ✕
                                                        </button>

                                                        <!-- File Link -->
                                                        <!-- <a href="<?= base_url($doc) ?>" target="_blank" class="text-decoration-none">
                                                            <i class="bi bi-file-earmark-text me-1"></i>
                                                            <?= basename($doc) ?>
                                                        </a> -->

                                                        <a href="javascript:void(0)"
                                                            class="preview-file text-decoration-none"
                                                            data-path="<?= base_url($doc) ?>"
                                                            data-name="<?= basename($doc) ?>">
                                                            <i class="bi bi-file-earmark-text me-1"></i>
                                                            <?= basename($doc) ?>
                                                        </a>


                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- File Preview Modal -->
                                <div class="modal fade" id="filePreviewModal" tabindex="-1">
                                    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h5 class="modal-title" id="previewTitle">File Preview</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body text-center" id="previewBody">
                                                <!-- dynamic content -->
                                            </div>

                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Reference Link</label>
                                <input type="url"
                                    class="form-control"
                                    placeholder="https://example.com"
                                    required
                                    <?= ($readOnly ? 'readonly' : '') ?>
                                    name="reference_link"
                                    value="<?= $task->referenceLink ?? '' ?>"
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
                                    <?= ($readOnly ? 'readonly' : '') ?>
                                    value="<?= $task->startDate ?? '' ?>"
                                    data-parsley-required-message="Starting date is required">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Deadline / Ending Date</label>
                                <input type="date"
                                    class="form-control"
                                    required
                                    name="end_date"
                                    <?= ($readOnly ? 'readonly' : '') ?>
                                    value="<?= $task->endDate ?? '' ?>"
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
                                    <?= ($readOnly ? 'readonly' : '') ?>
                                    value="<?= $task->totalMarks ?? '' ?>"
                                    data-parsley-required-message="Total marks are required">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Passing Marks</label>
                                <input type="number"
                                    class="form-control"
                                    placeholder="40"
                                    required
                                    name="passing_marks"
                                    <?= ($readOnly ? 'readonly' : '') ?>
                                    value="<?= $task->passingMarks ?? '' ?>"
                                    data-parsley-required-message="Passing marks are required">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Weightage (%)</label>
                                <input type="number"
                                    class="form-control"
                                    placeholder="10"
                                    required
                                    name="weightage"
                                    <?= ($readOnly ? 'readonly' : '') ?>
                                    value="<?= $task->weightage ?? '' ?>"
                                    data-parsley-required-message="Weightage is required">
                            </div>

                        </div>
                    </div>
                </div>

                <!-- ================= ACTIONS ================= -->
                <div class="text-end">
                    <?php if (!$readOnly): ?>
                        <button type="reset" class="btn btn-secondary me-2">
                            <i class="bi bi-x-circle"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send-check"></i> Assign Task
                        </button>
                    <?php endif; ?>
                </div>

            </form>

        </div>

    </div>



</div>



<script>
    $(document).ready(function() {

        $('#editTaskBtn').on('click', function() {
            $("#pageContent").load("<?= site_url('Tasks/view_edit_task/edit/') . $task->taskId. '/'. $studentId . '/' . $classId ?>");
        });

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
                        $("#pageContent").load("<?= site_url('Tasks/view_edit_task/view/') . $task->taskId. '/'. $studentId . '/' . $classId ?>");
                    }
                }
            });
        });

    });
</script>