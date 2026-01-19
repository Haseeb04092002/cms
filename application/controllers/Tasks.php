<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tasks extends MY_Controller
{
	public function task_assingment()
	{
		$this->load->view('pages/task/task_assingment');
	}

	public function upload_task($case = 'student', $userId = '')
	{
		switch ($case) {
			case 'student':
				$data = array();

				$data['student'] = $this->Student_model->get_student_by_id($userId);
				$data['subjects'] = $this->Subject_model->get_all_subjects();
				$data['tasks'] = $this->Task_model->get_tasks_by_student($userId, $data['student']->classId);

				// echo "<br>";
				// echo "<pre>";
				// print_r($data['student']);
				// die();

				$this->load->view('pages/task/upload_task', $data);
				break;

			case 'teacher':
				# code...
				break;
		}

		// $all_classes = $this->db->where('stationId', $StationId)->where('isDeleted', 0)->order_by('addedOn', 'DESC')->get('tbl_classes')->result();
		// $data['all_classes'] = $all_classes;
	}


	public function bulk_tasks()
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

		$this->load->view('pages/task/bulk_tasks', $data);
	}

	public function individual_task_upload()
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

		$this->load->view('pages/task/individual_task_upload', $data);
	}

	public function view_edit_task($case = 'view', $taskId = '', $studentId = '', $classId = '')
	{
		$UserId = '';
		$StationId = '';
		$UserId = $this->session->userdata('user_id') ?? '';
		$StationId = $this->session->userdata('station_id') ?? '';

		$this->db->select('
			t.*,
			sub.subjectName,
			d.documentPath,
			s.firstName,
			s.lastName,
			s.education_type AS student_education_type,
			c.className,
			c.sectionName
		');

		$this->db->from('tbl_tasks t');

		/* Subject */
		$this->db->join(
			'tbl_subjects sub',
			'sub.subjectId = t.subjectId',
			'left'
		);

		/* Task Documents */
		$this->db->join(
			'tbl_documents d',
			"t.taskId = d.referenceId
			AND d.referenceType = 'Student Task'
			AND d.isDeleted = 0
			AND d.stationId = " . $this->db->escape($StationId),
			'left'
		);

		/* Class */
		$this->db->join(
			'tbl_classes c',
			'c.classId = t.classId',
			'left'
		);

		/* Student */
		$this->db->join(
			'tbl_students s',
			's.studentId = t.studentId',
			'left'
		);

		$this->db->where('t.stationId', $StationId);
		$this->db->where('t.taskId', $taskId);
		$this->db->where('t.isDeleted', 0);

		$this->db->order_by('t.addedOn', 'DESC');

		$task = $this->db->get()->result();
		$subjects = $this->Subject_model->get_all_subjects();

		$data = array();
		$data['task'] = $task[0];
		foreach ($task as $doc) {
			$data['all_docs'][] = $doc->documentPath;
		}
		$data['studentId'] = $studentId;
		$data['classId'] = $classId;
		$data['subjects'] = $subjects;

		// echo "<br>";
		// echo "<pre>";
		// print_r($data['all_docs']);
		// die();

		switch ($case) {
			case 'view':
				$data['case'] = $case;
				$this->load->view('pages/task/view_edit_task', $data);
				break;

			case 'edit':
				$data['case'] = $case;
				$this->load->view('pages/task/view_edit_task', $data);
				break;
		}
	}

	public function delete_task()
	{
		$UserId = '';
		$StationId = '';
		$UserId = $this->session->userdata('user_id') ?? '';
		$StationId = $this->session->userdata('station_id') ?? '';
		
		$taskId = $this->input->post('taskId') ?? '';

		$Response['status']  = false;
		$Response['message']  = "Some Error Occured. Try Again";

		$this->db->where('taskId', $taskId)->where('stationId', $StationId)->update('tbl_tasks', array('isDeleted' => 1));

		if ($this->db->affected_rows() > 0) {
			$Response['status']  = true;
			$Response['message']  = "Task Deleted Successfully";
		}

		exit(json_encode($Response));

	}

	public function all_tasks()
	{
		$UserId = '';
		$StationId = '';
		$UserId = $this->session->userdata('user_id') ?? '';
		$StationId = $this->session->userdata('station_id') ?? '';

		$this->db->select('
			t.*,
			s.firstName,
			s.lastName,
			s.education_type As student_education_type,
			c.className,
			c.sectionName
		');

		$this->db->from('tbl_tasks t');

		/* Class */
		$this->db->join(
			'tbl_classes c',
			'c.classId = t.classId',
			'left'
		);

		/* Student */
		$this->db->join(
			'tbl_students s',
			's.studentId = t.studentId',
			'left'
		);

		$this->db->where('t.stationId', $StationId);
		$this->db->where('t.isDeleted', 0);

		$this->db->order_by('t.addedOn', 'DESC');

		$all_tasks = $this->db->get()->result();

		$data = array();
		$data['all_tasks'] = $all_tasks;
		$this->load->view('pages/task/all_tasks', $data);
	}

	public function individual_save_task($case = 'add')
	{
		$UserId = '';
		$StationId = '';
		$UserId = $this->session->userdata('user_id') ?? '';
		$StationId = $this->session->userdata('station_id') ?? '';

		$Response['status']  = false;
		$Response['message']  = "Some Error Occured. Try Again";

		$this->form_validation->set_rules('task_title', 'Task Title', 'required');
		$this->form_validation->set_rules('subject', 'Subject', 'required');
		$this->form_validation->set_rules('total_marks', 'Total Marks', 'required');
		$this->form_validation->set_rules('passing_marks', 'Passing Marks', 'required');

		if ($this->form_validation->run() == FALSE) {
			$Response['message']  = validation_errors();
			exit(json_encode($Response));
			return;
		} else {

			$taskTitle        = $this->input->post('task_title') ?? '';
			$classId          = $this->input->post('classId') ?? '';
			$studentId         = $this->input->post('studentId') ?? '';
			$subjectId           = $this->input->post('subject') ?? '';
			$taskDescription  = $this->input->post('task_description') ?? '';
			$referenceLink    = $this->input->post('reference_link') ?? '';
			$startDate        = $this->input->post('start_date') ?? '';
			$endDate          = $this->input->post('end_date') ?? '';
			$totalMarks       = $this->input->post('total_marks') ?? '';
			$passingMarks     = $this->input->post('passing_marks') ?? '';
			$weightage         = $this->input->post('weightage') ?? '';

			$taskTitle       = $this->simplify_text($taskTitle);
			$taskDescription = $this->simplify_text($taskDescription);
			$referenceLink   = $this->simplify_text($referenceLink);

			switch ($case) {

				case 'add':

					$data_task = array();

					$data_task['teacherId'] = $UserId;
					$data_task['classId'] = $classId;
					$data_task['status'] = 'pending';
					$data_task['addedOn'] = date('Y-m-d H:i:s');
					$data_task['updatedOn'] = date('Y-m-d H:i:s');
					$data_task['addedBy'] = $UserId;
					$data_task['taskTitle']       = $taskTitle;
					$data_task['subjectId']       = $subjectId;
					$data_task['studentId']       = $studentId;
					$data_task['taskDescription'] = $taskDescription;
					$data_task['referenceLink']   = $referenceLink;
					$data_task['startDate']       = $startDate;
					$data_task['endDate']         = $endDate;
					$data_task['totalMarks']      = $totalMarks;
					$data_task['passingMarks']    = $passingMarks;
					$data_task['weightage']        = $weightage;
					$data_task['stationId']        = $StationId;

					// echo "<br>";
					// echo "<pre>";
					// print_r($data_task);
					// echo "</pre>";
					// die();

					$this->db->insert('tbl_tasks', $data_task);

					if ($this->db->affected_rows() > 0) {

						$taskId = $this->db->insert_id();

						if (!empty($_FILES['attachments']['name'][0])) {

							$filesCount = count($_FILES['attachments']['name']);


							for ($i = 0; $i < $filesCount; $i++) {

								$file = [
									'name'     => $_FILES['attachments']['name'][$i],
									'type'     => $_FILES['attachments']['type'][$i],
									'tmp_name' => $_FILES['attachments']['tmp_name'][$i],
									'error'    => $_FILES['attachments']['error'][$i],
									'size'     => $_FILES['attachments']['size'][$i]
								];

								// $taskId = $taskId . $i;

								$check = $this->Document_upload->task_doc_upload(
									$file,
									'Student Task',
									$taskId
								);
							}
						}

						$Response['status']  = true;
						$Response['message']  = "Task Saved Successfully";
					}

					break;
			}

			exit(json_encode($Response));
			return;
		}
		exit(json_encode($Response));
	}

	public function individual_update_task()
	{
		$UserId = '';
		$StationId = '';
		$UserId = $this->session->userdata('user_id') ?? '';
		$StationId = $this->session->userdata('station_id') ?? '';

		$Response['status']  = false;
		$Response['message']  = "Some Error Occured. Try Again";

		$this->form_validation->set_rules('task_title', 'Task Title', 'required');
		$this->form_validation->set_rules('subject', 'Subject', 'required');
		$this->form_validation->set_rules('total_marks', 'Total Marks', 'required');
		$this->form_validation->set_rules('passing_marks', 'Passing Marks', 'required');

		if ($this->form_validation->run() == FALSE) {
			$Response['message']  = validation_errors();
			exit(json_encode($Response));
			return;
		} else {

			$taskId        = $this->input->post('taskId') ?? '';
			$taskTitle        = $this->input->post('task_title') ?? '';
			$classId          = $this->input->post('classId') ?? '';
			$studentId         = $this->input->post('studentId') ?? '';
			$subjectId           = $this->input->post('subject') ?? '';
			$taskDescription  = $this->input->post('task_description') ?? '';
			$referenceLink    = $this->input->post('reference_link') ?? '';
			$startDate        = $this->input->post('start_date') ?? '';
			$endDate          = $this->input->post('end_date') ?? '';
			$totalMarks       = $this->input->post('total_marks') ?? '';
			$passingMarks     = $this->input->post('passing_marks') ?? '';
			$weightage         = $this->input->post('weightage') ?? '';

			$taskTitle       = $this->simplify_text($taskTitle);
			$taskDescription = $this->simplify_text($taskDescription);
			$referenceLink   = $this->simplify_text($referenceLink);

			$data_task = array();

			$data_task['teacherId'] = $UserId;
			$data_task['classId'] = $classId;
			$data_task['status'] = 'pending';
			$data_task['addedOn'] = date('Y-m-d H:i:s');
			$data_task['updatedOn'] = date('Y-m-d H:i:s');
			$data_task['addedBy'] = $UserId;
			$data_task['taskTitle']       = $taskTitle;
			$data_task['subjectId']       = $subjectId;
			$data_task['studentId']       = $studentId;
			$data_task['taskDescription'] = $taskDescription;
			$data_task['referenceLink']   = $referenceLink;
			$data_task['startDate']       = $startDate;
			$data_task['endDate']         = $endDate;
			$data_task['totalMarks']      = $totalMarks;
			$data_task['passingMarks']    = $passingMarks;
			$data_task['weightage']        = $weightage;
			$data_task['stationId']        = $StationId;

			// echo "<br>";
			// echo "<pre>";
			// print_r($data_task);
			// echo "</pre>";
			// die();

			$this->db->where('taskId', $taskId)->update('tbl_tasks', $data_task);

			if ($this->db->affected_rows() > 0) {

				// New uploads
				// $uploadedFiles = $_FILES['attachments'] ?? null;

				// Remaining old files (after removals)
				$existingFiles = json_decode($this->input->post('existing_attachments'), true) ?? [];

				// Assuming you store files in a table: tbl_documents
				$allOldFiles = $this->db->select('documentPath')
					->from('tbl_documents')
					->where('referenceId', $taskId)
					->where('referenceType', 'Student Task')
					->get()
					->result_array();

				$allOldFiles = array_column($allOldFiles, 'documentPath'); // just paths

				// Assuming you store files in a table: tbl_documents
				$allOldFiles = $this->db->select('documentPath')
					->from('tbl_documents')
					->where('referenceId', $taskId)
					->where('referenceType', 'Student Task')
					->get()
					->result_array();

				$allOldFiles = array_column($allOldFiles, 'documentPath'); // just paths

				$filesToDelete = array_diff($allOldFiles, $existingFiles);

				foreach ($filesToDelete as $file) {
					$filePath = FCPATH . $file; // full path
					if (file_exists($filePath)) {
						unlink($filePath); // delete file
					}

					// Remove from DB
					$this->db->where('documentPath', $file)
						->where('referenceId', $taskId)
						->where('referenceType', 'Student Task')
						->delete('tbl_documents');
				}

				if (!empty($_FILES['attachments']['name'][0])) {

					$filesCount = count($_FILES['attachments']['name']);


					for ($i = 0; $i < $filesCount; $i++) {

						$file = [
							'name'     => $_FILES['attachments']['name'][$i],
							'type'     => $_FILES['attachments']['type'][$i],
							'tmp_name' => $_FILES['attachments']['tmp_name'][$i],
							'error'    => $_FILES['attachments']['error'][$i],
							'size'     => $_FILES['attachments']['size'][$i]
						];

						// $taskId = $taskId . $i;

						$check = $this->Document_upload->task_doc_upload(
							$file,
							'Student Task',
							$taskId
						);
					}
				}

				$Response['status']  = true;
				$Response['message']  = "Task Saved Successfully";
			}

			exit(json_encode($Response));
			return;
		}
		exit(json_encode($Response));
	}


	public function save_task($case = 'add')
	{
		$UserId = '';
		$StationId = '';
		$UserId = $this->session->userdata('user_id') ?? '';
		$StationId = $this->session->userdata('station_id') ?? '';

		$Response['status']  = false;
		$Response['message']  = "Some Error Occured. Try Again";

		$this->form_validation->set_rules('task_title', 'Task Title', 'required');
		$this->form_validation->set_rules('subject', 'Subject', 'required');
		$this->form_validation->set_rules('total_marks', 'Total Marks', 'required');
		$this->form_validation->set_rules('passing_marks', 'Passing Marks', 'required');

		if ($this->form_validation->run() == FALSE) {
			$Response['message']  = validation_errors();
			exit(json_encode($Response));
			return;
		} else {

			$studentIds = $this->input->post('checkStudent');

			if (empty($studentIds)) {
				$Response['message']  = 'No students selected';
				exit(json_encode($Response));
				return;
			}

			$taskTitle        = $this->input->post('task_title') ?? '';
			$classId          = $this->input->post('classId') ?? '';
			$studentId         = $this->input->post('studentId') ?? '';
			$subjectId           = $this->input->post('subject') ?? '';
			$taskDescription  = $this->input->post('task_description') ?? '';
			$referenceLink    = $this->input->post('reference_link') ?? '';
			$startDate        = $this->input->post('start_date') ?? '';
			$endDate          = $this->input->post('end_date') ?? '';
			$totalMarks       = $this->input->post('total_marks') ?? '';
			$passingMarks     = $this->input->post('passing_marks') ?? '';
			$weightage         = $this->input->post('weightage') ?? '';

			$taskTitle       = $this->simplify_text($taskTitle);
			$taskDescription = $this->simplify_text($taskDescription);
			$referenceLink   = $this->simplify_text($referenceLink);

			switch ($case) {

				case 'add':

					$task_ids = array();

					foreach ($studentIds as $studentId) {

						$data_task = array();

						$data_task['teacherId'] = $UserId;
						$data_task['classId'] = $classId;
						$data_task['status'] = 'pending';
						$data_task['addedOn'] = date('Y-m-d H:i:s');
						$data_task['updatedOn'] = date('Y-m-d H:i:s');
						$data_task['addedBy'] = $UserId;
						$data_task['taskTitle']       = $taskTitle;
						$data_task['subjectId']       = $subjectId;
						$data_task['studentId']       = $studentId;
						$data_task['taskDescription'] = $taskDescription;
						$data_task['referenceLink']   = $referenceLink;
						$data_task['startDate']       = $startDate;
						$data_task['endDate']         = $endDate;
						$data_task['totalMarks']      = $totalMarks;
						$data_task['passingMarks']    = $passingMarks;
						$data_task['weightage']        = $weightage;
						$data_task['stationId']        = $StationId;

						// echo "<br>";
						// echo "<pre>";
						// print_r($data_task);
						// echo "</pre>";
						// die();

						$this->db->insert('tbl_tasks', $data_task);

						$task_ids[] = $this->db->insert_id();
					}

					if ($this->db->affected_rows() > 0) {

						// $taskId = $this->db->insert_id();

						if (!empty($_FILES['attachments']['name'][0])) {

							$filesCount = count($_FILES['attachments']['name']);

							// foreach ($studentIds as $studentId) {
							foreach ($task_ids as $taskId) {

								for ($i = 0; $i < $filesCount; $i++) {

									$file = [
										'name'     => $_FILES['attachments']['name'][$i],
										'type'     => $_FILES['attachments']['type'][$i],
										'tmp_name' => $_FILES['attachments']['tmp_name'][$i],
										'error'    => $_FILES['attachments']['error'][$i],
										'size'     => $_FILES['attachments']['size'][$i]
									];

									// $taskId = $taskId . $i;

									$check = $this->Document_upload->task_doc_upload(
										$file,
										'Student Task',
										$taskId
									);
								}
							}
						}

						$Response['status']  = true;
						$Response['message']  = "Task Saved Successfully";
					}

					break;
			}

			exit(json_encode($Response));
			return;
		}
		exit(json_encode($Response));
	}

	public function student_tasks($classId = '')
	{
		$UserId    = $this->session->userdata('user_id') ?? '';
		$UserName  = $this->session->userdata('user_name') ?? '';
		$UserEmail = $this->session->userdata('user_email') ?? '';
		$UserRole  = $this->session->userdata('user_role') ?? '';
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

		$all_students = $this->Student_model->get_all_students_by_class($StationId, $classId);

		$class = $this->db->where('classId', $classId)->where('stationId', $StationId)->where('isDeleted', 0)->get('tbl_classes')->row();
		$subjects = $this->db->where('stationId', $StationId)->where('isDeleted', 0)->get('tbl_subjects')->result();

		$data['all_students'] = $all_students;
		$data['class'] = $class;
		$data['subjects'] = $subjects;
		// echo "<br>";
		// echo "<pre>";
		// print_r($all_students);
		// die();

		$this->load->view('pages/student/student_tasks', $data);
	}
}
