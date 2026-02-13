<div class="p-4">

  <!-- KPI -->
  <div class="row g-3 mb-3">
    <div class="col-lg-2 col-6">
      <div class="card">
        <div class="card-body">
          <div class="text-muted small">Students</div>
          <div class="fs-4 fw-bold"><?= $students_count ?? '' ?></div>
        </div>
      </div>
    </div>

    <div class="col-lg-2 col-6">
      <div class="card">
        <div class="card-body">
          <div class="text-muted small">Admissions</div>
          <div class="fs-4 fw-bold"><?= $admissions_count ?? '' ?></div>
        </div>
      </div>
    </div>

    <div class="col-lg-2 col-6">
      <div class="card">
        <div class="card-body">
          <div class="text-muted small">Classes</div>
          <div class="fs-4 fw-bold"><?= $classes_count ?? '' ?></div>
        </div>
      </div>
    </div>

    <div class="col-lg-2 col-6">
      <div class="card">
        <div class="card-body">
          <div class="text-muted small">Fees Paid</div>
          <div class="fs-4 fw-bold text-success"><?= $fees_paid ?? '' ?></div>
        </div>
      </div>
    </div>

    <div class="col-lg-2 col-6">
      <div class="card">
        <div class="card-body">
          <div class="text-muted small">Fee Dues</div>
          <div class="fs-4 fw-bold text-danger"><?= $fees_due ?? '' ?></div>
        </div>
      </div>
    </div>

    <div class="col-lg-2 col-6">
      <div class="card">
        <div class="card-body">
          <div class="text-muted small">Expenses</div>
          <div class="fs-4 fw-bold"><?= $expenses ?? '' ?></div>
        </div>
      </div>
    </div>
  </div>

  <!-- STATUS -->
  <div class="row g-3 mb-3">
    <?php if (isset($task_stats)): ?>
      <?php foreach ($task_stats as $k => $v): ?>
        <div class="col-lg-3 col-md-6">
          <div class="card">
            <div class="card-body">
              <h6><?= $k ?></h6>
              <span class="badge bg-dark"><?= $v ?></span>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
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