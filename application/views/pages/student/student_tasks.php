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
        <?php if ($class): ?>
            <h4 class="fw-bold">Assign Tasks to <span class="text-uppercase text-success"><?= $class->className ?> <?= $class->sectionName ?></span></h4>
        <?php endif; ?>
        <h4 class="fw-bold">Assign Tasks to Students</span></h4>
    </div>

    <div class="row">

        <div class="col-lg-3 mb-4">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 table-bordered align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody id="studentTableBody">
                                <?php
                                
                                foreach ($all_students as $record) :
                                ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input fs-4 student-checkbox" name="checkStudent[]" checked value="<?= $record->studentId ?>">
                                        </td>
                                        <td><?= $record->studentId ?></td>
                                        <td><?= $record->firstName ?> <?= $record->lastName ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <form class="FormSaveTask"
                method="post"
                enctype="multipart/form-data"
                data-parsley-validate>
                <input type="hidden" name="classId" value="<?= $class->classId ?>">
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

                <div class="card mb-3">
                    <div class="card-header fw-bold">
                        <i class="bi bi-textarea-t me-1"></i> Task Description
                    </div>

                    <div class="card-body">

                        <textarea class="form-control"
                            rows="6"
                            name="task_description"
                            placeholder="Write task details, instructions, references..."
                            required
                            data-parsley-required-message="Task description is required"></textarea>

                    </div>
                </div>
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

        $('#FindStudentForm').parsley();

        $(document).on('click', '#resetBtn', function() {
            $("#pageContent").load("<?= base_url('Tasks/student_tasks') ?>");
        });

        function formatDate(dateString) {
            const date = new Date(dateString);

            const options = {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            };

            return date.toLocaleString('en-GB', options).replace(',', '');
        }


        $(document).on('submit', '#FindStudentForm', function(e) {
            e.preventDefault();

            let form = $(this);
            if (!form.parsley().isValid()) return;

            $.ajax({
                url: "<?= site_url('Student/find_student') ?>",
                type: "POST",
                data: form.serialize(),
                dataType: "json",

                beforeSend: function() {
                    $('#studentTableBody').html(
                        '<tr><td colspan="9" class="text-center">Loading...</td></tr>'
                    );
                },

                success: function(response) {

                    if (!response.status || response.data.length === 0) {
                        $('#studentTableBody').html(
                            '<tr><td colspan="9" class="text-center text-muted">No students found</td></tr>'
                        );
                        return;
                    }

                    let rows = '';

                    response.data.forEach(function(r) {

                        let img = r.documentPath ?
                            "<?= base_url() ?>" + r.documentPath :
                            "<?= base_url('assets/images/default-avatar.png') ?>";

                        let date = new Date(r.addedOn).toLocaleString();
                        let formattedDate = formatDate(date);

                        rows += `
                        <tr>
                            <td>${r.studentId}</td>

                            <td>
                                <img src="${img}"
                                     class="img-thumbnail rounded-circle"
                                     width="70">
                            </td>

                            <td>${r.admissionNo}</td>
                            <td>${formattedDate}</td>
                            <td>${r.student_education_type}</td>
                            <td>${r.firstName} ${r.lastName}</td>
                            <td>${r.className} ${r.sectionName}</td>

                            <td>
                                <span class="badge bg-warning text-dark">
                                    ${r.status}
                                </span>
                            </td>

                            <td>
                                <a class="btn btn-sm btn-info navigator" href="<?= site_url('Tasks/upload_task/student/') . $record->studentId ?>">
                                    Assign Task
                                </a>
                            </td>
                        </tr>
                    `;
                    });

                    $('#studentTableBody').html(rows);
                },

                error: function() {
                    $('#studentTableBody').html(
                        '<tr><td colspan="9" class="text-danger text-center">Server Error</td></tr>'
                    );
                }
            });
        });

        // =============================================
        
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

            $('.student-checkbox:checked').each(function() {
                formData.append('checkStudent[]', $(this).val());
            });

            if ($('.student-checkbox:checked').length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Student Selected',
                    text: 'Please select at least one student'
                });
                return;
            }


            if (!form.parsley().isValid()) {
                return;
            }

            $.ajax({
                url: "<?= site_url('Tasks/save_task') ?>",
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
                        $("#pageContent").load("<?= base_url('Tasks/bulk_tasks') ?>");
                    }
                }
            });
        });

    });
</script>