<div class="p-4">
    <div class="d-flex justify-content-between mb-3">
        <h4 class="fw-bold">Manage Subjects</h4>
        <div>
            <button class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#AddSubject">Add New Subject</button>
            <!-- Add Subject Modal -->
            <div class="modal fade" id="AddSubject" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Add Subject</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <form id="FormAddSubject" data-parsley-validate>
                            <div class="modal-body">

                                <div class="row g-3">

                                    <!-- Subject Name -->
                                    <div class="col-md-6">
                                        <label class="form-label">Subject Name</label>
                                        <input type="text" name="subjectName" class="form-control"
                                            required
                                            data-parsley-required-message="Subject name is required">
                                    </div>

                                    <!-- Subject Code -->
                                    <div class="col-md-6">
                                        <label class="form-label">Subject Code</label>
                                        <input type="text" name="subjectCode" class="form-control"
                                            required
                                            data-parsley-required-message="Subject code is required">
                                    </div>

                                    <!-- Description -->
                                    <div class="col-md-12">
                                        <label class="form-label">Description</label>
                                        <input type="text" name="description" class="form-control"
                                            required
                                            data-parsley-required-message="Description is required">
                                    </div>

                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="submit" class="btn btn-success" id="BtnAddSubject">
                                    Save Subject
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label">Search</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Subject ID</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_subjects as $subject) : ?>
                            <tr>
                                <td><?= $subject->subjectId ?></td>
                                <td><?= $subject->subjectName ?></td>
                                <td><?= $subject->subjectCode ?></td>
                                <td><?= $subject->description ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $subject->subjectId ?>">
                                        Edit
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $subject->subjectId ?>">
                                        Delete
                                    </button>

                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="deleteModal<?= $subject->subjectId ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">

                                                <div class="modal-header bg-light">
                                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <form class="FormDeleteSubject" data-parsley-validate>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete this item ?</p>
                                                        <input type="hidden" name="subjectId" value="<?= $subject->subjectId ?>">
                                                        <div class="text-end">
                                                            <button class="btn btn-danger BtnDeleteSubject">Yes</button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Edit Form Modal -->
                                    <div class="modal fade" id="editModal<?= $subject->subjectId ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Subject</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <form class="FormEditSubject" data-parsley-validate>
                                                    <input type="hidden" name="subjectId" value="<?= $subject->subjectId ?>">

                                                    <div class="modal-body">

                                                        <div class="row g-3">

                                                            <!-- Subject Name -->
                                                            <div class="col-md-6">
                                                                <label class="form-label">Subject Name</label>
                                                                <input type="text" name="subjectName" class="form-control"
                                                                    value="<?= $subject->subjectName ?>" required>
                                                            </div>

                                                            <!-- Subject Code -->
                                                            <div class="col-md-6">
                                                                <label class="form-label">Subject Code</label>
                                                                <input type="text" name="subjectCode" class="form-control"
                                                                    value="<?= $subject->subjectCode ?>" required>
                                                            </div>

                                                            <!-- Description -->
                                                            <div class="col-md-12">
                                                                <label class="form-label">Description</label>
                                                                <input type="text" name="description" class="form-control"
                                                                    value="<?= $subject->description ?>" required>
                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            Cancel
                                                        </button>
                                                        <button type="submit" class="btn btn-success BtnEditSubject">
                                                            Save Subject
                                                        </button>
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

        $('form').each(function() {
            this.reset();
        });
        $('#FormAddsubject').parsley();
        $('.FormEditsubject').parsley();
        $('.FormDeletesubject').parsley();

        $(document).on('click', '#BtnAddSubject', function(e) {
            e.preventDefault();
            $('#FormAddSubject').submit();
        });
        $(document).on('submit', '#FormAddSubject', function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= site_url('Subject/add_subject') ?>",
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
                        var url = "<?= base_url('Subject/all_subjects') ?>";
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

        $(document).on('click', '.BtnEditSubject', function(e) {
            e.preventDefault();
            $(this).closest('form').submit();
        });

        $(document).on('submit', '.FormEditSubject', function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= site_url('Subject/edit_subject') ?>",
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
                        var url = "<?= base_url('Subject/all_subjects') ?>";
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

        $(document).on('click', '.BtnDeleteSubject', function(e) {
            e.preventDefault();
            $(this).closest('form').submit();
        });

        $(document).on('submit', '.FormDeleteSubject', function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= site_url('Subject/delete_subject') ?>",
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
                        var url = "<?= base_url('Subject/all_subjects') ?>";
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