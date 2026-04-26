<div class="p-4">

    <div class="card">
        <div class="card-body">
            <form id="FilterForm" class="row g-2 mb-3">

                <div class="col-md-4">
                    <select name="batchYear" class="form-select" required>
                        <option value="">Select Batch Year</option>
                        <?php for ($y = 2000; $y <= 2013; $y++): ?>
                            <option value="<?= $y ?>"><?= $y ?></option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <select name="classId" class="form-select" required>
                        <option value="">Select Class</option>
                        <?php foreach ($classes as $c): ?>
                            <option value="<?= $c->classId ?>">
                                <?= htmlspecialchars($c->className) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-dark w-100">Load</button>
                </div>

            </form>

            <div id="StructureResult"></div>
        </div>
    </div>


</div>

<script>
    $(document).off('submit', '#FilterForm').on('submit', '#FilterForm', function(e) {

        e.preventDefault();

        let form = $(this);

        $.ajax({
            url: "<?= site_url('Fee/structure_filter') ?>",
            type: "POST",
            data: form.serialize(),
            dataType: "json",
            success: function(res) {

                if (res.status) {
                    $('#StructureResult').html(res.html);
                }
            }
        });

    });

    $(document).off('submit', '#FormSaveStructure').on('submit', '#FormSaveStructure', function(e) {

        e.preventDefault();

        let form = $(this);

        $.ajax({
            url: "<?= site_url('Fee/save_structure') ?>",
            type: "POST",
            data: form.serialize(),
            dataType: "json",
            success: function(res) {

                if (res.status) {

                    Swal.fire({
                        title: 'Success',
                        text: res.message,
                        icon: 'success',
                        timer: 2000
                    });

                } else {

                    Swal.fire({
                        title: 'Error',
                        text: res.message,
                        icon: 'error'
                    });

                }
            }
        });

    });
</script>