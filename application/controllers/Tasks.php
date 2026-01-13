<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tasks extends MY_Controller
{
    public function task_assingment()
	{
		$this->load->view('Pages/task_assingment');
	}

    public function upload_task()
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

		// $all_classes = $this->db->where('stationId', $StationId)->where('isDeleted', 0)->order_by('addedOn', 'DESC')->get('tbl_classes')->result();
		// $data['all_classes'] = $all_classes;
		$this->load->view('Pages/upload_task');
	}

	public function student_tasks()
	{
		$UserId    = $this->session->userdata('user_id') ?? '';
		$UserName  = $this->session->userdata('user_name') ?? '';
		$UserEmail = $this->session->userdata('user_email') ?? '';
		$UserRole  = $this->session->userdata('user_role') ?? '';
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
			fe.*,
			c.className,
			c.sectionName,
			d.documentPath
		');

		$this->db->from('tbl_students s');

		/* Class */
		$this->db->join(
			'tbl_classes c',
			'c.classId = s.classId',
			'left'
		);

		$this->db->join(
			'tbl_fees fe',
			'fe.studentId = s.studentId
			AND fe.classId = s.classId
			AND fe.feeType = "admission"
			AND fe.paymentStatus = 1',
			'inner'
		);


		/* Student profile image */
		$this->db->join(
			'tbl_documents d',
			's.admissionNo = d.referenceId
         AND d.referenceType = "student"
         AND d.documentTitle = "profile_img"
         AND d.isDeleted = 0
         AND d.stationId = ' . $this->db->escape($StationId),
			'left'
		);

		$this->db->where('s.stationId', $StationId);
		$this->db->where('s.isDeleted', 0);

		$this->db->order_by('s.addedOn', 'DESC');

		$all_students = $this->db->get()->result();
		$data['all_students'] = $all_students;
		$data['all_classes'] = $all_classes;
		$data['all_education_type'] = $all_education_type;

		// echo "<br>";
		// echo "<pre>";
		// print_r($all_students);
		// die();

		$this->load->view('Pages/student_tasks', $data);
	}
}
