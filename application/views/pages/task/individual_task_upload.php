<div class="p-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Assign Task to Individual</h3>
    </div>

    <!-- Search Student Card -->
    <div class="card mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">Search Student</h5>
        </div>
        <div class="card-body">
            <form id="FindStudentForm" data-parsley-validate>
                <div class="row g-3">

                    <div class="col-md-4">
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

                    <div class="col-md-4">
                        <label class="form-label">Student Name</label>
                        <input type="text" class="form-control" name="student_name" data-parsley-required-message="Student Name is required">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Class</label>
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

                </div>

                <button class="btn btn-primary mt-3" type="submit">Search</button>
                <button class="btn btn-primary mt-3 ms-3" type="reset" id="resetBtn">Reset</button>

            </form>
        </div>
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
                    <tbody id="studentTableBody">
                        <?php
                        // echo "<br>";
                        // echo "<pre>";
                        // print_r($all_students);
                        // die();
                        foreach ($all_students as $record) :
                        ?>
                            <tr>
                                <td><?= $record->studentId ?></td>
                                <!-- <td>
                                    <?php if (!empty($record->documentPath)): ?>
                                        <img src="<?= base_url($record->documentPath); ?>"
                                            alt="Profile Image"
                                            class="img-thumbnail rounded-circle"
                                            width="75">
                                    <?php else: ?>
                                        <img src="<?= base_url('assets/images/default-avatar.png'); ?>"
                                            class="img-thumbnail rounded-circle"
                                            width="75">
                                    <?php endif; ?>
                                </td> -->
                                <td><?= $record->admissionNo ?></td>
                                <!-- <td><?= date('d M Y g:i A', strtotime($record->addedOn)) ?></td> -->
                                <td><?= $record->student_education_type ?></td>
                                <td><?= $record->firstName ?> <?= $record->lastName ?></td>
                                <td><?= $record->className ?> <?= $record->sectionName ?></td>
                                <!-- <td><span class="badge bg-warning text-dark"><?= $record->status ?></span></td> -->

                                <td>
                                    <div class="d-flex gap-2">

                                        <!-- Controls Dropdown -->
                                        <div class="position-static">
                                            <a class="btn btn-sm btn-info navigator" href="<?= site_url('Tasks/upload_task/student/').$record->studentId ?>">
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

        $(document).on('submit', '#FindStudentForm', function(e) {
            e.preventDefault();

            let form = $(this);
            if (!form.parsley().isValid()) return;

            $.ajax({
                url: "<?= site_url('Student/find_student') ?>",
                type: "POST",
                data: form.serialize(),
                dataType: "json",

                beforeSend: function() {
                    $('#studentTableBody').html(
                        '<tr><td colspan="9" class="text-center">Loading...</td></tr>'
                    );
                },

                success: function(response) {

                    if (!response.status || response.data.length === 0) {
                        $('#studentTableBody').html(
                            '<tr><td colspan="9" class="text-center text-muted">No students found</td></tr>'
                        );
                        return;
                    }

                    let rows = '';

                    response.data.forEach(function(r) {

                        let img = r.documentPath ?
                            "<?= base_url() ?>" + r.documentPath :
                            "<?= base_url('assets/images/default-avatar.png') ?>";

                        let date = new Date(r.addedOn).toLocaleString();

                        rows += `
                        <tr>
                            <td>${r.studentId}</td>

                            <!-- <td>
                                <img src="${img}"
                                     class="img-thumbnail rounded-circle"
                                     width="70">
                            </td> -->
                            <td>${r.admissionNo}</td>
                            <!-- <td>${date}</td> -->
                            <td>${r.student_education_type}</td>
                            <td>${r.firstName} ${r.lastName}</td>
                            <td>${r.className} ${r.sectionName}</td>

                            <!-- <td>
                                <span class="badge bg-warning text-dark">
                                    ${r.status}
                                </span>
                            </td> -->

                            <td>
                                <a class="btn btn-sm btn-info navigator" href="<?= site_url('Tasks/upload_task/student/').$record->studentId ?>">
                                    Assign Task
                                </a>
                            </td>
                        </tr>
                    `;
                    });

                    $('#studentTableBody').html(rows);
                },

                error: function() {
                    $('#studentTableBody').html(
                        '<tr><td colspan="9" class="text-danger text-center">Server Error</td></tr>'
                    );
                }
            });
        });

    });
</script>