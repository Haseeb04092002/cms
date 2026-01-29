<div class="p-4">
    <h3 class="fw-bold mb-4 text-start">
        Time Table Chart
        <?php if (isset($className)): ?>
            <span><?= $className ?></span>
        <?php endif; ?>

    </h3>

    <!-- Minimal Enhancement CSS -->
    <style>
        .table td,
        .table th {
            vertical-align: middle;
            padding: 0.5rem;
        }

        .table button.btn {
            border-radius: 0.5rem;
            transition: all 0.2s ease-in-out;
            border: 1px solid var(--bs-border-color);
        }

        .table button.btn:hover {
            background-color: var(--bs-light);
            transform: translateY(-1px);
            box-shadow: 0 .25rem .5rem rgba(0, 0, 0, .08);
        }

        .table thead button {
            font-weight: 600;
        }

        .table small {
            color: var(--bs-secondary);
        }

        .modal-header {
            background-color: var(--bs-light);
        }

        .modal-title {
            font-weight: 600;
        }
    </style>


    <div class="container-fluid">

        <?php if (isset($timetableData) && !empty($timetableData)): ?>
            <div class="table-responsive">
                <form id="TimeTableForm" novalidate>
                    <table class="table table-bordered align-middle text-center">
                        <!-- TIME HEADER -->
                        <thead class="table-light">
                            <tr>
                                <th>Days</th>

                                <?php
                                $count = $slotNumber;
                                for ($i = 1; $i <= $count; $i++):
                                ?>

                                    <th>
                                        <button type="button" class="btn btn-light w-100 lecture-btn"
                                            data-slot="<?= $i ?>"
                                            data-bs-toggle="modal"
                                            data-bs-target="#timeModal_<?= $i ?>">

                                            <div class="fw-bold">Lecture # <?= $i ?></div>

                                            <small class="time-text text-dark">
                                                <?= $timeSlots[$i]['startTime'] ?? '' ?> – <?= $timeSlots[$i]['endTime'] ?? '' ?>
                                            </small>

                                            <!-- Structured Hidden Inputs -->
                                            <input type="hidden"
                                                name="time_slots[<?= $i ?>][start_time]"
                                                value="<?= $timeSlots[$i]['startTime'] ?? '' ?>"
                                                id="startTime_<?= $i ?>">

                                            <input type="hidden"
                                                name="time_slots[<?= $i ?>][end_time]"
                                                value="<?= $timeSlots[$i]['endTime'] ?? '' ?>"
                                                id="endTime_<?= $i ?>">
                                        </button>
                                    </th>

                                    <!-- TIME MODAL -->
                                    <div class="modal fade"
                                        id="timeModal_<?= $i ?>"
                                        tabindex="-1"
                                        data-slot="<?= $i ?>">

                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Time Period</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">

                                                    <label class="form-label">Start Time</label>
                                                    <input type="text"
                                                        class="form-control mb-3 start-time timepicker"
                                                        value="<?= $timeSlots[$i]['startTime'] ?? '' ?>"
                                                        placeholder="Start Time">

                                                    <label class="form-label">End Time</label>
                                                    <input type="text"
                                                        class="form-control end-time timepicker"
                                                        value="<?= $timeSlots[$i]['endTime'] ?? '' ?>"
                                                        placeholder="End Time">

                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary save-time"
                                                        data-slot="<?= $i ?>">
                                                        Save
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                <?php endfor; ?>

                            </tr>
                        </thead>

                        <!-- SUBJECT ROWS -->
                        <tbody>

                            <?php foreach ($days as $record): ?>

                                <tr>
                                    <th class="table-light"><?= $record ?? '' ?></th>

                                    <?php
                                    $count = $slotNumber;
                                    for ($i = 1; $i <= $count; $i++):
                                        $cell = $timetableData[$record][$i] ?? null;
                                    ?>

                                        <td>
                                            <button type="button" class="btn btn-light w-100 subject-btn"
                                                data-day="<?= $record ?>"
                                                data-slot="<?= $i ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#subjectModal_<?= $record ?>_<?= $i ?>">

                                                <strong class="subject-text">
                                                    <?= $cell['subject_name'] ?? 'Subject' ?>
                                                </strong><br>

                                                <small class="teacher-text text-dark">
                                                    <?= $cell['teacher_name'] ?? 'Teacher' ?>
                                                </small>

                                                <!-- Structured Hidden Inputs -->
                                                <input type="hidden"
                                                    name="timetable[<?= $record ?>][<?= $i ?>][teacher_id]"
                                                    value="<?= $cell['teacher_id'] ?? '' ?>"
                                                    id="teacherID_<?= $record ?>_<?= $i ?>">

                                                <input type="hidden"
                                                    name="timetable[<?= $record ?>][<?= $i ?>][subject_id]"
                                                    value="<?= $cell['subject_id'] ?? '' ?>"
                                                    id="subjectID_<?= $record ?>_<?= $i ?>">
                                            </button>
                                        </td>

                                        <!-- SUBJECT / TEACHER MODAL -->
                                        <div class="modal fade"
                                            id="subjectModal_<?= $record ?>_<?= $i ?>"
                                            tabindex="-1"
                                            data-day="<?= $record ?>"
                                            data-slot="<?= $i ?>">

                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Subject</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <div class="modal-body">

                                                        <label class="form-label">Subject Name</label>
                                                        <select class="form-select subject-select">
                                                            <option value="">--Select--</option>
                                                            <?php if (!empty($subjects)): ?>
                                                                <?php foreach ($subjects as $type): ?>
                                                                    <option
                                                                        data-subjectname="<?= $type->subjectName ?>"
                                                                        value="<?= $type->subjectId ?>"
                                                                        <?= (!empty($cell) && $cell['subject_id'] == $type->subjectId) ? 'selected' : '' ?>>
                                                                        <?= $type->subjectName ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        </select>

                                                        <label class="mt-3 form-label">Teacher Name</label>
                                                        <select class="form-select teacher-select">
                                                            <option value="">--Select--</option>
                                                            <?php if (!empty($teachers)): ?>
                                                                <?php foreach ($teachers as $type): ?>
                                                                    <option
                                                                        data-teachername="<?= $type->firstName ?> <?= $type->lastName ?>"
                                                                        value="<?= $type->staffId ?>"
                                                                        <?= (!empty($cell) && $cell['teacher_id'] == $type->staffId) ? 'selected' : '' ?>>
                                                                        <?= $type->firstName ?> <?= $type->lastName ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        </select>

                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="button" class="btn btn-primary save-teacher"
                                                            data-day="<?= $record ?>"
                                                            data-slot="<?= $i ?>">
                                                            Save
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    <?php endfor; ?>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>
                    </table>

                    <div class="d-flex justify-content-end align-items-center mb-3">

                        <!-- Right: Action Buttons -->
                        <div class="d-flex gap-2">

                            <!-- Update Button -->
                            <button type="submit" form="TimeTableForm" class="btn btn-primary">
                                Save
                            </button>

                            <!-- Reset Button -->
                            <button type="reset"
                                class="btn btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#resetTimeTableModal">
                                Reset
                            </button>

                            <!-- Delete Button -->
                            <button type="button"
                                class="btn btn-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteTimeTableModal">
                                Delete
                            </button>

                        </div>

                    </div>

                </form>

                <!-- Delete Confirmation Modal -->
                <div class="modal fade" id="deleteTimeTableModal" tabindex="-1" aria-labelledby="deleteTimeTableModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <div class="modal-header bg-light">
                                <h5 class="modal-title" id="deleteTimeTableModalLabel">Confirm Delete</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <form class="FormDeleteTimeTable" data-parsley-validate>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete this item ?</p>
                                    <input type="hidden" name="classId" value="<?= $classId ?>">
                                    <div class="text-end">
                                        <button class="btn btn-danger BtnDeleteTimeTable">Yes</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <h2 class="text-danger">No Time Table for this class</h2>
        <?php endif; ?>
    </div>



</div>

<script>
    $(document).ready(function() {

        $(document).on('click', '.BtnDeleteTimeTable', function(e) {
            e.preventDefault();
            $(this).closest('form').submit();
        });

        $(document).on('submit', '.FormDeleteTimeTable', function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= site_url('Timetable/delete_timetable') ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.status === false) {
                        Swal.fire({
                            title: 'Error',
                            text: response.message,
                            icon: 'error',
                            position: 'center',
                            timer: 3000,
                            showConfirmButton: true,
                            confirmButtonText: 'OK',
                        });

                    } else {
                        Swal.fire({
                            title: 'Success',
                            text: response.message,
                            icon: 'success',
                            position: 'center',
                            timer: 3000,
                            showConfirmButton: true,
                            confirmButtonText: 'OK',
                        });
                    }
                }
            });
        });

        $(document).on('focus', '.timepicker', function() {
            if (!this._flatpickr) {
                flatpickr(this, {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "h:i K", // 9:00 AM
                    time_24hr: false,
                    minuteIncrement: 5
                });
            }
        });

        $(document).on('submit', '#TimeTableForm', function(e) {

            e.preventDefault();

            let form = $(this);

            $.ajax({
                url: <?= json_encode(site_url('Timetable/save_timetable/' . $classId . '/edit')) ?>,
                type: "POST",
                data: form.serialize(),
                dataType: "json",
                cache: false,
                success: function(response) {

                    let modalEl = form.closest('.modal');
                    let modal = bootstrap.Modal.getInstance(modalEl[0]);
                    if (modal) modal.hide();

                    Swal.fire({
                        title: response.status ? 'Success' : 'Error',
                        text: response.message,
                        icon: response.status ? 'success' : 'error',
                        timer: 3000,
                        showConfirmButton: true
                    });
                }
            });

        });

        $(document).on('click', '.save-time', function(e) {
            e.preventDefault();
            e.stopPropagation();

            // console.log('SAVE TIME CLICKED');
            // alert('Save Time Clicked');

            let modal = $(this).closest('.modal');

            let start = modal.find('.start-time').val();
            let end = modal.find('.end-time').val();

            let slot = $(this).data('slot');

            if (start === '' || end === '') {
                alert('Please select both start and end time');
                return;
            }

            // Update UI
            let btn = $('.lecture-btn[data-slot="' + slot + '"]');
            btn.find('.time-text').text(start + ' – ' + end);

            // Update hidden inputs
            $('#startTime_' + slot).val(start);
            $('#endTime_' + slot).val(end);

            let bsModal = bootstrap.Modal.getInstance(modal[0]);
            if (bsModal) {
                bsModal.hide();
            }
        });

        $(document).on('click', '.save-teacher', function(e) {

            e.preventDefault();
            e.stopPropagation();


            // console.log('SAVE teacher CLICKED');
            // alert('Save teacher Clicked');

            let modal = $(this).closest('.modal');

            let subjectId = modal.find('.subject-select').val();
            let teacherId = modal.find('.teacher-select').val();

            let subjectName = modal.find('.subject-select option:selected').data('subjectname');
            let teacherName = modal.find('.teacher-select option:selected').data('teachername');

            let day = $(this).data('day');
            let slot = $(this).data('slot');

            // Update UI
            let btn = $('.subject-btn[data-day="' + day + '"][data-slot="' + slot + '"]');
            btn.find('.subject-text').text(subjectName);
            btn.find('.teacher-text').text(teacherName);

            // Update hidden inputs
            $('#subjectID_' + day + '_' + slot).val(subjectId);
            $('#teacherID_' + day + '_' + slot).val(teacherId);

            let bsModal = bootstrap.Modal.getInstance(modal[0]);
            if (bsModal) {
                bsModal.hide();
            }
        });

    });
</script>