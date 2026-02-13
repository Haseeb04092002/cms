<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Reports extends MY_Controller
{
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
			$this->load->view('pages/student/dashboard_student_progress', $data);
		} else {
			$classes = $this->db->select('sectionName, className, classId')->from('tbl_classes')->where('stationId', $StationId)->where('isDeleted', 0)->get()->result();
			$data['classes'] = $classes;
			$this->load->view('pages/reports/reports', $data);
		}
	}


	public function ajax_generate_student_report()
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
		$reportType = $this->input->post('reportType') ?? '';
		$month      = $this->input->post('month') ?? '';
		$year       = $this->input->post('year') ?? '';
		$studentName       = $this->input->post('studentName') ?? '';

		if ($reportType == '') {
			echo json_encode([
				'status' => false,
				'message' => 'Please select Report Type.'
			]);
			return;
		}

		// if ($UserRole === "Student") {
		// 	$filters = [
		// 		'className'   => $className,
		// 		'sectionName' => $sectionName,
		// 		'reportType'  => $reportType,
		// 		'month'       => $month,
		// 		'year'        => $year,
		// 	];

		// 	$result = $this->Reports_model->get_single_student_report_rows($filters);

		// 	echo json_encode([
		// 		'status' => true,
		// 		'count'  => count($result['rows']),
		// 		'rows'   => $result['rows'],
		// 		'period' => $result['period'],
		// 		'pdf_url' => site_url('reports/student_report_pdf?' . http_build_query($filters))
		// 	]);
		// } else {

			$filters = [
				'className'   => $className,
				'sectionName' => $sectionName,
				'reportType'  => $reportType,
				'month'       => $month,
				'year'        => $year,
			];

			$result = $this->Reports_model->get_student_report_rows($filters);

			echo json_encode([
				'status' => true,
				'count'  => count($result['rows']),
				'rows'   => $result['rows'],
				'period' => $result['period'],
				'pdf_url' => site_url('reports/student_report_pdf?' . http_build_query($filters))
			]);
		// }
	}

	public function student_report_pdf()
	{
		require_once APPPATH . 'third_party/dompdf/autoload.inc.php';

		$className   = $this->input->get('className', true) ?? '';
		$sectionName = $this->input->get('sectionName', true) ?? '';
		$reportType  = $this->input->get('reportType', true) ?? '';
		$month       = $this->input->get('month', true) ?? '';
		$year        = $this->input->get('year', true) ?? '';

		if ($reportType == '') {
			show_error("Report Type is required.");
		}

		$filters = [
			'className'   => $className,
			'sectionName' => $sectionName,
			'reportType'  => $reportType,
			'month'       => $month,
			'year'        => $year
		];

		/* ===========================
       FETCH DATA FROM MODEL
    ============================ */
		$result = $this->Reports_model->get_student_report_rows($filters);

		$rows   = $result['rows'] ?? [];
		$period = $result['period'] ?? null;

		/* ===========================
       FORMAT PERIOD (DB DATES)
    ============================ */
		if ($period && !empty($period['start']) && !empty($period['end'])) {
			$periodText =
				date('d-M-Y', strtotime($period['start'])) .
				' → ' .
				date('d-M-Y', strtotime($period['end']));
		} else {
			$periodText = 'N/A';
		}

		/* ===========================
       PREPARE VIEW DATA
    ============================ */
		$data = [];
		$data['filters']     = $filters;
		$data['rows']        = $rows;
		$data['periodText']  = $periodText;
		$data['title']       = strtoupper($reportType) . ' REPORT';

		/* ===========================
       LOAD PDF VIEW
    ============================ */
		$html = $this->load->view(
			'pages/reports/template_student_report',
			$data,
			true
		);

		/* ===========================
       DOMPDF CONFIG
    ============================ */
		$options = new Options();
		$options->set('isRemoteEnabled', true);
		$options->set('defaultFont', 'DejaVu Sans');

		$dompdf = new Dompdf($options);
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();

		/* ===========================
       STREAM PDF
    ============================ */
		$dompdf->stream(
			'student_report_' . strtolower($reportType) . '.pdf',
			['Attachment' => 0]
		);
	}
}
