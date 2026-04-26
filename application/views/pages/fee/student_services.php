<div class="p-4">
    <div class="card">
        <div class="card-body p-0">

            <!-- ===== BULK ACTION BAR ===== -->
            <div class="p-3 border-bottom bg-light">
                <div class="row g-2 align-items-end">

                    <!-- Batch Year -->
                    <div class="col-md-2">
                        <label class="form-label mb-1">Batch Year</label>
                        <select id="batchYear" class="form-select form-select-sm" required>
                            <option value="">Select Year</option>
                        </select>
                    </div>

                    <!-- Service -->
                    <div class="col-md-3">
                        <label class="form-label mb-1">Select Service</label>
                        <select id="service_id" class="form-select form-select-sm" required>
                            <option value="">Select Service</option>
                            <?php foreach ($services as $sv): ?>
                                <option value="<?= (int)$sv->serviceId ?>">
                                    <?= htmlspecialchars($sv->serviceName) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Start Month -->
                    <div class="col-md-2">
                        <label class="form-label mb-1">Start Month</label>
                        <select id="startMonth" class="form-select form-select-sm" required>
                            <option value="">Month</option>
                            <?php for ($m = 1; $m <= 12; $m++): ?>
                                <option value="<?= $m ?>">
                                    <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <!-- End Month -->
                    <div class="col-md-2">
                        <label class="form-label mb-1">End Month</label>
                        <select id="endMonth" class="form-select form-select-sm" required>
                            <option value="">Month</option>
                            <?php for ($m = 1; $m <= 12; $m++): ?>
                                <option value="<?= $m ?>">
                                    <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <!-- Save -->
                    <div class="col-auto ms-auto">
                        <button type="button"
                            class="btn btn-sm btn-success"
                            id="saveServices">
                            Save Services
                        </button>
                    </div>

                </div>
            </div>

            <!-- ===== STUDENT TABLE ===== -->
            <div class="table-responsive">
                <table class="table table-hover mb-0 table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th width="40">
                                <input type="checkbox" id="checkAll" class="form-check-input fs-5" checked>
                            </th>
                            <th>Admission No</th>
                            <th>Name</th>
                            <th>Class</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $record): ?>
                            <tr>
                                <td>
                                    <input type="checkbox"
                                        class="form-check-input fs-4 student-checkbox"
                                        value="<?= $record->studentId ?>" checked>
                                </td>
                                <td><?= $record->admissionNo ?></td>
                                <td><?= $record->firstName ?> <?= $record->lastName ?></td>
                                <td><?= $className ?> <?= $sectionName ?></td>
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

        /* ===== Populate Batch Year ===== */
        const yearSelect = document.getElementById("batchYear");
        const currentYear = new Date().getFullYear();

        for (let year = 2000; year <= 2030; year++) {
            let option = document.createElement("option");
            option.value = year;
            option.textContent = year;
            if (year === currentYear) option.selected = true;
            yearSelect.appendChild(option);
        }

        /* ===== Check All ===== */
        $('#checkAll').on('change', function() {
            $('.student-checkbox').prop('checked', this.checked);
        });

        /* ===== Save Services ===== */
        $('#saveServices').on('click', function() {

            let serviceId = $('#service_id').val();
            let startMonth = $('#startMonth').val();
            let endMonth = $('#endMonth').val();
            let batchYear = $('#batchYear').val();

            if (!serviceId || !startMonth || !endMonth) {
                Swal.fire('Warning', 'Please fill all fields', 'warning');
                return;
            }

            let students = [];

            $('.student-checkbox:checked').each(function() {
                students.push($(this).val());
            });

            if (students.length === 0) {
                Swal.fire('Warning', 'No students selected', 'warning');
                return;
            }

            $.ajax({
                url: "<?= site_url('Fee/save_bulk_services') ?>",
                type: "POST",
                dataType: "json",
                data: {
                    serviceId: serviceId,
                    startMonth: startMonth,
                    endMonth: endMonth,
                    batchYear: batchYear,
                    students: students
                },
                success: function(res) {

                    Swal.fire({
                        title: res.status ? 'Success' : 'Error',
                        text: res.message,
                        icon: res.status ? 'success' : 'error'
                    });

                    if (res.status) {
                        location.reload();
                    }
                }
            });

        });

    });
</script>