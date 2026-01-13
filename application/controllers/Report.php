<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{
    public function reports()
	{
		$this->load->view('pages/report/reports');
	}
}
