<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fee extends MY_Controller
{
    public function add_fee_structure()
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

        $this->form_validation->set_rules('education_type', 'Education Type', 'required');
        $this->form_validation->set_rules('class_section', 'Class', 'required');
        $this->form_validation->set_rules('fee_type', 'Fee Type', 'required');
        $this->form_validation->set_rules('amount', 'Amount', 'required');
        $this->form_validation->set_rules('effectiveDate', 'Effective Date', 'required');

        if ($this->form_validation->run() == FALSE) {
            $Response['message']  = validation_errors();
            exit(json_encode($Response));
            return;
        } else {

            $education_type = $this->input->post('education_type');
            $class_section = $this->input->post('class_section');
            $fee_type = $this->input->post('fee_type');
            $amount = $this->input->post('amount');
            $effectiveDate = $this->input->post('effectiveDate');

            $data = array();

            $data['education_type'] = $education_type;
            $data['classId'] = $class_section;
            $data['feeType'] = $fee_type;
            $data['amount'] = $amount;
            $data['effectiveFrom'] = $effectiveDate;

            $IsDuplicate = $this->db->where($data)->get('tbl_fee_structure')->row();
            if ($IsDuplicate) {
                $Response['message']  = 'Duplicate Record';
                exit(json_encode($Response));
                // return;
            }

            $data['addedOn'] = date('Y-m-d H:i:s');
            $data['addedBy'] = $UserId;
            $data['stationId'] = $StationId;
            $data['userId'] = $UserId;

            $this->db->insert('tbl_fee_structure', $data);
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
                $Response['message']  = "Fee Structure Saved Successfully";
                exit(json_encode($Response));
                return;
            }
        }
        exit(json_encode($Response));
    }


    public function delete_fee_structure()
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

        $feeStructureId = $this->input->post('feeStructureId');

        $data['feeStructureId'] = $feeStructureId;
        $data['stationId'] = $StationId;

        $check = $this->db->where($data)->update('tbl_fee_structure', ['isDeleted' => 1]);
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
            $Response['message']  = "Deleted Successfully";
        }
        exit(json_encode($Response));
    }


    public function collect_fee()
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

        $this->form_validation->set_rules('payAmount', 'Pay Amount', 'required');
        $this->form_validation->set_rules('paymentMode', 'Payment Mode', 'required');

        if ($this->form_validation->run() == FALSE) {
            $Response['message']  = validation_errors();
            exit(json_encode($Response));
            return;
        } else {

            $studentId = $this->input->post('studentId') ?? null;
            $feeId = $this->input->post('feeId') ?? null;
            $feeType = $this->input->post('feeType') ?? null;
            $classId = $this->input->post('classId') ?? null;
            $education_type = $this->input->post('education_type') ?? null;
            $discount_type = $this->input->post('discount_type') ?? null;
            $discount_value = $this->input->post('discount_value') ?? null;
            $payAmount = $this->input->post('payAmount') ?? null;
            $paymentMode = $this->input->post('paymentMode') ?? null;

            $data = array();

            $data['studentId'] = $studentId;
            $data['classId'] = $classId;
            $data['feeType'] = $feeType;
            $data['education_type'] = $education_type;
            $data['discountType'] = $discount_type;
            $data['discountAmount'] = $discount_value;
            $data['paidAmount'] = $payAmount;
            $data['paymentMode'] = $paymentMode;
            $data['paymentStatus'] = 1;
            $data['addedOn'] = date('Y-m-d H:i:s');
            $data['addedBy'] = $UserId;
            $data['stationId'] = $StationId;
            $data['userId'] = $UserId;

            $this->db->insert('tbl_fees', $data);
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
                $Response['message']  = "Fee Saved Successfully";
                exit(json_encode($Response));
                return;
            }
        }
        exit(json_encode($Response));
    }

    public function my_fees()
    {
        $UserId = '';
        $UserName = '';
        $UserEmail = '';
        $UserRole = '';
        $StationId = '';
        $studentId = $this->session->userdata('user_id') ?? '';
        $UserName = $this->session->userdata('user_name') ?? '';
        $UserEmail = $this->session->userdata('user_email') ?? '';
        $UserRole = $this->session->userdata('user_role') ?? '';
        $stationId = $this->session->userdata('station_id') ?? '';

        $classId = $this->db->select('classId')->where('stationId', $stationId)->where('isDeleted', 0)->where('studentId', $studentId)->get('tbl_students')->row()->classId;

        $this->db->select('feeType, SUM(amount) AS total_fee');
        $this->db->from('tbl_fee_structure');
        $this->db->where([
            'stationId' => $stationId,
            'classId'   => $classId,
            'isDeleted' => 0
        ]);
        $this->db->group_by('feeType');

        $structures = $this->db->get()->result_array();

        $this->db->select('
            feeType,
            SUM(paidAmount)     AS total_paid,
            SUM(discountAmount) AS total_discount
        ');
        $this->db->from('tbl_fees');
        $this->db->where([
            'stationId' => $stationId,
            'studentId' => $studentId,
            'classId'   => $classId,
            'isDeleted' => 0
        ]);
        $this->db->group_by('feeType');

        $payments = $this->db->get()->result_array();

        $pay_index = [];
        foreach ($payments as $p) {
            $pay_index[$p['feeType']] = $p;
        }

        $fee_types = [];

        foreach ($structures as $s) {

            $feeType  = $s['feeType'];
            $paid     = (float) ($pay_index[$feeType]['total_paid'] ?? 0);
            $discount = (float) ($pay_index[$feeType]['total_discount'] ?? 0);

            $remaining = max(0, $s['total_fee'] - ($paid + $discount));

            $fee_types[] = [
                'feeType'    => $feeType,
                'total_fee' => (float)$s['total_fee'],
                'paid'      => $paid,
                'discount'  => $discount,
                'remaining' => $remaining
            ];
        }

        $data['fee_types'] = $fee_types;

        $this->load->view('pages/student/dashboard_student_fees', $data);
    }

    public function all_student_fee_data()
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

        $education_type = $this->input->post('education_type');
        $studentId = $this->input->post('studentId');
        $classId = $this->input->post('classId');

        $this->db->select('
            tbl_students.*,
            tbl_fees.*
        ');
        $this->db->from('tbl_students');
        $this->db->join('tbl_fees', 'tbl_students.studentId = tbl_fees.studentId');
        $this->db->where('tbl_students.stationId', $StationId);
        $this->db->where('tbl_students.studentId', $studentId);
        $this->db->where('tbl_students.education_type', $education_type);
        $this->db->where('tbl_students.isDeleted', 0);
        $this->db->group_by('tbl_students.studentId');

        $student = $this->db->get()->row();
        $siblings = $this->db
            ->where([
                'stationId' => $StationId,
                'admissionNo' => $admissionNo,
                'isDeleted' => 0
            ])
            ->get('tbl_siblings')
            ->result();
        $all_classes = $this->db->where('stationId', $StationId)->where('isDeleted', 0)->order_by('addedOn', 'DESC')->get('tbl_classes')->result();
        $img = $this->db
            ->where([
                'stationId' => $StationId,
                'referenceType' => 'student',
                'isDeleted' => 0,
                'referenceId'   => $admissionNo,
                'documentTitle' => 'profile_img'
            ])
            ->get('tbl_documents')
            ->row();

        // print_r($this->db->last_query());
        // die();

        $this->load->view('pages/student/admission', [
            'student' => $student,
            'all_education_type' => $all_education_type,
            'all_classes' => $all_classes,
            'student_img' => $img,
            'siblings' => $siblings,
            'all_genders' => $all_genders,
            'case' => 'edit',
        ]);

        // echo "<br>";
        // echo "<pre>";
        // print_r($student);
        // die();
    }

    public function fees()
    {
        $this->load->view('pages/finance/fees');
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
        $this->load->view('pages/finance/fees_structure', $data);
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

        $this->load->view('pages/finance/fees_collection', $data);
    }
}
