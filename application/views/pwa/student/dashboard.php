<div class="card pwa-card pwa-card-shadow mb-3 text-white bg-primary bg-gradient">
    <div class="card-body text-center">

        <div class="d-flex align-items-center justify-content-center">

            <div class="rounded-circle bg-white text-primary
                    d-inline-flex align-items-center justify-content-center
                    mb-2 pwa-avatar">
                <i class="bi bi-person-fill"></i>
            </div>

            <div class="ms-3 text-start fw-bold">
                <h5 class="mb-0 fw-bold">
                    <?= ucfirst($student->firstName) . ' ' . ucfirst($student->lastName) ?>
                </h5>

                <small>Admission No: <?= $student->admissionNo ?></small>

                <!-- <div class="mt-2">
                    <span class="badge <?= $student->status == 'pending' ? 'bg-warning text-dark' : 'bg-success' ?>">
                        <?= ucfirst($student->status) ?>
                    </span>
                </div> -->
            </div>

        </div>

    </div>
</div>

<div class="row g-2 mb-3">

    <div class="col-6">
        <div class="card pwa-tile text-center text-white bg-success bg-gradient p-2">
            <i class="bi bi-mortarboard fs-4"></i>
            <div class="small">Class</div>
            <strong><?= ucfirst($student->className) ?></strong>
        </div>
    </div>

    <div class="col-6">
        <div class="card pwa-tile text-center text-white bg-success bg-gradient p-2">
            <i class="bi bi-diagram-3 fs-4"></i>
            <div class="small">Section</div>
            <strong><?= ucfirst($student->sectionName) ?></strong>
        </div>
    </div>

    <div class="col-6">
        <div class="card pwa-tile text-center text-white bg-success bg-gradient p-2">
            <i class="bi bi-book fs-4"></i>
            <div class="small">Education</div>
            <strong><?= ucfirst($student->education_type) ?></strong>
        </div>
    </div>

    <div class="col-6">
        <div class="card pwa-tile text-center text-white bg-success bg-gradient p-2">
            <i class="bi bi-calendar-check fs-4"></i>
            <div class="small">Batch</div>
            <strong><?= $student->batchYear ?: '—' ?></strong>
        </div>
    </div>

</div>

<div class="row g-2 mb-3 text-center">

    <div class="col-4">
        <button class="btn btn-outline-primary w-100 pwa-action-btn"
            data-bs-toggle="modal"
            data-bs-target="#personalModal">
            <i class="bi bi-person"></i><br>
            <small>Personal</small>
        </button>
    </div>

    <div class="col-4">
        <button class="btn btn-outline-secondary w-100 pwa-action-btn"
            data-bs-toggle="modal"
            data-bs-target="#familyModal">
            <i class="bi bi-people"></i><br>
            <small>Family</small>
        </button>
    </div>

    <div class="col-4">
        <button class="btn btn-outline-dark w-100 pwa-action-btn"
            data-bs-toggle="modal"
            data-bs-target="#contactModal">
            <i class="bi bi-telephone"></i><br>
            <small>Contact</small>
        </button>
    </div>

</div>

<div class="modal fade pwa-modal" id="personalModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h6 class="modal-title">
                    <i class="bi bi-person-badge me-1"></i>
                    Personal Information
                </h6>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-0">
                <ul class="list-group list-group-flush">

                    <li class="list-group-item d-flex justify-content-between">
                        <span>Full Name</span>
                        <strong>
                            <?= ucfirst($student->firstName) . ' ' . ucfirst($student->lastName) ?>
                        </strong>
                    </li>

                    <li class="list-group-item d-flex justify-content-between">
                        <span>Gender</span>
                        <strong><?= ucfirst($student->gender) ?></strong>
                    </li>

                    <li class="list-group-item d-flex justify-content-between">
                        <span>Date of Birth</span>
                        <strong><?= date('d M Y', strtotime($student->dateOfBirth)) ?></strong>
                    </li>

                    <li class="list-group-item d-flex justify-content-between">
                        <span>Education Type</span>
                        <strong><?= ucfirst($student->education_type) ?></strong>
                    </li>

                    <li class="list-group-item d-flex justify-content-between">
                        <span>Previous School</span>
                        <strong><?= ucfirst($student->prev_school) ?></strong>
                    </li>

                    <li class="list-group-item d-flex justify-content-between">
                        <span>Admission Date</span>
                        <strong><?= date('d M Y', strtotime($student->admissionDate)) ?></strong>
                    </li>

                </ul>
            </div>

        </div>
    </div>
</div>


<div class="modal fade pwa-modal" id="familyModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down">
        <div class="modal-content">

            <div class="modal-header bg-secondary text-white">
                <h6 class="modal-title">
                    <i class="bi bi-people me-1"></i>
                    Family Information
                </h6>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-0">
                <ul class="list-group list-group-flush">

                    <li class="list-group-item">
                        <small class="pwa-muted">Father Name</small><br>
                        <strong><?= ucfirst($student->fatherName) ?></strong>
                    </li>

                    <li class="list-group-item">
                        <small class="pwa-muted">Mother Name</small><br>
                        <strong><?= ucfirst($student->motherName) ?></strong>
                    </li>

                    <li class="list-group-item">
                        <small class="pwa-muted">Guardian Name</small><br>
                        <strong><?= ucfirst($student->guardianName) ?></strong>
                    </li>

                </ul>
            </div>

        </div>
    </div>
</div>


<div class="modal fade pwa-modal" id="contactModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down">
        <div class="modal-content">

            <div class="modal-header bg-dark text-white">
                <h6 class="modal-title">
                    <i class="bi bi-telephone me-1"></i>
                    Contact Details
                </h6>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-0">
                <ul class="list-group list-group-flush">

                    <li class="list-group-item">
                        <small class="pwa-muted">Primary Contact</small><br>
                        <strong><?= $student->contactNo ?></strong>
                    </li>

                    <li class="list-group-item">
                        <small class="pwa-muted">Secondary Contact</small><br>
                        <strong><?= $student->contactNo2 ?></strong>
                    </li>

                    <li class="list-group-item">
                        <small class="pwa-muted">Email</small><br>
                        <strong><?= $student->email ?></strong>
                    </li>

                    <li class="list-group-item">
                        <small class="pwa-muted">Address</small><br>
                        <strong><?= ucfirst($student->address) ?></strong>
                    </li>

                </ul>
            </div>

        </div>
    </div>
</div>