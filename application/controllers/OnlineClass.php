<?php
defined('BASEPATH') or exit('No direct script access allowed');

class OnlineClass extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('session'));

		if (!$this->session->userdata('user_id')) {
			redirect('Login');
		}
	}

	private function getSessionData()
	{
		return array(
			'UserId'    => (int)($this->session->userdata('user_id') ?? 0),
			'UserRole'  => $this->session->userdata('user_role') ?? '',
			'RoleId'    => (int)($this->session->userdata('role_id') ?? 0),
			'StationId' => (int)($this->session->userdata('station_id') ?? 0)
		);
	}

	public function index()
	{
		$S = $this->getSessionData();
		$StationId = (int)($this->session->userdata('station_id') ?? 0);

		if ($S['UserRole'] == 'Teacher') {
			redirect('OnlineClass/teacher');
		}

		if ($S['UserRole'] == 'Student') {
			redirect('OnlineClass/student');
		}

		$this->db->select('
            oc.onlineClassId,
            oc.title,
            oc.roomName,
            oc.meetingDate,
            oc.startTime,
            oc.endTime,
            oc.status,
            c.className,
            c.sectionName,
            t.firstName as teacherName
        ');
		$this->db->from('tbl_online_classes oc');
		$this->db->join('tbl_classes c', 'c.classId = oc.classId', 'left');
		$this->db->join('tbl_staff t', 't.staffId = oc.teacherId', 'left');
		$this->db->where('oc.stationId', $StationId);
		$this->db->where('oc.isDeleted', 0);
		$this->db->order_by('oc.onlineClassId', 'DESC');
		$data['classes'] = $this->db->get()->result();

		$this->load->view('pages/online_class/list', $data);
	}

	public function create()
	{
		$S = $this->getSessionData();
		$StationId = (int)($this->session->userdata('station_id') ?? 0);

		if (!in_array($S['UserRole'], array('Admin', 'CEO', 'Principal', 'Teacher'))) {
			show_error('Access denied');
		}

		$this->db->where('stationId', $StationId);
		$this->db->where('isDeleted', 0);
		$this->db->order_by('className', 'ASC');
		$data['all_classes'] = $this->db->get('tbl_classes')->result();

		$this->db->where('stationId', $StationId);
		$this->db->where('isDeleted', 0);
		$this->db->order_by('firstName', 'ASC');
		$data['teachers'] = $this->db->get('tbl_staff')->result();

		$this->load->view('pages/online_class/create', $data);
	}

	public function save()
	{
		$S = $this->getSessionData();
		$StationId = (int)($this->session->userdata('station_id') ?? 0);

		$classId     = (int)$this->input->post('classId');
		$sectionId   = (int)$this->input->post('sectionId');
		$teacherId   = (int)$this->input->post('teacherId');
		$title       = trim($this->input->post('title'));
		$meetingDate = trim($this->input->post('meetingDate'));
		$startTime   = trim($this->input->post('startTime'));
		$endTime     = trim($this->input->post('endTime'));
		$classNotes  = trim($this->input->post('classNotes'));

		$roomName = 'Class-' . time();

		$insertData = array(
			'stationId'   => $StationId,
			'roleId'      => $S['RoleId'],
			'classId'     => $classId,
			'sectionId'   => $sectionId,
			'teacherId'   => $teacherId,
			'title'       => $title,
			'roomName'    => $roomName,
			'meetingDate' => $meetingDate,
			'startTime'   => $startTime,
			'endTime'     => $endTime,
			'classNotes'  => $classNotes,
			'status'      => 'Scheduled',
			'isDeleted'   => 0,
			'addedBy'     => $S['UserId'],
			'addedOn'     => date('Y-m-d H:i:s')
		);

		$this->db->insert('tbl_online_classes', $insertData);

		echo json_encode([
			'status' => true,
			'message' => 'Online class created successfully'
		]);
		exit;
	}

	public function teacher_classes()
	{
		$S = $this->getSessionData();
		$StationId = (int)($this->session->userdata('station_id') ?? 0);

		if (!in_array($S['UserRole'], array('Teacher', 'Admin', 'CEO', 'Principal'))) {
			show_error('Access denied');
		}

		$this->db->select('
            oc.*,
            c.className,
            c.sectionName
        ');
		$this->db->from('tbl_online_classes oc');
		$this->db->join('tbl_classes c', 'c.classId = oc.classId', 'left');
		$this->db->where('oc.stationId', $StationId);
		$this->db->where('oc.isDeleted', 0);

		if ($S['UserRole'] == 'Teacher') {
			$this->db->where('oc.teacherId', $S['UserId']);
		}

		$this->db->order_by('oc.onlineClassId', 'DESC');
		$data['classes'] = $this->db->get()->result();

		$this->load->view('pages/online_class/teacher_list', $data);
	}

	public function student_classes()
	{
		$S = $this->getSessionData();
		$StationId = (int)($this->session->userdata('station_id') ?? 0);
		$UserId = (int)($this->session->userdata('user_id') ?? 0);

		if ($S['UserRole'] != 'Student') {
			show_error('Access denied');
		}

		$studentId = $UserId;

		$student = $this->db
			->where('studentId', $studentId)
			->where('stationId', $StationId)
			->where('isDeleted', 0)
			->get('tbl_students')
			->row();

		if (!$student) {
			show_error('Student record not found.');
		}

		$this->db->select('
            oc.*,
            c.className,
            c.sectionName,
            t.firstName as teacherName
        ');
		$this->db->from('tbl_online_classes oc');
		$this->db->join('tbl_classes c', 'c.classId = oc.classId', 'left');
		$this->db->join('tbl_staff t', 't.staffId = oc.teacherId', 'left');
		$this->db->where('oc.stationId', $StationId);
		$this->db->where('oc.isDeleted', 0);
		$this->db->where('oc.classId', $student->classId);

		$this->db->order_by('oc.onlineClassId', 'DESC');
		$data['classes'] = $this->db->get()->result();

		// print_r($this->db->last_query());
		// die();

		$this->load->view('pages/online_class/student_list', $data);
	}

	public function go_live($id = 0)
	{
		$S = $this->getSessionData();
		$StationId = (int)($this->session->userdata('station_id') ?? 0);

		$row = $this->db
			->where('onlineClassId', (int)$id)
			->where('stationId', $StationId)
			->where('isDeleted', 0)
			->get('tbl_online_classes')
			->row();

		if (!$row) {
			show_404();
		}

		if (!in_array($S['UserRole'], array('Admin', 'Teacher'))) {
			show_error('Access denied');
		}

		if ($S['UserRole'] == 'Teacher' && (int)$row->teacherId !== (int)$S['UserId']) {
			show_error('You can only start your own class.');
		}

		$this->db->where('onlineClassId', $row->onlineClassId);
		$this->db->update('tbl_online_classes', array('status' => 'Live'));

		redirect('OnlineClass/room/' . $row->roomName . '?class_id=' . $row->onlineClassId . '&mode=teacher');
	}

	public function join($id = 0)
	{
		$S = $this->getSessionData();
		$StationId = (int)($this->session->userdata('station_id') ?? 0);

		$row = $this->db
			->where('onlineClassId', (int)$id)
			->where('stationId', $StationId)
			->where('isDeleted', 0)
			->get('tbl_online_classes')
			->row();

		if (!$row) {
			show_404();
		}

		if ($S['UserRole'] == 'Student') {
			$student = $this->db
				->where('studentId', $S['UserId'])
				->where('stationId', $StationId)
				->where('isDeleted', 0)
				->get('tbl_students')
				->row();

			if (!$student || (int)$student->classId !== (int)$row->classId) {
				show_error('You are not allowed to join this class.');
			}

			$att = array(
				'onlineClassId' => $row->onlineClassId,
				'studentId'     => $S['UserId'],
				'joinedAt'      => date('Y-m-d H:i:s')
			);
			// $this->db->insert('tbl_online_class_attendance', $att);
		}

		redirect('OnlineClass/room/' . $row->roomName . '?class_id=' . $row->onlineClassId . '&mode=student');
	}

	public function room($room = '')
	{
		$S = $this->getSessionData();
		$StationId = (int)($this->session->userdata('station_id') ?? 0);

		if ($room == '') {
			show_404();
		}

		$classId = (int)$this->input->get('class_id');
		$mode    = $this->input->get('mode');

		$row = $this->db
			->where('onlineClassId', $classId)
			->where('stationId', $StationId)
			->where('isDeleted', 0)
			->get('tbl_online_classes')
			->row();

		if (!$row) {
			show_404();
		}

		$data['roomName'] = $room;
		$data['classRow'] = $row;
		$data['mode']     = $mode;
		$data['displayName'] = $this->session->userdata('user_name') ?? $this->session->userdata('user_role');

		$this->load->view('pages/online_class/room', $data);
	}

	public function end_class($id = 0)
	{
		$S = $this->getSessionData();
		$StationId = (int)($this->session->userdata('station_id') ?? 0);

		$row = $this->db
			->where('onlineClassId', (int)$id)
			->where('stationId', $StationId)
			->where('isDeleted', 0)
			->get('tbl_online_classes')
			->row();

		if (!$row) {
			show_404();
		}

		if (!in_array($S['UserRole'], array('Admin', 'CEO', 'Principal', 'Teacher'))) {
			show_error('Access denied');
		}

		if ($S['UserRole'] == 'Teacher' && (int)$row->teacherId !== (int)$S['UserId']) {
			show_error('You can only end your own class.');
		}

		$this->db->where('onlineClassId', $row->onlineClassId);
		$this->db->update('tbl_online_classes', array('status' => 'Ended'));

		$this->session->set_flashdata('msg', '<div class="alert alert-success">Class ended successfully.</div>');

		if ($S['UserRole'] == 'Teacher') {
			redirect('OnlineClass/teacher');
		} else {
			redirect('OnlineClass');
		}
	}

	public function delete()
	{
		$S = $this->getSessionData();
		$StationId = (int)($this->session->userdata('station_id') ?? 0);

		$id = (int)$this->input->post('onlineClassId');

		if (!in_array($S['UserRole'], array('Admin', 'CEO', 'Principal'))) {

			echo json_encode([
				'status' => false,
				'message' => 'Only admin can delete class'
			]);
			exit;
		}

		$this->db->where('onlineClassId', $id);
		$this->db->where('stationId', $StationId);

		$this->db->update('tbl_online_classes', [
			'isDeleted' => 1
		]);

		echo json_encode([
			'status' => true,
			'message' => 'Online class deleted successfully'
		]);

		exit;
	}
}
