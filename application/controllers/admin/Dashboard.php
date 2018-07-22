<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User class.
 * 
 * @extends CI_Controller
 */
class Dashboard extends CI_Controller {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		//$this->load->model('admin/user_model'); create dashboard modal
		
	}
	
	
	public function index() {
		// create the data object
		$data = new stdClass();

		if($this->session->userdata('email')){
			 // do something when exist
			$this->load->view('admin/header');
			$this->load->view('admin/nav');
			//$this->load->view('admin/dashboard/index', $data);
			$this->load->view('admin/footer');
		}else{
			// do something when doesn't exist
			redirect('/admin/login');
		}
		
	}

}
