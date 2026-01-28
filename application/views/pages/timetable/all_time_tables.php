<div class="p-4">
    <h3 class="fw-bold mb-4">Select class to view time table</span></h3>

    <div class="row g-4">

        <?php foreach ($classes as $class):
            if (!empty($class->total_students) && $class->total_students > 0) {
                $link = site_url('Timetable/time_table_chart/' . $class->classId);
            } else {
                $link = "javascript:void(0);";
            }
        ?>

            <div class="col-xl-3 col-lg-4 col-md-6">
                <a href="<?= $link ?>" class="navigator text-decoration-none">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body">

                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                    <i class="bi bi-mortarboard-fill fs-4 text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark"><?= $class->className ?></h6>
                                    <small class="text-secondary"><?= $class->sectionName ?></small>
                                </div>
                            </div>

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