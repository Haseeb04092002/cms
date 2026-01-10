<div class="p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">All Courses</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal"><i class="bi bi-plus-lg"></i> Add New Course</button>
    </div>
    <div class="row">
        <?php for ($i = 1; $i <= 6; $i++): ?>
        <div class="p-3 col-12 col-md-6 col-lg-4">
            <div class="card shadow-sm">
                <div class="position-relative">
                    <img src="https://courses.iid.org.in/public//uploads/media_manager/725.jpg"
                        class="card-img-top"
                        alt="Course Image"
                        style="height: 150px; object-fit: cover;">
                    <!-- Category Badge Overlay -->
                    <span class="badge bg-danger fs-6 position-absolute top-0 end-0 m-2">Science</span>
                </div>
                <div class="card-body">
                    <h5 class="card-title fw-bold">Introduction to Coding</h5>
                    <p class="card-text small mb-2">Learn the fundamentals of physics, covering mechanics, energy, and motion with practical examples.</p>

                    <!-- Dates and Duration Row -->
                    <div class="d-flex justify-content-between flex-wrap small text-muted mb-3">
                        <div class="d-flex align-items-center mb-1">
                            <i class="bi bi-calendar-event me-1"></i> 10 Dec 2025
                        </div>
                        <div class="d-flex align-items-center mb-1">
                            <i class="bi bi-calendar-check me-1"></i> 10 Mar 2026
                        </div>
                        <div class="d-flex align-items-center mb-1">
                            <i class="bi bi-clock me-1"></i> 3 months
                        </div>
                    </div>

                    <a href="#" class="btn btn-primary btn-sm">Read More</a>
                </div>
            </div>
        </div>
        <?php endfor; ?>
    </div>
</div>