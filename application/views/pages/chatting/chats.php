<div class="p-4">

    <!-- ================= STATS CARDS ================= -->
    <div class="row g-3 mb-3">
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Total Tickets</div>
                            <div class="fs-4 fw-bold">248</div>
                        </div>
                        <i class="bi bi-ticket-perforated fs-2 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Open</div>
                            <div class="fs-4 fw-bold text-warning">42</div>
                        </div>
                        <i class="bi bi-hourglass-split fs-2 text-warning"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">In Progress</div>
                            <div class="fs-4 fw-bold text-primary">31</div>
                        </div>
                        <i class="bi bi-gear fs-2 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Resolved</div>
                            <div class="fs-4 fw-bold text-success">175</div>
                        </div>
                        <i class="bi bi-check-circle fs-2 text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= MAIN PANEL ================= -->
    <div class="row g-3">

        <!-- ===== LEFT: TICKET LIST ===== -->
        <div class="col-12 col-lg-4 col-xl-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong>Tickets</strong>
                        <button class="btn btn-sm btn-primary">
                            <i class="bi bi-plus-circle"></i> New
                        </button>
                    </div>
                    <input class="form-control form-control-sm mt-2" placeholder="Search ticket / name">
                </div>

                <div class="list-group list-group-flush" style="max-height:70vh; overflow-y:auto;">

                    <a href="#" class="list-group-item list-group-item-action active">
                        <div class="d-flex justify-content-between">
                            <strong>#TCK-1021</strong>
                            <small>10:00pm</small>
                        </div>
                        <div class="small">Ali Khan (Parent)</div>
                        <div class="small text-light">Fee issue</div>
                    </a>

                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex justify-content-between">
                            <strong>#TCK-1022</strong>
                            <small>9:40pm</small>
                        </div>
                        <div class="small">Hira Malik (Student)</div>
                        <div class="small text-muted">Result correction</div>
                    </a>

                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex justify-content-between">
                            <strong>#TCK-1023</strong>
                            <small>9:10pm</small>
                        </div>
                        <div class="small">Imran Khan (Parent)</div>
                        <div class="small text-muted">Transport complaint</div>
                    </a>

                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex justify-content-between">
                            <strong>#TCK-1024</strong>
                            <small>8:55pm</small>
                        </div>
                        <div class="small">Sara (Teacher)</div>
                        <div class="small text-muted">System access issue</div>
                    </a>

                </div>
            </div>
        </div>

        <!-- ===== RIGHT: CHAT VIEW ===== -->
        <div class="col-12 col-lg-8 col-xl-9">
            <div class="card shadow-sm h-100 d-flex flex-column">

                <!-- Header -->
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold">#TCK-1021 — Ali Khan (Parent)</div>
                            <div class="small text-muted">Category: Fee | Status: In Progress</div>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-telephone"></i></button>
                            <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-camera-video"></i></button>
                            <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-three-dots-vertical"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Messages -->
                <div class="card-body overflow-auto" style="max-height:65vh;">

                    <!-- User message -->
                    <div class="d-flex mb-3">
                        <div class="me-2">
                            <i class="bi bi-person-circle fs-3 text-secondary"></i>
                        </div>
                        <div class="bg-white border rounded p-3">
                            <div class="fw-semibold">Ali Khan</div>
                            <div>My child's fee voucher shows extra charges. Please clarify.</div>
                            <div class="small text-muted text-end">09:28</div>
                        </div>
                    </div>

                    <!-- Staff reply -->
                    <div class="d-flex justify-content-end mb-3">
                        <div class="bg-primary text-white rounded p-3" style="max-width:75%;">
                            <div class="fw-semibold">Support Team</div>
                            <div>We are checking your voucher. It may include transport charges.</div>
                            <div class="small text-end">09:41</div>
                        </div>
                    </div>

                    <!-- User message -->
                    <div class="d-flex mb-3">
                        <div class="me-2">
                            <i class="bi bi-person-circle fs-3 text-secondary"></i>
                        </div>
                        <div class="bg-white border rounded p-3">
                            <div class="fw-semibold">Ali Khan</div>
                            <div>We are not using transport service.</div>
                            <div class="small text-muted text-end">09:45</div>
                        </div>
                    </div>

                </div>

                <!-- Input -->
                <div class="card-footer bg-white">
                    <div class="input-group">
                        <button class="btn btn-outline-secondary"><i class="bi bi-paperclip"></i></button>
                        <input type="text" class="form-control" placeholder="Type your message...">
                        <button class="btn btn-primary"><i class="bi bi-send"></i></button>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>