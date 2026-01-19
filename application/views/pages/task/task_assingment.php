<style>
    /* Clickable Card Effect */
    a .card {
        cursor: pointer;
        transition: all 0.25s ease;
    }

    a .card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
    }

    /* Slight icon animation */
    a .card:hover i {
        transform: scale(1.1);
    }

    /* Smooth icon transition */
    a .card i {
        transition: transform 0.25s ease;
    }

    a .card:hover {
        border-left: 4px solid #0d6efd;
    }

    a .card:active {
        transform: translateY(-2px);
    }
</style>

<div class="p-4">
    <h3 class="fw-bold mb-4 text-start">Tasks / Jobs Assignment</h3>

    <div class="row g-4">

        <!-- VIEW ALL TASKS -->
        <div class="col-md-4">
            <a href="<?= site_url('Tasks/all_tasks') ?>" class="text-decoration-none navigator">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body d-flex align-items-center gap-4">

                        <div class="rounded-circle bg-success bg-opacity-10 p-3">
                            <i class="bi bi-list-check fs-2 text-success"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1 text-dark">
                                View All Tasks
                            </h5>
                            <p class="mb-0 text-secondary small">
                                View, manage, and track all assigned tasks
                            </p>
                        </div>

                    </div>
                </div>
            </a>
        </div>

        <!-- BULK TASK ASSIGNMENT -->
        <div class="col-md-4">
            <a href="<?= site_url('Tasks/bulk_tasks') ?>" class="text-decoration-none navigator">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body d-flex align-items-center gap-4">

                        <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                            <i class="bi bi-people-fill fs-2 text-primary"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1 text-dark">
                                Bulk Task Assignment
                            </h5>
                            <p class="mb-0 text-secondary small">
                                Assign tasks to multiple students at once
                            </p>
                        </div>

                    </div>
                </div>
            </a>
        </div>

        <!-- INDIVIDUAL TASK ASSIGNMENT -->
        <div class="col-md-4">
            <a href="<?= site_url('Tasks/individual_task_upload') ?>" class="text-decoration-none navigator">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body d-flex align-items-center gap-4">

                        <div class="rounded-circle bg-success bg-opacity-10 p-3">
                            <i class="bi bi-person-check-fill fs-2 text-success"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1 text-dark">
                                Individual Task Assignment
                            </h5>
                            <p class="mb-0 text-secondary small">
                                Assign tasks to a specific student
                            </p>
                        </div>

                    </div>
                </div>
            </a>
        </div>

    </div>
</div>