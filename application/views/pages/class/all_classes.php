<div class="p-4">
    <div class="d-flex justify-content-between mb-3">
        <h4 class="fw-bold">Manage Classes</h4>
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
                                <td><?= $class->head_teacher_name ?></td>
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

                                                <div class="modal-body">
                                                    <form class="FormEditClass" class="row g-3" data-parsley-validate>
                                                        <input type="hidden" name="classId" value="<?= $class->classId ?>">
                                                        <div class="col-12">
                                                            <label class="form-label fw-bold">Class Name</label>
                                                            <input class="form-control" type="text" name="className" value="<?= $class->className ?>" required data-parsley-required-message="Class Name is required">
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label fw-bold">Section Name</label>
                                                            <input class="form-control" type="text" name="sectionName" value="<?= $class->sectionName ?>">
                                                        </div>
                                                    </form>
                                                </div>

                                                <div class="modal-footer bg-light">
                                                    <button class="btn btn-success BtnEditClass">Update</button>
                                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

        $('form').each(function() {
            this.reset();
        });
        $('#FormAddClass').parsley();
        $('.FormEditClass').parsley();
        $('.FormDeleteClass').parsley();

        $(document).on('click', '#BtnAddClass', function(e) {
            e.preventDefault();
            $('#FormAddClass').submit();
        });
        $(document).on('submit', '#FormAddClass', function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= site_url('ClassSections/add_class') ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.status === false) {
                        document.querySelectorAll('.modal').forEach(modalEl => {
                            const modalInstance = bootstrap.Modal.getInstance(modalEl) ||
                                new bootstrap.Modal(modalEl); // in case it's not initialized yet
                            modalInstance.hide();
                        });
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
                        var url = "<?= base_url('Cms/all_classes') ?>";
                        // console.log(url);
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

        $(document).on('click', '.BtnEditClass', function(e) {
            e.preventDefault();
            $(this).closest('form').submit();
        });

        $(document).on('submit', '.FormEditClass', function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= site_url('ClassSections/edit_class') ?>",
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
                        var url = "<?= base_url('Cms/all_classes') ?>";
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

        $(document).on('click', '.BtnDeleteClass', function(e) {
            e.preventDefault();
            $(this).closest('form').submit();
        });

        $(document).on('submit', '.FormDeleteClass', function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= site_url('ClassSections/delete_class') ?>",
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
                        var url = "<?= base_url('Cms/all_classes') ?>";
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

        $('#classSearchForm').off('submit').on('submit', function(e) {
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
                </tr>
            `;

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

                        <!-- DELETE MODAL -->
                        <div class="modal fade" id="deleteModal${classRow.classId}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">

                                    <div class="modal-header bg-light">
                                        <h5 class="modal-title">Confirm Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <form class="FormDeleteClass">
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete this item ?</p>
                                            <input type="hidden" name="classId" value="${classRow.classId}">
                                            <div class="text-end">
                                                <button class="btn btn-danger BtnDeleteClass">Yes</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <!-- EDIT MODAL -->
                        <div class="modal fade" id="editModal${classRow.classId}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">

                                    <div class="modal-header bg-light">
                                        <h5 class="modal-title">Edit Data</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <form class="FormEditClass">
                                            <input type="hidden" name="classId" value="${classRow.classId}">

                                            <div class="mb-2">
                                                <label class="form-label fw-bold">Class Name</label>
                                                <input class="form-control"
                                                    type="text"
                                                    name="className"
                                                    value="${classRow.className}"
                                                    required>
                                            </div>

                                            <div class="mb-2">
                                                <label class="form-label fw-bold">Section Name</label>
                                                <input class="form-control"
                                                    type="text"
                                                    name="sectionName"
                                                    value="${classRow.sectionName}">
                                            </div>
                                        </form>
                                    </div>

                                    <div class="modal-footer bg-light">
                                        <button class="btn btn-success BtnEditClass">Update</button>
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </td>
                </tr>`;
                            });
                        }

                        // ✅ THIS LINE MAKES IT WORK
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
            </tr>
        `);
                    }
                }

            });
        });
    });
</script>