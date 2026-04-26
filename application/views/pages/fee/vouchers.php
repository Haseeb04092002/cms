<div class="card">
    <div class="card-body">
        <form method="post" class="row g-2">
            <div class="col-md-3">
                <label class="form-label">Month</label>
                <input type="month" name="month" class="form-control" value="<?= date('Y-m') ?>" required>
            </div>

            <div class="col-md-3">
                <label class="form-label">Batch</label>
                <select name="batch_id" class="form-select" required>
                    <option value="">Select</option>
                    <?php foreach ($batches as $b): ?>
                        <option value="<?= (int)$b->id ?>"><?= htmlspecialchars($b->name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Class</label>
                <select name="class_id" class="form-select" required>
                    <option value="">Select</option>
                    <?php foreach ($classes as $c): ?>
                        <option value="<?= (int)$c->id ?>"><?= htmlspecialchars($c->class_name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Issue Date</label>
                <input type="date" name="issue_date" class="form-control" value="<?= date('Y-m-d') ?>">
            </div>

            <div class="col-md-3">
                <label class="form-label">Due Date</label>
                <input type="date" name="due_date" class="form-control" value="<?= date('Y-m-10') ?>">
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-primary w-100" name="generate" value="1">Generate Challans</button>
            </div>
        </form>
    </div>
</div>