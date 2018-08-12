<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
 
 
 
 
 
 
 
 
 
 

/**
 * Claim/Incorrect controller
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

		$this->auth->restrict('Claim_Reports.Reports.View');
		$this->load->model('claim_reports_model', null, true);
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
			Assets::add_css('jquery-ui-timepicker.css');
			Assets::add_js('jquery-ui-timepicker-addon.js');
		Template::set_block('sub_nav', 'reports/_sub_nav');
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
		if (isset($_POST['delete'])) {
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked)) {
				$result = FALSE;
				foreach ($checked as $pid) {
					$result = $this->claim_reports_model->delete($pid);
				}

				if ($result) {
					Template::set_message(count($checked) .' '. lang('delete_success'), 'success');
				} else {
					Template::set_message(lang('delete_failure') . $this->claim_reports_model->error, 'error');
				}
			}
		}
		
		$this->claim_reports_model->limit($this->limit, $offset);
		$records = $this->claim_reports_model->get_claim_reports();
		
		// Pagination
		$this->load->library('pagination');
		
		$total_claims = $this->claim_reports_model->count_all();
		
		$this->pager['base_url'] = site_url(SITE_AREA ."/reports/claim_reports/index/");
		$this->pager['total_rows'] = $total_claims;
		$this->pager['per_page'] = $this->limit;
		$this->pager['uri_segment']	= 5;
		
		$this->pagination->initialize($this->pager);

		Template::set('records', $records);
		Template::set('toolbar_title', lang('manage_claim_reports'));
		Template::render();
	}

	/**
	 * Allows viewing of Claim Reports data.
	 *
	 * @return void
	 */
	public function view()
	{
		$id = $this->uri->segment(5);

		if (empty($id)) {
			Template::set_message(lang('claim_reports_invalid_id'), 'error');
			redirect(SITE_AREA .'/reports/claim_reports');
		}
		if (isset($_POST['save'])) {
			$this->auth->restrict('Claim_Reports.Reports.Edit');
			if ($this->save_claim_reports($id)) {
				// Log the activity
				log_activity($this->current_user->id, lang('act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'claim_reports');
		
				Template::set_message(lang('edit_success'), 'success');
				redirect(site_url(SITE_AREA .'/reports/claim_reports'));
			} else {
				Template::set_message(lang('edit_failure') . $this->claim_reports_model->error, 'error');
			}
		} elseif (isset($_POST['delete'])) {
			$this->auth->restrict('Claim_Reports.Reports.Delete');

			if ($this->claim_reports_model->delete($id)) {
				// Log the activity
				log_activity($this->current_user->id, lang('act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'claim_reports');

				Template::set_message(lang('delete_success'), 'success');

				redirect(SITE_AREA .'/reports/claim_reports');
			} else {
				Template::set_message(lang('delete_failure') . $this->claim_reports_model->error, 'error');
			}
		}
		Template::set('claim_reports', $this->claim_reports_model->get_claim_incorrect($id));
		Template::set('toolbar_title', lang('label_view') .' ' .lang('label_claim_incorrect'));
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
	private function save_claim_reports($id)
	{
		$_POST['id'] = $id;	
		$data = array();
		$data['type']        		= $this->input->post('claim_reports_type');
		$data['description']        = $this->input->post('claim_reports_description');
		$return = $this->claim_reports_model->update($id, $data);
		return $return;
	}
}