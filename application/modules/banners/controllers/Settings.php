<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

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

		$this->auth->restrict('Banners.Settings.View');
		$this->load->model('banners_model', null, true);
		$this->load->model('banner_types_model');
		$this->load->model('locations/countries_model');
		$this->load->model('locations/states_model');
		$this->load->model('locations/cities_model');
		//$this->lang->load('banners');	
		
		
		Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
		Assets::add_js('jquery-ui-1.8.13.min.js');
		Assets::add_css('jquery-ui-timepicker.css');
		Assets::add_js('jquery-ui-timepicker-addon.js');
				
		//LOAD DYNATREE JAVASCRIPT AND CSS FILE
		Assets::add_module_js('banners', '../dynatree/jquery/jquery.js');
		Assets::add_module_js('banners', '../dynatree/jquery/jquery-ui.custom.js');
		Assets::add_module_js('banners', '../dynatree/jquery/jquery.cookie.js');
		Assets::add_module_js('banners', '../dynatree/src/jquery.dynatree.js');
		
		
		//BUSINESS HOURS TIME PICKER
		Assets::add_module_css ('banners', '../dynatree/src/skin-vista/ui.dynatree.css' );
		
		Assets::add_js($this->load->view('settings/banners_js', null, true), 'inline');
		
		Template::set_block('sub_nav', 'settings/_sub_nav');
	}

	/**
	 * Displays a list of banners to the admin
	 *
	 * @return void
	 */
	public function index($offset = 0)
	{

		// Deleting anything?
		if (isset($_POST['delete'])) {
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked)) {
				$result = FALSE;
				foreach ($checked as $pid) {
					$this->banners_model->delete_banner_categories($pid);
					$result = $this->banners_model->delete_banner($pid);
				}

				if ($result) {
					Template::set_message(count($checked) .' '. lang('delete_success'), 'success');
				} else {
					Template::set_message(lang('delete_failure') . $this->banners_model->error, 'error');
				}
			}
		}

		$this->banners_model->limit($this->limit, $offset);
		$records = $this->banners_model->get_all();
		
		// Pagination
		$this->load->library('pagination');
		$total_banners = $this->banners_model->count_all();
		$this->pager['base_url'] = site_url(SITE_AREA ."/settings/banners/index/");
		$this->pager['total_rows'] = $total_banners;
		$this->pager['per_page'] = $this->limit;
		$this->pager['uri_segment']	= 5;
		
		$this->pagination->initialize($this->pager);

		Template::set('records', $records);
		Template::set('toolbar_title', lang('manage_banners'));
		Template::render();
	}

	/**
	 * Allow admin to add new banner.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Banners.Settings.Create');

		if (isset($_POST['save'])) {
			if ($insert_id = $this->save_banners()) {
				//STORE BANNER AND CATEGORIES ASSOCIATION IN BANNER_CATEGORIES TABLE
				$this->banner_categories('insert_banner_categories', $insert_id);
				
				//STORE BANNER AND LOCATIONS ASSOCIATION IN BANNER_LOCATIONS TABLE
				$this->banner_locations('insert_banner_locations', $insert_id);
				
				// Log the activity
				log_activity($this->current_user->id, lang('act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'banners');

				Template::set_message(lang('create_success'), 'success');
				redirect(SITE_AREA .'/settings/banners');
			} else {
				Template::set_message(lang('create_failure') . $this->banners_model->error, 'error');
			}
		}
		$banner_types = $this->banner_types_model->select('id,title')->find_all();
		Template::set('banner_types', $banner_types);
		Template::set('toolbar_title', lang('add') . ' ' .lang('label_banner'));
		Template::set_view('settings/banners_form_add');
		Template::render();
	}

	/**
	 * Allows editing of Banners data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id)) {
			Template::set_message(lang('banners_invalid_id'), 'error');
			redirect(SITE_AREA .'/settings/banners');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Banners.Settings.Edit');

			if ($this->save_banners('update', $id)) {
				//STORE BANNER AND CATEGORIES ASSOCIATION IN BANNER_CATEGORIES TABLE
				$this->banner_categories('update_banner_categories', $id);
				
				//STORE BANNER AND LOCATIONS ASSOCIATION IN BANNER_LOCATIONS TABLE
				$this->banner_locations('update_banner_locations', $id);
				
				// Log the activity
				log_activity($this->current_user->id, lang('act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'banners');

				Template::set_message(lang('edit_success'), 'success');
				redirect(SITE_AREA .'/settings/banners');
			} else {
				Template::set_message(lang('edit_failure') . $this->banners_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Banners.Settings.Delete');

			if ($this->banners_model->delete_banner($id))
			{
				$this->banners_model->delete_banner_categories($id);
				// Log the activity
				log_activity($this->current_user->id, lang('act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'banners');

				Template::set_message(lang('delete_success'), 'success');

				redirect(SITE_AREA .'/settings/banners');
			}
			else
			{
				Template::set_message(lang('delete_failure') . $this->banners_model->error, 'error');
			}
		}
		$banner = $this->banners_model->get_banner($id);
		$banner_types = $this->banner_types_model->select('id, title')->find_all(); //Get all banner types for dropdown
		$banner_type = $this->banner_types_model->select('type, location')->find($banner->type_id);//Get banner type for edit page
		
		Template::set( array (
						'banners' => $banner,
						'banner_types' => $banner_types,
						'banner_type' => $banner_type->type,
						'banner_location' => $banner_type->location
						));
		Template::set('toolbar_title', lang('edit') .' '.lang('label_banner'));
		Template::set_view('banners_form_edit');
		Template::render();
	}

	/**
	 * Summary
	 * 
	 * @param String $type Either "insert" or "update"
	 * @param Int	 $id	The ID of the record to update, ignored on inserts
	 *
	 * @return Mixed    An INT id for successful inserts, TRUE for successful updates, else FALSE
	 */
	private function save_banners($type='insert', $id=0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}
		
		// make sure we only pass in the fields we want
		$data = array();
		$data['type_id']        = $this->input->post('banners_type_id');
		$data['title']        = $this->input->post('banners_title');
		
		//Check whether banner is an image or HTML/Text
		if($this->input->post('banners_type') == 'image') {
			//Check whether image is uploaded or not
			if(isset($_FILES['banners_image']) && $_FILES['banners_image']['size'] > 0){
				$options = $this->banner_types_model->select('filesize, width, height')->find($this->input->post('banners_type_id'));
				$file_data = $this->upload_image($options->filesize, $options->width, $options->height);
				if($file_data) {
					$data['image'] = $file_data['upload_data']['file_name'];
				}
				else {
					if($id) {
						redirect(SITE_AREA .'/settings/banners/edit/'. $id);
					} else {
						redirect(SITE_AREA .'/settings/banners/create');
					}
				}
			}		
			
			$data['url']        	= $this->input->post('banners_url');
			$data['target']        	= $this->input->post('banners_target');
			$data['start_date']     = $this->input->post('banners_start_date') ? $this->input->post('banners_start_date') : '0000-00-00 00:00:00';
			$data['end_date']       = $this->input->post('banners_end_date') ? $this->input->post('banners_end_date') : '0000-00-00 00:00:00';
			$data['max_impressions']= $this->input->post('banners_max_impressions') ? $this->input->post('banners_max_impressions') : 0;
			$data['max_clicks']     = $this->input->post('banners_max_clicks') ? $this->input->post('banners_max_clicks') : 0;
		}
		$data['slider_heading']   	= $this->input->post('banners_slider_heading');
		$data['html_text']        	= $this->input->post('banners_html_text');
		$data['all_pages']        	= $this->input->post('banners_all_pages') ? 1 : 0;
		$data['active']        		= $this->input->post('banners_active') ? 1 : 0;

		
		if ($type == 'insert') {
			$id = $this->banners_model->insert_banner($data);

			if (is_numeric($id)) {
				$return = $id;
			} else {
				$return = FALSE;
			}
		} elseif ($type == 'update') {
			$return = $this->banners_model->update_banner($id, $data);
		}

		return $return;
	}
	
	/**
	 * To save banner categories information in association table
	 * @param string $type
	 * @param number $banner_id
	 */
	private function banner_categories($type = 'insert_banner_categories', $banner_id) {		
		if($this->input->post ('selected_categories')) {
			//TO REMOVE EXTRA SPACES
			$patterns = array("/\s+/", "/\s([?.!])/");
			$replacer = array(" ","$1");
			
			// TAKE VALUES FROM POST AND SEPARATE THEM
			$categories = array();
			$ids = explode ( ',', $this->input->post('selected_categories'));
			foreach ($ids as $id) {
				$categories[] = array (
						'banner_id' => $banner_id,
						'category_id' => trim(preg_replace( $patterns, $replacer, $id))
						); //REMOVE WHITE SPACES BEFORE AND AFTER COMMAS
			}
			if ($type == 'insert_banner_categories') {
				$this->banners_model->insert_banner_categories ( $categories );
			} elseif ($type == 'update_banner_categories') {
				// DELETE ALL EXISTING TAGS AND INSERT THEM				
				$this->banners_model->delete_banner_categories ( $banner_id );
				$this->banners_model->insert_banner_categories ( $categories );
			}
		}
		else if($this->input->post('on_post_selected_categories')) {
			//NO CATEGORY SELECTED
			if ($type == 'update_banner_categories') {
				// DELETE ALL EXISTING TAGS
				$this->banners_model->delete_banner_categories ( $banner_id );
			}
		}
		
	}
	
	/**
	 * Deal with banner locations
	 * @param string $type
	 * @param int $banner_id
	 */
	private function banner_locations($type = 'insert_banner_locations', $banner_id) {		
		if($this->input->post ('selected_locations')) {	
			$selected_locations = $this->input->post ('selected_locations');
			$selected_array = explode(',',$selected_locations);
			$banner_locations = array();
			$banner_locations_data = array();
			
			// REMOVE / FROM EACH STRING AND STORE VALUE IN AN ARRAY
			foreach($selected_array as $selected_value) {
				$banner_locations[] = explode('/',substr($selected_value, 1));
			}
			
			// CONVERT ARRAY INTO INSERT BATCH DATA
			foreach($banner_locations as $banner_location) {
				if(isset($banner_location[1])) { // NO STATE SELECTED
					$state_id = $banner_location[1];
				} else {
					$state_id = NULL;
				}
				if(isset($banner_location[2])) { // NO CITY SELECTED
					$city_id = $banner_location[2];
				} else {
					$city_id = NULL;
				}
				$banner_locations_data [] = array (
						'banner_id' => $banner_id,
						'country_iso' => $banner_location[0],
						'state_id' => $state_id,
						'city_id' => $city_id
				);
			}
			if ($type == 'insert_banner_locations') {
				$this->banners_model->insert_banner_locations ( $banner_locations_data );
			}
			elseif ($type == 'update_banner_locations') {
				// DELETE ALL EXISTING TAGS AND INSERT THEM
				$this->banners_model->delete_banner_locations ( $banner_id );
				$this->banners_model->insert_banner_locations ( $banner_locations_data );
			}				
		}	
		else if($this->input->post('on_post_selected_locations')) {
			//NO LOCATION SELECTED
			if ($type == 'update_banner_locations') {
				// DELETE ALL EXISTING TAGS
				$this->banners_model->delete_banner_locations ( $banner_id );
			}
		}		
	}
	
	
	/**
	 * Save uploaded image
	 */
	private function upload_image($filesize, $width, $height){
		$config['upload_path'] 		= realpath(FCPATH.'assets/images/banners/'); //Make SURE that you chmod this directory to 777!
		$config['allowed_types'] 	= 'gif|jpg|png';
		$config['max_size'] 		= $filesize;
		$config['max_width'] 		= $width;
		$config['max_height'] 		= $height;
		$config['remove_spaces']	= TRUE; //Remove spaces from the file name
		
		$this->load->library('upload', $config);
	
		if (!$this->upload->do_upload('banners_image')) // Image name is necessary
		{
			Template::set_message($this->upload->display_errors(), 'error'); // Show errors to the user;
			$id = $this->uri->segment(5);
			if($id) {
				redirect(SITE_AREA .'/settings/banners/edit/'. $id);
			} else {
				redirect(SITE_AREA .'/settings/banners/create');
			}
			
		} else {
			$data = array('upload_data' => $this->upload->data());
			//$this->resize($data['upload_data']['full_path'],$data['upload_data']['file_name']);
		}
		return $data;
	}
	
	/**
	 * Create thumbs of uploaded image
	 */
	public function resize($path,$file){
		$config['image_library']='gd2';
		$config['source_image']=$path;
		//$config['create_thumb']=TRUE; // This will create new file
		$config['maintain_ratio']=TRUE;
		$config['width']=200;
		$config['height']=200;
		$config['new_image']='./assets/images/banners/'.$file; //CHANGE THIS LINE FOR PATH
	
		$this->load->library('image_lib',$config);
		$this->image_lib->resize();
	}

	/*----------------------------------------------------*/
	/*	Manage Banner Types
	/*----------------------------------------------------*/
	
	/**
	 * Display all banner types to admin
	 * @param number $offset
	 */
	public function banner_types($offset = 0) {
		// Deleting anything?
		if (isset($_POST['delete'])) {
			$checked = $this->input->post('checked');
		
			if (is_array($checked) && count($checked)) {
				$result = FALSE;
				foreach ($checked as $pid) {
					$this->delete_banners($pid);					
					$result = $this->banner_types_model->delete($pid);
				}
		
				if ($result) {
					Template::set_message(count($checked) .' '. lang('delete_success'), 'success');
				} else {
					Template::set_message(lang('delete_failure') . $this->banner_types__model->error, 'error');
				}
			}
		}
		
		$this->banner_types_model->limit($this->limit, $offset);
		$records = $this->banner_types_model->find_all();
		// Pagination
		$this->load->library('pagination');
		$total_banner_types = $this->banner_types_model->count_all();
		$this->pager['base_url'] = site_url(SITE_AREA ."/settings/banners/banner_types/");
		$this->pager['total_rows'] = $total_banner_types;
		$this->pager['per_page'] = $this->limit;
		$this->pager['uri_segment']	= 5;
		
		$this->pagination->initialize($this->pager);
		Template::set('records', $records);
		Template::set('toolbar_title', lang('manage_banner_types'));
		Template::render();		
	}
	
	/**
	 * On delete of banner type also delete all related banners and their categories
	 * @param unknown $type_id
	 */
	private function delete_banners($type_id) {
		$result = $this->banners_model->get_banner_types($type_id);
		
		if($result) {
			//STORE OBJECT INTO ARRAYS OTHERWISE VALUE WILL NOT BE DELETED
			foreach ($result as $set_deleted) {
				$to_be_deleted[] = $set_deleted->id;
			}
						
			//USE OF IMPLODE AND DELETE WHERE TO DELETE MULTIPLE VALUES
			$where = "banner_id IN (" . implode(",", $to_be_deleted) .")";	
			$this->banners_model->delete_from_banner_categories($where);
		}
		
		$this->banners_model->delete_banner_types($type_id);
	}
	
	/**
	 * Creates a Banner Type object.
	 *
	 * @return void
	 */
	public function add_banner_type()
	{
		$this->auth->restrict('Banners.Settings.Create');
	
		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_banner_types()) {
				// Log the activity
				log_activity($this->current_user->id, lang('act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'banners');
	
				Template::set_message(lang('create_success'), 'success');
				redirect(SITE_AREA .'/settings/banners/banner_types');
			} else {
				Template::set_message(lang('create_failure') . $this->banner_types_model->error, 'error');
			}
		}
		Assets::add_module_js('banners', 'banners.js');
	
		Template::set('toolbar_title', lang('add') . ' '. lang('label_banner_type'));
		Template::set_view('settings/banner_types_form_add');
		Template::render();
	}
		
	/**
	 * Allows editing of Banner Types data.
	 *
	 * @return void
	 */
	public function edit_banner_types()
	{
		$id = $this->uri->segment(5);
	
		if (empty($id)) {
			Template::set_message(lang('banners_invalid_id'), 'error');
			redirect(SITE_AREA .'/settings/banners/banner_types');
		}
	
		if (isset($_POST['save'])) {
			$this->auth->restrict('Banners.Settings.Edit');
	
			if ($this->save_banner_types('update', $id)) {
				// Log the activity
				log_activity($this->current_user->id, lang('act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'banners');
	
				Template::set_message(lang('edit_success'), 'success');
				redirect(SITE_AREA .'/settings/banners/banner_types');
			} else {
				Template::set_message(lang('edit_failure') . $this->banner_types_model->error, 'error');
			}
		} else if (isset($_POST['delete'])) {
			$this->auth->restrict('Banners.Settings.Delete');
	
			if ($this->banner_types_model->delete($id)) {
				// Log the activity
				log_activity($this->current_user->id, lang('act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'banners');
	
				Template::set_message(lang('delete_success'), 'success');
				redirect(SITE_AREA .'/settings/banners/banner_types');				
			} else {
				Template::set_message(lang('delete_failure') . $this->banner_types_model->error, 'error');
			}
		}
		
		$banners = $this->banner_types_model->find($id);
		Template::set('banners', $banners);
		Template::set('toolbar_title', lang('edit') .' ' .lang('label_banner_type'));
		Template::set_view('settings/banner_types_form_edit');
		Template::render();
	}

	/**
	 * Summary
	 *
	 * @param String $type Either "insert" or "update"
	 * @param Int	 $id	The ID of the record to update, ignored on inserts
	 *
	 * @return Mixed    An INT id for successful inserts, TRUE for successful updates, else FALSE
	 */
	private function save_banner_types($type='insert', $id=0) {
		if ($type == 'update') {
			$_POST['id'] = $id;
		}
		$this->form_validation->set_rules('title', 'lang:label_title', 'required|trim|max_length[100]|sanitize');
		$this->form_validation->set_rules('filesize', 'lang:label_filesize', ($this->input->post('type') && $this->input->post('type') == 'image' ? 'required|' : ''). 'trim|numeric|sanitize');
		$this->form_validation->set_rules('width', 'lang:label_width', 'required|trim|numeric|sanitize');
		$this->form_validation->set_rules('height', 'lang:label_height', 'required|trim|numeric|sanitize');
		$this->form_validation->set_rules('location', 'lang:label_location', 'trim');
		$this->form_validation->set_rules('description', 'lang:label_description', 'trim');
		if ($this->form_validation->run() === false) {
			return false;
		}
		// make sure we only pass in the fields we want
		$data = array();
		$data['title']        	= $this->input->post('title');
		$data['width']        	= $this->input->post('width');
		$data['height']        	= $this->input->post('height');
		//Check whether banner is an image or HTML/Text
		if($this->input->post('type') == 'image') {
			$data['filesize']  	= $this->input->post('filesize');
		}
		$data['location']      	= $this->input->post('location');
		$data['description']	= $this->input->post('description');
	
		if ($type == 'insert') {
			$data['type']       = $this->input->post('type');
			$id = $this->banner_types_model->insert($data);
	
			if (is_numeric($id)) {
				$return = $id;
			} else {
				$return = FALSE;
			}
		} elseif ($type == 'update') {
			$return = $this->banner_types_model->update($id, $data);
		}
	
		return $return;
	}
	
	/**
	 * Get all banner types
	 */
	public function get_banner_type() {
		$banner_type = $this->banner_types_model->select('type, location')->find($this->input->post('banner_type_id'));
		if(($banner_type) && (($banner_type->type == 'image') && ($banner_type->location == 'slider'))) {
			echo $banner_type->location;
		} else {
			echo $banner_type->type;
		}
	}
	
	/**
	 * Change status of banner from index page
	 * @param int $id
	 */
	public function update_status($id, $offset = 0)
	{
		$this->auth->restrict('Banners.Settings.Edit');
		$sql = "UPDATE " . $this->db->dbprefix . "banners SET active = NOT active WHERE id = " .$id;
		$this->db->simple_query($sql);
		if ($offset != 0) {
			redirect(site_url(SITE_AREA .'/settings/banners/index/'.$offset));
		} else {
			redirect(site_url(SITE_AREA .'/settings/banners'));
		}
	}
}