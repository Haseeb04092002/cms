<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Timetable extends MY_Controller
{
	public function time_table_chart()
	{
		$this->load->view('pages/timetable/time_table_chart');
	}

	
}
