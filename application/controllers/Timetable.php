<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Timetable extends MY_Controller
{
	public function time_table_chart($classId = '')
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

		// $this->db->select('*');
		$this->db->select('
            tbl_time_table.*,
            tbl_staff.firstName,
            tbl_staff.lastName,
            tbl_subjects.subjectName,
            tbl_classes.className,
            tbl_classes.sectionName
        ');
        $this->db->from('tbl_time_table');
        $this->db->join('tbl_classes', 'tbl_time_table.classId = tbl_classes.classId', 'left');
        $this->db->join('tbl_staff', 'tbl_time_table.teacherId = tbl_staff.staffId', 'left');
        $this->db->join('tbl_subjects', 'tbl_time_table.subjectId = tbl_subjects.subjectId', 'left');
        $this->db->where('tbl_time_table.stationId', $StationId);
        $this->db->where('tbl_time_table.isDeleted', 0);
        $this->db->where('tbl_time_table.classId', $classId);
        $timeTable = $this->db->get()->result();

		$query = $this->db->query("SHOW COLUMNS FROM tbl_time_table LIKE 'dayName'");
        $row = $query->row();

        $days = [];

        if ($row) {
            $enum = str_replace(["enum(", ")", "'"], "", $row->Type);
            $days = explode(",", $enum);
        }

		// print_r($this->db->last_query());
		// echo "<br>";
		// echo "<pre>";
		// print_r($timeTable);
		// die();

		$data = array();

		$data['timeTable'] = $timeTable;
		$data['days'] = $days;

		$this->load->view('pages/timetable/time_table_chart', $data);
	}

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

		$data = array();

		$data['classes'] = $this->Class_model->get_all_classes_with_student_count($StationId);

		// echo "<br>";
		// echo "<pre>";
		// print_r($data['student']);
		// die();

		$this->load->view('pages/timetable/all_classes', $data);
	}

	
}
