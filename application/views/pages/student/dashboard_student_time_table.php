<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="p-4 ">

    <div class="card border-dark shadow-sm">
        <div class="card-header bg-light fw-semibold text-center">
            Class Timetable
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center mb-0">

                <!-- HEADER -->
                <thead class="table-light">
                    <tr>
                        <th style="width:120px;">Period</th>
                        <?php foreach ($days as $d): ?>
                            <th><?= $d ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>

                <!-- BODY -->
                <tbody>
                    <?php if (!empty($periods)): ?>
                        <?php foreach ($periods as $pKey => $p): ?>
                            <tr>

                                <!-- PERIOD -->
                                <th class="bg-light">
                                    <div class="fw-semibold">#<?= $p['periodNo'] ?></div>
                                    <div class="small text-muted"><?= $p['time'] ?></div>
                                </th>

                                <!-- DAYS -->
                                <?php foreach ($days as $day): ?>
                                    <td>
                                        <?php if (isset($table[$p['periodNo']][$day])):
                                            $cell = $table[$p['periodNo']][$day];
                                        ?>
                                            <div class="fw-semibold">
                                                <?= htmlspecialchars($cell['subjectName']) ?>
                                            </div>
                                            <div class="small text-muted">
                                                <?= htmlspecialchars($cell['firstName'] . ' ' . $cell['lastName']) ?>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted small">—</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>

                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?= count($days) + 1 ?>" class="text-muted">
                                No timetable found
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>
    </div>

</div>