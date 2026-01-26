<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cms extends MY_Controller
{

	public function index()
	{
		$this->load->view('master_view');
	}

	public function dashboard($case = 'Admin')
	{
		switch ($case) {
			case 'Admin':
				$this->load->view('pages/admin/dashboard');
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
