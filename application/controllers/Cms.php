<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cms extends MY_Controller
{

	public function index()
	{
		$this->load->view('master_view');
	}

	public function _check_array_required($value)
	{
		if (empty($value) || !is_array($value)) {
			$this->form_validation->set_message(
				'_check_array_required',
				'The {field} field is required. Please select at least one.'
			);
			return false;
		}
		return true;
	}


	public function save_subject_class_assign()
	{
		$UserId = '';
		$UserName = '';
		$UserEmail = '';
		$UserRole = '';
		$StationId = '';
		$UserId = $this->session->userdata('user_id') ?? '';
		$UserName = $this->session->userdata('user_name') ?? '';
		$UserEmail = $this->session->userdata('user_email') ?? '';
		$UserRole = $this->session->userdata('user_role') ?? '';
		$StationId = $this->session->userdata('station_id') ?? '';

		$Response['status']  = false;
		$Response['message']  = "Some Error Occured. Try Again";

		$teacherId        = $this->input->post('teacherId') ?? '';
		$lecturesPerWeek  = $this->input->post('lecturesPerWeek') ?? 0;
		$subjects         = $this->input->post('subjects') ?? [];
		$classes          = $this->input->post('classes') ?? [];
		$classHeads       = $this->input->post('classHeads') ?? [];

		$this->form_validation->set_rules('subjects[]', 'Subjects', 'required');
		$this->form_validation->set_rules('classes[]', 'Classes', 'required');
		$this->form_validation->set_rules('classHeads[]', 'Class Teacher', 'required');
		$this->form_validation->set_rules('lecturesPerWeek', 'lecturesPerWeek', 'required');

		if ($this->form_validation->run() == FALSE) {
			$Response['message']  = validation_errors();
			exit(json_encode($Response));
			return;
		} else {

			$subjects   = is_array($subjects) ? $subjects : [];
			$classes    = is_array($classes) ? $classes : [];
			$classHeads = is_array($classHeads) ? $classHeads : [];

			$this->db->where('teacherId', $teacherId)
				->where('isDeleted', 0)
				->update('tbl_class_subject_assignment', [
					'isDeleted' => 1
				]);

			$totalLectures = count($classes) * count($subjects);

			/* Optional: validate workload */
			if ($totalLectures > $lecturesPerWeek) {   // example limit
				$Response['message'] = "Teacher workload exceeded. Assigned: {$totalLectures} lectures/week, Allowed: {$lecturesPerWeek}. Please adjust assignments.";
				exit(json_encode($Response));
				return;
			}

			foreach ($classes as $classId) {

				// check if this class is class-head for this teacher
				// $isHeadClass = in_array($classId, $classHeads) ? $classId : '';

				foreach ($subjects as $subjectId) {

					$data = [
						'stationId'       => $StationId,
						'userId'          => $UserId,
						'classId'         => $classId,
						'subjectId'       => $subjectId,
						'teacherId'       => $teacherId,
						'lecturesPerWeek' => $lecturesPerWeek,
						'addedBy'         => $UserId,
						'addedOn'         => date('Y-m-d H:i:s')
					];

					$this->db->insert('tbl_class_subject_assignment', $data);
				}
			}

			foreach ($classHeads as $headClassId) {

				if (in_array($headClassId, $classes)) {
					// Case 1: class already exists → update rows
					$this->db->where('teacherId', $teacherId)
						->where('classId', $headClassId)
						->where('isDeleted', 0)
						->update('tbl_class_subject_assignment', [
							'headClassId' => $headClassId
						]);
				} else {
					// Case 2: class NOT in subject assignments → insert ONE head-only row
					$data = [
						'stationId'       => $StationId,
						'userId'          => $UserId,
						'headClassId'     => $headClassId,     // only head mapping
						'teacherId'       => $teacherId,
						'addedBy'         => $UserId,
						'addedOn'         => date('Y-m-d H:i:s')
					];

					$this->db->insert('tbl_class_subject_assignment', $data);
				}
			}

			if ($this->db->affected_rows() > 0) {

				$Response['status']  = true;
				$Response['message']  = "Saved Successfully";
			}
		}
		exit(json_encode($Response));
	}

	public function dashboard($case = 'Admin')
	{
		switch ($case) {
			case 'Admin':

				$db = $this->db; // CI DB instance

				/* =======================
				KPI COUNTS
				======================= */
				$data['students_count'] = $db->where('isDeleted', 0)->count_all_results('tbl_students');

				$data['admissions_count'] = $db->where('isDeleted', 0)->count_all_results('tbl_admissions');

				$data['classes_count'] = $db->where('isDeleted', 0)->count_all_results('tbl_classes');

				$data['fees_paid'] = $db->select_sum('paidAmount')
					->where('isDeleted', 0)
					->get('tbl_fees')
					->row()->paidAmount ?? 0;

				$data['fees_due'] = $db->select_sum('dueAmount')
					->where('isDeleted', 0)
					->get('tbl_fees')
					->row()->dueAmount ?? 0;

				$data['expenses'] = $db->select_sum('amount')
					->where('isDeleted', 0)
					->get('tbl_expenses')
					->row()->amount ?? 0;

				/* =======================
				TASK STATUS
				======================= */
				$data['task_stats'] = [
					'Pending'     => $db->where(['status' => 'Pending', 'isDeleted' => 0])->count_all_results('tbl_tasks'),
					'In Progress' => $db->where(['status' => 'In Progress', 'isDeleted' => 0])->count_all_results('tbl_tasks'),
					'Completed'   => $db->where(['status' => 'Completed', 'isDeleted' => 0])->count_all_results('tbl_tasks'),
					'Overdue'     => $db->where(['status' => 'Overdue', 'isDeleted' => 0])->count_all_results('tbl_tasks')
				];

				/* =======================
				EXAMS STATUS
				======================= */
				$data['exam_stats'] = [
					'Scheduled' => $db->where(['examStatus' => 'Scheduled', 'isDeleted' => 0])->count_all_results('tbl_exams'),
					'Ongoing'   => $db->where(['examStatus' => 'Ongoing', 'isDeleted' => 0])->count_all_results('tbl_exams'),
					'Completed' => $db->where(['examStatus' => 'Completed', 'isDeleted' => 0])->count_all_results('tbl_exams'),
					'Results'   => $db->where(['examStatus' => 'Result Published', 'isDeleted' => 0])->count_all_results('tbl_exams')
				];

				/* =======================
				ATTENDANCE % (TODAY)
				======================= */
				$total_att = $db->where(['isDeleted' => 0, 'attendanceDate' => date('Y-m-d')])
					->count_all_results('tbl_attendance');

				$present_att = $db->where([
					'isDeleted' => 0,
					'attendanceDate' => date('Y-m-d'),
					'status' => 'Present'
				])->count_all_results('tbl_attendance');

				$data['attendance_percent'] = ($total_att > 0)
					? round(($present_att / $total_att) * 100, 1)
					: 0;

				/* =======================
				ADMISSION TREND (MONTHLY)
				======================= */
				$trend = $db->query("
					SELECT DATE_FORMAT(admissionDate,'%b') AS m, COUNT(*) c
					FROM tbl_admissions
					WHERE isDeleted=0
					GROUP BY MONTH(admissionDate)
					ORDER BY MONTH(admissionDate)
				")->result_array();

				$data['admission_labels'] = array_column($trend, 'm');
				$data['admission_data']   = array_column($trend, 'c');

				/* =======================
				FINANCE TREND
				======================= */
				$finance = $db->query("
					SELECT DATE_FORMAT(dueDate,'%b') AS m,
							SUM(paidAmount) fees,
							(SELECT SUM(amount) FROM tbl_expenses e
							WHERE MONTH(e.expenseDate)=MONTH(f.dueDate)) exp
					FROM tbl_fees f
					WHERE isDeleted=0
					GROUP BY MONTH(dueDate)
				")->result_array();

				$data['finance_labels']   = array_column($finance, 'm');
				$data['fees_data']        = array_map(fn($r) => $r['fees'] ?? 0, $finance);
				$data['expense_data']     = array_map(fn($r) => $r['exp'] ?? 0, $finance);

				/* =======================
					TASK PIE
				======================= */
				$data['task_chart'] = array_values($data['task_stats']);

				/* =======================
					ATTENDANCE TREND (WEEK)
				======================= */
				$att_trend = $db->query("
					SELECT DAYNAME(attendanceDate) d,
							ROUND(SUM(status='Present')/COUNT(*)*100,1) p
					FROM tbl_attendance
					WHERE isDeleted=0
					GROUP BY attendanceDate
					ORDER BY attendanceDate DESC
					LIMIT 6
				")->result_array();

				$data['att_labels'] = array_column($att_trend, 'd');
				$data['att_data']   = array_column($att_trend, 'p');

				// echo "<br>";
				// echo "<pre>";
				// print_r($data);
				// die();

				$this->load->view('pages/admin/dashboard', $data);
				break;

			case 'Teacher':
				$UserId = '';
				$UserName = '';
				$UserEmail = '';
				$UserRole = '';
				$StationId = '';
				$UserId = $this->session->userdata('user_id') ?? '';
				$UserName = $this->session->userdata('user_name') ?? '';
				$UserEmail = $this->session->userdata('user_email') ?? '';
				$UserRole = $this->session->userdata('user_role') ?? '';
				$StationId = $this->session->userdata('station_id') ?? '';

				$data = array();
				$teacher = $this->db->where('stationId', $StationId)->where('isDeleted', 0)->where('staffId', $UserId)->get('tbl_staff')->row();
				$data['teacher'] = $teacher;
				// $data['suggested_password'] = $this->generate_strong_password(6,8);
				$this->load->view('pages/teacher/dashboard', $data);
				break;

			case 'Student':
				// echo "here";
				// die();
				$UserId = '';
				$UserName = '';
				$UserEmail = '';
				$UserRole = '';
				$StationId = '';
				$UserId = $this->session->userdata('user_id') ?? '';
				$UserName = $this->session->userdata('user_name') ?? '';
				$UserEmail = $this->session->userdata('user_email') ?? '';
				$UserRole = $this->session->userdata('user_role') ?? '';
				$StationId = $this->session->userdata('station_id') ?? '';

				$this->db->select('*');
				$this->db->from('tbl_students');
				$this->db->join('tbl_classes', 'tbl_students.classId = tbl_classes.classId');
				$this->db->join('tbl_parents', 'tbl_students.admissionNo = tbl_parents.admissionNo');
				$this->db->where('tbl_students.stationId', $StationId);
				$this->db->where('tbl_students.isDeleted', 0);
				$this->db->where('tbl_students.studentId', $UserId);
				$student = $this->db->get()->row();
				$admissionNo = $this->db->select('admissionNo')->where('stationId', $StationId)->where('studentId', $UserId)->get('tbl_students')->row()->admissionNo;
				// $admissionNo->admissionNo;
				$siblings = $this->db
					->where([
						'stationId' => $StationId,
						'admissionNo' => $admissionNo,
						'isDeleted' => 0
					])
					->get('tbl_siblings')
					->result();
				// echo "<br>";
				// print_r($this->db->last_query());
				// die();
				$all_classes = $this->db->where('stationId', $StationId)->where('isDeleted', 0)->order_by('addedOn', 'DESC')->get('tbl_classes')->result();

				// echo "<br>";
				// print_r($this->db->last_query());
				// die();

				$this->load->view('pages/student/student_profile', [
					'student' => $student,
					'all_classes' => $all_classes,
					'siblings' => $siblings
				]);
				break;
		}
	}

	public function assign_classes_subjects($staffId = '')
	{
		$UserId = '';
		$UserName = '';
		$UserEmail = '';
		$UserRole = '';
		$StationId = '';
		$UserId = $this->session->userdata('user_id') ?? '';
		$UserName = $this->session->userdata('user_name') ?? '';
		$UserEmail = $this->session->userdata('user_email') ?? '';
		$UserRole = $this->session->userdata('user_role') ?? '';
		$StationId = $this->session->userdata('station_id') ?? '';
		if ($staffId > 0) {
			$this->db->select('
				tbl_class_subject_assignment.*,
				tbl_classes.className, tbl_classes.sectionName,
				tbl_staff.firstName, tbl_staff.lastName,
				tbl_subjects.subjectName
			');
			$this->db->from('tbl_class_subject_assignment');
			$this->db->join('tbl_classes', 'tbl_class_subject_assignment.classId = tbl_classes.classId', 'left');
			$this->db->join('tbl_staff', 'tbl_class_subject_assignment.teacherId = tbl_staff.staffId', 'left');
			$this->db->join('tbl_subjects', 'tbl_class_subject_assignment.subjectId = tbl_subjects.subjectId', 'left');
			$this->db->where('tbl_class_subject_assignment.stationId', $StationId);
			$this->db->where('tbl_class_subject_assignment.teacherId', $staffId);
			$this->db->where('tbl_class_subject_assignment.isDeleted', 0);
			$assignments = $this->db->get()->result();
			$classes = $this->db->where('stationId', $StationId)->where('isDeleted', 0)->get('tbl_classes')->result();
			$subjects = $this->db->where('stationId', $StationId)->where('isDeleted', 0)->get('tbl_subjects')->result();
			$teacher = $this->db->where('stationId', $StationId)->where('isDeleted', 0)->where('staffId', $staffId)->get('tbl_staff')->row();
			$data['teacher'] = $teacher;
			$data['classes'] = $classes;
			$data['subjects'] = $subjects;
			$data['assignments'] = $assignments;
		} else {
			$teacher = $this->db->where('stationId', $StationId)->where('isDeleted', 0)->where('staffId', $staffId)->get('tbl_staff')->row();
			$classes = $this->db->where('stationId', $StationId)->where('isDeleted', 0)->get('tbl_classes')->result();
			$subjects = $this->db->where('stationId', $StationId)->where('isDeleted', 0)->get('tbl_subjects')->result();
			$data['classes'] = $classes;
			$data['subjects'] = $subjects;
		}
		// echo "<br>";
		// echo "<pre>";
		// print_r($data);
		// die();
		$this->load->view('pages/admin/assign_classes_subjects', $data);
	}

	public function users()
	{
		$this->load->view('pages/admin/users');
	}

	public function courses()
	{
		$this->load->view('pages/course/courses');
	}


	public function all_expenses()
	{
		$this->load->view('pages/finance/all_expenses');
	}

	public function user_access_control()
	{
		$UserId = '';
		$UserName = '';
		$UserEmail = '';
		$UserRole = '';
		$StationId = '';
		$UserId = $this->session->userdata('user_id') ?? '';
		$UserName = $this->session->userdata('user_name') ?? '';
		$UserEmail = $this->session->userdata('user_email') ?? '';
		$UserRole = $this->session->userdata('user_role') ?? '';
		$StationId = $this->session->userdata('station_id') ?? '';

		$sql = "SELECT studentId, firstName, lastName, 'student' AS type
				FROM tbl_students 
				WHERE stationId = '$StationId' AND isDeleted = 0 ";

		$sql .= " UNION ALL ";

		$sql .= "SELECT staffId, firstName, lastName, 'staff' AS type
				FROM tbl_staff 
				WHERE stationId = '$StationId' AND isDeleted = 0";


		$query = $this->db->query($sql);
		$result = $query->result();
		$data =  array();
		$data['all_users'] = $result;

		// echo "<br>";
		// echo "<pre>";
		// print_r($data['all_users']);
		// die();

		$this->load->view('pages/admin/users_access_control', $data);
	}
}
