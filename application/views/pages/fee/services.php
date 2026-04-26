<div class="p-4">
    <div class="card mb-3">
        <div class="card-body">
            <form id="FormSaveService" class="row g-2 mb-3" data-parsley-validate>
                <div class="col-md-5">
                    <input type="text" name="service_name" class="form-control" placeholder="Service (Speech Therapy)" required>
                </div>
                <div class="col-md-3">
                    <select required name="billing_type" class="form-select">
                        <option value="Monthly">Monthly</option>
                        <option value="OneTime">One Time</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" step="0.01" name="default_amount" class="form-control" placeholder="Amount" required>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0 table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Service</th>
                        <th>Billing</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($services)): foreach ($services as $s): ?>
                            <tr>
                                <td><?= (int)$s->serviceId ?></td>
                                <td><?= htmlspecialchars($s->serviceName) ?></td>
                                <td><?= htmlspecialchars($s->billingType) ?></td>
                                <td><?= number_format((float)$s->defaultAmount, 2) ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal<?= $s->serviceId ?>">
                                        Edit
                                    </button>

                                    <button type="button" class="btn btn-sm btn-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteModal<?= $s->serviceId ?>">
                                        Delete
                                    </button>

                                    <!-- DELETE MODAL -->
                                    <div class="modal fade" id="deleteModal<?= $s->serviceId ?>" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">

                                                <div class="modal-header bg-light">
                                                    <h5 class="modal-title">Confirm Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <form class="FormDeleteService">
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete this service?</p>
                                                        <input type="hidden" name="serviceId" value="<?= $s->serviceId ?>">
                                                        <div class="text-end">
                                                            <button type="submit" class="btn btn-danger">Yes</button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- EDIT MODAL -->
                                    <div class="modal fade" id="editModal<?= $s->serviceId ?>" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Service</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <form class="FormEditService">
                                                    <div class="modal-body">

                                                        <input type="hidden" name="serviceId" value="<?= $s->serviceId ?>">

                                                        <div class="mb-3">
                                                            <label class="form-label">Service Name</label>
                                                            <input type="text"
                                                                name="service_name"
                                                                class="form-control"
                                                                required
                                                                value="<?= htmlspecialchars($s->serviceName) ?>">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Billing Type</label>
                                                            <select name="billing_type" class="form-select" required>
                                                                <option value="Monthly" <?= ($s->billingType == 'Monthly') ? 'selected' : '' ?>>Monthly</option>
                                                                <option value="OneTime" <?= ($s->billingType == 'OneTime') ? 'selected' : '' ?>>One Time</option>
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Default Amount</label>
                                                            <input type="number"
                                                                step="0.01"
                                                                name="default_amount"
                                                                class="form-control"
                                                                required
                                                                value="<?= $s->defaultAmount ?>">
                                                        </div>

                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            Cancel
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">
                                                            Save
                                                        </button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                    <?php endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script>
    $('#FormSaveService').parsley();

    $(document).off('submit', '#FormSaveService').on('submit', '#FormSaveService', function(e) {
        e.preventDefault();
        let form = $(this);

        $.ajax({
            url: "<?= site_url('Fee/save_service') ?>",
            type: "POST",
            data: form.serialize(),
            dataType: "json",
            success: function(res) {

                if (res.status) {
                    Swal.fire('Success', res.message, 'success');
                    $("#pageContent").load("<?= base_url('Fee/services') ?>");
                } else {
                    Swal.fire('Error', res.message, 'error');
                }

            }
        });
    });


    $(document).off('submit', '.FormEditService').on('submit', '.FormEditService', function(e) {
        e.preventDefault();
        let form = $(this);

        $.ajax({
            url: "<?= site_url('Fee/edit_service') ?>",
            type: "POST",
            data: form.serialize(),
            dataType: "json",
            success: function(response) {

                closeAllModals();

                if (response.status) {
                    Swal.fire('Success', response.message, 'success');
                    $("#pageContent").load("<?= base_url('Fee/services') ?>");
                } else {
                    Swal.fire('Error', response.message, 'error');
                }

            }
        });
    });


    $(document).off('submit', '.FormDeleteService').on('submit', '.FormDeleteService', function(e) {
        e.preventDefault();
        let form = $(this);

        $.ajax({
            url: "<?= site_url('Fee/delete_service') ?>",
            type: "POST",
            data: form.serialize(),
            dataType: "json",
            success: function(response) {

                closeAllModals();

                if (response.status) {
                    Swal.fire('Success', response.message, 'success');
                    $("#pageContent").load("<?= base_url('Fee/services') ?>");
                } else {
                    Swal.fire('Error', response.message, 'error');
                }

            }
        });
    });


    function closeAllModals() {
        document.querySelectorAll('.modal').forEach(function(modalEl) {
            let modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
        });
    }
</script>