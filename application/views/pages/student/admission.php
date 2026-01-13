<div class="p-4">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <!-- <li class="nav-item" role="presentation">
            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Main Stream Education</button>
        </li> -->
        <!-- <li class="nav-item" role="presentation">
            <button class="nav-link " id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Special Education</button>
        </li> -->
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">

            <div class="card">
                <div class="container">

                    <form id="AdmissionForm"
                        action="<?= site_url('Student/save_admission') ?>"
                        method="post"
                        enctype="multipart/form-data"
                        data-parsley-validate>

                        <?php if (!empty($case)): ?>
                            <?php if ($case == 'edit'): ?>
                                <h3 class="p-2 text-center bg-warning">Edit Student Data</h3>
                            <?php endif; ?>
                        <?php endif; ?>

                        <h3 class="p-2 text-center">
                            <?php
                            if (!empty($student->admissionNo)):
                            ?>
                                <strong>Admission Number =</strong> <?= $student->admissionNo ?? '' ?>
                                <input type="hidden" name="admission_no" value="<?= $student->admissionNo ?? '' ?>">
                            <?php endif; ?>
                            <?php
                            if (!empty($admissionNo)):
                            ?>
                                <strong>Admission Number =</strong> <?= $admissionNo ?? '' ?>
                                <input type="hidden" name="admission_no" value="<?= $admissionNo ?? '' ?>">
                            <?php endif; ?>
                            <input type="hidden" name="case" value="<?= $case ?? 'add' ?>">
                        </h3>

                        <!-- ADMISSION INFO -->
                        <div class="card mb-4 border-0">
                            <div class="card-header bg-light fw-bold">ADMISSION Information</div>
                            <div class="card-body row g-3">

                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Education Type</label>
                                    <select class="form-select" name="education_type" required>
                                        <option value="">-- Select --</option>

                                        <?php if (!empty($all_education_type)): ?>
                                            <?php foreach ($all_education_type as $type): ?>
                                                <option value="<?= $type ?>"
                                                    <?= (!empty($student->education_type) && $student->education_type == $type) ? 'selected' : '' ?>>
                                                    <?= $type ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>

                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Class & Section</label>
                                    <select class="form-select" name="class_section" required>
                                        <option value="">--Select--</option>
                                        <?php if (!empty($all_classes)): ?>
                                            <?php foreach ($all_classes as $type): ?>
                                                <option value="<?= $type->classId ?>"
                                                    <?= (!empty($student->classId) && $student->classId == $type->classId) ? 'selected' : '' ?>>
                                                    <?= $type->className ?> <?= $type->sectionName ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <!-- STUDENT INFO -->
                        <div class="card mb-4 border-0">
                            <div class="card-header bg-light fw-bold">STUDENT INFORMATION</div>
                            <div class="card-body row g-3">

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">First Name</label>
                                    <input type="text" name="student_first_name" class="form-control" value="<?= $student->firstName ?? '' ?>" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Last Name</label>
                                    <input type="text" name="student_last_name" class="form-control" value="<?= $student->lastName ?? '' ?>" required>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Date of Birth</label>
                                    <input type="date" name="dob" class="form-control" value="<?= $student->dateOfBirth ?? '' ?>" required>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Gender</label>
                                    <select class="form-select" name="gender" required>
                                        <option value="">-- Select --</option>

                                        <?php if (!empty($all_genders)): ?>
                                            <?php foreach ($all_genders as $type): ?>
                                                <option value="<?= $type ?>"
                                                    <?= (!empty($student->gender) && $student->gender == $type) ? 'selected' : '' ?>>
                                                    <?= $type ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>

                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Previous School</label>
                                    <input type="text" name="previous_school" class="form-control" value="<?= $student->prev_school ?? '' ?>">
                                </div>

                                <!-- OTHER CHILDREN -->
                                <div class="col-md-12">
                                    <label class="form-label fw-bold fw-semibold">Other Children Studying at Inklings</label>

                                    <div id="childrenWrapper">

                                        <?php if (!empty($siblings)): ?>
                                            <?php foreach ($siblings as $index => $sib): ?>
                                                <div class="row g-2 mb-2 child-row">
                                                    <div class="col-md-4">
                                                        <input type="text" name="child_name[]" class="form-control"
                                                            value="<?= $sib->fullName ?? '' ?>">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="number" name="child_age[]" class="form-control"
                                                            value="<?= $sib->age ?? '' ?>">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <select class="form-select" name="child_class[]">
                                                            <option value="">--Select--</option>
                                                            <?php foreach ($all_classes as $class): ?>
                                                                <option value="<?= $class->classId ?>"
                                                                    <?= ($sib->classId == $class->classId) ? 'selected' : '' ?>>
                                                                    <?= $class->className ?> (<?= $class->sectionName ?>)
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-1">
                                                        <?php if ($index === 0): ?>
                                                            <button type="button" class="btn btn-primary btn-sm add-row">+</button>
                                                        <?php endif; ?>
                                                    </div>

                                                    <div class="col-md-1">
                                                        <?php if ($index > 0): ?>
                                                            <button type="button" class="btn btn-danger btn-sm remove-row">×</button>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>


                                        <div id="childrenWrapper">

                                            <div class="row g-2 mb-2 child-row">
                                                <div class="col-md-4">
                                                    <input type="text" name="child_name[]" class="form-control" placeholder="name">
                                                </div>

                                                <div class="col-md-2">
                                                    <input type="number" name="child_age[]" class="form-control" placeholder="age">
                                                </div>

                                                <div class="col-md-4">
                                                    <select class="form-select" name="child_class[]">
                                                        <option value="">--Select class--</option>
                                                        <?php foreach ($all_classes as $class): ?>
                                                            <option value="<?= $class->classId ?>">
                                                                <?= $class->className ?> (<?= $class->sectionName ?>)
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <!-- ONLY FIRST ROW HAS + -->
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-primary btn-sm add-row">+</button>
                                                </div>

                                                <div class="col-md-1">
                                                    <!-- no delete on first row -->
                                                </div>
                                            </div>

                                        </div>



                                    </div>

                                </div>

                            </div>
                        </div>

                        <!-- PARENT INFO -->
                        <div class="card mb-4 border-0">
                            <div class="card-header bg-light fw-bold">PARENT INFORMATION</div>
                            <div class="card-body row g-3">

                                <div class="col-md-4">
                                    <label class="form-lable fw-bold">Father Name</label>
                                    <input type="text" name="father_name" class="form-control" value="<?= $student->fatherName ?? '' ?>">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-lable fw-bold">Mother Name</label>
                                    <input type="text" name="mother_name" class="form-control" value="<?= $student->motherName ?? '' ?>">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-lable fw-bold">Guardian Name</label>
                                    <input type="text" name="guardian_name" class="form-control" value="<?= $student->guardianName ?? '' ?>">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-lable fw-bold">Contact 1</label>
                                    <input type="text" name="contact_1" class="form-control" value="<?= $student->contactNo ?? '' ?>" required>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-lable fw-bold">Contact 2</label>
                                    <input type="text" name="contact_2" class="form-control" value="<?= $student->contactNo2 ?? '' ?>">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-lable fw-bold">Email</label>
                                    <input type="email" name="email" class="form-control" value="<?= $student->email ?? '' ?>">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-lable fw-bold">CNIC</label>
                                    <input type="text" name="cnic" class="form-control" value="<?= $student->cnic ?? '' ?>">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-lable fw-bold">Address</label>
                                    <input type="text" name="address" class="form-control" value="<?= $student->address ?? '' ?>" required>
                                </div>

                            </div>
                        </div>

                        <!-- PHOTO -->
                        <div class="card mb-4 border-0">
                            <div class="card-header bg-light fw-bold">Student Photograph</div>
                            <div class="card-body">

                                <?php if (!empty($student_img)): ?>
                                    <div class="mb-2">
                                        <strong>Existing File:</strong>
                                        <?= $student_img->documentTitle ?? 'Profile Image' ?>
                                    </div>
                                <?php endif; ?>

                                <input type="file"
                                    name="student_photo"
                                    class="form-control"
                                    <?= empty($student_img) ? 'required' : '' ?>>

                                <?php if (!empty($student_img->documentPath)): ?>
                                    <div class="mt-2">
                                        <img src="<?= base_url($student_img->documentPath); ?>"
                                            alt="Profile Image"
                                            class="img-thumbnail rounded-circle"
                                            width="75">
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>

                        <div class="justify-content-center mx-auto text-center pb-5">
                            <button type="submit" class="btn btn-primary px-5">Submit</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>


</div>


<script>
    $(document).ready(function() {

        // ADD ROW (only from first row)
        $(document).on('click', '.add-row', function() {

            let row = `
                <div class="row g-2 mb-2 child-row">
                    <div class="col-md-4">
                        <input type="text" name="child_name[]" class="form-control" placeholder="name">
                    </div>

                    <div class="col-md-2">
                        <input type="number" name="child_age[]" class="form-control" placeholder="age">
                    </div>

                    <div class="col-md-4">
                        <select class="form-select" name="child_class[]">
                            ${$('#childrenWrapper select:first').html()}
                        </select>
                    </div>

                    <div class="col-md-1">
                        <!-- NO ADD BUTTON HERE -->
                    </div>

                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-sm remove-row">×</button>
                    </div>
                </div>
            `;

            $('#childrenWrapper').append(row);
        });


        // REMOVE ROW
        $(document).on('click', '.remove-row', function() {
            $(this).closest('.child-row').remove();
        });


        $(document).on('submit', '#AdmissionForm', function(e) {
            e.preventDefault();

            let form = $(this);

            if (!form.parsley().validate()) {
                return false;
            }

            $.ajax({
                url: form.attr('action'),
                type: "POST",
                data: new FormData(this),
                dataType: "json",
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    Swal.fire({
                        title: 'Saving...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(response) {

                    if (response.status === true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        }).then(() => {
                            var url = "<?= base_url('Cms/all_students') ?>";
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

                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Something went wrong'
                    });
                }
            });
        });

    });
</script>