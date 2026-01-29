<div class="p-4">
    <h3 class="fw-bold mb-4">Select class to view time table</span></h3>

    <div class="row g-4">
        <?php foreach ($classes as $class): ?>

            <?php
            if (empty($class->total_students) || $class->total_students <= 0) {
                continue; // skip class
            }

            // Timetable check
            $check = $this->db
                ->where('classId', $class->classId)
                ->where('stationId', $class->stationId)
                ->where('isDeleted', 0)
                ->get('tbl_time_table')
                ->row();

            $isTimeTable = !empty($check);

            // Link logic
            // if ($isTimeTable) {
            //     $link = site_url('Timetable/time_table_chart/' . $class->classId . '/edit');
            //     $clickAttr = '';
            // } else {
            //     // $link = 'javascript:void(0);';
            //     $clickAttr = 'data-bs-toggle="modal" data-bs-target="#ttModal' . $class->classId . '"';

            //     // $link = site_url('Timetable/time_table_chart/' . $class->classId . '/add');
            //     $link = "";
            //     // $clickAttr = '';
            // }
            ?>

            <div class="col-xl-3 col-lg-4 col-md-6">
                <?php if ($isTimeTable): ?>
                    <a style="cursor: pointer;" href="<?= site_url('Timetable/time_table_chart/' . $class->classId . '/edit'); ?>" class="navigator text-decoration-none">
                    <?php else: ?>
                        <a style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#ttModal<?= $class->classId ?>" class="text-decoration-none">
                        <?php endif; ?>
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body">

                                <!-- Status Badge -->
                                <div class="mb-3">
                                    <span class="badge <?= $isTimeTable ? 'bg-success text-white' : 'bg-warning text-dark' ?>">
                                        <?= $isTimeTable ? 'Ready' : 'Pending' ?>
                                    </span>
                                </div>

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

            <!-- ================= MODAL (Only for Pending) ================= -->
            <?php if (!$isTimeTable): ?>
                <div class="modal fade" id="ttModal<?= $class->classId ?>" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header">
                                <h5 class="modal-title text-danger">
                                    <i class="bi bi-exclamation-triangle-fill"></i> Timetable Not Available
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center">
                                <p class="mb-0 fw-semibold">
                                    Please create timetable first.<br>
                                    You cannot view timetable for this class.
                                </p>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                                <a href="<?= site_url('Timetable/time_table_templates/') . $class->classId ?>" data-bs-dismiss="modal" class="navigator btn btn-primary">Create Time Table</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        <?php endforeach; ?>
    </div>
</div>