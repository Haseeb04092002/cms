<style>
    .attendance-group {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .att-btn {
        padding: 5px 10px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        border: 2px solid #dee2e6;
        background: #f8f9fa;
        transition: 0.25s ease;
    }

    /* Hover */
    .att-btn:hover {
        transform: translateY(-2px);
    }

    /* Checked state */
    .btn-check:checked+.att-btn {
        color: #fff;
        border-color: transparent;
    }

    /* Colors */
    .present {
        border-color: #198754;
    }

    .btn-check:checked+.present {
        background: #198754;
    }

    .absent {
        border-color: #dc3545;
    }

    .btn-check:checked+.absent {
        background: #dc3545;
    }

    .late {
        border-color: #fd7e14;
    }

    .btn-check:checked+.late {
        background: #fd7e14;
    }

    .leave {
        border-color: #0d6efd;
    }

    .btn-check:checked+.leave {
        background: #0d6efd;
    }

    .sleave {
        border-color: #6c757d;
    }

    .btn-check:checked+.sleave {
        background: #6c757d;
    }
</style>

<div class="p-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3s">
        <h3 class="fw-bold">Student Attendance (<?= $className ?> <?= $sectionName ?> )</h3>
    </div>


    <div class="card">
        <div class="card-body p-0">
            <!-- ===== BULK ACTION BAR ===== -->
            <div class="p-3 border-bottom bg-light">
                <div class="d-flex flex-wrap gap-3 align-items-end">

                    <!-- Bulk Attendance -->
                    <div>
                        <label class="form-label mb-1">Bulk Attendance</label>
                        <select id="bulkAttendance" class="form-select form-select-sm w-auto">
                            <option value="">-- Select --</option>
                            <option value="Present">Present</option>
                            <option value="Absent">Absent</option>
                            <option value="Late">Late</option>
                            <option value="Leave">Leave</option>
                            <option value="S.Leave">S.Leave</option>
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

                        <!-- Attendance Date -->
                        <div>
                            <label for="attendanceDate" class="form-label mb-1">
                                Attendance Date
                            </label>
                            <input
                                type="date"
                                id="attendanceDate"
                                name="attendanceDate"
                                class="form-control form-control-sm"
                                required>
                        </div>

                        <!-- Save Button -->
                        <div>
                            <label class="form-label mb-1 d-block">&nbsp;</label>
                            <button
                                type="button"
                                class="btn btn-sm btn-success"
                                id="saveAttendance">
                                Save Attendance
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
                            <th>Name</th>
                            <!-- <th>Class</th> -->
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
                                <td><?= $record->firstName ?> <?= $record->lastName ?></td>
                                <!-- <td><?= $record->className ?> <?= $record->sectionName ?></td> -->
                                <td>
                                    <div class="d-flex justify-content-start">
                                        <?php $sid = $record->studentId; ?>

                                        <div class="attendance-group">

                                            <input type="radio" class="btn-check" name="attendance_<?= $sid ?>" id="p<?= $sid ?>" value="Present" checked>
                                            <label class="att-btn present" for="p<?= $sid ?>">Present</label>

                                            <input type="radio" class="btn-check" name="attendance_<?= $sid ?>" id="a<?= $sid ?>" value="Absent">
                                            <label class="att-btn absent" for="a<?= $sid ?>">Absent</label>

                                            <input type="radio" class="btn-check" name="attendance_<?= $sid ?>" id="l<?= $sid ?>" value="Late">
                                            <label class="att-btn late" for="l<?= $sid ?>">Late</label>

                                            <input type="radio" class="btn-check" name="attendance_<?= $sid ?>" id="lv<?= $sid ?>" value="Leave">
                                            <label class="att-btn leave" for="lv<?= $sid ?>">Leave</label>

                                            <input type="radio" class="btn-check" name="attendance_<?= $sid ?>" id="sl<?= $sid ?>" value="S.Leave">
                                            <label class="att-btn sleave" for="sl<?= $sid ?>">Short Leave</label>

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
        $('#saveAttendance').on('click', function(e) {
            e.preventDefault();

            let rows = [];
            let date = $('#attendanceDate').val();

            $('.student-checkbox:checked').each(function() {

                let row = $(this).closest('tr');
                let sid = $(this).val();
                let status = row.find('input[type="radio"]:checked').val() || 'Present';

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
                url: "<?= site_url('Attendance/save_attendance') ?>",
                type: "POST",
                dataType: "json",
                data: {
                    date: date,
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
                        $("#pageContent").load("<?= base_url('Attendance') ?>");
                    }
                }
            });
        });

    });
</script>