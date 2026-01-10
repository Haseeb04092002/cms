<div class="p-4">

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0 fw-bold">Dashboard</h3>
    <!-- <div>
      <button class="btn btn-sm btn-outline-primary me-2"><i class="bi bi-share"></i> Share</button>
      <button class="btn btn-sm btn-primary"><i class="bi bi-plus-lg"></i> New</button>
    </div> -->
  </div>

  <!-- Stats row -->
  <div class="row g-3 mb-4">
    
    <div class="col-6 col-md-3">
      <div class="card card-hover">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div>
              <h6 class="text-muted mb-1">Students</h6>
              <h3 class="fw-bold">1,250</h3>
            </div>
            <i class="bi bi-people fs-2 text-primary"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-md-3">
      <div class="card card-hover">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div>
              <h6 class="text-muted mb-1">Teachers</h6>
              <h3 class="fw-bold">78</h3>
            </div>
            <i class="bi bi-person-badge fs-2 text-success"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-md-3">
      <div class="card card-hover">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div>
              <h6 class="text-muted mb-1">Fees Due</h6>
              <h3 class="fw-bold">$8,450</h3>
            </div>
            <i class="bi bi-cash-stack fs-2 text-warning"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-md-3">
      <div class="card card-hover">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div>
              <h6 class="text-muted mb-1">Attendance Today</h6>
              <h3 class="fw-bold">92%</h3>
            </div>
            <i class="bi bi-calendar-check fs-2 text-danger"></i>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Quick links -->
  <div class="row g-3">

    <div class="col-md-3">
      <a href="admission.html" class="card text-decoration-none text-dark">
        <div class="card-body text-center">
          <i class="bi bi-journal-plus fs-2 text-primary"></i>
          <div class="mt-2">Admissions</div>
        </div>
      </a>
    </div>

    <div class="col-md-3">
      <a href="attendance.html" class="card text-decoration-none text-dark">
        <div class="card-body text-center">
          <i class="bi bi-calendar-check fs-2 text-success"></i>
          <div class="mt-2">Attendance</div>
        </div>
      </a>
    </div>

    <div class="col-md-3">
      <a href="reports.html" class="card text-decoration-none text-dark">
        <div class="card-body text-center">
          <i class="bi bi-graph-up fs-2 text-warning"></i>
          <div class="mt-2">Reports</div>
        </div>
      </a>
    </div>

    <div class="col-md-3">
      <a href="lms.html" class="card text-decoration-none text-dark">
        <div class="card-body text-center">
          <i class="bi bi-book fs-2 text-danger"></i>
          <div class="mt-2">LMS</div>
        </div>
      </a>
    </div>

  </div>

  <!-- Charts and recent activity -->
  <div class="row g-4 mt-2">

    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title fw-bold">Weekly Attendance</h6>
          <canvas id="attendanceChart" height="120"></canvas>
        </div>
      </div>
    </div>

    <div class="col-lg-4 d-none">
      <div class="card">
        <div class="card-body">
          <h6 class="fw-bold">Recent Activity</h6>
          <ul class="list-unstyled small">
            <li class="py-2 border-bottom"><strong>John Doe</strong> applied for admission <span class="text-muted small d-block">10 minutes ago</span></li>
            <li class="py-2 border-bottom"><strong>Salary</strong> processed for staff <span class="text-muted small d-block">1 hour ago</span></li>
            <li class="py-2"><strong>Exam</strong> timetable updated <span class="text-muted small d-block">Yesterday</span></li>
          </ul>
        </div>
      </div>
    </div>

  </div>

</div>


<!-- Chart Script (AJAX safe) -->
<script>
  const ctx = document.getElementById('attendanceChart');
  if (ctx) {
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Mon','Tue','Wed','Thu','Fri','Sat'],
        datasets: [{
          label: 'Attendance %',
          data: [90,92,91,93,92,88],
          tension: .3,
          fill: true,
          backgroundColor: 'rgba(13,110,253,0.08)',
          borderColor: 'rgb(13,110,253)'
        }]
      },
      options: { 
        plugins: { legend: { display: false } }, 
        scales: { y: { beginAtZero: true, max: 100 } } 
      }
    });
  }
</script>
