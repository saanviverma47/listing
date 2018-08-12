<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
 
 
 
 
 
 
 
 
 
 

/**
 * Transactions controller
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

		$this->auth->restrict('Transactions.Financial.View');
		$this->load->model('transactions_model', null, true);
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
			Assets::add_css('jquery-ui-timepicker.css');
			Assets::add_js('jquery-ui-timepicker-addon.js');
		Template::set_block('sub_nav', 'financial/_sub_nav');

		Assets::add_module_js('transactions', 'transactions.js');
	}


	/**
	 * Displays a list of all transactions to the admin
	 *
	 * @return void
	 */
	public function index($filter='all', $offset = 0)
	{
		$where = '';
		// Filters
		$filter_type = $filter;
		
		switch($filter_type)
		{
			case 'pending':
				$where['transactions.status'] = 0;
				break;
		
			case 'paid':
				$where['transactions.status'] = 1;
				break;
					
			case 'cancelled':
				$where['transactions.status'] = 2;
				break;
					
			case 'all':
				// Nothing to do
				break;
		
		
			default:
				show_404("transactions/index/$filter/");
		}
		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$result = $this->transactions_model->delete($pid);
				}

				if ($result) {
					Template::set_message(count($checked) .' '. lang('delete_success'), 'success');
				} else {
					Template::set_message(lang('delete_failure') . $this->transactions_model->error, 'error');
				}
			}
		}
		$this->transactions_model->limit($this->limit, $offset)->where($where);
		$records = $this->transactions_model->find_transactions();
		
		// Pagination
		$this->load->library('pagination');
		
		$this->transactions_model->where($where);
		$total_transactions = $this->transactions_model->count_all();
		
		$this->pager['base_url'] = site_url(SITE_AREA ."/financial/transactions/index/$filter_type/");
		$this->pager['total_rows'] = $total_transactions;
		$this->pager['per_page'] = $this->limit;
		$this->pager['uri_segment']	= 6;
		
		$this->pagination->initialize($this->pager);
		Template::set('records', $records);
		Template::set('index_url', site_url(SITE_AREA .'/financial/transactions/index/') .'/');
		Template::set('filter_type', $filter_type);
		Template::set('toolbar_title', lang('manage_transactions'));
		Template::render();
	}

	/**
	 * Allows admin to view and comment transactions.
	 * Admin can also change transaction status
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('invalid_id'), 'error');
			redirect(SITE_AREA .'/financial/transactions');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Transactions.Financial.Edit');

			if ($this->save_transactions('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'transactions');

				Template::set_message(lang('edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('edit_failure') . $this->transactions_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Transactions.Financial.Delete');

			if ($this->transactions_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'transactions');

				Template::set_message(lang('delete_success'), 'success');

				redirect(SITE_AREA .'/financial/transactions');
			}
			else
			{
				Template::set_message(lang('delete_failure') . $this->transactions_model->error, 'error');
			}
		}
		$transactions = $this->transactions_model->get_transaction($id);		
		Template::set('transactions', $transactions);
		Template::set('toolbar_title', lang('edit') . lang('label_transaction'));
		Template::set_view('financial/transactions_form');
		Template::render();
	}

	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	/**
	 * Save information in database
	 *
	 * @param String $type Either "insert" or "update"
	 * @param Int	 $id	The ID of the record to update, ignored on inserts
	 *
	 * @return Mixed    An INT id for successful inserts, TRUE for successful updates, else FALSE
	 */
	private function save_transactions($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['invoice']        = $this->input->post('transactions_invoice');
		$data['package_id']        = $this->input->post('transactions_package_id');
		$data['user_id']        = $this->input->post('transactions_user_id');
		$data['listing_id']        = $this->input->post('transactions_listing_id');
		$data['amount']        = $this->input->post('transactions_amount');
		$data['received_on']        = $this->input->post('transactions_received_on') ? $this->input->post('transactions_received_on') : '0000-00-00 00:00:00';
		$data['comments']        = $this->input->post('transactions_comments');
		$data['ip_address']		= $this->input->post('transactions_ip_address');
		$data['status']        = $this->input->post('transactions_status');		

		if ($type == 'insert')
		{			
			$id = $this->transactions_model->insert($data);

			if (is_numeric($id))
			{
				$return = $id;
			}
			else
			{
				$return = FALSE;
			}
		}
		elseif ($type == 'update')
		{
			$update_data = array (
				'comments' => $data['comments'],
				'status'	=> $data['status']
			);
			
			$return = $this->transactions_model->update($id, $update_data);
		}

		return $return;
	}
}