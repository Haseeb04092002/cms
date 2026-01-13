<div class="p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Manage Expenses</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddExpense"><i class="bi bi-plus-lg"></i> Add New Expense</button>
        <!-- Add/Edit User Modal -->
        <div class="modal fade" id="AddExpense" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Expense</h5><button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="AddExpenseForm" class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Expense Title</label>
                                <input class="form-control" type="text">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Amount</label>
                                <input class="form-control" type="number">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Remarks</label>
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
                            <th>Title</th>
                            <th>Amount</th>
                            <th>Remarks</th>
                            <th>Added On</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < 10; $i++) : ?>
                            <tr>
                                <td>Food</td>
                                <td>500</td>
                                <td>Staff Lunch</td>
                                <td>Sep 15, 2025</td>
                                <td>
                                    <select class="form-select">
                                        <option selected><i class="bi bi-list-task"></i> Actions</option>
                                        <option value="1">Edit</option>
                                        <option value="1">Delete</option>
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