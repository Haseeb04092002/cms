<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="p-4">

    <div class="card border-dark shadow-sm">

        <div class="card-header bg-light fw-semibold text-center">
            Class Exams Overview
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle text-center mb-0">

                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Exam Title</th>
                        <th>Subject</th>
                        <th>Type</th>
                        <th>Exam Date</th>
                        <th>Result Date</th>
                        <th>Duration</th>
                        <th>Total</th>
                        <th>Passing</th>
                        <th>Obtained</th>
                        <th>Status</th>
                        <th>Weightage</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($exams)): ?>
                        <?php $i = 1;
                        foreach ($exams as $e): ?>
                            <tr>

                                <td><?= $i++ ?></td>

                                <td class="fw-semibold">
                                    <?= htmlspecialchars($e['examTitle']) ?>
                                </td>

                                <td><?= htmlspecialchars($e['subjectName']) ?></td>

                                <td><?= htmlspecialchars($e['examType']) ?></td>

                                <td>
                                    <?= $e['examDate'] ? date('d-M-Y', strtotime($e['examDate'])) : '-' ?>
                                </td>

                                <td>
                                    <?= $e['resultDate'] ? date('d-M-Y', strtotime($e['resultDate'])) : '-' ?>
                                </td>

                                <td><?= htmlspecialchars($e['duration']) ?></td>

                                <td><?= (int)$e['totalMarks'] ?></td>

                                <td><?= (int)$e['passingMarks'] ?></td>

                                <td class="<?= $e['obtainedMarks'] < $e['passingMarks'] ? 'text-danger' : 'text-success' ?>">
                                    <?= (int)$e['obtainedMarks'] ?>
                                </td>

                                <td>
                                    <span class="badge bg-secondary">
                                        <?= htmlspecialchars($e['examStatus']) ?>
                                    </span>
                                </td>

                                <td><?= (float)$e['weightage'] ?>%</td>

                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="12" class="text-muted text-center">
                                No exams found for this class
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>

    </div>

</div>