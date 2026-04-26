
<div class="p-4">
    <div class="card-header bg-primary text-white">
        <strong>Teacher Online Classes</strong>
    </div>
    <div class="card-body">

        <?= $this->session->flashdata('msg'); ?>

        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Class</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th width="180">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($classes)): ?>
                        <?php $i = 1;
                        foreach ($classes as $row): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= htmlspecialchars($row->title) ?></td>
                                <td><?= htmlspecialchars(($row->className ?? '') . ' ' . ($row->sectionName ?? '')) ?></td>
                                <td><?= htmlspecialchars($row->meetingDate) ?></td>
                                <td><?= htmlspecialchars($row->startTime . ' - ' . $row->endTime) ?></td>
                                <td>
                                    <?php if ($row->status == 'Scheduled'): ?>
                                        <span class="badge bg-warning text-dark">Scheduled</span>
                                    <?php elseif ($row->status == 'Live'): ?>
                                        <span class="badge bg-success">Live</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Ended</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= site_url('online-class/live/' . $row->onlineClassId) ?>" class="btn btn-success btn-sm">Start</a>
                                    <a href="<?= site_url('online-class/end/' . $row->onlineClassId) ?>" class="btn btn-warning btn-sm">End</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No classes found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

</div>