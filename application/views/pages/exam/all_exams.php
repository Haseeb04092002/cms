<div class="p-4">
    <div class="d-flex justify-content-between mb-3">
        <h4 class="fw-bold">Manage Exams</h4>
        <div>
            <button class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#createExamModal">Add New Exam</button>
            <!-- CREATE EXAM MODAL -->
            <div class="modal fade" id="createExamModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow">

                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">
                                Create New Exam
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body text-center py-4">

                            <p class="text-secondary mb-4">
                                Select how you want to create the exam
                            </p>

                            <div class="d-grid gap-3">

                                <!-- Create For Class -->
                                <a href="<?= site_url('Exams/select_class') ?>"
                                    class="btn btn-primary btn-lg navigator" data-bs-dismiss="modal">
                                    <i class="bi bi-people-fill me-2"></i>
                                    Create for Class
                                </a>

                                <!-- Create For Student -->
                                <!-- <a href="<?= site_url('Exams/create_exam_for_student') ?>"
                                    class="btn btn-success btn-lg navigator" data-bs-dismiss="modal">
                                    <i class="bi bi-person-fill me-2"></i>
                                    Create for Student
                                </a> -->

                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="card mb-3 border-dark">
        <form id="teacherSearchForm">
            <div class="card-header p-1 ps-2">
                <h6 class="mb-0">Search Teachers</h6>
            </div>
            <div class="card-body p-3">
                <div class="row g-2 align-items-end">

                    <div class="col-md-3">
                        <label class="form-label mb-1">Exam Title</label>
                        <input type="text"
                            name="examTitle"
                            class="form-control form-control-sm">
                    </div>

                    <!-- Class -->
                    <div class="col-md-3">
                        <label class="form-label mb-1">Class</label>
                        <select class="form-select form-select-sm" name="class_id">
                            <option value="">--Select--</option>
                            <?php if (!empty($classes)): ?>
                                <?php foreach ($classes as $type): ?>
                                    <option value="<?= $type->classId ?>"
                                        <?= (!empty($student->classId) && $student->classId == $type->classId) ? 'selected' : '' ?>>
                                        <?= $type->className ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Section -->
                    <div class="col-md-3">
                        <label class="form-label mb-1">Section</label>
                        <select class="form-select form-select-sm" name="section_id">
                            <option value="">--Select--</option>
                            <?php if (!empty($classes)): ?>
                                <?php foreach ($classes as $type): ?>
                                    <option value="<?= $type->classId ?>"
                                        <?= (!empty($student->classId) && $student->classId == $type->classId) ? 'selected' : '' ?>>
                                        <?= $type->sectionName ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label mb-1">Subject Name</label>
                        <input type="text"
                            name="contact"
                            class="form-control form-control-sm">
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
                <table class="table table-hover mb-0 table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Exam ID</th>
                            <th>Title</th>
                            <th>Class</th>
                            <th>Subject</th>
                            <th>Date</th>
                            <th>Duration</th>
                            <th>Total Marks</th>
                            <th>Obtained Marks</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_exams as $exam) : ?>
                            <tr>
                                <td><?= $exam->examId ?></td>
                                <td><?= $exam->examTitle ?></td>
                                <td><?= $exam->className ?? '-' ?> <?= $exam->sectionName ?? '-' ?></td>
                                <td><?= $exam->subjectName ?? '--' ?></td>
                                <td><?= date('d-m-Y', strtotime($exam->examDate)) ?></td>
                                <td><?= $exam->duration ?? '--' ?> mins</td>
                                <td><?= $exam->totalMarks ?? '--' ?></td>
                                <td><?= $exam->obtainedMarks ?? '--' ?></td>
                                <td><?= $exam->examStatus ?? '--' ?></td>
                                <td>
                                    <a href="<?= site_url('Exams/view_exam/') . $exam->examId ?>" class="navigator btn btn-sm btn-primary">
                                        View
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $exam->examId ?>">
                                        Delete
                                    </button>

                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="deleteModal<?= $exam->examId ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">

                                                <div class="modal-header bg-light">
                                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <form class="FormDeleteTeacher" data-parsley-validate>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete this item ?</p>
                                                        <input type="hidden" name="examId" value="<?= $exam->examId ?>">
                                                        <div class="text-end">
                                                            <button class="btn btn-danger BtnDeleteExam">Yes</button>
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

<script>
    $(document).ready(function() {

        $('form').each(function() {
            this.reset();
        });
        $('#FormAddTeacher').parsley();
        $('.FormEditTeacher').parsley();
        $('.FormDeleteTeacher').parsley();

        $(document).on('click', '#BtnAddTeacher', function(e) {
            e.preventDefault();
            $('#FormAddTeacher').submit();
        });
        $(document).on('submit', '#FormAddTeacher', function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= site_url('Teacher/add_teacher') ?>",
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
                        var url = "<?= base_url('Teacher/all_teachers') ?>";
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

        $(document).on('click', '.BtnEditTeacher', function(e) {
            e.preventDefault();
            $(this).closest('form').submit();
        });

        $(document).on('submit', '.FormEditTeacher', function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= site_url('Teacher/edit_teacher') ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.status === false) {
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
                        var url = "<?= base_url('Teacher/all_teachers') ?>";
                        console.log(url);
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

        $(document).on('click', '.BtnDeleteTeacher', function(e) {
            e.preventDefault();
            $(this).closest('form').submit();
        });

        $(document).on('submit', '.FormDeleteTeacher', function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= site_url('Teacher/delete_teacher') ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.status === false) {
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
                        var url = "<?= base_url('Teacher/all_teachers') ?>";
                        console.log(url);
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
    });
</script>