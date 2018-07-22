<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User class.
 * 
 * @extends CI_Controller
 */
class User extends CI_Controller {

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
		$this->load->model('admin/user_model');
		
	}
	
	
	public function index() {
		if($this->session->userdata('admin') && $this->session->userdata('email')){
			 // do something when exist
			 redirect('/admin/dashboard');
		}else{
			// do something when doesn't exist
			redirect('/admin/login');
		}
		
	}
	
	public function register() {
		
		// create the data object
		$data = new stdClass();
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		// set validation rules
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[admin_users.email]', array('is_unique' => 'This email already exists. Please choose another one.'));
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');
		
		if ($this->form_validation->run() === false) {
			
			// validation not ok, send validation errors to the view
			$this->load->view('admin/header');
			$this->load->view('admin/user/register/register', $data);
			$this->load->view('admin/footer');
			
		} else {
			
			// set variables from the form
			$username = $this->input->post('username');
			$email    = $this->input->post('email');
			$password = $this->input->post('password');
			
			if ($this->user_model->create_user($username, $email, $password)) {
				
				// user creation ok
				$this->load->view('admin/header');
				$this->load->view('admin/user/register/register', $data);
				$this->load->view('admin/footer');
				
			} else {
				
				// user creation failed, this should never happen
				$data->error = 'There was a problem creating your new account. Please try again.';
				
				// send error to the view
				$this->load->view('admin/header');
				$this->load->view('admin/user/register/register', $data);
				$this->load->view('admin/footer');
				
			}
			
		}
		
	}

	public function login() {
		
		// create the data object
		$data = new stdClass();
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		// set validation rules
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if ($this->form_validation->run() == false) {
			
			// validation not ok, send validation errors to the view
			$this->load->view('admin/user/login/login');
			
		} else {
			
			// set variables from the form
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			
			if ($this->user_model->resolve_user_login($email, $password)) {
				
				$user_id = $this->user_model->get_user_id_from_username($email);
				$user    = $this->user_model->get_user($user_id);
				// set session user datas
				$_SESSION['admin']      = (bool)true;
				$_SESSION['user_id']      = (int)$user->id;
				$_SESSION['email']     = (string)$user->email;
				$_SESSION['logged_in']    = (bool)true;
				$_SESSION['first_name']    =	(string)$user->first_name;
				$_SESSION['last_name']    =	(string)$user->last_name;

				// user login ok
				redirect('/admin/dashboard');
				
			} else {
				// login failed
				$data->error = 'Wrong username or password.';
				
				// send error to the view
				$this->load->view('admin/user/login/login', $data);
				
			}
			
		}
		
	}
	
	public function logout() {
		
		// create the data object
		$data = new stdClass();
		
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			
			// remove session datas
			foreach ($_SESSION as $key => $value) {
				unset($_SESSION[$key]);
			}
			
			// user logout ok
			redirect('/admin/login');
			
		} else {
			redirect('/');
		}
		
	}

	
}
