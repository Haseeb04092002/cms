<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Exams extends MY_Controller
{
	public function exam_dashboard()
	{
		$StationId = $this->session->userdata('station_id') ?? '';
		$classes = $this->db->select('className, sectionName, classId')->from('tbl_classes')->where('stationId', $StationId)->where('isDeleted', 0)->get()->result();
		$data = array();
		$data['classes'] = $classes;
		// echo "<br>";
		// echo "<pre>";
		// print_r($data);
		// die();
		$this->load->view('pages/exam/exam_dashboard', $data);
	}

	public function create()
	{
		$this->load->view('pages/exam/exam_create');
	}

	public function create_exam_for_student()
	{
		$this->load->view('pages/exam/create_exam_for_student');
	}

	public function create_exam_for_class($classid = '', $className = '', $sectionName = '')
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

		$all_exam_types = [];
		$all_education_types = [];

		$query = $this->db->query("SHOW COLUMNS FROM tbl_exams LIKE 'examType'");
		$row = $query->row();
		if ($row) {
			$enum = str_replace(["enum(", ")", "'"], "", $row->Type);
			$all_exam_types = explode(",", $enum);
		}

		$query = $this->db->query("SHOW COLUMNS FROM tbl_exams LIKE 'educationType'");
		$row = $query->row();
		if ($row) {
			$enum = str_replace(["enum(", ")", "'"], "", $row->Type);
			$all_education_types = explode(",", $enum);
		}

		$all_subjects = $this->db->select('subjectName, subjectId')->from('tbl_subjects')->where('stationId', $StationId)->where('isDeleted', 0)->get()->result();

		$data['classId'] = $classid;
		$data['className'] = $className;
		$data['sectionName'] = $sectionName;
		$data['all_exam_types'] = $all_exam_types;
		$data['all_education_types'] = $all_education_types;
		$data['all_subjects'] = $all_subjects;
		// echo "<br>";
		// echo "<pre>";
		// print_r($data);
		// die();
		$this->load->view('pages/exam/create_exam_for_class', $data);
	}

	public function select_class()
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
		$this->load->view('pages/exam/select_class', $data);
	}


	public function class_exams()
	{
		$stationId = $this->session->userdata('station_id');
		// echo "station id  = ".$stationId;
		$studentId = $this->session->userdata('user_id');
		$classId = $this->db->select('classId')->where('stationId', $stationId)->where('isDeleted', 0)->where('studentId', $studentId)->get('tbl_students')->row()->classId;
		/* -----------------------------
           FETCH EXAMS
        ------------------------------*/
		$this->db->select('
            e.examTitle,
            e.examType,
            e.examDate,
            e.resultDate,
            e.duration,
            e.totalMarks,
            e.passingMarks,
            e.obtainedMarks,
            e.examStatus,
            e.weightage,
            s.subjectName
        ');
		$this->db->from('tbl_exams e');
		$this->db->join('tbl_subjects s', 's.subjectId = e.subjectId AND s.isDeleted=0', 'left');
		$this->db->where([
			'e.stationId' => $stationId,
			'e.classId'   => $classId,
			'e.isDeleted' => 0
		]);
		$this->db->order_by('e.examDate', 'ASC');

		$exams = $this->db->get()->result_array();

		$data['exams']   = $exams;
		$data['classId'] = $classId;

		$this->load->view('pages/student/dashboard_student_exams', $data);
	}

	public function view_exam($examId = '')
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
		$UserRoleId = $this->session->userdata('user_role_id') ?? '';
		$StationId = $this->session->userdata('station_id') ?? '';

		$this->db->select('
			exam.*,
			class.className,
			class.sectionName,
			subject.subjectName,
			student.firstName,
			student.lastName,
		');
		$this->db->from('tbl_exams as exam');
		$this->db->join('tbl_classes as class', 'exam.classId = class.classId', 'left');
		$this->db->join('tbl_subjects as subject', 'exam.subjectId = subject.subjectId', 'left');
		$this->db->join('tbl_students as student', 'exam.studentId = student.studentId', 'left');
		$this->db->where('exam.stationId', $StationId);
		$this->db->where('exam.examId', $examId);
		$this->db->where('exam.isDeleted', 0);
		$this->db->order_by('exam.examId', 'DESC');
		$data['exam'] = $this->db->get()->row();

		$all_exam_types = [];
		$all_education_types = [];
		$examStatus = [];

		$query = $this->db->query("SHOW COLUMNS FROM tbl_exams LIKE 'examType'");
		$row = $query->row();
		if ($row) {
			$enum = str_replace(["enum(", ")", "'"], "", $row->Type);
			$all_exam_types = explode(",", $enum);
		}

		$query = $this->db->query("SHOW COLUMNS FROM tbl_exams LIKE 'examStatus'");
		$row = $query->row();
		if ($row) {
			$enum = str_replace(["enum(", ")", "'"], "", $row->Type);
			$examStatus = explode(",", $enum);
		}

		$query = $this->db->query("SHOW COLUMNS FROM tbl_exams LIKE 'educationType'");
		$row = $query->row();
		if ($row) {
			$enum = str_replace(["enum(", ")", "'"], "", $row->Type);
			$all_education_types = explode(",", $enum);
		}

		$all_subjects = $this->db->select('subjectName, subjectId')->from('tbl_subjects')->where('stationId', $StationId)->where('isDeleted', 0)->get()->result();

		$data['all_exam_types'] = $all_exam_types;
		$data['all_education_types'] = $all_education_types;
		$data['all_subjects'] = $all_subjects;
		$data['examStatus'] = $examStatus;

		// echo "<br>";
		// echo "<pre>";
		// print_r($data);
		// die();

		$this->load->view('pages/exam/view_exam', $data);
	}

	public function all_exams()
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
		$UserRoleId = $this->session->userdata('user_role_id') ?? '';
		$StationId = $this->session->userdata('station_id') ?? '';

		$this->db->select('
			exam.*,
			class.className,
			class.sectionName,
			subject.subjectName,
			student.firstName,
			student.lastName,
		');
		$this->db->from('tbl_exams as exam');
		$this->db->join('tbl_classes as class', 'exam.classId = class.classId', 'left');
		$this->db->join('tbl_subjects as subject', 'exam.subjectId = subject.subjectId', 'left');
		$this->db->join('tbl_students as student', 'exam.studentId = student.studentId', 'left');
		$this->db->where('exam.stationId', $StationId);
		$this->db->where('exam.isDeleted', 0);
		$this->db->order_by('exam.examId', 'DESC');
		$data['all_exams'] = $this->db->get()->result();

		$this->load->view('pages/exam/all_exams', $data);
	}

	public function save_exam($case = 'add')
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
		$UserRoleId = $this->session->userdata('user_role_id') ?? '';
		$StationId = $this->session->userdata('station_id') ?? '';

		$Response['status']  = false;
		$Response['message']  = "Some Error Occured. Try Again";

		// Admission
		$this->form_validation->set_rules('exam_title', 'exam_title', 'required');
		$this->form_validation->set_rules('exam_type', 'exam_type', 'required');
		// $this->form_validation->set_rules('education_type', 'education_type', 'required');
		$this->form_validation->set_rules('subject', 'subject', 'required');
		$this->form_validation->set_rules('exam_date', 'exam_date', 'required');
		$this->form_validation->set_rules('result_date', 'result_date', 'required');
		$this->form_validation->set_rules('duration_minutes', 'duration_minutes', 'required');
		$this->form_validation->set_rules('total_marks', 'total_marks', 'required');
		$this->form_validation->set_rules('passing_marks', 'passing_marks', 'required');
		// $this->form_validation->set_rules('weightage', 'weightage', 'required');

		if ($this->form_validation->run() == FALSE) {
			$Response['message']  = validation_errors();
			exit(json_encode($Response));
			return;
		} else {

			$examId = $this->input->post('examId') ?? '';
			$exam_title = $this->input->post('exam_title') ?? '';
			$classId = $this->input->post('classId') ?? '';
			$exam_type = $this->input->post('exam_type') ?? '';
			$education_type = $this->input->post('education_type') ?? '';
			$subject = $this->input->post('subject') ?? '';
			$exam_date = $this->input->post('exam_date') ?? '';
			$result_date = $this->input->post('result_date') ?? '';
			$duration_minutes = $this->input->post('duration_minutes') ?? '';
			$total_marks = $this->input->post('total_marks') ?? '';
			$passing_marks = $this->input->post('passing_marks') ?? '';
			$weightage = $this->input->post('weightage') ?? '';
			$obtainedMarks = $this->input->post('obtainedMarks') ?? '';
			$examStatus = $this->input->post('examStatus') ?? '';

			$data = array();

			$data['stationId'] = $StationId;
			$data['userId'] = $UserId;
			$data['roleId'] = $UserRoleId;
			$data['classId'] = $classId;
			$data['examTitle'] = $exam_title;
			$data['examType'] = $exam_type;
			$data['educationType'] = $education_type;
			$data['subjectId'] = $subject;
			$data['examDate'] = date('Y-m-d', strtotime($exam_date));
			$data['resultDate'] = date('Y-m-d', strtotime($result_date));
			$data['duration'] = $duration_minutes;
			$data['totalMarks'] = $total_marks;
			$data['passingMarks'] = $passing_marks;
			$data['weightage'] = floatval($weightage);
			$data['description'] = trim($this->input->post('instructions') ?? '');
			$data['addedOn'] = date('Y-m-d H:i:s');
			$data['addedBy'] = $UserId;

			// echo "<br>";
			// echo "case = " . $case;

			switch ($case) {

				case 'add':

					$this->db->insert('tbl_exams', $data);
					if ($this->db->affected_rows() > 0) {
						$Response['status']  = true;
						$Response['message']  = "Exam Saved Successfully";
					}

					break;

				case 'edit':

					$data['obtainedMarks'] = floatval($obtainedMarks);
					$data['examStatus'] = $examStatus;

					// print_r($data);
					// die();
					$this->db->where('examId', $examId)->where('stationId', $StationId)->where('isDeleted', 0)->update('tbl_exams', $data);
					if ($this->db->affected_rows() > 0) {
						$Response['status']  = true;
						$Response['message']  = "Exam Updated Successfully";
					}

					break;
			}

			exit(json_encode($Response));
			return;
		}
		exit(json_encode($Response));
	}
}
