<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
 
 
 
 
 
 
 
 
 
 

/**
 * Content controller
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

		$this->auth->restrict('Listings.Content.View');
		$this->load->model('listings_model', null, true);
		
		//CREATE SLUG
		$config = array(
				'field' => 'slug',
				'title' => 'name',
				'table' => 'listings',
				'id' => 'id',
		);
		$this->load->library('slug', $config);
		
		//LOAD ALL MODELS FOR FILTERING AND OTHER OPERATIONS
		$this->load->model('products_model');		
		$this->load->model('videos_model');
		$this->load->model('classifieds_model');
		$this->load->model('business_hours_model');		
		$this->load->model('roles/role_model');
		$this->load->model('categories/categories_model');
		$this->load->model('locations/countries_model');
		$this->load->model('tags/tags_model');
				
		$this->lang->load('datatable');
		
		Assets::add_js('jquery-ui-1.8.13.min.js');
		Assets::add_js(array(
		'js/editors/ckeditor/ckeditor.js',
		));
		
		Assets::add_js(array(
		'js/editors/tinymce/tinymce.min.js',
		));
		
		//LOAD MODAL FOR YOUTUBE VIDEO PLAYER
		Assets::add_js('js/bootstrap.youtubepopup.min.js');
		
		//BUSINESS HOURS TIME PICKER
		Assets::add_css ( 'flick/jquery-ui-1.8.13.custom.css' );
		Assets::add_js ( 'jquery-ui-1.8.13.min.js' );
		Assets::add_css ( 'jquery-ui-timepicker.css' );
		Assets::add_js ( 'jquery-ui-timepicker-addon.js' );
		
		//SEARCH LISTING
		//Assets::add_js(Template::theme_url('js/bootstrap.js'));
		
		Assets::add_js( array ( Template::theme_url('js/jquery.dataTables.min.js' )) );
		Assets::add_js( array ( Template::theme_url('js/bootstrap-dataTables.js' )) );
		Assets::add_css( array ( Template::theme_url('css/datatable.css') ) ) ;
		Assets::add_css( array ( Template::theme_url('css/bootstrap-dataTables.css') ) ) ;
		
		//Load image_crud config and libraries file for upload_images function
		/* --------------------------------- */ 		
		$this->load->config('image_crud');
		
		$this->load->library('image_crud');
		$this->load->library('image_moo');
		/* --------------------------------- */
		
		Template::set_block('sub_nav', 'content/_sub_nav');

		Assets::add_module_js('listings', 'options.js');
		Assets::add_module_js('listings', 'listings.js');
	}

	/* ------------------------ LISTING MODULE ---------------------------------------- */
	/**
	 * Displays a list of form data.
	 *
	 * @return void
	 */
	
	public function index($filter='all', $offset=0)
	{
		Assets::add_js($this->load->view('content/listings_js', null, true), 'inline');
		// Fetch having we might want to filter on
		$roles = $this->role_model->select('role_id, role_name')->where('deleted', 0)->find_all();
		$ordered_roles = array();
		foreach ($roles as $role) {
			$ordered_roles[$role->role_id] = $role;
		}
		Template::set('roles', $ordered_roles);		
				
		// Do we have any actions?
		if (isset($_POST['activate']))    $action = '_activate';
		if (isset($_POST['deactivate']))  $action = '_deactivate';
		if (isset($_POST['spam']))        $action = '_spam';
		if (isset($_POST['unspam']))      $action = '_unspam';
		if (isset($_POST['delete']))      $action = '_delete';
		if (isset($_POST['purge']))       $action = '_purge';
		if (isset($_POST['restore']))     $action = '_restore';
	
		if (isset($action)) {
			$checked = $this->input->post('checked');
	
			if (!empty($checked)) {				
				foreach($checked as $listing_id) {
					$result = $this->$action($listing_id);
				}
				if ($result && $action == '_delete') {
					Template::set_message(count($checked) .' '. lang('delete_success'), 'success');
				} else if($action == '_delete') {
					Template::set_message(lang('delete_failure') . $this->listings_model->error, 'error');
				} else {
					Template::set_message(count($checked) .' '. lang('update_success'), 'success');
				}
			} else {
				Template::set_message(lang('ls_empty_id'), 'error');
			}
		}
	
		// Actions done, now display the view
		$where = "deleted = 0";//array('listings.deleted' => 0);
	
		// Filters
		if (preg_match('{first_letter-([A-Z])}', $filter, $matches)) {
			$filter_type = 'first_letter';
			$first_letter = $matches[1];
		} elseif (preg_match('{role_id-([0-9]*)}', $filter, $matches)) {
			$filter_type = 'role_id';
			$role_id = (int) $matches[1];
		} else {
			$filter_type = $filter;
		}
	
		switch($filter_type) {
			case 'claimed':
				$where = "claimed = 1 AND deleted = 0";
				break;
				
			case 'unclaimed':
				$where = "claimed = 0 AND deleted = 0";
				break;
			
			case 'inactive':
				$where = "active = 0 AND deleted = 0";
				break;
	
			case 'spammed':
				$where = "spammed = 1 AND deleted = 0";
				break;
	
			case 'deleted':
				$where = "deleted = 1";
				break;
				
			case 'logo':
				$where = "logo_url IS NOT NULL"; //LOGO IS NOT NULL
				Template::set('filter_having', 'Logo'); //DISPLAY HAVING IN SELECTION
				break;
				
			case 'product':
				//FILTER LISTINGS HAVING PRODUCT
				$products = array();
				//MODEL ADDED IN CONSTRUCTOR
				$result = $this->products_model->select('distinct(listing_id)')->find_all();
				if($result) { //PREVENT ERRORS IF QUERY RETURN NULL RESULT
					foreach ($result as $record) {
						$products[] = $record->listing_id;
					}
				}
				
				if($products) {
					$where = "id IN (" . implode(",", $products) .")";
				}
				else {
					$where = "id = NULL";
				}
				
				Template::set('filter_having', 'Products/Services');
				break;
			
			case 'photos':
				//FILTER LISTINGS HAVING IMAGES
				$photos = array();
				//MODEL ADDED IN CONSTRUCTOR
				$photos_result = $this->listings_model->photos_filter();
				//dump($photos_result);
				if($photos_result) {
					foreach ($photos_result as $photos_record) {
						$photos[] = $photos_record->listing_id;
					}
				}
				
				if($photos) {
					$where = "id IN (" . implode(",", $photos) .")";
				}
				else {
					$where = "id = NULL";
				}
				
				Template::set('filter_having', 'Photos');
				break;
			
			case 'videos':
				//FILTER LISTINGS HAVING VIDEOS
				$videos = array();
				//MODEL ADDED IN CONSTRUCTOR
				$videos_result = $this->videos_model->select('distinct(listing_id)')->find_all();
				if($videos_result) { //PREVENT ERRORS IF QUERY RETURN NULL RESULT
					foreach ($videos_result as $videos_record) {
						$videos[] = $videos_record->listing_id;
					}
				}
				
				if($videos) {
					$where = "id IN (" . implode(",", $videos) .")";
				}
				else {
					$where = "id = NULL";
				}
				
				Template::set('filter_having', 'Videos');
				break;
			
			case 'classifieds':
				//FILTER LISTINGS HAVING CLASSIFIEDS
				$classifieds = array();
				//MODEL ADDED IN CONSTRUCTOR
				$classifieds_result = $this->classifieds_model->select('distinct(listing_id)')->find_all();
				if($classifieds_result) { //PREVENT ERRORS IF QUERY RETURN NULL RESULT
					foreach ($classifieds_result as $classifieds_record) {
						$classifieds[] = $classifieds_record->listing_id;
					}
				}
				if($classifieds) {
					$where = "id IN (" . implode(",", $classifieds) .")";
				}
				else {
					$where = "id = NULL";
				}
				
				Template::set('filter_having', 'Classifieds');
				break;
			
			case 'business_hours':
				//FILTER LISTINGS HAVING BUSINESS HOURS
				$business_hours = array();
				//MODEL ADDED IN CONSTRUCTOR
				$business_hours_result = $this->business_hours_model->select('distinct(listing_id)')->find_all();
				if($business_hours_result) { //PREVENT ERRORS IF QUERY RETURN NULL RESULT
					foreach ($business_hours_result as $business_hours_record) {
						$business_hours[] = $business_hours_record->listing_id;
					}
				}
				
				// IF QUERY RETURN NULL RESULT AND ARRAY IS ALSO NULL RUN ELSE
				if($business_hours) {
					$where = "id IN (" . implode(",", $business_hours) .")";
				}
				else {
					$where = "id = NULL";
				}
				Template::set('filter_having', 'Business Hours');
				
				break;
	
			case 'role_id':
				$where = "user_id = ". $role_id;
	
				foreach ($roles as $role)
				{
					if ($role->role_id == $role_id)
					{
						Template::set('filter_role', $role->role_name);
						break;
					}
				}
				break;
	
			case 'first_letter':
				$where = "SUBSTRING( LOWER(title), 1, 1)= '". $first_letter ."'";
				break;
	
			case 'all':
				// Nothing to do
				break;
	
			default:
				show_404("listings/index/$filter/");
		}
	
		// Fetch the listings to display
		if(!empty($_POST['order_by'])) {
			switch($this->input->post('order_by')) {
				case 'id_asc':
					$order_by = 'id asc';
					break;
				case 'id_desc':
					$order_by = 'id desc';
					break;
				case 'title_asc':
					$order_by = 'title asc';
					break;
				case 'title_desc':
					$order_by = 'title desc';
					break;
				case 'created_asc':
					$order_by = 'created_on asc';
					break;
				case 'created_desc':
					$order_by = 'created_on desc';
					break;
			}
			$this->session->set_userdata('listings_order_by', $order_by);
		} elseif($this->session->userdata('listings_order_by')) {
			$order_by = $this->session->userdata('listings_order_by');
		} else {
			$order_by = 'id desc';
			$this->session->set_userdata('listings_order_by', $order_by);
		}
		if (isset($_POST['search'])) {
			$searchterm = $this->input->post('search');
			$where .= " AND (id LIKE '%" .$searchterm . "%' OR title LIKE '%" .$searchterm . "%' OR email LIKE '%" .$searchterm . "%' OR created_on LIKE '%" .$searchterm . "%') ";
			$records = $this->listings_model->get_admin_listings($offset, $this->limit, $where, $order_by);
		} else {
			$records = $this->listings_model->get_admin_listings($offset, $this->limit, $where, $order_by);//$this->listings_model->select('listings.id, listings.title, listings.email, listings.created_on, listings.active')->order_by('id', 'desc')->find_all();
		}
		
		Template::set('records', $records);
			
		// Pagination
		$this->load->library('pagination');
	
		if (isset($_POST['search'])) {
			$searchterm = $this->input->post('search');
			$where .= " AND (id LIKE '%" .$searchterm . "%' OR title LIKE '%" .$searchterm . "%' OR email LIKE '%" .$searchterm . "%' OR created_on LIKE '%" .$searchterm . "%') ";
			$this->listings_model->where($where);
			$total_listings = $this->listings_model->count_all();
		} else {
			$this->listings_model->where($where);
			$total_listings = $this->listings_model->count_all();
		}
	
		$this->pager['base_url'] = site_url(SITE_AREA ."/content/listings/index/$filter/");
		$this->pager['total_rows'] = $total_listings;
		$this->pager['per_page'] = $this->limit;
		$this->pager['uri_segment']	= 6;
	
		$this->pagination->initialize($this->pager);
	
		Template::set('index_url', site_url(SITE_AREA .'/content/listings/index/'));
		Template::set('filter_type', $filter_type);
	
		Template::set('toolbar_title', lang('listings_manage'));
		Template::render();
	
	}//end index()
	

	/**
	 * Allow admin to add new listing
	 */
	public function create() {		
		$this->auth->restrict('Listings.Content.Create');
		//Assets::add_module_js('listings', 'listings.js');
		if (isset($_POST['save'])) {
			if ($insert_id = $this->save_listings()) {
				// Store listing and categories association in listing_categories table
				$this->listing_categories('insert_listing_categories', $insert_id);
				// Store tags in listing_tags table				
				$this->deal_with_tags('insert_listing_tags', $insert_id);
				// Log the activity
				log_activity($this->current_user->id, lang('act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'listings');

				Template::set_message(lang('create_success'), 'success');
				redirect(SITE_AREA .'/content/listings');
			} else {
				Template::set_message(lang('create_failure') . $this->listings_model->error, 'error');
			}
		}
		
		
		$this->load->library('statistics');
		$this->statistics->info();
		$countries = $this->listings_model->get_countries();
		$categories = $this->categories_model->get_parent_categories();
		
		$map = $this->google_map();
		$this->load->model('packages/packages_model');
		$packages = $this->packages_model->select('id, title')->find_all();
		
		// POST HANDLING ON PAGE SUBMIT
		if(settings_item('lst.categories_level') == 1) {
			if($this->input->post('listings_category_id')) {
				$parent_category = $this->input->post('listings_category_id');
				Template::set('parent_category', $sub_category);
			}
		} else if(settings_item('lst.categories_level') == 2) {
			if($this->input->post('listings_category_id')) {
				$parent_category = $this->input->post('listings_category_id');
				Template::set('parent_category', $parent_category);
				$sub_categories = $this->categories_model->select('id, name')->find_all_by('parent_id', $this->input->post('listings_category_id'));
				Template::set('sub_categories', $sub_categories);
			}
		
			if($this->input->post('listings_subcategory_id')) {
				$sub_category = $this->input->post('listings_subcategory_id');
				Template::set('sub_category', $sub_category);
			}
		} else if(settings_item('lst.categories_level') == 3) {
			if($this->input->post('listings_category_id')) {
				$parent_category = $this->input->post('listings_category_id');
				Template::set('parent_category', $parent_category);
				$sub_categories = $this->categories_model->select('id, name')->find_all_by('parent_id', $this->input->post('listings_category_id'));
				Template::set('sub_categories', $sub_categories);
			}
		
			if($this->input->post('listings_subcategory_id')) {
				$sub_category = $this->input->post('listings_subcategory_id');
				Template::set('sub_category', $sub_category);
				$subsub_categories = $this->categories_model->select('id, name')->find_all_by('parent_id', $this->input->post('listings_subcategory_id'));
				Template::set('subsub_categories', $subsub_categories);
			}
		
			if($this->input->post('listings_subsubcategory_id')) {
				Template::set('subsub_category', $this->input->post('listings_subsubcategory_id'));
			}
		}
		
		if (settings_item ( 'lst.allow_country_selection' ) == 1) {
			if ($this->input->post ( 'listings_country_id' )) {
				$selected_country = $this->input->post ( 'listings_country_id' );
				Template::set ( 'selected_country', $selected_country );
				$this->load->model ( 'locations/states_model' );
				$listing_states = $this->states_model->select ( 'id, name' )->find_all_by ( 'country_iso', $this->input->post ( 'listings_country_id' ) );
				Template::set ( 'states', $listing_states );
			}
		} else {
			$this->load->model ( 'locations/states_model' );
			$listing_states = $this->states_model->select ( 'id, name' )->find_all_by ( 'country_iso', settings_item ( 'adv.default_country' ) );
			Template::set ( 'states', $listing_states );
		}
				
		if($this->input->post('listings_state_id')) {
			$selected_state = $this->input->post('listings_state_id');
			Template::set('selected_state', $selected_state);
			$this->load->model('locations/cities_model');
			$cities = $this->cities_model->select('id, name')->find_all_by('state_id', $this->input->post('listings_state_id'));
			Template::set('cities', $cities);
		}
		
		if($this->input->post('listings_city_id')) {
			$selected_city = $this->input->post('listings_city_id');
			Template::set('selected_city', $selected_city);
			$this->load->model('locations/localities_model');
			$localities = $this->localities_model->select('id, name')->find_all_by('city_id', $this->input->post('listings_city_id'));
			Template::set('localities', $localities);
		}
		
		if($this->input->post('listings_locality_id')) {
			$selected_locality = $this->input->post('listings_locality_id');
			Template::set('selected_locality', $selected_locality);
		}
		
		Template::set(array(
			'categories'	=> $categories,
			'countries'		=> $countries,
			'packages'		=> $packages,
			'map'			=> $map
		));
		Template::set('toolbar_title', lang('add') . ' '.lang('label_listing'));
		Template::set_view('content/listings_form');
		Template::render();
	}
	
	/**
	 * Allow admin to update listing
	 */
	public function edit() {
		$id = $this->uri->segment(5);

		if (empty($id)) {
			Template::set_message(lang('invalid_id'), 'error');
			redirect(SITE_AREA .'/content/listings');
		}

		if (isset($_POST['save'])) {
			$this->auth->restrict('Listings.Content.Edit');

			if ($this->save_listings('update', $id)) {
				// Store listing and categories association in listing_categories table
				$this->listing_categories('update_listing_categories', $id);
				// Store listing and tags association in listing_tags table
				$this->deal_with_tags('update_listing_tags', $id);
				// Log the activity
				log_activity($this->current_user->id, lang('act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'listings');

				Template::set_message(lang('edit_success'), 'success');
			} else {
				Template::set_message(lang('edit_failure') . $this->listings_model->error, 'error');
			}
		}
		else if (isset($_POST['delete'])) {
			$this->auth->restrict('Listings.Content.Delete');

			if ($this->listings_model->delete($id))	{
				// Log the activity
				log_activity($this->current_user->id, lang('act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'listings');

				Template::set_message(lang('delete_success'), 'success');

				redirect(SITE_AREA .'/content/listings');
			} else {
				Template::set_message(lang('delete_failure') . $this->listings_model->error, 'error');
			}
		}
		$record = $this->listings_model->find($id);
		
		/*--------------- CATEGORY SECTION ----------------------*/
		//DEAL WITH CATEGORIES
		/*$sub_category = NULL;
		$result = $this->categories_model->select('parent_id')->find($record->category_id); //FIND CATEGORY PARENT
		if($result->parent_id != 0) {
			$get_parent = $this->categories_model->select('id')->find($result->parent_id); //GET PARENT CATEGORY
			$parent_category = $get_parent->id;
			$sub_category = $record->category_id; //AND CONSIDER LISTING CATEGORY_ID AS SUB CATEGORY
		}
		else {
			$parent_category = $record->category_id;
		}
		//GET ALL CATEGORIES
		$categories = $this->categories_model->get_parent_categories();
		
		//GET SUBCATEGORIES ONLY IF PARENT EXIST
		if($parent_category != $record->category_id) {
			$sub_categories = $this->categories_model->select('id, name')->where('parent_id', $parent_category)->find_all();
		}
		else { $sub_categories = NULL; }*/
		//DEAL WITH CATEGORIES
		$categories = $this->categories_model->get_parent_categories();
		$sub_category = NULL;
		$result = $this->categories_model->select('parent_id')->find($record->category_id); //FIND CATEGORY PARENT
		if($result->parent_id != 0) {
			$get_parent = $this->categories_model->select('id, parent_id')->find($result->parent_id); //GET PARENT CATEGORY
			if($get_parent->parent_id != 0) { // CHECK WHETHER IT IS A SUB OR SUB SUB CATEGORY
				$get_sub_parent = $this->categories_model->select('id, name, parent_id')->find($get_parent->id);
				$parent_category = $get_parent->parent_id;
				$sub_category = $get_parent->id;
				$subsub_category = $record->category_id;
				$sub_categories = $this->categories_model->select('id, name')->where('parent_id', $parent_category)->find_all();
				$subsub_categories = $this->categories_model->select('id, name, parent_id')->find_all_by('parent_id', $sub_category);
			} else {
				$parent_category = $get_parent->id;
				$sub_categories = $this->categories_model->select('id, name')->where('parent_id', $parent_category)->find_all();
				$sub_category = $record->category_id; //AND CONSIDER LISTING CATEGORY_ID AS SUB CATEGORY
				$subsub_categories = $this->categories_model->select('id, name, parent_id')->find_all_by('parent_id', $sub_category);
				$subsub_category = NULL;
			}
		} else {
			$parent_category = $record->category_id;
			$sub_categories = $this->categories_model->select('id, name')->where('parent_id', $parent_category)->find_all();
			$subsub_categories = NULL;
			$subsub_category = NULL;
		}
		
		/* ------------ END OF CATEGORY SECTION ----------------*/
		
		$countries = $this->listings_model->get_countries();
		$states = $this->listings_model->get_states($record->country_iso);
		$cities = $this->listings_model->get_cities($record->state_id);
		$localities = $this->listings_model->get_localities($record->city_id);
		
		$map = $this->google_map($record->latitude, $record->longitude);
		
		/* --------------------- TAGS -------------------------*/
		// GET KEYWORDS FROM TAGS TABLE AND STORE THEM IN AN ARRAY
		$keywords = array ();
		$tags = '';
		$tags_id_result = $this->tags_model->find_listing_tags ($id);
		if ($tags_id_result) {
			foreach ( $tags_id_result as $keyword ) {
				$keywords [] = $keyword->name;
			}
			$tags = implode ( ', ', $keywords ); // STORE THEM AS A STRING IN COMMA SEPARATED VERSION
		}
		/* ------------------- END OF TAGS ----------------------*/
		$this->load->model('packages/packages_model');
		$packages = $this->packages_model->select('id, title')->find_all();
		
		// POST HANDLING ON PAGE SUBMIT
		if(settings_item('lst.categories_level') == 1) {
			if($this->input->post('listings_category_id')) {
				$parent_category = $this->input->post('listings_category_id');
				Template::set('parent_category', $sub_category);
			}
		} else if(settings_item('lst.categories_level') == 2) {
			if($this->input->post('listings_category_id')) {
				$parent_category = $this->input->post('listings_category_id');
				Template::set('parent_category', $parent_category);
				$sub_categories = $this->categories_model->select('id, name')->find_all_by('parent_id', $this->input->post('listings_category_id'));
				Template::set('sub_categories', $sub_categories);
			}  else {
				Template::set('sub_categories', $sub_categories);
			}
				
			if($this->input->post('listings_subcategory_id')) {
				$sub_category = $this->input->post('listings_subcategory_id');
				Template::set('sub_category', $sub_category);
			}
		} else if(settings_item('lst.categories_level') == 3) {
			if($this->input->post('listings_category_id')) {
				$parent_category = $this->input->post('listings_category_id');
				Template::set('parent_category', $parent_category);
				$sub_categories = $this->categories_model->select('id, name')->find_all_by('parent_id', $this->input->post('listings_category_id'));
				Template::set('sub_categories', $sub_categories);
			} else {
				Template::set('sub_categories', $sub_categories);
			}
				
			if($this->input->post('listings_subcategory_id')) {
				$sub_category = $this->input->post('listings_subcategory_id');
				Template::set('sub_category', $sub_category);
				$subsub_categories = $this->categories_model->select('id, name')->find_all_by('parent_id', $this->input->post('listings_subcategory_id'));
				Template::set('subsub_categories', $subsub_categories);
			} else {
				Template::set('subsub_categories', $subsub_categories);
			}
				
			if($this->input->post('listings_subsubcategory_id')) {
				Template::set('subsub_category', $this->input->post('listings_subsubcategory_id'));
			} else {
				Template::set('subsub_category', $subsub_category);
			}
		}

		if(settings_item('lst.allow_country_selection') == 1) {
			if($this->input->post('listings_country_id')) {
				$selected_country = $this->input->post('listings_country_id');
				Template::set('selected_country', $selected_country);
				$this->load->model('locations/states_model');
				$states = $this->states_model->select('id, name')->find_all_by('country_iso', $this->input->post('listings_country_id'));
				Template::set('states', $states);
			} else {
				Template::set('states', $states);
			}
		} else {
			$this->load->model('locations/states_model');
			$listing_states = $this->states_model->select('id, name')->find_all_by('country_iso', settings_item('adv.default_country'));
			Template::set('states', $listing_states);
		}
		
		if($this->input->post('listings_state_id')) {
			$selected_state = $this->input->post('listings_state_id');
			Template::set('selected_state', $selected_state);
			$this->load->model('locations/cities_model');
			$cities = $this->cities_model->select('id, name')->find_all_by('state_id', $this->input->post('listings_state_id'));
			Template::set('cities', $cities);
		} else {
			Template::set('cities', $cities);
		}
		
		if($this->input->post('listings_city_id')) {
			$selected_city = $this->input->post('listings_city_id');
			Template::set('selected_city', $selected_city);
			$this->load->model('locations/localities_model');
			$localities = $this->localities_model->select('id, name')->find_all_by('city_id', $this->input->post('listings_city_id'));
			Template::set('localities', $localities);
		}
		
		if($this->input->post('listings_locality_id')) {
			$selected_locality = $this->input->post('listings_locality_id');
			Template::set('selected_locality', $selected_locality);
		}
		
		Template::set(array(
			'packages'			=> $packages,
			'categories' 		=> $categories,
			'parent_category'	=> $parent_category,
			'sub_category'		=> $sub_category,
			'countries'			=> $countries,
			'localities'		=> $localities,
			'map'				=> $map,
			'tags'				=> $tags
		));
		
		$this->session->set_userdata('previous_city', $record->city_id);
		Template::set('listings', $record);
		Template::set('toolbar_title', lang('edit') .' Listing');
		Template::set_view('content/listings_form');
		Template::render();
	}

	/**
	 * Save listing information
	 * @param string $type
	 * @param number $id
	 * @return number
	 */
	private function save_listings($type='insert', $id=0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}
		
		$data = array();
		$data['title']        		= $this->input->post('listings_title');
		$data['slug']        		= $this->slug->create_uri($data['title']);
		$data['package_id']    		= $this->input->post('listings_package_id');
		
		// Categories Handling
		if(settings_item('lst.categories_level') == 1) {
			$data ['category_id'] = $this->input->post ( 'listings_category_id' );
		} else if(settings_item('lst.categories_level') == 2) {
			if ($this->input->post ( 'listings_subcategory_id' )) {
				$data ['category_id'] = $this->input->post ( 'listings_subcategory_id' );
			} else {
				$data ['category_id'] = $this->input->post ( 'listings_category_id' );
			}
		} else if(settings_item('lst.categories_level') == 3) {
			if ($this->input->post ( 'listings_subsubcategory_id' )) {
				$data ['category_id'] = $this->input->post ( 'listings_subsubcategory_id' );
			} elseif ($this->input->post ( 'listings_subcategory_id' )) {
				$data ['category_id'] = $this->input->post ( 'listings_subcategory_id' );
			} else {
				$data ['category_id'] = $this->input->post ( 'listings_category_id' );
			}
		}
		
		if(settings_item('allow_country_selection') == 1) {
			$data ['country_iso'] = $this->input->post ( 'listings_country_id' );
		} else {
			$data ['country_iso'] = settings_item('adv.default_country');
		}
		
		$data['state_id']        	= $this->input->post('listings_state_id');
		$data['city_id']        	= $this->input->post('listings_city_id');
		if($this->input->post('listings_locality_id')) {
			$data['locality_id']   	= $this->input->post('listings_locality_id');
		} else {
			$data['locality_id']   	= NULL;
		}
		$data['pincode']        	= $this->input->post('listings_pincode');
		$data['address']        	= $this->input->post('listings_address');
		$data['latitude']        	= $this->input->post('listings_latitude');
		$data['longitude']        	= $this->input->post('listings_longitude');
		$data['contact_person']    	= $this->input->post('listings_contact_person');
		$data['phone_number']      	= $this->input->post('listings_phone_number');
		$data['mobile_number']      = $this->input->post('listings_mobile_number');
		$data['tollfree']        	= $this->input->post('listings_tollfree');
		$data['fax']        		= $this->input->post('listings_fax');
		$data['email']        		= $this->input->post('listings_email');
		$data['website']        	= $this->input->post('listings_website');
		if(settings_item('lst.allow_facebook_url') == 1) {
			$data['facebook_url']      	= $this->input->post('listings_facebook_url');
		}
		if(settings_item('lst.allow_twitter_url') == 1) {
			$data['twitter_url']       	= $this->input->post('listings_twitter_url');
		}
		if(settings_item('lst.allow_googleplus_url') == 1) {
			$data['googleplus_url']    	= $this->input->post('listings_googleplus_url');
		}
		$data['description']        = $this->input->post('listings_description');
		if($this->input->post('listings_expires_on')) {
			$data['expires_on'] 	= $this->input->post('listings_expires_on');
		}
		$data['featured'] 			= $this->input->post('listings_featured') ? 1 : 0;
		$data['active'] 			= $this->input->post('listings_active') ? 1 : 0;
		if ($type == 'insert') {
			$id = $this->listings_model->insert($data);
			if (is_numeric($id)) {
				$return = $id;
			} else {
				$return = FALSE;
			}
		} elseif ($type == 'update') {			
			$return = $this->listings_model->update($id, $data);
		}
		return $return;
	}

	/**
	 * Show google map on listing create and update
	 * @param string $latitude
	 * @param string $longitude
	 */
	public function google_map($latitude = NULL, $longitude = NULL){
		$this->load->library('googlemaps');
		$config = array();
		//SET LATITUDE AND LONGITUDE IF NOT EDIT
		if(($latitude == NULL) && ($longitude == NULL))
		{
			$ip = $_SERVER['REMOTE_ADDR'];
			//MADE USE OF FREE PLUGIN
			$geopluginURL='http://www.geoplugin.net/php.gp?ip=49.249.196.21'; //.$ip;
			$unarr= file_get_contents($geopluginURL);     // Get File Contents
			$AddArr = unserialize($unarr);    // Get PHP values from file contents			
			$latitude = $AddArr['geoplugin_latitude'];  // City Name
			$longitude = $AddArr['geoplugin_longitude'];
		}
		$config['center'] = "$latitude, $longitude";
		$config['zoom'] = 14;
		$config['places'] = TRUE;
		$this->googlemaps->initialize($config);
	
		$marker = array();
		$marker['position'] = "$latitude, $longitude";
		$marker['draggable'] = true;
		$marker['ondragend'] = 'updateLatLngTextFields(event.latLng.lat(), event.latLng.lng());';
		$this->googlemaps->add_marker($marker);	
		return $this->googlemaps->create_map();
	}
	
	/**
	 * Get Subcategories using AJAX
	 * @param unknown $parent_id
	 */
	public function get_sub_categories($parent_id){
		$suboptions = $this->categories_model->get_sub_categories($parent_id);
	
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($suboptions);
	}
	
	/**
	 * Get States and Cities using AJAX
	 * @return location information in HTML format
	 */
	public function loadData() {
		$loadType = $_GET['loadType'];
		$loadId = $_GET['loadId'];
		$result = $this->listings_model->getData($loadType,$loadId);
		$HTML="";
		if($result){
			foreach($result as $list) {
				$HTML.="<option value='".$list->id."'>".$list->name."</option>";
			}
		}
		echo $HTML;
	}
	
	/*----------------------------------------------------*/
	/*	TAGS Handling
	/*----------------------------------------------------*/
	
	/**
	 * Deal with all keywords
	 * @param string $type
	 * @param unknown $listing_id
	 */
	public function deal_with_tags($type = 'insert_listing_tags', $listing_id) {
			
		if ($this->input->post ('listings_keywords')) {
			
			$selected_country_iso = $this->input->post('listings_country_id');
			$selected_state_id = $this->input->post('listings_state_id');
			$selected_city_id = $this->input->post('listings_city_id');
				
			$data = array ();
				
			$user_entered_tags = array (); // STORE USER ENTERED TAGS
			$new_tags = array (); // STORE NEW_TAGS
			$all_tags = array (); // STORE ID OF ALL TAGS
			$existing_tags_id = array(); // FOR COUNT
			$existing_tags_id_string = ''; // FOR MULTIPLE COUNT UPDATE			 
			$tags = ''; //SET TAGS VALUE TO NULL IF NO ASSOCIATION EXIST
			
			// GET KEYWORDS FROM TAGS TABLE AND STORE THEM IN AN ARRAY
			$keywords = array ();
			$result = $this->tags_model->find_listing_tags ( $listing_id );
			if ($result) {
				foreach ( $result as $keyword ) {
					$keywords [] = $keyword->name;
					$existing_tags_id [] = $keyword->id;
					$tag_locations_changed_array[] = '(' .$keyword->id. ', ' .$selected_city_id. ', 0, ' .$selected_state_id. ', 0, \'' .$selected_country_iso .'\', 0)';
				}
				$tags = implode ( ', ', $keywords ); // STORE THEM AS A STRING IN COMMA SEPARATED VERSION
				$existing_tags_id_string = implode ( ', ', $existing_tags_id );
			}
			
			// CHECK WHETHER USER UPDATED TAGS OR NOT, IF UPDATED
			if ($tags != $this->input->post ('listings_keywords')) {
				if($result) {
					// DECREMENT EXISTING TAGS COUNT AS THEY WILL BE UPDATED LATER
					$this->db->where('id IN ('.$existing_tags_id_string.')');
					$this->db->set('count', 'count - 1', FALSE);
					$this->db->update('tags');
					
					// DECREMENT TAG COUNT IN TAG_LOCATION TABLE
					$this->tags_model->decrement_tag_locations_count($existing_tags_id_string, $selected_city_id);
				}
				
				// TO REMOVE EXTRA SPACES
				$patterns = array("/\s+/", "/\s([?.!])/");
				$replacer = array(" ","$1");
	
				// TAKE VALUES FROM POST AND SEPARATE THEM
				$ids = explode ( ',', $this->input->post ( 'listings_keywords' ) );
				foreach ( $ids as $id ) {
					$user_entered_tags [] = strtolower(trim(preg_replace( $patterns, $replacer, $id))); //REMOVE WHITE SPACES BEFORE AND AFTER COMMAS
				}
					
				// CREATE STRING OF USER ENTERED TAGS
				$user_entered_tags_array = implode(",", $user_entered_tags);
					
				// ADD QUOTE TO EACH KEYWORD
				$string = "'" . str_replace ( ",", "','", $user_entered_tags_array) . "'";
					
				// REMOVE EXTRA SPACES WITH IN EACH TAG (e.g. PHP  TRAINING)
				$str = preg_replace( $patterns, $replacer, $string);
					
				// TAKE ALL KEYWORDS AND COMPARE THEM WITH DATABASE
				$result = $this->tags_model->find_tags($str);
					
				// STORE EXISTING TAGS IN AN ARRAY FOR COMPARING
				$mysql_exist_rows = array ();
				if($result) {
					foreach ( $result as $keyword ) {
						$mysql_exist_rows [] = $keyword->name;
					}
				}
	
				// COMPARE DATABASE TAGS AND USER ENTERED TAGS
				$new_tags = array_diff ($user_entered_tags, $mysql_exist_rows ); // NEW TAGS
					
				// INSERT NEW TAGS IN DATABASE
				if ($new_tags) {
					foreach ( $new_tags as $tag ) {
						$data_tags['name'] = strtolower($tag);
						$data_tags['count'] = -1; // SET COUNT TO -1 AS THEY ARE NEW ONE
						$insert_query = $this->db->insert_string($this->db->dbprefix . 'tags', $data_tags);
						$insert_query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $insert_query);
						$this->db->query($insert_query);
					}					
				}
					
				// FIND TAG_ID OF ALL USER ENTERED TAGS
				$tag_ids = $this->tags_model->find_tags ( $string );
				foreach ( $tag_ids as $tag_id ) {
					$all_tags [] = $tag_id->id;
				}
					
				if ($all_tags) {
					$tags_to = implode ( ',', $all_tags );
					// INSERT TAGS IN ASSOCIATION TABLE
					$listing_tags = array ();
					$tag_locations_data_array = array(); // TO HANDLE TAG LOCATIONS
					foreach ( $all_tags as $associated_tags ) {
						$listing_tags [] = array (
								'listing_id' => $listing_id,
								'tag_id' => $associated_tags
						);
						$tag_locations_data_array[] = '(' .$associated_tags. ', ' .$selected_city_id. ', 0, ' .$selected_state_id. ', 0, \'' .$selected_country_iso .'\', 0)';
					}		

					// TAG_LOCATIONS INFORMATION
					$tag_locations_data_string = implode(',', $tag_locations_data_array );
					
	
					if ($type == 'insert_listing_tags') {
						$this->tags_model->insert_listing_tags ( $listing_tags );
						// INCREMENT KEYWORDS COUNT BY 1
						$this->db->where('id IN ('.$tags_to.')');
						$this->db->set('count', 'count + 1', FALSE);
						$this->db->update('tags');
						
						// UPDATE TAG LOCATIONS
						$this->tags_model->insert_update_tag_locations ($tag_locations_data_string);
					}
					elseif ($type == 'update_listing_tags') {
						// DELETE ALL EXISTING TAGS AND INSERT THEM								
						$this->tags_model->delete_listing_tags ( $listing_id );
						$this->tags_model->insert_listing_tags ( $listing_tags );	

						// INCREMENT KEYWORDS COUNT BY 1
						$this->db->where('id IN ('.$tags_to.')');
						$this->db->set('count', 'count + 1', FALSE);
						$this->db->update('tags');	
						
						// UPDATE TAG LOCATIONS
						$this->tags_model->insert_update_tag_locations ($tag_locations_data_string);	
					}
				} 
			}	else if (($tags == $this->input->post ('listings_keywords')) && ($selected_city_id != $this->session->userdata('previous_city'))) {
					// TAG_LOCATIONS INFORMATION					
					$tag_locations_changed_string = implode(',', $tag_locations_changed_array );
					$this->tags_model->insert_update_tag_locations ($tag_locations_changed_string);
			}
		}
		else {
			//USER SELECTED TO DELETE ALL EXISTING TAGS
			if ($type == 'update_listing_tags') {
				// DELETE ALL EXISTING TAGS
				$result = $this->tags_model->find_listing_tags ( $listing_id );
				if ($result) {
					foreach ( $result as $keyword ) {
						$existing_tags_id [] = $keyword->id;
					}
					$existing_tags_id_string = implode ( ', ', $existing_tags_id );
					// DECREMENT EXISTING TAGS COUNT AS THEY WILL BE UPDATED LATER
					$this->db->where('id IN ('.$existing_tags_id_string.')');
					$this->db->set('count', 'count - 1', FALSE);
					$this->db->update('tags');
					
					// DECREMENT TAG COUNT IN TAG_LOCATION TABLE
					$this->tags_model->decrement_tag_locations_count($existing_tags_id_string, $this->input->post('listings_city_id'));					
				}
				return $this->tags_model->delete_listing_tags ( $listing_id );
			}
		}		
	}
	
	/**
	 * Deal with listing categories
	 * @param string $type
	 * @param int $listing_id
	 */
	private function listing_categories($type = 'insert_listing_categories', $listing_id) {
		if($this->input->post ('selected_categories')) {
			$selected_categories = $this->input->post ('selected_categories');
			$selected_array = explode(',',$selected_categories);
			$listing_categories = array();
			$listing_categories_data = array();
				
			// REMOVE / FROM EACH STRING AND STORE VALUE IN AN ARRAY
			foreach($selected_array as $selected_value) {
				$listing_categories[] = explode('/',substr($selected_value, 1));
			}
				
			// CONVERT ARRAY INTO INSERT BATCH DATA
			foreach($listing_categories as $listing_category) {
				if(isset($listing_category[1])) { // NO STATE SELECTED
					$sub_id = $listing_category[1];
				} else {
					$sub_id = 0;
				}
				if(isset($listing_category[2])) { // NO CITY SELECTED
					$subsub_id = $listing_category[2];
				} else {
					$subsub_id = 0;
				}
				$listing_categories_data [] = array (
						'listing_id' => $listing_id,
						'parent_id' => $listing_category[0],
						'sub_id' => $sub_id,
						'subsub_id' => $subsub_id
				);
			}
			if ($type == 'insert_listing_categories') {
				$this->db->insert_batch('listing_categories', $listing_categories_data);
			}
			elseif ($type == 'update_listing_categories') {
				// DELETE ALL EXISTING TAGS AND INSERT THEM
				$this->db->where('listing_id', $listing_id)->delete('listing_categories');
				$this->db->insert_batch('listing_categories', $listing_categories_data);
			}
		}
		else if($this->input->post('on_post_selected_categories')) {
			//NO CATEGORY SELECTED
			if ($type == 'update_listing_categories') {
				// DELETE ALL EXISTING TAGS
				$this->listings_model->delete_listing_categories ( $listing_id );
			}
		}
	}
	
	/**
	 * Spam a listing
	 * @param int    $listing_id     Listing to ban
	 * @return void
	 */
	private function _spam($listing_id) {
		$this->listings_model->update_listing($listing_id, array('spammed' => 1));	
	}//end _spam()
	
	/**
	 * Unspam a listing
	 * @param int    $listing_id     Listing to ban
	 * @return void
	 */
	private function _unspam($listing_id) {
		$this->listings_model->update_listing($listing_id, array('spammed' => 0));
	}//end _spam()
	
	/**
	 * Delete listings
	 * @access private
	 * @param int $id Listing to delete
	 * @return void
	 */
	private function _delete($id) {
		$result = $this->listings_model->delete($id);	
		return $result;	
	}//end _delete()
	
	/**
	 * Purge the selected listings which are already marked as deleted
	 * @access private
	 * @param int $id Listing to purge
	 * @return void
	 */
	private function _purge($id)
	{
		$this->listings_model->delete($id, TRUE);
		Template::set_message(lang('action_purged'), 'success');
	
		// Purge any product information for this listing, also.
		$this->db->where('listing_id', $id)->delete('products');
		
		// Purge any image or video for this listing, also.
		$this->db->where('listing_id', $id)->delete('images');
		
		// Purge any products or services for this listing, also.
		$this->db->where('listing_id', $id)->delete('videos');
		
		// Purge any classifieds for this listing, also.
		$this->db->where('listing_id', $id)->delete('classifieds');
		
		// Purge any business hours for this listing, also.
		$this->db->where('listing_id', $id)->delete('business_hours');
		
		// Purge any tags association for this listing, also.
		$this->db->where('listing_id', $id)->delete('listing_tags');
		
		// Purge any ratings assoced with listing, also.
		$this->db->where('listing_id', $id)->delete('ratings');
		
		// Purge any comments assoced with listing, also.
		$this->db->where('listing_id', $id)->delete('comments');
	
		// Any modules needing to save data?
		Events::trigger('purge_listing', $id);
	}//end _purge()
	
	/**
	 * Restore the deleted listing	 *
	 * @return void
	 */
	private function _restore($id)
	{
		if ($this->listings_model->update_listing($id, array('deleted'=>0))) {
			Template::set_message(lang('restored_success'), 'success');
		} else {
			Template::set_message(lang('restored_error'). $this->listings_model->error, 'error');
		}
	
	}//end restore()

	//--------------------------------------------------------------------
	// ACTIVATION METHODS
	//--------------------------------------------------------------------
	/**
	 * Activates selected listings.
	 * @access private
	 * @param int $listing_id
	 * @return void
	 */
	private function _activate($listing_id)
	{
		$this->listing_status($listing_id,1,0);
	
	}//end _activate()

	/**
	 * Deactivates selected listing.
	 * @access private
	 * @param int $listing_id
	 * @return void
	 */
	private function _deactivate($listing_id)
	{
		$this->listing_status($listing_id,0,0);
	
	}//end _deactivate()
	
	
	/**
	 * Activates or deavtivates listing from the listing dashboard.	 *
	 * @access private
	 *
	 * @param int $listing_id       Listing ID int
	 * @param int $status        1 = Activate, -1 = Deactivate
	 * @param int $supress_email 1 = Supress, All others = send email
	 *
	 * @return void
	 */
	private function listing_status($listing_id = false, $status = 1, $supress_email = 0)
	{
		$supress_email = (isset($supress_email) && $supress_email == 1 ? true : false);
	
		if ($listing_id !== false && $listing_id != -1)
		{
			$result = false;
			$type = '';
			if ($status == 1) {
				$result = $this->listings_model->listing_activation($listing_id);
				$type = lang('bf_action_activate');
			} else {
				$result = $this->listings_model->listing_deactivation($listing_id);
				$type = lang('bf_action_deactivate');
			}
	
			$listing = $this->listings_model->find($listing_id);
			//$log_name = $this->settings_lib->item('auth.use_own_names') ? $this->current_user->username : ($this->settings_lib->item('auth.use_usernames') ? $listing->username : $listing->email);
	
			//log_activity($this->current_user->id, lang('us_log_status_change') . ': '.$log_name . ' : '.$type."ed", 'users');
	/*
			if ($result)
			{
				$message = lang('us_active_status_changed');
				if ($status == 1 && !$supress_email)
				{
					// Now send the email
					$this->load->library('emailer/emailer');
	
					$site_title = $this->settings_lib->item('site.title');
	
					$data = array
					(
							'to'		=> $this->listing_model->find($listing_id)->email,
							'subject'	=> lang('us_account_active'),
							'message'	=> $this->load->view('_emails/activated', array('link'=>site_url(),'title'=>$site_title), true)
					);
	
					if ($this->emailer->send($data))
					{
						$message = lang('us_active_email_sent');
					}
					else
					{
						$message=lang('us_err_no_email'). $this->emailer->error;
					}
				}
				Template::set_message($message, 'success');
			}
			else
			{
				Template::set_message(lang('us_err_status_error').$this->listing_model->error,'error');
			}//end if*/
		}
		else
		{
			Template::set_message(lang('ls_err_no_id'),'error');
		}//end if
	
	}//end listing_status()
	
	
	/*----------------------------------------------------*/
	/*	Upload Logo File
	/*----------------------------------------------------*/
	public function logo() {
		$id = $this->uri->segment(5); //Get listing ID
		$data = array();
		if (isset($_POST['submit'])){
			//Check whether image is uploaded or not
			if(isset($_FILES['listings_logo']) && $_FILES['listings_logo']['size'] > 0){
				$file_data = $this->upload_logo_file();
				$data['logo_url'] = $file_data['upload_data']['file_name'];
			} else {
				$data['logo_url'] = $this->input->post('listings_logo');
			}
			
			$this->listings_model->update_listing($id, $data);
			$message = lang('ls_logo_upload_success'); //Set success message
			Template::set_message($message, 'success');
		}	
		
		//Display logo to the user
		$this->listings_model->select('logo_url, title');
		$records = $this->listings_model->find_by(array('id' => $id));
		Template::set('logo', $records->logo_url);
		Template::set('title', $records->title);
		
		Template::set('toolbar_title', lang('listings_action_logo'));
		Template::render();
	}
	
	/**
	 * Save uploaded image
	 * @return multitype:NULL
	 */
	private function upload_logo_file(){
	
		$config['upload_path'] = realpath(FCPATH.'assets/images/logo/'); //Make SURE that you chmod this directory to 777!
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']='100';
		$config['max_width']='1024';
		$config['max_height']='768';
		$config['remove_spaces']=TRUE; //Remove spaces from the file name
	
		$this->load->library('upload', $config);
	
		if (!$this->upload->do_upload('listings_logo')) // Image name is necessary
		{
			Template::set_message($this->upload->display_errors(), 'error'); // Show errors to the user
			$id = $this->uri->segment(5);
			redirect(SITE_AREA .'/content/listings/logo/'. $id);	
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$this->resize($data['upload_data']['full_path'],$data['upload_data']['file_name']);
		}
		return $data;
	}
	
	/**
	 * Create thumbs of uploaded image
	 */
	public function resize($path,$file){
		$config['image_library']='gd2';
		$config['source_image']=$path;
		$config['create_thumb']=TRUE; // This will create new file
		$config['maintain_ratio']=TRUE;
		$config['width']=120;
		$config['height']=120;
		$config['new_image']='./assets/images/logo/thumbs/'.$file; //CHANGE THIS LINE FOR PATH
	
		$this->load->library('image_lib',$config);
		$this->image_lib->resize();
	}
	
	/*----------------------------------------------------*/
	/*	Products Module
	/*----------------------------------------------------*/
	
	/**
	 * Display all listing related products to the admin
	 * @param string $listing_id
	 */
	public function products($listing_id = NULL)
	{
		$this->load->model('products_model');
		if(!isset($listing_id) || $listing_id == NULL) {
			Template::redirect(SITE_AREA .'/content/listings');
		}
		else {
			// Deleting anything?
			if (isset($_POST['delete'])) {
				$checked = $this->input->post('checked');
	
				if (is_array($checked) && count($checked)) {
					$result = FALSE;
					foreach ($checked as $pid) {
						$result = $this->products_model->delete_where(array('listing_id' => $listing_id, 'id' => $pid));
					}
	
					if ($result) {
						Template::set_message(count($checked) .' '. lang('delete_success'), 'success');
					}
					else {
						Template::set_message(lang('delete_failure') . $this->products_model->error, 'error');
					}
				}
			}
	
	
			$records = $this->products_model->find_all_by(array('listing_id' => $listing_id));
	
			$listing_id = $this->uri->segment(5);
			$this->session->set_flashdata('listing_id', $listing_id); //Set session data for change status
			Template::set('listing_id', $listing_id);
			Template::set('records', $records);
			Template::set('toolbar_title', 'Manage Products');
			Template::render();
		}
	}
	
	/**
	 * Allow admin to add product to listing
	 */
	public function add_product()
	{
		$this->load->model('products_model');
		$this->auth->restrict('Listings.Content.Create');
	
		$listing_id = $this->uri->segment(5);
	
		if (empty($listing_id)) {
			Template::set_message(lang('invalid_id'), 'error');
			redirect(SITE_AREA .'/content/listings/');
		}
	
		if (isset($_POST['save'])) {
			if ($insert_id = $this->save_products())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'products');
	
				Template::set_message(lang('create_success'), 'success');
				redirect(SITE_AREA .'/content/listings/products/' .$listing_id);
			}
			else {
				Template::set_message(lang('create_failure') . $this->products_model->error, 'error');
			}
		}
		Assets::add_module_js('products', 'products.js');
		Template::set('listing_id', $listing_id);
		Template::set('toolbar_title', lang('add') . ' Products');
		Template::set_view('content/products_form');
		Template::render();
	}
	
	/**
	 * Allow admin to edit existing product
	 */
	public function edit_product()
	{
		$this->load->model('products_model');
		$id = $this->uri->segment(5);
	
		if (empty($id)) {
			Template::set_message(lang('invalid_id'), 'error');
			redirect(SITE_AREA .'/content/listings/');
		}
		//GET LISTING ID OF EDITED PRODUCT OTHERWISE TOOLBAR MENU WOULD NOT WORK
		$this->db->select('listing_id');
		$listing_id = $this->products_model->find($id);
	
		if (isset($_POST['save']))
		{
			$this->auth->restrict('Listings.Content.Edit');
	
			if ($this->save_products('update', $id)) {
				// Log the activity
				log_activity($this->current_user->id, lang('act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'products');
	
				Template::set_message(lang('edit_success'), 'success');
			}
			else {
				Template::set_message(lang('edit_failure') . $this->products_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Listings.Content.Delete');
	
			if ($this->products_model->delete($id)) {
				// Log the activity
				log_activity($this->current_user->id, lang('act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'products');
	
				Template::set_message(lang('delete_success'), 'success');
	
				redirect(SITE_AREA .'/content/listings/products/' .$listing_id->listing_id);
			} else {
				Template::set_message(lang('delete_failure') . $this->products_model->error, 'error');
			}
		}
	
		$this->session->set_flashdata('listing_id', $listing_id->listing_id);
		Template::set('listing_id', $listing_id->listing_id);
	
		Template::set('products', $this->products_model->find($id));
		Template::set('toolbar_title', lang('edit') .' Products');
		Template::set_view('content/products_form');
		Template::render();
	}
	
	/**
	 * Allow admin to save product information
	 * @param string $type
	 * @param number $id
	 * @return number
	 */
	private function save_products($type='insert', $id=0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}
		$data = array();
		$data['listing_id']  = $this->input->post('products_listing_id');
		$data['title']       = $this->input->post('products_title');
		$data['type']        = $this->input->post('products_type');
		$data['price']        = $this->input->post('products_price');
		
		$this->form_validation->set_rules('uploaded_image', 'lang:label_image', 'trim');
		//Check whether image is uploaded or not
		if(isset($_FILES['image']) && $_FILES['image']['size'] > 0){
			$file_data = $this->listings_model->upload_image('products', 'image');
			if(!$file_data) {
				$_POST['file_upload'] = 'NONE';
				$this->form_validation->set_rules('file_upload', 'label:label_image', 'valid_file_upload');
			}
			// Avoid image upload process, if the form has validation issues with other fields
			$_POST['uploaded_image'] = $file_data['upload_data']['file_name'];
		}
		
		$data['image'] = $_POST['uploaded_image'];
		if ($this->form_validation->run() === false) {
			return false;
		}
	
		$data['description'] = $this->input->post('products_description');
	
		if ($type == 'insert') {	
			$id = $this->products_model->insert($data);	
			if (is_numeric($id)) {
				$return = $id;
			} else {
				$return = FALSE;
			}
		} elseif ($type == 'update') {
			$return = $this->products_model->update($id, $data);
		}
	
		return $return;
	}
	
	/*----------------------------------------------------*/
	/*	Upload Photos Module
	/*----------------------------------------------------*/
	
	/**
	 * Image_CRUD 0.6 is used to upload images
	 */
	public function photos() {
		
		//$path = realpath(FCPATH.'assets/uploads/');
		$image_crud = new image_CRUD();
		$image_crud->set_primary_key_field('id');
		$image_crud->set_url_field('url');
		$image_crud->set_title_field('title');
		
		$image_crud->set_active_field('active');
		$image_crud->active_field_value(1);
		$image_crud->user_limit(500);
		$image_crud->images_count(0);
		$image_crud->user_role($this->session->userdata('role_id'));
		
		$image_crud->set_table('images')
		->set_relation_field('listing_id')
		->set_ordering_field('priority')
		->set_image_path('assets/images/photos'); // CHANGE THIS FOR PATH
	
		$output = $image_crud->render();
	
		Assets::add_css($output->css_files);
		Assets::add_js($output->js_files);
		Template::set('output', $output->output);
	
		Template::set('toolbar_title', 'Upload Images');
		Template::render();
	}
	
	/*----------------------------------------------------*/
	/*	Video Module
	/*----------------------------------------------------*/

	/**
	 * Display all listing related videos to admin
	 * @param string $listing_id
	 */
	public function videos($listing_id = NULL, $id = NULL)
	{
		if(!isset($listing_id) || $listing_id == NULL) {
			Template::redirect(SITE_AREA .'/content/listings');
		} else {
		$this->load->model('videos_model'); //Display information using videos model
		
		// Deleting anything?
		if (isset($_POST['delete'])) {
			$checked = $this->input->post('checked');
	
			if (is_array($checked) && count($checked)) {
				$result = FALSE;
				foreach ($checked as $pid) {
					$result = $this->videos_model->delete($pid);
				}
	
				if ($result) {
					Template::set_message(count($checked) .' '. lang('delete_success'), 'success');
					Template::redirect(SITE_AREA .'/content/listings/videos/' . $listing_id);
				} else {
					Template::set_message(lang('delete_failure') . $this->videos_model->error, 'error');
				}
			}
		}
		if (isset($_POST['save'])) {
			if($id == NULL) {
				if ($insert_id = $this->save_videos()) {
					// Log the activity
					log_activity($this->current_user->id, lang('act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'videos');
				
					Template::set_message(lang('create_success'), 'success');
					Template::redirect(SITE_AREA .'/content/listings/videos/' . $listing_id);
				} else {
					Template::set_message(lang('create_failure') . $this->videos_model->error, 'error');
				}
			} else {
				$this->auth->restrict('Listings.Content.Edit');
			
				if ($this->save_videos('update', $id)) {
					// Log the activity
					log_activity($this->current_user->id, lang('act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'videos');
			
					Template::set_message(lang('edit_success'), 'success');
					Template::redirect(SITE_AREA .'/content/listings/videos/' . $listing_id);
				} else {
					Template::set_message(lang('edit_failure') . $this->videos_model->error, 'error');
				}
			}
		}
	
		$records = $this->videos_model->where('listing_id', $listing_id)->find_all();
	
		Template::set('listing_id', $listing_id);
		Template::set('videos', $this->videos_model->find($id));
		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Videos');
		Template::render();
		}
	}
	
	/**
	 * Save video information
	 * @param string $type
	 * @param number $id
	 * @return number
	 */
	private function save_videos($type='insert', $id=0)
	{
		$this->load->model('videos_model');
		if ($type == 'update') {
			$_POST['id'] = $id;
		}
	
		$data = array();
		$data['listing_id'] = $this->input->post('listing_id');		
		$data['url']        = $this->get_video_id($this->input->post('videos_url')); //Return video id
		if($this->input->post('videos_title')) { //Retrieve title from youtube and save in database
			$data['title']  = $this->input->post('videos_title');
		} else {
			$data['title'] 	= '' .$this->get_video_title($data['url']) .'';
		}
		$data['active']	= 1;
	
		if ($type == 'insert') {
			$id = $this->videos_model->insert($data);	
			if (is_numeric($id)) {
				$return = $id;
			} else {
				$return = FALSE;
			}
		}
		elseif ($type == 'update') {
			$return = $this->videos_model->update($id, $data);
		}	
		return $return;
	}
	
	/**
	 * Get Youtube Video Title
	 * @return video title
	 */
	private function get_video_title($video_id) {
		$content = file_get_contents("https://youtube.com/get_video_info?video_id=" .$video_id);
		parse_str($content, $ytarr);
		if(!empty($ytarr['title'])) {
			return $ytarr['title'];
		} else {
			return null;
		}
	}
	
	/**
	 * Get youtube video ID
	 * @param string $url
	 * @return string
	 */
	private function get_video_id($url) {
		// http://stackoverflow.com/questions/3452546/javascript-regex-how-to-get-youtube-video-id-from-url
		$regex = '/^.*(?:(?:youtu\.be\/|v\/|vi\/|u\/\w\/|embed\/)|(?:(?:watch)?\?v(?:i)?=|\&v(?:i)?=))([^#\&\?]*).*/';
		if(preg_match($regex, $url, $match)) {
			return $match[1];
		} else {
			return false;
		}	
	}
	
	/*----------------------------------------------------*/
	/*	Classified Module
	/*----------------------------------------------------*/
	
	/**
	 * Display listing related classifieds to admin
	 * @param string $listing_id
	 */
	public function classifieds($listing_id = NULL)
	{
		$this->load->model('classifieds_model');
		if(!isset($listing_id) || $listing_id == NULL) {
			Template::redirect(SITE_AREA .'/content/listings');
		} else {	
			// Deleting anything?
			if (isset($_POST['delete'])) {
				$checked = $this->input->post('checked');
				if (is_array($checked) && count($checked)) {
					$result = FALSE;
					foreach ($checked as $pid) {
						$result = $this->classifieds_model->delete_where(array('listing_id' => $listing_id, 'id' => $pid));
					}
	
					if ($result) {
						Template::set_message(count($checked) .' '. lang('delete_success'), 'success');
					} else {
						Template::set_message(lang('delete_failure') . $this->classifieds_model->error, 'error');
					}
				}
			}
	
			$records = $this->classifieds_model->find_all_by(array('listing_id' => $listing_id));
				
			$listing_id = $this->uri->segment(5);
			$this->session->set_flashdata('listing_id', $listing_id); //Set session data for change status
			Template::set('listing_id', $listing_id);
	
			Template::set('records', $records);
			Template::set('toolbar_title', 'Manage Classifieds');
			Template::render();
		}
	}
	
	/**
	 * Allow admin to add new classified to listing
	 */
	public function add_classified()
	{
		$this->load->model('classifieds_model');
		$this->auth->restrict('Listings.Content.Create');
		$listing_id = $this->uri->segment(5);
	
		if (empty($listing_id))	{
			Template::set_message(lang('invalid_id'), 'error');
			redirect(SITE_AREA .'/content/listings');
		}
	
		if (isset($_POST['save'])) {
			if ($insert_id = $this->save_classifieds()) {
				// Log the activity
				log_activity($this->current_user->id, lang('act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'classifieds');
	
				Template::set_message(lang('create_success'), 'success');
				redirect(SITE_AREA .'/content/listings/classifieds/' .$listing_id);
			} else {
				Template::set_message(lang('create_failure') . $this->classifieds_model->error, 'error');
			}
		}
		Template::set('listing_id', $listing_id);
		Template::set('toolbar_title', lang('add') . ' Classified');
		Template::set_view('content/classifieds_form');
		Template::render();
	}
	
	/**
	 * Allow admin to edit existing classified information
	 */
	public function edit_classified()
	{
		$this->load->model('classifieds_model');
		$id = $this->uri->segment(5);
		if (empty($id)) {
			Template::set_message(lang('invalid_id'), 'error');
			redirect(SITE_AREA .'/content/listings/classifieds/' .$listing_id);
		}
	
		//GET LISTING ID OF EDITED PRODUCT OTHERWISE TOOLBAR MENU WOULD NOT WORK
		$this->db->select('listing_id');
		$listing_id = $this->classifieds_model->find($id);
		$this->session->set_flashdata('listing_id', $listing_id->listing_id);
		
		if (isset($_POST['save'])) {
			$this->auth->restrict('Listings.Content.Edit');
			if ($this->save_classifieds('update', $id)) {
				// Log the activity
				log_activity($this->current_user->id, lang('act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'classifieds');
	
				Template::set_message(lang('edit_success'), 'success');
			} else {
				Template::set_message(lang('edit_failure') . $this->classifieds_model->error, 'error');
			}
		}
		else if (isset($_POST['delete'])) {
			$this->auth->restrict('Listings.Content.Delete');
	
			if ($this->classifieds_model->delete($id)) {
				// Log the activity
				log_activity($this->current_user->id, lang('act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'classifieds');
	
				Template::set_message(lang('delete_success'), 'success');
	
				redirect(SITE_AREA .'/content/listings/classifieds/' .$this->session->flashdata('listing_id'));
			} else {
				Template::set_message(lang('delete_failure') . $this->classifieds_model->error, 'error');
			}
		}

		Template::set('listing_id', $listing_id->listing_id);

		Template::set('classifieds', $this->classifieds_model->find($id));
		Template::set('toolbar_title', lang('edit') .' Classifieds');
		Template::set_view('content/classifieds_form');
		Template::render();
	}

	/**
	 * Save classified information
	 * @param string $type
	 * @param number $id
	 * @return number
	 */
	private function save_classifieds($type='insert', $id=0)
	{
		$this->load->model('classifieds_model');
		if ($type == 'update') {
			$_POST['id'] = $id;
		}

		$data = array();
		
		$data['listing_id']  = $this->input->post('listing_id');
		$data['title']  = $this->input->post('classifieds_title');
	
		$this->form_validation->set_rules('uploaded_image', 'lang:label_image', 'trim');
		//Check whether image is uploaded or not
		if(isset($_FILES['image']) && $_FILES['image']['size'] > 0){
			$file_data = $this->listings_model->upload_image('classifieds', 'image');
			if(!$file_data) {
				$_POST['file_upload'] = 'NONE';
				$this->form_validation->set_rules('file_upload', 'label:label_image', 'valid_file_upload');
			}
			// Avoid image upload process, if the form has validation issues with other fields
			$_POST['uploaded_image'] = $file_data['upload_data']['file_name'];
		}
		
		$data['image'] = $_POST['uploaded_image'];
		if ($this->form_validation->run() === false) {
			return false;
		}
	
		$data['from']        = $this->input->post('classifieds_from') ? $this->input->post('classifieds_from') : '0000-00-00 00:00:00';
		$data['to']        = $this->input->post('classifieds_to') ? $this->input->post('classifieds_to') : '0000-00-00 00:00:00';
	
		$data['price']  = $this->input->post('classifieds_price');
		$data['url']  = $this->input->post('classifieds_link');
		$data['description']  = $this->input->post('classifieds_description');
		if ($type == 'insert') {
			$id = $this->classifieds_model->insert($data);
	
			if (is_numeric($id)) {
				$return = $id;
			} else {
				$return = FALSE;
			}
		} elseif ($type == 'update') {
			$return = $this->classifieds_model->update($id, $data);
		}
	
		return $return;
	}
	
	/**
	 * Common upload image function for product and classified
	 * @param string $upload_path
	 * @param string $field_name
	 * @param string $type
	 * @return multitype:NULL
	 */
	private function upload_image($upload_path, $field_name, $type){
		$config['upload_path'] = realpath(FCPATH.'/assets/images/'. $upload_path .'/'); //Make SURE that you chmod this directory to 777!
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']= settings_item('lst.image_file_size');
		$config['max_width']=settings_item('lst.image_width');
		$config['max_height']=settings_item('lst.image_height');
		$config['remove_spaces']=TRUE; //Remove spaces from the file name
		$this->load->library('upload', $config);
	
		if (!$this->upload->do_upload($field_name)) // Image name is necessary
		{
			Template::set_message($this->upload->display_errors(), 'error'); // Show errors to the user
	
			//FIND WHETHER UPLOAD REQUEST IS MADE FROM EDIT PAGE OR CREATE PAGE
			$request=$this->uri->segment(4);
			if($request == 'edit') {
				$id=$this->uri->segment(5);
				redirect(SITE_AREA .'/content/listings/edit_'. $type .'/' .$id); //Request is from edit page
			} else {
				$id=$this->uri->segment(5);
				redirect(SITE_AREA .'/content/listings/add_' . $type .'/' .$id); //Request is from create page
			}	
		} else {
			$data = array('upload_data' => $this->upload->data());
			//RESIZE IMAGE USING resize FUNCTION
			$this->resize_image($data['upload_data']['full_path'],$upload_path,$data['upload_data']['file_name']);
		}
		return $data;
	}
	
	/**
	 * Create thumbnails of uploaded image
	 * @param unknown $path
	 * @param unknown $upload_path
	 * @param unknown $file
	 */
	function resize_image($path,$upload_path,$file){
		$config['image_library']='gd2';
		$config['source_image']=$path;
		$config['create_thumb']=TRUE;
		$config['maintain_ratio']=TRUE;
		$config['width']=150;
		$config['height']=75;
		$config['new_image']='./assets/images/' . $upload_path . '/'.$file;
	
		$this->load->library('image_lib',$config);
		$this->image_lib->resize();
	}
	
	/*----------------------------------------------------*/
	/*	Business Hours Module
	/*----------------------------------------------------*/
	
	/**
	 * Display business hours form to the user
	 * @param number $listing_id
	 */
	public function business_hours($listing_id = NULL) {
	
		if(!isset($listing_id) || $listing_id == NULL) {
			Template::redirect(SITE_AREA .'/content/listings');
		} else {
			$this->load->model('business_hours_model');
			// CHECK WHETHER BUSINESS HOURS ALREADY EXIST
	
			// FIND WHETHER BUSINESS HOURS WITH LISTING_ID EXIST OR NOT
			$this->db->select ( 'listing_id' );
			$list_id = $this->business_hours_model->where ( array (
					'listing_id' => $listing_id
			) )->count_all ();
	
			if (isset ( $_POST ['save'] )) {
				// NO BUSINESSS HOURS EXIST INSERT THEM
				if ($list_id == 0) {
					$this->auth->restrict ( 'Listings.Content.Create' );
	
					if ($insert_id = $this->save_business_hours ()) {
						// Log the activity
						log_activity ( $this->current_user->id, lang ( 'act_create_record' ) . ': ' . $insert_id . ' : ' . $this->input->ip_address (), 'business_hours' );
							
						Template::set_message ( lang ( 'create_success' ), 'success' );
						redirect ( SITE_AREA . '/content/listings/business_hours/' . $listing_id );
					} else {
						Template::set_message ( lang ( 'create_failure' ) . $this->business_hours_model->error, 'error' );
					}
				}
				// BUSINESS HOURS EXIST UPDATE THEM
				else {
	
					$this->auth->restrict ( 'Listings.Content.Edit' );
	
					if (! empty ( $_POST ['business_hours_day_of_week'] )) 				// IF NOTHING IS SELECTED DON'T THROW ERRORS
					{
						if ($this->save_business_hours ( 'update' )) { // PERFORM UPDATE OPERATION
							// Log the activity
							log_activity ( $this->current_user->id, lang ( 'act_edit_record' ) . ': ' . $this->input->ip_address (), 'business_hours' );
	
							Template::set_message ( lang ( 'edit_success' ), 'success' );
						} else {
							Template::set_message ( lang ( 'edit_failure' ) . $this->business_hours_model->error, 'error' );
						}
					}
				}
					
					
				// DELETE PARTICULAR RECORD WHEN CHECKBOX UNSELECTED
				if (! empty ( $_POST ['business_hours_day_of_week'] )) { //CHECK WHETHER IS THIS THE LAST ENTRY IF NOT PERFORM BELOW OPERATION ELSE MOVE
					// DELETE ALL ENTRIES NOT SELECTED BY THE USER
					$this->db->select ( 'id' );
					// IMPLODE FUNCTION TO DEAL WITH ARRAY VALUES
					$where = "listing_id = " . $listing_id . " AND day_of_week NOT IN (" . implode ( ",", $_POST ['business_hours_day_of_week'] ) . ")";
					$result = $this->business_hours_model->find_all_by ( $where );
	
					if ($result) {
						// STORE OBJECT INTO ARRAYS OTHERWISE VALUE WILL NOT BE DELETED
						foreach ( $result as $set_deleted ) {
							$to_be_deleted [] = $set_deleted->id;
						}
							
						// USE OF IMPLODE AND USE OF DELETE_WHERE FUNCTION TO DELETE MULTIPLE VALUES
						$where = "id IN (" . implode ( ",", $to_be_deleted ) . ")";
						$this->business_hours_model->delete_where ( $where );
					}
				}
				//LAST OR ALL ENTRIES DELETE REQUESTED BY THE USER
				else {
					//DELETE ALL RECORDS WHERE LISTING_ID IS SELECTED
					$this->business_hours_model->delete_where ( array (
							'listing_id' => $listing_id
					) );
				}
			}
	
			$records = $this->business_hours_model->where ( 'listing_id', $listing_id )->find_all ();
	
			Template::set ( 'listing_id', $listing_id );
			Template::set ( 'records', $records );
			Template::set ( 'toolbar_title', 'Manage Business Hours' );
			Template::render ();
		}
	}
	
	/**
	 * Save business hours information
	 * @param string $type
	 * @param number $id
	 * @return Ambigous <boolean, number>
	 */
	private function save_business_hours($type = 'insert', $id = 0) {
		$this->load->model('business_hours_model');
		if ($type == 'update') {
			$_POST ['id'] = $id;
		}
		$return = NULL;
		$data = array ();
		//DON'T DISPLAY ERRORS IF USER SUBMIT BLANK FORM
		if (! empty ( $_POST ['business_hours_day_of_week'] )) {
			foreach ( $_POST ['business_hours_day_of_week'] as $textbox ) {
				$data ['listing_id'] = $_POST ['listing_id'];
				$data ['day_of_week'] = $textbox;
					
				//IF CHECKBOX IS SELECTED SET VALIDATION RULES FOR CORRESPONDING INPUT TEXT BOX
				$this->form_validation->set_rules('open_time_' . $textbox, 'From', 'trim|required');
				$this->form_validation->set_rules('close_time_' . $textbox, 'To', 'trim|required');
				// Process the form
				if ($this->form_validation->run() == TRUE) {
					$data ['open_time'] = $_POST ['open_time_' . $textbox];
					$data ['close_time'] = $_POST ['close_time_' . $textbox];
						
					// ID OF BUSINESS HOURS TO BE UPDATED
					$this->db->select ( 'id' );
					$id = $this->business_hours_model->find_by ( array (
							'listing_id' => $data ['listing_id'],
							'day_of_week' => $data ['day_of_week']
					) );
						
					if ($type == 'insert') {
						$id = $this->business_hours_model->insert ( $data );
	
						if (is_numeric ( $id )) {
							$return = $id;
						} else {
							$return = FALSE;
						}
					} elseif ($type == 'update') {
						// CHECK WHETHER WEEK DAY EXIST OR NOT IN THE DATABASE
						if (! isset ( $id->id )) {
							$this->business_hours_model->insert ( $data ); // WEEK DAY DOES NOT EXIST
						}
	
						// PERFORM UPDATE OPERATION
						else {
							$return = $this->business_hours_model->update ( $id->id, $data );
						}
					}
				}
			}
			return $return;
		}
	}

	/**
	 * Change status of page from index page
	 * @param int $id
	 */
	public function change_status($type, $listing_id, $id)
	{
		//Return old status
		$this->db->select ( 'active' );
		$this->db->where('id', $id);
		$query = $this->db->get ( $type );
	
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
		$this->db->update($type, $data);
		redirect(site_url(SITE_AREA .'/content/listings/'.$type.'/'.$listing_id));
	}
	
	/**
	 * Update categories level in order to achieve multilevel categories functionality
	 */
	public function update_categories_level () {
		$listing_from = $this->input->post('listing_id_from');
		$listing_to = $this->input->post('listing_id_to');
		if (isset($_POST['save'])) {
		$this->form_validation->set_rules('listing_id_from', lang('label_listing_ids'), 'required|integer|min_val[1]');
		$this->form_validation->set_rules('listing_id_to', lang('label_listing_ids'), 'required|integer|max_val[10000000]|compare_fields['.$this->input->post('listing_id_from').']|diff_between['.$this->input->post('listing_id_from').',50000]');
		if($this->form_validation->run() == TRUE) {
			// STEP 1: Get records from categories table in hierarichal order and fill categories_level table
			$fill_categories_level_sql = "INSERT INTO " . $this->db->dbprefix . "categories_level (SELECT PARENT.id AS parent_id, CASE WHEN SUB.sub_id IS NULL THEN 0 ELSE SUB.sub_id END, CASE WHEN SUBSUB.subsub_id IS NULL THEN 0 ELSE SUBSUB.subsub_id END FROM " . $this->db->dbprefix . "categories AS PARENT";
			$fill_categories_level_sql .= " LEFT JOIN (SELECT id AS sub_id, parent_id FROM " . $this->db->dbprefix . "categories) SUB ON PARENT.id = SUB.parent_id AND SUB.parent_id != 0";
			$fill_categories_level_sql .= " LEFT JOIN (SELECT id AS subsub_id, parent_id FROM " . $this->db->dbprefix . "categories) SUBSUB ON SUB.sub_id = SUBSUB.parent_id WHERE PARENT.parent_id = 0)";
			$this->db->simple_query($fill_categories_level_sql);
			
			// STEP 2: Fill listing_categories table
			$sql = "SELECT L.id, L.category_id FROM " . $this->db->dbprefix . "listings L WHERE (L.id BETWEEN ".$listing_from." AND ".$listing_to.") AND L.category_id != 0 AND L.id NOT IN (SELECT listing_id FROM " . $this->db->dbprefix . "listings_categories WHERE (listing_id BETWEEN ".$listing_from." AND ".$listing_to.")) LIMIT 50000";
			$query = $this->db->query ( $sql );
			if($query->result_array()) {
				foreach ( $query->result_array() as $listing ) {
					$category_sql = "SELECT * FROM " . $this->db->dbprefix . "categories_level WHERE parent_id = ".$listing['category_id']." OR sub_id = ".$listing['category_id']." OR subsub_id = ".$listing['category_id'];
					$category_query = $this->db->query ( $category_sql );
					if($category_query->result_array()) {
						foreach ( $category_query->result_array() as $category ) {
							if($category['parent_id'] == $listing['category_id']) {
								$parent_id = $listing['category_id'];
								$sub_id = 0;
								$subsub_id = 0;
							} else if($category['sub_id'] == $listing['category_id']) {
								$parent_id = $category['parent_id'];
								$sub_id = $category['sub_id'];
								$subsub_id = 0;
							} else if($category['subsub_id'] == $listing['category_id']) {
								$parent_id = $category['parent_id'];
								$sub_id = $category['sub_id'];
								$subsub_id = $category['subsub_id'];
							}
						}
						$data['listing_id'] =  $listing['id'];
						$data['parent_id'] = $parent_id;
						$data['sub_id'] = $sub_id;
						$data['subsub_id'] = $subsub_id;
					}
					if(isset($data)) {
						$this->db->insert('listing_categories', $data);
					}
					unset($data);
					}
				}
			}
		}		
	}
}