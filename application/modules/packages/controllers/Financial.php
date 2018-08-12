<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
 
 
 
 
 
 
 
 
 
 

/**
 * Packages controller
 */
class Financial extends Admin_Controller
{

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->auth->restrict('Packages.Financial.View');
		$this->load->model('packages_model', null, true);
		
		Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
		Assets::add_js('jquery-ui-1.8.13.min.js');
		Assets::add_css('jquery-ui-timepicker.css');
		Assets::add_js('jquery-ui-timepicker-addon.js');
		Template::set_block('sub_nav', 'financial/_sub_nav');

		Assets::add_module_js('packages', 'packages.js');
	}

	/**
	 * Displays a list of packages to the admin
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
					$result = $this->packages_model->delete($pid);
				}

				if ($result) {
					Template::set_message(count($checked) .' '. lang('delete_success'), 'success');
				} else {
					Template::set_message(lang('delete_failure') . $this->packages_model->error, 'error');
				}
			}
		}

		$this->packages_model->limit($this->limit, $offset);
		$records = $this->packages_model->find_all();
		
		// Pagination
		$this->load->library('pagination');
		
		$total_packages = $this->packages_model->count_all();;
		
		$this->pager['base_url'] = site_url(SITE_AREA ."/financial/packages/index/");
		$this->pager['total_rows'] = $total_packages;
		$this->pager['per_page'] = $this->limit;
		$this->pager['uri_segment']	= 5;
		
		$this->pagination->initialize($this->pager);

		Template::set('records', $records);
		Template::set('toolbar_title', lang('manage_packages'));
		Template::render();
	}

	/**
	 * Allow admin to create a new package for member
	 *
	 * @return void
	 */
	public function create()
	{
		Assets::add_css('pick-a-color-1.1.8.min.css');
		Assets::add_js('tinycolor-0.9.14.min.js');
		Assets::add_js('pick-a-color-1.1.8.min.js');
		
		$this->auth->restrict('Packages.Financial.Create');

		if (isset($_POST['save'])) {
			if ($insert_id = $this->save_packages()) {
				$this->set_default($insert_id);
				// Log the activity
				log_activity($this->current_user->id, lang('act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'packages');

				Template::set_message(lang('create_success'), 'success');
				redirect(SITE_AREA .'/financial/packages');
			} else {
				Template::set_message(lang('create_failure') . $this->packages_model->error, 'error');
			}
		}
		Assets::add_module_js('packages', 'packages.js');

		Template::set('toolbar_title', lang('new') . ' Packages');
		Template::set_view('financial/packages_form');
		Template::render();
	}

	/**
	 * Allows editing of Packages data.
	 *
	 * @return void
	 */
	public function edit()
	{
		Assets::add_css('pick-a-color-1.1.8.min.css');
		Assets::add_js('tinycolor-0.9.14.min.js');
		Assets::add_js('pick-a-color-1.1.8.min.js');
		
		$id = $this->uri->segment(5);

		if (empty($id)) {
			Template::set_message(lang('packages_invalid_id'), 'error');
			redirect(SITE_AREA .'/financial/packages');
		}

		if (isset($_POST['save'])) {
			$this->auth->restrict('Packages.Financial.Edit');
			if ($this->save_packages('update', $id)) {				
				// Log the activity
				log_activity($this->current_user->id, lang('act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'packages');

				Template::set_message(lang('edit_success'), 'success');
				$this->set_default($id);
				redirect(SITE_AREA .'/financial/packages/edit/' .$id);
			} else {
				Template::set_message(lang('edit_failure') . $this->packages_model->error, 'error');
			}
		} else if (isset($_POST['delete'])) {
			$this->auth->restrict('Packages.Financial.Delete');

			if ($this->packages_model->delete($id)) {
				// Log the activity
				log_activity($this->current_user->id, lang('act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'packages');
				
				Template::set_message(lang('delete_success'), 'success');

				redirect(SITE_AREA .'/financial/packages');
			} else {
				Template::set_message(lang('delete_failure') . $this->packages_model->error, 'error');
			}
		}
		
		Template::set('packages', $this->packages_model->find($id));
		Template::set('toolbar_title', lang('edit') .' ' .lang('label_package'));
		Template::set_view('financial/packages_form');
		Template::render();
	}

	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	/**
	 * Summary
	 *
	 * @param String $type Either "insert" or "update"
	 * @param Int	 $id	The ID of the record to update, ignored on inserts
	 *
	 * @return Mixed    An INT id for successful inserts, TRUE for successful updates, else FALSE
	 */
	private function save_packages($type='insert', $id=0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['title']        		= $this->input->post('packages_title');
		$data['description']    	= $this->input->post('packages_description');
		$data['default']        	= $this->input->post('packages_default') ? 1 : 0;
		$data['active']        		= $this->input->post('packages_active') ? 1 : 0;
		$data['plan_type']      	= $this->input->post('packages_plan_type');
		$data['subscription']   	= $this->input->post('packages_subscription');
		$data['duration']       	= $this->input->post('packages_duration') ? $this->input->post('packages_duration') : '0';
		$data['price']        		= $this->input->post('packages_price') ? $this->input->post('packages_price') : '0';
		$data['claim_price']        = $this->input->post('packages_claim_price') ? $this->input->post('packages_claim_price') : '0';
		$data['keywords_limit']     = $this->input->post('packages_keywords_limit') ? $this->input->post('packages_keywords_limit') : '0';
		$data['keywords_length']    = $this->input->post('packages_keywords_length') ? $this->input->post('packages_keywords_length') : '0';
		$data['description_limit']  = $this->input->post('packages_description_limit') ? $this->input->post('packages_description_limit') : '0';
		$data['images_limit']       = $this->input->post('packages_images_limit') ? $this->input->post('packages_images_limit') : '0';
		$data['videos_limit']       = $this->input->post('packages_videos_limit') ? $this->input->post('packages_videos_limit') : '0';
		$data['products_limit']     = $this->input->post('packages_products_limit') ? $this->input->post('packages_products_limit') : '0';
		$data['classifieds_limit']  = $this->input->post('packages_classifieds_limit') ? $this->input->post('packages_classifieds_limit') : '0';
		$data['info_limit']        	= $this->input->post('packages_info_limit') ? $this->input->post('packages_info_limit') : '0';
		$data['address']        	= $this->input->post('packages_address') ? 1 : 0;
		$data['email']        		= $this->input->post('packages_email') ? 1 : 0;
		$data['website']        	= $this->input->post('packages_website') ? 1 : 0;
		$data['map']        		= $this->input->post('packages_map') ? 1 : 0;
		$data['logo']        		= $this->input->post('packages_logo') ? 1 : 0;
		$data['phone']        		= $this->input->post('packages_phone') ? 1 : 0;
		$data['person']        		= $this->input->post('packages_person') ? 1 : 0;
		$data['listings_active']    = $this->input->post('packages_listing') ? 1 : 0;
		$data['products_active']    = $this->input->post('packages_product') ? 1 : 0;
		$data['photos_active']      = $this->input->post('packages_photo') ? 1 : 0;
		$data['videos_active']      = $this->input->post('packages_video') ? 1 : 0;
		$data['classifieds_active'] = $this->input->post('packages_classified') ? 1 : 0;
		$data['color_scheme']       = $this->input->post('color_scheme');
		$data['border_color']       = $this->input->post('border_color');

		if ($type == 'insert') {
			$id = $this->packages_model->insert($data);

			if (is_numeric($id)) {
				$return = $id;
			} else {
				$return = FALSE;
			}
		} elseif ($type == 'update') {
			$return = $this->packages_model->update($id, $data);
		}

		return $return;
	}

	/**
	 * Allow admin to change status
	 * @param int $id
	 */
	public function change_status($id)
	{
		//Return old status
		$this->db->select ( 'active' );
		$this->db->where('id', $id);
		$query = $this->db->get ( 'packages' );
	
		$value = 0; //declare variable to store returned result
	
		//Run loop and store integer value in variable
		foreach($query->result() as $row) {
			$value = $row->active;
		}
	
		//Compare values
		if($value == 0) {
			$data['active'] = 1;
		} else {
			$data['active'] = 0;
		}
		//Update status
		$this->db->where('id', $id);
		$this->db->update('packages', $data);
		redirect(SITE_AREA .'/financial/packages/');
	}
	
	/**
	 * Set default
	 * @param int $id
	 */
	public function set_default($id) {
		$rows_to_update = array();
		
		if(($this->uri->segment(4) == 'edit' || $this->uri->segment(4) == 'create') && $this->input->post('packages_default')) {
		//CHECK WHETHER REQUEST IS FROM INDEX PAGE OR FORM
			//SET DEFAULT 1 FOR SELECTED ROW
			// $this->packages_model->update($id, array('default' => 1));
			$this->db->update('packages', array('default' => 1), array('id' => $id));
			
			//GET IDS OF ALL ROWS EXCEPT SPECIFIED ROW
			$result = $this->packages_model->select('id')->where('id NOT IN (' . $id .')')->find_all();
			if($result) {
				//STORE VALUE IN AN ARRAY
				foreach ($result as $row) {
					$rows_to_update[] = $row->id;
				}
				
				$rows = implode(',',$rows_to_update);
				$this->db->where('id IN (' . $rows . ')');
				$this->db->update($this->db->dbprefix . 'packages', array('default' => 0, 'modified_on' => date('Y-m-d H:m:s')));
			}
		} else if($this->uri->segment(4) != 'edit' && $this->uri->segment(4) != 'create') {
			//SET DEFAULT 1 FOR SELECTED ROW
			// $this->packages_model->update($id, array('default' => 1));
			$this->db->update('packages', array('default' => 1), array('id' => $id));
			
			//GET IDS OF ALL ROWS EXCEPT SPECIFIED ROW
			$result = $this->packages_model->select('id')->where('id NOT IN (' . $id .')')->find_all();
			if($result) {
				//STORE VALUE IN AN ARRAY
				foreach ($result as $row) {
					$rows_to_update[] = $row->id;
				}
					
				$rows = implode(',',$rows_to_update);
				$this->db->where('id IN (' . $rows . ')');
				$this->db->update($this->db->dbprefix . 'packages', array('default' => 0, 'modified_on' => date('Y-m-d H:m:s')));
			}
		}		
		redirect(SITE_AREA .'/financial/packages/');		
	}
}