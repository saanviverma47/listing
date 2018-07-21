<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->library('session');
		
		if (!$this->session->userdata('loggedin'))
		{
			header('Location: /admin/user/login');
		}
	}

	public function index()
	{
		$this->load->view('admin/dashboard/dashboard');
	}
	
}

?>