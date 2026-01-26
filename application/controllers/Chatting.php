<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Chatting extends MY_Controller
{
	public function chats()
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

		$all_messages = $this->db->where('stationId', $StationId)->where('isDeleted', 0)->order_by('addedOn', 'DESC')->get('tbl_messages')->result();

		$this->db->select('
            tbl_messages.*,
            tbl_users.username,
            tbl_staff.firstName, tbl_staff.lastName,
            tbl_students.firstName, tbl_students.lastName
        ');
		$this->db->from('tbl_messages');
		
		$this->db->join('tbl_parents', 'tbl_messages.admissionNo = tbl_parents.admissionNo');
		$this->db->join('tbl_users', 'tbl_messages.classId = tbl_classes.classId');
		
		$this->db->where('tbl_messages.stationId', $StationId);
		$this->db->where('tbl_messages.receiverId', $UserId);
		$this->db->where('tbl_messages.isDeleted', 0);
		$this->db->group_by('tbl_messages.studentId');

		$data['all_messages'] = $all_messages;

		$this->load->view('pages/chatting/chats', $data);
	}
}
