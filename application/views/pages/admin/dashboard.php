<style>
  /* ======================================
   MINIMAL CORPORATE ORANGE DASHBOARD
   Colors Used:
   Light Orange + White
====================================== */

  /* ===== KPI CARDS ===== */

  .dashboard-card {
    border: 1px solid #f1f1f1;
    border-radius: 14px;
    background: linear-gradient(135deg, #fff7ed 0%, #ffffff 70%);
    transition: all .25s ease;
    height: 100%;
    text-decoration: none;
  }

  /* .dashboard-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(255, 140, 0, 0.12);
    border-color: #ffe0cc;
  } */

  /* Small orange top accent line */
  .dashboard-card::before {
    content: '';
    display: block;
    height: 4px;
    width: 100%;
    background: linear-gradient(to right, #ffb067, #ff8c00);
    border-top-left-radius: 14px;
    border-top-right-radius: 14px;
    text-decoration: none;
  }

  /* KPI TEXT */
  .kpi-title {
    font-size: 13px;
    color: #6c757d;
    font-weight: 500;
  }

  .kpi-value {
    font-size: 24px;
    font-weight: 700;
    color: #ff8c00;
  }


  /* ===== FEATURE CARDS ===== */

  .feature-card {
    border: 1px solid #f1f1f1;
    border-radius: 16px;
    padding: 25px 15px;
    text-align: center;
    background: linear-gradient(135deg, #fff7ed 0%, #ffffff 75%);
    transition: all .25s ease;
    height: 100%;
    text-decoration: none;
  }

  /* .feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(255, 140, 0, 0.12);
    border-color: #ffd6b3;
  } */

  /* ICON */
  .feature-icon {
    font-size: 30px;
    margin-bottom: 10px;
    color: #ff8c00;
  }

  /* TITLE */
  .feature-title {
    font-size: 15px;
    font-weight: 600;
    color: #333;
  }
</style>


<div class="p-4">

  <!-- ================= KPI SECTION ================= -->
  <div class="h3 fw-bold">Overview</div>

  <div class="row g-3 mb-4">

    <div class="col-lg-2 col-md-4 col-6">
      <a href="<?= site_url('students') ?>" class="card-link navigator">
        <div class="card dashboard-card">
          <div class="card-body">
            <div class="kpi-title">Students</div>
            <div class="kpi-value"><?= $students_count ?? '0' ?></div>
          </div>
        </div>
      </a>
    </div>

    <div class="col-lg-2 col-md-4 col-6">
      <a href="<?= site_url('admissions') ?>" class="card-link navigator">
        <div class="card dashboard-card">
          <div class="card-body">
            <div class="kpi-title">Admissions</div>
            <div class="kpi-value"><?= $admissions_count ?? '0' ?></div>
          </div>
        </div>
      </a>
    </div>

    <div class="col-lg-2 col-md-4 col-6">
      <a href="<?= site_url('classes') ?>" class="card-link navigator">
        <div class="card dashboard-card">
          <div class="card-body">
            <div class="kpi-title">Classes</div>
            <div class="kpi-value"><?= $classes_count ?? '0' ?></div>
          </div>
        </div>
      </a>
    </div>

    <div class="col-lg-2 col-md-4 col-6">
      <a href="<?= site_url('fees') ?>" class="card-link navigator">
        <div class="card dashboard-card">
          <div class="card-body">
            <div class="kpi-title">Fees Paid</div>
            <div class="kpi-value text-success"><?= $fees_paid ?? '0' ?></div>
          </div>
        </div>
      </a>
    </div>

    <div class="col-lg-2 col-md-4 col-6">
      <a href="<?= site_url('fees/dues') ?>" class="card-link navigator">
        <div class="card dashboard-card">
          <div class="card-body">
            <div class="kpi-title">Fee Dues</div>
            <div class="kpi-value text-danger"><?= $fees_due ?? '0' ?></div>
          </div>
        </div>
      </a>
    </div>

    <div class="col-lg-2 col-md-4 col-6">
      <a href="<?= site_url('expenses') ?>" class="card-link navigator">
        <div class="card dashboard-card">
          <div class="card-body">
            <div class="kpi-title">Expenses</div>
            <div class="kpi-value"><?= $expenses ?? '0' ?></div>
          </div>
        </div>
      </a>
    </div>

  </div>


  <!-- ================= FEATURE CARDS ================= -->
  <div class="h3 fw-bold">Quick Access</div>

  <div class="row g-3 mb-4">

    <!-- Row 1 -->
    <div class="col-lg-3 col-md-6">
      <a href="<?= site_url('Student/admission_requests') ?>" class="card-link navigator">
        <div class="feature-card">
          <div class="feature-icon"><i class="bi bi-person-plus"></i></div>
          <div class="feature-title">Admission Requests</div>
        </div>
      </a>
    </div>

    <div class="col-lg-3 col-md-6">
      <a href="<?= site_url('Reports/reports') ?>" class="card-link navigator">
        <div class="feature-card">
          <div class="feature-icon"><i class="bi bi-bar-chart"></i></div>
          <div class="feature-title">Reports</div>
        </div>
      </a>
    </div>

    <div class="col-lg-3 col-md-6">
      <a href="<?= site_url('Chatting') ?>" class="card-link navigator">
        <div class="feature-card">
          <div class="feature-icon"><i class="bi bi-chat-dots"></i></div>
          <div class="feature-title">Chats</div>
        </div>
      </a>
    </div>

    <div class="col-lg-3 col-md-6">
      <a href="<?= site_url('Timetable/all_time_tables') ?>" class="card-link navigator">
        <div class="feature-card">
          <div class="feature-icon"><i class="bi bi-calendar-week"></i></div>
          <div class="feature-title">Time Tables</div>
        </div>
      </a>
    </div>

    <!-- Row 2 -->
    <div class="col-lg-3 col-md-6">
      <a href="<?= site_url('exam_calendar') ?>" class="card-link navigator">
        <div class="feature-card">
          <div class="feature-icon"><i class="bi bi-calendar-event"></i></div>
          <div class="feature-title">Exam Calendar</div>
        </div>
      </a>
    </div>

    <div class="col-lg-3 col-md-6">
      <a href="" class="card-link navigator">
        <div class="feature-card">
          <div class="feature-icon"><i class="bi bi-cash-stack"></i></div>
          <div class="feature-title">Fee Structures</div>
        </div>
      </a>
    </div>

    <div class="col-lg-3 col-md-6">
      <a href="<?= site_url('Tasks/task_assignment') ?>" class="card-link navigator">
        <div class="feature-card">
          <div class="feature-icon"><i class="bi bi-list-check"></i></div>
          <div class="feature-title">Student Tasks</div>
        </div>
      </a>
    </div>

    <div class="col-lg-3 col-md-6">
      <a href="<?= site_url('Classes/all_classes') ?>" class="card-link navigator">
        <div class="feature-card">
          <div class="feature-icon"><i class="bi bi-diagram-3"></i></div>
          <div class="feature-title">Classes & Sections</div>
        </div>
      </a>
    </div>

  </div>

</div>


<script>
  // declare chart variables globally (once)
  let admissionChart = null;
  let financeChart = null;
  let tasksChart = null;
  let attendanceChart = null;

  document.addEventListener("DOMContentLoaded", function() {

    /* ======================
       ADMISSION CHART
    ====================== */
    let admCanvas = document.getElementById('admissionChart');
    if (admCanvas) {

      if (admissionChart) {
        admissionChart.destroy();
      }

      admissionChart = new Chart(admCanvas, {
        type: 'line',
        data: {
          labels: <?= json_encode($admission_labels ?? []) ?>,
          datasets: [{
            label: 'Admissions',
            data: <?= json_encode($admission_data ?? []) ?>,
            fill: false,
            tension: 0.3
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false
        }
      });
    }

    /* ======================
       FINANCE CHART
    ====================== */
    const finCanvas = document.getElementById('financeChart');
    if (finCanvas) {

      if (financeChart) {
        financeChart.destroy();
      }

      financeChart = new Chart(finCanvas, {
        type: 'bar',
        data: {
          labels: <?= json_encode($finance_labels ?? []) ?>,
          datasets: [{
              label: 'Fees',
              data: <?= json_encode($fees_data ?? []) ?>
            },
            {
              label: 'Expenses',
              data: <?= json_encode($expense_data ?? []) ?>
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false
        }
      });
    }

    /* ======================
       TASKS CHART
    ====================== */
    const taskCanvas = document.getElementById('tasksChart');
    if (taskCanvas) {

      if (tasksChart) {
        tasksChart.destroy();
      }

      tasksChart = new Chart(taskCanvas, {
        type: 'doughnut',
        data: {
          labels: <?= json_encode(array_keys($task_stats ?? [])) ?>,
          datasets: [{
            data: <?= json_encode($task_chart ?? []) ?>
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false
        }
      });
    }

    /* ======================
       ATTENDANCE CHART
    ====================== */
    const attCanvas = document.getElementById('attendanceChart');
    if (attCanvas) {

      if (attendanceChart) {
        attendanceChart.destroy();
      }

      attendanceChart = new Chart(attCanvas, {
        type: 'line',
        data: {
          labels: <?= json_encode($att_labels ?? []) ?>,
          datasets: [{
            label: 'Attendance %',
            data: <?= json_encode($att_data ?? []) ?>,
            fill: false,
            tension: 0.3
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: {
              min: 0,
              max: 100
            }
          }
        }
      });
    }

  });
</script>