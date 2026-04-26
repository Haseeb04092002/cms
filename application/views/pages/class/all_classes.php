<div class="p-4">
    <div class="d-flex justify-content-between mb-3">
        <div>
            <button class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#AddClass">Add New Class</button>
            <!-- Add Class Modal -->
            <div class="modal fade" id="AddClass" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-light">
                            <h5 class="modal-title">Add Class</h5><button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="FormAddClass" class="row g-3" data-parsley-validate>
                                <div class="col-12">
                                    <label class="form-label">Class Name</label>
                                    <input class="form-control" type="text" name="className" required data-parsley-required-message="Class Name is required">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Section Name</label>
                                    <input class="form-control" type="text" name="sectionName">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-light">
                            <button class="btn btn-success" id="BtnAddClass">Save</button>
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3 border-dark">
        <form id="classSearchForm">
            <div class="card-header p-1 ps-2">
                <h6 class="mb-0">Search Classes</h6>
            </div>
            <div class="card-body p-3">
                <div class="row g-2 align-items-end">

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
                <table class="table table-hover mb-0 table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Class ID</th>
                            <th>Class Name</th>
                            <th>Section Name</th>
                            <th>Total Students</th>
                            <th>Head Teacher</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="classTableBody">
                        <?php foreach ($all_classes as $class) : ?>
                            <tr>
                                <td><?= $class->classId ?></td>
                                <td><?= $class->className ?></td>
                                <td><?= $class->sectionName ?></td>
                                <td><?= $class->total_students ?></td>
                                <td>

                                    <?php if (!empty($class->head_teacher_name)): ?>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span><?= $class->head_teacher_name ?></span>
                                            <button
                                                class="btn btn-sm btn-warning ms-2"
                                                data-bs-toggle="modal"
                                                data-bs-target="#assignModal<?= $class->classId ?>">
                                                Change
                                            </button>
                                        </div>
                                    <?php else: ?>
                                        <button
                                            class="btn btn-sm btn-success"
                                            data-bs-toggle="modal"
                                            data-bs-target="#assignModal<?= $class->classId ?>">
                                            Assign
                                        </button>
                                    <?php endif; ?>

                                    <!-- Assign / Change Head Teacher Modal -->
                                    <div class="modal fade" id="assignModal<?= $class->classId ?>" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">

                                                <div class="modal-header bg-light">
                                                    <h5 class="modal-title">
                                                        <?= !empty($class->head_teacher_name) ? 'Change Head Teacher' : 'Assign Head Teacher' ?>
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <form class="FormAssignTeacher">
                                                    <div class="modal-body">

                                                        <input type="hidden" name="classId" value="<?= $class->classId ?>">

                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Select Teacher</label>
                                                            <select name="headClassId" class="form-select" required>
                                                                <option value="">-- Select Teacher --</option>

                                                                <?php foreach ($teachers as $teacher): ?>
                                                                    <option value="<?= $teacher->staffId ?>"
                                                                        <?= ($teacher->staffId == $class->head_teacher_id) ? 'selected' : '' ?>>
                                                                        <?= $teacher->firstName . ' ' . $teacher->lastName ?>
                                                                        (<?= $teacher->designation ?>)
                                                                    </option>
                                                                <?php endforeach; ?>

                                                            </select>
                                                        </div>

                                                    </div>

                                                    <div class="modal-footer bg-light">
                                                        <button type="submit" class="btn btn-primary">
                                                            Save
                                                        </button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                </td>

                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $class->classId ?>">
                                        Edit
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $class->classId ?>">
                                        Delete
                                    </button>

                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="deleteModal<?= $class->classId ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">

                                                <div class="modal-header bg-light">
                                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <form class="FormDeleteClass" data-parsley-validate>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete this item ?</p>
                                                        <input type="hidden" name="classId" value="<?= $class->classId ?>">
                                                        <div class="text-end">
                                                            <button class="btn btn-danger BtnDeleteClass">Yes</button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Edit Form Modal -->
                                    <div class="modal fade" id="editModal<?= $class->classId ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $class->classId ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">

                                                <div class="modal-header bg-light">
                                                    <h5 class="modal-title" id="editModalLabel<?= $class->classId ?>">Edit Data</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <form class="FormEditClass" data-parsley-validate>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="classId" value="<?= $class->classId ?>">
                                                        <div class="col-12">
                                                            <label class="form-label fw-bold">Class Name</label>
                                                            <input class="form-control" type="text" name="className" value="<?= $class->className ?>" required data-parsley-required-message="Class Name is required">
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label fw-bold">Section Name</label>
                                                            <input class="form-control" type="text" name="sectionName" value="<?= $class->sectionName ?>">
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer bg-light">
                                                        <button class="btn btn-success BtnEditClass">Update</button>
                                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

        /* =====================================
           INIT PARSLEY (SAFE)
        ===================================== */
        $('#FormAddClass').parsley();
        $('.FormEditClass').parsley();
        $('.FormDeleteClass').parsley();


        /* =====================================
           ADD CLASS
        ===================================== */

        $(document).off('click', '#BtnAddClass').on('click', '#BtnAddClass', function(e) {
            e.preventDefault();
            $('#FormAddClass').submit();
        });

        $(document).off('submit', '#FormAddClass').on('submit', '#FormAddClass', function(e) {
            e.preventDefault();

            let form = $(this);

            $.ajax({
                url: "<?= site_url('Classes/add_class') ?>",
                type: "POST",
                data: form.serialize(),
                dataType: "json",
                cache: false,
                success: function(response) {

                    handleResponse(response);

                }
            });
        });


        /* =====================================
           EDIT CLASS
        ===================================== */

        $(document).off('click', '.BtnEditClass').on('click', '.BtnEditClass', function(e) {
            e.preventDefault();
            $(this).closest('form').submit();
        });

        $(document).off('submit', '.FormEditClass').on('submit', '.FormEditClass', function(e) {
            e.preventDefault();

            let form = $(this);

            $.ajax({
                url: "<?= site_url('Classes/edit_class') ?>",
                type: "POST",
                data: form.serialize(),
                dataType: "json",
                cache: false,
                success: function(response) {

                    handleResponse(response);

                }
            });
        });


        /* =====================================
           DELETE CLASS
        ===================================== */

        $(document).off('click', '.BtnDeleteClass').on('click', '.BtnDeleteClass', function(e) {
            e.preventDefault();
            $(this).closest('form').submit();
        });

        $(document).off('submit', '.FormDeleteClass').on('submit', '.FormDeleteClass', function(e) {
            e.preventDefault();

            let form = $(this);

            $.ajax({
                url: "<?= site_url('Classes/delete_class') ?>",
                type: "POST",
                data: form.serialize(),
                dataType: "json",
                cache: false,
                success: function(response) {

                    handleResponse(response);

                }
            });
        });


        /* =====================================
           ASSIGN HEAD TEACHER
        ===================================== */

        $(document).off('submit', '.FormAssignTeacher').on('submit', '.FormAssignTeacher', function(e) {
            e.preventDefault();

            let form = $(this);

            $.ajax({
                url: "<?= site_url('Classes/assign_head_teacher') ?>",
                type: "POST",
                data: form.serialize(),
                dataType: "json",
                success: function(response) {

                    if (response.status) {

                        closeAllModals();

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            timer: 2000
                        });

                        reloadPage();

                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                }
            });
        });


        /* =====================================
           SEARCH CLASS
        ===================================== */

        $(document).off('submit', '#classSearchForm').on('submit', '#classSearchForm', function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            Swal.fire({
                title: 'Searching...',
                text: 'Please wait',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: "<?= site_url('Classes/find_class') ?>",
                type: "POST",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(res) {

                    Swal.close();

                    if (res.status === true) {

                        let html = '';

                        if (res.data.length === 0) {
                            html = `
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                No classes found
                            </td>
                        </tr>`;
                        } else {

                            $.each(res.data, function(i, classRow) {

                                html += `
                            <tr>
                                <td>${classRow.classId}</td>
                                <td>${classRow.className}</td>
                                <td>${classRow.sectionName}</td>
                                <td>${classRow.total_students}</td>
                                <td>${classRow.head_teacher_name ?? ''}</td>
                                <td>
                                    <button type="button"
                                        class="btn btn-sm btn-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal${classRow.classId}">
                                        Edit
                                    </button>

                                    <button type="button"
                                        class="btn btn-sm btn-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteModal${classRow.classId}">
                                        Delete
                                    </button>
                                </td>
                            </tr>`;
                            });
                        }

                        $('#classTableBody').html(html);

                    } else {

                        Swal.fire({
                            icon: 'warning',
                            title: 'No Data',
                            text: 'No classes found'
                        });

                        $('#classTableBody').html(`
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                No classes found
                            </td>
                        </tr>`);
                    }
                }
            });
        });


        /* =====================================
           COMMON FUNCTIONS
        ===================================== */

        function handleResponse(response) {

            if (response.status === false) {

                closeAllModals();

                Swal.fire({
                    title: 'Error',
                    text: response.message,
                    icon: 'error',
                    timer: 3000
                });

            } else {

                closeAllModals();

                Swal.fire({
                    title: 'Success',
                    text: response.message,
                    icon: 'success',
                    timer: 2000
                });

                reloadPage();
            }
        }

        function reloadPage() {
            $("#pageContent").load("<?= base_url('Classes/all_classes') ?>");
        }

        function closeAllModals() {
            document.querySelectorAll('.modal').forEach(modalEl => {
                let modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
            });
        }

    });
</script>