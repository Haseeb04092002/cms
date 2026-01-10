<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cms extends MY_Controller
{

	public function index()
	{
		// $this->load->view('Pages/home');
		$this->load->view('master_view');
	}

	public function dashboard()
	{
		$this->load->view('Pages/dashboard');
	}

	public function admission()
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
		// Create a new DateTime object for the current time
		$date = new DateTime();
		// Format the date using the format() method
		$date = $date->format('His');

		$query = $this->db->query("SHOW COLUMNS FROM tbl_students LIKE 'gender'");
		$row = $query->row();

		$all_genders = [];

		if ($row) {
			$enum = str_replace(["enum(", ")", "'"], "", $row->Type);
			$all_genders = explode(",", $enum);
		}

		$query = $this->db->query("SHOW COLUMNS FROM tbl_students LIKE 'education_type'");
		$row = $query->row();

		$all_education_type = [];

		if ($row) {
			// Remove enum( and )
			$enum = str_replace(["enum(", ")", "'"], "", $row->Type);
			$all_education_type = explode(",", $enum);
		}
		// echo '<pre>';
		// print_r($row);
		// exit;
		$all_classes = $this->db->where('stationId', $StationId)->where('isDeleted', 0)->order_by('addedOn', 'DESC')->get('tbl_classes')->result();
		$this->load->view('Pages/admission', [
			'all_genders' => $all_genders,
			'all_classes' => $all_classes,
			'all_education_type' => $all_education_type,
			'admissionNo' => $date
		]);
	}

	public function users()
	{
		$this->load->view('Pages/users');
	}

	public function task_assingment()
	{
		$this->load->view('Pages/task_assingment');
	}

	public function student_tasks()
	{
		$UserId    = $this->session->userdata('user_id') ?? '';
		$UserName  = $this->session->userdata('user_name') ?? '';
		$UserEmail = $this->session->userdata('user_email') ?? '';
		$UserRole  = $this->session->userdata('user_role') ?? '';
		$StationId = $this->session->userdata('station_id') ?? '';

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

		// echo "<br>";
		// echo "<pre>";
		// print_r($all_students);
		// die();

		$this->load->view('Pages/student_tasks', $data);
	}

	public function student_attendance()
	{
		$this->load->view('Pages/student_attendance');
	}

	public function find_student()
	{
		$StationId = $this->session->userdata('station_id') ?? '';

		$education_type = $this->input->post('education_type');
		$class_section  = $this->input->post('class_section');
		$student_name   = $this->input->post('student_name');

		$this->db->select('
			s.studentId,
			s.admissionNo,
			s.addedOn,
			s.education_type AS student_education_type,
			s.firstName,
			s.lastName,
			s.status,

			c.className,
			c.sectionName,

			d.documentPath
		');

		$this->db->from('tbl_students s');
		$this->db->join('tbl_classes c', 'c.classId = s.classId', 'left');

		$this->db->join(
			'tbl_documents d',
			's.admissionNo = d.referenceId
			AND d.referenceType = "student"
			AND d.documentTitle = "profile_img"
			AND d.isDeleted = 0
			AND d.stationId = ' . $this->db->escape($StationId),
			'left'
		);

		if ($education_type) {
			$this->db->where('s.education_type', $education_type);
		}

		if ($class_section) {
			$this->db->where('s.classId', $class_section);
		}

		if ($student_name) {
			$this->db->group_start();
			$this->db->like('s.firstName', $student_name);
			$this->db->or_like('s.lastName', $student_name);
			$this->db->group_end();
		}

		$this->db->where('s.stationId', $StationId);
		$this->db->order_by('s.addedOn', 'DESC');

		$students = $this->db->get()->result_array();

		echo json_encode([
			'status' => true,
			'data'   => $students
		]);
	}


	public function all_students()
	{
		$UserId    = $this->session->userdata('user_id') ?? '';
		$UserName  = $this->session->userdata('user_name') ?? '';
		$UserEmail = $this->session->userdata('user_email') ?? '';
		$UserRole  = $this->session->userdata('user_role') ?? '';
		$StationId = $this->session->userdata('station_id') ?? '';

		$this->db->select('
			s.*,
			s.education_type AS student_education_type,

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

		$this->load->view('Pages/all_students', $data);
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


	public function all_classes()
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
		$data['all_classes'] = $all_classes;
		$this->load->view('Pages/all_classes', $data);
	}

	public function all_sections()
	{
		$this->load->view('Pages/all_sections');
	}

	public function all_teachers()
	{
		$this->load->view('Pages/all_teachers');
	}

	public function hrm()
	{
		$this->load->view('Pages/hrm');
	}

	public function reports()
	{
		$this->load->view('Pages/reports');
	}

	public function courses()
	{
		$this->load->view('Pages/courses');
	}

	public function fees()
	{
		$this->load->view('Pages/fees');
	}

	public function all_expenses()
	{
		$this->load->view('Pages/all_expenses');
	}

	public function fees_structure()
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

		$query = $this->db->query("SHOW COLUMNS FROM tbl_students LIKE 'education_type'");
		$row = $query->row();

		$all_education_type = [];

		if ($row) {
			// Remove enum( and )
			$enum = str_replace(["enum(", ")", "'"], "", $row->Type);
			$all_education_type = explode(",", $enum);
		}

		$query = $this->db->query("SHOW COLUMNS FROM tbl_fee_structure LIKE 'feeType'");
		$row = $query->row();

		$feeType = [];

		if ($row) {
			// Remove enum( and )
			$enum = str_replace(["enum(", ")", "'"], "", $row->Type);
			$feeType = explode(",", $enum);
		}

		$all_classes = $this->db->where('stationId', $StationId)->where('isDeleted', 0)->order_by('addedOn', 'DESC')->get('tbl_classes')->result();
		$all_fee_structures = $this->db->where('stationId', $StationId)->where('isDeleted', 0)->order_by('addedOn', 'DESC')->get('tbl_fee_structure')->result();

		// $this->db->select('*');
		// $this->db->from('tbl_students');
		// $this->db->join('tbl_classes', 'tbl_students.classId = tbl_classes.classId');
		// $this->db->where('tbl_students.stationId', $StationId);
		// $this->db->where('tbl_students.isDeleted', 0);
		// $this->db->order_by('tbl_students.addedOn', 'DESC');
		// $all_students = $this->db->get()->result();

		$data = array();
		$data['all_classes'] = $all_classes;
		$data['all_education_type'] = $all_education_type;
		$data['feeType'] = $feeType;
		$data['all_fee_structures'] = $all_fee_structures;
		$this->load->view('Pages/fees_structure', $data);
	}



	public function fees_collection()
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

		$data = array();

		$data['all_students'] = $all_students;
		$data['all_classes'] = $all_classes;
		$data['all_education_type'] = $all_education_type;

		$this->load->view('Pages/fees_collection', $data);
	}
}
