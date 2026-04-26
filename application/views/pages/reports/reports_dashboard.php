<?php
$UserId = '';
$UserName = '';
$UserEmail = '';
$UserRole = '';
$StationId = '';
$UserId = $this->session->userdata('user_id') ?? '';
$UserName = $this->session->userdata('user_name') ?? '';
$UserEmail = $this->session->userdata('user_email') ?? '';
$UserRole = $this->session->userdata('user_role') ?? '';
$UserRoleId = $this->session->userdata('user_role_id') ?? '';
$StationId = $this->session->userdata('station_id') ?? '';
?>

<style>
  /* ===== UNIFIED MODULE BUTTON STYLE ===== */

  .module-card {
    border: 1px solid transparent;
    border-radius: 12px;
    /* background: linear-gradient(135deg, #f4f7fb, #ffffff); */
    background: linear-gradient(135deg, #ddecff, #fff);
    transition: all 0.25s ease;
    cursor: pointer;
  }

  .module-card:hover {
    transform: translateY(-4px);
    border: 1px solid #0d6efd;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
  }
</style>


<div class="p-4">

  <!-- ================= STUDENT ================= -->
  <div class="card mb-4 border-0 shadow-lg">
    <div class="card-body">

      <div class="d-flex align-items-center mb-4">
        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
          style="width:50px;height:50px;">
          <i class="bi bi-mortarboard-fill fs-4"></i>
        </div>
        <h4 class="fw-bold mb-0">Student Reports</h4>
      </div>

      <div class="row g-3">

        <div class="col-md-4">
          <a href="<?= site_url('Reports/student_reports/attendance') ?>" class="navigator text-decoration-none">
            <div class="card border-primary shadow-sm h-100 text-center module-card">
              <div class="card-body">
                <i class="bi bi-clipboard-data fs-2 text-primary mb-3"></i>
                <h6 class="fw-semibold">Attendance Report</h6>
              </div>
            </div>
          </a>
        </div>

        <div class="col-md-4">
          <a href="<?= site_url('Reports/student_reports/academic') ?>" class="navigator text-decoration-none">
            <div class="card border-primary shadow-sm h-100 text-center module-card">
              <div class="card-body">
                <i class="bi bi-bar-chart-line fs-2 text-primary mb-3"></i>
                <h6 class="fw-semibold">Academic Report</h6>
              </div>
            </div>
          </a>
        </div>

        <div class="col-md-4">
          <a href="#" class="text-decoration-none">
            <div class="card border-primary shadow-sm h-100 text-center module-card">
              <div class="card-body">
                <i class="bi bi-award fs-2 text-primary mb-3"></i>
                <h6 class="fw-semibold">Fee Report</h6>
              </div>
            </div>
          </a>
        </div>

      </div>

    </div>
  </div>



  <!-- ================= TEACHER ================= -->
  <div class="card mb-4 border-0 shadow-lg">
    <div class="card-body">

      <div class="d-flex align-items-center mb-4">
        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
          style="width:50px;height:50px;">
          <i class="bi bi-person-workspace fs-4"></i>
        </div>
        <h4 class="fw-bold mb-0">Teacher Reports</h4>
      </div>

      <div class="row g-3">

        <div class="col-md-4">
          <a href="#" class="text-decoration-none">
            <div class="card border-primary shadow-sm h-100 text-center module-card">
              <div class="card-body">
                <i class="bi bi-calendar2-check fs-2 text-primary mb-3"></i>
                <h6 class="fw-semibold">Teacher Attendance</h6>
              </div>
            </div>
          </a>
        </div>

        <div class="col-md-4">
          <a href="#" class="text-decoration-none">
            <div class="card border-primary shadow-sm h-100 text-center module-card">
              <div class="card-body">
                <i class="bi bi-cash-stack fs-2 text-primary mb-3"></i>
                <h6 class="fw-semibold">Teacher Salaries</h6>
              </div>
            </div>
          </a>
        </div>

        <div class="col-md-4">
          <a href="#" class="text-decoration-none">
            <div class="card border-primary shadow-sm h-100 text-center module-card">
              <div class="card-body">
                <i class="bi bi-file-earmark-bar-graph fs-2 text-primary mb-3"></i>
                <h6 class="fw-semibold">Teacher Report</h6>
              </div>
            </div>
          </a>
        </div>

      </div>

    </div>
  </div>



  <!-- ================= FINANCE ================= -->
  <div class="<?= ($UserRole === 'Admin')?'d-block':'d-none' ?> card mb-4 border-0 shadow-lg">
    <div class="card-body">

      <div class="d-flex align-items-center mb-4">
        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
          style="width:50px;height:50px;">
          <i class="bi bi-bank2 fs-4"></i>
        </div>
        <h4 class="fw-bold mb-0">Finance Reports</h4>
      </div>

      <div class="row g-3">

        <div class="col-md-4">
          <a href="#" class="text-decoration-none">
            <div class="card border-primary shadow-sm h-100 text-center module-card">
              <div class="card-body">
                <i class="bi bi-wallet2 fs-2 text-primary mb-3"></i>
                <h6 class="fw-semibold">Payable</h6>
              </div>
            </div>
          </a>
        </div>

        <div class="col-md-4">
          <a href="#" class="text-decoration-none">
            <div class="card border-primary shadow-sm h-100 text-center module-card">
              <div class="card-body">
                <i class="bi bi-credit-card-2-front fs-2 text-primary mb-3"></i>
                <h6 class="fw-semibold">Receivable</h6>
              </div>
            </div>
          </a>
        </div>

        <div class="col-md-4">
          <a href="#" class="text-decoration-none">
            <div class="card border-primary shadow-sm h-100 text-center module-card">
              <div class="card-body">
                <i class="bi bi-graph-up-arrow fs-2 text-primary mb-3"></i>
                <h6 class="fw-semibold">Profit & Loss</h6>
              </div>
            </div>
          </a>
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