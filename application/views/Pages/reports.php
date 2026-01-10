<div class="p-4">

  <!-- PAGE HEADER -->
  <h4 class="fw-semibold mb-4">
    <i class="bi bi-clipboard-data"></i> Reports Center
  </h4>

  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Student</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Teacher</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Finance</button>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
      <!-- =======================
         STUDENT REPORT SECTION
         ======================= -->
      <div class="card mb-5">
        <div class="card-body">
          <h5 class="fw-semibold mb-3"><i class="bi bi-people"></i> Student Reports</h5>

          <div class="row g-3 mb-3">

            <div class="col-md-3">
              <label class="form-label">Class</label>
              <select class="form-select">
                <option>All</option>
                <option>One</option>
                <option>Two</option>
                <option>Three</option>
              </select>
            </div>

            <div class="col-md-3">
              <label class="form-label">Section</label>
              <select class="form-select">
                <option>All</option>
                <option>A</option>
                <option>B</option>
              </select>
            </div>

            <div class="col-md-3">
              <label class="form-label">Report Type</label>
              <select class="form-select">
                <option>Attendance</option>
                <option>Grades</option>
                <option>Fee Status</option>
              </select>
            </div>

            <div class="col-md-3">
              <label class="form-label">Month</label>
              <input type="month" class="form-control">
            </div>

          </div>

          <button class="btn btn-primary mb-4">
            <i class="bi bi-funnel-fill"></i> Generate Report
          </button>

          <!-- RESULTS -->
          <h6 class="fw-bold mb-3">Results</h6>

          <div class="table-responsive">
            <table class="table table-bordered table-striped text-start">
              <thead class="table-dark">
                <tr>
                  <th>Student Name</th>
                  <th>Class</th>
                  <th>Section</th>
                  <th>Status / Value</th>
                </tr>
              </thead>

              <tbody>
                <tr>
                  <td>Ali Khan</td>
                  <td>3</td>
                  <td>A</td>
                  <td>Present</td>
                </tr>

                <tr>
                  <td>Hina Fatima</td>
                  <td>3</td>
                  <td>A</td>
                  <td>Absent</td>
                </tr>

                <tr>
                  <td>Usman Tariq</td>
                  <td>2</td>
                  <td>B</td>
                  <td>Present</td>
                </tr>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
      <!-- =======================
         TEACHER REPORT SECTION
         ======================= -->
      <div class="card mb-5">
        <div class="card-body">

          <h5 class="fw-semibold mb-3"><i class="bi bi-person-badge"></i> Teacher Reports</h5>

          <div class="row g-3 mb-3">

            <div class="col-md-4">
              <label class="form-label">Department</label>
              <select class="form-select">
                <option>All</option>
                <option>Science</option>
                <option>Math</option>
                <option>Computer</option>
                <option>English</option>
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label">Report Type</label>
              <select class="form-select">
                <option>Attendance</option>
                <option>Performance</option>
                <option>Salary</option>
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label">Month</label>
              <input type="month" class="form-control">
            </div>

          </div>

          <button class="btn btn-success mb-4">
            <i class="bi bi-funnel"></i> Generate Report
          </button>

          <!-- RESULTS -->
          <h6 class="fw-bold mb-3">Results</h6>

          <div class="table-responsive">
            <table class="table table-bordered table-striped text-start">
              <thead class="table-dark">
                <tr>
                  <th>Teacher Name</th>
                  <th>Department</th>
                  <th>Report Data</th>
                </tr>
              </thead>

              <tbody>
                <tr>
                  <td>Mr. Ahmed</td>
                  <td>Science</td>
                  <td>Present</td>
                </tr>

                <tr>
                  <td>Ms. Sara</td>
                  <td>Math</td>
                  <td>Late</td>
                </tr>

                <tr>
                  <td>Mr. Bilal</td>
                  <td>Computer</td>
                  <td>Present</td>
                </tr>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
      <!-- =======================
         FINANCE REPORT SECTION
         ======================= -->
      <div class="card mb-5">
        <div class="card-body">

          <h5 class="fw-semibold mb-3"><i class="bi bi-cash-coin"></i> Finance Reports</h5>

          <div class="row g-3 mb-3">

            <div class="col-md-4">
              <label class="form-label">Category</label>
              <select class="form-select">
                <option>Income</option>
                <option>Expense</option>
                <option>Profit / Loss</option>
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label">Start Date</label>
              <input type="date" class="form-control">
            </div>

            <div class="col-md-4">
              <label class="form-label">End Date</label>
              <input type="date" class="form-control">
            </div>

          </div>

          <button class="btn btn-warning mb-4">
            <i class="bi bi-funnel"></i> Generate Report
          </button>

          <!-- RESULTS -->
          <h6 class="fw-bold mb-3">Results</h6>

          <div class="table-responsive">
            <table class="table table-bordered table-striped text-start">
              <thead class="table-dark">
                <tr>
                  <th>Date</th>
                  <th>Description</th>
                  <th>Amount</th>
                  <th>Type</th>
                </tr>
              </thead>

              <tbody>
                <tr>
                  <td>2026-01-01</td>
                  <td>Fee Collection</td>
                  <td>50,000</td>
                  <td>Income</td>
                </tr>

                <tr>
                  <td>2026-01-03</td>
                  <td>Utility Bills</td>
                  <td>18,000</td>
                  <td>Expense</td>
                </tr>

                <tr>
                  <td>2026-01-05</td>
                  <td>Books & Supplies</td>
                  <td>7,500</td>
                  <td>Expense</td>
                </tr>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>

</div>