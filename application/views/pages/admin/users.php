<div class="p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Multi-user Management & Access Control</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal"><i class="bi bi-plus-lg"></i> Add User</button>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Access</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Sarah Khan</td>
                            <td>sarah@school.com</td>
                            <td><span class="badge bg-primary">Teacher</span></td>
                            <td>Timetable, Attendance</td>
                            <td><button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#rolesModal">Roles</button></td>
                        </tr>
                        <tr>
                            <td>Ali Raza</td>
                            <td>ali@school.com</td>
                            <td><span class="badge bg-success">Parent</span></td>
                            <td>View Reports</td>
                            <td><button class="btn btn-sm btn-outline-secondary">Edit</button></td>
                        </tr>
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