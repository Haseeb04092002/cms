<?php
$assignedLectures = count($subject_class_assigns);
foreach ($subject_class_assigns as $record) {
    $lecturesPerWeek = $record->lecturesPerWeek;
}
?>

<div class="p-4">
    <div class="container my-4">

        <style>
            /* ===== PROFILE CARD ===== */
            .profile-card {
                background: linear-gradient(180deg, #f8f9fa, #ffffff);
                border-radius: 1rem;
            }

            .profile-img {
                border: 5px solid #fff;
                box-shadow: 0 10px 25px rgba(0, 0, 0, .15);
            }

            /* ===== ACTION BUTTONS ===== */
            .profile-actions .btn {
                border-radius: 30px;
                font-weight: 500;
            }

            /* ===== LABELS ===== */
            .info-label {
                font-size: 0.75rem;
                text-transform: uppercase;
                color: #6c757d;
                letter-spacing: .6px;
            }

            .dashboard-card {
                transition: all 0.25s ease-in-out;
                cursor: pointer;
            }

            .dashboard-card:hover {
                transform: scale(1.03);
                background-color: #f8f9fa;
                /* light grey */
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08) !important;
            }

            .dashboard-card:active {
                transform: scale(1.01);
            }
        </style>

        <div class="row g-4">

            <!-- LEFT PROFILE -->
            <div class="col-lg-4">
                <div class="card profile-card shadow-sm h-100 border-0">
                    <div class="card-body text-center">

                        <h4 class="fw-bold mb-1">
                            <?= $teacher->firstName ?? '' ?> <?= $teacher->lastName ?? '' ?>
                        </h4>

                        <span class="badge bg-primary mb-2">
                            Designation # <?= $teacher->designation ?? '--' ?>
                        </span>

                        <!-- ACTION BUTTONS -->
                        <div class="profile-actions d-grid gap-2 mt-4">

                            <button class="btn btn-outline-secondary"
                                data-bs-toggle="modal"
                                data-bs-target="#changePasswordModal">
                                <i class="bi bi-shield-lock me-2"></i> Change Password
                            </button>

                            <!-- CHANGE PASSWORD MODAL -->
                            <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg rounded-4">

                                        <!-- MODAL HEADER -->
                                        <div class="modal-header bg-primary text-white rounded-top-4">
                                            <h5 class="modal-title fw-semibold">
                                                <i class="bi bi-shield-lock me-2"></i> Change Password
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>

                                        <!-- MODAL BODY -->
                                        <form class="FormPassword" method="post">

                                            <div class="modal-body text-start p-4">

                                                <!-- OLD PASSWORD (ONLY IF EXISTS) -->
                                                <?php if (!empty($teacher->password)): ?>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">Current Password</label>

                                                        <div class="input-group">
                                                            <span class="input-group-text">
                                                                <i class="bi bi-lock"></i>
                                                            </span>

                                                            <input type="text"
                                                                name="old_password"
                                                                class="form-control password-field"
                                                                value="<?= $teacher->password ?>"
                                                                required>

                                                            <span class="input-group-text toggle-password" role="button">
                                                                <i class="bi bi-eye"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="case" value="edit">
                                                <?php endif; ?>
                                                <?php if (empty($teacher->password)): ?>
                                                    <input type="hidden" name="case" value="add">
                                                <?php endif; ?>
                                                <!-- NEW PASSWORD -->
                                                <div class="mb-3">
                                                    <label class="d-block pb-0 mb-0 form-label fw-semibold">New Password</label>
                                                    <small class="pt-0 mt-0 text-success">better to use suggested system password</small>
                                                    <button id="re-generate-password-btn" class="mt-0 p-1 py-0 rounded-1 btn btn-sm btn-outline-success">Re-generate</button>
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                            <i class="bi bi-key"></i>
                                                        </span>

                                                        <input type="password"
                                                            name="new_password"
                                                            class="form-control password-field"
                                                            id="new-password"
                                                            required>

                                                        <span class="input-group-text toggle-password" role="button">
                                                            <i class="bi bi-eye"></i>
                                                        </span>
                                                    </div>
                                                </div>

                                                <!-- CONFIRM PASSWORD -->
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Confirm New Password</label>

                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                            <i class="bi bi-check-circle"></i>
                                                        </span>

                                                        <input type="password"
                                                            name="confirm_password"
                                                            class="form-control password-field"
                                                            required>

                                                        <span class="input-group-text toggle-password" role="button">
                                                            <i class="bi bi-eye"></i>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- MODAL FOOTER -->
                                            <div class="modal-footer border-0 px-4 pb-4">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                    Cancel
                                                </button>
                                                <button type="submit" class="btn btn-primary px-4">
                                                    <i class="bi bi-save me-2"></i> Update Password
                                                </button>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- ACADEMIC INFO -->
                        <div class="text-start px-2">
                            <h6 class="fw-bold mb-3 text-primary">
                                <i class="bi bi-mortarboard me-2"></i> Personal Info
                            </h6>

                            <div class="mb-3">
                                <div class="info-label">Department</div>
                                <strong>
                                    <?= $teacher->department ?? '' ?>
                                </strong>
                            </div>
                            <div class="mb-3">
                                <div class="info-label">Contact</div>
                                <strong>
                                    <?= $teacher->contactNo ?? '' ?>
                                </strong>
                            </div>
                            <div class="mb-3">
                                <div class="info-label">Email</div>
                                <strong>
                                    <?= $teacher->email ?? '' ?>
                                </strong>
                            </div>
                            <div class="mb-3">
                                <div class="info-label">Address</div>
                                <strong>
                                    <?= $teacher->address ?? '' ?>
                                </strong>
                            </div>
                            <div class="mb-3">
                                <div class="info-label">Joining Date</div>
                                <strong>
                                    <?= !empty($teacher->joiningDate) ? date('d M Y', strtotime($teacher->joiningDate)) : '--' ?>
                                </strong>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- RIGHT DETAILS -->
            <div class="col-lg-8">
                <div class="container-fluid py-3">

                    <div class="row g-3">

                        <!-- Next Class Card -->
                        <div class="col-12 col-md-4">
                            <a href="student_next_class.php" class="text-decoration-none text-dark">
                                <div class="border rounded p-3 h-100 shadow-sm bg-white dashboard-card">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="fw-bold fs-5">Next Class</div>
                                            <div class="text-muted small">Upcoming lecture</div>
                                        </div>
                                        <div class="fs-1 text-primary">
                                            <i class="bi bi-easel2"></i>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="fw-semibold">Subject</div>
                                            <div class="text-muted">Physics</div>
                                        </div>
                                        <div class="col-6 text-end">
                                            <div class="fw-semibold">Time</div>
                                            <div class="text-muted">10:30 AM</div>
                                        </div>
                                    </div>

                                    <div class="mt-2 text-muted small">
                                        Teacher: Dr. Usman
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Total Leaves Card -->
                        <div class="col-12 col-md-4">
                            <a href="student_leaves.php" class="text-decoration-none text-dark">
                                <div class="border rounded p-3 h-100 shadow-sm bg-white dashboard-card">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="fw-bold fs-5">My Leaves</div>
                                            <div class="text-muted small">Attendance summary</div>
                                        </div>
                                        <div class="fs-1 text-warning">
                                            <i class="bi bi-calendar2-x"></i>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row text-center">
                                        <div class="col-4">
                                            <div class="fw-bold fs-4">3</div>
                                            <div class="text-muted small">Taken</div>
                                        </div>
                                        <div class="col-4">
                                            <div class="fw-bold fs-4">7</div>
                                            <div class="text-muted small">Remaining</div>
                                        </div>
                                        <div class="col-4">
                                            <div class="fw-bold fs-4">10</div>
                                            <div class="text-muted small">Total</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Notifications / Alerts Card -->
                        <div class="col-12 col-md-4">
                            <a href="student_notifications.php" class="text-decoration-none text-dark">
                                <div class="border rounded p-3 h-100 shadow-sm bg-white dashboard-card">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="fw-bold fs-5">Alerts</div>
                                            <div class="text-muted small">Notifications & updates</div>
                                        </div>
                                        <div class="fs-1 text-danger">
                                            <i class="bi bi-bell"></i>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="fw-semibold">New Messages</div>
                                            <div class="text-muted">2 unread notifications</div>
                                        </div>
                                    </div>

                                    <div class="mt-2">
                                        <span class="badge bg-danger">Urgent</span>
                                        <span class="badge bg-primary">Academic</span>
                                        <span class="badge bg-secondary">General</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>

                    <div class="card shadow-sm border-0 mt-4">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-bold">
                                <i class="bi bi-journal-bookmark-fill me-2 text-primary"></i>
                                Assigned Classes & Subjects
                            </h6>
                            <a href="<?= site_url('Cms/assign_classes_subjects/') . $teacher->staffId ?>" class="navigator btn btn-sm btn-primary">Assign Classes and Subjects</a>
                        </div>

                        <div class="card-body">

                            <div class="justify-content-start gap-2 d-flex align-items-center">
                                <span class="badge bg-secondary fs-6 mb-2">Total Lectures Per Week = <?= $lecturesPerWeek ?></span>
                                <span class="badge bg-success fs-6 mb-2">Total Free Lectures = <?= $lecturesPerWeek - $assignedLectures ?></span>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Class</th>
                                            <th>Section</th>
                                            <th>Subject</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php if (empty($subject_class_assigns)): ?>
                                            <div class="d-block p-3 justify-content-center mx-auto text-center">
                                                <h4>There are no subjects and class assigned</h4>
                                                <a href="<?= site_url('Cms/assign_classes_subjects/') . $teacher->staffId ?>" class="navigator btn btn-primary">Assign Classes and Subjects</a>
                                            </div>
                                        <?php endif;
                                        foreach ($subject_class_assigns as $record) :
                                        ?>
                                            <tr>
                                                <td><?= $record->assignId ?></td>
                                                <td><span class="fw-semibold"><?= $record->className ?></span></td>
                                                <td><span class="badge bg-info"><?= $record->sectionName ?></span></td>
                                                <td><span class="text-primary fw-bold"><?= $record->subjectName ?></span></td>
                                            </tr>
                                        <?php endforeach; ?>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>


                </div>

            </div>

        </div>


    </div>

</div>

<script>
    function generateStrongPassword(minLen = 6, maxLen = 8) {

        const lower = 'abcdefghijklmnopqrstuvwxyz';
        const upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const digits = '0123456789';
        const special = '!@#$%^&*()-_=+[]{}<>?';

        let password = [];

        // Ensure required characters
        password.push(lower[Math.floor(Math.random() * lower.length)]);
        password.push(upper[Math.floor(Math.random() * upper.length)]);
        password.push(digits[Math.floor(Math.random() * digits.length)]);
        password.push(special[Math.floor(Math.random() * special.length)]);

        // Random length between 6–8
        let length = Math.floor(Math.random() * (maxLen - minLen + 1)) + minLen;

        // Character pool
        let all = lower + upper + digits + special;

        for (let i = password.length; i < length; i++) {
            password.push(all[Math.floor(Math.random() * all.length)]);
        }

        // Shuffle array (Fisher–Yates)
        for (let i = password.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [password[i], password[j]] = [password[j], password[i]];
        }

        return password.join('');
    }

    /* ===== Regex Validation ===== */
    function validatePassword(pwd) {
        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d])\S{6,8}$/;
        return regex.test(pwd);
    }

    $(document).ready(function() {

        let pwd = generateStrongPassword();
        if (validatePassword(pwd)) {
            $("#new-password").val(pwd);
            console.log("✅ Valid password (Regex matched)");
        } else {
            console.log("❌ Invalid password (Regex failed)");
        }

        $("#re-generate-password-btn").on('click', function(e) {
            let pwd = generateStrongPassword();
            if (validatePassword(pwd)) {
                $("#new-password").val(pwd);
                console.log("✅ Valid password (Regex matched)");
            } else {
                console.log("❌ Invalid password (Regex failed)");
            }
        });

        $('.FormPassword').parsley();

        $(document).off('submit', '.FormPassword');
        $(document).on('submit', '.FormPassword', function(e) {
            e.preventDefault();

            let form = $(this);

            let formData = new FormData(this);

            $.ajax({
                url: "<?= site_url('Teacher/save_password/') . $teacher->staffId ?>",
                type: "POST",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {

                    let modalEl = form.closest('.modal');
                    let modal = bootstrap.Modal.getInstance(modalEl[0]);
                    if (modal) modal.hide();

                    Swal.fire({
                        title: response.status ? 'Success' : 'Error',
                        text: response.message,
                        icon: response.status ? 'success' : 'error',
                        timer: 300000,
                        showConfirmButton: true
                    });

                    if (response.status) {
                        $("#pageContent").load("<?= base_url('Teacher/dashboard/') . $teacher->staffId ?>");
                    }
                }
            });
        });

        document.querySelectorAll('.toggle-password').forEach(toggle => {
            toggle.addEventListener('click', function() {

                const input = this.closest('.input-group').querySelector('.password-field');
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            });
        });
    });
</script>