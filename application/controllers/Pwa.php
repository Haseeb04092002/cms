<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pwa extends MY_Controller
{
	public function index()
	{
		if (!$this->session->userdata('user_id')) {
			redirect('Pwa/login');
		} else {
			$this->load->view('pwa/master_view');
		}
	}


	public function login()
    {
        $sql = "select roleName from tbl_user_roles where roleId in (25, 27, 28, 33)";
        $user_roles = $this->db->query($sql)->result();
        $data = array();
        $data['user_roles'] = $user_roles;
        $this->load->view('pwa/login', $data);
    }

	public function logout()
    {
        // Clear all session data properly
        $this->session->unset_userdata([
            'user_id',
            'user_name',
            'user_email',
            'station_id',
            'last_activity'
        ]);
        $this->session->sess_destroy();
        redirect('Pwa/login');
    }

	public function tasks()
    {
        $this->load->view('pwa/student/tasks');
    }


	public function progress()
    {
        $this->load->view('pwa/student/progress');
    }

	public function fees()
    {
        $this->load->view('pwa/student/fees');
    }

	public function calendar()
    {
        $this->load->view('pwa/student/calendar');
    }


	public function dashboard($case = 'Admin')
	{
		switch ($case) {
			case 'Admin':
				$this->load->view('pwa/admin/dashboard');
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

				$this->load->view('pwa/student/dashboard', [
					'student' => $student,
					'all_classes' => $all_classes,
					'siblings' => $siblings
				]);

				// echo "<br>";
				// echo "<pre>";
				// // print_r($all_classes);
				// print_r($student);
				// print_r($siblings);
				// die();
				break;
		}
	}
}
