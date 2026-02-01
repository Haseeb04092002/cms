<div class="p-4">
    <h3 class="fw-bold mb-4">Select class to view time table</span></h3>

    <div class="row g-4">
        <?php foreach ($classes as $class): 
            // $className = $class->className . ' ' . $class->sectionName;
            // echo "<br>className = ".$className;
            if (empty($class->total_students) || $class->total_students <= 0) {
                continue; // skip class
            }
            ?>

            <div class="col-xl-3 col-lg-4 col-md-6">
                <a style="cursor: pointer;" href="<?= site_url('Exams/create_exam_for_class/') . $class->classId . '/' . $class->className . '/' . $class->sectionName ?>" class="navigator text-decoration-none">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body">

                            <!-- Class Info -->
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                    <i class="bi bi-mortarboard-fill fs-4 text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark"><?= $class->className ?></h6>
                                    <small class="text-secondary"><?= $class->sectionName ?></small>
                                </div>
                            </div>

                            <!-- Students -->
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-secondary small">Students</span>
                                <span class="fw-bold text-primary fs-5"><?= $class->total_students ?></span>
                            </div>

                        </div>
                    </div>
                </a>
            </div>

        <?php endforeach; ?>
    </div>
</div>