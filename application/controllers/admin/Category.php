<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User class.
 * 
 * @extends CI_Controller
 */
class Category extends CI_Controller {

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
		$this->load->model('admin/category_model');
	}
	
	public function index() {
		if($this->session->userdata('admin') && $this->session->userdata('email')){
			// create the data object
			$data = new stdClass();
			$data->categories = $this->category_model->getAll();
			
			$this->load->view('admin/header');
			$this->load->view('admin/nav');
			$this->load->view('admin/category/index', $data);
			$this->load->view('admin/footer');
			$this->load->view('admin/category/category_footer');
			$this->load->view('admin/footer_close');
		}else{
			// do something when doesn't exist
			redirect('/admin/login');
		}
	}
	
	/**
	 * will use to get all the category
	 */
	public function getAll(){
		$result = $this->category_model->getAll();
	}
	
	public function save(){
		
	}
	
	public function update(){
		
	}

}
