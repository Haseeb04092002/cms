<div class="p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">User Access Control</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal"><i class="bi bi-plus-lg"></i> Add User</button>
    </div>

    <!-- User Role Cards -->
    <div class="row g-4">

        <!-- Teachers -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title fw-semibold">Teachers</h5>
                    <p class="card-text text-muted">
                        Control access for teaching staff and manage permissions.
                    </p>
                    <a href="#" class="btn btn-primary w-100">
                        Manage Permissions
                    </a>
                </div>
            </div>
        </div>

        <!-- Coordinators -->
        <div class="col-md-6 col-lg-4">
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

        <!-- Parents/Students -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title fw-semibold">Parents/Students</h5>
                    <p class="card-text text-muted">
                        View and restrict student and Parents access.
                    </p>
                    <a href="#" class="btn btn-primary w-100">
                        Manage Permissions
                    </a>
                </div>
            </div>
        </div>

    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>User Type</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="studentTableBody">
                        <?php
                        // echo "<br>";
                        // echo "<pre>";
                        // print_r($all_students);
                        // die();
                        foreach ($all_users as $record) :
                        ?>
                            
                            <tr>
                                <td><?= $record->type ?></td>
                                <td><?= $record->firstName ?> <?= $record->lastName ?></td>
                                <td>

                                    <a class="btn btn-sm btn-info navigator" href="<?= site_url('Tasks/view_edit_task/view/') . $record->type . '/' . $record->type . '/' . $record->type ?>">
                                        View
                                    </a>

                                    <a class="btn btn-sm btn-warning navigator" href="<?= site_url('Tasks/view_edit_task/edit/') . $record->type . '/' . $record->type . '/' . $record->type ?>">
                                        Edit
                                    </a>

                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $record->type ?>">
                                        Delete
                                    </button>

                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="deleteModal<?= $record->type ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">

                                                <div class="modal-header bg-light">
                                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <form class="FormDeleteTask" data-parsley-validate>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete this item ?</p>
                                                        <input type="hidden" name="type" value="<?= $record->type ?>">
                                                        <div class="text-end">
                                                            <button class="btn btn-danger BtnDeleteTask">Yes</button>
                                                        </div>
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