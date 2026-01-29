<?php
/* ===============================
   PREPARE DATA FROM CONTROLLER
================================ */

$assignedSubjects = [];
$assignedClasses  = [];
$assignedHeads    = [];
$lecturesValue    = '';

if (!empty($assignments)) {
    foreach ($assignments as $a) {

        // subjects
        if (!empty($a->subjectId) && $a->subjectId > 0) {
            $assignedSubjects[] = (int)$a->subjectId;
        }

        // classes
        if (!empty($a->classId) && $a->classId > 0) {
            $assignedClasses[] = (int)$a->classId;
        }

        // class heads
        if (!empty($a->headClassId) && $a->headClassId > 0) {
            $assignedHeads[] = (int)$a->headClassId;
        }

        // lectures per week (take first non-zero value)
        if ($lecturesValue === '' && !empty($a->lecturesPerWeek)) {
            $lecturesValue = (int)$a->lecturesPerWeek;
        }
    }
}

$assignedSubjects = array_unique($assignedSubjects);
$assignedClasses  = array_unique($assignedClasses);
$assignedHeads    = array_unique($assignedHeads);
?>

<div class="p-4">

    <!-- ================= TEACHER INFO ================= -->
    <form id="assignForm">
        <input type="hidden" name="teacherId" value="<?= (int)$teacher->staffId ?>">

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <div class="row align-items-center">

                    <div class="col-md-8">
                        <h5 class="fw-bold mb-1">
                            <i class="bi bi-person-badge me-2 text-primary"></i>
                            <?= htmlspecialchars($teacher->firstName) ?> <?= htmlspecialchars($teacher->lastName) ?>
                        </h5>
                        <div class="text-muted">
                            Designation: <strong><?= htmlspecialchars($teacher->designation) ?></strong> |
                            Department: <strong><?= htmlspecialchars($teacher->department) ?></strong>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- ================= LECTURES ================= -->
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="form-check mb-3">
                            <label class="form-label fw-semibold">
                                Total Lectures Per Week
                            </label>
                            <input class="form-control" type="number" name="lecturesPerWeek"
                                value="<?= htmlspecialchars($lecturesValue) ?>" min="0">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= ASSIGNMENTS ================= -->
        <div class="row">

            <!-- SUBJECTS -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white">
                        <h6 class="fw-bold mb-0">
                            <i class="bi bi-book me-2 text-primary"></i>
                            Assign Subjects
                        </h6>
                    </div>

                    <div class="card-body">
                        <?php foreach ($subjects as $record): ?>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox"
                                    name="subjects[]"
                                    value="<?= (int)$record->subjectId ?>"
                                    <?= in_array((int)$record->subjectId, $assignedSubjects) ? 'checked' : '' ?>>

                                <label class="form-check-label fw-semibold">
                                    <?= htmlspecialchars($record->subjectName) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- CLASSES -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white">
                        <h6 class="fw-bold mb-0">
                            <i class="bi bi-mortarboard-fill me-2 text-primary"></i>
                            Assign Classes
                        </h6>
                    </div>

                    <div class="card-body">
                        <?php foreach ($classes as $record): ?>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox"
                                    name="classes[]"
                                    value="<?= (int)$record->classId ?>"
                                    <?= in_array((int)$record->classId, $assignedClasses) ? 'checked' : '' ?>>

                                <label class="form-check-label fw-semibold">
                                    <?= htmlspecialchars($record->className) ?> <?= htmlspecialchars($record->sectionName) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- CLASS HEAD -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white">
                        <h6 class="fw-bold mb-0">
                            <i class="bi bi-mortarboard-fill me-2 text-primary"></i>
                            Class Teacher
                        </h6>
                    </div>

                    <div class="card-body">
                        <?php foreach ($classes as $record): ?>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox"
                                    name="classHeads[]"
                                    value="<?= (int)$record->classId ?>"
                                    <?= in_array((int)$record->classId, $assignedHeads) ? 'checked' : '' ?>>

                                <label class="form-check-label fw-semibold">
                                    <?= htmlspecialchars($record->className) ?> <?= htmlspecialchars($record->sectionName) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </div>

        <!-- ================= ACTION ================= -->
        <div class="d-flex justify-content-end gap-3">
            <button class="btn btn-primary" type="submit">
                Save assignments
            </button>
        </div>

    </form>

</div>


<script>
    $(document).ready(function() {

        $('form').each(function() {
            this.reset();
        });
        $('#assignForm').parsley();
        $(document).off('submit', '#assignForm').on('submit', '#assignForm', function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= site_url('Cms/save_subject_class_assign') ?>",
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
                    }
                }
            });
        });
    });
</script>