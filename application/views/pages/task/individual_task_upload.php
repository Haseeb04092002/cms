<div class="p-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Assign Task to Individual</h3>
    </div>

    <div class="card mb-3 border-dark">
        <form id="studentSearchForm">
            <div class="card-header p-1 ps-2">
                <h6 class="mb-0">Search Students</h6>
            </div>
            <div class="card-body p-3">
                <div class="row g-2 align-items-end">

                    <!-- Education Type -->
                    <div class="col-md-2">
                        <label class="form-label mb-1">Education Type</label>
                        <select class="form-select form-select-sm" name="education_type">
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

                    <!-- Class -->
                    <div class="col-md-2">
                        <label class="form-label mb-1">Class</label>
                        <select class="form-select form-select-sm" name="class_id">
                            <option value="">--Select--</option>
                            <?php if (!empty($all_classes)): ?>
                                <?php foreach ($all_classes as $type): ?>
                                    <option value="<?= $type->classId ?>"
                                        <?= (!empty($student->classId) && $student->classId == $type->classId) ? 'selected' : '' ?>>
                                        <?= $type->className ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Section -->
                    <div class="col-md-2">
                        <label class="form-label mb-1">Section</label>
                        <select class="form-select form-select-sm" name="section_id">
                            <option value="">--Select--</option>
                            <?php if (!empty($all_classes)): ?>
                                <?php foreach ($all_classes as $type): ?>
                                    <option value="<?= $type->classId ?>"
                                        <?= (!empty($student->classId) && $student->classId == $type->classId) ? 'selected' : '' ?>>
                                        <?= $type->sectionName ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Student Name -->
                    <div class="col-md-3">
                        <label class="form-label mb-1">Student Name</label>
                        <input type="text"
                            name="student_name"
                            class="form-control form-control-sm"
                            placeholder="Type student name">
                    </div>

                    <!-- Batch Year -->
                    <div class="col-md-2">
                        <label class="form-label mb-1">Batch Year</label>
                        <select class="form-select form-select-sm" name="batchYear">
                            <option value="">--Select--</option>
                            <?php
                            if (!empty($all_batch_year)): ?>
                                <?php foreach ($all_batch_year as $type): ?>
                                    <?php
                                    $selected =
                                        (!empty($student->batchYear) && $student->batchYear == $type)
                                        ? 'selected'
                                        : '';
                                    ?>
                                    <option value="<?= $type ?>" <?= $selected ?>>
                                        <?= $type ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
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
                <table class="table table-hover mb-0 table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Student ID</th>
                            <!-- <th>Image</th> -->
                            <th>Admission No</th>
                            <!-- <th>Admission Date</th> -->
                            <th>Education Type</th>
                            <th>Name</th>
                            <th>Class</th>
                            <!-- <th>Status</th> -->
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="studentsTableBody">
                        <?php
                        // echo "<br>";
                        // echo "<pre>";
                        // print_r($all_students);
                        // die();
                        foreach ($all_students as $record) :
                        ?>
                            <tr>
                                <td><?= $record->studentId ?></td>
                                <td><?= $record->admissionNo ?></td>
                                <td><?= $record->student_education_type ?></td>
                                <td><?= $record->firstName ?> <?= $record->lastName ?></td>
                                <td><?= $record->className ?> <?= $record->sectionName ?></td>
                                <td>
                                    <div class="d-flex gap-2">

                                        <div class="position-static">
                                            <a class="btn btn-sm btn-info navigator" href="<?= site_url('Tasks/upload_task/student/') . $record->studentId ?>">
                                                Assign Task
                                            </a>
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

        $('.FormCollectFee').parsley();

        // remove previous handlers before binding
        $(document).off('submit', '.FormCollectFee');
        // submit handler
        $(document).on('submit', '.FormCollectFee', function(e) {
            e.preventDefault();

            let form = $(this);

            if (!form.parsley().isValid()) {
                return;
            }

            $.ajax({
                url: "<?= site_url('Fee/collect_fee') ?>",
                type: "POST",
                data: form.serialize(),
                dataType: "json",
                cache: false,
                success: function(response) {

                    // close only current modal
                    let modalEl = form.closest('.modal');
                    let modal = bootstrap.Modal.getInstance(modalEl[0]);
                    if (modal) modal.hide();

                    Swal.fire({
                        title: response.status ? 'Success' : 'Error',
                        text: response.message,
                        icon: response.status ? 'success' : 'error',
                        timer: 3000,
                        showConfirmButton: true
                    });

                    if (response.status) {
                        $("#pageContent").load("<?= base_url('Cms/fee_collection') ?>");
                    }
                }
            });
        });

        $('#FindStudentForm').parsley();

        $(document).on('click', '#resetBtn', function() {
            // $("#pageContent").load("<?= base_url('Cms/fee_collection') ?>");
        });

        $('#studentSearchForm').off('submit').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            Swal.fire({
                title: 'Searching...',
                text: 'Please wait',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            console.log("form data = ", formData);

            $.ajax({
                url: "<?= site_url('Student/find_student') ?>",
                type: "POST",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,

                success: function(res) {

                    Swal.close();

                    if (res.status === true) {

                        let html = '';

                        $.each(res.data, function(i, record) {

                            html += `
                                <tr>
                                    <td>${record.studentId}</td>
                                    <td>${record.admissionNo}</td>
                                    <td>${record.student_education_type}</td>
                                    <td>${record.firstName} ${record.lastName}</td>
                                    <td>${record.className} ${record.sectionName}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <div class="position-static">
                                                <a class="btn btn-sm btn-info navigator"
                                                href="<?= site_url('Tasks/upload_task/student/') ?>${record.studentId}">
                                                    Assign Task
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>`;
                        });

                        // ✅ Inject into table body
                        $('#studentTableBody').html(html);
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'No Data',
                            text: 'No students found'
                        });
                    }
                }
            });
        });

    });
</script>