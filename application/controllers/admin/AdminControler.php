<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User class.
 *
 * @extends CI_Controller
 */
class AdminControler extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
	}
	public function loginValidation(){
		if(!($this->session->userdata('admin') && $this->session->userdata('email'))){
			redirect('/admin/login');
		}
	}

}