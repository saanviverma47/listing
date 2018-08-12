<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
 
 
 
 
 
 
 
 
 
 


/**
 * Contact Queries Controller
 */
class Reports extends Admin_Controller
{
	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->auth->restrict('Contact_Queries.Reports.View');
		$this->load->model('contact_queries_model', null, true);
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
			Assets::add_css('jquery-ui-timepicker.css');
			Assets::add_js('jquery-ui-timepicker-addon.js');
		Template::set_block('sub_nav', 'reports/_sub_nav');

		Assets::add_module_js('contact_queries', 'contact_queries.js');
	}

	//--------------------------------------------------------------------


	/**
	 * Displays a list of form data.
	 *
	 * @return void
	 */
	public function index($offset = 0)
	{

		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked)) {
				$result = FALSE;
				foreach ($checked as $pid) {
					$result = $this->contact_queries_model->delete($pid);
				}

				if ($result) {
					Template::set_message(count($checked) .' '. lang('delete_success'), 'success');
				} else {
					Template::set_message(lang('delete_failure') . $this->contact_queries_model->error, 'error');
				}
			}
		}

		$this->contact_queries_model->limit($this->limit, $offset);
		$records = $this->contact_queries_model->get_all_queries();
		
		// Pagination
		$this->load->library('pagination');
		
		$total_queries = $this->contact_queries_model->count_all();
		
		$this->pager['base_url'] = site_url(SITE_AREA ."/reports/contact_queries/index/");
		$this->pager['total_rows'] = $total_queries;
		$this->pager['per_page'] = $this->limit;
		$this->pager['uri_segment']	= 5;
		
		$this->pagination->initialize($this->pager);

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Contact Queries');
		Template::render();
	}

	/**
	 * Allows editing of Contact Queries data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('contact_queries_invalid_id'), 'error');
			redirect(SITE_AREA .'/reports/contact_queries');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Contact_Queries.Reports.Edit');

			if ($this->save_contact_queries('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'contact_queries');

				Template::set_message(lang('edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('edit_failure') . $this->contact_queries_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Contact_Queries.Reports.Delete');

			if ($this->contact_queries_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('contact_queries_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'contact_queries');

				Template::set_message(lang('delete_success'), 'success');

				redirect(SITE_AREA .'/reports/contact_queries');
			} else {
				Template::set_message(lang('delete_failure') . $this->contact_queries_model->error, 'error');
			}
		}
		Template::set('contact_queries', $this->contact_queries_model->find($id));
		Template::set('toolbar_title', lang('edit') .' Contact Queries');
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
	private function save_contact_queries($type='insert', $id=0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}

		$data = array();
		$data['user_id']        = $this->input->post('contact_queries_user_id');
		$data['name']        = $this->input->post('contact_queries_name');
		$data['email']        = $this->input->post('contact_queries_email');
		$data['phone']        = $this->input->post('contact_queries_phone');
		$data['message']        = $this->input->post('contact_queries_message');
		$data['ip']        = $this->input->post('contact_queries_ip');
		$data['posted_on']        = $this->input->post('contact_queries_posted_on') ? $this->input->post('contact_queries_posted_on') : '0000-00-00 00:00:00';

		if ($type == 'insert') {
			$id = $this->contact_queries_model->insert($data);

			if (is_numeric($id)) {
				$return = $id;
			} else {
				$return = FALSE;
			}
		}
		elseif ($type == 'update') {
			$return = $this->contact_queries_model->update($id, $data);
		}
		return $return;
	}
}