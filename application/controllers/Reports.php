<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Reports extends MY_Controller
{
	public function index()
	{
		$this->load->view('pages/reports/reports_dashboard');
	}


	public function student_reports($case = 'attendance')
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

		switch ($case) {
			case 'attendance':
				if ($UserRole === "Student") {
					$classId = $this->db->select('classId')->where('studentId', $UserId)->where('stationId', $StationId)->where('isDeleted', 0)->get('tbl_students')->row()->classId;
					$classes = $this->db->select('sectionName, className, classId')->from('tbl_classes')->where('classId', $classId)->where('stationId', $StationId)->where('isDeleted', 0)->get()->row();
					$data['classes'] = $classes;
					// print_r($data);
					// die();
					$this->output->set_header('X-Page-Title: Student Attendance Report');
					$this->load->view('pages/reports/student/attendance', $data);
				}
				if ($UserRole === "Admin") {
					$this->output->set_header('X-Page-Title: Student Attendance Report');
					$this->load->view('pages/reports/student/attendance');
					break;
				}

				break;

			case 'academic':
				$this->output->set_header('X-Page-Title: Student Academic Report');
				$this->load->view('pages/reports/student/academic');
				break;
		}
	}



	public function reports()
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
		$data = array();

		if ($UserRole === "Student") {
			$classId = $this->db->select('classId')->where('studentId', $UserId)->where('stationId', $StationId)->where('isDeleted', 0)->get('tbl_students')->row()->classId;
			$classes = $this->db->select('sectionName, className, classId')->from('tbl_classes')->where('classId', $classId)->where('stationId', $StationId)->where('isDeleted', 0)->get()->result();
			$data['classes'] = $classes;
			// print_r($data);
			// die();
			$this->output->set_header('X-Page-Title: Progress & Reports');
			$this->load->view('pages/student/dashboard_student_progress', $data);
		} else {
			$classes = $this->db->select('sectionName, className, classId')->from('tbl_classes')->where('stationId', $StationId)->where('isDeleted', 0)->get()->result();
			$data['classes'] = $classes;
			$this->output->set_header('X-Page-Title: Progress & Reports');
			$this->load->view('pages/reports/reports', $data);
		}
	}


	public function ajax_generate_student_report($case = '')
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

		$className  = $this->input->post('className') ?? '';
		$sectionName = $this->input->post('sectionName') ?? '';
		$month      = $this->input->post('month') ?? '';
		$year       = $this->input->post('year') ?? '';
		$startDate       = $this->input->post('startDate') ?? '';
		$endDate       = $this->input->post('endDate') ?? '';

		if ($case == '') {
			echo json_encode([
				'status' => false,
				'message' => 'Please select Report Type.'
			]);
			return;
		}

		$filters = [
			'className'   => $className,
			'sectionName' => $sectionName,
			'month'       => $month,
			'reportType'  => $case,
			'year'        => $year,
			'startDate'   => $startDate,
			'stationId'   => $StationId,
			'endDate'     => $endDate
		];

		switch ($case) {

			case 'attendance':

				$result = $this->Reports_model->get_student_report_rows($filters);

				$response = [
					'status'  => true,
					'count'   => count($result['rows']),
					'rows'    => $result['rows'],
					'period'  => $result['period'],
					'pdf_url' => site_url('reports/student_attendance_report_pdf?' . http_build_query($filters))
				];

				break;

			case 'academic':

				$result = $this->Reports_model->get_student_report_rows($filters);

				$response = [
					'status'  => true,
					'count'   => count($result['rows']),
					'rows'    => $result['rows'],
					'period'  => $result['period'],
					'pdf_url' => site_url('reports/student_academic_report_pdf?' . http_build_query($filters))
				];

				break;

			case 'fee':

				$result = $this->Reports_model->get_student_report_rows($filters);
				echo json_encode([
					'status' => true,
					'count'  => count($result['rows']),
					'rows'   => $result['rows'],
					'period' => $result['period'],
					'pdf_url' => site_url('reports/?' . http_build_query($filters))
				]);

				break;
		}

		ob_clean();
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}


	public function student_attendance_report_pdf()
	{
		require_once APPPATH . 'third_party/dompdf/autoload.inc.php';

		$rows   = json_decode($this->input->post('rows'), true) ?? [];
		$period = json_decode($this->input->post('period'), true) ?? [];
		$title  = $this->input->post('title') ?? 'STUDENT REPORT';
		$filters = json_decode($this->input->post('filters'), true) ?? [];

		if (empty($rows)) {
			show_error("No data received for PDF.");
		}

		// ✅ Build period text
		if (!empty($period['start']) && !empty($period['end'])) {
			$periodText =
				date('d-M-Y', strtotime($period['start'])) .
				' → ' .
				date('d-M-Y', strtotime($period['end']));
		} else {
			$periodText = 'N/A';
		}

		// ✅ Prepare data for view (matches your template)
		$data = [
			'rows'       => $rows,
			'periodText' => $periodText,
			'title'      => $title,
			'filters'    => $filters
		];

		// print_r($data);
		// die();

		$html = $this->load->view(
			'pages/reports/template_student_attendance_report',
			$data,
			true
		);

		$options = new Options();
		$options->set('isRemoteEnabled', true);
		$options->set('defaultFont', 'DejaVu Sans');

		$dompdf = new Dompdf($options);
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();

		// ✅ Output PDF inline
		$dompdf->stream(
			'student_report.pdf',
			['Attachment' => 0]
		);
	}

	public function student_academic_report_pdf()
	{
		require_once APPPATH . 'third_party/dompdf/autoload.inc.php';

		$rows   = json_decode($this->input->post('rows'), true) ?? [];
		$period = json_decode($this->input->post('period'), true) ?? [];
		$title  = $this->input->post('title') ?? 'ACADEMIC REPORT';
		$filters = json_decode($this->input->post('filters'), true) ?? [];

		if (empty($rows)) {
			show_error("No data received for PDF.");
		}

		if (!empty($period['start']) && !empty($period['end'])) {
			$periodText =
				date('d-M-Y', strtotime($period['start'])) .
				' → ' .
				date('d-M-Y', strtotime($period['end']));
		} else {
			$periodText = 'N/A';
		}

		// ✅ Ensure filters always have keys (avoid undefined index)
		$filters = array_merge([
			'className'   => '',
			'sectionName' => ''
		], $filters);

		// ✅ Prepare data for view
		$data = [
			'rows'       => $rows,
			'periodText' => $periodText,
			'title'      => $title,
			'filters'    => $filters
		];

		$html = $this->load->view(
			'pages/reports/template_student_academic_report',
			$data,
			true
		);

		$options = new Options();
		$options->set('isRemoteEnabled', true);
		$options->set('defaultFont', 'DejaVu Sans');

		$dompdf = new Dompdf($options);
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();

		$dompdf->stream(
			'student_academic_report.pdf',
			['Attachment' => 0]
		);
	}
}
