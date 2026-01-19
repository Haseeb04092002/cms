<div class="p-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">All Tasks</h3>
    </div>

    <!-- Search Student Card -->
    <div class="card mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">Search Task</h5>
        </div>
        <div class="card-body">
            <form id="FindStudentForm" data-parsley-validate>
                <div class="row g-3">

                    <div class="col-md-10">
                        <input type="text" class="form-control"
                            placeholder="Enter Task title, ID, or keywords"
                            name="searchQuery"
                            id="searchQuery"
                            required>
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
                    <tbody id="studentTableBody">
                        <?php
                        // echo "<br>";
                        // echo "<pre>";
                        // print_r($all_students);
                        // die();
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

    });
</script>