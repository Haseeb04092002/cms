<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Student extends MY_Controller
{

    public function admission_requests()
    {
        $UserId    = $this->session->userdata('user_id') ?? '';
        $UserName  = $this->session->userdata('user_name') ?? '';
        $UserEmail = $this->session->userdata('user_email') ?? '';
        $UserRole  = $this->session->userdata('user_role') ?? '';
        $StationId = $this->session->userdata('station_id') ?? '';

        $this->db->select('
			s.*,
			s.education_type AS student_education_type,

            p.fatherName,
            p.motherName,
            p.guardianName,
            p.parentId,
            p.address,
            p.contactNo,
            p.contactNo2,

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

        /* Parent (FIXED) */
        $this->db->join(
            'tbl_parents p',
            'p.admissionNo = s.admissionNo
            AND p.stationId = ' . $this->db->escape($StationId) . '
            AND p.isDeleted = 0',
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
        $this->db->where('s.status', 'pending');
        $this->db->where('s.isDeleted', 0);

        $this->db->order_by('s.addedOn', 'DESC');

        $all_students = $this->db->get()->result();

        $query = $this->db->query("SHOW COLUMNS FROM tbl_students LIKE 'education_type'");
        $row = $query->row();
        $all_education_type = [];
        if ($row) {
            $enum = str_replace(["enum(", ")", "'"], "", $row->Type);
            $all_education_type = explode(",", $enum);
        }

        $query = $this->db->query("SHOW COLUMNS FROM tbl_students LIKE 'batchYear'");
        $row = $query->row();
        $all_batch_year = [];
        if ($row) {
            $enum = str_replace(["enum(", ")", "'"], "", $row->Type);
            $all_batch_year = explode(",", $enum);
        }

        $all_classes = $this->db->select('classId, className, sectionName')->where('stationId', $StationId)->where('isDeleted', 0)->order_by('addedOn', 'DESC')->get('tbl_classes')->result();

        $data['all_students'] = $all_students;
        $data['all_education_type'] = $all_education_type;
        $data['all_batch_year'] = $all_batch_year;
        $data['all_classes'] = $all_classes;

        // echo "<br>";
        // echo "<pre>";
        // print_r($data['all_students']);
        // die();

        $this->load->view('pages/student/admission_requests', $data);
    }



    public function updated_admission_requests()
    {
        $StationId = $this->session->userdata('station_id') ?? '';
        $rows = json_decode($this->input->post('rows'), true);
        // echo "<pre>";
        // print_r($rows);
        // echo "</pre>";
        // die();

        $Response['status']  = false;
        $Response['message']  = "Some Error Occured. Try Again";

        foreach ($rows as $row) {
            $update = [
                'status'         => $row['status'],
                'addedBy' => $this->session->userdata('user_id'),
                'addedOn'        => date('Y-m-d H:i:s'),
                'isDeleted'      => 0
            ];

            $this->db->where('studentId', $row['studentId']);
            $this->db->where('isDeleted', 0);
            $this->db->where('stationId', $StationId);
            $this->db->update('tbl_students', $update);
        }

        if ($this->db->affected_rows() > 0) {
            $Response['status']  = true;
            $Response['message']  = "Admission Requests Updated Successfully";
            exit(json_encode($Response));
            return;
        }

        exit(json_encode($Response));
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
        $query = $this->db->query("SHOW COLUMNS FROM tbl_students LIKE 'batchYear'");
        $row = $query->row();
        $all_batch_year = [];
        if ($row) {
            $enum = str_replace(["enum(", ")", "'"], "", $row->Type);
            $all_batch_year = explode(",", $enum);
        }
        // echo '<pre>';
        // print_r($row);
        // exit;
        $all_classes = $this->db->where('stationId', $StationId)->where('isDeleted', 0)->order_by('addedOn', 'DESC')->get('tbl_classes')->result();
        $this->load->view('pages/student/admission', [
            'all_genders' => $all_genders,
            'all_classes' => $all_classes,
            'all_education_type' => $all_education_type,
            'all_batch_year' => $all_batch_year,
            'admissionNo' => $date
        ]);
    }

    public function student_attendance()
    {
        $this->load->view('pages/student/student_attendance');
    }

    public function save_admission($case = 'add')
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

        // Admission
        $this->form_validation->set_rules('admission_no', 'admission_no', 'required');
        $this->form_validation->set_rules('education_type', 'education_type', 'required');
        $this->form_validation->set_rules('class_section', 'class_section', 'required');
        $this->form_validation->set_rules('batchYear', 'batchYear', 'required');

        // Student Info
        $this->form_validation->set_rules('student_first_name', 'student_first_name', 'required');
        $this->form_validation->set_rules('student_last_name', 'student_last_name', 'required');
        $this->form_validation->set_rules('dob', 'dob', 'required');
        $this->form_validation->set_rules('gender', 'gender', 'required');

        $this->form_validation->set_rules('contact_1', 'contact_1', 'required');

        $this->form_validation->set_rules('cnic', 'cnic', 'required');
        $this->form_validation->set_rules('address', 'address', 'required');

        if ($this->form_validation->run() == FALSE) {
            $Response['message']  = validation_errors();
            exit(json_encode($Response));
            return;
        } else {

            $case      = $this->input->post('case');
            // Admission
            $admission_no      = $this->input->post('admission_no');
            $education_type    = $this->input->post('education_type');
            $class_section     = $this->input->post('class_section');
            $batchYear     = $this->input->post('batchYear');

            // Student Info
            $student_first_name = $this->input->post('student_first_name');
            $student_last_name  = $this->input->post('student_last_name');
            $dob                = $this->input->post('dob');
            $gender             = $this->input->post('gender');
            $previous_school    = $this->input->post('previous_school');
            $class_section      = $this->input->post('class_section');

            // Other Children (ARRAYS)
            $child_names  = $this->input->post('child_name');   // array
            $child_ages   = $this->input->post('child_age');    // array
            $child_classes  = $this->input->post('child_class');  // array

            $father_name   = $this->input->post('father_name');
            $mother_name   = $this->input->post('mother_name');
            $guardian_name = $this->input->post('guardian_name');

            $contact_1 = $this->input->post('contact_1');
            $contact_2 = $this->input->post('contact_2');

            $email   = $this->input->post('email');
            $cnic    = $this->input->post('cnic');
            $address = $this->input->post('address');

            $student_photo = $_FILES['student_photo']['name'] ?? '';

            // $className = $this->simplify_text($className);

            // Admission
            $admission_no = $this->simplify_text($admission_no);
            $education_type = $this->simplify_text($education_type);
            $class_section = $this->simplify_text($class_section);

            // Student Info
            $student_first_name = $this->simplify_text($student_first_name);
            $student_last_name = $this->simplify_text($student_last_name);
            $dob = $this->simplify_text($dob);
            $gender = $this->simplify_text($gender);
            $previous_school = $this->simplify_text($previous_school);

            $father_name = $this->simplify_text($father_name);
            $mother_name = $this->simplify_text($mother_name);
            $guardian_name = $this->simplify_text($guardian_name);

            $contact_1 = $this->simplify_text($contact_1);
            $contact_2 = $this->simplify_text($contact_2);

            $email = $this->simplify_text($email);
            $cnic = $this->simplify_text($cnic);
            $address = $this->simplify_text($address);

            $data_students = array();
            $data_parents = array();
            $data_siblings = array();

            $data_students['stationId'] = $StationId;
            $data_students['userId'] = $UserId;
            $data_students['status'] = 'pending';
            $data_students['education_type'] = $education_type;
            $data_students['firstName'] = $student_first_name;
            $data_students['lastName'] = $student_last_name;
            $data_students['gender'] = $gender;
            $data_students['dateOfBirth'] = $dob;
            $data_students['prev_school'] = $previous_school;
            $data_students['classId'] = $class_section;
            $data_students['batchYear'] = $batchYear;
            $data_students['addedOn'] = date('Y-m-d H:i:s');
            $data_students['addedBy'] = $UserId;

            $data_parents['fatherName'] = $father_name;
            $data_parents['motherName'] = $mother_name;
            $data_parents['guardianName'] = $guardian_name;
            $data_parents['stationId'] = $StationId;
            $data_parents['userId'] = $UserId;
            $data_parents['contactNo'] = $contact_1;
            $data_parents['contactNo2'] = $contact_2;
            $data_parents['email'] = $email;
            $data_parents['cnic'] = $cnic;
            $data_parents['address'] = $address;
            $data_parents['addedOn'] = date('Y-m-d H:i:s');
            $data_parents['addedBy'] = $UserId;

            $check_students = false;
            $check_parents = false;
            $check_sibling = false;

            // echo "<br>";
            // echo "case = " . $case;

            switch ($case) {

                // =======================
                // ADD CASE
                // =======================
                case 'add':

                    $data_students['admissionDate'] = date('Y-m-d H:i:s');
                    $data_students['admissionNo'] = $admission_no;

                    if (!empty($_FILES['student_photo']['name'])) {

                        $this->load->model('Document_upload');

                        $this->Document_upload->UploadDocuments(
                            $_FILES['student_photo'], // ✅ FULL FILE ARRAY
                            'Student',
                            $admission_no,
                            'image'
                        );
                    }
                    $student_first_name = trim($student_first_name);
                    $student_last_name  = trim($student_last_name);
                    $gender             = trim($gender);
                    $dob                = date('Y-m-d', strtotime($dob));

                    $this->db->where('firstName', $student_first_name);
                    $this->db->where('lastName', $student_last_name);
                    $this->db->where('dateOfBirth', $dob);
                    $this->db->where('gender', $gender);
                    $this->db->where('stationId', $StationId);

                    $IsDuplicate = $this->db->get('tbl_students')->row();

                    if ($IsDuplicate) {
                        $Response['message'] = 'Duplicate Record';
                        echo json_encode($Response);
                        exit;
                    }

                    if (!empty($child_names)) {
                        foreach ($child_names as $key => $name) {
                            if (!empty($name)) {
                                $childData = [
                                    'stationId' => $StationId,
                                    'userId' => $UserId,
                                    'admissionNo' => $admission_no,
                                    'fullName'   => $this->simplify_text($name),
                                    'age'    => $child_ages[$key],
                                    'classId'  => $this->simplify_text($child_classes[$key]),
                                    'addedBy'  => $UserId,
                                    'addedON'  => date('Y-m-d H:i:s'),
                                ];
                                $this->db->insert('tbl_siblings', $childData);
                                if ($this->db->affected_rows() > 0) {
                                    $check_sibling = true;
                                }
                            }
                        }
                    }

                    $this->db->insert('tbl_students', $data_students);
                    if ($this->db->affected_rows() > 0) {
                        $check_students = true;
                    }

                    $data_parents['admissionNo'] = $admission_no;

                    $this->db->insert('tbl_parents', $data_parents);
                    if ($this->db->affected_rows() > 0) {
                        $check_parents = true;
                    }

                    if ($check_parents == true && $check_sibling == true && $check_students == true) {
                        $Response['status']  = true;
                        $Response['message']  = "Student Added Successfully";
                    }

                    break;



                // =======================
                // EDIT CASE
                // =======================
                case 'edit':

                    if (!empty($_FILES['student_photo']['name'])) {

                        $this->load->model('Document_upload');

                        $this->Document_upload->UploadDocuments(
                            $_FILES['student_photo'], // ✅ FULL FILE ARRAY
                            'Student',
                            $admission_no,
                            'image'
                        );
                    }

                    if (!empty($child_names)) {
                        foreach ($child_names as $key => $name) {
                            if (!empty($name)) {
                                $childData = [
                                    'stationId' => $StationId,
                                    'userId' => $UserId,
                                    'fullName'   => $this->simplify_text($name),
                                    'age'    => $child_ages[$key],
                                    'classId'  => $this->simplify_text($child_classes[$key]),
                                    'addedBy'  => $UserId,
                                    'addedON'  => date('Y-m-d H:i:s'),
                                ];
                                $this->db->where('stationId', $StationId)->where('isDeleted', 0)->where('admissionNo', $admission_no)->update('tbl_siblings', $childData);
                                if ($this->db->affected_rows() > 0) {
                                    $Response['status']  = true;
                                }
                            }
                        }
                    }

                    $this->db->where('stationId', $StationId)->where('isDeleted', 0)->where('admissionNo', $admission_no)->update('tbl_students', $data_students);
                    if ($this->db->affected_rows() > 0) {
                        $Response['status']  = true;
                    }
                    $this->db->where('stationId', $StationId)->where('isDeleted', 0)->where('admissionNo', $admission_no)->update('tbl_parents', $data_parents);
                    if ($this->db->affected_rows() > 0) {
                        $Response['status']  = true;
                    }

                    $Response['message']  = "Student Updated Successfully";

                    break;
            }

            // if ($check_parents == true && $check_sibling == true && $check_students == true) {
            exit(json_encode($Response));
            return;
            // }
        }
        exit(json_encode($Response));
    }

    public function save_password($studentId = '')
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
                    ->where('studentId', $studentId)
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
            ->where('studentId', $studentId)
            ->where('isDeleted', 0)
            ->update('tbl_students', $data);

        if ($this->db->affected_rows() > 0) {
            $Response['status']  = true;
            $Response['message'] = "Password Saved Successfully";
        }

        exit(json_encode($Response));
    }


    public function student_data($studentId = '', $admissionNo = '')
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

        $this->db->select('
            tbl_students.*,
            tbl_parents.*,
            tbl_classes.*
        ');
        $this->db->from('tbl_students');
        $this->db->join('tbl_classes', 'tbl_students.classId = tbl_classes.classId');
        $this->db->join('tbl_parents', 'tbl_students.admissionNo = tbl_parents.admissionNo');
        $this->db->where('tbl_students.stationId', $StationId);
        $this->db->where('tbl_students.admissionNo', $admissionNo);
        $this->db->where('tbl_students.studentId', $studentId);
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

    public function student_profile($studentId = '', $admissionNo = '')
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

        $this->db->select('*');
        $this->db->from('tbl_students');
        $this->db->join('tbl_classes', 'tbl_students.classId = tbl_classes.classId');
        $this->db->join('tbl_parents', 'tbl_students.admissionNo = tbl_parents.admissionNo');
        $this->db->where('tbl_students.stationId', $StationId);
        $this->db->where('tbl_students.isDeleted', 0);
        $this->db->where('tbl_students.studentId', $studentId);
        $student = $this->db->get()->row();
        $admissionNo = $this->db->select('admissionNo')->where('stationId', $StationId)->where('studentId', $studentId)->get('tbl_students')->row()->admissionNo;
        $siblings = $this->db
            ->where([
                'stationId' => $StationId,
                'admissionNo' => $admissionNo,
                'isDeleted' => 0
            ])
            ->get('tbl_siblings')
            ->result();
        $all_classes = $this->db->where('stationId', $StationId)->where('isDeleted', 0)->order_by('addedOn', 'DESC')->get('tbl_classes')->result();

        // echo "<br>";
        // print_r($this->db->last_query());
        // die();

        $this->load->view('pages/student/student_profile', [
            'student' => $student,
            'all_classes' => $all_classes,
            'siblings' => $siblings
        ]);
    }

    public function print_student_doc($case = '')
    {
        if ($case !== 'character_certificate') {
            show_error('Invalid document type');
            return;
        }

        require_once APPPATH . 'third_party/dompdf/autoload.inc.php';

        // ===============================
        // HARD-CODED STUDENT DATA
        // ===============================
        $schoolName     = "ABC Model School";
        $schoolAddress  = "Main Road, Islamabad, Pakistan";
        $schoolPhone    = "+92 300 1234567";

        $studentName    = "Muhammad Ali Khan";
        $fatherName     = "Ahmed Khan";
        $admissionNo    = "ADM-2021-045";
        $class          = "Grade 8";
        $session        = "2021 - 2024";
        $conduct        = "excellent";
        $issueDate      = date('d F Y');
        $principalName  = "Mr. Shahid Mehmood";

        // ===============================
        // HTML TEMPLATE (A4)
        // ===============================
        $html = '
            <!DOCTYPE html>
            <html>
            <head>
                <style>
                    @page { margin: 30mm; }

                    body {
                        font-family: "Times New Roman", serif;
                        font-size: 14px;
                        color: #000;
                        line-height: 1.8;
                    }

                    .certificate {
                        border: 6px double #000;
                        padding: 40px;
                        height: 100%;
                    }

                    .header {
                        text-align: center;
                    }

                    .header h1 {
                        margin: 0;
                        font-size: 28px;
                        letter-spacing: 1px;
                    }

                    .header p {
                        margin: 4px 0;
                        font-size: 14px;
                    }

                    .title {
                        text-align: center;
                        margin: 30px 0;
                        font-size: 22px;
                        text-decoration: underline;
                        font-weight: bold;
                    }

                    .content {
                        text-align: justify;
                        font-size: 16px;
                    }

                    .content strong {
                        font-weight: bold;
                    }

                    .footer {
                        margin-top: 60px;
                        display: flex;
                        justify-content: space-between;
                        font-size: 14px;
                    }

                    .signature {
                        text-align: center;
                    }

                    .signature span {
                        display: block;
                        margin-top: 60px;
                        border-top: 1px solid #000;
                        padding-top: 5px;
                        width: 220px;
                        margin-left: auto;
                        margin-right: auto;
                    }
                </style>
            </head>
            <body>

                <div class="certificate">

                    <div class="header">
                        <h1>' . $schoolName . '</h1>
                        <p>' . $schoolAddress . '</p>
                        <p>Phone: ' . $schoolPhone . '</p>
                    </div>

                    <div class="title">
                        CHARACTER CERTIFICATE
                    </div>

                    <div class="content">
                        This is to certify that <strong>' . $studentName . '</strong>,
                        son of <strong>' . $fatherName . '</strong>, bearing Admission No.
                        <strong>' . $admissionNo . '</strong>, was a bonafide student of this
                        institution and studied in <strong>' . $class . '</strong> during
                        the academic session <strong>' . $session . '</strong>.

                        <br><br>

                        During his stay at this school, his conduct and character were found
                        to be <strong>' . ucfirst($conduct) . '</strong>. He has not been involved
                        in any disciplinary activity to the best of our knowledge.

                        <br><br>

                        We wish him every success in his future endeavors.
                    </div>

                    <div class="footer">
                        <div>
                            <strong>Date:</strong> ' . $issueDate . '
                        </div>

                        <div class="signature">
                            <span>
                                ' . $principalName . '<br>
                                <strong>Principal</strong>
                            </span>
                        </div>
                    </div>

                </div>
 
            </body>
            </html>
        ';

        // ===============================
        // DOMPDF CONFIG
        // ===============================
        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);

        // A4 size
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Stream PDF (open in browser)
        $dompdf->stream("character_certificate.pdf", ["Attachment" => 0]);
    }

    public function find_student($case = "")
    {
        $Response['status']  = false;
        $Response['message'] = "Some Error Occured. Try Again";

        $station_id     = $this->session->userdata('station_id');

        $education_type = $this->input->post('education_type') ?? '';
        $class_name     = $this->input->post('class_id') ?? '';
        $section_name   = $this->input->post('section_id') ?? '';
        $student_name   = $this->input->post('student_name') ?? '';
        $batch_year     = $this->input->post('batch_year') ?? '';

        // echo "<br> education_type = ".$education_type; 
        // echo "<br> class_name = ".$class_name;     
        // echo "<br> section_name = ".$section_name;   
        // echo "<br> student_name = ".$student_name;   
        // echo "<br> batch_year = ".$batch_year;     

        if (empty($education_type) && empty($class_name) && empty($section_name) && empty($student_name) && empty($batch_year)) {
            $Response['message'] = "Please select at least one filter.";
            exit(json_encode($Response));
        }

        $students = $this->Student_model->find_students(
            $station_id,
            $education_type,
            $class_name,
            $section_name,
            $student_name,
            $batch_year
        );

        // echo "<br> all students = ".print_r($students, true);
        // die();

        if (empty($students)) {
            $Response['message'] = "No students found matching the criteria.";
            exit(json_encode($Response));
        }
        switch ($case) {
            case 'fee_collection':
                $html = $this->load->view(
                    'commons/student_row_fee_collection',
                    ['records' => $students],
                    true
                );
                break;

            default:
                $html = $this->load->view(
                    'commons/student_row',
                    ['records' => $students],
                    true
                );
                break;
        }

        $Response['status']  = true;
        $Response['message'] = "Students found successfully.";
        $Response['html']    = $html;
        $Response['count']    = count($students);

        exit(json_encode($Response));
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
        $this->db->where('s.status', 'approved');
        $this->db->where('s.isDeleted', 0);

        $this->db->order_by('s.addedOn', 'DESC');

        $all_students = $this->db->get()->result();

        $query = $this->db->query("SHOW COLUMNS FROM tbl_students LIKE 'education_type'");
        $row = $query->row();
        $all_education_type = [];
        if ($row) {
            $enum = str_replace(["enum(", ")", "'"], "", $row->Type);
            $all_education_type = explode(",", $enum);
        }

        $query = $this->db->query("SHOW COLUMNS FROM tbl_students LIKE 'batchYear'");
        $row = $query->row();
        $all_batch_year = [];
        if ($row) {
            $enum = str_replace(["enum(", ")", "'"], "", $row->Type);
            $all_batch_year = explode(",", $enum);
        }

        $all_classes = $this->db->select('classId, className, sectionName')->where('stationId', $StationId)->where('isDeleted', 0)->order_by('addedOn', 'DESC')->get('tbl_classes')->result();

        $data['all_students'] = $all_students;
        $data['all_education_type'] = $all_education_type;
        $data['all_batch_year'] = $all_batch_year;
        $data['all_classes'] = $all_classes;

        // echo "<br>";
        // echo "<pre>";
        // print_r($all_batch_year);
        // die();

        $this->load->view('pages/student/all_students', $data);
    }
}
