<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

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

		$this->auth->restrict('Categories.Content.View');
		$this->load->model('categories_model', null, true);
		
		Assets::add_module_js('categories', 'categories.js');
		
		$config = array(
				'field' => 'slug',
				'title' => 'name',
				'table' => 'categories',
				'id' => 'id',
		);
		$this->load->library('slug', $config);
		
		//LOAD CKEDITOR
		Assets::add_js(array(
		'js/editors/tinymce/tinymce.min.js',
		));
				
		Template::set_block('sub_nav', 'content/_sub_nav');
	}

	/**
	 * Displays a list of all categories to the admin.
	 *
	 * @return void
	 */
	public function index($id = NULL, $offset = 0)
	{		
		// Deleting anything?
		if (isset($_POST['delete'])) {
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked)) {
				$result = FALSE;
				foreach ($checked as $pid) {
					// Delete subcategories
					$where = "parent_id = " .$pid;
					$this->categories_model->delete_where($where);
					$result = $this->categories_model->delete($pid);					
				}

				if ($result) {
					Template::set_message(count($checked) .' '. lang('delete_success'), 'success');
				} else {
					Template::set_message(lang('delete_failure') . $this->categories_model->error, 'error');
				}
			}
		}
		
		$this->categories_model->limit($this->limit, $offset);
		if (isset($_POST['search'])) {
			$searchterm = $this->input->post('search');
			$this->db->or_like(array(
					'id' => $searchterm,
					'name' => $searchterm
			));
			$records = $this->categories_model->find_all();
		} else {
			if($id != NULL)	{
				$records = $this->categories_model->find_all_by('parent_id', $id);
			}
			else {
				$records = $this->categories_model->find_all_by('parent_id', 0);
			}
		}
		
		// Check whether categories or subcategories page called
		$parent_id = $this->uri->segment(5);
		if($parent_id) {
			$parent_name = $this->categories_model->select('name')->find($parent_id);
			Template::set('parent_name', $parent_name->name);
		}
		// Pagination
		$this->load->library('pagination');
		if($id != NULL)	{
			$total_categories = $this->categories_model->count_by(array('parent_id' => $id));
		} else {
			$total_categories = $this->categories_model->count_by(array('parent_id' => 0));
		}
		
		if($id != NULL) {
			$this->pager['base_url'] = site_url(SITE_AREA ."/content/categories/index/" .$id."/");
		} else {
			$this->pager['base_url'] = site_url(SITE_AREA ."/content/categories/index/0/");
		}
		$this->pager['total_rows'] = $total_categories;
		$this->pager['per_page'] = $this->limit;
		$this->pager['uri_segment']	= 6;
		
		$this->pagination->initialize($this->pager);
		// Pass parent_id as a variable
		Template::set('parent_id', $parent_id);
		Template::set('records', $records);
		if($id == NULL) {
			Template::set('toolbar_title', lang('manage_categories'));
		} else {
			Template::set('toolbar_title', lang('manage_subcategories'));
		}
		Template::render();
	}

	/**
	 * Allow admin to create a new category or subcategory.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Categories.Content.Create');
		
		if (isset($_POST['save'])) {
			if ($insert_id = $this->save_categories()) {
				// Log the activity
				log_activity($this->current_user->id, lang('act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'categories');

				Template::set_message(lang('create_success'), 'success');
				redirect(SITE_AREA .'/content/categories');
			}
			else
			{
				Template::set_message(lang('create_failure') . $this->categories_model->error, 'error');
			}
		}
		
		//Display Parent Categories to the user
		$categories_no_parents = $this->categories_model->get_no_parents();
		Template::set('categories_no_parents', $categories_no_parents); //Pass data to view
		
		Template::set('toolbar_title', lang('add') . ' '.lang('label_category'));
		Template::set_view('content/categories_form');
		Template::render();
	}

	/**
	 * Allows editing of Categories data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id)) {
			Template::set_message(lang('categories_invalid_id'), 'error');
			redirect(SITE_AREA .'/content/categories');
		}

		if (isset($_POST['save'])) {
			$this->auth->restrict('Categories.Content.Edit');

			if ($this->save_categories('update', $id)) {
				// Log the activity
				log_activity($this->current_user->id, lang('act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'categories');

				Template::set_message(lang('edit_success'), 'success');
				if($this->session->userdata('parent_category_navigation')) {
					redirect(SITE_AREA .'/content/categories/index/' .$this->session->userdata('parent_category_navigation'));
					$this->session->unset_userdata('parent_category_navigation');
				} else {
					redirect(SITE_AREA .'/content/categories');
				}
			} else {
				Template::set_message(lang('edit_failure') . $this->categories_model->error, 'error');
			}
		}
		else if (isset($_POST['delete'])) {
			$this->auth->restrict('Categories.Content.Delete');

			if ($this->categories_model->delete($id)) {
				// Log the activity
				log_activity($this->current_user->id, lang('act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'categories');

				Template::set_message(lang('delete_success'), 'success');

				redirect(SITE_AREA .'/content/categories');
			} else {
				Template::set_message(lang('delete_failure') . $this->categories_model->error, 'error');
			}
		}
		$record = $this->categories_model->find($id);
		/*--------------- CATEGORY SECTION ----------------------*/
		//Display Parent Categories to the user
		$categories_no_parents = $this->categories_model->get_no_parents();
		$sub_category = NULL;
		$result = $this->categories_model->select('parent_id')->find($record->parent_id); //FIND CATEGORY PARENT
		if(!is_bool($result) && $result->parent_id != 0) {
			$get_parent = $this->categories_model->select('id')->find($result->parent_id); //GET PARENT CATEGORY
			$parent_category = $get_parent->id;
			$sub_category = $record->parent_id; //AND CONSIDER LISTING CATEGORY_ID AS SUB CATEGORY
		}
		else {
			$parent_category = $record->parent_id;
		}
		//GET ALL CATEGORIES
		$categories = $this->categories_model->get_parent_categories();
		
		//GET SUBCATEGORIES ONLY IF PARENT EXIST
		if($parent_category != $record->parent_id) {
			$sub_categories = $this->categories_model->select('id, name')->where('parent_id', $parent_category)->find_all();
		}
		else { $sub_categories = NULL; }
		/* ------------ END OF CATEGORY SECTION ----------------*/
		
		Template::set( array(
			'categories_no_parents' => $categories_no_parents,
			'sub_categories' 	=> $sub_categories,
			'parent_category'	=> $parent_category,
			'sub_category'		=> $sub_category,
		)); //Pass data to view
		
		Template::set('categories', $record);
		Template::set('toolbar_title', lang('edit') .' ' .lang('label_category'));
		Template::set_view('content/categories_form');
		Template::render();
	}

	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	/**
	 * Summary
	 * Save Category
	 * @param String $type Either "insert" or "update"
	 * @param Int	 $id	The ID of the record to update, ignored on inserts
	 *
	 * @return Mixed    An INT id for successful inserts, TRUE for successful updates, else FALSE
	 */
	private function save_categories($type='insert', $id=0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}
		$data = array();
		
		if((settings_item('lst.categories_level') == 3) && ($this->input->post('listings_subcategory_id'))) {
			$data['parent_id']      = $this->input->post('listings_subcategory_id');
		} else {
			$data['parent_id']      = $this->input->post('categories_parent_id');
		}
		$data['name']        		= $this->input->post('categories_name');
		$data['slug']        		= $this->input->post('categories_slug');
		$data['description']        = $this->input->post('categories_description');
		// Check whether slug is entered or not
		if ($data['slug'] == NULL) {
			$data['slug'] 			= $this->slug->create_uri($data['name']); //If not entered create slug
		}
		$data['meta_title']        	= $this->input->post('categories_meta_title');
		$data['meta_keywords']      = $this->input->post('categories_meta_keywords');	
		$data['meta_description']   = $this->input->post('categories_meta_description');
		$data['active']        		= $this->input->post('categories_active') ? 1 : 0;

		if ($type == 'insert') {
			$id = $this->categories_model->insert($data);

			if (is_numeric($id)) {
				$return = $id;
			} else {
				$return = FALSE;
			}
		} elseif ($type == 'update') {
			$return = $this->categories_model->update($id, $data);
		}

		return $return;
	}
	
	/**
	 * Allow admin to change order of categories
	 */
	public function order ()
	{
		//LOAD NESTED SORTABLE JAVASCRIPT AND CSS FILE
		Assets::add_module_js('categories', '../jquery-ui-custom/jquery-ui.min.js');
		Assets::add_module_js('categories', '../nestedSortable2.0/jquery.mjs.nestedSortable.js');
		Assets::add_module_css('categories', '../nestedSortable2.0/admin.css');
		Assets::add_js($this->load->view('content/categories_js', null, true), 'inline');
		Template::set('sortable', TRUE);
		Template::set('toolbar_title', 'Order Categories');
		Template::render();
	}
	
	/**
	 * Ajax function to order categories using nestedSortable
	 */
	public function order_ajax ()
	{
		//LOAD NESTED SORTABLE JAVASCRIPT AND CSS FILE
		Assets::add_module_js('categories', '../jquery-ui-custom/jquery-ui.min.js');
		Assets::add_module_js('categories', '../nestedSortable2.0/jquery.mjs.nestedSortable.js');
		Assets::add_module_css('categories', '../nestedSortable2.0/admin.css');
		Assets::add_js($this->load->view('content/categories_js', null, true), 'inline');
		// Save order from ajax call
		if (isset($_POST['sortable'])) {
			$this->categories_model->save_order($_POST['sortable']);
		}
	
		// Load view
		Template::set('categories', $this->categories_model->get_nested());
		Template::set('toolbar_title', 'Order Categories');
		Template::render();
	}
	
	/**
	 * Change status of category from index page
	 * @param int $id
	 */
	public function update_status($id, $category_id = 0, $offset = 0)
	{
		$this->auth->restrict('Categories.Content.Edit');
		$sql = "UPDATE " . $this->db->dbprefix . "categories SET active = NOT active WHERE id = " .$id;
		$this->db->simple_query($sql);
		if(($category_id != 0) && ($offset != 0)){
			redirect(site_url(SITE_AREA .'/content/categories/index/'.$category_id.'/'.$offset));
		} elseif ($category_id != 0) {
			redirect(site_url(SITE_AREA .'/content/categories/index/' .$category_id));
		} elseif($offset != 0) {
			redirect(site_url(SITE_AREA .'/content/categories/index/0/' .$offset));
		} else {
			redirect(site_url(SITE_AREA .'/content/categories'));
		}
	}
	
	/**
	 * Update listings count for home page
	 */
	public function counts() {
		$result = $this->categories_model->get_home_categories();
		if($result) {
			foreach($result as $count) {
				$sql = "UPDATE " . $this->db->dbprefix . "categories SET counts = ".$count['TotalCounts']." WHERE id = " .$count['category_id'];
				$this->db->simple_query($sql);
			}
			Template::set_message(lang('message_count_success'), 'success');
			redirect(site_url(SITE_AREA .'/content/categories'));
		}
	}
}