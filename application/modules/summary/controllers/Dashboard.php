<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
 
 
 
 
 
 
 
 
 
 

/**
 * dashboard controller
 */
class Dashboard extends Admin_Controller
{

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->auth->restrict('Summary.Dashboard.View');
		$this->load->model('summary_model');
		
		//LOAD ALL MODELS FOR FILTERING AND OTHER OPERATIONS
		$this->load->model('listings/listings_model');
		$this->load->model('listings/products_model');
		$this->load->model('listings/videos_model');
		$this->load->model('listings/classifieds_model');
		$this->load->model('listings/business_hours_model');
		$this->load->model('roles/role_model');
		$this->load->model('categories/categories_model');
		$this->load->model('locations/countries_model');
		$this->load->model('tags/tags_model');
		
		Template::set_block('sub_nav', 'dashboard/_sub_nav');

		Assets::add_module_js('summary', 'summary.js');
	}

	/**
	 * Displays a list of module summary to the admin.
	 *
	 * @return void
	 */
	public function index() {
		$update = parse_ini_string($this->get_content(), TRUE);
		if($update['version'] > settings_item('site.version')) {
			Template::set('update', $update);
		}
		
		$notifications = json_decode($this->get_notifications(), TRUE);
		if(!empty($notifications)) {
			Template::set('notifications', $notifications);
		}
		
		$summary = $this->summary_model->get_dashboard();
		Template::set('summary', $summary);
		Template::set('toolbar_title', 'Summary');
		Template::render();
	}
	
	/**
	 * Get latest version information from mbb Official website
	 * @param string $URL
	 * @return mixed
	 */
	private function get_content() {
		$URL = settings_item('site.update_url');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $URL);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	
	/**
	 * Get latest version information from mbb Official website
	 * @param string $URL
	 * @return mixed
	 */
	private function get_notifications() {
		$URL = settings_item('site.notifications_url');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $URL);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
}