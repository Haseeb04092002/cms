<!-- <div class="report-box shadow-sm"> -->
<div class="p-4">
  <div class="d-flex justify-content-between mb-3">
    <h4 class="fw-bold">Attendance</h4>
    <!-- <div>
      <button class="btn btn-primary ms-2">Add New Class</button>
    </div> -->
  </div>
  <!-- <h5 class="mb-4 fw-semibold">Attendance Report</h5> -->

  <!-- Filters -->
  <div class="bg-white p-3 row g-3">
    <div class="col-md-3">
      <label class="form-label fw-medium">Select Type</label>
      <select class="form-select">
        <option>Student</option>
        <option>Class</option>
        <option>Staff</option>
      </select>
    </div>

    <div class="col-md-3">
      <label class="form-label fw-medium">Date</label>
      <input type="month" class="form-control" value="2026-01">
    </div>

    <div class="col-md-3">
      <label class="form-label fw-medium">Class</label>
      <select class="form-select">
        <option>Three</option>
        <option>Four</option>
        <option>Five</option>
      </select>
    </div>

    <div class="col-md-3">
      <label class="form-label fw-medium">Section</label>
      <select class="form-select">
        <option>A</option>
        <option>B</option>
      </select>
    </div>

    <div class="col-12 mt-2">
      <button class="btn btn-success px-4">
        <i class="bi bi-funnel"></i> Generate Report
      </button>
    </div>
  </div>

  <!-- Summary Section -->
  <div class="bg-white p-3 attendance-summary mt-4 text-center">
    <h6 class="fw-semibold">
      Attendance Type : Student » Year: 2026 Month: 01
    </h6>
    <p class="mb-1">
      Class : <strong>Three</strong>
      &nbsp; Section : <strong>A</strong>
    </p>
    <p class="small text-secondary">
      <strong>P:</strong> Present |
      <strong>A:</strong> Absent |
      <strong>L:</strong> Late |
      <strong>UN:</strong> Undefined
    </p>
  </div>

  <!-- Table -->
  <div class="bg-white p-3 table-responsive mt-3">
    <table class="table table-bordered align-middle">
      <thead class="table-light">
        <tr>
          <th style="min-width:160px">Name</th>

          <!-- Days 1 to 31 -->
          <!-- GENERATED DAYS -->
          <?php for ($i = 1; $i <= 31; $i++): ?>
            <th><?= $i ?></th>
          <?php endfor; ?>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Sarah Khan</td>

          <?php for ($i = 1; $i <= 31; $i++): ?>
            <td></td>
          <?php endfor; ?>
        </tr>
        <tr>
          <td>Sarah Khan</td>

          <?php for ($i = 1; $i <= 31; $i++): ?>
            <td></td>
          <?php endfor; ?>
        </tr>
        <tr>
          <td>Sarah Khan</td>

          <?php for ($i = 1; $i <= 31; $i++): ?>
            <td></td>
          <?php endfor; ?>
        </tr>
        <tr>
          <td>Sarah Khan</td>

          <?php for ($i = 1; $i <= 31; $i++): ?>
            <td></td>
          <?php endfor; ?>
        </tr>
        <tr>
          <td>Sarah Khan</td>

          <?php for ($i = 1; $i <= 31; $i++): ?>
            <td></td>
          <?php endfor; ?>
        </tr>
      </tbody>
    </table>
  </div>

</div>