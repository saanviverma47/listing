<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// load Session Library
        $this->load->library('session');
        // load url helper
        $this->load->helper('url');
        
		if ($this->session->userdata('loggedin'))
		{
			header('Location: /admin/');
		}
	}

	public function login()
	{
		$this->load->view('admin/user/login');
		
		if($this->input->post("email")){
			$this->session->set_userdata('loggedin', $this->input->post("email"));
			 header('Location: /admin/');
		}
	}
	
	
	public function logout()
	{
		 $this->session->sess_destroy();
		 header('Location: /admin/user/login');
	}
}

?>