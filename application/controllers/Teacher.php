<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Teacher extends MY_Controller
{

	public function all_teachers()
	{
		$this->load->view('pages/teacher/all_teachers');
	}

	public function hrm()
	{
		$this->load->view('pages/teacher/hrm');
	}

	
}
