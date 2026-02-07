<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Classes extends MY_Controller
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

        // $all_classes = $this->db->where('stationId', $StationId)->where('isDeleted', 0)->order_by('addedOn', 'DESC')->get('tbl_classes')->result();
        $this->db->select('
            c.classId,
            c.className,
            c.sectionName,
            COUNT(DISTINCT s.studentId) AS total_students,

            st.staffId AS head_teacher_id,
            CONCAT(st.firstName, " ", st.lastName) AS head_teacher_name
        ');

        $this->db->from('tbl_classes c');

        $this->db->join(
            'tbl_students s',
            's.classId = c.classId 
         AND s.stationId = c.stationId
         AND s.isDeleted IS NULL',
            'left'
        );

        $this->db->join(
            'tbl_class_subject_assignment a',
            'a.classId = c.classId 
         AND a.stationId = c.stationId',
            'left'
        );

        $this->db->join(
            'tbl_staff st',
            'st.staffId = a.headClassId
         AND st.stationId = c.stationId',
            'left'
        );

        if (!empty($class_name)) {
            $this->db->where('c.classId', $class_name);
        }
        if (!empty($section_name)) {
            $this->db->where('c.classId', $section_name);
        }

        $this->db->where('c.stationId', $StationId);
        $this->db->where('c.isDeleted', 0);
        $this->db->group_by('c.classId');
        $this->db->order_by('c.addedOn', 'DESC');
        $all_classes = $this->db->get()->result();
        $data['all_classes'] = $all_classes;
        $this->load->view('pages/class/all_classes', $data);
    }

    public function all_sections()
    {
        $this->load->view('pages/class/all_sections');
    }

    public function add_class()
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

        $this->form_validation->set_rules('className', 'Class Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $Response['message']  = validation_errors();
            exit(json_encode($Response));
            return;
        } else {

            $className = $this->input->post('className');
            $sectionName = $this->input->post('sectionName');

            $className = $this->simplify_text($className);
            $sectionName = $this->simplify_text($sectionName);

            $IsDuplicate = $this->db->where('className', $className)->where('sectionName', $sectionName)->get('tbl_classes')->row();
            if ($IsDuplicate) {
                $Response['message']  = 'Duplicate Record';
                exit(json_encode($Response));
                // return;
            }

            $data['className'] = $className;
            $data['sectionName'] = $sectionName;
            $data['stationId'] = $StationId;
            $data['AddedOn'] = date('Y-m-d H:i:s');
            $data['AddedBy'] = $UserId;

            $this->db->insert('tbl_classes', $data);
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
                $Response['message']  = "Class added Successfully";
                exit(json_encode($Response));
                return;
            }
        }
        exit(json_encode($Response));
    }

    public function delete_class()
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

        $classId = $this->input->post('classId');

        $data['classId'] = $classId;

        $check = $this->db->where($data)->update('tbl_classes', ['isDeleted' => 1]);
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
            $Response['message']  = "Class Deleted Successfully";
        }
        exit(json_encode($Response));
    }


    public function find_class()
    {
        $Response['status']  = false;
        $Response['message'] = "Some Error Occured. Try Again";

        $station_id     = $this->session->userdata('station_id');

        $class_name     = $this->input->post('class_id') ?? '';
        $section_name   = $this->input->post('section_id') ?? '';

        if (empty($class_name) && empty($section_name)) {
            $Response['message'] = "Please select at least one filter.";
            exit(json_encode($Response));
        }

        $this->db->select('
            c.classId,
            c.className,
            c.sectionName,
            COUNT(DISTINCT s.studentId) AS total_students,

            st.staffId AS head_teacher_id,
            CONCAT(st.firstName, " ", st.lastName) AS head_teacher_name
        ');

        $this->db->from('tbl_classes c');

        $this->db->join(
            'tbl_students s',
            's.classId = c.classId 
         AND s.stationId = c.stationId
         AND s.isDeleted IS NULL',
            'left'
        );

        $this->db->join(
            'tbl_class_subject_assignment a',
            'a.classId = c.classId 
         AND a.stationId = c.stationId',
            'left'
        );

        $this->db->join(
            'tbl_staff st',
            'st.staffId = a.headClassId
         AND st.stationId = c.stationId',
            'left'
        );

        if (!empty($class_name)) {
            $this->db->where('c.classId', $class_name);
        }
        if (!empty($section_name)) {
            $this->db->where('c.classId', $section_name);
        }

        $this->db->where('c.stationId', $station_id);
        $this->db->where('c.isDeleted', 0);
        $this->db->group_by('c.classId');
        $this->db->order_by('c.addedOn', 'DESC');
        $classes = $this->db->get()->result();
        // echo "<br> all students = ".print_r($students, true);
        // die();
        if (empty($classes)) {
            $Response['message'] = "No students found matching the criteria.";
            exit(json_encode($Response));
        }

        $Response['status']  = true;
        $Response['data'] = $classes;
        $Response['message'] = "Classes found successfully.";

        exit(json_encode($Response));
    }



    public function edit_class()
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

        $this->form_validation->set_rules('className', 'Class Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $Response['message']  = validation_errors();
            exit(json_encode($Response));
            return;
        } else {

            $classId = $this->input->post('classId');
            $className = $this->input->post('className');
            $sectionName = $this->input->post('sectionName');

            $className = $this->simplify_text($className);
            $sectionName = $this->simplify_text($sectionName);

            $data['className'] = $className;
            $data['sectionName'] = $sectionName;

            $this->db->where('classId', $classId)->update('tbl_classes', $data);
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
                $Response['message']  = "Class Updated Successfully";
                exit(json_encode($Response));
                return;
            }
        }
        exit(json_encode($Response));
    }
}
