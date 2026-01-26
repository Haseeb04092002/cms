<div class="p-4">

    <!-- ================= TOP CHAT STATS ================= -->
    <div class="row g-3 mb-3">
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Total Chats</div>
                        <div class="fs-4 fw-bold">124</div>
                    </div>
                    <i class="bi bi-chat-dots fs-2 text-primary"></i>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Online Users</div>
                        <div class="fs-4 fw-bold text-success">18</div>
                    </div>
                    <i class="bi bi-circle-fill fs-2 text-success"></i>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Unread</div>
                        <div class="fs-4 fw-bold text-warning">7</div>
                    </div>
                    <i class="bi bi-envelope-exclamation fs-2 text-warning"></i>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Active Rooms</div>
                        <div class="fs-4 fw-bold text-primary">5</div>
                    </div>
                    <i class="bi bi-people fs-2 text-primary"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= MAIN CHAT PANEL ================= -->
    <div class="row g-3">

        <!-- ===== LEFT: CONTACT LIST ===== -->
        <div class="col-12 col-lg-4 col-xl-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <div class="fw-bold">Chats</div>
                    <input class="form-control form-control-sm mt-2" placeholder="Search user">
                </div>

                <div class="list-group list-group-flush" style="max-height:70vh; overflow-y:auto;">

                    <?php foreach ($all_messages as $record): ?>

                        <a href="#" class="list-group-item list-group-item-action active">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-person-circle fs-3 me-2"></i>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold">Ali Khan</div>
                                    <div class="small text-light">Typing...</div>
                                </div>
                                <span class="badge bg-danger">2</span>
                            </div>
                        </a>

                    <?php endforeach; ?>

                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-circle fs-3 me-2"></i>
                            <div class="flex-grow-1">
                                <div class="fw-semibold">Sara (Teacher)</div>
                                <div class="small text-muted">See you tomorrow</div>
                            </div>
                        </div>
                    </a>

                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-circle fs-3 me-2"></i>
                            <div class="flex-grow-1">
                                <div class="fw-semibold">Hira (Student)</div>
                                <div class="small text-muted">Thanks sir</div>
                            </div>
                        </div>
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
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-circle fs-3 me-2"></i>
                            <div>
                                <div class="fw-bold">Ali Khan</div>
                                <div class="small text-success">Online</div>
                            </div>
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

                    <!-- Incoming -->
                    <div class="d-flex mb-3">
                        <div class="me-2">
                            <i class="bi bi-person-circle fs-3 text-secondary"></i>
                        </div>
                        <div class="bg-white border rounded p-3">
                            <div class="fw-semibold">Ali Khan</div>
                            <div>Hello sir, I need help with fee voucher.</div>
                            <div class="small text-muted text-end">09:28</div>
                        </div>
                    </div>

                    <!-- Outgoing -->
                    <div class="d-flex justify-content-end mb-3">
                        <div class="bg-primary text-white rounded p-3" style="max-width:75%;">
                            <div class="fw-semibold">You</div>
                            <div>Please share the voucher screenshot.</div>
                            <div class="small text-end">09:41</div>
                        </div>
                    </div>

                    <!-- Incoming -->
                    <div class="d-flex mb-3">
                        <div class="me-2">
                            <i class="bi bi-person-circle fs-3 text-secondary"></i>
                        </div>
                        <div class="bg-white border rounded p-3">
                            <div class="fw-semibold">Ali Khan</div>
                            <div>Sure, sending now.</div>
                            <div class="small text-muted text-end">09:45</div>
                        </div>
                    </div>

                </div>

                <!-- Input -->
                <div class="card-footer bg-white">
                    <div class="input-group">
                        <button class="btn btn-outline-secondary"><i class="bi bi-paperclip"></i></button>
                        <input type="text" class="form-control" placeholder="Type a message...">
                        <button class="btn btn-primary"><i class="bi bi-send"></i></button>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>