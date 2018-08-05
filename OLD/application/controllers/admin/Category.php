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
	
	/**
	 * 
	 * will use to load the category index page
	 */
	public function index() {
		if($this->session->userdata('admin') && $this->session->userdata('email')){
			// create the data object
			$data = new stdClass();
			$data->categories = $this->category_model->getAll();
			$this->load->view('admin/header');
			$this->load->view('admin/nav');
			$this->load->view('admin/category/index', $data);
			$this->load->view('admin/footer');
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

	/**
	 * will use this to open add form
	 */
	public function add(){
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data = new stdClass();
		$data->categories_combo = $this->category_model->getCategoryCombo(0);
		$this->load->view('admin/header');
		$this->load->view('admin/nav');
		$this->load->view('admin/category/add', $data);
		$this->load->view('admin/footer');
	}
	/**
	 *
	 * will use this to oprn edit form
	 */
	public function edit(){
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data = new stdClass();
		$data->categories_combo = $this->category_model->getCategoryCombo(0);
		$data->category_edit = $this->category_model->getCategoryById($this->input->get('id'));
		$this->load->view('admin/header');
		$this->load->view('admin/nav');
		$this->load->view('admin/category/add', $data);
		$this->load->view('admin/footer');
	}

	/**
	 * 
	 * will use this to save the category
	 */
	public function save(){
		// create the data object
		$data = new stdClass();
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
		// set validation rules
		$this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[categories.name]', array('is_unique' => 'This category already exists.'));
		$this->form_validation->set_rules('parent_id', 'parent_id', 'trim|required');
		if ($this->form_validation->run() === false) {
			$data->categories_combo = $this->category_model->getCategoryCombo(0);
			// validation not ok, send validation errors to the view
			$this->load->view('admin/header');
			$this->load->view('admin/nav');
			$this->load->view('admin/category/add', $data);
			$this->load->view('admin/footer');
		} else {
			// set variables from the form
			$query = array(
			'name'      => $this->input->post('name'),
			'parent_id'   => $this->input->post('parent_id'),
			'description' => $this->input->post('description'),
			'meta_title'      => $this->input->post('meta_title'),
			'meta_keywords'   => $this->input->post('meta_keywords'),
			'meta_description' => $this->input->post('meta_description'),
			'status'   => $this->input->post('status'),
			'created_by' => $_SESSION['user_id']
			);
				
			if($this->category_model->save($query)){
				redirect('/admin/category');
			} else {
				// login failed
				$data->categories_combo = $this->category_model->getCategoryCombo(0);
				$data->error = 'Failed Please try again.';
				// send error to the view
				$this->load->view('admin/header');
				$this->load->view('admin/nav');
				$this->load->view('admin/category/add', $data);
				$this->load->view('admin/footer');
			}
		}
	}

	/**
	 * 
	 * will use this to update the category
	 */
	public function update(){
		// create the data object
		$data = new stdClass();
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
		// set validation rules
		$this->form_validation->set_rules('name', 'name', 'trim|required');
		$this->form_validation->set_rules('parent_id', 'parent_id', 'trim|required');
		if ($this->form_validation->run() === false) {
			// validation not ok, send validation errors to the view
			$data->categories_combo = $this->category_model->getCategoryCombo(0);
			$data->category_edit = $this->category_model->getCategoryById($this->input->get('id'));
			$this->load->view('admin/header');
			$this->load->view('admin/nav');
			$this->load->view('admin/category/add', $data);
			$this->load->view('admin/footer');
		} else {
			// set variables from the form
			$query = "UPDATE categories SET name ='". $this->input->post('name')
			."', parent_id ='". $this->input->post('parent_id')
			."', description ='". $this->input->post('description')
			."', meta_title ='". $this->input->post('meta_title')
			."', meta_keywords ='". $this->input->post('meta_keywords')
			."', meta_description ='". $this->input->post('meta_description')
			."', status ='". $this->input->post('status')
			."', modified_by ='". $_SESSION['user_id']
			."' WHERE id='".$this->input->post('id')."' limit 1";
				
			if($this->category_model->update($query)){
				redirect('/admin/category');
			} else {
				// login failed
				$data->error = 'Failed Please try again.';
				$data->categories_combo = $this->category_model->getCategoryCombo(0);
				$data->category_edit = $this->category_model->getCategoryById($this->input->get('id'));	
				// send error to the view
				$this->load->view('admin/header');
				$this->load->view('admin/nav');
				$this->load->view('admin/category/add', $data);
				$this->load->view('admin/footer');
			}
		}
	}
	
	public function updateStatus(){
		// create the data object
		$data = new stdClass();
		// set variables from the form
		$query = "UPDATE categories SET status ='". $this->input->get('status')."', modified_by ='". $_SESSION['user_id']."' WHERE id='".$this->input->get('id')."' limit 1";
		$this->category_model->update($query);
	}
}
