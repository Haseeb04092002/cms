<div class="p-4">
    <div class="d-flex justify-content-between mb-3">
        <div>
            <button class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#AddTeacher">Add New Teacher</button>
            <!-- Add Teacher Modal -->
            <!-- Add Teacher Modal -->
            <div class="modal fade" id="AddTeacher" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <!-- ❌ removed modal-dialog-centered -->

                    <div class="modal-content" style="max-height: 95vh;">

                        <div class="modal-header">
                            <h5 class="modal-title">Add Teacher</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <form id="FormAddTeacher" data-parsley-validate>

                            <!-- ✅ FORCE SCROLL HERE -->
                            <div class="modal-body" style="overflow-y:auto; max-height:500px;">
 
                                <div class="row g-3">

                                    <!-- First Name -->
                                    <div class="col-md-6">
                                        <label class="form-label">First Name</label>
                                        <input type="text"
                                            name="firstName"
                                            class="form-control"
                                            required
                                            data-parsley-pattern="^[a-zA-Z\s]+$"
                                            data-parsley-pattern-message="Only alphabets allowed">
                                    </div>

                                    <!-- Last Name -->
                                    <div class="col-md-6">
                                        <label class="form-label">Last Name</label>
                                        <input type="text"
                                            name="lastName"
                                            class="form-control"
                                            required
                                            data-parsley-pattern="^[a-zA-Z\s]+$"
                                            data-parsley-pattern-message="Only alphabets allowed">
                                    </div>

                                    <!-- Gender -->
                                    <div class="col-md-6">
                                        <label class="form-label">Gender</label>
                                        <select name="gender" class="form-select" required>
                                            <option value="">Select Gender</option>
                                            <option>Male</option>
                                            <option>Female</option>
                                            <option>Other</option>
                                        </select>
                                    </div>

                                    <!-- Designation -->
                                    <div class="col-md-6">
                                        <label class="form-label">Designation</label>
                                        <input type="text"
                                            name="designation"
                                            class="form-control"
                                            required>
                                    </div>

                                    <!-- Department -->
                                    <div class="col-md-6">
                                        <label class="form-label">Department</label>
                                        <input type="text"
                                            name="department"
                                            class="form-control"
                                            required>
                                    </div>

                                    <!-- Contact -->
                                    <div class="col-md-6">
                                        <label class="form-label">Contact No</label>
                                        <input type="text"
                                            name="contactNo"
                                            class="form-control"
                                            required
                                            data-parsley-pattern="^[0-9]{10,13}$"
                                            data-parsley-pattern-message="Enter valid contact number">
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="email"
                                            name="email"
                                            class="form-control"
                                            required>
                                    </div>

                                    <!-- Joining Date -->
                                    <div class="col-md-6">
                                        <label class="form-label">Joining Date</label>
                                        <input type="date"
                                            name="joiningDate"
                                            class="form-control"
                                            required>
                                    </div>

                                    <!-- Salary -->
                                    <div class="col-md-6">
                                        <label class="form-label">Salary</label>
                                        <input type="number"
                                            name="salary"
                                            class="form-control"
                                            required
                                            min="0">
                                    </div>

                                    <!-- Address -->
                                    <div class="col-md-12">
                                        <label class="form-label">Address</label>
                                        <textarea name="address"
                                            class="form-control"
                                            rows="2"
                                            required></textarea>
                                    </div>

                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancel</button>

                                <button type="submit"
                                    class="btn btn-success">Save Teacher</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="card mb-3 border-dark">
        <form id="teacherSearchForm">
            <div class="card-header p-1 ps-2">
                <h6 class="mb-0">Search Teachers</h6>
            </div>
            <div class="card-body p-3">
                <div class="row g-2 align-items-end">

                    <div class="col-md-3">
                        <label class="form-label mb-1">Teacher Name</label>
                        <input type="text"
                            name="teacherName"
                            class="form-control form-control-sm">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label mb-1">Designation</label>
                        <input type="text"
                            name="designation"
                            class="form-control form-control-sm">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label mb-1">Department</label>
                        <input type="text"
                            name="department"
                            class="form-control form-control-sm">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label mb-1">Contact</label>
                        <input type="text"
                            name="contact"
                            class="form-control form-control-sm">
                    </div>

                    <!-- Search Button -->
                    <div class="col-md-1 text-end">
                        <button type="submit" class="btn btn-dark btn-sm w-100">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Teacher ID</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Department</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Joining Date</th>
                            <th>Salary</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="teachersTableBody">
                        <?php foreach ($all_teachers as $teacher) : ?>
                            <tr>
                                <td><?= $teacher->staffId ?></td>
                                <td><?= ucfirst($teacher->firstName) ?></td>
                                <td><?= $teacher->designation ?></td>
                                <td><?= $teacher->department ?></td>
                                <td><?= $teacher->contactNo ?></td>
                                <td><?= $teacher->email ?></td>
                                <td><?= $teacher->joiningDate ?></td>
                                <td><?= $teacher->salary ?></td>
                                <td>
                                    <a href="<?= site_url('Teacher/dashboard/') . $teacher->staffId ?>" class="navigator btn btn-sm btn-primary">
                                        View
                                    </a>
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $teacher->staffId ?>">
                                        Edit
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $teacher->staffId ?>">
                                        Delete
                                    </button>

                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="deleteModal<?= $teacher->staffId ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">

                                                <div class="modal-header bg-light">
                                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <form class="FormDeleteTeacher" data-parsley-validate>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete this item ?</p>
                                                        <input type="hidden" name="staffId" value="<?= $teacher->staffId ?>">
                                                        <div class="text-end">
                                                            <button class="btn btn-danger BtnDeleteTeacher">Yes</button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade"
                                        id="editModal<?= $teacher->staffId ?>"
                                        tabindex="-1"
                                        aria-hidden="true">

                                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">

                                                <form class="FormEditTeacher" data-parsley-validate>

                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Teacher</h5>
                                                        <button type="button"
                                                            class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <input type="hidden"
                                                        name="staffId"
                                                        value="<?= $teacher->staffId ?>">

                                                    <div class="modal-body">

                                                        <div class="row g-3">

                                                            <!-- First Name -->
                                                            <div class="col-md-6">
                                                                <label class="form-label">First Name</label>
                                                                <input type="text"
                                                                    name="firstName"
                                                                    class="form-control"
                                                                    value="<?= $teacher->firstName ?>"
                                                                    required
                                                                    data-parsley-pattern="^[a-zA-Z\s]+$"
                                                                    data-parsley-pattern-message="Only alphabets allowed">
                                                            </div>

                                                            <!-- Last Name -->
                                                            <div class="col-md-6">
                                                                <label class="form-label">Last Name</label>
                                                                <input type="text"
                                                                    name="lastName"
                                                                    class="form-control"
                                                                    value="<?= $teacher->lastName ?>"
                                                                    required
                                                                    data-parsley-pattern="^[a-zA-Z\s]+$"
                                                                    data-parsley-pattern-message="Only alphabets allowed">
                                                            </div>

                                                            <!-- Gender -->
                                                            <div class="col-md-6">
                                                                <label class="form-label">Gender</label>
                                                                <select name="gender"
                                                                    class="form-select"
                                                                    required>
                                                                    <option value="">Select Gender</option>
                                                                    <option value="Male"
                                                                        <?= ($teacher->gender == 'Male') ? 'selected' : '' ?>>
                                                                        Male
                                                                    </option>
                                                                    <option value="Female"
                                                                        <?= ($teacher->gender == 'Female') ? 'selected' : '' ?>>
                                                                        Female
                                                                    </option>
                                                                    <option value="Other"
                                                                        <?= ($teacher->gender == 'Other') ? 'selected' : '' ?>>
                                                                        Other
                                                                    </option>
                                                                </select>
                                                            </div>

                                                            <!-- Designation -->
                                                            <div class="col-md-6">
                                                                <label class="form-label">Designation</label>
                                                                <input type="text"
                                                                    name="designation"
                                                                    class="form-control"
                                                                    value="<?= $teacher->designation ?>"
                                                                    required>
                                                            </div>

                                                            <!-- Department -->
                                                            <div class="col-md-6">
                                                                <label class="form-label">Department</label>
                                                                <input type="text"
                                                                    name="department"
                                                                    class="form-control"
                                                                    value="<?= $teacher->department ?>"
                                                                    required>
                                                            </div>

                                                            <!-- Contact -->
                                                            <div class="col-md-6">
                                                                <label class="form-label">Contact No</label>
                                                                <input type="text"
                                                                    name="contactNo"
                                                                    class="form-control"
                                                                    value="<?= $teacher->contactNo ?>"
                                                                    required
                                                                    data-parsley-pattern="^[0-9]{10,13}$"
                                                                    data-parsley-pattern-message="Enter valid contact number">
                                                            </div>

                                                            <!-- Email -->
                                                            <div class="col-md-6">
                                                                <label class="form-label">Email</label>
                                                                <input type="email"
                                                                    name="email"
                                                                    class="form-control"
                                                                    value="<?= $teacher->email ?>"
                                                                    required>
                                                            </div>

                                                            <!-- Joining Date -->
                                                            <div class="col-md-6">
                                                                <label class="form-label">Joining Date</label>
                                                                <input type="date"
                                                                    name="joiningDate"
                                                                    class="form-control"
                                                                    value="<?= $teacher->joiningDate ?>"
                                                                    required>
                                                            </div>

                                                            <!-- Salary -->
                                                            <div class="col-md-6">
                                                                <label class="form-label">Salary</label>
                                                                <input type="number"
                                                                    name="salary"
                                                                    class="form-control"
                                                                    value="<?= $teacher->salary ?>"
                                                                    required
                                                                    min="0">
                                                            </div>

                                                            <!-- Address -->
                                                            <div class="col-md-12">
                                                                <label class="form-label">Address</label>
                                                                <textarea name="address"
                                                                    class="form-control"
                                                                    rows="2"
                                                                    required><?= $teacher->address ?></textarea>
                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button"
                                                            class="btn btn-secondary"
                                                            data-bs-dismiss="modal">
                                                            Cancel
                                                        </button>

                                                        <button type="submit"
                                                            class="btn btn-success">
                                                            Save Changes
                                                        </button>
                                                    </div>

                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        /* ==========================
           INIT PARSLEY
        ========================== */
        $('#FormAddTeacher').parsley();
        $('.FormEditTeacher').parsley();
        $('.FormDeleteTeacher').parsley();


        /* ==========================
           ADD TEACHER
        ========================== */
        $(document).off('submit', '#FormAddTeacher').on('submit', '#FormAddTeacher', function(e) {

            e.preventDefault();

            let form = $(this);

            if (!form.parsley().isValid()) return;

            $.ajax({
                url: "<?= site_url('Teacher/add_teacher') ?>",
                type: "POST",
                data: form.serialize(),
                dataType: "json",
                success: function(response) {

                    handleResponse(response, form);

                }
            });

        });


        /* ==========================
           EDIT TEACHER
        ========================== */
        $(document).off('submit', '.FormEditTeacher').on('submit', '.FormEditTeacher', function(e) {

            e.preventDefault();

            let form = $(this);

            if (!form.parsley().isValid()) return;

            $.ajax({
                url: "<?= site_url('Teacher/edit_teacher') ?>",
                type: "POST",
                data: form.serialize(),
                dataType: "json",
                success: function(response) {

                    handleResponse(response, form, 1);

                }
            });

        });


        /* ==========================
           DELETE TEACHER
        ========================== */
        $(document).off('submit', '.FormDeleteTeacher').on('submit', '.FormDeleteTeacher', function(e) {

            e.preventDefault();

            let form = $(this);

            $.ajax({
                url: "<?= site_url('Teacher/delete_teacher') ?>",
                type: "POST",
                data: form.serialize(),
                dataType: "json",
                success: function(response) {

                    handleResponse(response, form, 1);

                }
            });

        });


        /* ==========================
           SEARCH TEACHER
        ========================== */
        $(document).off('submit', '#teacherSearchForm').on('submit', '#teacherSearchForm', function(e) {

            e.preventDefault();

            let formData = new FormData(this);

            Swal.fire({
                title: 'Searching...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: "<?= site_url('Teacher/find_teacher') ?>",
                type: "POST",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(res) {

                    Swal.close();

                    if (res.status) {
                        buildTeacherTable(res.data);
                    } else {
                        showError(res.message);
                    }

                }
            });

        });


        /* ==========================
           COMMON FUNCTIONS
        ========================== */

        function handleResponse(response, form, closeModals) {
            if (closeModals === 1) {
                closeAllModals();
            }

            if (!response.status) {
                showError(response.message);
                return;
            }

            showSuccess(response.message);

            if (form.attr('id') === 'FormAddTeacher') {
                form[0].reset();
                form.parsley().reset();
            }

            reloadPage();
        }


        function reloadPage() {
            $("#pageContent").load("<?= base_url('Teacher/all_teachers') ?>");
        }


        function closeAllModals() {
            document.querySelectorAll('.modal').forEach(modalEl => {
                let modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
            });
        }


        function showSuccess(message) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: message,
                timer: 2000,
                showConfirmButton: false
            });
        }


        function showError(message) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message,
                timer: 3000
            });
        }


        function buildTeacherTable(data) {

            let html = '';

            if (data.length === 0) {
                html = `<tr>
                        <td colspan="9" class="text-center text-muted">
                            No teachers found
                        </td>
                    </tr>`;
            } else {

                $.each(data, function(i, teacher) {

                    html += `
                    <tr>
                        <td>${teacher.staffId}</td>
                        <td>${teacher.firstName} ${teacher.lastName}</td>
                        <td>${teacher.designation}</td>
                        <td>${teacher.department}</td>
                        <td>${teacher.contactNo}</td>
                        <td>${teacher.email}</td>
                        <td>${teacher.joiningDate}</td>
                        <td>${teacher.salary}</td>
                        <td>
                            <a href="<?= base_url('Teacher/dashboard/') ?>${teacher.staffId}"
                                class="btn btn-sm btn-primary">
                                View
                            </a>
                        </td>
                    </tr>`;
                });

            }

            $('#teachersTableBody').html(html);
        }

    });
</script>