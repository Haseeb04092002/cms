<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cms extends MY_Controller
{

	public function index()
	{
		$this->load->view('master_view');
	}

	public function dashboard()
	{
		$this->load->view('pages/admin/dashboard');
	}

	public function users()
	{
		$this->load->view('pages/admin/users');
	}

	public function courses()
	{
		$this->load->view('pages/course/courses');
	}
	

	public function all_expenses()
	{
		$this->load->view('pages/finance/all_expenses');
	}

	
}
