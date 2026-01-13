<div class="container-fluid p-4">

    <div class="row mb-3">
        <div class="col">
            <h4 class="fw-bold">
                <i class="bi bi-clipboard-check me-2 text-primary"></i>
                Assign Task to Student
            </h4>
        </div>
    </div>

    <form method="post" enctype="multipart/form-data">

        <!-- ================= BASIC INFO ================= -->
        <div class="card mb-3">
            <div class="card-header fw-bold">
                <i class="bi bi-info-circle me-1"></i> Task Information
            </div>

            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Task Title</label>
                        <input type="text" class="form-control" placeholder="Enter task title" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Subject / Course</label>
                        <select class="form-select" required>
                            <option value="">Select subject</option>
                            <option>Mathematics</option>
                            <option>Science</option>
                            <option>English</option>
                        </select>
                    </div>
                </div>

            </div>
        </div>

        <!-- ================= TASK DESCRIPTION ================= -->
        <div class="card mb-3">
            <div class="card-header fw-bold">
                <i class="bi bi-textarea-t me-1"></i> Task Description
            </div>

            <div class="card-body">

                <!-- Formatting Toolbar -->
                <div class="btn-toolbar mb-2" role="toolbar">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-type-bold"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-type-italic"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-type-underline"></i>
                        </button>
                    </div>

                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-list-ul"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-list-ol"></i>
                        </button>
                    </div>

                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-link-45deg"></i>
                        </button>
                    </div>
                </div>

                <textarea class="form-control" rows="6" placeholder="Write task details, instructions, references..." required></textarea>

            </div>
        </div>

        <!-- ================= ATTACHMENTS ================= -->
        <div class="card mb-3">
            <div class="card-header fw-bold">
                <i class="bi bi-paperclip me-1"></i> Attachments & Resources
            </div>

            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Upload Files</label>
                        <input type="file" class="form-control" multiple>
                        <div class="form-text">PDF, DOC, Images allowed</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Reference Link</label>
                        <input type="url" class="form-control" placeholder="https://example.com">
                    </div>
                </div>

            </div>
        </div>

        <!-- ================= DATES ================= -->
        <div class="card mb-3">
            <div class="card-header fw-bold">
                <i class="bi bi-calendar-event me-1"></i> Schedule
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Starting Date</label>
                        <input type="date" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Deadline / Ending Date</label>
                        <input type="date" class="form-control" required>
                    </div>
                </div>

            </div>
        </div>

        <!-- ================= MARKS ================= -->
        <div class="card mb-3">
            <div class="card-header fw-bold">
                <i class="bi bi-award me-1"></i> Marks & Evaluation
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Total Marks</label>
                        <input type="number" class="form-control" placeholder="100" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Passing Marks</label>
                        <input type="number" class="form-control" placeholder="40" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Weightage (%)</label>
                        <input type="number" class="form-control" placeholder="10">
                    </div>
                </div>

            </div>
        </div>

        <!-- ================= ACTIONS ================= -->
        <div class="text-end">
            <button type="reset" class="btn btn-secondary me-2">
                <i class="bi bi-x-circle"></i> Reset
            </button>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-send-check"></i> Assign Task
            </button>
        </div>

    </form>

</div>