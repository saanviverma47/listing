<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
 
 
 
 
 
 
 
 
 
 

/**
 * Pages controller
 */
class Content extends Admin_Controller
{
	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->auth->restrict('Pages.Content.View');
		$this->load->model('pages_model', null, true);
		//$this->lang->load('pages');
		
		$config = array(
				'field' => 'slug',
				'title' => 'name',
				'table' => 'pages',
				'id' => 'id',
		);
		$this->load->library('slug', $config);
		
		Template::set_block('sub_nav', 'content/_sub_nav');
	}

	/**
	 * Displays a list of all pages.
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
					$result = $this->pages_model->delete($pid);
				}

				if ($result) {
					Template::set_message(count($checked) .' '. lang('delete_success'), 'success');
				}
				else {
					Template::set_message(lang('delete_failure') . $this->pages_model->error, 'error');
				}
			}
		}

		$this->pages_model->limit($this->limit, $offset);
		$records = $this->pages_model->find_all();
		
		// Pagination
		$this->load->library('pagination');
		
		$total_pages = $this->pages_model->count_all();;
		
		$this->pager['base_url'] = site_url(SITE_AREA ."/content/pages/index/");
		$this->pager['total_rows'] = $total_pages;
		$this->pager['per_page'] = $this->limit;
		$this->pager['uri_segment']	= 5;
		
		$this->pagination->initialize($this->pager);

		Template::set('records', $records);
		Template::set('toolbar_title', lang('manage_pages'));
		Template::render();
	}

	/**
	 * Allow admin to create new page
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Pages.Content.Create');
		Assets::add_js(array(
		'js/editors/tinymce/tinymce.min.js',
		));
		
		Assets::add_module_js('pages', 'pages.js');

		if (isset($_POST['save'])) {
			if ($insert_id = $this->save_pages()) {
				// Log the activity
				log_activity($this->current_user->id, lang('act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'pages');

				Template::set_message(lang('create_success'), 'success');
				redirect(SITE_AREA .'/content/pages');
			} else {
				Template::set_message(lang('create_failure') . $this->pages_model->error, 'error');
			}
		}
		Assets::add_module_js('pages', 'pages.js');
		
		// Pages for dropdown
		$pages_no_parents = $this->pages_model->get_no_parents();
		Template::set('pages_no_parents', $pages_no_parents);
		Template::set('toolbar_title', lang('new') . ' ' .lang('label_page'));
		Template::set_view('content/pages_form');
		Template::render();
	}

	/**
	 * Allows editing of Pages data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);
		if (empty($id)) {
			Template::set_message(lang('pages_invalid_id'), 'error');
			redirect(SITE_AREA .'/content/pages');
		}
		
		Assets::add_js(array(
			'js/editors/tinymce/tinymce.min.js',
		));
		
		Assets::add_module_js('pages', 'pages.js');

		if (isset($_POST['save'])) {
			$this->auth->restrict('Pages.Content.Edit');

			if ($this->save_pages('update', $id)) {
				// Log the activity
				log_activity($this->current_user->id, lang('act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'pages');

				Template::set_message(lang('edit_success'), 'success');
			} else {
				Template::set_message(lang('edit_failure') . $this->pages_model->error, 'error');
			}
		}
		else if (isset($_POST['delete'])) {
			$this->auth->restrict('Pages.Content.Delete');

			if ($this->pages_model->delete($id)) {
				// Log the activity
				log_activity($this->current_user->id, lang('act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'pages');

				Template::set_message(lang('delete_success'), 'success');

				redirect(SITE_AREA .'/content/pages');
			} else {
				Template::set_message(lang('delete_failure') . $this->pages_model->error, 'error');
			}
		}
		// Pages for dropdown
		$pages_no_parents = $this->pages_model->get_no_parents();
		Template::set('pages_no_parents', $pages_no_parents);
		Template::set('pages', $this->pages_model->find($id));
		Template::set('toolbar_title', lang('edit') .' ' .lang('label_page'));
		Template::set_view('content/pages_form');
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
	private function save_pages($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['parent_id']        = $this->input->post('pages_parent_id');
		$data['title']        = $this->input->post('pages_title');
		$data['slug']        = $this->input->post('pages_slug');
		// Check whether slug is entered or not
		if ($data['slug'] == NULL)
		{
			$data['slug'] = $this->slug->create_uri($data['title']); //If not entered create slug
		}
		$data['body']        = $this->input->post('pages_body');
		$data['meta_title']        = $this->input->post('pages_meta_title');
		$data['meta_keywords']        = $this->input->post('pages_meta_keywords');
		$data['meta_description']        = $this->input->post('pages_meta_description');
		$data['location']        = $this->input->post('pages_location');
		$data['active']        = $this->input->post('pages_active') ? 1 : 0;

		if ($type == 'insert') {
			$id = $this->pages_model->insert($data);

			if (is_numeric($id)) {
				$return = $id;
			} else {
				$return = FALSE;
			}
		} elseif ($type == 'update') {
			$return = $this->pages_model->update($id, $data);
		}

		return $return;
	}
	
	/**
	 * Allow admin to change order of pages
	 */
	public function order ()
	{

		//LOAD NESTED SORTABLE JAVASCRIPT AND CSS FILE
		Assets::add_css('nestedSortable/admin.css');
		Assets::add_js('nestedSortable/jquery-ui.min.js');
		Assets::add_js('nestedSortable/jquery.mjs.nestedSortable.js');
		
		Assets::add_js($this->load->view('content/pages_js', null, true), 'inline');
		Template::set('sortable', TRUE);
		Template::set('toolbar_title', 'Order Pages');
		Template::render();
	}
	
	/**
	 * Order pages using AJAX nestedSortable
	 */
	public function order_ajax ()
	{
		Assets::add_js($this->load->view('content/pages_js', null, true), 'inline');
		// Save order from ajax call
		if (isset($_POST['sortable'])) {
			$this->pages_model->save_order($_POST['sortable']);
		}
	
		// Load view
		$order_pages = $this->pages_model->get_nested();
		Template::set('pages', $order_pages);
		Template::set('toolbar_title', 'Order Pages');
		Template::render();
	}

	/**
	 * Change status of page from index page
	 * @param int $id
	 */
	public function change_status($id)
	{
		//Return old status
		$this->db->select ( 'active' );
		$this->db->where('id', $id);
		$query = $this->db->get ( 'pages' );
	
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
		$this->db->update('pages', $data);
		redirect(SITE_AREA .'/content/pages/');
	}	
}