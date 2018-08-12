<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
 
 
 
 
 
 
 
 
 
 

/**
 * Payment Gateways controller
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

		$this->auth->restrict('Payment_Gateways.Settings.View');
		$this->load->model('payment_gateways_model', null, true);
		//$this->lang->load('payment_gateways');
		
		Template::set_block('sub_nav', 'settings/_sub_nav');
	}


	/**
	 * Displays all payment gateways to admin.
	 *
	 * @return void
	 */
	public function index($offset = 0)
	{
		$this->payment_gateways_model->limit($this->limit, $offset);
		$records = $this->payment_gateways_model->find_all();
		
		// Pagination
		$this->load->library('pagination');
		
		$total_gateways = $this->payment_gateways_model->count_all();;
		
		$this->pager['base_url'] = site_url(SITE_AREA ."/settings/payment_gateways/index/");
		$this->pager['total_rows'] = $total_gateways;
		$this->pager['per_page'] = $this->limit;
		$this->pager['uri_segment']	= 5;
		
		$this->pagination->initialize($this->pager);

		Template::set('records', $records);
		Template::set('toolbar_title', lang('manage_payment_gateways'));
		Template::render();
	}

	/*----------------------------------------------------*/
	/*	PayPal Payment Gatway
	 /*----------------------------------------------------*/

	/**
	 * Allows editing of PayPal Payment Gateway data.
	 *
	 * @return void
	 */
	public function paypal()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('invalid_id'), 'error');
			redirect(SITE_AREA .'/settings/payment_gateways');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Payment_Gateways.Settings.Edit');

			if ($this->save_paypal('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'payment_gateways');

				Template::set_message(lang('edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('edit_failure') . $this->payment_gateways_model->error, 'error');
			}
		}
		// Find record
		$paypal = $this->payment_gateways_model->find($id);
		
		// Retrieve settings from database
		$settings = unserialize($paypal->settings);
		
		Template::set('paypal', $paypal);
		Template::set('settings', $settings);
		Template::set('toolbar_title', lang('edit') .lang('label_paypal'));
		Template::render();
	}
	
	/**
	 * Save PayPal Information
	 * @param Int	 $id	The ID of the record to update
	 */
	private function save_paypal($type='update', $id=0)
	{
		$_POST['id'] = $id;
		$data = array();
		$data['display_name']        = $this->input->post('display_name');
		$data['order']        = $this->input->post('order');
		$settings = array('api_username'=>$this->input->post('paypal_api_username'),'api_password'=>$this->input->post('paypal_api_password'),'api_signature'=>$this->input->post('paypal_api_signature'),'currency'=>$this->input->post('paypal_currency'), 'testmode'=> ($this->input->post('paypal_testmode') ? 1 : 0));
		$data['settings'] = serialize($settings);
		$data['active']        = $this->input->post('active') ? 1 : 0;
		
		$rules = $this->payment_gateways_model->validation_rules_paypal;
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run() == TRUE) {
			return $this->payment_gateways_model->update($id, $data);
		} else {
			return false;
		}		
	}
	
	/**
	 * Make payment gateway active or inactive from index page
	 * @param int $id
	 */
	public function change_status($id)
	{
		//Return old status
		$query = $this->payment_gateways_model->select('active')->find($id);
		
		$value = 0; //declare variable to store returned result
	
		//Run loop and store integer value in variable
		foreach($query as $row) {
			$value = $row;
		}
		
		//Compare values
		if($value == 0) {
			$data['active'] = 1;
		} else {
			$data['active'] = 0;
		}
		//Update status
		$this->db->where('id', $id);
		$this->db->update('payment_gateways', $data);
		redirect(SITE_AREA .'/settings/payment_gateways/');
	}
}