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
        $this->output->set_header('X-Page-Title: Admissions Requests');
        $this->load->view('pages/student/admission_requests', $data);
    }



    public function updated_admission_requests()
    {
        $StationId = $this->session->userdata('station_id') ?? '';
        $rows = json_decode($this->input->post('rows'), true);

        $Response = [
            'status'  => false,
            'message' => 'Some Error Occured. Try Again'
        ];

        if (empty($rows)) {
            $Response['message'] = 'No students selected';
            exit(json_encode($Response));
        }

        foreach ($rows as $row) {

            if (empty($row['studentId']) || empty($row['status'])) {
                continue;
            }

            $update = [
                'status'    => $row['status'],
                'addedBy'   => $this->session->userdata('user_id'),
                'addedOn'   => date('Y-m-d H:i:s'),
                'isDeleted' => 0
            ];

            $this->db->where('studentId', $row['studentId']);
            $this->db->where('isDeleted', 0);
            $this->db->where('stationId', $StationId);
            $this->db->update('tbl_students', $update);
        }

        if ($this->db->affected_rows() > 0) {
            $Response['status']  = true;
            $Response['message'] = "Admission Requests Updated Successfully";
        } else {
            $Response['message'] = "No changes detected";
        }

        $this->output->set_header('X-Page-Title: Admissions Requests');
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
        $this->output->set_header('X-Page-Title: Admissions Portal');
        $this->load->view('pages/student/admission', [
            'all_genders' => $all_genders,
            'all_classes' => $all_classes,
            'all_education_type' => $all_education_type,
            'all_batch_year' => $all_batch_year
            // 'admissionNo' => $date
        ]);
    }

    public function student_attendance()
    {
        $this->output->set_header('X-Page-Title: Attendance');
        $this->load->view('pages/student/student_attendance');
    }

    public function save_admission()
    {
        $UserId     = $this->session->userdata('user_id');
        $StationId  = $this->session->userdata('station_id');

        $Response = [
            'status'  => false,
            'message' => 'Some Error Occured. Try Again'
        ];

        $this->form_validation->set_rules('admission_no', 'Admission No', 'required');
        $this->form_validation->set_rules('education_type', 'Education Type', 'required');
        $this->form_validation->set_rules('class_section', 'Class Section', 'required');
        $this->form_validation->set_rules('batchYear', 'Batch Year', 'required');

        $this->form_validation->set_rules('student_first_name', 'First Name', 'required');
        // $this->form_validation->set_rules('student_last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('dob', 'Date of Birth', 'required');
        $this->form_validation->set_rules('gender', 'Gender', 'required');

        // $this->form_validation->set_rules('guardian_name', 'Guardian Name', 'required');
        $this->form_validation->set_rules('contact_1', 'Contact 1', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');

        if ($this->form_validation->run() == FALSE) {
            $Response['message'] = strip_tags(validation_errors());
            exit(json_encode($Response));
        }

        $case = $this->input->post('case');

        $admission_no  = $this->input->post('admission_no');
        $education_type = $this->input->post('education_type');
        $class_section = $this->input->post('class_section');
        $batchYear     = $this->input->post('batchYear');

        $firstName     = $this->input->post('student_first_name');
        $lastName      = $this->input->post('student_last_name');
        $dob           = $this->input->post('dob');
        $gender        = $this->input->post('gender');
        $prev_school   = $this->input->post('previous_school');

        $father_name = $this->input->post('father_name');
        $mother_name = $this->input->post('mother_name');
        $guardian_name = $this->input->post('guardian_name');
        $contact_1     = $this->input->post('contact_1');
        $contact_2     = $this->input->post('contact_2');
        $contact_3     = $this->input->post('contact_3');
        $email         = $this->input->post('email');
        $cnic          = $this->input->post('cnic');
        $address       = $this->input->post('address');

        $studentData = [
            'stationId'      => $StationId,
            'education_type' => $education_type,
            'firstName'      => $firstName,
            'lastName'       => $lastName,
            'gender'         => $gender,
            'dateOfBirth'    => $dob,
            'prev_school'    => $prev_school,
            'classId'        => $class_section,
            'batchYear'      => $batchYear,
            'addedOn'        => date('Y-m-d H:i:s'),
            'addedBy'        => $UserId,
            'status'         => 'approved'
        ];

        $parentData = [
            'stationId'   => $StationId,
            'admissionNo' => $admission_no,
            'guardianName' => $guardian_name,
            'fatherName' => $father_name,
            'motherName' => $mother_name,
            'contactNo'   => $contact_1,
            'contactNo2'  => $contact_2,
            'contactNo3'  => $contact_3,
            'email'       => $email,
            'cnic'        => $cnic,
            'address'     => $address,
            'addedOn'     => date('Y-m-d H:i:s'),
            'addedBy'     => $UserId
        ];

        if ($case == 'add') {

            $studentData['admissionNo'] = $admission_no;
            $studentData['admissionDate'] = date('Y-m-d H:i:s');

            $this->db->insert('tbl_students', $studentData);
            $this->db->insert('tbl_parents', $parentData);

            $Response['status'] = true;
            $Response['message'] = "Student Added Successfully";
        }

        if ($case == 'edit') {

            $this->db->where('admissionNo', $admission_no)
                ->where('stationId', $StationId)
                ->update('tbl_students', $studentData);

            $this->db->where('admissionNo', $admission_no)
                ->where('stationId', $StationId)
                ->update('tbl_parents', $parentData);

            $Response['status'] = true;
            $Response['message'] = "Student Updated Successfully";
        }

        $this->output->set_header('X-Page-Title: Admissions');
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

        $this->output->set_header('X-Page-Title: Student Password');

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

        $query = $this->db->query("SHOW COLUMNS FROM tbl_students LIKE 'batchYear'");
        $row = $query->row();
        $all_batch_year = [];
        if ($row) {
            $enum = str_replace(["enum(", ")", "'"], "", $row->Type);
            $all_batch_year = explode(",", $enum);
        }

        // print_r($this->db->last_query());
        // die();

        $this->output->set_header('X-Page-Title: Student Details');

        $this->load->view('pages/student/admission', [
            'student' => $student,
            'all_education_type' => $all_education_type,
            'all_classes' => $all_classes,
            'student_img' => $img,
            'all_batch_year' => $all_batch_year,
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

        $this->output->set_header('X-Page-Title: Student Dashboard');
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

        $this->output->set_header('X-Page-Title: All Students');
        $this->load->view('pages/student/all_students', $data);
    }

    public function delete_student()
    {
        $Response = [
            'status' => false,
            'message' => 'Some Error Occured. Try Again'
        ];
        
        $StationId = $this->session->userdata('station_id');
        $studentId = $this->input->post('studentId');
        
        if (empty($studentId)) {
            $Response['message'] = "Invalid Request";
            exit(json_encode($Response));
        }

        $this->db->where('studentId', $studentId);
        $this->db->where('stationId', $StationId);
        $this->db->update('tbl_students', ['isDeleted' => 1]);

        if ($this->db->affected_rows() > 0) {
            $Response['status'] = true;
            $Response['message'] = "Student deleted successfully.";
        }

        exit(json_encode($Response));
    }

    public function update_batch_year() {
        $years = [];
        for ($i = 2010; $i <= 2030; $i++) {
            $next_year = substr((string)($i + 1), -2);
            $years[] = "'" . $i . "-" . $next_year . "'";
        }
        $enum_str = implode(',', $years);

        $tables = $this->db->query("SELECT TABLE_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND COLUMN_NAME = 'batchYear'")->result();

        foreach ($tables as $t) {
            $table = $t->TABLE_NAME;
            $sql = "ALTER TABLE $table MODIFY COLUMN batchYear ENUM($enum_str) DEFAULT NULL";
            if ($this->db->query($sql)) {
                echo "$table altered successfully.<br>";
            } else {
                echo "Error altering $table.<br>";
            }
        }
        echo "Done.";
    }
}
