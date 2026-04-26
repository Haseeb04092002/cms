<div class="p-4">
    <div class="card">
        <div class="card-header bg-success text-white">
            <strong>Create Online Class</strong>
        </div>
        <div class="card-body">

            <form id="saveOnlineClassForm" data-parsley-validate>

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Class Title</label>
                        <input type="text"
                            name="title"
                            class="form-control"
                            placeholder="Mathematics Live Class"
                            required
                            data-parsley-required="true">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Meeting Date</label>
                        <input type="date"
                            name="meetingDate"
                            class="form-control"
                            required
                            data-parsley-required="true">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Teacher</label>
                        <select name="teacherId"
                            class="form-select"
                            required
                            data-parsley-required="true">

                            <option value="">Select Teacher</option>

                            <?php foreach ($teachers as $t): ?>
                                <option value="<?= $t->staffId ?>">
                                    <?= htmlspecialchars($t->firstName) ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Class</label>
                        <select name="classId"
                            class="form-select"
                            required
                            data-parsley-required="true">

                            <option value="">Select Class</option>

                            <?php foreach ($all_classes as $c): ?>
                                <option value="<?= $c->classId ?>">
                                    <?= htmlspecialchars(($c->className ?? '') . ' ' . ($c->sectionName ?? '')) ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Section ID</label>
                        <input type="number"
                            name="sectionId"
                            class="form-control"
                            placeholder="Optional">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Start Time</label>
                        <input type="time"
                            name="startTime"
                            class="form-control"
                            required
                            data-parsley-required="true">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">End Time</label>
                        <input type="time"
                            name="endTime"
                            class="form-control">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Class Notes</label>
                        <textarea name="classNotes"
                            class="form-control"
                            rows="4"
                            placeholder="Lecture details, chapter, homework instructions etc."></textarea>
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success">
                            Save Online Class
                        </button>

                        <a href="<?= site_url('online-class') ?>" class="btn btn-secondary">
                            Back
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

</div>


<script>
    $(document).ready(function() {

        var form = $('#saveOnlineClassForm');

        form.parsley();

        form.on('submit', function(e) {

            e.preventDefault();

            if (!form.parsley().isValid()) {
                return;
            }

            $.ajax({

                url: "<?= site_url('OnlineClass/save') ?>",
                type: "POST",
                data: form.serialize(),
                dataType: "json",

                beforeSend: function() {
                    form.find('button[type=submit]').prop('disabled', true);
                },

                success: function(res) {

                    if (res.status == true) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
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

                }

            });

        });
        

    });
</script>