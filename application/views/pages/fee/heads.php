<div class="p-4">
    <div class="card">
        <div class="card-body pb-0">
            <div class="d-flex justify-content-between mb-3">

                <button class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#AddFeeHeadModal">
                    <i class="bi bi-plus-circle"></i> Add Fee Head
                </button>
                <div class="modal fade" id="AddFeeHeadModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Add Fee Head</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <form id="FormAddFeeHead" data-parsley-validate>
                                <div class="modal-body">

                                    <div class="mb-3">
                                        <label class="form-label">Head Name</label>
                                        <input type="text"
                                            name="headName"
                                            class="form-control"
                                            required
                                            data-parsley-required-message="Head name is required">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Head Type</label>
                                        <select name="headType"
                                            class="form-select"
                                            required>
                                            <option value="Monthly">Monthly</option>
                                            <option value="OneTime">One Time</option>
                                        </select>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button"
                                        class="btn btn-secondary"
                                        data-bs-dismiss="modal">
                                        Cancel
                                    </button>

                                    <button type="submit"
                                        class="btn btn-primary"
                                        id="BtnAddFeeHead">
                                        Save
                                    </button>
                                </div>
                            </form>

                        </div>
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
                            <th>#</th>
                            <th>Head</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($heads as $h): ?>
                            <tr>
                                <td><?= (int)$h->feeHeadId ?></td>
                                <td><?= htmlspecialchars($h->headName) ?></td>
                                <td><?= htmlspecialchars($h->headType) ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $h->feeHeadId ?? '' ?>">
                                        Edit
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $h->feeHeadId ?? '' ?>">
                                        Delete
                                    </button>

                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="deleteModal<?= $h->feeHeadId ?? '' ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">

                                                <div class="modal-header bg-light">
                                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <form class="FormDeleteFeeHead" data-parsley-validate>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete this item ?</p>
                                                        <input type="hidden" name="feeHeadId" value="<?= $h->feeHeadId ?? '' ?>">
                                                        <div class="text-end">
                                                            <button type="submit" class="btn btn-danger BtnDeleteClass">Yes</button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Edit Form Modal -->
                                    <div class="modal fade" id="editModal<?= $h->feeHeadId ?? '' ?>" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Fee Head</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <form class="FormEditFeeHead" data-parsley-validate>
                                                    <div class="modal-body">

                                                        <input type="hidden" name="feeHeadId" value="<?= $h->feeHeadId ?? '' ?>">

                                                        <div class="mb-3">
                                                            <label class="form-label">Head Name</label>
                                                            <input type="text"
                                                                name="headName"
                                                                class="form-control"
                                                                required
                                                                value="<?= htmlspecialchars($h->headName) ?>"
                                                                data-parsley-required-message="Head name is required">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Head Type</label>
                                                            <select name="headType"
                                                                class="form-select"
                                                                required>
                                                                <option <?= ($h->headType === 'Monthly') ? 'selected' : '' ?> value="Monthly">Monthly</option>
                                                                <option <?= ($h->headType === 'OneTime') ? 'selected' : '' ?> value="OneTime">One Time</option>
                                                            </select>
                                                        </div>

                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button"
                                                            class="btn btn-secondary"
                                                            data-bs-dismiss="modal">
                                                            Cancel
                                                        </button>

                                                        <button type="submit"
                                                            class="btn btn-primary"
                                                            class="BtnEditFeeHead">
                                                            Save
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

        $('#FormAddFeeHead').parsley();


        $(document).off('click', '#BtnAddFeeHead').on('click', '#BtnAddFeeHead', function(e) {
            e.preventDefault();
            $('#FormAddFeeHead').submit();
        });


        $(document).off('submit', '#FormAddFeeHead').on('submit', '#FormAddFeeHead', function(e) {

            e.preventDefault();

            let form = $(this);

            $.ajax({
                url: "<?= site_url('Fee/add_head') ?>",
                type: "POST",
                data: form.serialize(),
                dataType: "json",
                cache: false,
                success: function(response) {

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

                        $("#pageContent").load("<?= base_url('Fee/heads') ?>");
                    }

                }
            });
        });


        $(document).off('click', '.BtnEditFeeHead').on('click', '.BtnEditFeeHead', function(e) {
            e.preventDefault();
            $('.FormEditFeeHead').submit();
        });


        $(document).off('submit', '.FormEditFeeHead').on('submit', '.FormEditFeeHead', function(e) {

            e.preventDefault();

            let form = $(this);

            $.ajax({
                url: "<?= site_url('Fee/edit_head') ?>",
                type: "POST",
                data: form.serialize(),
                dataType: "json",
                cache: false,
                success: function(response) {

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

                        $("#pageContent").load("<?= base_url('Fee/heads') ?>");
                    }

                }
            });
        });


        $(document).off('submit', '.FormDeleteFeeHead').on('submit', '.FormDeleteFeeHead', function(e) {

            e.preventDefault();

            let form = $(this);

            $.ajax({
                url: "<?= site_url('Fee/delete_head') ?>",
                type: "POST",
                data: form.serialize(),
                dataType: "json",
                cache: false,
                success: function(response) {

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

                        $("#pageContent").load("<?= base_url('Fee/heads') ?>");
                    }

                }
            });
        });


        function closeAllModals() {
            document.querySelectorAll('.modal').forEach(modalEl => {
                let modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
            });
        }

    });
</script>