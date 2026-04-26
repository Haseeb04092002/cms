<style>
    /* ================= MOBILE TABLE ================= */

    @media (max-width: 768px) {

        .table-responsive {
            border: 0;
        }

        /* Hide table header */

        table thead {
            display: none;
        }

        /* Card layout */

        table tbody tr {
            display: block;
            margin: 12px;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        /* Table cells */

        table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 12px;
            border: none;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        /* Remove last border */

        table tbody td:last-child {
            border-bottom: none;
        }

        /* Labels */

        table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #555;
        }

        /* Checkbox row */

        table tbody td:first-child {
            justify-content: flex-start;
        }

        /* Status dropdown */

        .student-status {
            width: 120px;
        }

        /* Bulk bar */

        .p-3.border-bottom {
            flex-direction: column;
        }

    }

    /* ================= SMALL PHONES ================= */

    @media (max-width:480px) {

        table tbody tr {
            margin: 10px 6px;
        }

        table tbody td {
            font-size: 13px;
            padding: 8px 10px;
        }

        .student-status {
            width: 110px;
        }

    }
</style>

<div class="p-4">
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
                                            <option <?= ($record->status === 'pending') ? 'selected' : ''; ?> value="pending">Pending</option>
                                            <option <?= ($record->status === 'approved') ? 'selected' : ''; ?> value="approved">Approved</option>
                                            <option <?= ($record->status === 'rejected') ? 'selected' : ''; ?> value="rejected">Rejected</option>
                                            <option <?= ($record->status === 'cancelled') ? 'selected' : ''; ?> value="cancelled">Cancelled</option>
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

        /* ===============================
           CHECK / UNCHECK ALL
        =============================== */
        $('#checkAll').on('change', function() {
            $('.student-checkbox').prop('checked', this.checked);
        });

        /* ===============================
           BULK CHANGE (AUTO APPLY)
           No Apply Button Needed
        =============================== */
        $('#bulkAttendance').on('change', function() {

            let val = $(this).val();
            if (!val) return;

            $('.student-checkbox:checked').each(function() {
                let row = $(this).closest('tr');
                row.find('.student-status').val(val);
            });
        });

        /* ===============================
           SAVE REQUESTS
        =============================== */
        $('#saveRequests').on('click', function(e) {
            e.preventDefault();

            let rows = [];

            $('.student-checkbox:checked').each(function() {

                let row = $(this).closest('tr');
                let sid = $(this).val();
                let status = row.find('.student-status').val();

                rows.push({
                    studentId: sid,
                    status: status
                });
            });

            if (rows.length === 0) {
                Swal.fire('Warning', 'Please select at least one student', 'warning');
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
                        timer: 2000
                    });

                    if (response.status) {
                        loadPage("<?= base_url('Student/admission_requests') ?>");
                    }
                }
            });

        });

    });
</script>