<div class="p-4">

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

<script>
  let reportData = [];
  let reportPeriod = null;
  let reportTitle = '';
  let reportFilters = {};

  $(document).ready(function() {

    $(document).on('submit', '.searchFilterForm', function(e) {

      e.preventDefault();

      const form = $(this);

      $('#btnGenerate').prop('disabled', true);
      $('#attendanceRows').html('<tr><td colspan="5">Loading...</td></tr>');
      $('.btnPdf').addClass('d-none');

      $.ajax({
        url: form.attr('action'),
        type: "POST",
        dataType: "json", // ✅ Force JSON
        data: form.serialize(),
        success: function(resp) {

          $('#btnGenerate').prop('disabled', false);

          if (!resp || resp.status !== true || resp.count <= 0) {
            $('#attendanceRows').html('<tr><td colspan="5">No record found.</td></tr>');
            Swal.fire('Error', 'No record found.', 'error');
            return;
          }

          // ✅ Store data for PDF
          reportData = resp.rows;
          reportPeriod = resp.period;
          reportTitle = 'STUDENT ATTENDANCE REPORT';

          // ✅ Store filter values safely
          reportFilters = {
            className: form.find('[name="className"]').val() || '',
            sectionName: form.find('[name="sectionName"]').val() || ''
          };

          let html = '';

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

          $('#attendanceRows').html(html);
          $('.btnPdf').removeClass('d-none');
        },
        error: function(xhr) {
          $('#btnGenerate').prop('disabled', false);
          $('#attendanceRows').html('<tr><td colspan="5">Error loading data.</td></tr>');
          console.log(xhr.responseText);
          Swal.fire('Server Error', 'Request failed.', 'error');
        }
      });

    });

    // ✅ Export PDF using stored data
    $('.btnPdf').on('click', function() {

      if (!reportData.length) {
        Swal.fire('Error', 'Generate report first.', 'error');
        return;
      }

      $.ajax({
        url: "<?= site_url('reports/student_attendance_report_pdf') ?>",
        type: "POST",
        data: {
          rows: JSON.stringify(reportData),
          period: JSON.stringify(reportPeriod),
          title: reportTitle,
          filters: JSON.stringify(reportFilters)
        },
        xhrFields: {
          responseType: 'blob'
        },
        success: function(blob) {
          const url = window.URL.createObjectURL(blob);
          window.open(url);
        },
        error: function() {
          Swal.fire('Error', 'PDF generation failed.', 'error');
        }
      });

    });

    function escapeHtml(text) {
      if (!text) return '';
      return String(text)
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", "&#039;");
    }

  });
</script>