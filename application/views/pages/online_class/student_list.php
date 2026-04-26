<div class="p-4">
    <div class="card">
        <div class="card-header bg-info text-dark">
            <strong>My Online Classes</strong>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Teacher</th>
                            <th>Class</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Notes</th>
                            <th>Status</th>
                            <th width="120">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($classes)): ?>
                            <?php $i = 1;
                            foreach ($classes as $row): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($row->title) ?></td>
                                    <td><?= htmlspecialchars($row->teacherName ?? '') ?></td>
                                    <td><?= htmlspecialchars(($row->className ?? '') . ' ' . ($row->sectionName ?? '')) ?></td>
                                    <td><?= htmlspecialchars($row->meetingDate) ?></td>
                                    <td><?= htmlspecialchars($row->startTime . ' - ' . $row->endTime) ?></td>
                                    <td><?= htmlspecialchars($row->classNotes ?? '') ?></td>
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
                                        <?php if ($row->status == 'Live'): ?>
                                            <a href="<?= site_url('online-class/join/' . $row->onlineClassId) ?>" class="btn btn-success btn-sm">Join</a>
                                        <?php elseif ($row->status == 'Scheduled'): ?>
                                            <button type="button" class="btn btn-secondary btn-sm" disabled>Wait</button>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-dark btn-sm" disabled>Closed</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center">No online class available for your class.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

</div>