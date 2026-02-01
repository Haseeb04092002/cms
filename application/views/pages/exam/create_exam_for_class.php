<div class="p-4">
    <div class="card border shadow-sm mb-4">
        <form id="createExamForm" data-parsley-validate>
            <div class="card-header bg-light">
                <h5 class="mb-0 fw-bold">Create Exam for <?= $className ?> <?= $sectionName ?></h5>
            </div>

            <div class="card-body">

                <div class="row g-3">

                    <input type="hidden" value="<?= $classId ?>" name="classId">

                    <!-- Exam Title -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Exam Title</label>
                        <input type="text"
                            name="exam_title"
                            class="form-control"
                            required
                            data-parsley-required-message="Exam title is required">
                    </div>

                    <!-- Exam Type -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Exam Type</label>
                        <select class="form-select"
                            name="exam_type"
                            required
                            data-parsley-required-message="Exam type is required">
                            <option value="">-- Select --</option>
                            <?php if (!empty($all_exam_types)): ?>
                                <?php foreach ($all_exam_types as $type): ?>
                                    <option value="<?= $type ?>">
                                        <?= $type ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Education Type -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Education Type</label>
                        <select class="form-select"
                            name="education_type"
                            required
                            data-parsley-required-message="Education type is required">
                            <option value="">-- Select --</option>
                            <?php if (!empty($all_education_types)): ?>
                                <?php foreach ($all_education_types as $type): ?>
                                    <option value="<?= $type ?>">
                                        <?= $type ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Subject -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Subject</label>
                        <select class="form-select"
                            name="subject"
                            required
                            data-parsley-required-message="Subject is required">
                            <option value="">-- Select --</option>
                            <?php if (!empty($all_subjects)): ?>
                                <?php foreach ($all_subjects as $subject): ?>
                                    <option value="<?= $subject->subjectId ?>">
                                        <?= $subject->subjectName ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Exam Date -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Exam Date</label>
                        <input type="date"
                            name="exam_date"
                            class="form-control"
                            required
                            data-parsley-required-message="Exam date is required">
                    </div>

                    <!-- Result Date -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Result Date</label>
                        <input type="date"
                            name="result_date"
                            class="form-control"
                            required
                            data-parsley-required-message="Result date is required">
                    </div>

                    <!-- Duration -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Duration (Minutes)</label>
                        <input type="number"
                            name="duration_minutes"
                            class="form-control"
                            required
                            data-parsley-required-message="Duration is required">
                    </div>

                    <!-- Total Marks -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Total Marks</label>
                        <input type="number"
                            name="total_marks"
                            class="form-control"
                            required
                            data-parsley-required-message="Total marks are required">
                    </div>

                    <!-- Passing Marks -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Passing Marks</label>
                        <input type="number"
                            name="passing_marks"
                            class="form-control"
                            required
                            data-parsley-required-message="Passing marks are required">
                    </div>

                    <!-- Weightage -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Weightage (%)</label>
                        <input type="number"
                            step="0.01"
                            name="weightage"
                            class="form-control"
                            required
                            data-parsley-required-message="Weightage is required">
                    </div>

                    <!-- Instructions -->
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Exam Instructions</label>
                        <textarea class="form-control"
                            name="instructions"
                            rows="3"
                            required
                            data-parsley-required-message="Exam instructions are required"></textarea>
                    </div>

                </div>

            </div>

            <div class="card-footer bg-light d-flex justify-content-end gap-2">
                <button type="reset" class="btn btn-secondary">
                    Reset
                </button>
                <button type="submit" class="btn btn-primary">
                    Save
                </button>
            </div>
        </form>

    </div>
</div>

<script>
    $(document).ready(function() {
        $(document).off('submit', '#createExamForm').on('submit', '#createExamForm', function(e) {
            e.preventDefault();

            let form = $(this);

            if (!form.parsley().validate()) {
                return false;
            }

            $.ajax({
                url: "<?= site_url('Exams/save_exam/add') ?>",
                type: "POST",
                data: new FormData(this),
                dataType: "json",
                processData: false,
                contentType: false,
                cache: false,
                success: function(response) {

                    if (response.status === true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        }).then(() => {
                            var url = "<?= base_url('Student/all_students') ?>";
                            // console.log(url);
                            document.querySelectorAll('.modal').forEach(modalEl => {
                                const modalInstance = bootstrap.Modal.getInstance(modalEl) ||
                                    new bootstrap.Modal(modalEl); // in case it's not initialized yet
                                modalInstance.hide();
                            });

                            $("#pageContent").load(url, function() {
                                // $('.selectpicker').selectpicker();
                            });
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }

                }
            });
        });

    });
</script>