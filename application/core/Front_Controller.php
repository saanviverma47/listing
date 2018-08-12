<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Front Controller
 *
 * This class provides a common place to handle any tasks that need to
 * be done for all public-facing controllers.
 *
 * @package    Bonfire\Core\Controllers
 * @category   Controllers
 * @author     Bonfire Dev Team
 * @link       http://guides.cibonfire.com/helpers/file_helpers.html
 *
 */
class Front_Controller extends Base_Controller
{

    //--------------------------------------------------------------------

    /**
     * Class constructor
     *
     */
    public function __construct()
    {
        parent::__construct();

        Events::trigger('before_front_controller');

        $this->load->library('template');
        $this->load->library('assets');
        $this->load->helper('text');
		$this->load->helper('security');
        $this->load->model('categories/categories_model');

        $this->set_current_user();
        
        $this->config->set_item('language', settings_item('site.default_language'));    
       
        /**
         * Country, State and City Selection
         */
        if(settings_item('adv.search_location') == 1) {
        	$this->load->model('locations/countries_model');
        	$countries = $this->countries_model->find_all_by('active', 1);
        	Template::set('countries', $countries);
        }
        if(settings_item('adv.search_blocks') == 1) {
	        $this->load->model('locations/countries_model');    
	        $this->load->model('locations/states_model');
	        $this->load->model('locations/cities_model');
	        $this->load->model('locations/localities_model');
	       
	        if (isset($_POST['locationSubmit'])){
	        	if($this->input->post('select-country')) {
	        		$country = $this->input->post('select-country');
	        	} else {
	        		$country = settings_item('adv.default_country');
	        	}
	        	
	        	$state = $this->input->post('select-state');
	        	$this->session->set_userdata('search_country', $country);
	        	$this->session->set_userdata('search_state', $state);
	        	$city = $this->cities_model->select('id')->find_by('state_id', $state);
	        	$city = $city->id;
	        	$this->session->set_userdata('search_city', $city);
	        } else {
	        	if($this->session->userdata('search_country')) { 
		        	$country = $this->session->userdata('search_country'); 
	        	} else {
	        		$country = settings_item('adv.default_country');
	        		$this->session->set_userdata('search_country', $country);
	        	}
	        	if($this->session->userdata('search_state')) {
	        		$state = $this->session->userdata('search_state');
	        	} else {
	        		$state = settings_item('adv.default_state');
	        		$this->session->set_userdata('search_state', $state);
	        	}
	        	if($this->session->userdata('search_city')) {
		        	$city = $this->session->userdata('search_city');
	        	} else {
	        		$city = settings_item('adv.default_city');
	        		$this->session->set_userdata('search_city', $city);
	        	}
	        }
	        
	        // display locations for selection
	        $countries = $this->countries_model->select('iso, name')->order_by('name')->find_all_by('active', 1);
	        $states = $this->states_model->select('id, name')->order_by('name')->find_all_by(array('country_iso' => $country, 'active' => 1));
	     	if(settings_item('adv.search_location') == 2) {
	     		$cities = $this->cities_model->get_all_cities($country);
	        } else {
	        	$cities = $this->cities_model->select('id, name')->order_by('name')->find_all_by(array('state_id' => $state, 'active' => 1));
	        } 
	        
	        // load localities based on country state or city availability
	        $localities = $this->localities_model->select('id, name')->order_by('name')->find_all_by(array('city_id' => $city, 'active' => 1));
	        
	        Template::set(array(
		        'countries' => $countries,
		        'states' => $states,
		        'cities' => $cities,
		        'localities' => $localities,
		        'default_country' => $country,
		        'default_state'	 => $state,
		        'default_city' => $city
	        ));
	        
        } elseif(settings_item('adv.search_blocks') == 2 || settings_item('adv.search_blocks') == 3) {
        	if (isset($_POST['locationSubmit'])){
        		if($this->input->post('select-country')) {
        			$country = $this->input->post('select-country');
        		}
        		$this->session->set_userdata('search_country', $country);
        	} else {
        		if($this->session->userdata('search_country')) {
        			$country = $this->session->userdata('search_country');
        		} else {
        			$country = settings_item('adv.default_country');
        			$this->session->set_userdata('search_country', $country);
        		}
        	}
        	$this->session->set_userdata('search_country', $country);
        	Template::set('default_country', $country);
        	
        	if(settings_item('adv.search_blocks') == 2) {
        		$categories = $this->categories_model->select('id, name')->find_all_by('parent_id', 0);
        		Template::set('header_categories', $categories);
        	}
        }
        
        if(settings_item('site.display_footer_popular') == 1) {
        	$this->load->model('locations/cities_model');
	        // load popular categories for footer
	        $popular_category_array = array();
	        $popular_categories = $this->categories_model->select('id, name, slug')->order_by('hits', 'desc')->limit(5)->find_all_by(array('active' => 1));
	        if(!empty($popular_categories)) {
		        foreach($popular_categories as $popular_category) {
		        	$popular_category_array[] = '<a href="'.site_url('category/' .$popular_category->slug .'-' .$popular_category->id).'">' .$popular_category->name .'</a>';
		        }
	        }
	        
	        $popular_city_array = array();
	        $popular_cities = $this->cities_model->select('id, name')->order_by('hits', 'desc')->limit(5)->find_all_by(array('active' => 1));
	        if(!empty($popular_cities)) {
		        foreach($popular_cities as $popular_city) {
		        	$popular_city_array[] = '<a href="'.site_url('location/' .str_replace(" ", "-", strtolower($popular_city->name)) .'-' .$popular_city->id).'">' .$popular_city->name .'</a>';
		        }
	        }
	        //footer pages link
	        // send values to view
	        Template::set(array(
	        	'popular_categories' => $popular_category_array,
	        	'popular_cities'=> $popular_city_array
	        ));
        }    
        /************** END OF SELECT LOCATION ************/
        // pages link
        $this->load->model('pages/pages_model');
        $pages = $this->pages_model->get_links();
        // send as parameter to module view
        Template::set('menu_links', $pages);
        // Load Zend Caching
       /* $this->load->library('zf_cache', array('lifetime' => 900));
        $this->zf_cache = $this->zf_cache->get_instance();
        */
        Events::trigger('after_front_controller');
    }//end __construct()

    //--------------------------------------------------------------------

}

/* End of file Front_Controller.php */
/* Location: ./application/core/Front_Controller.php */