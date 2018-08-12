<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Bonfire
 *
 * An open source project to allow developers get a jumpstart their development of CodeIgniter applications
 *
 * @package   Bonfire
 * @author    Bonfire Dev Team
 * @copyright Copyright (c) 2011 - 2013, Bonfire Dev Team
 * @license   http://guides.cibonfire.com/license.html
 * @link      http://cibonfire.com
 * @since     Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Settings Module
 *
 * Allows the user to management the preferences for the site.
 *
 * @package    Bonfire
 * @subpackage Modules_Settings
 * @category   Controllers
 * @author     Bonfire Dev Team
 * @link       http://guides.cibonfire.com/helpers/file_helpers.html
 *
 */
class Settings extends Admin_Controller
{

	/**
	 * Private variable declaration for file upload
	 * Used in help option for consistency
	 * @var unknown
	 */
	private $file_size = 70; // set maximum size
	private $max_width = 163; // set maximum width
	private $max_height = 45; // set maximum height
	private $resize_width = 163; // set resize width
	private $resize_height = 45; // set resize height

	/**
	 * Sets up the require permissions and loads required classes
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		// restrict access - View and Manage
		$this->auth->restrict('Bonfire.Settings.View');
		$this->auth->restrict('Bonfire.Settings.Manage');

		Template::set('toolbar_title', 'Site Settings');
		
		// settings used in help option
		$file_upload_settings = array (
				'file_size' => $this->file_size,
				'max_width'	=> $this->max_width,
				'max_height' => $this->max_height,
				'resize_width' => $this->resize_width,
				'resize_height' => $this->resize_height
		);
		Template::set('file_upload_settings',$file_upload_settings);

		$this->load->helper('config_file');
		$this->lang->load('settings');

	}//end __construct()

	//--------------------------------------------------------------------

	/**
	 * Displays a form with various site setings including site name and
	 * registration settings
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function index()
	{
		$this->load->model('locations/countries_model');
		$this->load->model('listings/listings_model');
		$this->load->model('currencies/currencies_model');
		$this->load->model('pages/pages_model');
		$this->load->config('extended_settings');
		$this->load->config('general_settings');
		$extended_settings = config_item('extended_settings_fields');
		$general_settings = config_item('general_settings_fields');

		if (isset($_POST['save']))
		{
			if ($this->save_settings($extended_settings, $general_settings))
			{
				Template::set_message(lang('settings_saved_success'), 'success');
				redirect(SITE_AREA .'/settings/settings');
			}
			else
			{
				Template::set_message(lang('settings_error_success'), 'error');
			}
		}

		// Read our current settings
		$settings = $this->settings_lib->find_all();
		// Load countries information
		$countries = $this->countries_model->find_all();		
		// Load currencies information
		$currencies = $this->currencies_model->find_all();
		// Load states
		$states = $this->listings_model->get_states(settings_item('adv.default_country'));
		// Load cities
		$cities = $this->listings_model->get_cities(settings_item('adv.default_state'));
	
		Template::set(array('settings' => $settings,
							'extended_settings'=> $extended_settings,
							'general_settings'=> $general_settings,
							'countries'	=> $countries,
							'states'	=> $states,
							'cities'	=> $cities,
							'currencies'	=> $currencies,
							'pages'	=> $this->pages_model->select('id, slug, title')->find_all()
							));
		
		// Get the possible languages
		$this->load->helper('translate/languages');
		Template::set('languages', list_languages());
		Template::set('selected_languages', unserialize($settings['site.languages']));

		Assets::add_module_js('settings', 'js/settings.js');

		Template::set_view('settings/settings/index');
		Template::render();

	}//end index()
	
	//GET STATES AND CITIES (AJAX)
	public function loadData()
	{
		$loadType=$_POST['loadType'];
		$loadId=$_POST['loadId'];
	
		$result=$this->settings_model->getData($loadType,$loadId);
		$HTML="";
	
		if($result) {
			foreach($result as $list){
				$HTML.="<option value='".$list->id."'>".$list->name."</option>";
			}
		}
		echo $HTML;
	}
	

	//--------------------------------------------------------------------

	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	/**
	 * Performs the form validation and saves the settings to the database
	 *
	 * @access private
	 *
	 * @param array	$extended_settings	An optional array of settings from the extended_settings config file
	 *
	 * @return bool
	 */
	private function save_settings($extended_settings=array(), $general_settings=array())
	{
		$this->form_validation->set_rules('title', 'lang:bf_site_name', 'required|trim');
		$this->form_validation->set_rules('system_email', 'lang:bf_site_email', 'required|trim|valid_email');
		$this->form_validation->set_rules('list_limit','Items <em>p.p.</em>', 'required|trim|numeric');
		$this->form_validation->set_rules('google_api_key', 'lang:google_api_key', 'trim|required');
		$this->form_validation->set_rules('default_country', 'lang:default_country', 'required');
		$this->form_validation->set_rules('default_state', 'lang:default_state', 'required');
		$this->form_validation->set_rules('default_city', 'lang:default_city', 'required');
		$this->form_validation->set_rules('password_min_length','lang:bf_password_length', 'required|trim|numeric');
		$this->form_validation->set_rules('password_force_numbers', 'lang:bf_password_force_numbers', 'trim|numeric');
		$this->form_validation->set_rules('password_force_symbols', 'lang:bf_password_force_symbols', 'trim|numeric');
		$this->form_validation->set_rules('password_force_mixed_case', 'lang:bf_password_force_mixed_case', 'trim|numeric');
		$this->form_validation->set_rules('password_show_labels', 'lang:bf_password_show_labels', 'trim|numeric');
		$this->form_validation->set_rules('languages[]', 'lang:bf_language', 'required|trim|is_array');

		// setup the validation rules for any extended settings
		$extended_data = array();
		foreach ($extended_settings as $field)
		{
			if ( empty($field['permission'])
				|| $field['permission'] === FALSE
				|| ( ! empty($field['permission']) && has_permission($field['permission']) )
				)
			{
				$this->form_validation->set_rules($field['name'], $field['label'], $field['rules']);
				$extended_data['ext.' . $field['name']] = $this->input->post($field['name']);
			}
		}
		
		// setup the validation rules for any general settings
		$general_data = array();
		foreach ($general_settings as $field)
		{
			if ( empty($field['permission'])
					|| $field['permission'] === FALSE
					|| ( ! empty($field['permission']) && has_permission($field['permission']) )
			)
			{
				$this->form_validation->set_rules($field['name'], $field['label'], $field['rules']);
				$general_data['site.' . $field['name']] = $this->input->post($field['name']);
			}
		}

		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}
		
		// upload logo
		if (isset($_FILES['site_logo']) && is_uploaded_file($_FILES['site_logo']['tmp_name'])) {
			$file_data = $this->upload_logo_file(); // upload logo file
			$site_logo_value = $file_data['upload_data']['file_name']; // retrieve file name of uploaded file
		} else {
			$site_logo_value = settings_item('site.logo'); // retrieve old file name and update database
		}
		$currency = explode('|', $this->input->post('currency'));
		$data = array(
			array('name' => 'site.title', 'value' => $this->input->post('title')),
			array('name' => 'site.logo', 'value' => $site_logo_value),					
			array('name' => 'site.system_email', 'value' => $this->input->post('system_email')),
			array('name' => 'site.status', 'value' => $this->input->post('status')),
			array('name' => 'site.list_limit', 'value' => $this->input->post('list_limit')),
			array('name' => 'site.currency', 'value' => $currency[0]),
			array('name' => 'site.currency_code', 'value' => $currency[1]),
			array('name' => 'site.google_api_key', 'value' => $this->input->post('google_api_key')),				
			array('name' => 'site.default_language', 'value' => $this->input->post('default_language')),

			array('name' => 'auth.allow_register', 'value' => isset($_POST['allow_register']) ? 1 : 0),
			array('name' => 'auth.user_activation_method', 'value' => isset($_POST['user_activation_method']) ? $_POST['user_activation_method'] : 0),
			array('name' => 'auth.login_type', 'value' => $this->input->post('login_type')),
			array('name' => 'auth.use_usernames', 'value' => isset($_POST['use_usernames']) ? $this->input->post('use_usernames') : 0),
			array('name' => 'auth.allow_remember', 'value' => isset($_POST['allow_remember']) ? 1 : 0),
			array('name' => 'auth.remember_length', 'value' => (int)$this->input->post('remember_length')),
			array('name' => 'auth.use_extended_profile', 'value' => isset($_POST['use_ext_profile']) ? 1 : 0),
			array('name' => 'auth.allow_name_change', 'value' => $this->input->post('allow_name_change') ? 1 : 0),
			array('name' => 'auth.name_change_frequency', 'value' => $this->input->post('name_change_frequency')),
			array('name' => 'auth.name_change_limit', 'value' => $this->input->post('name_change_limit')),
			array('name' => 'auth.password_min_length', 'value' => $this->input->post('password_min_length')),
			array('name' => 'auth.password_force_numbers', 'value' => $this->input->post('password_force_numbers') ? 1 : 0),
			array('name' => 'auth.password_force_symbols', 'value' => $this->input->post('password_force_symbols') ? 1 : 0),
			array('name' => 'auth.password_force_mixed_case', 'value' => $this->input->post('password_force_mixed_case') ? 1 : 0),
			array('name' => 'auth.password_show_labels', 'value' => $this->input->post('password_show_labels') ? 1 : 0),

			array('name' => 'updates.do_check', 'value' => isset($_POST['do_check']) ? 1 : 0),
			array('name' => 'updates.bleeding_edge', 'value' => isset($_POST['bleeding_edge']) ? 1 : 0),
			array('name' => 'site.show_profiler', 'value' => isset($_POST['show_profiler']) ? 1 : 0),
			array('name' => 'site.enable_cache', 'value' => isset($_POST['enable_cache']) ? 1 : 0),
			array('name' => 'site.show_front_profiler', 'value' => isset($_POST['show_front_profiler']) ? 1 : 0),
			array('name' => 'site.languages', 'value' => $this->input->post('languages') != '' ? serialize($this->input->post('languages')) : ''),
			array('name' => 'password_iterations', 'value' => $this->input->post('password_iterations')),
			
			// Advanced Settings
			array('name' => 'site.display_top_menu', 'value' => $this->input->post('display_top_menu') ? 1 : 0),
			array('name' => 'site.display_email', 'value' => $this->input->post('display_email') ? 1 : 0),
			array('name' => 'site.call_us', 'value' => $this->input->post('call_us')),
			array('name' => 'adv.search_blocks', 'value' => $this->input->post('search_blocks')),
			array('name' => 'adv.search_location', 'value' => $this->input->post('search_location')),
			array('name' => 'adv.default_country', 'value' => $this->input->post('default_country')),
			array('name' => 'adv.default_state', 'value' => $this->input->post('default_state')),
			array('name' => 'adv.default_city', 'value' => $this->input->post('default_city')),
				
			// Listing Settings
			array('name' => 'lst.top_advertisement', 'value' => $this->input->post('top_advertisement') ? 1 : 0),
			array('name' => 'lst.advertisement_page', 'value' => $this->input->post('advertisement_page')),			
			array('name' => 'lst.featured_location', 'value' => $this->input->post('featured_location')),
			array('name' => 'lst.recently_added_location', 'value' => $this->input->post('recently_added_location')),
			array('name' => 'lst.popular_location', 'value' => $this->input->post('popular_location')),
			array('name' => 'lst.top_featured_count', 'value' => $this->input->post('top_featured_count')),
			array('name' => 'lst.right_featured_count', 'value' => $this->input->post('right_featured_count')),
			array('name' => 'lst.recently_added_count', 'value' => $this->input->post('recently_added_count')),
			array('name' => 'lst.popular_count', 'value' => $this->input->post('popular_count')),
			array('name' => 'lst.related_links_location', 'value' => $this->input->post('related_links_location')),
			array('name' => 'lst.related_links_count', 'value' => $this->input->post('related_links_count')),
			array('name' => 'lst.logo_file_size', 'value' => $this->input->post('logo_file_size')),
			array('name' => 'lst.logo_width', 'value' => $this->input->post('logo_width')),
			array('name' => 'lst.logo_height', 'value' => $this->input->post('logo_height')),
			array('name' => 'lst.image_file_size', 'value' => $this->input->post('image_file_size')),
			array('name' => 'lst.image_width', 'value' => $this->input->post('image_width')),
			array('name' => 'lst.image_height', 'value' => $this->input->post('image_height')),
			array('name' => 'lst.thumbnail_width', 'value' => $this->input->post('thumbnail_width')),
			array('name' => 'lst.thumbnail_height', 'value' => $this->input->post('thumbnail_height')),
			array('name' => 'lst.allow_email', 'value' => $this->input->post('allow_email') ? 1 : 0),
			array('name' => 'lst.allow_print', 'value' => $this->input->post('allow_print') ? 1 : 0),
			array('name' => 'lst.allow_review', 'value' => $this->input->post('allow_review') ? 1 : 0),
			array('name' => 'lst.loggedin_review_only', 'value' => $this->input->post('loggedin_review_only') ? 1 : 0),
			array('name' => 'lst.allow_facebook_url', 'value' => $this->input->post('allow_facebook_url') ? 1 : 0),
			array('name' => 'lst.allow_twitter_url', 'value' => $this->input->post('allow_twitter_url') ? 1 : 0),
			array('name' => 'lst.allow_googleplus_url', 'value' => $this->input->post('allow_googleplus_url') ? 1 : 0),
			array('name' => 'lst.allow_country_selection', 'value' => $this->input->post('allow_country_selection') ? 1 : 0),
			array('name' => 'lst.categories_level', 'value' => $this->input->post('categories_level')),
			array('name' => 'lst.query_email_notification', 'value' => $this->input->post('query_email_notification') ? 1 : 0),
				
			// Financial Settings
			array('name' => 'fin.days_before_email', 'value' => $this->input->post('days_before_email'))
		);

		// Log the activity
		log_activity($this->current_user->id, lang('bf_act_settings_saved').': ' . $this->input->ip_address(), 'core');

		// save the settings to the DB
		$updated = $this->settings_model->update_batch($data, 'name');

		// if the update was successful and we have extended settings to save,
		if ($updated && ! empty($extended_data))
		{
			// go ahead and save them
			$updated = $this->save_extended_settings($extended_data);
		}
		
		// save the settings to the DB
		$updated = $this->settings_model->update_batch($data, 'name');
		
		// if the update was successful and we have extended settings to save,
		if ($updated && ! empty($extended_data))
		{
			// go ahead and save them
			$updated = $this->save_extended_settings($extended_data);
		}
		
		// if the update was successful and we have general settings to save,
		if ($updated && ! empty($general_data))
		{
			// go ahead and save them
			$general_data['site.display_footer_popular'] = $general_data['site.display_footer_popular'] ? 1 : 0;
			$updated = $this->save_general_settings($general_data);
		}

		return $updated;

	}//end save_settings()

	//--------------------------------------------------------------------

	/**
	 * Save the extended settings
	 *
	 * @access private
	 * @param	array	$extended_data	An array of settings to save
	 * @return	mixed/bool	TRUE or an inserted id if all settings saved successfully, else FALSE
	 */
	private function save_extended_settings($extended_data)
	{
		if ( ! is_array($extended_data)
			|| empty($extended_data)
			|| ! count($extended_data)
			)
		{
			return FALSE;
		}

		$setting = FALSE;
		foreach ($extended_data as $key => $value)
		{
			$setting = $this->settings_lib->set($key, $value);
			if ($setting === FALSE)
			{
				return FALSE;
			}
		}

		return $setting;
	}// end save_extended_settings()
	
	/**
	 * Save the general settings
	 *
	 * @access private
	 * @param	array	$general_data	An array of settings to save	 *
	 * @return	mixed/bool	TRUE or an inserted id if all settings saved successfully, else FALSE
	 */
	private function save_general_settings($general_data)
	{
		if ( ! is_array($general_data)
				|| empty($general_data)
				|| ! count($general_data)
		)
		{
			return FALSE;
		}
	
		$setting = FALSE;
		foreach ($general_data as $key => $value)
		{
			$setting = $this->settings_lib->set($key, $value);
			if ($setting === FALSE)
			{
				return FALSE;
			}
		}
	
		return $setting;
	}// end save_general_settings()

		/* -------------------------UPLOAD LOGO FUNCTION --------------------------------------*/
	/**
	 * Save uploaded image
	 * @return multitype:NULL
	 */
	private function upload_logo_file(){
	
		$config['upload_path'] = realpath(FCPATH.'assets/images/'); //Make SURE that you chmod this directory to 777!
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']= $this->file_size;
		$config['max_width']= $this->max_width;
		$config['max_height']= $this->max_height;
		$config['remove_spaces']=TRUE; //Remove spaces from the file name
	
		$this->load->library('upload', $config);
	
		if (!$this->upload->do_upload('site_logo')) // Image name is necessary
		{
			Template::set_message($this->upload->display_errors(), 'error'); // Show errors to the user
			redirect(SITE_AREA .'/settings/');
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
		//	$this->resize($data['upload_data']['full_path'],$data['upload_data']['file_name']);
		}
		return $data;
	}
	
	/**
	 * Create thumbs of uploaded image
	 */
	public function resize($path,$file){
		$config['image_library']='gd2';
		$config['source_image']=$path;
		//$config['create_thumb']=TRUE; // This will create new file
		$config['maintain_ratio']=TRUE;
		$config['width']= $this->resize_width;
		$config['height']= $this->resize_height;
		$config['new_image']='./assets/images/'.$file; //CHANGE THIS LINE FOR PATH
	
		$this->load->library('image_lib',$config);
		$this->image_lib->resize();
	}
	
	/* ------------------------ END OF UPLOAD LOGO ------------------------------------- */
}//end Settings()
