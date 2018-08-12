<?php if (! defined ( 'BASEPATH' ))exit ( 'No direct script access allowed' );
 
 
 
 
 
 
 
 
 
 
 
 

class Members extends Front_Controller {	
	/**
	 * Constructor
	 *
	 * @return void
	 */
	public $listing_permission;
	public function __construct() {
		parent::__construct ();
		
		$this->load->library ( 'form_validation' );
		//CREATE SLUG
		$config = array(
				'field' => 'slug',
				'title' => 'name',
				'table' => 'listings',
				'id' => 'id',
		);
		$this->load->library('slug', $config);
		$this->load->library('encrypt');
		//LOAD ALL MODELS FOR FILTERING AND OTHER OPERATIONS
		$this->load->model('listings/listings_model');
		$this->load->library('users/auth');
		$this->load->model('listings/products_model');
		$this->load->model('listings/videos_model');
		$this->load->model('listings/classifieds_model');
		$this->load->model('listings/business_hours_model');
		$this->load->model('roles/role_model');
		$this->load->model('categories/categories_model');
		$this->load->model('locations/countries_model');
		$this->load->model('tags/tags_model');
		$this->load->model('listings/business_queries_model');
		$this->load->model('comments/comments_model');
		$this->load->model('transactions/transactions_model');
		$this->load->model('packages/packages_model');
		$this->load->model('emailer/emailer_model');
		
		//user authentication library
		Assets::add_js(array(
		'js/editors/tinymce/tinymce.min.js',
		));
				
		$queries_count = $this->business_queries_model->count_business_queries($this->auth->user_id());
		$comments_count = $this->comments_model->count_listing_comments($this->auth->user_id());
		$transactions_count = $this->transactions_model->count_by(array('user_id' => $this->auth->user_id()));
		$admin_messages = $this->emailer_model->select('subject, message_text')->order_by('id', 'desc')->limit(10)->find_all_by(array('user_id' => $this->auth->user_id()));
		$users_info = $this->user_model->select('display_name, last_login, last_ip')->find($this->auth->user_id());
		Template::set (array(
			'total_comments'	=> $comments_count,
			'total_business_queries'=> $queries_count,
			'total_transactions'	=> $transactions_count,
			'admin_messages'	=> $admin_messages,
			'users_info'	=> $users_info
		));
		
		Assets::add_module_js ( 'members', 'members.js' );
	}
	

	/**
	 * Displays dashboard to the member
	 *
	 * @return void
	 */
	public function index($offset = 0) {		
		$this->auth->restrict ();
		// Deleting anything?
		if (isset ( $_POST ['delete'] )) {
			$checked = $this->input->post ( 'checked' );
			
			if (is_array ( $checked ) && count ( $checked )) {
				$result = FALSE;
				foreach ( $checked as $pid ) {
					$result = $this->listings_model->delete ( $pid );
				}
				
				if ($result) {
					Template::set_message ( count ( $checked ) . ' ' . lang ( 'delete_success' ), 'success' );
				} else {
					Template::set_message ( lang ( 'delete_failure' ) . $this->listings_model->error, 'error' );
				}
			}
		}
		$this->listings_model->limit(10, $offset);
		$records = $this->listings_model->order_by('id', 'desc')->find_all_by ( array (
				'user_id' => $this->auth->user_id (),
				'deleted' => 0
		) );
		
		// Pagination
		$this->load->library('pagination');
		$this->config->load("pagination");
		$config['base_url'] = base_url()."/members/index/";
		$config['total_rows'] = $this->listings_model->count_by ( array ('user_id' => $this->auth->user_id (), 'deleted' => 0 ) );
		$config['per_page'] = 10;
		$this->pagination->initialize($config);
		
		Template::set (array(
			'title'	=> lang('members_dashboard'),	
			'records' => $records) 
		);
		Template::render ( 'member' );
	}
	
	/**
	 * Allow member to add new business
	 * @param int $package_id	 * 
	 */
	public function add_business($package_id = NULL) {		
		$package_id = intval($this->encrypt->decode($this->input->get('id')));
		$this->load->model('packages/packages_model');
		$result = $this->packages_model->find_by(array('id' => $package_id, 'active' => 1));
		if($result && count($result) > 0) {	// count result if package exists
			Assets::add_module_js ( 'members', 'listing.js' );
			$this->auth->restrict ();
			
			$user_limit = 1;
			$active_field_value = (int)$result->listings_active;
			$listings_count = $this->listings_model->count_by(array ('user_id' => $this->auth->user_id(), 'package_id' => $package_id));

			if(($user_limit == 0) || ($user_limit > $listings_count)) {	
				$this->load->library('form_validation');
				$this->form_validation->set_rules('listings_description', lang('label_description'), 'required|max_length['.(intval($result->description_limit) == 0) ? 50000 : $result->description_limit.']|xss_clean');
				$this->form_validation->set_rules('listings_keywords', lang('label_keywords'), 'trim|xss_clean|sanitize|alpha_keyword|tag_handling|keywords_limit['.(intval($result->keywords_limit == 0)? 50 : $result->keywords_limit).']');
				if (($this->form_validation->run() == TRUE) && isset ( $_POST ['save'] )) {
					if ($insert_id = $this->save_listings ('insert', 0, $active_field_value)) {
						$this->deal_with_tags ( 'insert_listing_tags', $insert_id );
						
						// Log the activity
						log_activity ( $this->auth->user_id(), lang ( 'act_create_record' ) . ': ' . $insert_id . ' : ' . $this->input->ip_address (), 'listings' );
						
						Template::set_message ( lang ( 'create_success' ), 'success' );
						// Price is greater than zero
						if($result->price > 0 ) {
							$transaction_id = $this->insert_transaction($insert_id, $package_id, $this->input->post('payment_gateways'), $result->price);
							// set temporary session in order to update transaction status after payment
							$package_duration = $this->packages_model->select('duration')->find($package_id);
							$expired_on = new DateTime(date("Y-m-d"));
							$expired_on->modify($package_duration->duration . " day");							
							$this->session->set_userdata('package_duration', $expired_on->format("Y-m-d"));							
							$this->session->set_userdata('transaction_id', $transaction_id); // flashdata was not working
							$this->session->set_userdata('inserted_listing_id', $insert_id); // flashdata was not working
							$this->session->set_userdata('amount', $result->price); // pass amount to payment gateway
							redirect('payment_gateways/' .$this->input->post('payment_gateways'));
						}
						redirect (site_url('members'));
					} else {
						Template::set_message ( lang ( 'create_failure' ) . $this->listings_model->error, 'error' );
					}
				}	
				Assets::add_module_js ( 'listings', 'listings.js' );
				
				$countries = $this->listings_model->get_countries ();
				$categories = $this->categories_model->select('id, name')->find_all_by(array('parent_id' => 0));
				$map = $this->google_map ();
				
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
				
				if(settings_item('lst.allow_country_selection') == 1) {
					if($this->input->post('listings_country_id')) {
						$selected_country = $this->input->post('listings_country_id');
						Template::set('selected_country', $selected_country);
						$this->load->model('locations/states_model');
						$listing_states = $this->states_model->select('id, name')->find_all_by('country_iso', $this->input->post('listings_country_id'));
						Template::set('listing_states', $listing_states);
					}
				} else {
					$this->load->model('locations/states_model');
					$listing_states = $this->states_model->select('id, name')->find_all_by('country_iso', settings_item('adv.default_country'));
					Template::set('listing_states', $listing_states);
				}
				
				if($this->input->post('listings_state_id')) {
					$selected_state = $this->input->post('listings_state_id');
					Template::set('selected_state', $selected_state);
					$listing_cities = $this->cities_model->select('id, name')->find_all_by('state_id', $this->input->post('listings_state_id'));
					Template::set('listing_cities', $listing_cities);
				}
				
				if($this->input->post('listings_city_id')) {
					$selected_city = $this->input->post('listings_city_id');
					Template::set('selected_city', $selected_city);
				}
				
				Template::set ( array (
						'package_id' => $package_id,
						'categories' => $categories,
						'all_countries' => $countries,
						'map' => $map,
						'description_limit' => $result->description_limit,
						'keywords_limit'	=> $result->keywords_limit
				) );
				
				/** Get payment gateways. Display payment selection option to user at the end of form 
				 * if package has a price associated with it*/
				
				if($result->price > 0) {
					$this->load->model('payment_gateways/payment_gateways_model');
					$payment_gateways = $this->payment_gateways_model->select('name, display_name')->find_all_by(array('active' => 1));
					Template::set (array (
						'payment_gateways' => $payment_gateways,
						'price'	=> $result->price
					));				
				}
				Template::set ('title', lang('header_add_business') );
				Template::set_view ( 'listings_form' );
				Template::render ('member');
			} else {
				Template::set_message(sprintf(lang('user_limit'), $user_limit, 'listing(s)'), 'error');
				redirect(site_url('members'));
			}
		} else {
			redirect('members/packages');
		}
	}
	
	/**
	 * SAVE PAYMENT INFORMATION IN TRANSACTION TABLE STATUS AS PENDING AND UPDATE IT ON SUCCESSFUL PAYMENT
	 * @param int $listing_id
	 * @param int $package_id
	 * @param string $payment_method
	 * @param float $amount
	 */
	public function insert_transaction($listing_id, $package_id, $payment_method, $amount) {
		$this->load->model('transactions/transactions_model');
		$this->transactions_model->skip_validation(true);
		// get last invoice value
		$invoice_value = $this->transactions_model->select('invoice')->order_by('id', 'desc')->limit(1)->find_all();
		$data = array();
		if(!empty($invoice_value)) {
			$data['invoice']        = $invoice_value[0]->invoice + 1; // last invoice plus 1
		} else {
			$data['invoice']        = 1;
		}
		$data['package_id']     = $package_id;
		$data['user_id']        = $this->auth->user_id();
		$data['listing_id']     = $listing_id;
		$data['payment_method'] = $payment_method;
		$data['currency']     	= settings_item('site.currency');
		$data['amount']         = $amount;
		$data['received_on']    = date('Y-m-d H:i:s');
		$data['ip_address']		= $this->input->ip_address();
		return $id = $this->transactions_model->insert($data);
	}
	
	/**
	 * Edit business information
	 * @param string $id
	 */
	public function edit_business() {
		$id = intval($this->encrypt->decode($this->input->get('id')));
		Assets::add_module_js ( 'members', 'listing.js' );
		$record = $this->listings_model->find ( $id );
		$package_info = $this->packages_model->find_by(array('id' => $record->package_id));
		if($record) {
		if(((int)$record->user_id != $this->auth->user_id()) || ((int)$record->deleted == 1)) {
			Template::set_message ( lang ( 'unauthorized_deleted' ), 'error' );
			redirect ( site_url('members' ));
		} else {
		
		if (isset ( $_POST ['save'] )) {
			$this->auth->restrict ();
			$this->load->library('form_validation');
			$this->form_validation->set_rules('listings_description', lang('label_description'), 'required|max_length['.(intval($package_info->description_limit) == 0) ? 50000 : $package_info->description_limit.']|xss_clean');
			$this->form_validation->set_rules('listings_keywords', lang('label_keywords'), 'trim|xss_clean|sanitize|alpha_keyword|tag_handling|keywords_limit['.(intval($package_info->keywords_limit == 0)? 50 : $package_info->keywords_limit).']');
			
			if (($this->form_validation->run() == TRUE) && $this->save_listings ( 'update', $id )) {
				$this->deal_with_tags ( 'update_listing_tags', $id );
				// Log the activity
				log_activity ( $this->auth->user_id(), lang ( 'act_edit_record' ) . ': ' . $id . ' : ' . $this->input->ip_address (), 'listings' );
				
				Template::set_message ( lang ( 'edit_success' ), 'success' );
			} else {
				Template::set_message ( lang ( 'edit_failure' ) . $this->listings_model->error, 'error' );
			}
		} else if (isset ( $_POST ['delete'] )) {
			$this->auth->restrict ();
			
			if ($this->listings_model->delete ( $id )) {
				// Log the activity
				log_activity ( $this->auth->user_id(), lang ( 'act_delete_record' ) . ': ' . $id . ' : ' . $this->input->ip_address (), 'listings' );
				
				Template::set_message ( lang ( 'delete_success' ), 'success' );
				
				redirect ( site_url('members' ));
			} else {
				Template::set_message ( lang ( 'delete_failure' ) . $this->listings_model->error, 'error' );
			}
		}
		
		/* --------------------- Categories ------------------------- */
		// DEAL WITH CATEGORIES
		$categories = $this->categories_model->find_all_by('parent_id', 0);
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
		/* ------------------ End of Categories ---------------------- */
		$countries = $this->listings_model->get_countries ();
		$states = $this->listings_model->get_states ( $record->country_iso );
		$cities = $this->listings_model->get_cities ( $record->state_id );
		$localities = $this->listings_model->get_localities ( $record->city_id );
		$map = $this->google_map ( $record->latitude, $record->longitude );
		
		/* --------------------- TAGS ------------------------- */
		// GET KEYWORDS FROM TAGS TABLE AND STORE THEM IN AN ARRAY
		$keywords = array ();
		$tags = '';
		$tags_id_result = $this->tags_model->find_listing_tags ( $id );
		if ($tags_id_result) {
			foreach ( $tags_id_result as $keyword ) {
				$keywords [] = $keyword->name;
			}
			$tags = implode ( ', ', $keywords ); // STORE THEM AS A STRING IN COMMA SEPARATED VERSION
		}
		/* ------------------- END OF TAGS ---------------------- */
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
			} else {
				Template::set('parent_category', $parent_category);
				Template::set('sub_categories', $sub_categories);
			}
				
			if($this->input->post('listings_subcategory_id')) {
				$sub_category = $this->input->post('listings_subcategory_id');
				Template::set('sub_category', $sub_category);
			} else {
				Template::set('sub_category', $sub_category);
			}
		} else if(settings_item('lst.categories_level') == 3) {
			if($this->input->post('listings_category_id')) {
				$parent_category = $this->input->post('listings_category_id');
				Template::set('parent_category', $parent_category);
				$sub_categories = $this->categories_model->select('id, name')->find_all_by('parent_id', $this->input->post('listings_category_id'));
				Template::set('sub_categories', $sub_categories);
			} else {
				Template::set('parent_category', $parent_category);
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
				$listing_states = $this->states_model->select('id, name')->find_all_by('country_iso', $this->input->post('listings_country_id'));
				Template::set('listing_states', $listing_states);
			} else {
				Template::set('listing_states', $states);
			}
		} else {
			$this->load->model('locations/states_model');
			$listing_states = $this->states_model->select('id, name')->find_all_by('country_iso', settings_item('adv.default_country'));
			Template::set('listing_states', $listing_states);
		}
		
		if($this->input->post('listings_state_id')) {
			$selected_state = $this->input->post('listings_state_id');
			Template::set('selected_state', $selected_state);
			$this->load->model('locations/cities_model');
			$listing_cities = $this->cities_model->select('id, name')->find_all_by('state_id', $this->input->post('listings_state_id'));
			Template::set('listing_cities', $listing_cities);
		} else {
			Template::set('listing_cities', $cities);
		}
		
		if($this->input->post('listings_city_id')) {
			$selected_city = $this->input->post('listings_city_id');
			Template::set('selected_city', $selected_city);
		}
		
		Template::set ( array (
				'package_id' => $record->package_id,
				'categories' => $categories,
				'parent_category' => $parent_category,
				'sub_category' => $sub_category,
				'all_countries' => $countries,
				'localities' => $localities,
				'map' => $map,
				'tags' => $tags,
				'description_limit' => $package_info->description_limit,
				'keywords_limit'	=> $package_info->keywords_limit
				) );
		
		$this->session->set_userdata('previous_city', $record->city_id);
		Template::set ( 'listings', $record );
		Template::set ( 'title', lang ( 'listings_edit_heading' ) );
		Template::set_view ( 'listings_form' );
		Template::render ('member');
		}
		} else {
			redirect ( site_url('members' ));
		}
	}
	
	/**
	 * Save business information in database
	 * @param string $type
	 * @param number $id
	 * @return number
	 */
	private function save_listings($type = 'insert', $id = 0, $active = 0) {
		if ($type == 'update') {
			$_POST ['id'] = $id;
		}
		$data = array ();
		$data ['package_id'] = $this->input->post('package_id');
		$data ['user_id'] = $this->auth->user_id();
		$data ['title'] = $this->input->post ( 'listings_title' );
		
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
		
		if(settings_item('allow_country_selection') == 1){
			$data ['country_iso'] = $this->input->post ( 'listings_country_id' );
		} else {
			$data ['country_iso'] = settings_item('adv.default_country');
		}
		
		$data ['state_id'] = $this->input->post ( 'listings_state_id' );
		$data ['city_id'] = $this->input->post ( 'listings_city_id' );
		if ($this->input->post ( 'listings_locality_id' )) {
			$data ['locality_id'] = $this->input->post ( 'listings_locality_id' );
		}
		$data ['pincode'] = $this->input->post ( 'listings_pincode' );
		$data ['address'] = $this->input->post ( 'listings_address' );
		$data ['latitude'] = $this->input->post ( 'listings_latitude' );
		$data ['longitude'] = $this->input->post ( 'listings_longitude' );
		$data ['contact_person'] = $this->input->post ( 'listings_contact_person' );
		$data ['phone_number'] = $this->input->post ( 'listings_phone_number' );
		$data ['mobile_number'] = $this->input->post ( 'listings_mobile_number' );
		$data ['tollfree'] = $this->input->post ( 'listings_tollfree' );
		$data ['fax'] = $this->input->post ( 'listings_fax' );
		$data ['email'] = $this->input->post ( 'listings_email' );
		$data ['website'] = $this->input->post ( 'listings_website' );		
		
		if(settings_item('lst.allow_facebook_url') == 1) {
			$data['facebook_url']      	= $this->input->post('listings_facebook_url');
		}
		if(settings_item('lst.allow_twitter_url') == 1) {
			$data['twitter_url']       	= $this->input->post('listings_twitter_url');
		}
		if(settings_item('lst.allow_googleplus_url') == 1) {
			$data['googleplus_url']    	= $this->input->post('listings_googleplus_url');
		}
		
		$data ['description'] = $this->input->post ( 'listings_description' );
		if ($type == 'insert') {
			$data['slug'] = $this->slug->create_slug ( $data ['title'] );
			$data['active'] = $active;
			$id = $this->listings_model->insert ( $data );
			
			if (is_numeric ( $id )) {
				$return = $id;
			} else {
				$return = FALSE;
			}
		} elseif ($type == 'update') {
			$return = $this->listings_model->update ( $id, $data );
		}
		
		return $return;
	}
	
	/**
	 * Ajax function to load sub categories
	 * @param int $parent_id
	 * @return JsonResponse
	 */
	public function loadSubCategories($parent_id)
	{
		header('Content-Type: application/x-json; charset=utf-8');
		$result = $this->categories_model->find_all_by('parent_id', $parent_id);
		$output = json_decode(json_encode($result),true);
		echo json_encode($output);
	}
	
	/**
	 * Ajax function to load locations
	 * @param string $type
	 * @param int $id
	 * @return JsonResponse
	 */
	public function loadLocations($type, $id)
	{
		header('Content-Type: application/x-json; charset=utf-8');
		$result = $this->listings_model->getData($type, $id);
		$output = json_decode(json_encode($result),true);
		echo json_encode($output);
	}
	
	/**
	 * Display Google Map to the member
	 * @param float $latitude
	 * @param float $longitude
	 */
	public function google_map($latitude = NULL, $longitude = NULL) {
		$this->load->library ( 'listings/googlemaps' );
		$config = array ();
		// SET LATITUDE AND LONGITUDE IF NOT EDIT
		if (($latitude == NULL) && ($longitude == NULL)) {
			$ip = $_SERVER ['REMOTE_ADDR'];
			// MADE USE OF FREE PLUGIN
			$geopluginURL = 'http://www.geoplugin.net/php.gp?ip=49.249.196.21'; // .$ip;
			$unarr = file_get_contents ( $geopluginURL ); // Get File Contents
			$AddArr = unserialize ( $unarr ); // Get PHP values from file contents
			$latitude = $AddArr ['geoplugin_latitude']; // City Name
			$longitude = $AddArr ['geoplugin_longitude'];
		}
		$config ['center'] = "$latitude, $longitude";
		$config ['zoom'] = 14;
		$config ['places'] = TRUE;
		$this->googlemaps->initialize ( $config );
		
		$marker = array ();
		$marker ['position'] = "$latitude, $longitude";
		$marker ['draggable'] = true;
		$marker ['ondragend'] = 'updateLatLngTextFields(event.latLng.lat(), event.latLng.lng());';
		$this->googlemaps->add_marker ( $marker );
		return $this->googlemaps->create_map ();
	}
	
	/**
	 * Handle tags or keywords information
	 * @param string $type
	 * @param int $listing_id
	 * @return null
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
						$insert_query = $this->db->insert_string('tags', $data_tags);
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
	 * Allow member to upload listing logo
	 */
	public function logo() {
		$this->auth->restrict();
		$id = intval($this->encrypt->decode($this->input->get('id')));
		if (empty ( $id )) {
			Template::set_message ( lang ( 'invalid_id' ), 'error' );
			redirect ( site_url( 'members' ));
		}
		$data = array();
		if (isset($_POST['submit'])){
			if($_FILES['listings_logo']['name']) {
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
		}
	
		//Display logo to the user
		$this->listings_model->select('logo_url');
		$records = $this->listings_model->select('title, logo_url')->find_by(array('id' => $id));
		
		Template::set(array(
			'listing_title' => $records->title,
			'logo' => $records->logo_url,
			'title' => 'Upload Logo',
			'help_message' => sprintf(lang('image_help'), settings_item('lst.logo_file_size'), settings_item('lst.logo_width'), settings_item('lst.logo_height'))
		));
		Template::render('member');
	}
	
	/**
	 * Save uploaded image
	 * @return multitype:NULL
	 */
	private function upload_logo_file(){
		$config['upload_path'] = realpath(FCPATH.'assets/images/logo/'); //Make SURE that you chmod this directory to 777!
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']= settings_item('lst.logo_file_size');
		$config['max_width']= settings_item('lst.logo_width');
		$config['max_height']= settings_item('lst.logo_height');
		$config['remove_spaces']=TRUE; //Remove spaces from the file name
	
		$this->load->library('upload', $config);
	
		// Image name is necessary
		if (!$this->upload->do_upload('listings_logo')) {
			Template::set_message($this->upload->display_errors(), 'error'); // Show errors to the user
			redirect(site_url('members/logo?id='.$this->input->get('id')));
		}
		else {
			$data = array('upload_data' => $this->upload->data());
			$this->resize($data['upload_data']['full_path'],$data['upload_data']['file_name']);
		}
		return $data;
	}
	
	/**
	 * Create thumbs of uploaded image
	 * @param string $path for saving image
	 * @param string $file for file name
	 */
	public function resize($path,$file){
		$config['image_library']='gd2';
		$config['source_image']=$path;
		$config['create_thumb']=TRUE; // This will create new file
		$config['maintain_ratio']=TRUE;
		$config['width']=settings_item('lst.thumbnail_width');
		$config['height']=settings_item('lst.thumbnail_height');
		$config['new_image']='./assets/images/logo/thumbs/'.$file; //CHANGE THIS LINE FOR PATH
	
		$this->load->library('image_lib',$config);
		$this->image_lib->resize();
	}
	
	/* ------------------------ PRODUCTS MODULE ---------------------------------------- */
	//MOVE USER TO PRODUCTS MODULE
	public function products()
	{
		$listing_id = intval($this->encrypt->decode($this->input->get('id')));
		$listing_user = $this->listings_model->select('user_id')->find_by(array('id' => $listing_id, 'deleted' => 0)); // find user_id of specified listing
		if($listing_user && ($listing_user->user_id == $this->auth->user_id())) {
			$this->load->model('products_model');
			$records = $this->products_model->get_listing_products($listing_id, $this->auth->user_id());
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
							redirect('members/products/'.$listing_id);
						}
						else {
							Template::set_message(lang('delete_failure') . $this->products_model->error, 'error');
						}
					}
			}
			Template::set(array(
					'records' => $records,
					'title'=> 'Products Information',
					'listing_id'=> $listing_id
			));
			Template::render('member');
		} else {
			redirect('members');
		}
	}
	
	/**
	 * Add product to listing
	 * @param $listing_id
	 * @return null
	 */
	public function add_product()
	{
		$this->auth->restrict();
		$listing_id = intval($this->encrypt->decode($this->input->get('id')));
		$listing_user = $this->listings_model->select('user_id')->find_by(array('id' => $listing_id, 'deleted' => 0)); // find user_id of specified listing
		
		if(($listing_id != NULL) && $listing_user && ($listing_user->user_id == $this->auth->user_id())) { // user has permission
		
			// GET USER LIMIT AND ACTIVE VALUE FROM PACKAGE
			$package_settings = $this->packages_model->get_package_info($listing_id);
			$user_limit = (int)$package_settings->products_limit;
			$active_field_value = (int)$package_settings->products_active;
			$products_count = $this->products_model->count_by('listing_id', $listing_id);
			
			if(($user_limit == 0) || ($user_limit > $products_count)) {		
				if (isset($_POST['save'])) {
					if ($insert_id = $this->save_products('insert', 0, $active_field_value)) {
						// Log the activity
						log_activity($this->auth->user_id(), lang('act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'products');
			
						Template::set_message(lang('create_success'), 'success');
						redirect(site_url('members/products?id=' .$this->encrypt->encode($listing_id)));
					}
					else {
						Template::set_message(lang('create_failure') . $this->products_model->error, 'error');
					}
				}
				Assets::add_module_js('products', 'products.js');
				Template::set(array(
					// 'help_message' => sprintf(lang('image_help'), settings_item('lst.image_file_size'), settings_item('lst.image_width'), settings_item('lst.image_height')),
					'title'=> lang('add') .' '.lang('label_product'),
					'listing_id' => $listing_id
				));
				Template::set_view('products_form');
				Template::render('member');
			} else {
				Template::set_message(sprintf(lang('user_limit'), $user_limit, 'products/services'), 'error');
				redirect(site_url('members/products?id='.$this->encrypt->encode($listing_id)));
			}
	} else {
		redirect(site_url('members'));
	}
}
	
	/**
 	* Edit existing product
 	* @param $id
 	* @return null 
 	*/
	public function edit_product()
	{
		$this->auth->restrict();
		$id = intval($this->encrypt->decode($this->input->get('id')));
		$this->load->model('products_model');
		if($id != NULL) {
		$product = $this->products_model->get_products_member($id, $this->auth->user_id());
		if($product) { // user has permission				
			if (isset($_POST['save']))
			{
				$this->auth->restrict();
		
				if ($this->save_products('update', $id)) {
					// Log the activity
					log_activity($this->auth->user_id(), lang('act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'products');
		
					Template::set_message(lang('edit_success'), 'success');
					redirect(site_url('members/products?id=' .$this->encrypt->encode($product->listing_id)));
				}
				else {
					Template::set_message(lang('edit_failure') . $this->products_model->error, 'error');
				}
			}
			else if (isset($_POST['delete'])) {
				$this->auth->restrict();
		
				if ($this->products_model->delete($id)) {
					// Log the activity
					log_activity($this->auth->user_id(), lang('act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'products');
		
					Template::set_message(lang('delete_success'), 'success');
		
					redirect(site_url('members/products?id=' .$this->encrypt->encode($product->listing_id)));
				}
				else {
					Template::set_message(lang('delete_failure') . $this->products_model->error, 'error');
				}
			}

			Template::set(array(
				// 'help_message' => sprintf(lang('image_help'), settings_item('lst.image_file_size'), settings_item('lst.image_width'), settings_item('lst.image_height')),
				'products' => $product,
				'title'=> 'Edit Product',
				'listing_id'=> $product->listing_id
			));
			Template::set_view('products_form');
			Template::render('member');
		} else {
			redirect(site_url('members'));
		}
	} else {
			redirect(site_url('members'));
	}
	}
		
	/**
	 * Save product information
	 * @param string $type
	 * @param number $id
	 * @param number $active
	 * @return number
	 */
	private function save_products($type = 'insert', $id = 0, $active = 0) {
		if ($type == 'update') {
			$_POST ['id'] = $id;
		}
		// make sure we only pass in the fields we want
		$data = array ();
		$data ['listing_id'] = $this->input->post ( 'products_listing_id' );
		$data ['title'] = $this->input->post ( 'products_title' );
		$data ['type'] = $this->input->post ( 'products_type' );
		$data ['price'] = $this->input->post ( 'products_price' );
		
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
		
		$data ['description'] = $this->input->post ( 'products_description' );
		
		if ($type == 'insert') {
			$data['active'] = $active;
			$id = $this->products_model->insert ( $data );
			if (is_numeric ( $id )) {
				$return = $id;
			} else {
				$return = FALSE;
			}
		} elseif ($type == 'update') {
			$return = $this->products_model->update ( $id, $data );
		}
		return $return;
	}	

	/**
	 * Upload image using CRUD
	 * Image_CRUD 0.6 is used to upload images
	 */
	public function photos($listing_id = NULL) {
		$this->auth->restrict();
		// IMPORTANT OTHERWISE AJAX WILL NOT WORK
		if(is_numeric($listing_id)) {
			$this->session->set_userdata('listing_id', $listing_id);
		}
		
		// GET USER LIMIT AND ACTIVE VALUE FROM PACKAGE
		$package_settings = $this->packages_model->get_package_info($this->session->userdata('listing_id'));
		if($package_settings) {
			$user_limit = (int)$package_settings->images_limit;
			$active_field_value = (int)$package_settings->photos_active;
		}
		
		// COUNT EXISTING IMAGES
		$query = "SELECT COUNT(id) AS count FROM " . $this->db->dbprefix . "images WHERE listing_id = " .$this->session->userdata('listing_id');
		$count_val = $this->db->query($query)->result();
		foreach($count_val as $count) {
			$images_count = $count->count;
		}
		
		// CHECK USER PERMISSION
		$this->db->select('user_id')->where(array('id' => $this->session->userdata('listing_id'), 'user_id' => $this->auth->user_id(), 'deleted' => 0));
		$listing_permission = $this->db->count_all_results('listings');
		if($listing_permission) {
		//Load image_crud config and libraries file for upload_images function
		/* --------------------------------- */
		$this->load->config('image_crud');
		$this->load->library('image_crud');
		$this->load->library('image_moo');
		/* --------------------------------- */
		$image_crud = new image_CRUD();
		$image_crud->set_primary_key_field('id');
		$image_crud->set_url_field('url');
		$image_crud->set_title_field('title');
		$image_crud->set_active_field('active');
		
		$image_crud->active_field_value($active_field_value);
		$image_crud->user_limit($user_limit);
		$image_crud->images_count($images_count);
		$image_crud->user_role($this->session->userdata('role_id'));
		
		$image_crud->set_table('images')
		->set_relation_field('listing_id')
		->set_ordering_field('priority')
		->set_image_path('assets/images/photos'); // CHANGE THIS FOR PATH
		$output = $image_crud->render();
		Assets::add_css($output->css_files);
		Assets::add_js($output->js_files);
		Template::set(array(
			'help_message' => sprintf(lang('image_help'), settings_item('lst.image_file_size'), settings_item('lst.image_width'), settings_item('lst.image_height')) ,
			'title'=> 'Image Uploader',
			'output' => $output->output
		));
		
		if($listing_permission == 1) { // user has permission
			Template::render('member');			
		} else {
			redirect(site_url('members'));
		}
		} else {
			redirect(site_url('members'));
		}		
	}
			
	/**
	 * TAKE USER TO VIDEO MODULE AND DISPLAY EXISTING VIDEOS
	 * @param int $listing_id
	 * @param int $id
	 */
	public function videos()
	{
		$this->auth->restrict();
		$listing_id = intval($this->encrypt->decode($this->input->get('id')));
		$id = intval(urldecode(base64_decode($this->input->get('video_id'))));
		$listing_user = $this->listings_model->select('user_id')->find_by(array('id' => $listing_id, 'deleted' => 0)); // find user_id of specified listing
		if($listing_user && ($listing_user->user_id == $this->auth->user_id())) {
			//LOAD MODAL FOR YOUTUBE VIDEO PLAYER
			Assets::add_module_js('members', 'videos.js');
			Assets::add_js('js/bootstrap.youtubepopup.min.js');
			
			if (! isset ( $listing_id ) || $listing_id == NULL) {
				Template::redirect ( 'members' );
			} else {
				$this->load->model ( 'videos_model' ); // Display information using videos model
				if (isset ( $_POST ['save'] )) {
					if($id == NULL) {
						// GET USER LIMIT AND ACTIVE VALUE FROM PACKAGE
						$package_settings = $this->packages_model->get_package_info($listing_id);
						$user_limit = (int)$package_settings->videos_limit;
						$active_field_value = (int)$package_settings->videos_active;
						$videos_count = $this->videos_model->count_by('listing_id', $listing_id);
							
						if(($user_limit == 0) || ($user_limit > $videos_count)) {						
							if ($insert_id = $this->save_videos ('insert', 0, $active_field_value)) {
								// Log the activity
								log_activity ( $this->auth->user_id(), lang ( 'act_create_record' ) . ': ' . $insert_id . ' : ' . $this->input->ip_address (), 'videos' );
						
								Template::set_message ( lang ( 'create_success' ), 'success' );
								redirect ( site_url('members/videos?id=' . $this->encrypt->encode($listing_id) ));
							} else {
								Template::set_message ( lang ( 'create_failure' ) . $this->videos_model->error, 'error' );
							}
						} else {
							Template::set_message(sprintf(lang('user_limit'), $user_limit, 'videos'), 'error');
						}
					} else {
						if ($this->save_videos ( 'update', $id )) {
							// Log the activity
							log_activity ( $this->auth->user_id(), lang ( 'act_edit_record' ) . ': ' . $id . ' : ' . $this->input->ip_address (), 'videos' );
						
							Template::set_message ( lang ( 'edit_success' ), 'success' );
							redirect ( site_url('members/videos?id=' . $this->encrypt->encode($listing_id) ));
						} else {
							Template::set_message ( lang ( 'edit_failure' ) . $this->videos_model->error, 'error' );
						}
					}
				}
				// Deleting anything?
				if (isset ( $_POST ['delete'] )) {
					$checked = $this->input->post ( 'checked' );
					
					if (is_array ( $checked ) && count ( $checked )) {
						$result = FALSE;
						foreach ( $checked as $pid ) {
							$result = $this->videos_model->delete ( $pid );
						}
						if ($result) {
							Template::set_message ( count ( $checked ) . ' ' . lang ( 'delete_success' ), 'success' );
						} else {
							Template::set_message ( lang ( 'delete_failure' ) . $this->videos_model->error, 'error' );
						}
					}
				}	
				$records = $this->videos_model->where('listing_id', $listing_id)->find_all();
		
				Template::set(array (
					'title'	=> 'Manage Videos',
					//'help_message' => sprintf(lang('image_help'), settings_item('lst.image_file_size'), settings_item('lst.image_width'), settings_item('lst.image_height')),
					'listing_id' => $listing_id,
					'records' => $records,
					'videos' => $this->videos_model->find ($id),
				));
				Template::render('member');
			}
		} else {
			redirect(site_url('members'));
		}		
	}
	
	/**
	 * Save YouTube video information in database
	 * @param string $type
	 * @param int $id
	 * @param int $active
	 */
	private function save_videos($type = 'insert', $id = 0, $active = 0) {
		$this->load->model ( 'videos_model' );
		if ($type == 'update') {
			$_POST ['id'] = $id;
		}		
		// make sure we only pass in the fields we want		
		$data = array ();
		$data ['listing_id'] = $this->input->post ( 'listing_id' );
		$data ['url'] = $this->get_video_id ( $this->input->post ( 'videos_url' ) ); // Return video id
		if ($this->input->post ( 'videos_title' )) { // Retrieve title from youtube and save in database
			$data ['title'] = $this->input->post ( 'videos_title' );
		} else {
			$data ['title'] = '' . $this->get_video_title ( $data ['url'] ) . '';
		}
		
		if ($type == 'insert') {
			$data['active'] = $active;
			$id = $this->videos_model->insert ( $data );
			if (is_numeric ( $id )) {
				$return = $id;
			} else {
				$return = FALSE;
			}
		} elseif ($type == 'update') {
			$return = $this->videos_model->update ( $id, $data );
		}
		return $return;
	}
	
	/**
	 * Get Youtube Video Title
	 * @return unknown
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
	 * Get youtube video ID	 * 
	 * @param string $url        	
	 * @return string
	 */
	private function get_video_id($url) {
		$ytvIDlen = 11; // This is the length of YouTube's video IDs
		                
		// The ID string starts after "v=", which is usually right after
		                // "youtube.com/watch?" in the URL
		$idStarts = strpos ( $url, "?v=" );
		
		// In case the "v=" is NOT right after the "?" (not likely, but I like to keep my
		// bases covered), it will be after an "&":
		if ($idStarts === FALSE)
			$idStarts = strpos ( $url, "&v=" );
			// If still FALSE, URL doesn't have a vid ID
		if ($idStarts === FALSE)
			die (lang ( 'error_video_not_found' ));
			Template::set_message ( lang ( 'error_video_not_found' ) . $this->classifieds_model->error, 'error' );
			
			// Offset the start location to match the beginning of the ID string
		$idStarts += 3;
		
		// Get the ID string and return it
		$ytvID = substr ( $url, $idStarts, $ytvIDlen );
		
		return $ytvID;
	}

	/**
	 * Take member to classified module
	 * @param int $listing_id
	 */
	public function classifieds()
	{
		$this->auth->restrict();
		$listing_id = intval($this->encrypt->decode($this->input->get('id')));
		$this->load->model ( 'classifieds_model' );
		if (! isset ( $listing_id ) || $listing_id == NULL) {
			Template::redirect ( SITE_AREA . '/content/listings' );
		} else {
			// Deleting anything?
			if (isset ( $_POST ['delete'] )) {
				$checked = $this->input->post ( 'checked' );
				if (is_array ( $checked ) && count ( $checked )) {
					$result = FALSE;
					foreach ( $checked as $pid ) {
						$result = $this->classifieds_model->delete_where ( array (
								'listing_id' => $listing_id,
								'id' => $pid 
						) );
					}
					
					if ($result) {
						Template::set_message ( count ( $checked ) . ' ' . lang ( 'delete_success' ), 'success' );
					} else {
						Template::set_message ( lang ( 'delete_failure' ) . $this->classifieds_model->error, 'error' );
					}
				}
			}
			$records = $this->classifieds_model->find_all_by ( array (
					'listing_id' => $listing_id 
			) );
			
			$this->session->set_flashdata ( 'listing_id', $listing_id ); // Set session data for change status
			Template::set ( array(
				'title' => 'Manage Classifieds',
				'listing_id' => $listing_id,
				'records' => $records
			));
			Template::render ('member');
		}
	}

	/**
	 * Add new classified
	 * @param int $listing_id
	 */
	public function add_classified() {
		$this->auth->restrict();
		$listing_id = intval($this->encrypt->decode($this->input->get('id')));
		$listing_user = $this->listings_model->select('user_id')->find_by(array('id' => $listing_id, 'deleted' => 0)); // find user_id of specified listing
		if( ($listing_id != NULL) && $listing_user && ($listing_user->user_id == $this->auth->user_id())) {			
		$this->load->model ( 'classifieds_model' );	
		//DATE TIME PICKER
		Assets::add_js('moment.js');
		Assets::add_css ( 'bootstrap-datetimepicker.min.css' );
		Assets::add_js ( 'bootstrap-datetimepicker.min.js' );
		Assets::add_module_js ( 'members', 'classifieds.js' );
		
		// GET USER LIMIT AND ACTIVE VALUE FROM PACKAGE
		$package_settings = $this->packages_model->get_package_info($listing_id);
		$user_limit = (int)$package_settings->classifieds_limit;
		$active_field_value = (int)$package_settings->classifieds_active;
		$classifieds_count = $this->classifieds_model->count_by('listing_id', $listing_id);
			
		if(($user_limit == 0) || ($user_limit > $classifieds_count)) {
			if (isset ( $_POST ['save'] )) {
				if ($insert_id = $this->save_classifieds ('insert', 0, $active_field_value)) {
					// Log the activity
					log_activity ( $this->auth->user_id(), lang ( 'act_create_record' ) . ': ' . $insert_id . ' : ' . $this->input->ip_address (), 'classifieds' );
					
					Template::set_message ( lang ( 'create_success' ), 'success' );
					redirect(site_url('members/classifieds?id=' .$this->encrypt->encode($listing_id)));
				} else {
					Template::set_message ( lang ( 'create_failure' ) . $this->classifieds_model->error, 'error' );
				}
			}
			Template::set ( array (
				'title'	=> lang('add') .' '. lang('label_classified'),
				//'help_message' => sprintf(lang('image_help'), settings_item('lst.image_file_size'), settings_item('lst.image_width'), settings_item('lst.image_height')),
				'listing_id' => $listing_id
			));
			Template::set_view ( 'classifieds_form' );
			Template::render ('member');
		} else {
			Template::set_message(sprintf(lang('user_limit'), $user_limit, 'classified(s)'), 'error');
			redirect(site_url('members/classifieds?id=' .$this->encrypt->encode($listing_id)));
		}
	} else {
		redirect(site_url('members'));
	}
}

	/**
	 * Edit existing classified information
	 * @param int $id carry classified id
	 */
	public function edit_classified() {
		$this->auth->restrict();
		$id = intval($this->encrypt->decode($this->input->get('id')));		
		$classified = $this->classifieds_model->find ( $id );
		$listing_user = $this->listings_model->select('user_id')->find_by(array('id' => $classified->listing_id, 'deleted' => 0)); // find user_id of specified listing
		if( ($id != NULL) && $listing_user && ($listing_user->user_id == $this->auth->user_id())) {		
			$this->load->model ( 'classifieds_model' );
			//DATE TIME PICKER
			Assets::add_js('moment.js');
			Assets::add_css ( 'bootstrap-datetimepicker.min.css' );
			Assets::add_js ( 'bootstrap-datetimepicker.min.js' );
			Assets::add_module_js ( 'members', 'classifieds.js' );
					
			if (isset ( $_POST ['save'] )) {
				$this->auth->restrict ();
				if ($this->save_classifieds ( 'update', $id )) {
					// Log the activity
					log_activity ( $this->auth->user_id(), lang ( 'act_edit_record' ) . ': ' . $id . ' : ' . $this->input->ip_address (), 'classifieds' );
					
					Template::set_message ( lang ( 'edit_success' ), 'success' );
					redirect(site_url('members/classifieds?id=' .$this->encrypt->encode($classified->listing_id)));
				} else {
					Template::set_message ( lang ( 'edit_failure' ) . $this->classifieds_model->error, 'error' );
				}
			} else if (isset ( $_POST ['delete'] )) {
				$this->auth->restrict ();
				
				if ($this->classifieds_model->delete ( $id )) {
					// Log the activity
					log_activity ( $this->auth->user_id(), lang ( 'act_delete_record' ) . ': ' . $id . ' : ' . $this->input->ip_address (), 'classifieds' );
					
					Template::set_message ( lang ( 'delete_success' ), 'success' );
					
					redirect ( site_url('members/classifieds?id=' .$this->encrypt->encode($classified->listing_id)));
				} else {
					Template::set_message ( lang ( 'delete_failure' ) . $this->classifieds_model->error, 'error' );
				}
			}
			
			Template::set ( array (
					'title'	=> lang('edit') .' '. lang('label_classified'),
					//'help_message' => sprintf(lang('image_help'), settings_item('lst.image_file_size'), settings_item('lst.image_width'), settings_item('lst.image_height')),
					'listing_id' => $classified->listing_id,
			 		'classifieds' => $classified 
			));
			Template::set_view ( 'classifieds_form' );
			Template::render ('member');
		} else {
			redirect(site_url('members'));
		}
	}
		
	/**
	 * Save Classifieds information in database
	 * @param string $type
	 * @param number $id
	 * @param number $active
	 * @return number
	 */
	private function save_classifieds($type = 'insert', $id = 0, $active = 0) {
		$this->load->model ( 'classifieds_model' );
		if ($type == 'update') {
			$_POST ['id'] = $id;
		}		
		$data = array ();
		
		$data ['listing_id'] = $this->input->post ( 'listing_id' );
		$data ['title'] = $this->input->post ( 'classifieds_title' );
		$data ['image'] = $this->input->post ( 'classifieds_image' );
		
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
		
		$data ['from'] = $this->input->post ( 'classifieds_from' ) ? $this->input->post ( 'classifieds_from' ) : '0000-00-00 00:00:00';
		$data ['to'] = $this->input->post ( 'classifieds_to' ) ? $this->input->post ( 'classifieds_to' ) : '0000-00-00 00:00:00';
		$data ['price'] = $this->input->post ( 'classifieds_price' );
		$data ['url'] = $this->input->post ( 'classifieds_link' );
		$data ['description'] = $this->input->post ( 'classifieds_description' );
		if ($type == 'insert') {
			$data['active'] = $active;
			$id = $this->classifieds_model->insert ( $data );
			
			if (is_numeric ( $id )) {
				$return = $id;
			} else {
				$return = FALSE;
			}
		} elseif ($type == 'update') {
			$return = $this->classifieds_model->update ( $id, $data );
		}		
		return $return;
	}

	/**
	 * Upload images function for product/service and classifieds
	 * @param string $upload_path for saving path
	 * @param string $field_name for post field
	 * @param string $type to find out whether request is from add or edit page
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
			$request=$this->uri->segment(2);
			if($request == 'edit_' .$type) {
				redirect(site_url('members/edit_'. $type .'?id=' .$this->input->get('id'))); //Request is from edit page
			}
			else {
				$id=$this->uri->segment(3);
				redirect(site_url('members/add_' . $type .'?id=' .$this->input->get('id'))); //Request is from create page
			}
		}
		else {
			$data = array('upload_data' => $this->upload->data());
			//RESIZE IMAGE USING resize FUNCTION
			$this->resize_image($data['upload_data']['full_path'],$upload_path,$data['upload_data']['file_name']);
		}
		return $data;
	}
	
	/**
	 * Create thumbnail of uploaded image
	 * @param string $path
	 * @param string $upload_path
	 * @param string $file
	 */
	function resize_image($path,$upload_path,$file){
		$config['image_library']='gd2';
		$config['source_image']=$path;
		$config['create_thumb']=TRUE;
		$config['maintain_ratio']=TRUE;
		$config['width']=settings_item('lst.thumbnail_width');
		$config['height']=settings_item('lst.thumbnail_height');
		$config['new_image']='./assets/images/' . $upload_path . '/'.$file;
	
		$this->load->library('image_lib',$config);
		$this->image_lib->resize();
	}
	
	/**
	 * Allow member to add business hours
	 * @param string $listing_id
	 */
	public function business_hours() {
		$this->auth->restrict();
		$listing_id = intval($this->encrypt->decode($this->input->get('id')));
		$listing_user = $this->listings_model->select('user_id')->find_by(array('id' => $listing_id, 'deleted' => 0)); // find user_id of specified listing
		if( ($listing_id != NULL) && $listing_user && ($listing_user->user_id == $this->auth->user_id())) {		
			//BUSINESS HOURS TIME PICKER
			Assets::add_js('moment.js');
			Assets::add_css ( 'bootstrap-datetimepicker.min.css' );
			Assets::add_js ( 'bootstrap-datetimepicker.min.js' );
			Assets::add_module_js ( 'members', 'business_hours.js' );
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
					$this->auth->restrict ();
					
					if ($insert_id = $this->save_business_hours ()) {
						// Log the activity
						log_activity ( $this->auth->user_id(), lang ( 'act_create_record' ) . ': ' . $insert_id . ' : ' . $this->input->ip_address (), 'business_hours' );
						
						Template::set_message ( lang ( 'create_success' ), 'success' );
						redirect ( site_url('members/business_hours/' . $listing_id ));
					} else {
						Template::set_message ( lang ( 'create_failure' ) . $this->business_hours_model->error, 'error' );
					}
				} 				// BUSINESS HOURS EXIST UPDATE THEM
				else {					
					$this->auth->restrict ();
					
					if (! empty ( $_POST ['business_hours_day_of_week'] )) 					// IF NOTHING IS SELECTED DON'T THROW ERRORS
					{
						if ($this->save_business_hours ( 'update' )) { // PERFORM UPDATE OPERATION
						                                               // Log the activity
							log_activity ( $this->auth->user_id(), lang ( 'act_edit_record' ) . ': ' . $this->input->ip_address (), 'business_hours' );
							
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
			Template::set (array(
				'title'	=> lang('label_business_hours'),
				'listing_id' => $listing_id,
				'records' => $records
			));
			Template::render ('member');
		} else {
			redirect(site_url('members'));
		}
	}
	
	/**
	 * Save business hours in database
	 * @param string $type
	 * @param number $id
	 * @return Ambigous <boolean, number>
	 */
	private function save_business_hours($type = 'insert', $id = 0) {
		$this->load->model ( 'business_hours_model' );
		if ($type == 'update') {
			$_POST ['id'] = $id;
		}
		
		$return = NULL;
		$data = array ();
		// DON'T DISPLAY ERRORS IF USER SUBMIT BLANK FORM
		if (! empty ( $_POST ['business_hours_day_of_week'] )) {
			foreach ( $_POST ['business_hours_day_of_week'] as $textbox ) {
				$data ['listing_id'] = $_POST ['listing_id'];
				$data ['day_of_week'] = $textbox;
				
				// IF CHECKBOX IS SELECTED SET VALIDATION RULES FOR CORRESPONDING INPUT TEXT BOX
				$this->form_validation->set_rules ( 'open_time_' . $textbox, 'From', 'trim|required' );
				$this->form_validation->set_rules ( 'close_time_' . $textbox, 'To', 'trim|required' );
				// Process the form
				if ($this->form_validation->run () == TRUE) {
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
	 * Allow member to view comments posted by users on their listings
	 * @param number $offset for pagination
	 */
	public function view_comments($offset = 0) {
		// Deleting anything?
		if (isset($_POST['delete'])) {
			$checked = $this->input->post('checked');		
			if (is_array($checked) && count($checked)) {
				$result = FALSE;
				foreach ($checked as $pid) {
					$result = $this->comments_model->delete($pid);
				}
		
				if ($result) {
					Template::set_message(count($checked) .' '. lang('delete_success'), 'success');
					redirect(site_url('members/view_comments'));
				}
				else {
					Template::set_message(lang('delete_failure') . $this->comments_model->error, 'error');
				}
			}
		}
		$this->auth->restrict();
		$this->comments_model->limit(10, $offset);
		$all_comments = $this->comments_model->get_listing_comments($this->auth->user_id());		
		if($all_comments) {			
			Template::set ( 'records', $all_comments );			
		} 
		// Pagination
		$this->load->library('pagination');
		//$this->config->load(APPPATH ."pagination");
		$config['base_url'] = base_url()."/members/view_comments/";
		$config['total_rows'] = $this->comments_model->count_listing_comments($this->auth->user_id());//count($all_comments);
		$config['per_page'] = 10;
		$this->pagination->initialize($config);
		//Template::set ('total_comments', $comments_count);
		Template::set ('title', 'Comments');
		Template::render ('member');
	}
	/**
	 * Allow member to view business queries asked by users on their listings
	 * @param number $offset for pagination
	 */
	public function view_business_queries($offset = 0) {
		// Deleting anything?
		if (isset($_POST['delete'])) {
			$checked = $this->input->post('checked');
			if (is_array($checked) && count($checked)) {
				$result = FALSE;
				foreach ($checked as $pid) {
					$result = $this->business_queries_model->delete($pid);
				}
		
				if ($result) {
					Template::set_message(count($checked) .' '. lang('delete_success'), 'success');
					redirect(site_url('members/view_business_queries'));
				}
				else {
					Template::set_message(lang('delete_failure') . $this->business_queries_model->error, 'error');
				}
			}
		}
		$this->auth->restrict();
		Assets::add_module_js ( 'members', 'business_queries.js' );
		$this->business_queries_model->limit(10, $offset);
		$all_queries = $this->business_queries_model->get_business_queries($this->auth->user_id());		
		if($all_queries) {
			Template::set ( 'records', $all_queries );
		}
		// Pagination
		$this->load->library('pagination');
		$this->config->load("pagination");
		$config['base_url'] = base_url()."/members/view_business_queries/";
		$config['total_rows'] = $this->business_queries_model->count_business_queries($this->auth->user_id());//count($all_comments);
		$config['per_page'] = 10;
		$this->pagination->initialize($config);
		//Template::set ('total_business_queries', $queries_count);
		Template::set ('title', 'Business Queries');
		Template::render ('member');
	}
	
	/**
	 * Allow member to select package for their listing
	 * @param number $offset
	 */
	public function packages() {
		$this->auth->restrict();
		$this->load->model('packages/packages_model');
		$now = date('Y-m-d H:m:s');
		
		// GET PACKAGES WHICH ARE NOT EXPIRED
		$where = "((duration = 0) || (duration >= DATEDIFF( '" .$now ."', created_on )) + duration) AND active = 1";
		$all_packages = $this->packages_model->find_all_by($where);
		if($all_packages && (count($all_packages)> 1)) { // when multiple packages are set
			Template::set ( 'records', $all_packages );
		} else if($all_packages && (count($all_packages)== 1)) { // only one package is available and it is set to default
			redirect(site_url('members/add_business/' .$all_packages[0]->id));
		}
		Template::set ('title', lang('label_select_package'));
		Template::render ('member');
	}
	
	/**
	 * Allow member to view and download invoices
	 * @param number $offset for pagination
	 */
	 public function invoices($offset = 0) {
		$this->auth->restrict();
		$this->transactions_model->limit(10, $offset);
		$all_transactions = $this->transactions_model->get_member_transactions($this->auth->user_id());//$this->transactions_model->find_all_by(array('user_id' => $this->auth->user_id()));
		if($all_transactions) { // when multiple packages are set
			Template::set ( 'records', $all_transactions );
		}
		// Pagination
		$this->load->library('pagination');
		$this->config->load("pagination");
		$config['base_url'] = base_url()."/members/invoices/";
		$config['total_rows'] = $this->transactions_model->count_by(array('user_id' => $this->auth->user_id()));//count($all_comments);
		$config['per_page'] = 10;
		$this->pagination->initialize($config);
		
		//Template::set_view('invoice_template');
		Template::set ('title', 'Invoices');
		Template::render ('member');
	}
	
	/**
	 * To display message to the member on email reply failure
	 * @param string $messsage
	 */
	function errorResponse ($messsage) {
		header('HTTP/1.1 500 Internal Server Error');
		die(json_encode(array('message' => $messsage)));
	}
	
	/**
	 * Verify captcha before proceeding
	 * @param string $fieldname for POST
	 * @return boolean
	 */
	public function check_captcha($fieldname) {
		$this->load->library ( 'securimage/securimage' );
		$securimage = new Securimage ();
		if (! $securimage->check ( $this->input->post ( $fieldname ) )) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	/**
	 * Send email to the user
	 */
	public function sendEmail() {
		$query_id = (int) $this->input->post ('query_id' );
		if($query_id == 0) {
			$this->errorResponse('Unable to send email, please try again later');
		}
		else {
			header('Content-Type: application/x-json; charset=utf-8');
			$emails = $this->business_queries_model->get_email_addresses($query_id);			
	
			//do Captcha check, make sure the submitter is not a robot:)...
			if(!$this->check_captcha('email_captcha_code')) {
				$this->errorResponse('Invalid Security Code');
			} else {
				// Send Email
				$this->load->library('emailer/emailer');
				$message = $this->input->post('email_message') .'<hr><br />' .settings_item('site.title') .'<br />' .site_url();
				$data = array(
						'to'		=> $emails->email_to,
						'subject'	=> $this->input->post('email_subject'),
						'message'	=> $message
				);
				
				$success = $this->emailer->send($data, FALSE);
				if($success) {
				echo json_encode ( array (
						'message' => 'Your message has been sent successfully'
				) );
				} else {
					echo json_encode ( array (
							'message' => $this->email->print_debugger()
					) );
				}
			}
		}
	}
	
	/**
	 * Allow member to view their invoice in HTML format
	 * @param int $transaction_id to store transaction information
	 */
	public function view_invoice($transaction_id = NULL) {
		$this->auth->restrict();
		$transaction_info = $this->transactions_model->invoice($transaction_id, $this->auth->user_id());
		if($transaction_info) {
			$this->load->library('parser');
			
			switch ($transaction_info->status) {
				case 0:
					$status = '<span class="label label-info">'.lang('pending').'</span>';
					break;
				case 1:
					$status = '<span class="label label-success">'.lang('paid').'</span>';
					break;
				case 2:
					$status = '<span class="label label-warning">'.lang('cancelled').'</span>';
					break;
			}
			
			$data = array(
					'invoice' => $transaction_info->invoice,
					'payment_method' => ucwords(strtolower($transaction_info->payment_method)),
					'currency' => $transaction_info->currency,
					'amount' => floatval($transaction_info->amount),
					'quantity' => 1,
					'total'	=> settings_item('site.currency'),
					'order_date'	=> $transaction_info->received_on,
					'display_name'	=> $transaction_info->display_name,
					'email'	=> $transaction_info->email,
					'listing_title' => $transaction_info->listing_title,
					'package_title' => $transaction_info->package_title,
					'status' => $status,
					'url'	=> site_url('members/invoices')
			);
			$content = $this->parser->parse('invoice_template', $data, TRUE); //TRUE is important to return string
			Template::set(array(
					'title'	=> 'Invoice #' .$transaction_info->invoice,
					'content'=> $content
			));
			Template::render('member');
		} else {
			redirect(site_url('members'));
		}
	}
	
	/**
	 * Creates Invoice PDF invoice using TCPDF
	 * @package com.tecnick.tcpdf
	 * @abstract TCPDF - Example: Default Header and Footer
	 */	
	public function download_invoice($transaction_id = NULL) {
		$this->auth->restrict();
		$transaction_info = $this->transactions_model->invoice($transaction_id, $this->auth->user_id());
		if($transaction_info) {			
			$this->load->library("listings/Pdf");
			//Retrieve listing information from database
			
			// create new PDF document
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor(settings_item('site.title'));
			$pdf->SetTitle('Invoice No.:' .$transaction_info->invoice);
			$pdf->SetSubject('Invoice for purchase #' .$transaction_info->invoice);
			$pdf->SetKeywords(settings_item('site.title'));
			
			// set default header data
			$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', '', array(0,64,255), array(0,64,128));
			$pdf->setFooterData(array(0,64,0), array(0,64,128));
	
			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	
			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	
			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	
			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	
			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	
			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
				require_once(dirname(__FILE__).'/lang/eng.php');
				$pdf->setLanguageArray($l);
			}
	
			// ---------------------------------------------------------
	
			// set default font subsetting mode
			$pdf->setFontSubsetting(true);
	
			// Set font
			// dejavusans is a UTF-8 Unicode font, if you only need to
			// print standard ASCII chars, you can use core fonts like
			// helvetica or times to reduce file size.
			$pdf->SetFont('dejavusans', '', 10, '', true);
	
			// Add a page
			// This method has several options, check the source code documentation for more information.
			$pdf->AddPage();
	
			// set text shadow effect
			$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
	
			// Set content to print
			$this->load->library('parser');
			switch ($transaction_info->status) {
				case 0:
					$status = '<span class="label label-info">'.lang('pending').'</span>';
					break;
				case 1:
					$status = '<span class="label label-success">'.lang('paid').'</span>';
					break;
				case 2:
					$status = '<span class="label label-warning">'.lang('cancelled').'</span>';
					break;
			}
			$data = array(
					'invoice' => $transaction_info->invoice,
					'payment_method' => ucwords(strtolower($transaction_info->payment_method)),
					'currency' => $transaction_info->currency,
					'amount' => $transaction_info->amount,
					'quantity' => 1,
					'total'	=> settings_item('site.currency'),
					'order_date'	=> $transaction_info->received_on,
					'display_name'	=> $transaction_info->display_name,
					'email'	=> $transaction_info->email,
					'listing_title' => $transaction_info->listing_title,
					'package_title' => $transaction_info->package_title,			
					'url'	=> site_url(),
					'status' => $status
			);
			//TCPDF does not support external css files, therefore, different template is created for invoice download
			$content = $this->parser->parse('pdf_invoice_template', $data, TRUE); //TRUE is important to return string
	
			$html = <<<EOD
    			$content
	
EOD;
	
			// Print text using writeHTMLCell()
			$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
	
			// Close and output PDF document
			// This method has several options, check the source code documentation for more information.
			$pdf->Output(settings_item('site.title') . ' Invoice ' .$transaction_info->invoice .'.pdf', 'D');
	
			//============================================================+
			// END OF FILE
			//============================================================+
		} else {
			redirect(site_url('members'));
		} 
	}
}