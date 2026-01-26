<div class="p-4">
    <h3 class="fw-bold mb-4 text-start">Time Table Chart</h3>

    <!-- Minimal Enhancement CSS -->
    <style>
        .table td,
        .table th {
            vertical-align: middle;
            padding: 0.5rem;
        }

        .table button.btn {
            border-radius: 0.5rem;
            transition: all 0.2s ease-in-out;
            border: 1px solid var(--bs-border-color);
        }

        .table button.btn:hover {
            background-color: var(--bs-light);
            transform: translateY(-1px);
            box-shadow: 0 .25rem .5rem rgba(0, 0, 0, .08);
        }

        .table thead button {
            font-weight: 600;
        }

        .table small {
            color: var(--bs-secondary);
        }

        .modal-header {
            background-color: var(--bs-light);
        }

        .modal-title {
            font-weight: 600;
        }
    </style>


    <div class="container-fluid">


        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">

                <!-- TIME HEADER -->
                <thead class="table-light">
                    <tr>
                        <th>Days</th>

                        <?php
                        $count = 1;
                        // print_r($timeTable);
                        // die();
                        foreach ($timeTable as $record):
                        ?>

                            <th>
                                <button class="btn btn-light w-100" data-bs-toggle="modal" data-bs-target="#timeModal">
                                    <div class="fw-bold">Lecture # <?= $count ?></div>
                                    <small><?= $timeTable->startTime ?? '' ?> – <?= $timeTable->endTime ?? '' ?></small>
                                </button>
                            </th>

                        <?php
                        $count++;
                        endforeach;
                        ?>

                    </tr>
                </thead>

                <!-- SUBJECT ROWS -->
                <tbody>

                    <?php foreach ($days as $record): ?>

                        <tr>
                            <th class="table-light"><?= $record??'' ?></th>

                            <td><button class="btn btn-light w-100" data-bs-toggle="modal" data-bs-target="#subjectModal"><strong>English</strong><br><small>Mr. Ali</small></button></td>
                            <td><button class="btn btn-light w-100" data-bs-toggle="modal" data-bs-target="#subjectModal"><strong>Maths</strong><br><small>Ms. Sana</small></button></td>
                            <td><button class="btn btn-light w-100" data-bs-toggle="modal" data-bs-target="#subjectModal"><strong>Computer</strong><br><small>Mr. Ahmed</small></button></td>
                            <td><button class="btn btn-light w-100" data-bs-toggle="modal" data-bs-target="#subjectModal"><strong>Physics</strong><br><small>Dr. Usman</small></button></td>
                            <td><button class="btn btn-light w-100" data-bs-toggle="modal" data-bs-target="#subjectModal"><strong>Urdu</strong><br><small>Ms. Fatima</small></button></td>
                        </tr>

                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>

    <!-- TIME MODAL -->
    <div class="modal fade" id="timeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Time Period</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Start Time</label>
                    <input type="time" class="form-control mb-3">
                    <label class="form-label">End Time</label>
                    <input type="time" class="form-control">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- SUBJECT MODAL -->
    <div class="modal fade" id="subjectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Subject</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Subject Name</label>
                    <input type="text" class="form-control mb-3">
                    <label class="form-label">Teacher Name</label>
                    <input type="text" class="form-control">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>



</div>