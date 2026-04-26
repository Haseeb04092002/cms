<div class="p-4">
    <div class="row g-4">

        <?php foreach ($classes as $class):

            if ($class->total_students <= 0) continue;

            $services = $servicesByClass[$class->classId] ?? [];
        ?>

            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm border-0">

                    <div class="card-body">

                        <!-- Class Header -->
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                <i class="bi bi-mortarboard-fill fs-4 text-primary"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">
                                    <?= $class->className ?>
                                </h6>
                                <small class="text-secondary">
                                    <?= $class->sectionName ?>
                                </small>
                            </div>
                        </div>

                        <!-- Student Count -->
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-secondary small">Total Students</span>
                            <span class="fw-bold text-primary">
                                <?= $class->total_students ?>
                            </span>
                        </div>

                        <hr>

                        <!-- Service List -->
                        <?php if (!empty($services)): ?>

                            <?php foreach ($services as $srv): ?>

                                <?php
                                $isFull = ($srv['assignedCount'] == $class->total_students);
                                ?>

                                <div class="d-flex justify-content-between align-items-center mb-2">

                                    <span class="small text-dark">
                                        <?= $srv['serviceName'] ?>
                                    </span>

                                    <?php if ($isFull): ?>
                                        <span class="badge bg-success">
                                            Whole Class Assigned
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">
                                            <?= $srv['assignedCount'] ?> Assigned
                                        </span>
                                    <?php endif; ?>

                                </div>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <div class="text-muted small">
                                No services assigned
                            </div>

                        <?php endif; ?>

                    </div>

                    <!-- Footer Button -->
                    <div class="card-footer bg-white border-0 pt-0">
                        <a href="<?= site_url('Fee/student_services/' . $class->classId) ?>"
                            class="navigator btn btn-sm btn-outline-primary w-100">
                            Manage Services
                        </a>
                    </div>

                </div>
            </div>

        <?php endforeach; ?>

    </div>
</div>