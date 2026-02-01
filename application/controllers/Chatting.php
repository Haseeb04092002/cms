<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Chatting extends MY_Controller
{

	public function index()
	{
		$this->load->view('pages/chatting/chats');
	}

	public function open_chat($otherUserId, $otherRoleId)
	{
		$UserId    = (int)$this->session->userdata('user_id');
		$UserRole  = (int)$this->session->userdata('user_role');
		$senderRoleId = (int)$this->session->userdata('user_role_id');
		$StationId = (int)$this->session->userdata('station_id');

		$otherUserId = (int)$otherUserId;
		$otherRoleId = (int)$otherRoleId;

		$messages = $this->db
			->where('stationId', $StationId)
			->group_start()
			->where('senderId', $UserId)
			->where('receiverId', $otherUserId)
			->where('receiverRoleId', $otherRoleId)
			->group_end()
			->or_group_start()
			->where('senderId', $otherUserId)
			->where('receiverId', $UserId)
			->where('senderRoleId', $senderRoleId)
			->group_end()
			->order_by('addedOn', 'ASC')
			->get('tbl_messages')
			->result();

		// foreach ($messages as $m) {
		// 	if ((int)$m->receiverId === $UserId) {

		// 		$exists = $this->db
		// 			->where('messageId', $m->messageId)
		// 			->get('tbl_message_reads')
		// 			->row();

		// 		if (!$exists) {
		// 			$this->db->insert('tbl_message_reads', [
		// 				'stationId'  => $StationId,
		// 				'userId'     => $UserId,
		// 				'messageId'  => $m->messageId,
		// 				'senderId'   => $m->senderId,
		// 				'receiverId' => $m->receiverId,
		// 				'receiverRoleId' => $m->receiverRoleId,
		// 				'readOn'     => date('Y-m-d H:i:s'),
		// 				'addedBy'    => $UserId,
		// 				'addedOn'    => date('Y-m-d H:i:s')
		// 			]);
		// 		}
		// 	}
		// }

		echo json_encode($messages);
	}


	public function send_message()
	{
		$senderId     = (int)$this->session->userdata('user_id');
		$senderRoleId = (int)$this->session->userdata('user_role_id');
		$StationId    = (int)$this->session->userdata('station_id');

		$Response['status']  = false;
		$Response['message'] = "Some Error Occured. Try Again";

		$receiverId     = (int)$this->input->post('receiverId');
		$receiverRoleId = (int)$this->input->post('receiverRoleId');
		$message        = $this->input->post('message');

		// echo "<br>receiverId = ".$receiverId;
		// echo "<br>receiverRoleId = ".$receiverRoleId;
		// echo "<br>message = ".$message;
		// die();

		$this->db->insert('tbl_messages', [
			'stationId'      => $StationId,
			'senderId'       => $senderId,
			'senderRoleId'   => $senderRoleId,
			'receiverId'     => $receiverId,
			'receiverRoleId' => $receiverRoleId,
			'messageType'    => 'TEXT',
			'messageText'    => $message,
			'addedBy'        => $senderId,
			'addedOn'        => date('Y-m-d H:i:s')
		]);

		if ($this->db->affected_rows() > 0) {
			$Response['status']  = true;
			$Response['message'] = "Message Sent Successfully";
		}

		exit(json_encode($Response));
	}


	public function poll_updates()
	{
		$UserId    = (int)$this->session->userdata('user_id');
		$StationId = (int)$this->session->userdata('station_id');

		$unread = $this->db
			->select('m.senderId, COUNT(m.messageId) AS total')
			->from('tbl_messages m')
			->join(
				'tbl_message_reads mr',
				'mr.messageId = m.messageId AND mr.userId = ' . $UserId,
				'left'
			)
			->where('m.stationId', $StationId)
			->where('m.receiverId', $UserId)
			->where('mr.messageReadId IS NULL', null, false)
			->group_by('m.senderId')
			->get()
			->result();

		echo json_encode($unread);
	}

	public function chats()
	{
		$UserId    = (int)$this->session->userdata('user_id');
		$UserRole  = (int)$this->session->userdata('user_role');
		$UserRoleId  = (int)$this->session->userdata('user_role_id');
		$StationId = (int)$this->session->userdata('station_id');

		$users = $this->db
			->select("roleId AS roleId, userId AS profile_id, 'USER' AS profile_type, username AS name", false)
			->where('stationId', $StationId)
			->where('isDeleted', 0)
			->get('tbl_users')
			->result();

		$staff = $this->db
			->select("roleId AS roleId, staffId AS profile_id, 'STAFF' AS profile_type, CONCAT(firstName,' ',lastName) AS name", false)
			->where('stationId', $StationId)
			->get('tbl_staff')
			->result();

		$students = $this->db
			->select("roleId AS roleId, studentId AS profile_id, 'STUDENT' AS profile_type, CONCAT(firstName,' ',lastName) AS name", false)
			->where('stationId', $StationId)
			->where('status', 1)
			->get('tbl_students')
			->result();

		$all_users = array_merge($users, $staff, $students);



		$unique = [];
		foreach ($all_users as $u) {
			$key = $u->profile_id . '_' . $u->roleId;   // ✅ NEW UNIQUE KEY
			$unique[$key] = $u;
		}
		$all_users = array_values($unique);



		if (empty($all_users)) {
			$data['chat_users'] = [];
			$this->load->view('pages/chatting/chats', $data);
			return;
		}

		$unread_data = $this->db
			->select("CONCAT(m.senderId,'_',m.senderRoleId) AS chat_key, COUNT(m.messageId) AS unread_count", false)
			->from('tbl_messages m')
			->join('tbl_message_reads mr', 'mr.messageId=m.messageId', 'left')
			->where('m.stationId', $StationId)
			->where('m.receiverId', $UserId)
			->where('m.receiverRoleId', $UserRoleId)
			->where('m.isDeleted', 0)
			// ->where('mr.messageReadId IS NULL', null, false)
			->group_by('m.senderId, m.senderRoleId', false)
			->get()
			->result();

		$unread_map = [];
		foreach ($unread_data as $r) {
			$unread_map[$r->chat_key] = (int)$r->unread_count;
		}

		$last_msgs = $this->db
			->select("
				CASE 
					WHEN senderId = $UserId AND senderRoleId = $UserRoleId
						THEN CONCAT(receiverId,'_',receiverRoleId)
					ELSE CONCAT(senderId,'_',senderRoleId)
				END AS chat_key,
				messageText,
				addedOn
			", false)
			->from('tbl_messages')
			->where('stationId', $StationId)
			->where("(
				(senderId = $UserId AND senderRoleId = $UserRoleId) OR
				(receiverId = $UserId AND receiverRoleId = $UserRoleId)
			)", null, false)
			->order_by('addedOn', 'DESC')
			->get()
			->result();

		$last_msg_map = [];
		foreach ($last_msgs as $m) {
			if (!isset($last_msg_map[$m->chat_key])) {
				$last_msg_map[$m->chat_key] = ['text' => $m->messageText, 'time' => $m->addedOn];
			}
		}

		foreach ($all_users as &$u) {
			$key = $u->profile_id . '_' . $u->roleId;

			$u->chat_key     = $key; // ✅ very important for JS
			$u->unread_count = $unread_map[$key] ?? 0;
			$u->last_message = $last_msg_map[$key]['text'] ?? null;
			$u->last_time    = $last_msg_map[$key]['time'] ?? null;
		}

		usort($all_users, function ($a, $b) {
			if ($a->unread_count != $b->unread_count) {
				return $b->unread_count - $a->unread_count;
			}
			return strtotime($b->last_time ?? '1970-01-01') <=> strtotime($a->last_time ?? '1970-01-01');
		});

		$data['chat_users'] = $all_users;

		// echo "<br>";
		// echo "<pre>";
		// // print_r($this->db->last_query());
		// print_r($data);
		// die();

		// $this->load->view('pages/chatting/chats', $data);
		header('Content-Type: application/json');
		echo json_encode($data);
		exit;
	}
}
