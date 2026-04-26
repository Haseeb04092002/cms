<div class="p-4">

    <!-- ================= FILTER SECTION ================= -->
    <div class="card mb-3">
        <div class="card-body">

            <div class="row g-2">

                <div class="col-md-3">
                    <input type="text" id="searchStudent" class="form-control" placeholder="Search Student Name">
                </div>

                <div class="col-md-2">
                    <select id="searchClass" class="form-select">
                        <option value="">All Classes</option>
                        <?php foreach ($classes as $c): ?>
                            <option value="<?= $c->classId ?>">
                                <?= $c->className ?> - <?= $c->sectionName ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <select id="startMonth" class="form-select">
                        <option value="">Start Month</option>
                        <?php for ($m = 1; $m <= 12; $m++): ?>
                            <option value="<?= $m ?>"><?= date("F", mktime(0, 0, 0, $m, 1)) ?></option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <select id="endMonth" class="form-select">
                        <option value="">End Month</option>
                        <?php for ($m = 1; $m <= 12; $m++): ?>
                            <option value="<?= $m ?>"><?= date("F", mktime(0, 0, 0, $m, 1)) ?></option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <input type="number" id="batchYear" class="form-control" placeholder="Batch Year">
                </div>

                <div class="col-md-1">
                    <button class="btn btn-primary w-100" onclick="loadChallans()">Search</button>
                </div>

            </div>

        </div>
    </div>


    <!-- ================= TABLE ================= -->
    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Challan ID</th>
                            <th>Student</th>
                            <th>Class</th>
                            <!-- <th>Section</th> -->
                            <th>Education Type</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="challanTableBody">
                        <tr>
                            <td colspan="6" class="text-center">No Data</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

<!-- ================= STATUS MODAL ================= -->
<div class="modal fade" id="statusModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Fee Summary</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div id="summaryArea"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="generateBtn" onclick="generateChallan()">
                    Generate Fee Challan
                </button>
            </div>

        </div>
    </div>
</div>


<script>
    var selectedStudentId = 0;
    var selectedChallanExists = false;

    function loadChallans() {


        $.ajax({
            url: "<?= site_url('Fee/get_echallans') ?>",
            type: "POST",
            dataType: "json",
            data: {
                student: $('#searchStudent').val(),
                classId: $('#searchClass').val(),
                startMonth: $('#startMonth').val(),
                endMonth: $('#endMonth').val(),
                batchYear: $('#batchYear').val()
            },
            success: function(res) {
                console.log("skdjskdj");

                console.log(res);

                let html = '';

                if (res.status && res.data.length > 0) {

                    res.data.forEach(row => {

                        let statusButton = `
                            <button class="btn btn-sm btn-primary"
                                onclick="openStatus(${row.studentId}, ${row.feeChallanId ?? 0})">
                                View
                            </button>
                        `;

                        html += `
                            <tr>
                                <td>${row.challanNo ?? '-'}</td>
                                <td>${row.studentName}</td>
                                <td>${row.className ?? '-'}</td>
                                <td>${row.education_type ?? '-'}</td>
                                <td>${statusButton}</td>
                            </tr>
                        `;
                    });

                } else {
                    html = `<tr><td colspan="6" class="text-center">No Data Found</td></tr>`;
                }

                $('#challanTableBody').html(html);
            },
            error: function(xhr, status, error) {
                console.log("ERROR");
                console.log("Status:", status);
                console.log("Error:", error);
                console.log("Response:", xhr.responseText);
            }
        });
    }

    // Ensure this helper function exists to clean up Bootstrap backdrops
    function closeAllModals() {
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open').css({
            'overflow': '',
            'padding-right': ''
        });
    }

    function openStatus(studentId, feeChallanId = 0) {
        selectedStudentId = studentId;
        selectedChallanExists = feeChallanId ? true : false;

        $.ajax({
            url: "<?= site_url('Fee/get_student_fee_summary') ?>",
            type: "POST",
            dataType: "json",
            data: {
                studentId: studentId,
                startMonth: $('#startMonth').val(), // Assumes these inputs exist
                endMonth: $('#endMonth').val()
            },
            success: function(res) {

                // 1. Check if controller returned success
                if (!res.status) {
                    Swal.fire('Notice', res.message, 'info');
                    return;
                }

                let html = `
                <div class="mb-3">
                    <strong>Student:</strong> ${res.student} <br>
                    <strong>Period:</strong> ${res.range}
                </div>
                <table class="table table-sm table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Month</th>
                            <th>Fee Head</th>
                            <th class="text-end">Amount</th>
                            <th class="text-end">Discount</th>
                            <th class="text-end">Net</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

                // 2. Loop through the 'data' array from the controller
                res.data.forEach(row => {
                    html += `
                    <tr>
                        <td><span class="badge bg-secondary">${row.month}</span></td>
                        <td>${row.feeHead}</td>
                        <td class="text-end">${parseFloat(row.originalAmount).toLocaleString()}</td>
                        <td class="text-end text-danger">-${parseFloat(row.discount).toLocaleString()}</td>
                        <td class="text-end fw-bold">${parseFloat(row.netAmount).toLocaleString()}</td>
                    </tr>
                `;
                });

                // 3. Grand Total Row
                html += `
                <tr class="table-secondary">
                    <th colspan="4" class="text-end">Grand Total</th>
                    <th class="text-end">${parseFloat(res.grandTotal).toLocaleString()}</th>
                </tr>
            `;

                html += `</tbody></table>`;

                // Update the UI
                $('#summaryArea').html(html);

                if (selectedChallanExists) {
                    // $('#generateBtn').hide();
                    $('#generateBtn').show();
                } else {
                    $('#generateBtn').show();
                }

                // Trigger Modal securely
                let modalEl = document.getElementById('statusModal');
                let modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                modal.show();
            },
            error: function() {
                closeAllModals();
                Swal.fire('Error', 'Failed to fetch student fee details.', 'error');
            }
        });
    }

    function generateChallan() {
        if (!selectedStudentId) return;

        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to generate a fee challan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, generate it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('Fee/generate_echallan') ?>",
                    type: "POST",
                    dataType: "json",
                    data: {
                        studentId: selectedStudentId,
                        // Pass current filter months so challan is generated for that period
                        month: $('#startMonth').val() || new Date().getMonth() + 1
                    },
                    success: function(res) {
                        if (res.status) {
                            Swal.fire('Success', 'Challan Generated Successfully', 'success');

                            // --- FIX: Open Base64 in New Tab ---
                            let linkSource = `data:application/pdf;base64,${res.pdfData}`;
                            let downloadLink = document.createElement("a");
                            downloadLink.href = linkSource;
                            downloadLink.target = "_blank"; // This opens in a new tab
                            downloadLink.download = res.filename;
                            downloadLink.click();
                            // ------------------------------------

                            loadChallans(); // Refresh main list
                            // bootstrap.Modal.getInstance(document.getElementById('statusModal')).hide();

                        } else {
                            Swal.fire('Error', res.message || "Something went wrong", 'error');
                        }
                    },
                    error: function(xhr) {
                        // console.log(xhr.responseText);
                        console.log("Status: " + status);
                        // console.log("Error: " + error);
                        console.log("Response Text: " + xhr.responseText);
                        Swal.fire('Error', 'An error occurred while generating the challan.', 'error');
                    }
                });
            }
        });
    }

    $(document).ready(function() {
        loadChallans();
    });
</script>