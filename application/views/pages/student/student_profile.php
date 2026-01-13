<?php
$UserId = '';
$UserName = '';
$UserEmail = '';
$UserRole = '';
$StationId = '';
$UserId = $this->session->userdata('user_id') ?? '';
$UserName = $this->session->userdata('user_name') ?? '';
$UserEmail = $this->session->userdata('user_email') ?? '';
$UserRole = $this->session->userdata('user_role') ?? '';
$StationId = $this->session->userdata('station_id') ?? '';

// echo "<br>";
// echo "<pre>";
// print_r($siblings);

$student_img = $this->db
    ->where([
        'stationId' => $StationId,
        'referenceType' => 'student',
        'isDeleted' => 0,
        'referenceId'   => $student->admissionNo,
        'documentTitle' => 'profile_img'
    ])
    ->get('tbl_documents')
    ->row();
?>
<div class="p-4">
    <div class="container my-4">

        <div class="row g-4">

            <div class="col-lg-4">
                <div class="card shadow-sm h-100 border-0">
                    <div class="card-body text-center">

                        <?php if (!empty($student_img)): ?>
                            <img src="<?= base_url($student_img->documentPath); ?>"
                                class="rounded-circle shadow mb-3"
                                width="180" height="180" style="object-fit:cover;">
                        <?php else: ?>
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($student->firstName) ?>&size=180"
                                class="rounded-circle shadow mb-3">
                        <?php endif; ?>

                        <h4 class="fw-bold mb-1">
                            <?= $student->firstName ?? '' ?> <?= $student->lastName ?? '' ?>
                        </h4>

                        <p class="text-muted mb-2">
                            <i class="bi bi-person-badge"></i>
                            Admission #: <?= $student->admissionNo ?? '--' ?>
                        </p>

                        <span class="badge bg-success px-3 py-2 mb-3">
                            <?= $student->status ?? 'Active' ?>
                        </span>

                        <!-- ACTION BUTTONS -->
                        <div class="d-grid gap-2 mt-4">
                            <button class="btn btn-primary btn-lg">
                                <i class="bi bi-pencil-square me-2"></i> Edit Profile
                            </button>

                            <button class="btn btn-outline-success btn-lg">
                                <i class="bi bi-cash-coin me-2"></i> Fee Details
                            </button>

                            <button class="btn btn-outline-info btn-lg">
                                <i class="bi bi-graph-up-arrow me-2"></i> Progress
                            </button>

                            <button class="btn btn-outline-warning btn-lg">
                                <i class="bi bi-calendar-check me-2"></i> Attendance
                            </button>
                        </div>

                        <!-- ACADEMIC DETAILS (SHIFTED HERE) -->
                        <hr class="my-4">

                        <div class="text-start">
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-mortarboard me-2"></i> Academic Info
                            </h6>

                            <p class="mb-1">
                                <small class="text-muted">Admission Date</small><br>
                                <strong>
                                    <?= !empty($student->admissionDate) ? date('d M Y', strtotime($student->admissionDate)) : '--' ?>
                                </strong>
                            </p>

                            <p class="mb-0">
                                <small class="text-muted">Education Type</small><br>
                                <strong><?= $student->education_type ?? '--' ?></strong>
                            </p>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-8">

                <!-- STUDENT INFORMATION -->
                <div class="card shadow-sm mb-3 border-0 rounded-3">
                    <div class="card-header bg-primary text-white fw-bold rounded-top-3 d-flex align-items-center py-2">
                        <i class="bi bi-info-circle me-2"></i> Student Information
                    </div>
                    <div class="card-body p-3">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="text-muted small mb-1">First Name</div>
                                <div class="fw-bold"><?= $student->firstName ?? '--' ?></div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Last Name</div>
                                <div class="fw-bold"><?= $student->lastName ?? '--' ?></div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Class</div>
                                <div class="fw-bold"><?= $student->className ?? '--' ?> <?= $student->sectionName ?? '--' ?></div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Gender</div>
                                <div class="fw-bold"><?= $student->gender ?? '--' ?></div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Date of Birth</div>
                                <div class="fw-bold"><?= !empty($student->admissionDate) ? date('d M Y', strtotime($student->admissionDate)) : '--' ?></div>
                            </div>
                            <div class="col-md-6 text-end">
                                <div class="text-muted small mb-1">Status</div>
                                <span class="badge bg-success px-2 py-1"><?= $student->status ?? 'Active' ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PARENT / GUARDIAN INFORMATION -->
                <div class="card shadow-sm mb-3 border-0 rounded-3">
                    <div class="card-header bg-success text-white fw-bold rounded-top-3 d-flex align-items-center py-2">
                        <i class="bi bi-people me-2"></i> Parent / Guardian Information
                    </div>
                    <div class="card-body p-3">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Father Name</div>
                                <div class="fw-bold"><?= $student->fatherName ?? '--' ?></div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Mother Name</div>
                                <div class="fw-bold"><?= $student->motherName ?? '--' ?></div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Guardian Name</div>
                                <div class="fw-bold"><?= $student->guardianName ?? '--' ?></div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Contact No (Primary)</div>
                                <div class="fw-bold"><?= $student->contactNo ?? '--' ?></div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Contact No (Secondary)</div>
                                <div class="fw-bold"><?= $student->contactNo2 ?? '--' ?></div>
                            </div>
                            <div class="col-12">
                                <div class="text-muted small mb-1">Address</div>
                                <div class="fw-bold"><?= $student->address ?? '--' ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SIBLINGS INFORMATION -->
                <?php if (!empty($siblings)): ?>
                    <div class="card shadow-sm mb-3 border-0 rounded-3">
                        <div class="card-header bg-warning text-dark fw-bold rounded-top-3 d-flex align-items-center py-2">
                            <i class="bi bi-diagram-3 me-2"></i> Siblings Information
                        </div>
                        <div class="card-body p-3">
                            <?php foreach ($siblings as $sib): ?>
                                <div class="row g-2 align-items-center border rounded-2 p-2 mb-2">
                                    <div class="col-md-4">
                                        <div class="text-muted small mb-1">Child Name</div>
                                        <div class="fw-bold"><?= $sib->fullName ?: '--' ?></div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="text-muted small mb-1">Age</div>
                                        <div class="fw-bold"><?= $sib->age ?: '--' ?></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-muted small mb-1">Class</div>
                                        <div class="fw-bold">
                                            <?php
                                            foreach ($all_classes as $class) {
                                                if ($sib->classId == $class->classId) {
                                                    echo $class->className . ' (' . $class->sectionName . ')';
                                                    break;
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>


        </div>

    </div>

</div>