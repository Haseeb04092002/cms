<div class="p-4">
    <div class="card mb-3">
        <div class="card-body">
            <form id="FormAddDiscount" class="row g-2">
                <div class="col-md-4">
                    <label class="form-label">Discount Name</label>
                    <input type="text" name="discount_name" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Type</label>
                    <select name="discount_type" class="form-select">
                        <option value="Fixed">Fixed</option>
                        <option value="Percent">Percent</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Value</label>
                    <input type="number" step="0.01" name="value" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label></label>
                    <button class="btn btn-primary w-100 mt-2" id="BtnAddDiscount">Save</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Value</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($discounts as $d): ?>
                            <tr>
                                <td>
                                    <?= $d->discountName ?>
                                </td>
                                <td>
                                    <?= $d->discountType ?>
                                </td>
                                <td>
                                    <?= $d->discountValue ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $d->discountId ?>">Edit</button>
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $d->discountId ?>">Delete</button>
                                    <div class="modal fade" id="editModal<?= $d->discountId ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form class="FormEditDiscount">
                                                    <div class="modal-body">

                                                        <input type="hidden" name="discountId" value="<?= $d->discountId ?>">

                                                        <div class="mb-3">
                                                            <label>Name</label>
                                                            <input type="text" name="discount_name" class="form-control" value="<?= $d->discountName ?>" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label>Type</label>
                                                            <select name="discount_type" class="form-select">
                                                                <option <?= ($d->discountType == 'Fixed') ? 'selected' : '' ?> value="Fixed">Fixed</option>
                                                                <option <?= ($d->discountType == 'Percent') ? 'selected' : '' ?> value="Percent">Percent</option>
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label>Value</label>
                                                            <input type="number" step="0.01" name="value" class="form-control" value="<?= $d->discountValue ?>" required>
                                                        </div>

                                                        <button class="btn btn-primary">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="deleteModal<?= $d->discountId ?? '' ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">

                                                <div class="modal-header bg-light">
                                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <form class="FormDeleteDiscount" data-parsley-validate>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete this item ?</p>
                                                        <input type="hidden" name="discountId" value="<?= $d->discountId ?? '' ?>">
                                                        <div class="text-end">
                                                            <button class="btn btn-danger BtnDeleteClass">Yes</button>
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


    <script>
        $(document).ready(function() {

            /* ==============================
               ADD DISCOUNT
            ============================== */

            $('#FormAddDiscount').parsley();

            $(document).off('click', '#BtnAddDiscount')
                .on('click', '#BtnAddDiscount', function(e) {
                    e.preventDefault();
                    $('#FormAddDiscount').submit();
                });

            $(document).off('submit', '#FormAddDiscount')
                .on('submit', '#FormAddDiscount', function(e) {

                    e.preventDefault();

                    let form = $(this);

                    $.ajax({
                        url: "<?= site_url('Fee/add_discount') ?>",
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

                                $("#pageContent").load("<?= base_url('Fee/discounts') ?>");
                            }
                        }
                    });
                });


            /* ==============================
               EDIT DISCOUNT
            ============================== */

            $('.FormEditDiscount').parsley();

            $(document).off('submit', '.FormEditDiscount')
                .on('submit', '.FormEditDiscount', function(e) {

                    e.preventDefault();

                    let form = $(this);

                    $.ajax({
                        url: "<?= site_url('Fee/edit_discount') ?>",
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

                                $("#pageContent").load("<?= base_url('Fee/discounts') ?>");
                            }
                        }
                    });
                });


            /* ==============================
               DELETE DISCOUNT
            ============================== */

            $(document).off('submit', '.FormDeleteDiscount')
                .on('submit', '.FormDeleteDiscount', function(e) {

                    e.preventDefault();

                    let form = $(this);

                    $.ajax({
                        url: "<?= site_url('Fee/delete_discount') ?>",
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

                                $("#pageContent").load("<?= base_url('Fee/discounts') ?>");
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