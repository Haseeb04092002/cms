<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Subject extends MY_Controller
{

    public function all_subjects()
    {
        $data = array();
        $data['all_subjects'] = $this->Teacher_model->get_all_subject();
        $this->load->view('pages/teacher/all_subjects', $data);
    }

    public function add_subject()
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

        $this->form_validation->set_rules('subjectName', 'Subject Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $Response['message']  = validation_errors();
            exit(json_encode($Response));
            return;
        } else {

            $subjectName    = $this->input->post('subjectName') ?? '';
            $subjectCode    = $this->input->post('subjectCode') ?? '';
            $description    = $this->input->post('description') ?? '';

            $subjectName   = $this->simplify_text($subjectName);
            $description   = $this->simplify_text($description);

            $IsDuplicate = $this->db
                ->where('subjectName', $subjectName)
                ->where('stationId', $StationId)
                ->where('isDeleted', 0)
                ->get('tbl_subjects')->row();
            if ($IsDuplicate) {
                $Response['message']  = 'Duplicate Record';
                exit(json_encode($Response));
                // return;
            }

            $data = array();

            $data['subjectName']   = $subjectName;
            $data['subjectCode']   = $subjectCode;
            $data['description']   = $description;
            $data['stationId']     = $StationId;
            $data['userId']        = $UserId;
            $data['addedOn']       = date('Y-m-d H:i:s');
            $data['addedBy']       = $UserId;

            $this->db->insert('tbl_subjects', $data);
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
                $Response['message']  = "Subject Saved Successfully";
                exit(json_encode($Response));
                return;
            }
        }
        exit(json_encode($Response));
    }

    public function delete_subject()
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

        $subjectId = $this->input->post('subjectId');

        $data['subjectId'] = $subjectId;

        $check = $this->db->where($data)->update('tbl_subjects', ['isDeleted' => 1]);
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
            $Response['message']  = "Subject Deleted Successfully";
        }
        exit(json_encode($Response));
    }

    public function edit_subject()
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

        $this->form_validation->set_rules('subjectName', 'Subject Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $Response['message']  = validation_errors();
            exit(json_encode($Response));
            return;
        } else {

            $subjectId      = $this->input->post('subjectId') ?? '';
            $subjectName    = $this->input->post('subjectName') ?? '';
            $subjectCode    = $this->input->post('subjectCode') ?? '';
            $description    = $this->input->post('description') ?? '';

            $subjectName   = $this->simplify_text($subjectName);
            $description   = $this->simplify_text($description);

            $data = array();

            $data['subjectName']   = $subjectName;
            $data['subjectCode']   = $subjectCode;
            $data['description']   = $description;
            $data['stationId']     = $StationId;
            $data['userId']        = $UserId;
            $data['addedOn']       = date('Y-m-d H:i:s');
            $data['addedBy']       = $UserId;

            $this->db->where('subjectId', $subjectId)->update('tbl_subjects', $data);
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
                $Response['message']  = "Subject Updated Successfully";
                exit(json_encode($Response));
                return;
            }
        }
        exit(json_encode($Response));
    }

    public function find_subject()
	{
		$Response['status']  = false;
		$Response['message'] = "Some Error Occured. Try Again";

		$stationId    = $this->session->userdata('station_id');

		$subjectName  = $this->input->post('subjectName') ?? '';
		$subjectCode  = $this->input->post('subjectCode') ?? '';
		$description  = $this->input->post('description') ?? '';

		if (empty($subjectName) && empty($subjectCode) && empty($description)) {
			$Response['message'] = "Please select at least one filter.";
			exit(json_encode($Response));
		}

		$this->db->select('*')->where('stationId', $stationId)->where('isDeleted', 0);
		if (!empty($subjectName)) {
        $this->db->where('subjectName', $subjectName);
        }
        if (!empty($subjectCode)) {
        $this->db->where('subjectCode', $subjectCode);
        }
        if (!empty($description)) {
        $this->db->where('description', $description);
        }

		$this->db->order_by('addedOn', 'DESC');

		$subjects = $this->db->get('tbl_subjects')->result();
		// echo "<br> all students = ".print_r($students, true);
		// die();
		if (empty($subjects)) {
			$Response['message'] = "No subjects found.";
			exit(json_encode($Response));
		}

		$Response['status']  = true;
		$Response['data'] = $subjects;
		$Response['message'] = "Subjects found successfully.";

		exit(json_encode($Response));
	}
}
