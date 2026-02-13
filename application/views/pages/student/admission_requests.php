<div class="p-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3s">
        <h3 class="fw-bold">Admission Requests</h3>
    </div>


    <div class="card">
        <div class="card-body p-0">
            <!-- ===== BULK ACTION BAR ===== -->
            <div class="p-3 border-bottom bg-light">
                <div class="d-flex flex-wrap gap-3 align-items-end">

                    <!-- Bulk Attendance -->
                    <div>
                        <label class="form-label mb-1">Bulk Action</label>
                        <select id="bulkAttendance" class="form-select form-select-sm w-auto">
                            <option value="">-- Select --</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>

                    <!-- Apply Button -->
                    <div>
                        <label class="form-label mb-1 d-block">&nbsp;</label>
                        <button type="button" id="applyBulk" class="btn btn-sm btn-primary">
                            Apply
                        </button>
                    </div>

                    <!-- Right Side -->
                    <div class="ms-auto d-flex gap-3 align-items-end">

                        <!-- Save Button -->
                        <div>
                            <label class="form-label mb-1 d-block">&nbsp;</label>
                            <button
                                type="button"
                                class="btn btn-sm btn-success"
                                id="saveRequests">
                                Save
                            </button>
                        </div>

                    </div>

                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover mb-0 table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th width="40">
                                <input type="checkbox" id="checkAll" class="form-check-input fs-5" checked>
                            </th>
                            <th>Admission No</th>
                            <th>Education Type</th>
                            <th>Class</th>
                            <th>Name</th>
                            <th>Last School</th>
                            <th>Guardian</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="studentTableBody">
                        <?php
                        foreach ($all_students as $record) :
                        ?>
                            <tr>
                                <td>
                                    <input type="checkbox" class="form-check-input fs-4 student-checkbox" name="checkStudent[]" checked value="<?= $record->studentId ?>">
                                </td>
                                <td><?= $record->admissionNo ?></td>
                                <td><?= $record->student_education_type ?></td>
                                <td><?= $record->className ?></td>
                                <td><?= $record->firstName ?> <?= $record->lastName ?></td>
                                <td><?= $record->prev_school ?></td>
                                <td>
                                    <?php
                                    if (isset($record->fatherName) && !empty($record->fatherName)) {
                                        echo $record->fatherName ?? '';
                                    } elseif (isset($record->motherName) && !empty($record->motherName)) {
                                        echo $record->motherName ?? '';
                                    } elseif (isset($record->guardianName) && !empty($record->guardianName)) {
                                        echo $record->guardianName ?? '';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (isset($record->contactNo) && !empty($record->contactNo)) {
                                        echo $record->contactNo ?? '';
                                    } elseif (isset($record->contactNo2) && !empty($record->contactNo2)) {
                                        echo $record->contactNo2 ?? '';
                                    }
                                    ?>
                                </td>
                                <td><?= $record->address ?? '' ?></td>
                                <td>
                                    <div>
                                        <select class="form-select form-select-sm w-auto student-status">
                                        <!-- <select id="bulkAttendance" class="form-select form-select-sm w-auto"> -->
                                            <option value="">-- Select --</option>
                                            <option <?= ($record->status === 'pending')?'selected':''; ?> value="pending">Pending</option>
                                            <option <?= ($record->status === 'approved')?'selected':''; ?> value="approved">Approved</option>
                                            <option <?= ($record->status === 'rejected')?'selected':''; ?> value="rejected">Rejected</option>
                                            <option <?= ($record->status === 'cancelled')?'selected':''; ?> value="cancelled">Cancelled</option>
                                        </select>
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

        // ===== Check / Uncheck All =====
        $('#checkAll').on('change', function() {
            $('.student-checkbox').prop('checked', this.checked);
        });

        // ===== Bulk Apply =====
        $('#applyBulk').on('click', function() {

            let val = $('#bulkAttendance').val();
            if (!val) return;

            $('.student-checkbox:checked').each(function() {

                let row = $(this).closest('tr');
                row.find('input[type="radio"][value="' + val + '"]').prop('checked', true);
            });
        });

        // ===== SAVE ATTENDANCE =====
        $('#saveRequests').on('click', function(e) {
            e.preventDefault();

            let rows = [];

            $('.student-checkbox:checked').each(function() {

                let row = $(this).closest('tr');
                let sid = $(this).val();
                let status = row.find('.student-status').val() || 'pending';

                rows.push({
                    studentId: sid,
                    status: status
                });
            });

            if (rows.length === 0) {
                Swal.fire('Warning', 'No students selected', 'warning');
                return;
            }

            $.ajax({
                url: "<?= site_url('Student/updated_admission_requests') ?>",
                type: "POST",
                dataType: "json",
                data: {
                    rows: JSON.stringify(rows)
                },
                success: function(response) {

                    Swal.fire({
                        title: response.status ? 'Success' : 'Error',
                        text: response.message,
                        icon: response.status ? 'success' : 'error',
                        timer: 3000
                    });

                    if (response.status) {
                        $("#pageContent").load("<?= base_url('Student/admission_requests') ?>");
                    }
                }
            });
        });

    });
</script>