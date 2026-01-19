<div class="p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">User Access Control</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal"><i class="bi bi-plus-lg"></i> Add User</button>
    </div>

    <!-- User Role Cards -->
    <div class="row g-4">

        <!-- Teachers -->
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title fw-semibold">Teachers</h5>
                    <p class="card-text text-muted">
                        Control access for teaching staff.
                    </p>
                    <a href="#" class="btn btn-primary w-100">
                        Manage Permissions
                    </a>
                </div>
            </div>
        </div>

        <!-- Coordinators -->
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title fw-semibold">Coordinators</h5>
                    <p class="card-text text-muted">
                        Assign academic and administrative permissions.
                    </p>
                    <a href="#" class="btn btn-primary w-100">
                        Manage Permissions
                    </a>
                </div>
            </div>
        </div>

        <!-- Students -->
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title fw-semibold">Students</h5>
                    <p class="card-text text-muted">
                        View and restrict student access.
                    </p>
                    <a href="#" class="btn btn-primary w-100">
                        Manage Permissions
                    </a>
                </div>
            </div>
        </div>

        <!-- Parents -->
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title fw-semibold">Parents</h5>
                    <p class="card-text text-muted">
                        Manage parent portal permissions.
                    </p>
                    <a href="#" class="btn btn-primary w-100">
                        Manage Permissions
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- Permissions Table Placeholder -->
    <div class="row mt-5">
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-header fw-semibold">
                    Assigned Permissions
                </div>
                <div class="card-body table-responsive">

                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>User Name</th>
                                <th>Role</th>
                                <th>Permission Group</th>
                                <th>Permission</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Ali Raza</td>
                                <td>Teacher</td>
                                <td>Students</td>
                                <td>View Students</td>
                                <td class="text-center">
                                    <span class="badge bg-success">Allowed</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Sana Malik</td>
                                <td>Coordinator</td>
                                <td>Fees</td>
                                <td>Collect Fees</td>
                                <td class="text-center">
                                    <span class="badge bg-danger">Denied</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>