<div class="p-4">

  <!-- ================= KPI CARDS ================= -->
  <div class="row g-3 mb-3">

    <div class="col-6 col-lg-2">
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="text-muted small">Students</div>
          <div class="fs-4 fw-bold">2480</div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-2">
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="text-muted small">Admissions</div>
          <div class="fs-4 fw-bold">420</div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-2">
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="text-muted small">Classes</div>
          <div class="fs-4 fw-bold">48</div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-2">
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="text-muted small">Fees Paid</div>
          <div class="fs-4 fw-bold text-success">₨ 4.2M</div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-2">
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="text-muted small">Fee Dues</div>
          <div class="fs-4 fw-bold text-danger">₨ 1.1M</div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-2">
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="text-muted small">Expenses</div>
          <div class="fs-4 fw-bold">₨ 1.9M</div>
        </div>
      </div>
    </div>

  </div>

  <!-- ================= STATUS ROW ================= -->
  <div class="row g-3 mb-3">

    <div class="col-lg-3 col-md-6 col-12">
      <div class="card shadow-sm">
        <div class="card-body">
          <h6 class="fw-bold">Student Tasks</h6>
          <ul class="list-group list-group-flush small">
            <li class="list-group-item d-flex justify-content-between">Pending <span class="badge bg-warning">34</span></li>
            <li class="list-group-item d-flex justify-content-between">In Progress <span class="badge bg-primary">21</span></li>
            <li class="list-group-item d-flex justify-content-between">Completed <span class="badge bg-success">128</span></li>
            <li class="list-group-item d-flex justify-content-between">Overdue <span class="badge bg-danger">7</span></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 col-12">
      <div class="card shadow-sm">
        <div class="card-body">
          <h6 class="fw-bold">Exams & Results</h6>
          <ul class="list-group list-group-flush small">
            <li class="list-group-item d-flex justify-content-between">Scheduled <span class="badge bg-info">6</span></li>
            <li class="list-group-item d-flex justify-content-between">Ongoing <span class="badge bg-primary">2</span></li>
            <li class="list-group-item d-flex justify-content-between">Completed <span class="badge bg-success">14</span></li>
            <li class="list-group-item d-flex justify-content-between">Results Published <span class="badge bg-dark">10</span></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 col-12">
      <div class="card shadow-sm">
        <div class="card-body">
          <h6 class="fw-bold">Attendance</h6>
          <ul class="list-group list-group-flush small">
            <li class="list-group-item d-flex justify-content-between">Present <span class="badge bg-success">93%</span></li>
            <li class="list-group-item d-flex justify-content-between">Absent <span class="badge bg-danger">5%</span></li>
            <li class="list-group-item d-flex justify-content-between">Late <span class="badge bg-warning">2%</span></li>
            <li class="list-group-item d-flex justify-content-between">Defaulters <span class="badge bg-dark">84</span></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 col-12">
      <div class="card shadow-sm">
        <div class="card-body">
          <h6 class="fw-bold">Parents Messages</h6>
          <ul class="list-group list-group-flush small">
            <li class="list-group-item d-flex justify-content-between">Unread <span class="badge bg-danger">18</span></li>
            <li class="list-group-item d-flex justify-content-between">Open <span class="badge bg-warning">12</span></li>
            <li class="list-group-item d-flex justify-content-between">In Progress <span class="badge bg-primary">9</span></li>
            <li class="list-group-item d-flex justify-content-between">Resolved <span class="badge bg-success">146</span></li>
          </ul>
        </div>
      </div>
    </div>

  </div>

  <!-- ================= GRAPHS ================= -->
  <div class="row g-3">

    <div class="col-lg-6 col-12">
      <div class="card shadow-sm">
        <div class="card-body">
          <h6 class="fw-bold">Admissions Trend</h6>
          <canvas id="admissionChart"></canvas>
        </div>
      </div>
    </div>

    <div class="col-lg-6 col-12">
      <div class="card shadow-sm">
        <div class="card-body">
          <h6 class="fw-bold">Fees vs Expenses</h6>
          <canvas id="financeChart"></canvas>
        </div>
      </div>
    </div>

    <div class="col-lg-6 col-12">
      <div class="card shadow-sm">
        <div class="card-body">
          <h6 class="fw-bold">Student Tasks Distribution</h6>
          <canvas id="tasksChart"></canvas>
        </div>
      </div>
    </div>

    <div class="col-lg-6 col-12">
      <div class="card shadow-sm">
        <div class="card-body">
          <h6 class="fw-bold">Attendance Trend</h6>
          <canvas id="attendanceChart"></canvas>
        </div>
      </div>
    </div>

  </div>

</div>

<script>
  new Chart(document.getElementById('admissionChart'), {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
      datasets: [{
        label: 'Admissions',
        data: [120, 180, 260, 310, 380, 420],
        fill: false,
        tension: 0.3
      }]
    }
  });

  new Chart(document.getElementById('financeChart'), {
    type: 'bar',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
      datasets: [{
          label: 'Fees',
          data: [600, 700, 850, 900, 980, 1100]
        },
        {
          label: 'Expenses',
          data: [300, 350, 420, 460, 500, 540]
        }
      ]
    }
  });

  new Chart(document.getElementById('tasksChart'), {
    type: 'doughnut',
    data: {
      labels: ['Pending', 'In Progress', 'Completed', 'Overdue'],
      datasets: [{
        data: [34, 21, 128, 7]
      }]
    }
  });

  new Chart(document.getElementById('attendanceChart'), {
    type: 'line',
    data: {
      labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
      datasets: [{
        label: 'Attendance %',
        data: [91, 93, 94, 92, 95, 90],
        fill: false,
        tension: 0.3
      }]
    }
  });
</script>

<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->