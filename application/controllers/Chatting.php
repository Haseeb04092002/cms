<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Chatting extends MY_Controller
{
	public function chats()
	{
		$this->load->view('pages/chatting/chats');
	}

	
}
