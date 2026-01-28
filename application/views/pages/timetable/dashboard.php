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
    <h3 class="fw-bold mb-4 text-start">Time Table Management</h3>

    <div class="row g-4">

        <!-- VIEW TIME TABLE -->
        <div class="col-md-4">
            <a href="<?= site_url('Timetable/all_time_tables') ?>" class="text-decoration-none navigator">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body d-flex align-items-center gap-4">

                        <div class="rounded-circle bg-info bg-opacity-10 p-3">
                            <i class="bi bi-calendar3-week fs-2 text-info"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1 text-dark">
                                View Time Table
                            </h5>
                            <p class="mb-0 text-secondary small">
                                View and manage class-wise time tables
                            </p>
                        </div>

                    </div>
                </div>
            </a>
        </div>

        <!-- CREATE NEW TIME TABLE -->
        <div class="col-md-4">
            <a href="<?= site_url('Timetable/time_table_templates') ?>" class="text-decoration-none navigator">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body d-flex align-items-center gap-4">

                        <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                            <i class="bi bi-plus-square-dotted fs-2 text-warning"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1 text-dark">
                                Create New Time Table
                            </h5>
                            <p class="mb-0 text-secondary small">
                                Create and assign a new class timetable
                            </p>
                        </div>

                    </div>
                </div>
            </a>
        </div>


    </div>
</div>