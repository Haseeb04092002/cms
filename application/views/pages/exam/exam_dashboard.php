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
    <h3 class="fw-bold mb-4 text-start">Exam Management</h3>

    <div class="row g-4">

        <!-- CREATE NEW EXAM -->
        <div class="col-md-4">
            <button type="button" class="border-0 text-start"
                data-bs-toggle="modal"
                data-bs-target="#createExamModal">

                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body d-flex align-items-center gap-4">

                        <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                            <i class="bi bi-plus-square-fill fs-2 text-primary"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1 text-dark">
                                Create New Exam
                            </h5>
                            <p class="mb-0 text-secondary small">
                                Create and schedule a new examination
                            </p>
                        </div>

                    </div>
                </div>
            </button>
        </div>

        <!-- CREATE EXAM MODAL -->
        <div class="modal fade" id="createExamModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">
                            Create New Exam
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body text-center py-4">

                        <p class="text-secondary mb-4">
                            Select how you want to create the exam
                        </p>

                        <div class="d-grid gap-3">

                            <!-- Create For Class -->
                            <a href="<?= site_url('Exams/select_class') ?>"
                                class="btn btn-primary btn-lg navigator" data-bs-dismiss="modal">
                                <i class="bi bi-people-fill me-2"></i>
                                Create for Class
                            </a>

                            <!-- Create For Student -->
                            <a href="<?= site_url('Exams/create_exam_for_student') ?>"
                                class="btn btn-success btn-lg navigator" data-bs-dismiss="modal">
                                <i class="bi bi-person-fill me-2"></i>
                                Create for Student
                            </a>

                        </div>

                    </div>

                </div>
            </div>
        </div>


        <!-- VIEW ALL EXAMS -->
        <div class="col-md-4">
            <a href="<?= site_url('Exams/all_exams') ?>" class="text-decoration-none navigator">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body d-flex align-items-center gap-4">

                        <div class="rounded-circle bg-success bg-opacity-10 p-3">
                            <i class="bi bi-journal-text fs-2 text-success"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1 text-dark">
                                View All Exams
                            </h5>
                            <p class="mb-0 text-secondary small">
                                View, manage, and update all exams
                            </p>
                        </div>

                    </div>
                </div>
            </a>
        </div>


        <!-- EXAM CALENDAR -->
        <div class="col-md-4">
            <a href="<?= site_url('Exams/calendar') ?>" class="text-decoration-none navigator">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body d-flex align-items-center gap-4">

                        <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                            <i class="bi bi-calendar-event-fill fs-2 text-warning"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1 text-dark">
                                Exam Calendar
                            </h5>
                            <p class="mb-0 text-secondary small">
                                View exam dates and schedules in calendar view
                            </p>
                        </div>

                    </div>
                </div>
            </a>
        </div>


    </div>
</div>