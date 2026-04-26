<div class="p-4">
    <div class="d-flex justify-content-between mb-3">
        <div>
            <button class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#AddSubject">Add New Subject</button>
            <!-- Add Subject Modal -->
            <div class="modal fade" id="AddSubject" tabindex="-1">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content shadow">

                        <form id="FormAddSubject" data-parsley-validate>

                            <div class="modal-header bg-light">
                                <h5 class="modal-title fw-bold">Add Subject</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">

                                <!-- Subject Name -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Subject Name</label>
                                    <input type="text"
                                        name="subjectName"
                                        class="form-control"
                                        required
                                        data-parsley-pattern="^[a-zA-Z\s]+$"
                                        data-parsley-pattern-message="Only alphabets allowed">
                                </div>

                                <!-- Subject Code (Optional) -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Subject Code</label>
                                    <input type="text"
                                        name="subjectCode"
                                        class="form-control">
                                </div>

                                <!-- Description (Optional) -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Description</label>
                                    <input type="text"
                                        name="description"
                                        class="form-control">
                                </div>

                            </div>

                            <div class="modal-footer bg-light">
                                <button type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="btn btn-success">
                                    Save Subject
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="card mb-3 border-dark">
        <form id="subjectSearchForm">
            <div class="card-header p-1 ps-2">
                <h6 class="mb-0">Search Subjects</h6>
            </div>
            <div class="card-body p-3">
                <div class="row g-2 align-items-end">

                    <div class="col-md-3">
                        <label class="form-label mb-1">Subject Name</label>
                        <input type="text"
                            name="subjectName"
                            class="form-control form-control-sm">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label mb-1">Subject Code</label>
                        <input type="text"
                            name="subjectCode"
                            class="form-control form-control-sm">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label mb-1">Subject Description</label>
                        <input type="text"
                            name="description"
                            class="form-control form-control-sm">
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
                            <th>Subject ID</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="subjectTableBody">
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

                                    <div class="modal fade" id="editModal<?= $subject->subjectId ?>" tabindex="-1">
                                        <div class="modal-dialog modal-md modal-dialog-centered">
                                            <div class="modal-content shadow">

                                                <form class="FormEditSubject" data-parsley-validate>

                                                    <div class="modal-header bg-light">
                                                        <h5 class="modal-title fw-bold">Edit Subject</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <input type="hidden"
                                                        name="subjectId"
                                                        value="<?= $subject->subjectId ?>">

                                                    <div class="modal-body">

                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Subject Name</label>
                                                            <input type="text"
                                                                name="subjectName"
                                                                class="form-control"
                                                                value="<?= $subject->subjectName ?>"
                                                                required
                                                                data-parsley-pattern="^[a-zA-Z\s]+$"
                                                                data-parsley-pattern-message="Only alphabets allowed">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Subject Code</label>
                                                            <input type="text"
                                                                name="subjectCode"
                                                                class="form-control"
                                                                value="<?= $subject->subjectCode ?>">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Description</label>
                                                            <input type="text"
                                                                name="description"
                                                                class="form-control"
                                                                value="<?= $subject->description ?>">
                                                        </div>

                                                    </div>

                                                    <div class="modal-footer bg-light">
                                                        <button type="button"
                                                            class="btn btn-secondary"
                                                            data-bs-dismiss="modal">
                                                            Cancel
                                                        </button>
                                                        <button type="submit"
                                                            class="btn btn-success">
                                                            Save Changes
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

        /* =========================
           INIT PARSLEY
        ========================= */
        $('#FormAddSubject').parsley();
        $('.FormEditSubject').parsley();
        $('.FormDeleteSubject').parsley();


        /* =========================
           ADD SUBJECT
        ========================= */
        $(document).off('submit', '#FormAddSubject').on('submit', '#FormAddSubject', function(e) {

            e.preventDefault();
            let form = $(this);

            if (!form.parsley().isValid()) return;

            $.ajax({
                url: "<?= site_url('Subject/add_subject') ?>",
                type: "POST",
                data: form.serialize(),
                dataType: "json",
                success: function(response) {

                    handleResponse(response, form);

                }
            });
        });


        /* =========================
           EDIT SUBJECT
        ========================= */
        $(document).off('submit', '.FormEditSubject').on('submit', '.FormEditSubject', function(e) {

            e.preventDefault();
            let form = $(this);

            if (!form.parsley().isValid()) return;

            $.ajax({
                url: "<?= site_url('Subject/edit_subject') ?>",
                type: "POST",
                data: form.serialize(),
                dataType: "json",
                success: function(response) {

                    handleResponse(response);

                }
            });
        });


        /* =========================
           DELETE SUBJECT
        ========================= */
        $(document).off('submit', '.FormDeleteSubject').on('submit', '.FormDeleteSubject', function(e) {

            e.preventDefault();
            let form = $(this);

            $.ajax({
                url: "<?= site_url('Subject/delete_subject') ?>",
                type: "POST",
                data: form.serialize(),
                dataType: "json",
                success: function(response) {

                    handleResponse(response);

                }
            });
        });


        /* =========================
           COMMON HANDLER
        ========================= */
        function handleResponse(response, form = null) {

            closeAllModals();

            if (!response.status) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message,
                    timer: 2500
                });
                return;
            }

            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: response.message,
                timer: 2000,
                showConfirmButton: false
            });

            if (form) {
                form[0].reset();
                form.parsley().reset();
            }

            reloadPage();
        }

        function reloadPage() {
            $("#pageContent").load("<?= base_url('Subject/all_subjects') ?>");
        }

        function closeAllModals() {
            document.querySelectorAll('.modal').forEach(modalEl => {
                let modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
            });
        }

    });
</script>