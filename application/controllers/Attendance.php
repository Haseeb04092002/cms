<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Attendance extends MY_Controller
{
	public function attendance()
	{
		$this->load->view('pages/attendance/attendance');
	}

	public function index()
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

		$this->load->view('pages/attendance/select_class', $data);
	}

	public function save_attendance()
	{
		$rows = json_decode($this->input->post('rows'), true);
		$date = $this->input->post('date');

		// echo "<pre>";
		// print_r($rows);
		// echo "</pre>";
		// die();

		$Response['status']  = false;
		$Response['message']  = "Some Error Occured. Try Again";

		$this->form_validation->set_rules('date', 'Attendance Date', 'required');

		if ($this->form_validation->run() == FALSE) {
			$Response['message']  = validation_errors();
			exit(json_encode($Response));
			return;
		}

		foreach ($rows as $row) {
			$insert = [
				'studentId'      => $row['studentId'],
				'attendanceDate' => $date,
				'status'         => $row['status'],
				'stationId'      => 1,
				'roleId'         => 3,
				'addedBy'        => $this->session->user_id,
				'addedOn'        => date('Y-m-d H:i:s'),
				'isDeleted'      => 0
			];

			// prevent duplicate same day
			$this->db->where('studentId', $row['studentId']);
			$this->db->where('attendanceDate', $date);
			$exists = $this->db->get('tbl_attendance')->row();

			if ($exists)
				$this->db->update('tbl_attendance', $insert, ['attendanceId' => $exists->attendanceId]);
			else
				$this->db->insert('tbl_attendance', $insert);
		}

		if ($this->db->affected_rows() > 0) {
			$Response['status']  = true;
			$Response['message']  = "Attendance Saved Successfully";
			exit(json_encode($Response));
			return;
		}

		exit(json_encode($Response));
	}

	public function mark_attendance($classId = '', $className = '', $sectionName = '')
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

		$all_classes = $this->db->where('stationId', $StationId)->where('isDeleted', 0)->order_by('addedOn', 'DESC')->get('tbl_classes')->result();

		$query = $this->db->query("SHOW COLUMNS FROM tbl_students LIKE 'education_type'");
		$row = $query->row();

		$all_education_type = [];

		if ($row) {
			// Remove enum( and )
			$enum = str_replace(["enum(", ")", "'"], "", $row->Type);
			$all_education_type = explode(",", $enum);
		}

		$this->db->select('
			s.*,
			s.education_type AS student_education_type,
			c.className,
			c.sectionName
		');

		$this->db->from('tbl_students s');

		/* Class */
		$this->db->join(
			'tbl_classes c',
			'c.classId = s.classId',
			'left'
		);

		$this->db->where('s.classId', $classId);
		$this->db->where('s.stationId', $StationId);
		$this->db->where('s.isDeleted', 0);

		$this->db->order_by('s.addedOn', 'DESC');

		$all_students = $this->db->get()->result();

		$data = array();

		$data['all_students'] = $all_students;
		$data['all_classes'] = $all_classes;
		$data['all_education_type'] = $all_education_type;
		$data['classId'] = $classId;
		$data['className'] = $className;
		$data['sectionName'] = $sectionName;

		$this->load->view('pages/attendance/attendance', $data);
	}
}
