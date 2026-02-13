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
				$data['className'] = $this->db->select('className, sectionName')->where('stationId', $StationId)->where('isDeleted', 0)->where('classId', $classId)->get('tbl_classes')->row();
				$data['slotNumber'] = $slotNumber;
				$data['days'] = $days;
				$data['subjects'] = $subjects;
				$data['teachers'] = $teachers;
				$data['classId'] = $classId;
				$this->load->view('pages/timetable/time_table_chart_add', $data);

				break;

			case 'edit':

				$rawData = $this->db->select('
					tt.timeTableId,
					tt.stationId,
					tt.userId,
					tt.classId,
					tt.subjectId,
					tt.teacherId,
					tt.dayName,
					tt.periodNo,
					tt.startTime,
					tt.endTime,

					s.subjectName,
					CONCAT(staff.firstName," ",staff.lastName) AS teacherName,
					CONCAT(c.className," ",c.sectionName) AS className
				')
					->from('tbl_time_table tt')
					->join('tbl_subjects s', 's.subjectId = tt.subjectId', 'left')
					->join('tbl_staff staff', 'staff.staffId = tt.teacherId', 'left')
					->join('tbl_classes c', 'c.classId = tt.classId', 'left')
					->where('tt.stationId', $StationId)
					->where('tt.classId', $classId)
					->where('tt.isDeleted', 0)
					->order_by('tt.dayName', 'ASC')
					->order_by('tt.periodNo', 'ASC')
					->get()
					->result();

				$timetableData = [];
				$timeSlots     = [];
				$className = '';

				foreach ($rawData as $row) {

					// Day + Period mapping
					$timetableData[$row->dayName][$row->periodNo] = [
						'subject_id'   => $row->subjectId,
						'subject_name' => $row->subjectName,
						'teacher_id'   => $row->teacherId,
						'teacher_name' => $row->teacherName,
						'class_id'     => $row->classId,
						'class_name'   => $row->className,
						'startTime'    => $row->startTime,
						'endTime'      => $row->endTime,
					];

					// Slot time mapping
					$timeSlots[$row->periodNo] = [
						'startTime' => $row->startTime,
						'endTime'   => $row->endTime
					];

					$className = $row->className;
				}

				$subjects = $this->db->select('subjectName, subjectId')->where('stationId', $StationId)->where('isDeleted', 0)->get('tbl_subjects')->result();
				$teachers = $this->db->select('firstName, lastName, staffId')->where('stationId', $StationId)->where('isDeleted', 0)->get('tbl_staff')->result();
				$data['subjects'] = $subjects;
				$data['teachers'] = $teachers;
				$data['className'] = $className;
				$data['classId'] = $classId;
				$data['timetableData'] = $timetableData;
				$data['timeSlots']     = $timeSlots;
				$data['slotNumber']    = count($timeSlots);
				$data['days']          = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

				// echo "<br>";
				// echo "<pre>";
				// print_r($data);
				// die();

				$this->load->view('pages/timetable/time_table_chart_edit', $data);

				break;
		}
	}

	public function time_table_templates($classId = '')
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

		if ($classId > 0) {
			$data['className'] = $this->db->select('className, sectionName')->where('stationId', $StationId)->where('isDeleted', 0)->where('classId', $classId)->get('tbl_classes')->row();
			$data['classId'] = $classId;
			$this->load->view('pages/timetable/templates', $data);
		} else {
			$this->load->view('pages/timetable/templates');
		}
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
		// print_r($data['classes']);
		// die();

		$this->load->view('pages/timetable/all_time_tables', $data);
	}

	public function student_time_table()
	{
		$stationId = $this->session->userdata('station_id');
		// echo "station id  = ".$stationId;
		$studentId = $this->session->userdata('user_id');
        $classId = $this->db->select('classId')->where('stationId', $stationId)->where('isDeleted', 0)->where('studentId', $studentId)->get('tbl_students')->row()->classId;
		// print_r($this->db->last_query());

		$this->db->select('
            tt.dayName,
            tt.periodNo,
            tt.startTime,
            tt.endTime,
            s.subjectName,
            st.firstName,
            st.lastName
        ');
		$this->db->from('tbl_time_table tt');
		$this->db->join('tbl_subjects s', 's.subjectId = tt.subjectId AND s.isDeleted=0', 'left');
		$this->db->join('tbl_staff st', 'st.staffId = tt.teacherId AND st.isDeleted=0', 'left');
		$this->db->where([
			'tt.stationId' => $stationId,
			'tt.classId'   => $classId,
			'tt.isDeleted' => 0
		]);
		$this->db->order_by('tt.periodNo, tt.startTime');

		$rows = $this->db->get()->result_array();

		$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

		$periods = [];
		$table   = [];

		foreach ($rows as $r) {

			$periodKey = $r['periodNo'] . '|' . $r['startTime'] . '-' . $r['endTime'];
			$periods[$periodKey] = [
				'periodNo' => $r['periodNo'],
				'time'     => $r['startTime'] . ' - ' . $r['endTime']
			];

			$table[$r['periodNo']][$r['dayName']] = $r;
		}

		ksort($periods);

		$data = [
			'days'    => $days,
			'periods' => $periods,
			'table'   => $table,
			'classId' => $classId
		];

		$this->load->view('pages/student/dashboard_student_time_table', $data);
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

				// Soft delete old timetable
				$this->db->where('classId', $classId);
				$this->db->where('stationId', $StationId);
				$this->db->where('isDeleted', 0);
				$this->db->update('tbl_time_table', [
					'isDeleted' => 1
				]);

				// Insert new timetable
				if (!empty($insertBatch)) {
					$this->db->insert_batch('tbl_time_table', $insertBatch);
				}

				if ($this->db->affected_rows() > 0) {
					$Response['status']  = true;
					$Response['message'] = "Time Table Saved Successfully";
				}
				break;
		}

		exit(json_encode($Response));
		return;
	}

	public function delete_timetable()
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

		$classId = $this->input->post('classId');

		$this->db->where('classId', $classId);
		$this->db->where('stationId', $StationId);
		$this->db->where('isDeleted', 0);
		$this->db->update('tbl_time_table', [
			'isDeleted' => 1
		]);

		if ($this->db->affected_rows() > 0) {
			$Response['status']  = true;
			$Response['message'] = "Time Table Deleted Successfully";
		}

		exit(json_encode($Response));
		return;
	}

	public function all_classes($slotNumber = '', $classId = '')
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
		$data['slotNumber'] = $slotNumber;

		// echo "<br>";
		// echo "<pre>";
		// print_r($data);
		// die();

		if ($classId > 0) {
			redirect('Timetable/time_table_chart/' . $classId . '/add/' . $slotNumber);
		} else {
			$data['classes'] = $this->Class_model->get_all_classes_with_student_count($StationId);
			$this->load->view('pages/timetable/all_classes', $data);
		}
	}
}
