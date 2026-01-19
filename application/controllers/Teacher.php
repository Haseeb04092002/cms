<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Teacher extends MY_Controller
{

	public function all_teachers()
	{
		$data = array();
		$data['all_teachers'] = $this->Teacher_model->get_all_teachers();
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

			$IsDuplicate = $this->db->where('firstName', $firstName)->where('contactNo', $contactNo)->get('tbl_staff')->row();
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

			$staffId      = $this->input->post('staffId')??'';
			$firstName    = $this->input->post('firstName')??'';
			$lastName     = $this->input->post('lastName')??'';
			$gender       = $this->input->post('gender')??'';
			$designation  = $this->input->post('designation')??'';
			$department   = $this->input->post('department')??'';
			$contactNo    = $this->input->post('contactNo')??'';
			$email        = $this->input->post('email')??'';
			$joiningDate  = $this->input->post('joiningDate')??'';
			$salary       = $this->input->post('salary')??'';
			$address      = $this->input->post('address')??'';

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
