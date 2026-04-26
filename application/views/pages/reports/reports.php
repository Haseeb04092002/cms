<div class="p-4">

  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance" type="button" role="tab" aria-controls="attendance" aria-selected="true">Attendance Report</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="academic-tab" data-bs-toggle="tab" data-bs-target="#academic" type="button" role="tab" aria-controls="academic" aria-selected="true">Academic Report</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="fee-tab" data-bs-toggle="tab" data-bs-target="#fee" type="button" role="tab" aria-controls="fee" aria-selected="true">Fee Report</button>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">

    <div class="tab-pane fade show active" id="attendance" role="tabpanel" aria-labelledby="attendance-tab">
      <div class="card mb-5">
        <div class="card-body">
          <form class="searchFilterForm" action="<?= site_url('Reports/ajax_generate_student_report/attendance') ?>">
            <div class="row g-3 mb-3">

              <div class="col-md-2">
                <label class="form-label">Class</label>
                <select class="form-select"
                  name="className">
                  <option value="">-- Select --</option>
                  <?php if (!empty($classes)): ?>
                    <?php foreach ($classes as $class): ?>
                      <option value="<?= $class->classId ?>">
                        <?= $class->className ?>
                      </option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>

              </div>

              <div class="col-md-2">
                <label class="form-label">Section</label>
                <select class="form-select"
                  name="sectionName">
                  <option value="">-- Select --</option>
                  <?php if (!empty($classes)): ?>
                    <?php foreach ($classes as $class): ?>
                      <option value="<?= $class->classId ?>">
                        <?= $class->sectionName ?>
                      </option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </div>

              <div class="col-md-2">
                <label class="form-label">Month</label>
                <select class="form-select" name="month">
                  <option value="">-- Select Month --</option>
                  <option value="01">January</option>
                  <option value="02">February</option>
                  <option value="03">March</option>
                  <option value="04">April</option>
                  <option value="05">May</option>
                  <option value="06">June</option>
                  <option value="07">July</option>
                  <option value="08">August</option>
                  <option value="09">September</option>
                  <option value="10">October</option>
                  <option value="11">November</option>
                  <option value="12">December</option>
                </select>
              </div>

              <div class="col-md-2">
                <label class="form-label">Batch Year</label>
                <select class="form-select" name="year">
                  <option value="">-- Select Year --</option>
                  <?php
                  for ($y = 2000; $y <= 2050; $y++) {
                    echo "<option value='$y'>$y</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="col-md-2">
                <label class="form-label">Start Date</label>
                <input type="date" name="startDate" class="form-control">
              </div>

              <div class="col-md-2">
                <label class="form-label">End Date</label>
                <input type="date" name="endDate" class="form-control">
              </div>

            </div>
            <button type="submit" class="btn btn-primary mb-3" id="btnGenerate">
              <i class="bi bi-funnel-fill"></i> Generate Report
            </button>

            <button type="button" class="btn btn-dark mb-3 d-none btnPdf" id="">
              <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </button>
          </form>
          <h6 class="fw-bold mb-3">Results</h6>
          <div class="table-responsive">
            <table class="table table-bordered table-striped text-start">
              <thead class="table-dark" id="attendanceHead">
                <tr>
                  <th>Student Name</th>
                  <th>Class</th>
                  <th>Section</th>
                  <th id="thPeriod">Time Period</th>
                  <th>Status / Value</th>
                </tr>
              </thead>

              <tbody id="attendanceRows">
                <tr>
                  <td colspan="5">Apply filters and click Generate Report.</td>
                </tr>
              </tbody>
            </table>

          </div>

        </div>
      </div>
    </div>



    <div class="tab-pane fade" id="academic" role="tabpanel" aria-labelledby="academic-tab">
      <div class="card mb-5">

        <div class="card-body">
          <form class="searchFilterForm" action="<?= site_url('Reports/ajax_generate_student_report/academic') ?>">
            <div class="row g-3 mb-3">

              <div class="col-md-2">
                <label class="form-label">Class</label>
                <select class="form-select"
                  name="className">
                  <option value="">-- Select --</option>
                  <?php if (!empty($classes)): ?>
                    <?php foreach ($classes as $class): ?>
                      <option value="<?= $class->classId ?>">
                        <?= $class->className ?>
                      </option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>

              </div>

              <div class="col-md-2">
                <label class="form-label">Section</label>
                <select class="form-select"
                  name="sectionName">
                  <option value="">-- Select --</option>
                  <?php if (!empty($classes)): ?>
                    <?php foreach ($classes as $class): ?>
                      <option value="<?= $class->classId ?>">
                        <?= $class->sectionName ?>
                      </option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </div>

              <div class="col-md-2">
                <label class="form-label">Month</label>
                <select class="form-select" name="month">
                  <option value="">-- Select Month --</option>
                  <option value="01">January</option>
                  <option value="02">February</option>
                  <option value="03">March</option>
                  <option value="04">April</option>
                  <option value="05">May</option>
                  <option value="06">June</option>
                  <option value="07">July</option>
                  <option value="08">August</option>
                  <option value="09">September</option>
                  <option value="10">October</option>
                  <option value="11">November</option>
                  <option value="12">December</option>
                </select>
              </div>

              <div class="col-md-2">
                <label class="form-label">Year</label>
                <select class="form-select" name="year">
                  <option value="">-- Select Year --</option>
                  <?php
                  for ($y = 2000; $y <= 2050; $y++) {
                    echo "<option value='$y'>$y</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="col-md-2">
                <label class="form-label">Start Date</label>
                <input type="date" name="startDate" class="form-control">
              </div>

              <div class="col-md-2">
                <label class="form-label">End Date</label>
                <input type="date" name="endDate" class="form-control">
              </div>

            </div>
            <button type="submit" class="btn btn-primary mb-3" id="btnGenerate">
              <i class="bi bi-funnel-fill"></i> Generate Report
            </button>

            <button type="button" class="btn btn-dark mb-3 d-none btnPdf" id="">
              <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </button>
          </form>
          <h6 class="fw-bold mb-3">Results</h6>
          <div class="table-responsive">
            <table class="table table-bordered table-striped text-start">
              <thead class="table-dark" id="academicHead">
                <tr>
                  <th>Student Name</th>
                  <th>Class</th>
                  <th>Section</th>
                  <th>Exam</th>
                  <th>Exam Date</th>
                  <th>Total Marks</th>
                  <th>Obtained Marks</th>
                  <th>Status</th>
                </tr>
              </thead>

              <tbody id="academicRows">
                <tr>
                  <td colspan="5">Apply filters and click Generate Report.</td>
                </tr>
              </tbody>
            </table>

          </div>

        </div>
      </div>
    </div>



    <div class="tab-pane fade" id="fee" role="tabpanel" aria-labelledby="fee-tab">
      <div class="card mb-5">

        <div class="card-body">
          <form class="searchFilterForm" action="<?= site_url('Reports/ajax_generate_student_report/fee') ?>">
            <div class="row g-3 mb-3">

              <div class="col-md-2">
                <label class="form-label">Class</label>
                <select class="form-select"
                  name="className">
                  <option value="">-- Select --</option>
                  <?php if (!empty($classes)): ?>
                    <?php foreach ($classes as $class): ?>
                      <option value="<?= $class->classId ?>">
                        <?= $class->className ?>
                      </option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>

              </div>

              <div class="col-md-2">
                <label class="form-label">Section</label>
                <select class="form-select"
                  name="sectionName">
                  <option value="">-- Select --</option>
                  <?php if (!empty($classes)): ?>
                    <?php foreach ($classes as $class): ?>
                      <option value="<?= $class->classId ?>">
                        <?= $class->sectionName ?>
                      </option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </div>

              <div class="col-md-2">
                <label class="form-label">Month</label>
                <select class="form-select" name="month">
                  <option value="">-- Select Month --</option>
                  <option value="01">January</option>
                  <option value="02">February</option>
                  <option value="03">March</option>
                  <option value="04">April</option>
                  <option value="05">May</option>
                  <option value="06">June</option>
                  <option value="07">July</option>
                  <option value="08">August</option>
                  <option value="09">September</option>
                  <option value="10">October</option>
                  <option value="11">November</option>
                  <option value="12">December</option>
                </select>
              </div>

              <div class="col-md-2">
                <label class="form-label">Year</label>
                <select class="form-select" name="year">
                  <option value="">-- Select Year --</option>
                  <?php
                  for ($y = 2000; $y <= 2050; $y++) {
                    echo "<option value='$y'>$y</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="col-md-2">
                <label class="form-label">Start Date</label>
                <input type="date" name="startDate" class="form-control">
              </div>

              <div class="col-md-2">
                <label class="form-label">End Date</label>
                <input type="date" name="endDate" class="form-control">
              </div>

            </div>
            <button type="submit" class="btn btn-primary mb-3" id="btnGenerate">
              <i class="bi bi-funnel-fill"></i> Generate Report
            </button>
            <button type="button" class="btn btn-dark mb-3 d-none btnPdf" id="">
              <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </button>
          </form>
          <h6 class="fw-bold mb-3">Results</h6>
          <div class="table-responsive">
            <table class="table table-bordered table-striped text-start">
              <thead class="table-dark" id="feeHead">
                <tr>
                  <th>Student Name</th>
                  <th>Class</th>
                  <th>Section</th>
                  <th>Fee Type</th>
                  <th>Total</th>
                  <th>Discount</th>
                  <th>Paid</th>
                  <th>Paid Date</th>
                  <th>Balance</th>
                </tr>
              </thead>

              <tbody id="feeRows">
                <tr>
                  <td colspan="5">Apply filters and click Generate Report.</td>
                </tr>
              </tbody>
            </table>

          </div>

        </div>
      </div>
    </div>

  </div>


</div>

<script>
  $(document).ready(function() {

    $('#frmReport').parsley();

    let lastPdfUrl = '';
    $(document).off('submit', '.searchFilterForm').on('submit', '.searchFilterForm', function(e) {

      e.preventDefault();

      const form = $(this);

      if (!form.parsley().validate()) {
        Swal.fire('Validation Error', 'Please fill required fields.', 'error');
        return;
      }

      $('#btnGenerate').prop('disabled', true);
      $('#tblRows').html('<tr><td colspan="4">Loading...</td></tr>');
      $('.btnPdf').addClass('d-none');
      lastPdfUrl = '';

      $.ajax({
        url: form.attr('action'),
        type: "POST",
        dataType: "json",
        data: form.serialize(),
        success: function(resp) {

          let actionUrl = form.attr('action');
          let reportType = '';

          if (actionUrl.includes('attendance')) {
            reportType = 'attendance';
          } else if (actionUrl.includes('academic')) {
            reportType = 'academic';
          } else if (actionUrl.includes('fee')) {
            reportType = 'fee';
          }

          $('#btnGenerate').prop('disabled', false);

          if (!resp || resp.status !== true || resp.count <= 0) {
            Swal.fire('Error', 'No record found.', 'error');
            return;
          }

          let html = '';
          let headerHtml = '';

          /* ================= ATTENDANCE ================= */
          if (reportType === 'attendance') {

            headerHtml = `
              <tr>
                <th>Student Name</th>
                <th>Class</th>
                <th>Section</th>
                <th>Time Period</th>
                <th>Status / Value</th>
              </tr>
            `;

            $.each(resp.rows, function(i, r) {
              html += `
                <tr>
                  <td>${escapeHtml(r.studentName)}</td>
                  <td>${escapeHtml(r.className)}</td>
                  <td>${escapeHtml(r.sectionName)}</td>
                  <td>${resp.period.start} → ${resp.period.end}</td>
                  <td>${escapeHtml(r.value)}</td>
                </tr>
              `;
            });

            $('#attendanceHead').html(headerHtml);
            $('#attendanceRows').html(html);
          }

          /* ================= ACADEMIC ================= */
          if (reportType === 'academic') {

            headerHtml = `
              <tr>
                <th>Student Name</th>
                <th>Class</th>
                <th>Section</th>
                <th>Exam</th>
                <th>Exam Date</th>
                <th>Total Marks</th>
                <th>Obtained Marks</th>
                <th>Status</th>
              </tr>
            `;

            $.each(resp.rows, function(i, r) {

              let total = parseFloat(r.totalMarks || 0);
              let obtained = parseFloat(r.obtainedMarks || 0);
              let percentage = total > 0 ? ((obtained / total) * 100).toFixed(1) : 0;
              let status = percentage >= 40 ? 'Pass' : 'Fail';

              html += `
                <tr>
                  <td>${escapeHtml(r.studentName)}</td>
                  <td>${escapeHtml(r.className)}</td>
                  <td>${escapeHtml(r.sectionName)}</td>
                  <td>${escapeHtml(r.examName)}</td>
                  <td>${escapeHtml(r.examDate)}</td>
                  <td>${total}</td>
                  <td>${obtained}</td>
                  <td>${status} (${percentage}%)</td>
                </tr>
              `;
            });

            $('#academicHead').html(headerHtml);
            $('#academicRows').html(html);
          }

          if (reportType === 'fee') {

            headerHtml = `
              <tr>
                <th>Student Name</th>
                <th>Class</th>
                <th>Section</th>
                <th>Fee Type</th>
                <th>Total</th>
                <th>Discount</th>
                <th>Paid</th>
                <th>Paid Date</th>
                <th>Balance</th>
              </tr>
            `;

            $.each(resp.rows, function(i, r) {

              html += `
                <tr>
                  <td>${escapeHtml(r.studentName)}</td>
                  <td>${escapeHtml(r.className)}</td>
                  <td>${escapeHtml(r.sectionName)}</td>
                  <td>${escapeHtml(r.feeType)}</td>
                  <td>${parseFloat(r.originalAmount || 0).toFixed(2)}</td>
                  <td>${parseFloat(r.discountAmount || 0).toFixed(2)}</td>
                  <td>${parseFloat(r.paidAmount || 0).toFixed(2)}</td>
                  <td>${escapeHtml(r.paymentDate || '')}</td>
                  <td>${parseFloat(r.balance || 0).toFixed(2)}</td>
                </tr>
              `;
            });

            $('#feeHead').html(headerHtml);
            $('#feeRows').html(html);
          }


          lastPdfUrl = resp.pdf_url || '';
          if (lastPdfUrl) {
            $('.btnPdf').removeClass('d-none');
          }

        },
        error: function() {
          $('#btnGenerate').prop('disabled', false);
          Swal.fire('Server Error', 'Request failed.', 'error');
        }
      });


    });

    $('.btnPdf').on('click', function() {
      if (!lastPdfUrl) {
        Swal.fire('Error', 'Generate report first to export PDF.', 'error');
        return;
      }
      window.open(lastPdfUrl, '_blank');
    });

    function escapeHtml(text) {
      if (text === null || text === undefined) return '';
      return String(text)
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", "&#039;");
    }

  });
</script>