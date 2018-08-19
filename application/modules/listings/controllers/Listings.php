<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Listings extends Front_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('listings_model', null, true);
		$this->load->model('products_model');
		$this->load->model('images_model');
		$this->load->model('videos_model');
		$this->load->model('classifieds_model');
		$this->load->model('business_hours_model');
		$this->load->model('comments/comments_model');
		$this->load->model('categories/categories_model');
		$this->load->model('ratings_model');
		$this->load->model('business_queries_model');
		$this->load->model('claim_reports/claim_reports_model');
		$this->load->model('users/user_model');
		$this->load->model('tags/tags_model');
		$this->load->model('banners/banners_model');
		$this->load->model('pages/pages_model');
		/*if($this->input->cookie('language')) {
			$this->lang->load('listings', $this->input->cookie('language'));
		}
		else {
			$this->lang->load('listings');
		}*/
		
		$this->load->library('users/auth');		

		//rating star
		Assets::add_js('star-rating.min.js');
		Assets::add_css('star-rating.min.css');
		
		//phone number verification
		Assets::add_js('intlTelInput.min.js');
		Assets::add_css('intlTelInput.css');
		
		//gallery
		Assets::add_css('main.css');
		Assets::add_js('jquery.prettyPhoto.js');
		Assets::add_js('main.js');
		Assets::add_js('plugins.js');
	}
	
	/**
	 * Show Listing Detail to the User
	 * @param string $slug
	 */
	public function detail($slug)
	{
		$this->load->model('users/user_model');
		Assets::add_js( $this->load->view('listings_js', null, true ), 'inline' );
		Assets::add_module_js('listings', 'business_hours_tooltip.js');
		// get all characters from right to left till first dash to get listing id
		if(settings_item('lst.allow_sms') == 1) {
			Assets::add_js( $this->load->view('sms_js', null, true ), 'inline' );
		}
		if(settings_item('lst.allow_email') == 1) {
			Assets::add_js( $this->load->view('email_js', null, true ), 'inline' );
		}
		$id = (int)substr( $slug, strrpos( $slug, '-' ) + 1);
		
		if(settings_item('site.enable_cache') == 1) { 
			$cacheID = str_replace('-', '_', $slug); // Cache giving errors when invalid url with spaces and special characters
			if(!$listings = $this->zf_cache->load($cacheID)) {
				if((int)$id) {
					$listings = $this->listings_model->get_listing($id);
					$actual_slug = $listings->slug .'-in-' .strtolower(str_replace(" ","-", $listings->city)).'-' .$listings->id;
					if($listings && ($actual_slug != $this->uri->segment(2))) {
						redirect(site_url('detail/' .$actual_slug));
					}
					$this->zf_cache->save($listings, $cacheID);
				} else {
					show_404();
				}
			}
		} else {
			if((int)$id) {
				$listings = $this->listings_model->get_listing($id);
				$actual_slug = $listings->slug .'-in-' .strtolower(str_replace(" ","-", $listings->city)).'-' .$listings->id;
				if($listings && ($actual_slug != $this->uri->segment(2))) {
					redirect(site_url('detail/' .$actual_slug));
				}
			} else {
				show_404();
			}
		}

		$this->load->model('packages/packages_model');
		$package = $this->packages_model->select('claim_price, address, email, website, map, logo, phone, person, border_color')->find($listings->package_id);
		$banners = $this->banners_model->get_frontend_banners_all();
		$categories = $this->categories_model->get_breadcrumb($listings->category_id);
		$products = $this->products_model->find_all_by(array('listing_id' => $id, 'active' => 1));
		$products_count = $this->products_model->count_by(array('listing_id' => $id, 'type' => 'product', 'active' => 1));
		$services_count = $this->products_model->count_by(array('listing_id' => $id, 'type' => 'service', 'active' => 1));
		$images = $this->images_model->find_all_by(array('listing_id' => $id, 'active' => 1));
		$videos = $this->videos_model->find_all_by(array('listing_id' => $id, 'active' => 1));
		$classifieds = $this->classifieds_model->find_all_by(array('listing_id' => $id, 'active' => 1));
		$business_hours = $this->business_hours_model->select('day_of_week, open_time, close_time')->find_all_by('listing_id', $id);

		/* ------------------- GOOGLE MAP -----------------------*/
		if((isset($listings->latitude)) && (isset($listings->longitude))) {
			$this->load->library('googlemaps');
			
			$config['center'] = $listings->latitude .', ' .$listings->longitude;
			$config['zoom'] = 12;
			$this->googlemaps->initialize($config);
			
			$marker = array();
			$marker['position'] =  $listings->latitude .', ' .$listings->longitude;
			$this->googlemaps->add_marker($marker);
			$map = $this->googlemaps->create_map();
			Template::set('map', $map);
		}
		/* ------------------- END GOOGLE MAP --------------------*/
		$ratings = $this->ratings_model->select('average_rating, total_ratings, total_users')->find_by('listing_id', $id);
		$comments = $this->comments_model->where(array('comments.listing_id' => $id, 'comments.status' => 1, 'comments.deleted' => 0))->get_comments();
		
		// update listing hits
		$this->listings_model->updateHits($id);
		
		if(!empty($listings->meta_title)) {
			$page_title = $listings->meta_title;
		} else {
			$page_title = $listings->title.' in ' .$listings->city;
		}
		
		if(!empty($listings->meta_description)) {
			$page_description = $listings->meta_description;
		} else {
			$last_space = strrpos( substr( $listings->description, 0, 200 ), ' ' ); // find the last space within 35 characters
			$page_description = strip_tags(substr( $listings->description, 0, $last_space ) . '...');
		}
		
		if(settings_item('adv.search_blocks') == 1) {
			Template::set('default_city', $listings->city_id);			
		} else {
			Template::set('search_location', $listings->city);
			if(settings_item('adv.search_blocks') == 2) {
				$search_category = $this->categories_model->select('parent_id')->find_by('id', $listings->category_id);
				if($search_category->parent_id != 0 ) {
					$search_category = $search_category->parent_id;
				} else {
					$search_category = $listings->category_id;
				}
				Template::set('search_category', $search_category);
			}
		}		
		
		Template::set(array(
							'page_title' => $page_title,
							'page_description' => $page_description,
							'listing'=> $listings, 
							'package' => $package,
							'products' => $products,
							'products_count' => $products_count,
							'services_count' => $services_count, 
							'categories' => $categories,
							'images' => $images,
							'videos' => $videos,
							'classifieds'	=> $classifieds,
							'business_hours' => $business_hours,
							'ratings'	=> $ratings,
							'comments' => $comments,
							'banners'	=> $banners,
							'searchterm' => $listings->title
		));
		
		/** Get payment gateways. Display payment selection option to user at the end of form
		 * if package has a price associated with it*/
		if($package->claim_price >= 0) {
			$this->load->model('payment_gateways/payment_gateways_model');
			$payment_gateways = $this->payment_gateways_model->select('name, display_name')->find_all_by(array('active' => 1));
			Template::set (array (
				'payment_gateways' => $payment_gateways,
				'price'	=> $package->claim_price
			));
		}

		// for email form
		if($this->session->userdata('user_id')) {
			$user_info = $this->user_model->select('email, display_name, mobile_number')->find($this->session->userdata('user_id'));
			Template::set('user_info', $user_info);
		}
		if (isset ( $_POST ['claimListing'] )) {
			// Price is greater than zero
			if($package->claim_price > 0 ) {
				$transaction_id = $this->insert_transaction($id, $listings->package_id, $this->input->post('payment_mode'), $package->claim_price);
				// set temporary session in order to update transaction status after payment
				$this->session->set_userdata('transaction_id', $transaction_id); // flashdata was not working
				$this->session->set_userdata('claimed_listing_id', $id);
				$this->session->set_flashdata('amount', $package->claim_price); // pass amount to payment gateway
				redirect('payment_gateways/' .$this->input->post('payment_mode'));
			} else {				
				$claim_data['listing_id'] = $id;
				$claim_data['user_id']	= $this->session->userdata('user_id');
				$claim_data['type']	= 1;
				$claim_data['description']	= lang('claim_description');
				$claim_data['name']	= $user_info->display_name;
				$claim_data['email'] = $user_info->email;
				$claim_data['phone'] = $user_info->mobile_number;
				$claim_data['ip'] = $this->input->ip_address();
				$this->load->model('claim_reports/claim_reports_model');
				$claim_insert_id = $this->claim_reports_model->insert($claim_data);
				if($claim_insert_id) {
					Template::set_message(lang('claim_request_success'), 'success');
				} else {
					Template::set_message(lang('claim_request_error'), 'error');
				}			
			}
		}
		
		switch(settings_item('lst.featured_location')) {
			case 1:
			case 4:
			case 6:
			case 7:
				Template::set('featured_listings', $this->featured_listings());
				break;
		}
		
		switch(settings_item('lst.popular_location')) {
			case 1:
			case 4:
			case 6:
			case 7:
				Template::set('popular_listings', $this->popular_listings());
				break;
		}
		
		switch(settings_item('lst.recently_added_location')) {
			case 1:
			case 4:
			case 6:
			case 7:
				Template::set('recently_added', $this->recently_added());
				break;
		}
		
		if(settings_item('lst.related_links_location') == 1) {
			Template::set('related_links', $this->related_listings($listings->id, $listings->category_id));
		}
		Template::render();
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
		$data['invoice']        = $invoice_value[0]->invoice + 1; // last invoice plus 1
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
	 * Deal with AJAX error responses 
	 * @param string $message
	 * 
	 */
	function errorResponse ($messsage) {
		header('HTTP/1.1 500 Internal Server Error');
		die(json_encode(array('message' => $messsage)));
	}
	
	/**
	 * BUSINESS ENQUIRY FORM
	 * Send enquiry to business owner
	 * 
	 */	
	public function business_query()
	{
		//important to include because of json
		header('Content-Type: application/x-json; charset=utf-8'); 
		
		//do Captcha check, make sure the submitter is not a robot:)...
		if(!$this->check_captcha('captcha_code')) {
			$this->errorResponse(lang('error_invalid_captcha'));
		}
		
		$listing_id = escape($this->input->post ( 'listing_id' ));
		$customer_name = escape($this->input->post ( 'name' ));
		$customer_phone = escape($this->input->post ( 'phone' ));
		$customer_email = escape($this->input->post ( 'email' ));
		$customer_message = escape($this->input->post ( 'message' ));
		// insert into database
		$data = array (
				'listing_id' => $listing_id,
				'name' => $customer_name,
				'phone' => $customer_phone,
				'email' => $customer_email,
				'message' => $customer_message,
				'ip'	=> $this->input->ip_address()
		);
		
		if($this->session->userdata('user_id')) {
			$data['user_id'] = $this->session->userdata('user_id');
		}
		
		if ($id = $this->business_queries_model->insert( $data )) {
			echo json_encode ( array (
					'message' => lang('success_message')
			) );
		} else {
			echo json_encode ( array (
					'message' => lang('failure_message') 
			) );
		}
		
		if(settings_item('lst.query_email_notification') == 1) {
			// Retrieve template from database
			$this->load->model('email_templates/email_templates_model');
			$email_template = $this->email_templates_model->select('subject, message')->find(9);
			
			//Retrieve listing information from database
			$listing_info = $this->listings_model->get_listing_detail($listing_id);
			
			// Message
			$this->load->library('parser');
			$subject_data = array(
					'subject' => $email_template->subject,
					'site_title'	=> settings_item('site.title')
			);
			$subject = $this->parser->parse('email_templates/email_subject', $subject_data, TRUE);
			
			$owner_message_data = array(
					'message' => $email_template->message,
					'title'	=> $listing_info->title,
					'contact_person' => !empty($listing_info->contact_person) ? $listing_info->contact_person :'Sir',
					'customer_name' => $customer_name,
					'custome_phone' => $customer_phone,
					'customer_email' => $customer_email,
					'customer_message' => $customer_message,
					'listing_url'	=> site_url('/detail/' .$listing_info->slug. '-in-' .strtolower(str_replace(" ","-", $listing_info->city)) .'-' .$listing_id),
					'url'	=> site_url()
			);
			$owner_email = $this->parser->parse('email_templates/email_body', $owner_message_data, TRUE); //TRUE is important to return string
			
			// Send Email
			$this->load->library('emailer/emailer');
			$data = array(
					//'from'		=> $customer_email, 
					'to'		=> $listing_info->email,
					'subject'	=> $subject,
					'message'	=> $owner_email
			);
			$this->emailer->send($data, FALSE);
			
			// Customer Email
			$customer_email_template = $this->email_templates_model->select('subject, message')->find(10);
			$customer_subject_data = array(
					'subject' => $customer_email_template->subject,
					'site_title'	=> settings_item('site.title')
			);
			
			$customer_subject = $this->parser->parse('email_templates/email_subject', $customer_subject_data, TRUE);
			$customer_message_data = array(
					'message_II' => $customer_email_template->message,
					'title'	=> $listing_info->title,
					'name' => $customer_name,
					'listing_url'	=> site_url('/detail/' .$listing_info->slug. '-in-' .strtolower(str_replace(" ","-", $listing_info->city)) .'-' .$listing_id),
					'url'	=> site_url()
			);
			$customer_data = array(
					//'from'		=> $listing_info->email,
					'to'		=> $customer_email,
					'subject'	=> $subject,
					'message'	=> $this->parser->parse('email_templates/email_body_II', $customer_message_data, TRUE)
			);
			$this->emailer->send($customer_data, FALSE);
		}
	}
	
	/**
	 * COMMENT FORM
	 * Allow users to post comment on listing
	 */
	public function review()
	{
		// important to include because of json
		header('Content-Type: application/x-json; charset=utf-8'); 
	
		// do Captcha check, make sure the submitter is not a robot:)...
		if(!$this->check_captcha('review_captcha_code')) {
			$this->errorResponse(lang('error_invalid_captcha'));
		}
	
		// insert comment into database
			$data = array (
					'listing_id' => escape($this->input->post ( 'listing_id' )),
					'username' => escape($this->input->post ( 'user_name' )),
					'title' => escape($this->input->post ( 'review_title' )),
					'comment' => escape($this->input->post ( 'review_message' )),
					'ip'	=> $this->input->ip_address(),
			);
			
			if($this->session->userdata('user_id')) {
				$data['user_id'] = $this->session->userdata('user_id');
			}
		
			if ($id = $this->comments_model->insert( $data )) {
				echo json_encode ( array (
						'message' => lang('success_message')
				) );
			} else {
				echo json_encode ( array (
						'message' => lang('failure_message')
				) );
			}
	}
	
	/**
	 * CLAIM/REPORT FORM
	 * Allow users to claim or send report for the incorrect information 
	 * Called by AJAX
	 */
	public function claim_report()
	{
		header('Content-Type: application/x-json; charset=utf-8'); 
	
		// do Captcha check, make sure the submitter is not a robot:)...
		if(!$this->check_captcha('claim_report_captcha_code')) {
			$this->errorResponse('Invalid Security Code');
		}
		// insert claim information into database
		$data = array (
				'listing_id' => escape($this->input->post ( 'listing_id' )),
				'type' => escape($this->input->post ( 'claim_report_type' )),
				'description' => escape($this->input->post ( 'claim_report_description' )),
				'name' => escape($this->input->post ( 'claim_report_name' )),
				'email' => escape($this->input->post ( 'claim_report_email' )),
				'phone' => escape($this->input->post ( 'claim_report_phone' )),
				'ip'	=> $this->input->ip_address(),
		);
	
		if($this->session->userdata('user_id')) {
			$data['user_id'] = $this->session->userdata('user_id');
		}
	
		if ($id = $this->claim_reports_model->insert( $data )) {
			echo json_encode ( array (
					'message' => lang('success_message')
			) );
		} else {
			echo json_encode ( array (
					'message' => lang('failure_message')
			) );
		}
	}
	
	/**
	 * Display captcha to the user
	 * securimage plugin is used to implement below given function
	 * 
	 */
	public function securimage() {
		$this->load->config ( 'csecurimage' );
		$active = $this->config->item ( 'si_active' );
		$allsettings = array_merge ( $this->config->item ( $active ), $this->config->item ( 'si_general' ) );
		$this->load->library ( 'securimage/securimage' );
		$img = new Securimage ( $allsettings );
		$img->show ( APPPATH . 'libraries/securimage/backgrounds/bg4.png' );
	}
	
	/**
	 * Check user entered captcha against provided image
	 * @param string $fieldname ($this->input->post())
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
	 * KAPSYSTEM SEND SMS FUNCTION 
	 * PHP code provided by KapSystem
	 * @param string $url
	 * 
	 */
	public function kapsystem_openurl($url) {
	    if(is_callable("curl_exec"))  {
		    // Use CURL if its available
		    $ch = @curl_init($url);
		    curl_setopt($ch, CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    $result = curl_exec($ch);
	    } else {
	    // Use fopen instead
	    if($fp = @fopen($url, "rb")) {
		    $result = "";
		    while(!feof($fp)) {
		    	$result .= fgets($fp, 4096);
		    }
	    	@fclose($fp);
	    }
	   }
	}
	
	/**
	 * Allow users to send Email
	 * @return JsonResponse
	 */ 
	public function sendEmail() {
		$listing_id = $this->input->post ('listing_id' );
		if(!($listing_id)) {
			$this->errorResponse('Unable to send email, please try again later');
		}
		else {
			header('Content-Type: application/x-json; charset=utf-8'); 
			if(!$this->check_captcha('email_captcha_code')) {
				$this->errorResponse('Invalid Security Code');
			} else {				
				// Retrieve template from database
				$this->load->model('email_templates/email_templates_model');
				$email_template = $this->email_templates_model->select('subject, message')->find(1);
				
				//Retrieve listing information from database
				$listing_info = $this->listings_model->find($listing_id);			
						
				// Message
				$this->load->library('parser');
				$subject_data = array(
					'subject' => $email_template->subject,
					'from'	=> escape($this->input->post('email_from_name'))
				);
				$subject = $this->parser->parse('email_templates/email_subject', $subject_data, TRUE);
				
				$message_data = array( 
						'message' => $email_template->message,
						'title'		=> $listing_info->title,
						'address'	=> $listing_info->address,
						'contact_person' => $listing_info->contact_person,
						'mobile_number'	=> $listing_info->mobile_number,
						'email'	=> $listing_info->email,
						'url'	=> site_url('/listings/detail/' .$listing_id)
				);
				$email = $this->parser->parse('email_templates/email_body', $message_data, TRUE); //TRUE is important to return string
				
				// Send Email
				$this->load->library('emailer/emailer');
				$data = array(
						//'from'		=> escape($this->input->post('email_from')), //. ', ' .$this->input->post('email_from_name'),
						'to'		=> escape($this->input->post('email_to')),
						'subject'	=> $subject,
						'message'	=> $email
				);
				
				$success = $this->emailer->send($data, FALSE);
				echo json_encode ( array (
						'message' => lang('success_message')
					) );		
			}
		}	
	}

	/**
	 * Allow users to rate listing
	 * @param int $listing_id
	 * @return JsonResponse
	 * 
	 */
	public function star_rating()
	{
		$listing_id = $this->input->post("listing_id");
		header('Content-Type: application/x-json; charset=utf-8'); 
		$ip_address = $this->input->ip_address(); 
		$new_rating = $this->input->post("ratings", true);
		//Get current rated values
		$current_rating = $this->ratings_model->find_by('listing_id', $listing_id);
			
		// Match user system ip address with existing records
		if ($current_rating) { // Entry exist for specified listing
			$existing_ip_addresses = explode ( ', ', $current_rating->used_ips ); // Get list of all IP addresses
			if ((!$this->match_ip_address ( $existing_ip_addresses, $ip_address ))) {
				$data ['total_ratings'] = $current_rating->total_ratings + $new_rating; // Get existing ratings and increment with new rating
				$data ['total_users'] = $current_rating->total_users + 1; // Increment users by one
				$data ['average_rating'] = $data ['total_ratings'] / $data ['total_users'];
				$this->db->set('used_ips' , "CONCAT(used_ips,". "', " .$ip_address ."')", false); // Append IP Address
				if ($this->ratings_model->update( $current_rating->id, $data)) { // Update rating information
					echo json_encode ( array (
							"result" => "<span class=\"label label-success\">".lang('success_rating')."</span>"
					) );
				} else {
					echo json_encode ( array (
							"result" => "<span class=\"label label-warning\">".lang('error_rating')."</span>"
					) );
				}
			} else {
				echo json_encode ( array (
						"result" => "<span class=\"label label-warning\">".lang('failure_rating')."</span>"
				) );
			}
		}
	
		else { // User is rating first time for this listing
			$data['listing_id']		= $listing_id;
			$data ['average_rating'] = $new_rating;
			$data ['total_ratings'] = $new_rating;
			$data ['total_users'] = 1;
			$data ['used_ips'] = $ip_address;
			if ($this->ratings_model->insert($data)) { // Update rating information
				echo json_encode ( array (
						"result" => lang('success_rating')
				) );
			} else {
				echo json_encode ( array (
						"result" => lang('error_rating')
				) );
			}
		}
	
	}
	
	/**
	 * Restrict user to rate only once based on their IP address. 
	 * Match IP address with existing database
	 * @param array $existing_ip_addresses
	 * @param string $new_ip_address
	 * @return boolean
	 */
	public function match_ip_address($existing_ip_addresses, $new_ip_address)
	{
		foreach($existing_ip_addresses as $ip_addresses) {
			if(strpos($ip_addresses,$new_ip_address) !== false) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * CREATE PDF FILE
	 * Creates a Business Listing PDF document using TCPDF
	 * @package com.tecnick.tcpdf
	 * @abstract TCPDF - Example: Default Header and Footer
	 */	
	public function create_pdf($slug = NULL) {
		// get all characters from right to left till first dash to get listing id
		$listing_id = substr( $slug, strrpos( $slug, '-' ) + 1);
		if((int)$listing_id == NULL) {
			redirect(site_url());	
		} else {
		$this->load->library("Pdf");
		
		//Retrieve listing information from database
		$listing_info = $this->listings_model->get_listing_detail($listing_id);
		
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor(settings_item('site.title'));
		$pdf->SetTitle($listing_info->title);
		$pdf->SetSubject($listing_info->title);
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
		$pdf->SetFont('dejavusans', '', 14, '', true);
	
		// Add a page
		// This method has several options, check the source code documentation for more information.
		$pdf->AddPage();
	
		// set text shadow effect
		$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
	
		// Set content to print
		$this->load->library('parser');
		$data = array(
				'title'		=> $listing_info->title,
				'address'	=> $listing_info->address,
				'contact_person' => $listing_info->contact_person,
				'mobile_number'	=> $listing_info->mobile_number,
				'email'	=> $listing_info->email,
				'url'	=> site_url('detail/' .$listing_info->slug.'-in-'.strtolower($listing_info->city) .'-'.$listing_id)
		);
		$content = $this->parser->parse('pdf_template', $data, TRUE); //TRUE is important to return string
		
		$html = <<<EOD
    			$content

EOD;
	
		// Print text using writeHTMLCell()
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
	
		// ---------------------------------------------------------
	
		// Close and output PDF document
		// This method has several options, check the source code documentation for more information.
		$pdf->Output($listing_info->title. '.pdf', 'D');
		}
	}
	
	/**
	 * Category Browsing
	 * @param string $slug
	 * @param int $offset for pagination
	 */
	public function category($slug, $offset = 0) {
		Assets::add_js( $this->load->view('view_js', null, true ), 'inline' );
		
		// get all characters from right to left till first dash to get listing id
		$id = substr( $slug, strrpos( $slug, '-' ) + 1);
		if((int)$id) {
			$check_existence = $this->categories_model->find_by(array('id' => $id, 'active' => 1));			
			if($check_existence) {
				$actual_slug = $check_existence->slug .'-' .$check_existence->id;
				if($actual_slug != $this->uri->segment(2)) {
					redirect(site_url('category/' .$actual_slug));
				}
			} else {
				show_404();
			}			
		} else {
			show_404();
		}
		
		$this->load->helper('array');
		$limit = 10;
		$row_limit = 10;
		$sort_by = 'rating_default';
		
		// Allow user to select number of rows
		if (isset($_POST['selectRows'])){
			$limit = $this->input->post('selectRows');
			$row_limit = $limit;
			$this->session->set_userdata('rows_limit', $limit);
		} else if ($this->session->userdata('rows_limit')) {
			$limit = $this->session->userdata('rows_limit');
			$row_limit = $limit;
		}
		
		if (isset($_POST['sortBy'])){
			$sort_by = $this->input->post('sortBy');
			$this->session->set_userdata('sort_by', $sort_by);
		} else if ($this->session->userdata('sort_by')) {
			$sort_by = $this->session->userdata('sort_by');
		}
		
		/**
		 * FEATURED LISTINGS
		 */
		
		// get total number of listings to be displayed from settings
		$total_featured = (int)settings_item('lst.top_featured_count') + (int)settings_item('lst.right_featured_count');
		
		// get_category_listings(category id, transaction status, locality and limit)
		$featured_listings = $this->listings_model->get_category_listings($id, 1, 0, $sort_by, $total_featured);
				
		// Count total featured listings  and decrement limit by them
		$featured_listings_count = count($featured_listings);
		
		$random_featured = array();
		$top_featured = array(); // to store top featured listings
		$right_featured = array(); // to store right hand featured listings
		
		// compare total featured count to user specified top featured counts
		if(($featured_listings) && ($featured_listings_count > (int)settings_item('lst.top_featured_count'))) {
			if($featured_listings_count >= $total_featured) {
				$random_featured = $this->array_random_assoc($featured_listings, $total_featured); // get random values from array
			} else {
				$random_featured = $this->array_random_assoc($featured_listings, $featured_listings_count);
			}
			usort($random_featured, array('listings', 'sortByPrice'));
			$top_featured = array_slice($random_featured, 0, (int)settings_item('lst.top_featured_count')); // split array starting from 0
			$right_featured = array_slice($random_featured, (int)settings_item('lst.top_featured_count')); // split array starting from 2
			$limit = $limit - (int)settings_item('lst.top_featured_count');
		} else if(($featured_listings) && ($featured_listings_count <= (int)settings_item('lst.top_featured_count'))) {
			$top_featured = $featured_listings;
			$limit = $limit - $featured_listings_count;
		}
		
		$listings = $this->listings_model->get_category_listings($id, 0, 0, $sort_by, $limit, $offset);
		$listings_array = (array) $listings; // Convert object to array
		
		// Merge top featured and listings results array
		$result = array_merge($top_featured, $listings);
		
		$banners = $this->banners_model->get_frontend_category_banners($id); // retrieve banners
		
		//footer pages link
		$pages = $this->pages_model->get_links();
		
		// Pagination
		$this->load->library('pagination');
		$total_listings = $this->listings_model->count_by(array(
				'category_id' => $id,
				'deleted'	=> 0,
				'spammed'	=> 0,
				'active'	=> 1
		));
		$this->config->load("pagination");
		$config['base_url'] = base_url()."category/" . $check_existence->slug .'-' .$id;
		$config['total_rows'] = $this->listings_model->count_total_category_listings($id);//count($all_listings);
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);
		
		// update category hits
		$this->categories_model->updateHits($id);
		Template::set(array(
			'page_title' => $check_existence->meta_title,
			'page_keywords' => $check_existence->meta_keywords,
			'page_description' => $check_existence->meta_description,
			'title' => $check_existence->name,
			'searchterm' => $check_existence->name,
			'description' => $check_existence->description,
			'top_featured' => $top_featured,
			'listings'=> $listings,
			'banners' => $banners,
			'limit'		=> $row_limit, // set dropdown field value
			'sort_by'	=> $sort_by,
			'footer_links'	=> $pages,
			'featured_listings' => $right_featured,
			'popular_listings' => $this->popular_listings(),
			'recently_added' => $this->recently_added()
		));
		
		// right hand categories
		$child_categories = $this->categories_model->select('id, name, slug, counts')->find_all_by(array('active' => 1, 'parent_id' => $id));
		if($child_categories) {
			Template::set(array('child_categories' => $child_categories, 'category_heading' => $check_existence->name));
		}
		
		// right hand categories
		$categories = $this->categories_model->select('id, name, slug, counts')->find_all_by(array('active' => 1, 'parent_id' => 0));
		if($categories) {
			Template::set('categories', $categories);
		}
		
		Template::set_view('view.php');
		Template::render();
	}
	
	/**
	 * Ajax function to loadSubCategories on user click
	 */
	public function loadSubCategories() {
		$parent_id = $this->input->post('id');
		$result = $this->categories_model->select('id, name, slug, counts')->order_by('name', 'asc')->find_all_by('parent_id', $parent_id);
		$output = json_decode(json_encode($result),true);
		echo json_encode($output);
	}
	
	/**
	 * Location Browsing
	 * @param string $slug
	 * @param int $offset for pagination
	 */
	public function location($slug, $offset = 0) {
		Assets::add_js( $this->load->view('view_js', null, true ), 'inline' );
	
		// get all characters from right to left till first dash to get listing id
		$id = substr( $slug, strrpos( $slug, '-' ) + 1);
		if((int)$id) {
			$check_existence = $this->cities_model->find($id);
			if($check_existence) {
				$actual_slug = str_replace(" ", "-", strtolower($check_existence->name)) .'-' .$check_existence->id;
				if($actual_slug != $this->uri->segment(2)) {
					$this->session->userdata('search_city', $id);
					redirect(site_url('location/' .$actual_slug));
				}
			} else {
				redirect(site_url());
			}
		} else {
			redirect(site_url());
		}
	
		$this->load->helper('array');
		$limit = 10;
		$row_limit = 10;
		$sort_by = 'rating_default';
		
		// Allow user to select number of rows
		if (isset($_POST['selectRows'])) {
			$limit = $this->input->post('selectRows');
			$row_limit = $limit;
			$this->session->set_userdata('rows_limit', $limit);
		} else if ($this->session->userdata('rows_limit')) {
			$limit = $this->session->userdata('rows_limit');
			$row_limit = $limit;
		}
		
		if (isset($_POST['sortBy'])){
			$sort_by = $this->input->post('sortBy');
			$this->session->set_userdata('sort_by', $sort_by);
		} else if ($this->session->userdata('sort_by')) {
			$sort_by = $this->session->userdata('sort_by');
		}
	
		/**
		 * FEATURED LISTINGS
		 */
	
		// get total number of listings to be displayed from settings
		$total_featured = (int)settings_item('lst.top_featured_count') + (int)settings_item('lst.right_featured_count');
	
		// get_category_listings(category id, transaction status, locality and limit)
		$featured_listings = $this->listings_model->get_location_listings($id, 1, 0, $sort_by, $total_featured);
	
		// Count total featured listings  and decrement limit by them
		$featured_listings_count = count($featured_listings);
	
		$random_featured = array();
		$top_featured = array(); // to store top featured listings
		$right_featured = array(); // to store right hand featured listings
	
		// compare total featured count to user specified top featured counts
		if(($featured_listings) && ($featured_listings_count > (int)settings_item('lst.top_featured_count'))) {
			if($featured_listings_count >= $total_featured) {
				$random_featured = $this->array_random_assoc($featured_listings, $total_featured); // get random values from array
			} else {
				$random_featured = $this->array_random_assoc($featured_listings, $featured_listings_count);
			}
			usort($random_featured, array('listings', 'sortByPrice'));
			$top_featured = array_slice($random_featured, 0, (int)settings_item('lst.top_featured_count')); // split array starting from 0
			$right_featured = array_slice($random_featured, (int)settings_item('lst.top_featured_count')); // split array starting from 2
			$limit = $limit - (int)settings_item('lst.top_featured_count');
		} else if(($featured_listings) && ($featured_listings_count <= (int)settings_item('lst.top_featured_count'))) {
			$top_featured = $featured_listings;
			$limit = $limit - $featured_listings_count;
		}
		$listings = $this->listings_model->get_location_listings($id, 0, 0, $sort_by, $limit, $offset);
		$listings_array = (array) $listings; // Convert object to array
	
		// Merge top featured and listings results array
		$result = array_merge($top_featured, $listings);
	
		$banners = $this->banners_model->get_banners_by_city($id); // retrieve banners
	
		//footer pages link
		$pages = $this->pages_model->get_links();
	
		// Pagination
		$this->load->library('pagination');
		$total_listings = $this->listings_model->count_by(array(
				'city_id' => $id,
				'deleted'	=> 0,
				'spammed'	=> 0,
				'active'	=> 1
		));
		$this->config->load("pagination");
		$config['base_url'] = base_url()."location/" . str_replace(" ", "-", strtolower($check_existence->name)) .'-' .$id;
		$config['total_rows'] = $this->listings_model->count_total_location_listings($id);//count($all_listings);
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);
	
		$location_meta_title = 'Recommended '.$check_existence->name.' Companies.';
		$location_meta_description = 'Find companies in '.$check_existence->name.'. See reviews and contact details including website, email and phone number.';
		// update category hits
		$this->listings_model->updateHits($id, 'cities');
		Template::set(array(
			'search_location' => $check_existence->name,
			'page_title' => $location_meta_title,
			'page_description' => $location_meta_description,
			'top_featured' => $top_featured,
			'listings'=> $listings,
			'banners' => $banners,
			'limit'		=> $row_limit, // set dropdown field value
			'sort_by'	=> $sort_by,
			'title' => $check_existence->name,
			'description' => $check_existence->description,
			'footer_links'	=> $pages,
			'featured_listings' => $right_featured,
			'popular_listings' => $this->popular_listings(),
			'recently_added' => $this->recently_added()
		));
	
		// right hand categories
		$categories = $this->categories_model->select('id, name, slug, counts')->find_all_by(array('active' => 1, 'parent_id' => 0));
		if($categories) {
			Template::set('categories', $categories);
		}
	
		Template::set_view('view.php');
		Template::render();
	}
	
	/**
	 * Allow user to browse by locations
	 */
	public function locations() {
		$this->load->model('locations/states_model');
		Assets::add_js( $this->load->view('locations_js', null, true ), 'inline' );
		$states = $this->states_model->order_by('name', 'asc')->find_all_by('active', 1);
		Template::set( array (
			'states' => $states
		));
		Template::render();
	}
	
	/**
	 * Ajax function to loadCities on user click
	 */
	public function loadCities() {
		$state_id = $this->input->post('id');
		$this->load->model('locations/cities_model');
		$result = $this->cities_model->select('id, name')->order_by('name', 'asc')->find_all_by('state_id', $state_id);
		$output = json_decode(json_encode($result),true);
		echo json_encode($output);
	}
	
	/**
	 * Search or browse listing using Tag name or ID
	 * @param string $city
	 * @param string @search_string actual keyword
	 * @param int @offset for pagination
	 * 
	 */
	public function search($city = NULL, $search_string = NULL, $offset = 0 ) {
		Assets::add_js( $this->load->view('view_js', null, true ), 'inline' );
		$this->load->model('locations/cities_model');
		/**
		 * On search submit, handle settings as per search_block configuration
		 * If user enabled locality or area information, store and process locality_id
		 * Else deal with search location and category ID
		 */
		if(isset($_POST['searchSubmit'])) {
			$this->load->library('form_validation');			
			$this->form_validation->set_rules('search', 'search', 'trim|required|min_length[2]|sanitize');
			if ($this->form_validation->run() == FALSE) {
				redirect(site_url());
			} else {						
				$search_string = $this->searchterm_handler($this->input->get_post('search', TRUE));
				$search_city = $this->cities_model->find($this->session->userdata('search_city'));
				if(settings_item('adv.search_blocks') == 1) {									
					if($search_city) {
						$search_city = strtolower(str_replace(" ","-", $search_city->name));
						$search_locality = $this->locality_handler($this->input->get_post('select-locality'));
						if($search_locality != -1) {
							redirect(base_url('search/' .str_replace(" ","-", $search_city).'/' .$this->slugify($this->input->post('search')). '-l0t0'));
						} else {
							redirect(base_url('search/' .str_replace(" ","-", $search_city).'/' .$this->slugify($this->input->post('search')). '-l0t0'));
						}
					}					
				} else {
					if(settings_item('adv.search_blocks') == 2) {
						$search_category = $this->category_handler(escape($this->input->get_post('select-category')));
					}
					$search_city = $this->slugify($this->input->post('location'));
					$redirect_url = site_url('search/' . $search_city . '/' . $this->slugify($this->input->post('search')). '-l0t0');
					redirect($redirect_url);
				}
			}
		} else if($city && $search_string) { // check whether user passed arguments or not
			$this->location_handler($city);
			// get all characters from right to left till first dash
			$str = substr( $search_string, strrpos( $search_string, '-' ) + 1);
			
			// search parameters
			$from ="l";
			$to ="t";
			
			// get integer value between l and t
			$sub = substr($str, strpos($str,$from)+strlen($from),strlen($str));
			
			// extract locality id from locality_output
			$locality_id = substr($sub,0,strpos($sub,$to));
			if(((string)(int)$locality_id !== $locality_id)) { // check whether returned string contains integer value or not
				redirect(site_url());
			} else if ($locality_id == "") {
				redirect(site_url());
			}
			
			// extract tag id information
			$get_tag_id = substr( $str, strrpos( $str, 't' ) + 1);
			if($get_tag_id != 0) {
			$check_tag = $this->tags_model->select('id')->find($get_tag_id);
				if($check_tag) {
					$tag_id = $check_tag->id;
				} else {
					redirect(site_url()); // unable to find tag specified city
				}
			} else {
				$tag_id = $get_tag_id;
			}
			
			if(settings_item('adv.search_blocks') == 1) {
				// user wants to search in a particular area
				if($locality_id != 0) {
					// find whether the city and locality id has relation and match
					$city_locality = $this->cities_model->get_city_locality($city, $locality_id);
					if($city_locality) {
							$this->session->set_userdata('search_city', $city_locality->city_id);
							$default_city = $city_locality->city_id;
							
							$search_city = strtolower($city_locality->city_name);
							// set locality session
							$search_locality = $this->locality_handler($city_locality->locality_id);					
					} else {
						redirect(site_url()); // unable to find locality in specified city
					}
				} else { // user wants to search in all areas
						$city_locality = $this->cities_model->select('id as city_id, name as city_name')->find_by(array('name' => str_replace("-"," ",$city)));
						if($city_locality) {
							$this->session->set_userdata('search_city', $city_locality->city_id);
							$default_city = $city_locality->city_id;					
								
							$search_city = strtolower($city_locality->city_name);
							// set locality session
							$search_locality = $this->locality_handler(-1);
						} else {
							redirect(site_url()); // unable to find specified city
						}
				} 
			} else {
				$search_locality = 0;
				$default_city = str_replace('-', '_', $city);
			}
			// get all characters upto last dash
			$keyword_output = substr( $search_string, 0, strrpos( $search_string, '-' ) );
				
			// remove all dashes
			$search_keyword = str_replace("-"," ",$keyword_output);
			if($this->session->userdata('search_term')) {
				$search_string = $this->session->userdata('search_term');
			} else {					
				// set search string in input box and session
				$search_string = $this->searchterm_handler($search_keyword);
			}
		} else { // city and locality information not provided
			redirect(site_url());
		}
		if(settings_item('adv.search_blocks') == 1) {
			// load localities based on country state or city availability
			$localities = $this->localities_model->select('id, name')->order_by('name')->find_all_by('city_id', $default_city);
		}
		
		$this->load->helper('array'); // object to array and array to object conversion
		$limit = 10;
		$row_limit = 10;
		$sort_by = 'rating_default';
		
		// Allow user to select number of rows
		if (isset($_POST['selectRows'])){
			$limit = $this->input->post('selectRows');
			$row_limit = $limit;
			$this->session->set_userdata('rows_limit', $limit);
		} else if ($this->session->userdata('rows_limit')) {
			$limit = $this->session->userdata('rows_limit');
			$row_limit = $limit;
		}
		
		if (isset($_POST['sortBy'])){
			$sort_by = $this->input->post('sortBy');
			$this->session->set_userdata('sort_by', $sort_by);
		} else if ($this->session->userdata('sort_by')) {
			$sort_by = $this->session->userdata('sort_by');
		}	
		$search_city = $default_city;
		
		/**
		 * Get all featured listings from the database and store them in a cache
		 * Select random from the cached item each time for pagination
		 */
		if(settings_item('adv.search_blocks') == 1) {
			if(($search_locality != -1) && ($tag_id == 0)) { // locality search
				$featured_listings = $this->listings_model->search_listings($search_string, $search_city, $search_locality, 0, 0, 1, $sort_by);
			} else if(($search_locality != -1) && ($tag_id != 0)) { // all localities
				$featured_listings = $this->listings_model->search_listings($search_string, $search_city, $search_locality, 0, $tag_id, 1, $sort_by);
			} else if (($search_locality == -1) && ($tag_id == 0)) {
				$featured_listings = $this->listings_model->search_listings($search_string, $search_city, 0, 0, 0, 1, $sort_by);
			} else if (($search_locality == -1) && ($tag_id != 0)) {
				$featured_listings = $this->listings_model->search_listings($search_string, $search_city, 0, 0, $tag_id, 1, $sort_by);
			}
		} elseif(settings_item('adv.search_blocks') == 2) {		
			$search_category = $this->session->userdata('search_category');	
			if(($search_category != -1) && ($tag_id == 0)) { // category search
				$featured_listings = $this->listings_model->search_listings($search_string, $search_city, 0, $search_category, 0, 1, $sort_by);
			} else if(($search_category != -1) && ($tag_id != 0)) { // all categories
				$featured_listings = $this->listings_model->search_listings($search_string, $search_city, 0, $search_category, $tag_id, 1, $sort_by);
			} else if (($search_category == -1) && ($tag_id == 0)) {
				$featured_listings = $this->listings_model->search_listings($search_string, $search_city, 0, 0, 0, 1, $sort_by);
			} else if (($search_category == -1) && ($tag_id != 0)) {
				$featured_listings = $this->listings_model->search_listings($search_string, $search_city, 0, 0, $tag_id, 1, $sort_by);
			}
		} else if(settings_item('adv.search_blocks') == 3) {
			if($tag_id == 0) {
				$featured_listings = $this->listings_model->search_listings($search_string, $search_city, 0, 0, 0, 1, $sort_by);
			} else {
				$featured_listings = $this->listings_model->search_listings($search_string, $search_city, 0, 0, $tag_id, 1, $sort_by);
			}
		}
			
		/**
		 * Count total featured listings and declare array for top, right and random featured.
		 * Random_featured array is to store featured listings which are randomly selected.
		 * Top_featured array will store top featured listings.
		 * Right_featured array is for right hand side featured listings.
		 * Compare total featured count to user specified top featured counts.
		 * Get total number of listings specified by the admin.
		 * If total number of featured listings is greater than total_random, get random values equal to total_random or else equal to featured_listings_count
		 */
		$listings_limit = $limit; 
		$random_featured = array();
		$top_featured = array();
		$right_featured = array();
		
		if($featured_listings) {
			$featured_listings_count = count($featured_listings);
			if($featured_listings_count > (int)settings_item('lst.top_featured_count')) {
				$total_random = (int)settings_item('lst.top_featured_count') + (int)settings_item('lst.right_featured_count');
				if($featured_listings_count >= $total_random) {
					$random_featured = $this->array_random_assoc($featured_listings, $total_random); // get random values from array
				} else {
					$random_featured = $this->array_random_assoc($featured_listings, $featured_listings_count);
				}				
				usort($random_featured, array('listings', 'sortByPrice'));
				$top_featured = array_slice($random_featured, 0, (int)settings_item('lst.top_featured_count')); // split array starting from 0
				$right_featured = array_slice($random_featured, (int)settings_item('lst.top_featured_count')); // split array starting from 2
				$listings_limit = $limit - (int)settings_item('lst.top_featured_count');
			} else {
				$top_featured = $featured_listings;
				$listings_limit = $limit - $featured_listings_count;
			}
		}
		
		/**
		 * Apply limit and offset
		 * Get remaining listings
		 */
		if(settings_item('adv.search_blocks') == 1) {
			if(($search_locality != -1) && ($tag_id == 0)) { // locality search
				$listings = $this->listings_model->search_listings($search_string, $search_city, $search_locality, 0, 0, 0, $sort_by, $listings_limit, $offset);
			} else if(($search_locality != -1) && ($tag_id != 0)) { // all localities
				$listings = $this->listings_model->search_listings($search_string, $search_city, $search_locality, 0, $tag_id, 0, $sort_by, $listings_limit, $offset);
			} else if (($search_locality == -1) && ($tag_id == 0)) {
				$listings = $this->listings_model->search_listings($search_string, $search_city, 0, 0, 0, 0, $sort_by, $listings_limit, $offset);
			} else if (($search_locality == -1) && ($tag_id != 0)) {
				$listings = $this->listings_model->search_listings($search_string, $search_city, 0, 0, $tag_id, 0, $sort_by, $listings_limit, $offset);
			}
		} elseif(settings_item('adv.search_blocks') == 2) {
			$search_category = $this->category_handler($this->input->get_post('select-category'));
			if(($search_category != -1) && ($tag_id == 0)) { // category search
				$listings = $this->listings_model->search_listings($search_string, $search_city, 0, $search_category, 0, 0, $sort_by, $listings_limit, $offset);
			} else if(($search_category != -1) && ($tag_id != 0)) { // all categories
				$listings = $this->listings_model->search_listings($search_string, $search_city, 0, $search_category, $tag_id, 0, $sort_by, $listings_limit, $offset);
			} else if (($search_category == -1) && ($tag_id == 0)) {
				$listings = $this->listings_model->search_listings($search_string, $search_city, 0, 0, 0, 0, $sort_by, $listings_limit, $offset);
			} else if (($search_category == -1) && ($tag_id != 0)) {
				$listings = $this->listings_model->search_listings($search_string, $search_city, 0, 0, $tag_id, 0, $sort_by, $listings_limit, $offset);
			}
		} else if(settings_item('adv.search_blocks') == 3) {
			if($tag_id == 0) {
				$listings = $this->listings_model->search_listings($search_string, $search_city, 0, 0, 0, 0, $sort_by, $listings_limit, $offset);
			} else {
				$listings = $this->listings_model->search_listings($search_string, $search_city, 0, 0, $tag_id, 0, $sort_by, $listings_limit, $offset);
			}
		}
		
		$listings_array = (array) $listings; // Convert object to array
		
		/*if(settings_item('site.enable_cache') == 1) {
			$cacheID = "search_". $default_city ."_". str_replace(" ", "_", $search_string)."_".$sort_by ."_".$limit."_".$offset;
			if(!$listings = $this->zf_cache->load($cacheID)) {
				$this->zf_cache->save($listings, $cacheID);
			}
		}*/

		// Merge top featured and listings results array
		$banners = $this->banners_model->get_frontend_banners_all(); // retrieve banners
			
		// Pagination
		$this->load->library('pagination');
		$config ['uri_segment'] = 4;
		$config ['full_tag_open'] = "<ul class='pagination'>";
		$config ['full_tag_close'] = "</ul>";
		$config ['num_tag_open'] = '<li>';
		$config ['num_tag_close'] = '</li>';
		$config ['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config ['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config ['next_tag_open'] = "<li>";
		$config ['next_tagl_close'] = "</li>";
		$config ['prev_tag_open'] = "<li>";
		$config ['prev_tagl_close'] = "</li>";
		$config ['first_tag_open'] = "<li>";
		$config ['first_tagl_close'] = "</li>";
		$config ['last_tag_open'] = "<li>";
		$config ['last_tagl_close'] = "</li>";
		if($search_locality != -1) {
			$config['base_url'] = base_url()."/search/" .str_replace(" ","-", $city). '/' .$this->slugify($search_string). '-l' .$search_locality .'t0';
		} else {
			$config['base_url'] = base_url()."/search/" .str_replace(" ","-", $city). '/' .$this->slugify($search_string). '-l0t0';
		}
		
		if(settings_item('adv.search_blocks') == 1) {
			$config['total_rows'] = $this->listings_model->search_results_count($search_string, $search_city, $search_locality);
		} elseif(settings_item('adv.search_blocks') == 2) {
			$config['total_rows'] = $this->listings_model->search_results_count($search_string, $search_city, 0, $search_category);
		} else {
			$config['total_rows'] = $this->listings_model->search_results_count($search_string, $search_city);
		}
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);
			
		/**
		 * To set typed city or state name
		 */
		if(settings_item('adv.search_blocks') == 1) {
			Template::set(array('localities' => $localities, 'search_locality' => $search_locality));
		} elseif(settings_item('adv.search_blocks') == 2 || settings_item('adv.search_blocks') == 3) {
			$search_city = str_replace('_', ' ', $search_city);
			$search_city = ucwords($search_city);
			Template::set('search_location', $search_city);
			if(settings_item('adv.search_blocks') == 2) {
				Template::set('search_category', $search_category);
			}
		}
		Template::set(array(
			'page_title' => ucwords($search_string),
			'searchterm' => ucwords($search_string),
			'top_featured' => $top_featured,
			'listings'=> $listings,
			'banners' => $banners,
			'limit'		=> $row_limit, // set dropdown field value
			'sort_by'	=> $sort_by,
			'featured_listings' => $right_featured,
			'popular_listings' => $this->popular_listings(),
			'recently_added' => $this->recently_added(),
			'default_city' => str_replace('_', ' ', $default_city)
		));
		
		// right hand categories
		$categories = $this->categories_model->select('id, name, slug, counts')->find_all_by(array('active' => 1, 'parent_id' => 0));
		if($categories) {
			Template::set('categories', $categories);
		}
		
		Template::set_view('view.php');
		Template::render();
	}	
	
	/**
	 * Display city on user keyup
	 * @return unknown
	 */
	public function ajax_search_location () {
		$keyword = escape($this->input->get('search'));
		$keyword = $this->location_handler($keyword);		
		$listings = $this->listings_model->ajax_search_location($keyword);
		$result = array();
		foreach($listings as $listing) {
			$result[]['name'] = $listing['name'];
		}
		$output = json_decode(json_encode($result),true);
		echo json_encode($output);
		return $listings;
	}
	
	/**
	 * Grab and display result on user keyup
	 * @return JsonResponse
	 */
	public function ajax_search () {
		$keyword = escape($this->input->get('search'));
		if(settings_item('adv.search_blocks') == 1) {
			$locality_id = $this->session->userdata('search_locality');
			if($locality_id == -1) {
				$listings = $this->listings_model->ajax_search($keyword, $this->session->userdata('search_location'));
			} else {
				$listings = $this->listings_model->ajax_search($keyword, $this->session->userdata('search_location'), $locality_id);
			}
		} elseif(settings_item('adv.search_blocks') == 2) {
			$listings = $this->listings_model->ajax_search($keyword, $this->session->userdata('search_location'), 0, $this->session->userdata('search_category'));
		} elseif(settings_item('adv.search_blocks') == 3) {
			$listings = $this->listings_model->ajax_search($keyword, $this->session->userdata('search_location'));
		}
	
		$result = array();
		foreach($listings as $listing) {
			$result[]['title'] = $listing['title'];
		}
		$output = json_decode(json_encode($result),true);
		echo json_encode($output);
		return $listings;
	}
	
	/**
	 * Store category id on user selection
	 */
	public function ajax_selection () {
		if(!empty($_POST['category'])) {
			if($_POST['category'] != -1) {
				$this->category_handler(escape($this->input->post('category')));
			} else {
				$this->category_handler(0);			
			}			
		}
		if(!empty($_POST['locality'])) {
			$this->locality_handler(escape($this->input->post('locality')));
		}	
	}
	
	/**
	 * Create slug from $text string
	 * @param string $text
	 * @return string|mixed
	 */
	public function slugify($text) {
		// replace non letter or digits by -
		$text = preg_replace ( '~[^\\pL\d]+~u', '-', $text );		
		// trim
		$text = trim ( $text, '-' );		
		// transliterate
		$text = iconv ( 'utf-8', 'us-ascii//TRANSLIT', $text );		
		// lowercase
		$text = strtolower ( $text );		
		// remove unwanted characters
		$text = preg_replace ( '~[^-\w]+~', '', $text );		
		if (empty ( $text )) {
			return 'n-a';
		}		
		return $text;
	}
		
	/**
	 * Get random values from an associative array for featured listing
	 * @param array $arr
	 * @param number $num
	 * @return multitype:array
	 */
	function array_random_assoc($arr, $num = 1) {
		$keys = array_keys($arr);
		shuffle($keys);
		$r = array();
		for ($i = 0; $i < $num; $i++) {
			$r[$keys[$i]] = $arr[$keys[$i]];
		}
		return $r;
	}
	
	/**
	 * Sort array based on value
	 */
	function sortByPrice($x, $y) {
		return $y['price'] - $x['price'];
	}
	
	/**
	 * Storing search term for pagination
	 * @param string $searchterm
	 * @return return searchterm
	 */
	public function searchterm_handler($searchterm) {
		if($searchterm) {
			$this->session->set_userdata('search_term', $searchterm);
			return $searchterm;
		} elseif($this->session->userdata('search_term')) {
			$searchterm = $this->session->userdata('search_term');			
			return $searchterm;
			$this->session->unset_userdata('search_term');
		} else {
			$searchterm ="";
			return $searchterm;
		}
	}
	
	/**
	 * Storing locality information
	 * @param string $search_locality
	 * @return return search_locality
	 */
	public function locality_handler($search_locality) {
		if($search_locality) {
			$this->session->set_userdata('search_locality', $search_locality);
			return $search_locality;
		} elseif($this->session->userdata('search_locality')) {
			$search_locality = $this->session->userdata('search_locality');
			return $search_locality;
			$this->session->unset_userdata('search_locality');
		} else {
			$search_locality ="";
			return $search_locality;
		}
	}
	
	/**
	 * Storing location information
	 * @param string $search_location
	 * @return return search_location
	 */
	public function location_handler($search_location) {
		if($search_location) {
			$this->session->set_userdata('search_location', $search_location);
			return $search_location;
		} elseif($this->session->userdata('search_location')) {
			$search_location = $this->session->userdata('search_location');
			return $search_location;
			$this->session->unset_userdata('search_location');
		} else {
			$search_location ="";
			return $search_location;
		}
	}
	
	/**
	 * Storing category information
	 * @param string $search_category
	 * @return return search_category
	 */
	public function category_handler($search_category) {
		if($search_category) {
			$this->session->set_userdata('search_category', $search_category);
			return $search_category;
		} elseif($this->session->userdata('search_category')) {
			$search_category = $this->session->userdata('search_category');
			return $search_category;
			$this->session->unset_userdata('search_category');
		} else {
			$search_category ="";
			return $search_category;
		}
	}
	
	/**
	 * Get featured listings from database
	 * @return return featured_listings
	 */
	public function featured_listings() {
		return $this->listings_model->featured_listings(settings_item('lst.right_featured_count'));
	}
	
	/**
	 * Get popular listings from database
	 * @return return popular_listing
	 */
	public function popular_listings() {
		return $this->listings_model->popular_listings(settings_item('lst.popular_count'));
	}
	
	/**
	 * Get recently added listings from database
	 * @return return recently_added listings
	 */
	public function recently_added() {
		return $this->listings_model->recently_added(settings_item('lst.recently_added_count'));
	}
	
	/**
	 * Get related listings from database
	 * @return return related listings
	 */
	public function related_listings($listing_id, $category_id) {
		return $this->listings_model->related_listings($listing_id, $category_id, settings_item('lst.related_links_count'));
	}
	
	/**
	 * GET STATES AND CITIES (AJAX)
	 * @param string $country_iso
	 * @return AJAX
	 */
	public function loadData($country_iso)
	{
		header('Content-Type: application/x-json; charset=utf-8'); //important to include because of json
		$result = $this->states_model->find_all_by(array('country_iso' => $country_iso, 'active' => 1));
		$output = json_decode(json_encode($result),true);
		echo json_encode($output);
	}
	
	/**
	 * Retrieve localities using city id
	 * @param int $city_id
	 * @return AJAX
	 */
	public function loadLocalities($city_id)
	{
		$this->session->set_userdata('search_city', $city_id);
		header('Content-Type: application/x-json; charset=utf-8'); //important to include because of json
		$result = $this->localities_model->find_all_by(array('city_id' => $city_id, 'active' => 1));
		$output = json_decode(json_encode($result),true);
		echo json_encode($output);
	}
	
	/**
	 * BANNER CLICKS
	 * Update banner hits on user click
	 * Used by AJAX 
	 */
	public function updateBannerClicks() {
		$id = $this->input->post('id');
		$this->db->where('id', $id);
		$this->db->set('clicks', 'clicks + 1', FALSE);
		$this->db->update('banners');
	}
	
	/**
	 * BANNER IMPRESSIONS
	 * Update banner impressions on mouse over
	 * Used by AJAX
	 */
	public function updateBannerImpressions() {
		$id = $this->input->post('id');
		$this->db->where('id', $id);
		$this->db->set('impressions', 'impressions + 1', FALSE);
		$this->db->update('banners');
	}
	
	/**
	 * Get thumbnail file by adding _thumb
	 * @param $filename
	 */
	
	public function get_thumb($filename) {
		preg_match('/(?<extension>\.\w+)$/im', $filename, $matches);
		$extension = $matches['extension'];
		return preg_replace('/(\.\w+)$/im', '', $filename) . '_thumb' . $extension;
	}
}