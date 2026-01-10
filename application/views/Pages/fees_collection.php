<div class="p-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Fee Collection / Payment</h3>
    </div>

    <!-- Search Student Card -->
    <div class="card mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">Search Student</h5>
        </div>
        <div class="card-body">
            <form>
                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">Education Type</label>
                        <input type="text" class="form-control" placeholder="Enter Student ID">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Student Name</label>
                        <input type="text" class="form-control" placeholder="Enter Student ID">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Class</label>
                        <input type="text" class="form-control" placeholder="Enter Student Name">
                    </div>

                </div>

                <button class="btn btn-primary mt-3">Search</button>

            </form>
        </div>
    </div>


    <!-- Payment History -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">Payment History</h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Mode</th>
                            <th>Amount</th>
                            <th>Reference No.</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td>2025-01-10</td>
                            <td>Cash</td>
                            <td>5000</td>
                            <td>–</td>
                            <td><span class="badge bg-success">Paid</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary me-2">Receipt</button>
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#paymentModal">
                                    Collect Payment
                                </button>
                            </td>
                        </tr>

                        <tr>
                            <td>2025-02-05</td>
                            <td>Bank Transfer</td>
                            <td>5000</td>
                            <td>BTX123456</td>
                            <td><span class="badge bg-success">Paid</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary me-2">Receipt</button>
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#paymentModal">
                                    Collect Payment
                                </button>
                            </td>
                        </tr>

                    </tbody>

                </table>
            </div>
        </div>
    </div>

</div>
