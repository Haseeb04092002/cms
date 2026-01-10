<div class="p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Manage Teachers</h4>
        <button class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#AddTeacher">Add New Teacher</button>
            <!-- Add Class Modal -->
            <div class="modal fade" id="AddTeacher" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Teacher</h5><button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="AddTeacherForm" class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Name</label>
                                    <input class="form-control" type="text">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Father</label>
                                    <input class="form-control" type="text">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">DOB</label>
                                    <input class="form-control" type="text">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Job Type</label>
                                    <input class="form-control" type="text">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone</label>
                                    <input class="form-control" type="text">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input class="form-control" type="text">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Address</label>
                                    <input class="form-control" type="text">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success">Save</button>
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <!-- <div class="col-md-3">
                    <label class="form-label">Select Class</label>
                    <select class="form-select">
                        <option selected>--</option>
                        <option value="1">Grade 1</option>
                        <option value="2">Grade 2</option>
                        <option value="3">Grade 3</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Select Section</label>
                    <select class="form-select">
                        <option selected>--</option>
                        <option value="1">A</option>
                        <option value="2">B</option>
                        <option value="3">C</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Select Student</label>
                    <select class="form-select">
                        <option selected>--</option>
                        <option value="1">Ali</option>
                        <option value="2">Haseeb</option>
                        <option value="3">Qasim</option>
                    </select>
                </div> -->
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th>Designation</th>
                            <th>Registered</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < 10; $i++) : ?>
                            <tr>
                                <td>Sarah Khan</td>
                                <td>sarah@school.com</td>
                                <td>03368438235</td>
                                <td>Nishat Colony Chakwal</td>
                                <td><span class="badge bg-primary">Coordinator</span></td>
                                <td>Sep 15, 2025</td>
                                <td>
                                    <select class="form-select">
                                        <option selected><i class="bi bi-list-task"></i> Actions</option>
                                        <option value="1">Edit</option>
                                        <option value="1">Delete</option>
                                        <option value="3">Promotion</option>
                                    </select>
                                </td>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add/Edit User Modal -->
    <div class="modal fade" id="userModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5><button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="userForm" class="row g-3">
                        <div class="col-12"><label class="form-label">Full name</label><input class="form-control"></div>
                        <div class="col-12"><label class="form-label">Email</label><input class="form-control" type="email"></div>
                        <div class="col-12"><label class="form-label">Role</label><select class="form-select">
                                <option>Admin</option>
                                <option>Teacher</option>
                                <option>Parent</option>
                                <option>Student</option>
                            </select></div>
                        <div class="col-12 text-end"><button class="btn btn-primary">Save</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Roles modal -->
    <div class="modal fade" id="rolesModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Role & Access</h5><button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-check"><input class="form-check-input" type="checkbox" id="acc1"><label class="form-check-label" for="acc1">View Attendance</label></div>
                    <div class="form-check"><input class="form-check-input" type="checkbox" id="acc2"><label class="form-check-label" for="acc2">Edit Timetable</label></div>
                </div>
                <div class="modal-footer"><button class="btn btn-secondary" data-bs-dismiss="modal">Close</button><button class="btn btn-primary">Save</button></div>
            </div>
        </div>
    </div>
</div>