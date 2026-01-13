<div class="p-4">
    <div class="d-flex justify-content-between mb-3">
        <h4 class="fw-bold">Manage Sections</h4>
        <div>
            <button class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#AddSection">Add New Section</button>
            <!-- Add Class Modal -->
            <div class="modal fade" id="AddSection" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Section</h5><button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="AddSectionForm" class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Section Name</label>
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
                            <th>Father</th>
                            <th>Phone</th>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Reports</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < 10; $i++) : ?>
                            <tr>
                                <td>Sarah Khan</td>
                                <td>Zahid Khan</td>
                                <td>03368438235</td>
                                <td>Grade 1</td>
                                <td>A</td>
                                <td>
                                    <select class="form-select" style="background-color: #02a30a8a;">
                                        <option selected><i class="bi bi-list-task"></i> Reports</option>
                                        <option value="1">Character Certificate</option>
                                        <option value="2">School Leaving Certificate</option>
                                        <option value="3">Fee Voucher</option>
                                        <option value="3">Attendance Report</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-select" style="background-color: #0278a38a;">
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
</div>