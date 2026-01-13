<div class="p-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Fee Structure Management</h3>
        <button class="btn btn-primary btn-sm">Go Back</button>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs" id="feeTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#structure">Class-wise Fee Structure</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="structure">

            <div class="card">

                <div class="card-body">

                    <form id="FormAddFeeStructure" data-parsley-validate>

                        <div class="row g-3">

                            <div class="col-md-3">
                                <label class="form-label">Education Type</label>
                                <select class="form-select" name="education_type" required data-parsley-required-message="Education Type is required">
                                    <option value="">-- Select --</option>

                                    <?php if (!empty($all_education_type)): ?>
                                        <?php foreach ($all_education_type as $type): ?>
                                            <option value="<?= $type ?>"
                                                <?= (!empty($student->education_type) && $student->education_type == $type) ? 'selected' : '' ?>>
                                                <?= $type ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Class & Section</label>
                                <select class="form-select" name="class_section" required data-parsley-required-message="Class & Section is required">
                                    <option value="">--Select--</option>
                                    <?php if (!empty($all_classes)): ?>
                                        <?php foreach ($all_classes as $type): ?>
                                            <option value="<?= $type->classId ?>"
                                                <?= (!empty($student->classId) && $student->classId == $type->classId) ? 'selected' : '' ?>>
                                                <?= $type->className ?> <?= $type->sectionName ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Fee Category</label>
                                <select class="form-select" name="fee_type" required data-parsley-required-message="Fee category is required">
                                    <option value="">--Select--</option>
                                    <?php if (!empty($feeType)): ?>
                                        <?php foreach ($feeType as $type): ?>
                                            <option value="<?= $type ?>">
                                                <?= $type ?> fee
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Amount (PKR)</label>
                                <input type="number" name="amount" class="form-control" placeholder="e.g. 5000" required data-parsley-required-message="Fee amount is required">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Effective From</label>
                                <input type="date" class="form-control" name="effectiveDate" required data-parsley-required-message="Effective From date is required">
                            </div>

                        </div>

                        <button class="btn btn-primary mt-3" id="BtnAddFeeStructure">Save</button>

                    </form>

                </div>
            </div>

            <!-- Fee Table -->
            <div class="card mt-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">All Fee Structures</h5>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 table-bordered align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Education Type</th>
                                    <th>Fee Type</th>
                                    <th>Class</th>
                                    <th>Amount</th>
                                    <th>Effective From</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // print_r($all_students);
                                // die();
                                foreach ($all_fee_structures as $record) :
                                ?>
                                    <tr>
                                        <td><?= $record->feeStructureId ?></td>
                                        <td><?= $record->education_type ?></td>
                                        <td><?= $record->feeType ?></td>
                                        <td>
                                            <?php
                                            foreach ($all_classes as $type) {
                                                if ($type->classId == $record->classId) {
                                                    echo $type->className . $type->sectionName;
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td><?= $record->amount ?></td>
                                        <td><?= date('d M Y g:i A', strtotime($record->effectiveFrom)) ?></td>
                                        <td>

                                            <button class="btn btn-sm btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $record->feeStructureId ?>">
                                                Delete
                                            </button>

                                            <!-- Delete Confirmation Modal -->
                                            <div class="modal fade" id="deleteModal<?= $record->feeStructureId ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">

                                                        <div class="modal-header bg-light">
                                                            <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <form class="FormDeleteFeeStructure" data-parsley-validate>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to delete this item?</p>
                                                                <input type="hidden" name="feeStructureId" value="<?= $record->feeStructureId ?>">
                                                                <div class="text-end">
                                                                    <button type="submit" class="btn btn-danger BtnDeleteFeeStructure">Yes</button>
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

    </div>

</div>


<script>
    $(document).ready(function() {

        $('form').each(function() {
            this.reset();
        });
        $('#FormAddFeeStructure').parsley();

        $(document).on('click', '#BtnAddFeeStructure', function(e) {
            e.preventDefault();
            $('#FormAddFeeStructure').submit();
        });
        $(document).on('submit', '#FormAddFeeStructure', function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= site_url('Fee/add_fee_structure') ?>",
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
                        var url = "<?= base_url('Cms/fees_structure') ?>";
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


        $(document).on('click', '#BtnDeleteFeeStructure', function(e) {
            e.preventDefault();
            $('#FormDeleteFeeStructure').submit();
        });

        $(document).on('submit', '.FormDeleteFeeStructure', function(e) {
            e.preventDefault();

            let form = $(this);

            $.ajax({
                url: "<?= site_url('Fee/delete_fee_structure') ?>",
                type: "POST",
                data: form.serialize(),
                dataType: "json",
                cache: false,
                success: function(response) {

                    if (response.status === false) {
                        Swal.fire({
                            title: 'Error',
                            text: response.message,
                            icon: 'error',
                        });
                    } else {

                        // Close only current modal
                        form.closest('.modal').modal('hide');

                        Swal.fire({
                            title: 'Success',
                            text: response.message,
                            icon: 'success',
                        });

                        $("#pageContent").load("<?= base_url('Cms/fees_structure') ?>");
                    }
                }
            });
        });


    });
</script>