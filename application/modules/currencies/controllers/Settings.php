<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
 
 
 
 
 
 
 
 
 
 

/**
 * Currency controller
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

		$this->auth->restrict('Currencies.Settings.View');
		$this->load->model('currencies_model', null, true);
		
		Template::set_block('sub_nav', 'settings/_sub_nav');
	}

	/**
	 * Displays a list of currencies to admin.
	 *
	 * @return void
	 */
	public function index($offset = 0, $id = NULL)
	{

		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked)) {
				$result = FALSE;
				foreach ($checked as $pid) {
					$result = $this->currencies_model->delete($pid);
				}

				if ($result) {
					Template::set_message(count($checked) .' '. lang('delete_success'), 'success');
				} else {
					Template::set_message(lang('delete_failure') . $this->currencies_model->error, 'error');
				}
			}
		}

		if (isset($_POST['save'])) {
			if($id == NULL) {
				$this->auth->restrict('Currencies.Settings.Create');
				if ($insert_id = $this->save_currencies()) {
					// Log the activity
					log_activity($this->current_user->id, lang('act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'currencies');
			
					Template::set_message(lang('create_success'), 'success');
					if($this->uri->segment(5)) {
						redirect(SITE_AREA .'/settings/currencies/index/' .$this->uri->segment(5));
					} else {
						redirect(SITE_AREA .'/settings/currencies');
					}
					
				} else {
					Template::set_message(lang('create_failure') . $this->currencies_model->error, 'error');
				}
			} else {
				$this->auth->restrict('Currencies.Settings.Edit');
				
				if ($this->save_currencies('update', $id)) {
					// Log the activity
					log_activity($this->current_user->id, lang('act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'currencies');
				
					Template::set_message(lang('edit_success'), 'success');
					if($this->uri->segment(5)) {
						redirect(SITE_AREA .'/settings/currencies/index/' .$this->uri->segment(5));
					} else {
						redirect(SITE_AREA .'/settings/currencies');
					}
				} else {
					Template::set_message(lang('edit_failure') . $this->currencies_model->error, 'error');
				}
			}
		}
		
		$this->currencies_model->limit($this->limit, $offset);
		$records = $this->currencies_model->find_all();
		
		// Pagination
		$this->load->library('pagination');
		
		$total_currencies = $this->currencies_model->count_all();
		
		$this->pager['base_url'] = site_url(SITE_AREA ."/settings/currencies/index/");
		$this->pager['total_rows'] = $total_currencies;
		$this->pager['per_page'] = $this->limit;
		$this->pager['uri_segment']	= 5;
		
		$this->pagination->initialize($this->pager);

		Template::set('currencies', $this->currencies_model->find($id));
		Template::set('records', $records);
		Template::set('toolbar_title', lang('manage_currencies'));
		Template::render();
	}

	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	/**
	 * Summary
	 * Save currency information
	 * @param String $type Either "insert" or "update"
	 * @param Int	 $id	The ID of the record to update, ignored on inserts
	 *
	 * @return Mixed    An INT id for successful inserts, TRUE for successful updates, else FALSE
	 */
	private function save_currencies($type='insert', $id=0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}
		$data = array();
		$data['code']      	= $this->input->post('currencies_code');
		$data['symbol']    	= $this->input->post('currencies_symbol');
		$data['name']      	= $this->input->post('currencies_name');
		$data['active']    	= 1;

		if ($type == 'insert') {
			$id = $this->currencies_model->insert($data);

			if (is_numeric($id)) {
				$return = $id;
			} else {
				$return = FALSE;
			}
		} elseif ($type == 'update') {
			$return = $this->currencies_model->update($id, $data);
		}

		return $return;
	}
	
	/**
	 * Change status of currency from index page
	 * @param int $id
	 */
	public function update_status($id, $offset = 0)
	{
		$this->auth->restrict('Currencies.Settings.Edit');
		$sql = "UPDATE " . $this->db->dbprefix . "currencies SET active = NOT active WHERE id = " .$id;
		$this->db->simple_query($sql);
		if($offset != 0){
			redirect(site_url(SITE_AREA .'/settings/currencies/index/' .$offset));
		} else {
			redirect(site_url(SITE_AREA .'/settings/currencies/'));
		}
	}
}