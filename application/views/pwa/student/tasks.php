<div class="mb-3">
    <input type="text"
        class="form-control pwa-task-search"
        placeholder="Search task by title, subject or date">
</div>

<ul class="nav nav-pills nav-fill mb-3 small pwa-task-tabs">
    <li class="nav-item">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#allTasks">
            All Tasks
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#completedTasks">
            Completed
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#incompleteTasks">
            In-Complete
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#resultTasks">
            With Results
        </button>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane fade show active" id="allTasks">

        <!-- TASK CARD -->
        <div class="card mb-3 pwa-card pwa-card-shadow pwa-task-card">
            <div class="card-body">

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h6 class="mb-1">English Essay Writing</h6>
                        <small class="pwa-muted">Subject: English</small>
                    </div>
                    <span class="badge bg-warning text-dark">Pending</span>
                </div>

                <!-- Details -->
                <div class="small mb-2 pwa-task-meta">
                    <div><strong>Assigned:</strong> 10 Feb 2026</div>
                    <div><strong>Due:</strong> 15 Feb 2026</div>
                    <div><strong>Teacher:</strong> Mr. Ahmad</div>
                </div>

                <!-- Description -->
                <p class="small text-muted mb-3">
                    Write an essay on “My Favourite Teacher” (minimum 300 words).
                </p>

                <!-- Actions -->
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm w-100">
                        View Task
                    </button>
                    <button class="btn btn-outline-primary btn-sm w-100">
                        Upload Task
                    </button>
                </div>

            </div>
        </div>

    </div>
    <div class="tab-pane fade" id="completedTasks">

        <div class="card mb-3 pwa-card pwa-card-shadow pwa-task-card">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h6 class="mb-1">Math Worksheet – Chapter 5</h6>
                        <small class="pwa-muted">Subject: Mathematics</small>
                    </div>
                    <span class="badge bg-success">Completed</span>
                </div>

                <div class="small mb-2 strong> 10 Feb 202">
                    <div><strong>Submitted:</strong> 08 Feb 2026</div>
                    <div><strong>Teacher:</strong> Ms. Sara</div>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm w-100">
                        View Task
                    </button>
                    <button class="btn btn-outline-success btn-sm w-100">
                        View Result
                    </button>
                </div>

            </div>
        </div>

    </div>
    <div class="tab-pane fade" id="incompleteTasks">

        <div class="card mb-3 pwa-card pwa-card-shadow pwa-task-card">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h6 class="mb-1">Science Project – Plants</h6>
                        <small class="pwa-muted">Subject: Science</small>
                    </div>
                    <span class="badge bg-danger">Overdue</span>
                </div>

                <div class="small mb-2 strong> 15 Feb 202">
                    <div><strong>Due:</strong> 05 Feb 2026</div>
                    <div><strong>Teacher:</strong> Mr. Ali</div>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm w-100">
                        View Task
                    </button>
                    <button class="btn btn-outline-danger btn-sm w-100">
                        Upload Now
                    </button>
                </div>

            </div>
        </div>

    </div>
    <div class="tab-pane fade" id="resultTasks">

        <div class="card mb-3 pwa-card pwa-card-shadow pwa-task-card">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h6 class="mb-1">Urdu Translation</h6>
                        <small class="pwa-muted">Subject: Urdu</small>
                    </div>
                    <span class="badge bg-info text-dark">Result Published</span>
                </div>

                <div class="small mb-2 ="small mb-2">
                    <div><strong>Marks:</strong> 18 / 20</div>
                    <div><strong>Grade:</strong> A</div>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm w-100">
                        View Task
                    </button>
                    <button class="btn btn-outline-dark btn-sm w-100">
                        View Result
                    </button>
                </div>

            </div>
        </div>

    </div>

</div>