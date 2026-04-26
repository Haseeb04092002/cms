<div class="p-4">
    <div class="card">
        <div class="card-header bg-dark text-white">
            <strong>All Online Classes</strong>
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
                            <th>Teacher</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Room</th>
                            <th>Status</th>
                            <th width="220">Action</th>
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
                                    <td><?= htmlspecialchars($row->teacherName ?? '') ?></td>
                                    <td><?= date('d M Y', strtotime($row->meetingDate)) ?></td>
                                    <td>
                                        <?= htmlspecialchars(
                                            date('g:iA', strtotime($row->startTime)) . ' - ' . date('g:iA', strtotime($row->endTime))
                                        ) ?>
                                    </td>
                                    <td><small><?= htmlspecialchars($row->roomName) ?></small></td>
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
                                        <a href="<?= site_url('OnlineClass/go_live/' . $row->onlineClassId) ?>" target="_blank" class="btn btn-success btn-sm">Start</a>
                                        <a href="<?= site_url('OnlineClass/end/' . $row->onlineClassId) ?>" class="btn btn-warning btn-sm">End</a>
                                        <!-- <a href="<?= site_url('OnlineClass/delete/' . $row->onlineClassId) ?>" class="btn btn-danger btn-sm">Delete</a> -->
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $row->onlineClassId ?>">
                                            Delete
                                        </button>

                                        <!-- Delete Confirmation Modal -->
                                        <div class="modal fade" id="deleteModal<?= $row->onlineClassId ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">

                                                    <div class="modal-header bg-light">
                                                        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <form class="FormDeleteClass" data-parsley-validate>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete this item ?</p>
                                                            <input type="hidden" name="onlineClassId" value="<?= $row->onlineClassId ?>">
                                                            <div class="text-end">
                                                                <button class="btn btn-danger BtnDeleteClass" type="submit">Yes</button>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center">No online classes found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $(document).off('submit', '.FormDeleteClass').on('submit', '.FormDeleteClass', function(e) {

            e.preventDefault();

            let form = $(this);

            $.ajax({

                url: "<?= site_url('OnlineClass/delete') ?>",
                type: "POST",
                data: form.serialize(),
                dataType: "json",

                beforeSend: function() {
                    form.find('button').prop('disabled', true);
                },

                success: function(res) {

                    if (res.status) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });

                    } else {

                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning',
                            text: res.message
                        });

                    }

                },

                error: function(xhr) {

                    console.log(xhr.responseText);

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Server error'
                    });

                }

            });

        });
    });
</script>