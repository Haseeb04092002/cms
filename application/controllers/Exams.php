<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Exams extends MY_Controller
{
	public function exam_dashboard()
	{
		$this->load->view('pages/exam/exam_dashboard');
	}

	
}
