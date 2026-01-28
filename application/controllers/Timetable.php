<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Timetable extends MY_Controller
{
	public function time_table_chart($classId = '', $case = 'add', $slotNumber = '')
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

		switch ($case) {
			case 'add':
				$query = $this->db->query("SHOW COLUMNS FROM tbl_time_table LIKE 'dayName'");
				$row = $query->row();
				$days = [];
				if ($row) {
					$enum = str_replace(["enum(", ")", "'"], "", $row->Type);
					$days = explode(",", $enum);
				}
				$subjects = $this->db->select('subjectName, subjectId')->where('stationId', $StationId)->where('isDeleted', 0)->get('tbl_subjects')->result();
				$teachers = $this->db->select('firstName, lastName, staffId')->where('stationId', $StationId)->where('isDeleted', 0)->get('tbl_staff')->result();
				$data = array();
				$data['slotNumber'] = $slotNumber;
				$data['days'] = $days;
				$data['subjects'] = $subjects;
				$data['teachers'] = $teachers;
				$data['classId'] = $classId;
				$this->load->view('pages/timetable/time_table_chart_add', $data);

				break;

			case 'edit':

				// $this->db->select('*');
				$this->db->select('
					tbl_time_table.*,
					tbl_staff.firstName,
					tbl_staff.lastName,
					tbl_subjects.subjectName,
					tbl_classes.className,
					tbl_classes.sectionName
				');
				$this->db->from('tbl_time_table');
				$this->db->join('tbl_classes', 'tbl_time_table.classId = tbl_classes.classId', 'left');
				$this->db->join('tbl_staff', 'tbl_time_table.teacherId = tbl_staff.staffId', 'left');
				$this->db->join('tbl_subjects', 'tbl_time_table.subjectId = tbl_subjects.subjectId', 'left');
				$this->db->where('tbl_time_table.stationId', $StationId);
				$this->db->where('tbl_time_table.isDeleted', 0);
				$this->db->where('tbl_time_table.classId', $classId);
				$timeTable = $this->db->get()->result();

				$query = $this->db->query("SHOW COLUMNS FROM tbl_time_table LIKE 'dayName'");
				$row = $query->row();

				$days = [];

				if ($row) {
					$enum = str_replace(["enum(", ")", "'"], "", $row->Type);
					$days = explode(",", $enum);
				}

				// print_r($this->db->last_query());
				// echo "<br>";
				// echo "<pre>";
				// print_r($timeTable);
				// die();

				$data = array();

				$data['timeTable'] = $timeTable;
				$data['days'] = $days;

				$this->load->view('pages/timetable/time_table_chart_edit', $data);

				break;

			case 'view':
				
				break;
		}
	}

	public function time_table_templates()
	{
		$this->load->view('pages/timetable/templates');
	}

	public function all_time_tables()
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

		$data = array();

		$data['classes'] = $this->Class_model->get_all_classes_with_student_count($StationId);

		// echo "<br>";
		// echo "<pre>";
		// print_r($data['student']);
		// die();

		$this->load->view('pages/timetable/all_time_tables', $data);
	}

	public function time_table_dashboard()
	{
		$this->load->view('pages/timetable/dashboard');
	}

	public function save_timetable($classId = '', $case = 'add')
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
		$Response['message'] = "Some Error Occured. Try Again";

		$timeSlots = $this->input->post('time_slots');   // [slot][start_time,end_time]
		$timetable = $this->input->post('timetable');    // [day][slot][teacher_id,subject_id]

		// Safety check
		if (empty($timeSlots) || empty($timetable)) {
			$Response['message'] = 'Invalid timetable data';
			exit(json_encode($Response));
		}

		$insertBatch = [];

		foreach ($timetable as $dayName => $slots) {

			foreach ($slots as $periodNo => $row) {

				$subjectId = $row['subject_id'] ?? null;
				$teacherId = $row['teacher_id'] ?? null;

				// skip empty cells
				if (empty($subjectId) && empty($teacherId)) {
					continue;
				}

				// slot timing
				$startTime = $timeSlots[$periodNo]['start_time'] ?? null;
				$endTime   = $timeSlots[$periodNo]['end_time'] ?? null;

				$insertBatch[] = [
					'stationId' => $StationId,
					'userId'    => $UserId,
					'classId'   => $classId,
					'subjectId' => $subjectId,
					'teacherId' => $teacherId,
					'dayName'   => $dayName,
					'periodNo'  => $periodNo,
					'startTime' => $startTime,
					'addedOn'   => date('Y-m-d H:i:s'),
					'addedBy'   => $UserId,
					'endTime'   => $endTime
				];
			}
		}

		switch ($case) {
			case 'add':
				$this->db->insert_batch('tbl_time_table', $insertBatch);
				if ($this->db->affected_rows() > 0) {
					$Response['status']  = true;
					$Response['message'] = "Time Table Saved Successfully";
				}
				break;

			case 'edit':
				# code...
				break;
		}

		exit(json_encode($Response));
		return;
	}



	public function all_classes($slotNumber = '')
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

		$data = array();

		$data['classes'] = $this->Class_model->get_all_classes_with_student_count($StationId);
		$data['slotNumber'] = $slotNumber;
		$data['slotNumber'] = $slotNumber;

		// echo "<br>";
		// echo "<pre>";
		// print_r($data['student']);
		// die();

		$this->load->view('pages/timetable/all_classes', $data);
	}
}
