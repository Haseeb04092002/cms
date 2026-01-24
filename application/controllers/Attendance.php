<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Attendance extends MY_Controller
{
	public function attendance()
	{
		$this->load->view('pages/attendance/attendance');
	}

	
}
