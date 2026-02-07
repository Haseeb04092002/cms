<div class="p-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">All Tasks</h3>
    </div>

    <div class="card mb-3 border-dark">
        <form id="taskSearchForm">
            <div class="card-header p-1 ps-2">
                <h6 class="mb-0">Search Tasks</h6>
            </div>
            <div class="card-body p-3">
                <div class="row g-2 align-items-end">

                    <div class="col-md-2">
                        <label class="form-label mb-1">Task title</label>
                        <input type="text"
                            name="taskTitle"
                            class="form-control form-control-sm">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label mb-1">Assign Date</label>
                        <input type="date"
                            name="assignDate"
                            class="form-control form-control-sm">
                    </div>

                    <div class="col-md-1">
                        <label class="form-label mb-1">Status</label>
                        <input type="text"
                            name="status"
                            class="form-control form-control-sm">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label mb-1">Student Name</label>
                        <input type="text"
                            name="studentName"
                            class="form-control form-control-sm">
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
                            <th>Task ID</th>
                            <th>Title</th>
                            <th>Assign Date</th>
                            <th>Status</th>
                            <th>Student</th>
                            <th>Class</th>
                            <th>Education</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tasksTableBody">
                        <?php
                        foreach ($all_tasks as $record) :
                        ?>
                            <tr>
                                <td><?= $record->taskId ?></td>
                                <td><?= $record->taskTitle ?></td>
                                <td><?= date('d M Y g:i A', strtotime($record->addedOn)) ?></td>
                                <td><?= $record->status ?></td>
                                <td><?= $record->firstName ?> <?= $record->lastName ?></td>
                                <td><?= $record->className ?> <?= $record->sectionName ?></td>
                                <td><?= $record->student_education_type ?></td>
                                <td>

                                    <a class="btn btn-sm btn-info navigator" href="<?= site_url('Tasks/view_edit_task/view/') . $record->taskId . '/' . $record->studentId . '/' . $record->classId ?>">
                                        View
                                    </a>

                                    <a class="btn btn-sm btn-warning navigator" href="<?= site_url('Tasks/view_edit_task/edit/') . $record->taskId . '/' . $record->studentId . '/' . $record->classId ?>">
                                        Edit
                                    </a>

                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $record->taskId ?>">
                                        Delete
                                    </button>

                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="deleteModal<?= $record->taskId ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">

                                                <div class="modal-header bg-light">
                                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <form class="FormDeleteTask" data-parsley-validate>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete this item ?</p>
                                                        <input type="hidden" name="taskId" value="<?= $record->taskId ?>">
                                                        <div class="text-end">
                                                            <button class="btn btn-danger BtnDeleteTask">Yes</button>
                                                        </div>
                                                    </div>
                                                </form>

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

        $('.FormDeleteTask').parsley();
        $(document).on('click', '.BtnDeleteTask', function(e) {
            e.preventDefault();
            $(this).closest('form').submit();
        });

        $(document).off('submit', '.FormDeleteTask');
        $(document).on('submit', '.FormDeleteTask', function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= site_url('Tasks/delete_task') ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.status === false) {
                        Swal.fire({
                            title: 'Error',
                            text: response.message,
                            icon: 'error',
                            position: 'center',
                            timer: 3000,
                            showConfirmButton: true,
                            confirmButtonText: 'OK',
                        });

                    } else {
                        var url = "<?= base_url('Tasks/all_tasks') ?>";
                        console.log(url);
                        document.querySelectorAll('.modal').forEach(modalEl => {
                            const modalInstance = bootstrap.Modal.getInstance(modalEl) ||
                                new bootstrap.Modal(modalEl); // in case it's not initialized yet
                            modalInstance.hide();
                        });
                        Swal.fire({
                            title: 'Success',
                            text: response.message,
                            icon: 'success',
                            position: 'center',
                            timer: 3000,
                            showConfirmButton: true,
                            confirmButtonText: 'OK',
                        });

                        $("#pageContent").load(url, function() {
                            // $('.selectpicker').selectpicker();
                        });
                    }
                }
            });
        });

        $('#taskSearchForm').off('submit').on('submit', function(e) {
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
                url: "<?= site_url('Tasks/find_task') ?>",
                type: "POST",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,

                success: function(res) {

                    Swal.close();

                    if (res.status === true) {

                        let html = '';

                        $.each(res.data, function(i, record) {

                            let addedOn = new Date(record.addedOn).toLocaleString('en-GB', {
                                day: '2-digit',
                                month: 'short',
                                year: 'numeric',
                                hour: 'numeric',
                                minute: '2-digit',
                                hour12: true
                            });

                            html += `
                                <tr>
                                    <td>${record.taskId}</td>
                                    <td>${record.taskTitle}</td>
                                    <td>${addedOn}</td>
                                    <td>${record.status}</td>
                                    <td>${record.firstName} ${record.lastName}</td>
                                    <td>${record.className} ${record.sectionName}</td>
                                    <td>${record.student_education_type}</td>
                                    <td>

                                        <a class="btn btn-sm btn-info navigator"
                                        href="<?= site_url('Tasks/view_edit_task/view/') ?>${record.taskId}/${record.studentId}/${record.classId}">
                                            View
                                        </a>

                                        <a class="btn btn-sm btn-warning navigator"
                                        href="<?= site_url('Tasks/view_edit_task/edit/') ?>${record.taskId}/${record.studentId}/${record.classId}">
                                            Edit
                                        </a>

                                        <button type="button"
                                                class="btn btn-sm btn-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal${record.taskId}">
                                            Delete
                                        </button>

                                        <div class="modal fade"
                                            id="deleteModal${record.taskId}"
                                            tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">

                                                    <div class="modal-header bg-light">
                                                        <h5 class="modal-title">Confirm Delete</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <form class="FormDeleteTask">
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete this item ?</p>
                                                            <input type="hidden" name="taskId" value="${record.taskId}">
                                                            <div class="text-end">
                                                                <button class="btn btn-danger BtnDeleteTask">Yes</button>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>`
                            ;
                        });

                        $('#tasksTableBody').html(html);

                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'No Data',
                            text: 'No tasks found'
                        });
                    }
                }

            });
        });

    });
</script>