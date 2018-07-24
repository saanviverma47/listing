<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User class.
 * 
 * @extends CI_Controller
 */
class Location extends CI_Controller {

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
		$this->load->model('admin/country_model');
		$this->load->model('admin/states_model');
		$this->load->model('admin/cities_model');
		$this->load->model('admin/localities_model');
		
	}
	
	
	public function index() {
		// create the data object
		$data = new stdClass();

		if($this->session->userdata('email')){

			//Get all country
			$data->countries = $this->country_model->get_all_countries();
			 // do something when exist
			$this->load->view('admin/header');
			$this->load->view('admin/nav');
			$this->load->view('admin/location/index', $data);
			$this->load->view('admin/footer');
		}else{
			// do something when doesn't exist
			redirect('/admin/login');
		}
		
	}

	public function states($countryID = null) {
		// create the data object
		$data = new stdClass();

		if($this->session->userdata('email')){

			//Get all country
			$data->states = $this->states_model->get_states_by_country($countryID);
			$data->countryName = $this->country_model->get_country_by_id($countryID);
			$_SESSION['country_id']      = $countryID;
			 // do something when exist
			$this->load->view('admin/header');
			$this->load->view('admin/nav');
			$this->load->view('admin/location/states', $data);
			$this->load->view('admin/footer');
		}else{
			// do something when doesn't exist
			redirect('/admin/login');
		}
		
	}

	public function cities($stateID = null) {
		// create the data object
		$data = new stdClass();

		if($this->session->userdata('email')){

			//Get all country
			$data->cities = $this->cities_model->get_cities_by_state($stateID);
			$data->stateName = $this->states_model->get_state_by_id($stateID);
			$_SESSION['state_id']      = $stateID;
			 // do something when exist
			$this->load->view('admin/header');
			$this->load->view('admin/nav');
			$this->load->view('admin/location/cities', $data);
			$this->load->view('admin/footer');
		}else{
			// do something when doesn't exist
			redirect('/admin/login');
		}
		
	}

	public function locality($cityID = null) {
		// create the data object
		$data = new stdClass();

		if($this->session->userdata('email')){

			//Get all country
			$data->localities = $this->localities_model->get_localities_by_cities($cityID);
			$data->cityName = $this->cities_model->get_city_by_id($cityID);
			$_SESSION['city_id']      = $cityID;
			 // do something when exist
			$this->load->view('admin/header');
			$this->load->view('admin/nav');
			$this->load->view('admin/location/locality', $data);
			$this->load->view('admin/footer');
		}else{
			// do something when doesn't exist
			redirect('/admin/login');
		}
		
	}

}
