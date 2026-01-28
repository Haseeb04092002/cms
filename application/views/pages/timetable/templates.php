<div class="p-4">
    <h3 class="fw-bold mb-4">Select any class to set time table</h3>

    <style>
        .timetable-circle {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            font-weight: 700;
            font-size: 18px;
            background: rgba(13, 110, 253, 0.1);
            border: 2px solid #0d6efd;
            color: #0d6efd;
        }

        .timetable-card {
            transition: 0.25s ease;
        }

        .timetable-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }
    </style>

    <div class="row g-3">

        <?php for ($i = 3; $i <= 14; $i++): ?>

            <div class="col-xl-3 col-lg-4 col-md-3 col-sm-6">
                <a href="<?= site_url('Timetable/all_classes/') . $i ?>" class="navigator text-decoration-none text-dark">

                    <div class="card h-100 shadow-sm border-0 timetable-card">
                        <div class="card-body text-center d-flex flex-column align-items-center justify-content-center">

                            <!-- Center Circle -->
                            <div class="timetable-circle mb-2">
                                <div class="fs-1"><?= $i ?></div>
                                <small class="fw-normal">Slots</small>
                            </div>

                            <!-- Bottom Label -->
                            <div class="fw-semibold text-secondary">Timetable</div>

                        </div>
                    </div>

                </a>
            </div>

        <?php endfor; ?>

    </div>

</div>