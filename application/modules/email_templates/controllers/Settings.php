<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
 
 
 
 
 
 
 
 
 
 

/**
 * Email Template controller
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

		$this->auth->restrict('Email_Templates.Settings.View');
		$this->load->model('email_templates_model', null, true);
		//$this->lang->load('email_templates');
		Assets::add_js(array(
		'js/editors/ckeditor/ckeditor.js',
		));
		
		Template::set_block('sub_nav', 'settings/_sub_nav');	
	}

	/**
	 * Displays a list of email templates.
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
					$result = $this->email_templates_model->delete($pid);
				}

				if ($result) {
					Template::set_message(count($checked) .' '. lang('delete_success'), 'success');
				} else {
					Template::set_message(lang('delete_failure') . $this->email_templates_model->error, 'error');
				}
			}
		}

		$this->email_templates_model->limit($this->limit, $offset);
		$records = $this->email_templates_model->order_by('name', 'asc')->find_all();
		
		// Pagination
		$this->load->library('pagination');
		
		$total_templates = $this->email_templates_model->count_all();
		
		$this->pager['base_url'] = site_url(SITE_AREA ."/settings/email_templates/index/");
		$this->pager['total_rows'] = $total_templates;
		$this->pager['per_page'] = $this->limit;
		$this->pager['uri_segment']	= 5;
		
		$this->pagination->initialize($this->pager);

		Template::set('records', $records);
		Template::set('toolbar_title', lang('manage_email_templates'));
		Template::render();
	}


	/**
	 * Allows editing of Email Templates data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);
		Assets::add_module_js('email_templates', 'email_templates.js');

		if (empty($id)) {
			Template::set_message(lang('email_templates_invalid_id'), 'error');
			redirect(SITE_AREA .'/settings/email_templates');
		}

		if (isset($_POST['save'])) {
			$this->auth->restrict('Email_Templates.Settings.Edit');

			if ($this->save_email_templates('update', $id)) {
				// Log the activity
				log_activity($this->current_user->id, lang('act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'email_templates');

				Template::set_message(lang('edit_success'), 'success');
				redirect(site_url(SITE_AREA .'/settings/email_templates'));
			} else {
				Template::set_message(lang('edit_failure') . $this->email_templates_model->error, 'error');
			}
		}
		Template::set('email_templates', $this->email_templates_model->find($id));
		Template::set('toolbar_title', lang('edit') .' '. lang('label_email_template'));
		Template::set_view('settings/email_templates_form');
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
	private function save_email_templates($type='insert', $id=0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}
		$data = array();
		$data['subject']        = $this->input->post('email_templates_subject');
		$data['message']        = $this->input->post('email_templates_message');

		if ($type == 'insert') {
			$id = $this->email_templates_model->insert($data);

			if (is_numeric($id)) {
				$return = $id;
			} else {
				$return = FALSE;
			}
		} elseif ($type == 'update') {
			$return = $this->email_templates_model->update($id, $data);
		}

		return $return;
	}
}