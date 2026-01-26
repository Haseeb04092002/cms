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

            /* ===== RIGHT PANEL BACKGROUND ===== */
            .section-bg {
                background: #f8f9fa;
                border-radius: 1rem;
                padding: 1rem;
            }

            /* ===== CARD HEADERS ===== */
            .card-header {
                font-size: .9rem;
                letter-spacing: .3px;
            }

            /* ===== SIBLINGS ===== */
            .sibling-row {
                background: #ffffff;
                transition: all .2s ease;
            }

            .sibling-row:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 18px rgba(0, 0, 0, .08);
            }
        </style>

        <div class="row g-4">

            <!-- LEFT PROFILE -->
            <div class="col-lg-4">
                <div class="card profile-card shadow-sm h-100 border-0">
                    <div class="card-body text-center">

                        <?php if (!empty($student_img)): ?>
                            <img src="<?= base_url($student_img->documentPath); ?>"
                                class="rounded-circle profile-img mb-3"
                                width="170" height="170" style="object-fit:cover;">
                        <?php else: ?>
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($student->firstName) ?>&size=170"
                                class="rounded-circle profile-img mb-3">
                        <?php endif; ?>

                        <h4 class="fw-bold mb-1">
                            <?= $student->firstName ?? '' ?> <?= $student->lastName ?? '' ?>
                        </h4>

                        <span class="badge bg-primary mb-2">
                            Admission #<?= $student->admissionNo ?? '--' ?>
                        </span>

                        <div class="mt-2">
                            <span class="badge bg-success px-3 py-2">
                                <?= $student->status ?? 'Active' ?>
                            </span>
                        </div>

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
                                                <?php if (!empty($student->password)): ?>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">Current Password</label>

                                                        <div class="input-group">
                                                            <span class="input-group-text">
                                                                <i class="bi bi-lock"></i>
                                                            </span>

                                                            <input type="text"
                                                                name="old_password"
                                                                class="form-control password-field"
                                                                value="<?= $student->password ?>"
                                                                required>

                                                            <span class="input-group-text toggle-password" role="button">
                                                                <i class="bi bi-eye"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="case" value="edit">
                                                <?php endif; ?>
                                                <?php if (empty($student->password)): ?>
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

                            <button class="btn btn-outline-primary">
                                <i class="bi bi-pencil-square me-2"></i> Tasks
                            </button>
                            <button class="btn btn-outline-success">
                                <i class="bi bi-cash-coin me-2"></i> Fee Details
                            </button>
                            <button class="btn btn-outline-info">
                                <i class="bi bi-graph-up-arrow me-2"></i> Progress
                            </button>
                            <button class="btn btn-outline-warning">
                                <i class="bi bi-calendar-check me-2"></i> Attendance
                            </button>
                        </div>

                        <hr class="my-4">

                        <!-- ACADEMIC INFO -->
                        <div class="text-start px-2">
                            <h6 class="fw-bold mb-3 text-primary">
                                <i class="bi bi-mortarboard me-2"></i> Academic Info
                            </h6>

                            <div class="mb-3">
                                <div class="info-label">Admission Date</div>
                                <strong>
                                    <?= !empty($student->admissionDate) ? date('d M Y', strtotime($student->admissionDate)) : '--' ?>
                                </strong>
                            </div>

                            <div>
                                <div class="info-label">Education Type</div>
                                <strong><?= $student->education_type ?? '--' ?></strong>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- RIGHT DETAILS -->
            <div class="col-lg-8">
                <div class="">

                    <!-- STUDENT INFORMATION -->
                    <div class="card shadow-sm mb-3 border-0 rounded-3">
                        <div class="card-header bg-primary text-white fw-semibold py-2">
                            <i class="bi bi-info-circle me-2"></i> Student Information
                        </div>
                        <div class="card-body p-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="info-label">First Name</div>
                                    <div class="fw-bold"><?= $student->firstName ?? '--' ?></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-label">Last Name</div>
                                    <div class="fw-bold"><?= $student->lastName ?? '--' ?></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-label">Class</div>
                                    <div class="fw-bold"><?= $student->className ?? '--' ?> <?= $student->sectionName ?? '--' ?></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-label">Gender</div>
                                    <div class="fw-bold"><?= $student->gender ?? '--' ?></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-label">Date of Birth</div>
                                    <div class="fw-bold"><?= !empty($student->dob) ? date('d M Y', strtotime($student->dob)) : '--' ?></div>
                                </div>
                                <div class="col-md-6 text-end">
                                    <div class="info-label">Status</div>
                                    <span class="badge bg-success"><?= $student->status ?? 'Active' ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PARENT / GUARDIAN -->
                    <div class="card shadow-sm mb-3 border-0 rounded-3">
                        <div class="card-header bg-success text-white fw-semibold py-2">
                            <i class="bi bi-people me-2"></i> Parent / Guardian Information
                        </div>
                        <div class="card-body p-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="info-label">Father Name</div>
                                    <div class="fw-bold"><?= $student->fatherName ?? '--' ?></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-label">Mother Name</div>
                                    <div class="fw-bold"><?= $student->motherName ?? '--' ?></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-label">Guardian Name</div>
                                    <div class="fw-bold"><?= $student->guardianName ?? '--' ?></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-label">Primary Contact</div>
                                    <div class="fw-bold"><?= $student->contactNo ?? '--' ?></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-label">Secondary Contact</div>
                                    <div class="fw-bold"><?= $student->contactNo2 ?? '--' ?></div>
                                </div>
                                <div class="col-12">
                                    <div class="info-label">Address</div>
                                    <div class="fw-bold"><?= $student->address ?? '--' ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SIBLINGS -->
                    <?php if (!empty($siblings)): ?>
                        <div class="card shadow-sm mb-0 border-0 rounded-3">
                            <div class="card-header bg-warning text-dark fw-semibold py-2">
                                <i class="bi bi-diagram-3 me-2"></i> Siblings Information
                            </div>
                            <div class="card-body p-3">
                                <?php foreach ($siblings as $sib): ?>
                                    <div class="row g-3 sibling-row align-items-center border rounded-3 p-3 mb-2">
                                        <div class="col-md-4">
                                            <div class="info-label">Child Name</div>
                                            <div class="fw-bold"><?= $sib->fullName ?? '--' ?></div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="info-label">Age</div>
                                            <div class="fw-bold"><?= $sib->age ?? '--' ?></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-label">Class</div>
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

</div>

<script>
    $(document).ready(function() {
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
                url: "<?= site_url('Student/save_password/') . $student->studentId ?>",
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
                        $("#pageContent").load("<?= base_url('Student/student_profileTasks/') . $student->studentId . '/' . $student->admissionNo ?>");
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