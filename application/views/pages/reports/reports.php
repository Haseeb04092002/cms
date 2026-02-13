<div class="p-4">

  <h4 class="fw-semibold mb-4">
    <i class="bi bi-clipboard-data"></i> Student Reports Center
  </h4>

  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Student</button>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
      <div class="card mb-5">

        <div class="card-body">
          <h5 class="fw-semibold mb-3"><i class="bi bi-people"></i> Student Reports</h5>
          <form id="searchFilterForm" action="<?= site_url('Reports/ajax_generate_student_report') ?>">
            <div class="row g-3 mb-3">

              <div class="col-md-3">
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

              <div class="col-md-3">
                <label class="form-label">Report Type</label>
                <select class="form-select" name="reportType">
                  <option value="">-- Select Report --</option>
                  <option value="attendance">Attendance Report</option>
                  <option value="academic">Academic Report</option>
                  <option value="fee">Fee Report</option>
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

            </div>
            <button type="submit" class="btn btn-primary mb-3" id="btnGenerate">
              <i class="bi bi-funnel-fill"></i> Generate Report
            </button>

            <button type="button" class="btn btn-dark mb-3 d-none" id="btnPdf">
              <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </button>
          </form>


          <!-- RESULTS -->
          <h6 class="fw-bold mb-3">Results</h6>

          <div class="table-responsive">
            <table class="table table-bordered table-striped text-start">
              <thead class="table-dark">
                <tr>
                  <th>Student Name</th>
                  <th>Class</th>
                  <th>Section</th>
                  <th id="thPeriod">Time Period</th>
                  <th>Status / Value</th>
                </tr>
              </thead>

              <tbody id="tblRows">
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
    $(document).off('submit', '#searchFilterForm').on('submit', '#searchFilterForm', function(e) {

      e.preventDefault();

      const form = $(this);

      if (!form.parsley().validate()) {
        Swal.fire('Validation Error', 'Please fill required fields.', 'error');
        return;
      }

      $('#btnGenerate').prop('disabled', true);
      $('#tblRows').html('<tr><td colspan="4">Loading...</td></tr>');
      $('#btnPdf').addClass('d-none');
      lastPdfUrl = '';


      $.ajax({
        url: "<?= site_url('Reports/ajax_generate_student_report') ?>",
        type: "POST",
        dataType: "json",
        data: form.serialize(),
        success: function(resp) {
          $('#btnGenerate').prop('disabled', false);

          if (!resp || resp.status !== true) {
            Swal.fire('Error', (resp && resp.message) ? resp.message : 'Something went wrong.', 'error');
            $('#tblRows').html('<tr><td colspan="4">No record found.</td></tr>');
            return;
          }

          if (resp.count <= 0) {
            $('#tblRows').html('<tr><td colspan="4">No record found.</td></tr>');
            return;
          }

          // detect selected time
          const month = form.find('[name="month"]').val();
          const year = form.find('[name="year"]').val();

          const monthNames = {
            '01': 'January',
            '02': 'February',
            '03': 'March',
            '04': 'April',
            '05': 'May',
            '06': 'June',
            '07': 'July',
            '08': 'August',
            '09': 'September',
            '10': 'October',
            '11': 'November',
            '12': 'December'
          };

          let periodText = '';

          if (resp.period && resp.period.start && resp.period.end) {
            const start = new Date(resp.period.start);
            const end = new Date(resp.period.end);

            periodText =
              start.toLocaleDateString('en-GB', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
              }) +
              ' → ' +
              end.toLocaleDateString('en-GB', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
              });
          } else {
            periodText = 'No Date Range';
          }


          // update table header
          $('#thPeriod').text('Time Period');

          // build rows
          let html = '';
          $.each(resp.rows, function(i, r) {
            html += `<tr>
              <td>${escapeHtml(r.studentName)}</td>
              <td>${escapeHtml(r.className)}</td>
              <td>${escapeHtml(r.sectionName)}</td>
              <td>${periodText}</td>
              <td>${escapeHtml(r.value)}</td>
            </tr>`;
          });

          $('#tblRows').html(html);


          // show PDF button
          lastPdfUrl = resp.pdf_url || '';
          if (lastPdfUrl) {
            $('#btnPdf').removeClass('d-none');
          }
        },
        error: function() {
          $('#btnGenerate').prop('disabled', false);
          Swal.fire('Server Error', 'Request failed. Please try again.', 'error');
          $('#tblRows').html('<tr><td colspan="4">No record found.</td></tr>');
        }
      });

    });

    $('#btnPdf').on('click', function() {
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