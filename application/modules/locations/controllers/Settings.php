<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
 
 
 
 
 
 
 
 
 
 

/**
 * Locations controller
 */
class Settings extends Admin_Controller
{
	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->auth->restrict('Locations.Settings.View');
		$this->load->model('countries_model', null, true);
		$this->load->model('states_model');
		$this->load->model('cities_model');
		$this->load->model('localities_model');
				
		Template::set_block('sub_nav', 'settings/_sub_nav');
	}
	
	/*----------------------------------------------------*/
	/*	MANAGE COUNTRIES
	/*----------------------------------------------------*/
	/**
	 * Display all countries to the user
	 * @param string $filter for alphabetical display
	 * @param number $offset for pagination
	 */
	public function index($filter='all', $offset=0)
	{
		// Deleting anything?
		if (isset($_POST['delete'])) {
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked)) {
				$result = FALSE;
				foreach ($checked as $pid) {
					$result = $this->countries_model->delete($pid);
				}

				if ($result) {
					Template::set_message(count($checked) .' '. lang('delete_success'), 'success');
				} else {
					Template::set_message(lang('delete_failure') . $this->countries_model->error, 'error');
				}
			}
		}
		
		if (isset($_POST['update_status'])) {
			$this->change_status('countries', $_POST['update_status']);
		}

		$where = array();
		// Filters
		if (preg_match('{first_letter-([A-Z])}', $filter, $matches)) {
			$filter_type = 'first_letter';
			$first_letter = $matches[1];
		} else {
			$filter_type = $filter;
		}
		
		switch($filter_type)
		{
			case 'first_letter':
				$where['SUBSTRING( LOWER(name), 1, 1)='] = $first_letter;
				break;
					
			case 'all':
				// Nothing to do
				break;
					
			default:
				show_404("locations/index/$filter/");
		}
		
		$this->countries_model->limit($this->limit, $offset)->where($where);
		$records = $this->countries_model->find_all();		
		Template::set('records', $records);
		
		// Pagination
		$this->load->library('pagination');
		
		$this->countries_model->where($where);
		$total_countries = $this->countries_model->count_all();
		
		$this->pager['base_url'] = site_url(SITE_AREA ."/settings/locations/index/$filter/");
		$this->pager['total_rows'] = $total_countries;
		$this->pager['per_page'] = $this->limit;
		$this->pager['uri_segment']	= 6;
		
		$this->pagination->initialize($this->pager);
		
		Template::set('index_url', site_url(SITE_AREA .'/settings/locations/index/') .'/');
		Template::set('filter_type', $filter_type);
		
		
		Template::set('toolbar_title', lang('manage_countries'));
		Template::render();
		
	}

	/**
	 * Allow admin to add new country
	 */
	public function add_country()
	{
		$this->auth->restrict('Locations.Settings.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_country()) {
				// Log the activity
				log_activity($this->current_user->id, lang('act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'locations');

				Template::set_message(lang('create_success'), 'success');
				redirect(SITE_AREA .'/settings/locations');
			} else {
				Template::set_message(lang('create_failure') . $this->countries_model->error, 'error');
			}
		}
		
		Template::set('toolbar_title', lang('label_country_new'));
		Template::set_view('settings/countries_form');
		Template::render();
	}

	/**
	 * Allow admin to change country information
	 */
	public function edit_country()
	{
		$id = $this->uri->segment(5);

		if (empty($id)) {
			Template::set_message(lang('invalid_id'), 'error');
			redirect(SITE_AREA .'/settings/locations');
		}

		if (isset($_POST['save'])) {
			$this->auth->restrict('Locations.Settings.Edit');

			if ($this->save_country('update', $id)) {
				// Log the activity
				log_activity($this->current_user->id, lang('act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'locations');

				Template::set_message(lang('edit_success'), 'success');
				redirect(site_url(SITE_AREA .'/settings/locations'));
			} else {
				Template::set_message(lang('edit_failure') . $this->countries_model->error, 'error');
			}
		} else if (isset($_POST['delete'])) {
			$this->auth->restrict('Locations.Settings.Delete');

			if ($this->countries_model->delete($id)) {
				// Log the activity
				log_activity($this->current_user->id, lang('act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'locations');

				Template::set_message(lang('delete_success'), 'success');

				redirect(SITE_AREA .'/settings/locations');
			} else {
				Template::set_message(lang('delete_failure') . $this->countries_model->error, 'error');
			}
		}
		Template::set('countries', $this->countries_model->find($id));
		Template::set('toolbar_title', lang('label_country_edit'));
		Template::set_view('settings/countries_form');
		Template::render();
	}

	/**
	 * Save Country information
	 * @param string $type
	 * @param number $id
	 * @return number
	 */
	private function save_country($type='insert', $id=0)
	{
		if ($type == 'update') {
			$_POST['iso'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['iso']        = $this->input->post('countries_iso');
		$data['name']        = $this->input->post('countries_name');
		$data['printable_name']        = $this->input->post('countries_printable_name');
		$data['iso3']        = $this->input->post('countries_iso3');
		$data['numcode']        = $this->input->post('countries_numcode');

		if ($type == 'insert') {
			$id = $this->countries_model->insert($data);
			if (is_numeric($id)) {
				$return = $this->countries_model->count_all() + 1;
			} else {
				$return = FALSE;
			}
		} elseif ($type == 'update') {
			$return = $this->countries_model->update($id, $data);
		}

		return $return;
	}
	
	/*----------------------------------------------------*/
	/*	MANAGE STATES
	/*----------------------------------------------------*/
	
	/**
	 * Display states to the user
	 * @param string $country_iso
	 * @param string $filter
	 * @param number $offset
	 */
	public function states($country_iso = NULL, $filter='all', $offset=0, $id = NULL)
	{
		if($country_iso == NULL) {
			Template::set_message(lang('selection_failure'), 'error');
			redirect(site_url(SITE_AREA .'/settings/locations/'));
		}
		// Deleting anything?
		if (isset($_POST['delete'])) {
			$checked = $this->input->post('checked');
	
			if (is_array($checked) && count($checked)) {
				$result = FALSE;
				foreach ($checked as $pid) {
					$result = $this->states_model->delete($pid);
				}
	
				if ($result) {
					Template::set_message(count($checked) .' '. lang('delete_success'), 'success');
				} else {
					Template::set_message(lang('delete_failure') . $this->states_model->error, 'error');
				}
			}
		}
		
		$where = array();
		// Filters
		if (preg_match('{first_letter-([A-Z])}', $filter, $matches)) {
			$filter_type = 'first_letter';
			$first_letter = $matches[1];
		} else {
			$filter_type = $filter;
		}
		
		switch($filter_type) {
			case 'first_letter':
				$where['SUBSTRING( LOWER(name), 1, 1)='] = $first_letter;
				break;
					
			case 'all':
				// Nothing to do
				break;
					
			default:
				show_404("locations/states/$country_iso/$filter/");
		}
		
		//FOR NAVIGATION
		$this->session->set_userdata('country_iso', $country_iso);
		
		$this->states_model->limit($this->limit, $offset)->where($where);
		if($country_iso != NULL) {
			$records = $this->states_model->where('country_iso', $country_iso)->order_by('name', 'asc')->find_all();
		} else {
			$records = $this->states_model->order_by('name', 'asc')->find_all();
		}
		Template::set('records', $records);
		
		// Add and update state		
		if (isset($_POST['save'])) {
			if($id == NULL) {
				$this->auth->restrict('Locations.Settings.Create');
				if ($insert_id = $this->save_state()) {
					// Log the activity
					log_activity($this->current_user->id, lang('act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'locations');
			
					Template::set_message(lang('create_success'), 'success');
					if($this->uri->segment(5) && ($this->uri->segment(6)) && ($this->uri->segment(7))) {
						redirect(site_url(SITE_AREA .'/settings/locations/states/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$this->uri->segment(7).'/'));
					} elseif($this->uri->segment(5) && ($this->uri->segment(6))) {
						redirect(site_url(SITE_AREA .'/settings/locations/states/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'));
					} else {
						redirect(site_url(SITE_AREA . '/settings/locations/states/'.$this->uri->segment(5)));
					} 
				} else {
					Template::set_message(lang('create_failure') . $this->states_model->error, 'error');
				}
			} else {			
				$this->auth->restrict('Locations.Settings.Edit');
				if ($this->save_state('update', $id)) {
					// Log the activity
					log_activity($this->current_user->id, lang('act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'locations');
				
					Template::set_message(lang('edit_success'), 'success');
					if($this->uri->segment(5) && ($this->uri->segment(6)) && ($this->uri->segment(7))) {
						redirect(site_url(SITE_AREA .'/settings/locations/states/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$this->uri->segment(7).'/'));						
					} elseif($this->uri->segment(5) && ($this->uri->segment(6))) {
						redirect(site_url(SITE_AREA .'/settings/locations/states/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'));
					} else {
						redirect(site_url(SITE_AREA . '/settings/locations/states/'.$this->uri->segment(5)));
					}
				} else {
					Template::set_message(lang('edit_failure') . $this->states_model->error, 'error');
				}
			}
		}
		
		if (isset($_POST['update_status'])) {
			$this->change_status('states', $_POST['update_status']);
		}
	
		// Pagination
		$this->load->library('pagination');
	
		$this->states_model->where($where);
		$total_states = $this->states_model->where('country_iso', $country_iso)->count_all();
	
		$this->pager['base_url'] = site_url(SITE_AREA ."/settings/locations/states/$country_iso/$filter/");
		$this->pager['total_rows'] = $total_states;
		$this->pager['per_page'] = $this->limit;
		$this->pager['uri_segment']	= 7;
	
		$this->pagination->initialize($this->pager);
	
		Template::set('states', $this->states_model->find($id));
		Template::set('states_url', site_url(SITE_AREA .'/settings/locations/states/'. $country_iso .'/' . $filter . '/') .'/');
	
		Template::set('index_url', site_url(SITE_AREA .'/settings/locations/states/' . $country_iso . '/') .'/');
		Template::set('filter_type', $filter_type);
		
		Template::set('toolbar_title', lang('label_manage_states'));
		Template::render();
	}
	
	/**
	 * SAVE STATE INFORMATION
	 * @param string $type
	 * @param number $id
	 * @return number
	 */
	private function save_state($type='insert', $id=0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}
	
		// make sure we only pass in the fields we want
	
		$data = array();
		$data['name']        = $this->input->post('states_name');
		$data['abbrev']        = $this->input->post('states_abbrev');
		$data['country_iso']	= $this->session->userdata('country_iso');
			
		if ($type == 'insert') {
			$id = $this->states_model->insert($data);
			if (is_numeric($id)) {
				$return = $id;
			} else {
				$return = FALSE;
			}
		}
		elseif ($type == 'update') {
			$return = $this->states_model->update($id, $data);
		}
		return $return;
	}	

	/*----------------------------------------------------*/
	/*	MANAGE CITIES
	/*----------------------------------------------------*/
	
	/**
	 * Allow admin to view, add and update cities information
	 * @param number $state_id
	 * @param string $filter
	 * @param number $offset
	 */
	public function cities($state_id = 0, $filter = 'all', $offset = 0, $city_id = NULL)
	{
		if($state_id == 0) {
			Template::set_message(lang('selection_failure'), 'error');
			redirect(site_url(SITE_AREA .'/settings/locations/'));
		}
		//CHECK WHETHER CITY IS ALPHA OR NUMERIC, IF ALPHA CONVERT IT TO INTEGER
		$state_id = (int)$state_id;
		// Deleting anything?
		if (isset($_POST['delete'])) {
			$checked = $this->input->post('checked');
	
			if (is_array($checked) && count($checked)) {
				$result = FALSE;
				foreach ($checked as $pid) {
					$result = $this->cities_model->delete($pid);
				}
	
				if ($result) {
					Template::set_message(count($checked) .' '. lang('delete_success'), 'success');
				} else {
					Template::set_message(lang('delete_failure') . $this->cities_model->error, 'error');
				}
			}
		}
		
		if (isset($_POST['save'])) {
			if($city_id == NULL) {
				if ($insert_id = $this->save_city()) {
					// Log the activity
					log_activity($this->current_user->id, lang('act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'locations');
			
					Template::set_message(lang('create_success'), 'success');
					if($this->uri->segment(5) && ($this->uri->segment(6)) && ($this->uri->segment(7))) {
						redirect(site_url(SITE_AREA .'/settings/locations/cities/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$this->uri->segment(7).'/'));
					} else if($this->uri->segment(5) && ($this->uri->segment(6))) {
						redirect(site_url(SITE_AREA .'/settings/locations/cities/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'));
					} else {
						redirect(site_url(SITE_AREA . '/settings/locations/cities/'.$this->uri->segment(5)));
					} 
				}
				else {
					Template::set_message(lang('create_failure') . $this->cities_model->error, 'error');
				}
			} else {
				$this->auth->restrict('Locations.Settings.Edit');				
				if ($this->save_city('update', $city_id)) {
					// Log the activity
					log_activity($this->current_user->id, lang('act_edit_record') .': '. $city_id .' : '. $this->input->ip_address(), 'locations');
				
					Template::set_message(lang('edit_success'), 'success');
					if($this->uri->segment(5) && ($this->uri->segment(6)) && ($this->uri->segment(7))) {
						redirect(site_url(SITE_AREA .'/settings/locations/cities/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$this->uri->segment(7).'/'));
					} else if($this->uri->segment(5) && ($this->uri->segment(6))) {
						redirect(site_url(SITE_AREA .'/settings/locations/cities/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/0/'));
					} else {
						redirect(site_url(SITE_AREA . '/settings/locations/cities/'.$this->uri->segment(5)));
					} 
				} else {
					Template::set_message(lang('edit_failure') . $this->cities_model->error, 'error');
				}
			}
		}
		
		if (isset($_POST['update_status'])) {
			$this->change_status('cities', $_POST['update_status']);
		}
		
		$where = array();
		// Filters
		if (preg_match('{first_letter-([A-Z])}', $filter, $matches)) {
			$filter_type = 'first_letter';
			$first_letter = $matches[1];
		} else {
			$filter_type = $filter;
		}
		
		switch($filter_type) {
			case 'first_letter':
				$where['SUBSTRING( LOWER(cities.name), 1, 1)='] = $first_letter;
				break;					
			case 'all':
				// Nothing to do
				break;					
			default:
				show_404("locations/cities/$state_id/$filter/");
		}
		
		
		//FOR NAVIGATION
		$this->session->set_userdata('state_id', $state_id);
	
		$this->cities_model->limit($this->limit, $offset)->where($where);
	
		if($state_id == 0) {	//USER ENTERED URL WITHOUT CITY ID
			$records = $this->cities_model->get_cities_state();
		}
		else {
			$records = $this->cities_model->get_cities_state($state_id);
		}
	
		Template::set('records', $records);
	
		// Pagination
		$this->load->library('pagination');
		
		$this->cities_model->where($where);
		if($state_id == 0) {
			$total_cities = $this->cities_model->count_all();
		}
		else {
			$total_cities = $this->cities_model->where('state_id', $state_id)->count_all();
		}
		$this->pager['base_url'] = site_url(SITE_AREA ."/settings/locations/cities/$state_id/$filter/");
		$this->pager['total_rows'] = $total_cities;
		$this->pager['per_page'] = $this->limit;
		$this->pager['uri_segment']	= 7;
	
		$this->pagination->initialize($this->pager);
		Template::set('index_url', site_url(SITE_AREA .'/settings/locations/cities/' . $state_id . '/') .'/');
		Template::set('filter_type', $filter_type);
		Template::set('cities', $this->cities_model->find($city_id));
		Template::set('toolbar_title', lang('label_manage_cities'));
		Template::render();
	}
	
	/**
	 * Save City Information
	 * @param string $type
	 * @param number $id
	 * @return number
	 */
	private function save_city($type='insert', $id=0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}
		$data = array();
		$data['name']        = $this->input->post('cities_name');
		$data['abbrev']        = $this->input->post('cities_abbrev');
		$data['state_id']	= $this->session->userdata('state_id');
		$data['description'] = $this->input->post('cities_description');
			
		if ($type == 'insert') {
			$id = $this->cities_model->insert($data);
			if (is_numeric($id)) {
				$return = $id;
			} else {
				$return = FALSE;
			}
		} elseif ($type == 'update') {
			$return = $this->cities_model->update($id, $data);
		}
		return $return;
	}
	
	/*----------------------------------------------------*/
	/*	MANAGE LOCALITIES
	/*----------------------------------------------------*/
	
	/**
	 * Allow admin to view, add and update localities
	 * @param number $city_id
	 * @param string $filter
	 * @param number $offset
	 */
	public function localities($city_id = 0, $filter='all', $offset=0, $locality_id = NULL)
	{		
		//CHECK WHETHER CITY IS ALPHA OR NUMERIC, IF ALPHA CONVERT IT TO INTEGER
		$city_id = (int)$city_id;
		if($city_id == 0) {
			Template::set_message(lang('selection_failure'), 'error');
			redirect(site_url(SITE_AREA .'/settings/locations/'));
		}
		// Deleting anything?
		if (isset($_POST['delete'])) {
			$checked = $this->input->post('checked');
	
			if (is_array($checked) && count($checked)) {
				$result = FALSE;
				foreach ($checked as $pid) {
					$result = $this->localities_model->delete($pid);
				}
	
				if ($result) {
					Template::set_message(count($checked) .' '. lang('delete_success'), 'success');
				} else {
					Template::set_message(lang('delete_failure') . $this->localities_model->error, 'error');
				}
			}
		}
		
		if (isset($_POST['update_status'])) {
			$this->change_status('localities', $_POST['update_status']);
		}
		
		if (isset($_POST['save'])) {
			if($locality_id == NULL) {
				$this->auth->restrict('Locations.Settings.Create');
				if ($insert_id = $this->save_locality()) {
					// Log the activity
					log_activity($this->current_user->id, lang('act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'locations');
			
					Template::set_message(lang('create_success'), 'success');
					if($this->uri->segment(5) && ($this->uri->segment(6)) && ($this->uri->segment(7))) {
						redirect(site_url(SITE_AREA .'/settings/locations/localities/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$this->uri->segment(7).'/'));
					} else if($this->uri->segment(5) && ($this->uri->segment(6))) {
						redirect(site_url(SITE_AREA .'/settings/locations/localities/'.$this->uri->segment(5).'/'.$this->uri->segment(6)));
					} else {
						redirect(site_url(SITE_AREA . '/settings/locations/localities/'.$this->uri->segment(5)));
					} 
				} else {
					Template::set_message(lang('create_failure') . $this->localities_model->error, 'error');
				}
			} else {
				$this->auth->restrict('Locations.Settings.Edit');
				if ($this->save_locality('update', $locality_id)) {
					// Log the activity
					log_activity($this->current_user->id, lang('act_edit_record') .': '. $locality_id .' : '. $this->input->ip_address(), 'locations');
				
					Template::set_message(lang('edit_success'), 'success');
					if($this->uri->segment(5) && ($this->uri->segment(6)) && ($this->uri->segment(7))) {
						redirect(site_url(SITE_AREA .'/settings/locations/localities/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$this->uri->segment(7).'/'));
					} else if($this->uri->segment(5) && ($this->uri->segment(6))) {
						redirect(site_url(SITE_AREA .'/settings/locations/localities/'.$this->uri->segment(5).'/'.$this->uri->segment(6)));
					} else {
						redirect(site_url(SITE_AREA . '/settings/locations/localities/'.$this->uri->segment(5)));
					} 
				} else {
					Template::set_message(lang('edit_failure') . $this->localities_model->error, 'error');
				}
			}
		}
		
		$where = array();
		// FILTER DATA
		if (preg_match('{first_letter-([A-Z])}', $filter, $matches)) {
			$filter_type = 'first_letter';
			$first_letter = $matches[1];
		} else {
			$filter_type = $filter;
		}
	
		switch($filter_type) {
			case 'first_letter':
				$where['SUBSTRING( LOWER(`localities`.`name`), 1, 1)='] = $first_letter;
				break;
					
			case 'all':
				// Nothing to do
				break;
					
			default:
				show_404("cities/localities/$filter/");
		}
		//ADD NEW CITY
		$this->session->set_userdata('city_id', $city_id);
		
		$this->localities_model->limit($this->limit, $offset)->where($where);
	
		if($city_id == 0) {	//USER ENTERED URL WITHOUT CITY ID
			$records = $this->localities_model->get_localities_city();
		}
		else {
			$records = $this->localities_model->get_localities_city($city_id);
		}
	
		Template::set('records', $records);
	
		// Pagination
		$this->load->library('pagination');
	
		$this->localities_model->where($where);
	
		if($city_id == 0) {
			$total_cities = $this->localities_model->count_all();
		}
		else {
			$total_cities = $this->localities_model->where('city_id', $city_id)->count_all();
		}
		$this->pager['base_url'] = site_url(SITE_AREA ."/settings/locations/localities/$city_id/$filter/");
		$this->pager['total_rows'] = $total_cities;
		$this->pager['per_page'] = $this->limit;
		$this->pager['uri_segment']	= 7;
	
		$this->pagination->initialize($this->pager);
		Template::set('localities_url', site_url(SITE_AREA .'/settings/locations/localities/'. $city_id .'/') .'/');
			
		Template::set('filter_type', $filter_type);
		Template::set('localities', $this->localities_model->find($locality_id));
			
		Template::set('toolbar_title', lang('label_manage_localities'));
		Template::render();
	}
	
	/**
	 * Update Status
	 * @param string $type
	 * @param int $id
	 */
	private function change_status($type, $id) {
		if($type == 'countries') {
			$sql = "UPDATE " . $this->db->dbprefix . $type . " SET active = NOT active WHERE iso = '" . $id ."'";
		} else {
			$sql = "UPDATE " . $this->db->dbprefix . $type . " SET active = NOT active WHERE id = " . $id;
		}
		$this->db->simple_query($sql);
		Template::redirect(current_url());
	}
		
	/**
	 * Save Locality Information
	 * @param string $type
	 * @param number $id
	 * @return number
	 */
	private function save_locality($type='insert', $id=0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}
	
		$data = array();
		$data['name']        = $this->input->post('localities_name');
		$data['city_id']	= $this->session->userdata('city_id');
			
		if ($type == 'insert') {
			$id = $this->localities_model->insert($data);
			if (is_numeric($id)) {
				$return = $id;
			} else {
				$return = FALSE;
			}
		} elseif ($type == 'update') {
			$return = $this->localities_model->update($id, $data);
		}
		return $return;
	}
	
	/**
	 * Change status of location from index page
	 * @param int $id
	 */
	public function update_status($type, $id, $filter = 'all', $offset = 0, $city_id = 0)
	{
		$this->auth->restrict('Locations.Settings.Edit');
		if($type == 'countries') {
			$sql = "UPDATE " . $this->db->dbprefix . $type . " SET active = NOT active WHERE iso = '" .$id ."'";
		} else {
			$sql = "UPDATE " . $this->db->dbprefix . $type." SET active = NOT active WHERE id = " .$id;
		}
		$this->db->simple_query($sql);
		if($type == 'countries') {
			if($offset != 0){
				redirect(site_url(SITE_AREA .'/settings/locations/index/'.$filter.'/'.$offset));
			} elseif ($filter != 'all') {
				redirect(site_url(SITE_AREA .'/settings/locations/index/' .$filter));
			} else {
				redirect(site_url(SITE_AREA .'/settings/locations'));
			}
		} elseif(($type == 'states') || ($type == 'cities')) {
			if($offset != 0){
				redirect(site_url(SITE_AREA .'/settings/locations/' . $type .'/'. $filter.'/'. $offset));
			} elseif ($filter != 'all') {
				redirect(site_url(SITE_AREA .'/settings/locations/' . $type .'/' . $filter));
			} else {
				redirect(site_url(SITE_AREA .'/settings/locations/' . $type ));
			}
		} elseif($type == 'localities') {
			if($offset != 0) {
				redirect(site_url(SITE_AREA .'/settings/locations/' . $type .'/'. $city_id .'/'. $filter.'/'. $offset));
			} elseif ($filter != 'all') {
				redirect(site_url(SITE_AREA .'/settings/locations/' . $type .'/' . $city_id . '/'. $filter));
			} else {
				redirect(site_url(SITE_AREA .'/settings/locations/' . $type .'/' . $city_id ));
			}
		}
	}
	
	/**
	 * Update state status
	 */
	public function update_state($id, $country_iso, $filter = 'all', $offset = 0) {
		$sql = "UPDATE " . $this->db->dbprefix . "states SET active = NOT active WHERE id = " .$id;
		$this->db->simple_query($sql);
		if($offset != 0){
			redirect(site_url(SITE_AREA .'/settings/locations/states/'. $country_iso .'/'. $filter.'/'. $offset));
		} elseif ($filter != 'all') {
			redirect(site_url(SITE_AREA .'/settings/locations/states/' . $country_iso .'/' . $filter));
		} else {
			redirect(site_url(SITE_AREA .'/settings/locations/states/' . $country_iso ));
		}		
	}
	
	/**
	 * Update city status
	 */
	public function update_city($id, $state_id, $filter = 'all', $offset = 0) {
		$sql = "UPDATE " . $this->db->dbprefix . "cities SET active = NOT active WHERE id = " .$id;
		$this->db->simple_query($sql);
		if($offset != 0){
			redirect(site_url(SITE_AREA .'/settings/locations/cities/'. $state_id .'/'. $filter.'/'. $offset));
		} elseif ($filter != 'all') {
			redirect(site_url(SITE_AREA .'/settings/locations/cities/' . $state_id .'/' . $filter));
		} else {
			redirect(site_url(SITE_AREA .'/settings/locations/cities/' . $state_id));
		}
	
	}
}