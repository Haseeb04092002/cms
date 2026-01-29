<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Teacher extends MY_Controller
{

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

		$data = array();

		$data['classes'] = $this->Class_model->get_all_classes_with_student_count($StationId);

		// echo "<br>";
		// echo "<pre>";
		// print_r($data['student']);
		// die();

		$this->load->view('pages/teacher/all_classes', $data);
	}

	public function dashboard($staffId = '')
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

		$this->db->select('
            tbl_class_subject_assignment.*,
            tbl_staff.firstName, tbl_staff.lastName,
            tbl_classes.className, tbl_classes.sectionName,
            tbl_subjects.subjectName
        ');
        $this->db->from('tbl_class_subject_assignment');
        $this->db->join('tbl_classes', 'tbl_class_subject_assignment.classId = tbl_classes.classId', 'left');
        $this->db->join('tbl_staff', 'tbl_class_subject_assignment.teacherId = tbl_staff.staffId', 'left');
        $this->db->join('tbl_subjects', 'tbl_class_subject_assignment.subjectId = tbl_subjects.subjectId', 'left');
        $this->db->where('tbl_class_subject_assignment.stationId', $StationId);
        $this->db->where('tbl_class_subject_assignment.teacherId', $staffId);
        $this->db->where('tbl_class_subject_assignment.isDeleted', 0);

        $subject_class_assigns = $this->db->get()->result();

		$data = array();
		$teacher = $this->db->where('stationId', $StationId)->where('isDeleted', 0)->where('staffId', $staffId)->get('tbl_staff')->row();
		$data['teacher'] = $teacher;
		$data['subject_class_assigns'] = $subject_class_assigns;

		// echo "<br>";
		// echo "<pre>";
		// // print_r($data['subject_class_assigns']);
		// print_r($this->db->last_query());
		// die();
		$data['suggested_password'] = $this->generate_strong_password(6, 8);
		$this->load->view('pages/teacher/dashboard', $data);
	}

	function generate_strong_password($minLen = 6, $maxLen = 8)
	{
		$lower   = 'abcdefghijklmnopqrstuvwxyz';
		$upper   = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$digits  = '0123456789';
		$special = '!@#$%^&*()-_=+[]{}<>?';

		// Ensure required characters
		$password = [];
		$password[] = $lower[random_int(0, strlen($lower) - 1)];
		$password[] = $upper[random_int(0, strlen($upper) - 1)];
		$password[] = $digits[random_int(0, strlen($digits) - 1)];
		$password[] = $special[random_int(0, strlen($special) - 1)];

		// Random length between 6–8
		$length = random_int($minLen, $maxLen);

		// Character pool
		$all = $lower . $upper . $digits . $special;

		for ($i = count($password); $i < $length; $i++) {
			$password[] = $all[random_int(0, strlen($all) - 1)];
		}

		// Shuffle pattern
		shuffle($password);

		return implode('', $password);
	}

	public function save_password($staffId = '')
	{
		$StationId = $this->session->userdata('station_id') ?? '';

		$Response['status']  = false;
		$Response['message'] = "Some Error Occured. Try Again";

		$old_password     = $this->input->post('old_password') ?? '';
		$new_password     = $this->input->post('new_password') ?? '';
		$confirm_password = $this->input->post('confirm_password') ?? '';
		$case             = $this->input->post('case') ?? '';

		/* ===============================
       COMMON PASSWORD REGEX
       =============================== */
		$password_regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d])\S{6,8}$/';

		switch ($case) {

			/* ===============================
           ADD PASSWORD
           =============================== */
			case 'add':

				$this->form_validation->set_rules(
					'new_password',
					'New Password',
					'required|min_length[6]|max_length[8]'
				);
				$this->form_validation->set_rules(
					'confirm_password',
					'Confirm New Password',
					'required'
				);

				if ($this->form_validation->run() == FALSE) {
					$Response['message'] = validation_errors();
					exit(json_encode($Response));
				}

				if ($new_password !== $confirm_password) {
					$Response['message'] = "Password do not match";
					exit(json_encode($Response));
				}

				if (!preg_match($password_regex, $new_password)) {
					$Response['message'] =
						"Password must be 6–8 characters, include uppercase, lowercase, number, special character, and no spaces.";
					exit(json_encode($Response));
				}

				break;

			/* ===============================
           EDIT PASSWORD
           =============================== */
			case 'edit':

				$this->form_validation->set_rules(
					'old_password',
					'Current Password',
					'required'
				);
				$this->form_validation->set_rules(
					'new_password',
					'New Password',
					'required|min_length[6]|max_length[8]'
				);
				$this->form_validation->set_rules(
					'confirm_password',
					'Confirm New Password',
					'required'
				);

				if ($this->form_validation->run() == FALSE) {
					$Response['message'] = validation_errors();
					exit(json_encode($Response));
				}

				if ($new_password !== $confirm_password) {
					$Response['message'] = "Password do not match";
					exit(json_encode($Response));
				}

				if (!preg_match($password_regex, $new_password)) {
					$Response['message'] =
						"Password must be 6–8 characters, include uppercase, lowercase, number, special character, and no spaces.";
					exit(json_encode($Response));
				}

				$check = $this->db
					->where('stationId', $StationId)
					->where('staffId', $staffId)
					->where("BINARY `password` = " . $this->db->escape($old_password), null, false)
					->where('isDeleted', 0)
					->get('tbl_students')
					->row();

				if (!$check) {
					$Response['message'] = "Current Password is incorrect";
					exit(json_encode($Response));
				}

				break;
		}

		/* ===============================
       SAVE PASSWORD
       =============================== */
		$data['password'] = $new_password;

		$this->db
			->where('stationId', $StationId)
			->where('staffId', $staffId)
			->where('isDeleted', 0)
			->update('tbl_staff', $data);

		if ($this->db->affected_rows() > 0) {
			$Response['status']  = true;
			$Response['message'] = "Password Saved Successfully";
		}

		exit(json_encode($Response));
	}

	public function all_teachers()
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
		$teachers = $this->db->where('stationId', $StationId)->where('isDeleted', 0)->order_by('addedOn', 'DESC')->get('tbl_staff')->result();
		$data['all_teachers'] = $teachers;
		$this->load->view('pages/teacher/all_teachers', $data);
	}

	public function add_teacher()
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

		$this->form_validation->set_rules('firstName', 'First Name', 'required');
		// $this->form_validation->set_rules('lastName', 'Last Name', 'required');
		// $this->form_validation->set_rules('gender', 'Gender', 'required');
		$this->form_validation->set_rules('designation', 'Designation', 'required');
		$this->form_validation->set_rules('department', 'Department', 'required');
		$this->form_validation->set_rules('contactNo', 'Contact No', 'required');
		// $this->form_validation->set_rules('email', 'Email', 'required');
		// $this->form_validation->set_rules('joiningDate', 'Joining Date', 'required');
		// $this->form_validation->set_rules('salary', 'Salary', 'required');
		// $this->form_validation->set_rules('address', 'Address', 'required');


		if ($this->form_validation->run() == FALSE) {
			$Response['message']  = validation_errors();
			exit(json_encode($Response));
			return;
		} else {

			$firstName    = $this->input->post('firstName');
			$lastName     = $this->input->post('lastName');
			$gender       = $this->input->post('gender');
			$designation  = $this->input->post('designation');
			$department   = $this->input->post('department');
			$contactNo    = $this->input->post('contactNo');
			$email        = $this->input->post('email');
			$joiningDate  = $this->input->post('joiningDate');
			$salary       = $this->input->post('salary');
			$address      = $this->input->post('address');

			$firstName   = $this->simplify_text($firstName);
			$lastName    = $this->simplify_text($lastName);
			$designation = $this->simplify_text($designation);
			$department  = $this->simplify_text($department);
			$address     = $this->simplify_text($address);

			$IsDuplicate = $this->db->where('firstName', $firstName)->where('contactNo', $contactNo)->where('stationId', $StationId)->where('isDeleted', 0)->get('tbl_staff')->row();
			if ($IsDuplicate) {
				$Response['message']  = 'Duplicate Record';
				exit(json_encode($Response));
				// return;
			}

			$data = array();

			$data['firstName']   = $firstName;
			$data['lastName']    = $lastName;
			$data['gender']      = $gender;
			$data['designation'] = $designation;
			$data['department']  = $department;
			$data['contactNo']   = $contactNo;
			$data['email']       = $email;
			$data['joiningDate'] = $joiningDate;
			$data['salary']      = $salary;
			$data['address']     = $address;
			$data['stationId']   = $StationId;
			$data['userId']      = $UserId;
			$data['addedOn']     = date('Y-m-d H:i:s');
			$data['addedBy']     = $UserId;


			$this->db->insert('tbl_staff', $data);
			// print_r($this->db->last_query());
			// die();
			if ($this->db->affected_rows() > 0) {

				// $notifi_data = array();
				// $notifi_data['StationId'] = $StationId;
				// $notifi_data['Title'] = 'Data Added';
				// $notifi_data['Message'] = 'Product Added by ' . $StationName;
				// $notifi_data['Type'] = 'In App';
				// $notifi_data['AddedOn'] = date('Y-m-d H:i:s');
				// $notifi_data['AddedBy'] = $UserId;
				// $this->db->insert('tbl_notifications', $notifi_data);

				$Response['status']  = true;
				$Response['message']  = "Teacher Saved Successfully";
				exit(json_encode($Response));
				return;
			}
		}
		exit(json_encode($Response));
	}

	public function delete_teacher()
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

		$staffId = $this->input->post('staffId');

		$data['staffId'] = $staffId;
		$data['stationId'] = $StationId;
		$data['isDeleted'] = 0;

		$check = $this->db->where($data)->update('tbl_staff', ['isDeleted' => 1]);
		// print_r($this->db->last_query());
		// die();
		// if ($this->db->affected_rows() > 0) {
		if ($check) {
			// $notifi_data = array();
			// $notifi_data['StationId'] = $StationId;
			// $notifi_data['Title'] = 'Data Deleted';
			// $notifi_data['Message'] = 'Product Deleted by ' . $StationName;
			// $notifi_data['Type'] = 'In App';
			// $notifi_data['AddedOn'] = date('Y-m-d H:i:s');
			// $notifi_data['AddedBy'] = $UserId;
			// $this->db->insert('tbl_notifications', $notifi_data);

			$Response['status']  = true;
			$Response['message']  = "Teacher Deleted Successfully";
		}
		exit(json_encode($Response));
	}

	public function edit_teacher()
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

		$this->form_validation->set_rules('firstName', 'First Name', 'required');
		// $this->form_validation->set_rules('lastName', 'Last Name', 'required');
		// $this->form_validation->set_rules('gender', 'Gender', 'required');
		$this->form_validation->set_rules('designation', 'Designation', 'required');
		$this->form_validation->set_rules('department', 'Department', 'required');
		$this->form_validation->set_rules('contactNo', 'Contact No', 'required');
		// $this->form_validation->set_rules('email', 'Email', 'required');
		// $this->form_validation->set_rules('joiningDate', 'Joining Date', 'required');
		// $this->form_validation->set_rules('salary', 'Salary', 'required');
		// $this->form_validation->set_rules('address', 'Address', 'required');


		if ($this->form_validation->run() == FALSE) {
			$Response['message']  = validation_errors();
			exit(json_encode($Response));
			return;
		} else {

			$staffId      = $this->input->post('staffId') ?? '';
			$firstName    = $this->input->post('firstName') ?? '';
			$lastName     = $this->input->post('lastName') ?? '';
			$gender       = $this->input->post('gender') ?? '';
			$designation  = $this->input->post('designation') ?? '';
			$department   = $this->input->post('department') ?? '';
			$contactNo    = $this->input->post('contactNo') ?? '';
			$email        = $this->input->post('email') ?? '';
			$joiningDate  = $this->input->post('joiningDate') ?? '';
			$salary       = $this->input->post('salary') ?? '';
			$address      = $this->input->post('address') ?? '';

			$firstName   = $this->simplify_text($firstName);
			$lastName    = $this->simplify_text($lastName);
			$designation = $this->simplify_text($designation);
			$department  = $this->simplify_text($department);
			$address     = $this->simplify_text($address);

			$data = array();

			$data['firstName']   = $firstName;
			$data['lastName']    = $lastName;
			$data['gender']      = $gender;
			$data['designation'] = $designation;
			$data['department']  = $department;
			$data['contactNo']   = $contactNo;
			$data['email']       = $email;
			$data['joiningDate'] = $joiningDate;
			$data['salary']      = $salary;
			$data['address']     = $address;
			$data['stationId']   = $StationId;
			$data['userId']      = $UserId;
			$data['addedOn']     = date('Y-m-d H:i:s');
			$data['addedBy']     = $UserId;


			$this->db
				->where('staffId', $staffId)
				->where('stationId', $StationId)
				->update('tbl_staff', $data);
			// print_r($this->db->last_query());
			// die();
			if ($this->db->affected_rows() > 0) {

				// $notifi_data = array();
				// $notifi_data['StationId'] = $StationId;
				// $notifi_data['Title'] = 'Data Added';
				// $notifi_data['Message'] = 'Product Added by ' . $StationName;
				// $notifi_data['Type'] = 'In App';
				// $notifi_data['AddedOn'] = date('Y-m-d H:i:s');
				// $notifi_data['AddedBy'] = $UserId;
				// $this->db->insert('tbl_notifications', $notifi_data);

				$Response['status']  = true;
				$Response['message']  = "Teacher Updated Successfully";
				exit(json_encode($Response));
				return;
			}
		}
		exit(json_encode($Response));
	}
}
