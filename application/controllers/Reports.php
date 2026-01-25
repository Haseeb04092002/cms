<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends MY_Controller
{
	public function reports()
	{
		$this->load->view('pages/reports/reports');
	}

	
}
