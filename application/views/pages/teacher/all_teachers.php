<div class="p-4">
    <div class="d-flex justify-content-between mb-3">
        <h4 class="fw-bold">Manage Teachers</h4>
        <div>
            <button class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#AddTeacher">Add New Teacher</button>
            <!-- Add Teacher Modal -->
            <div class="modal fade" id="AddTeacher" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Add Teacher</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <form id="FormAddTeacher" data-parsley-validate>
                            <div class="modal-body">

                                <div class="row g-3">

                                    <!-- First Name -->
                                    <div class="col-md-6">
                                        <label class="form-label">First Name</label>
                                        <input type="text" name="firstName" class="form-control"
                                            required
                                            data-parsley-required-message="First name is required">
                                    </div>

                                    <!-- Last Name -->
                                    <div class="col-md-6">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" name="lastName" class="form-control"
                                            required
                                            data-parsley-required-message="Last name is required">
                                    </div>

                                    <!-- Gender -->
                                    <div class="col-md-6">
                                        <label class="form-label">Gender</label>
                                        <select name="gender" class="form-select"
                                            required
                                            data-parsley-required-message="Please select gender">
                                            <option value="">Select Gender</option>
                                            <option>Male</option>
                                            <option>Female</option>
                                            <option>Other</option>
                                        </select>
                                    </div>

                                    <!-- Designation -->
                                    <div class="col-md-6">
                                        <label class="form-label">Designation</label>
                                        <input type="text" name="designation" class="form-control"
                                            required
                                            data-parsley-required-message="Designation is required">
                                    </div>

                                    <!-- Department -->
                                    <div class="col-md-6">
                                        <label class="form-label">Department</label>
                                        <input type="text" name="department" class="form-control"
                                            required
                                            data-parsley-required-message="Department is required">
                                    </div>

                                    <!-- Contact No -->
                                    <div class="col-md-6">
                                        <label class="form-label">Contact No</label>
                                        <input type="tel" name="contactNo" class="form-control"
                                            required
                                            data-parsley-required-message="Contact number is required">
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control"
                                            required
                                            data-parsley-required-message="Email is required">
                                    </div>

                                    <!-- Joining Date -->
                                    <div class="col-md-6">
                                        <label class="form-label">Joining Date</label>
                                        <input type="date" name="joiningDate" class="form-control"
                                            required
                                            data-parsley-required-message="Joining date is required">
                                    </div>

                                    <!-- Salary -->
                                    <div class="col-md-6">
                                        <label class="form-label">Salary</label>
                                        <input type="number" name="salary" class="form-control"
                                            required
                                            data-parsley-required-message="Salary is required">
                                    </div>

                                    <!-- Address -->
                                    <div class="col-md-12">
                                        <label class="form-label">Address</label>
                                        <textarea name="address" class="form-control" rows="2"
                                            required
                                            data-parsley-required-message="Address is required"></textarea>
                                    </div>

                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="submit" class="btn btn-success" id="BtnAddTeacher">
                                    Save Teacher
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label">Search</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
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
                    <tbody>
                        <?php foreach ($all_teachers as $teacher) : ?>
                            <tr>
                                <td><?= $teacher->staffId ?></td>
                                <td><?= $teacher->firstName ?></td>
                                <td><?= $teacher->designation ?></td>
                                <td><?= $teacher->department ?></td>
                                <td><?= $teacher->contactNo ?></td>
                                <td><?= $teacher->email ?></td>
                                <td><?= $teacher->joiningDate ?></td>
                                <td><?= $teacher->salary ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $teacher->staffId ?>">
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

                                    <!-- Edit Form Modal -->
                                    <div class="modal fade" id="editModal<?= $teacher->staffId ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Teacher</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <form class="FormEditTeacher" data-parsley-validate>
                                                    <input type="hidden" name="staffId" value="<?= $teacher->staffId ?>">

                                                    <div class="modal-body">

                                                        <div class="row g-3">

                                                            <!-- First Name -->
                                                            <div class="col-md-6">
                                                                <label class="form-label">First Name</label>
                                                                <input type="text" name="firstName" class="form-control"
                                                                    value="<?= $teacher->firstName ?>" required>
                                                            </div>

                                                            <!-- Last Name -->
                                                            <div class="col-md-6">
                                                                <label class="form-label">Last Name</label>
                                                                <input type="text" name="lastName" class="form-control"
                                                                    value="<?= $teacher->lastName ?>" required>
                                                            </div>

                                                            <!-- Gender -->
                                                            <div class="col-md-6">
                                                                <label class="form-label">Gender</label>
                                                                <select name="gender" class="form-select" required>
                                                                    <option value="">Select Gender</option>
                                                                    <option <?= ($teacher->gender == 'Male') ? 'selected' : '' ?>>Male</option>
                                                                    <option <?= ($teacher->gender == 'Female') ? 'selected' : '' ?>>Female</option>
                                                                    <option <?= ($teacher->gender == 'Other') ? 'selected' : '' ?>>Other</option>
                                                                </select>
                                                            </div>

                                                            <!-- Designation -->
                                                            <div class="col-md-6">
                                                                <label class="form-label">Designation</label>
                                                                <input type="text" name="designation" class="form-control"
                                                                    value="<?= $teacher->designation ?>" required>
                                                            </div>

                                                            <!-- Department -->
                                                            <div class="col-md-6">
                                                                <label class="form-label">Department</label>
                                                                <input type="text" name="department" class="form-control"
                                                                    value="<?= $teacher->department ?>" required>
                                                            </div>

                                                            <!-- Contact No -->
                                                            <div class="col-md-6">
                                                                <label class="form-label">Contact No</label>
                                                                <input type="tel" name="contactNo" class="form-control"
                                                                    value="<?= $teacher->contactNo ?>" required>
                                                            </div>

                                                            <!-- Email -->
                                                            <div class="col-md-6">
                                                                <label class="form-label">Email</label>
                                                                <input type="email" name="email" class="form-control"
                                                                    value="<?= $teacher->email ?>" required>
                                                            </div>

                                                            <!-- Joining Date -->
                                                            <div class="col-md-6">
                                                                <label class="form-label">Joining Date</label>
                                                                <input type="date" name="joiningDate" class="form-control"
                                                                    value="<?= $teacher->joiningDate ?>" required>
                                                            </div>

                                                            <!-- Salary -->
                                                            <div class="col-md-6">
                                                                <label class="form-label">Salary</label>
                                                                <input type="number" name="salary" class="form-control"
                                                                    value="<?= $teacher->salary ?>" required>
                                                            </div>

                                                            <!-- Address -->
                                                            <div class="col-md-12">
                                                                <label class="form-label">Address</label>
                                                                <textarea name="address" class="form-control" rows="2" required><?= $teacher->address ?></textarea>
                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            Cancel
                                                        </button>
                                                        <button type="submit" class="btn btn-success BtnEditTeacher">
                                                            Save Teacher
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

        $('form').each(function() {
            this.reset();
        });
        $('#FormAddTeacher').parsley();
        $('.FormEditTeacher').parsley();
        $('.FormDeleteTeacher').parsley();

        $(document).on('click', '#BtnAddTeacher', function(e) {
            e.preventDefault();
            $('#FormAddTeacher').submit();
        });
        $(document).on('submit', '#FormAddTeacher', function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= site_url('Teacher/add_teacher') ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.status === false) {
                        document.querySelectorAll('.modal').forEach(modalEl => {
                            const modalInstance = bootstrap.Modal.getInstance(modalEl) ||
                                new bootstrap.Modal(modalEl); // in case it's not initialized yet
                            modalInstance.hide();
                        });
                        Swal.fire({
                            title: 'Error',
                            text: response.message,
                            icon: 'error',
                            position: 'center',
                            timer: 3000,
                            showConfirmButton: true,
                            confirmButtonText: 'OK',
                        });

                    } else {
                        var url = "<?= base_url('Teacher/all_teachers') ?>";
                        // console.log(url);
                        document.querySelectorAll('.modal').forEach(modalEl => {
                            const modalInstance = bootstrap.Modal.getInstance(modalEl) ||
                                new bootstrap.Modal(modalEl); // in case it's not initialized yet
                            modalInstance.hide();
                        });
                        Swal.fire({
                            title: 'Success',
                            text: response.message,
                            icon: 'success',
                            position: 'center',
                            timer: 3000,
                            showConfirmButton: true,
                            confirmButtonText: 'OK',
                        });

                        $("#pageContent").load(url, function() {
                            // $('.selectpicker').selectpicker();
                        });
                    }
                }
            });
        });

        $(document).on('click', '.BtnEditTeacher', function(e) {
            e.preventDefault();
            $(this).closest('form').submit();
        });

        $(document).on('submit', '.FormEditTeacher', function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= site_url('Teacher/edit_teacher') ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.status === false) {
                        Swal.fire({
                            title: 'Error',
                            text: response.message,
                            icon: 'error',
                            position: 'center',
                            timer: 3000,
                            showConfirmButton: true,
                            confirmButtonText: 'OK',
                        });

                    } else {
                        var url = "<?= base_url('Teacher/all_teachers') ?>";
                        console.log(url);
                        document.querySelectorAll('.modal').forEach(modalEl => {
                            const modalInstance = bootstrap.Modal.getInstance(modalEl) ||
                                new bootstrap.Modal(modalEl); // in case it's not initialized yet
                            modalInstance.hide();
                        });
                        Swal.fire({
                            title: 'Success',
                            text: response.message,
                            icon: 'success',
                            position: 'center',
                            timer: 3000,
                            showConfirmButton: true,
                            confirmButtonText: 'OK',
                        });

                        $("#pageContent").load(url, function() {
                            // $('.selectpicker').selectpicker();
                        });
                    }
                }
            });
        });

        $(document).on('click', '.BtnDeleteTeacher', function(e) {
            e.preventDefault();
            $(this).closest('form').submit();
        });

        $(document).on('submit', '.FormDeleteTeacher', function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= site_url('Teacher/delete_teacher') ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.status === false) {
                        Swal.fire({
                            title: 'Error',
                            text: response.message,
                            icon: 'error',
                            position: 'center',
                            timer: 3000,
                            showConfirmButton: true,
                            confirmButtonText: 'OK',
                        });

                    } else {
                        var url = "<?= base_url('Teacher/all_teachers') ?>";
                        console.log(url);
                        document.querySelectorAll('.modal').forEach(modalEl => {
                            const modalInstance = bootstrap.Modal.getInstance(modalEl) ||
                                new bootstrap.Modal(modalEl); // in case it's not initialized yet
                            modalInstance.hide();
                        });
                        Swal.fire({
                            title: 'Success',
                            text: response.message,
                            icon: 'success',
                            position: 'center',
                            timer: 3000,
                            showConfirmButton: true,
                            confirmButtonText: 'OK',
                        });

                        $("#pageContent").load(url, function() {
                            // $('.selectpicker').selectpicker();
                        });
                    }
                }
            });
        });
    });
</script>