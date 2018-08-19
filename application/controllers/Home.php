<?php defined('BASEPATH') || exit('No direct script access allowed');

class Home extends Front_Controller
{
	protected $sett = array();
	public function __construct()
	{
		parent::__construct();

		$this->load->helper('application');
		$this->load->library('Template');
		$this->load->library('Assets');
		$this->lang->load('application');
		$this->load->library('events');
        $this->requested_page = isset($_SESSION['requested_page']) ? $_SESSION['requested_page'] : null;
	}

	//--------------------------------------------------------------------

	/**
	 * Displays the homepage of the Bonfire app
	 *
	 * @return void
	 */
	public function index()
	{
		$this->load->model('banners/banners_model');
		$this->load->model('listings/listings_model');
		$this->load->model('categories/categories_model');
		$categories = $this->categories_model->order_by('counts','DESC')->find_all_by('active', 1);	
		$banners = $this->banners_model->get_frontend_banners_all(); // retrieve banners
		$frontend_slider = $this->banners_model->get_frontend_slider();
		$popular_listings = $this->listings_model->popular_listings(settings_item('lst.popular_count'));
		$recently_added = $this->listings_model->recently_added(settings_item('lst.recently_added_count'));
		$this->load->library('users/auth');
		$this->set_current_user();
		Template::set(array(
			'frontend_slider' => $frontend_slider,
			'banners' => $banners,
			'featured_listings' => $this->listings_model->frontend_featured_listings(),
			'popular_listings' => $popular_listings,
			'recently_added' => $recently_added,
			'categories' => $categories
		));
		Template::render();
	}

	//--------------------------------------------------------------------

	/**
	 * If the Auth lib is loaded, it will set the current user, since users
	 * will never be needed if the Auth library is not loaded. By not requiring
	 * this to be executed and loaded for every command, we can speed up calls
	 * that don't need users at all, or rely on a different type of auth, like
	 * an API or cronjob.
	 *
	 * Copied from Base_Controller
	 */
	protected function set_current_user()
	{
        if (class_exists('Auth')) {
			// Load our current logged in user for convenience
            if ($this->auth->is_logged_in()) {
				$this->current_user = clone $this->auth->user();

				$this->current_user->user_img = gravatar_link($this->current_user->email, 22, $this->current_user->email, "{$this->current_user->email} Profile");

				// if the user has a language setting then use it
                if (isset($this->current_user->language)) {
					$this->config->set_item('language', $this->current_user->language);
				}
            } else {
				$this->current_user = null;
			}

			// Make the current user available in the views
            if (! class_exists('Template')) {
				$this->load->library('Template');
			}
			Template::set('current_user', $this->current_user);
		}
	}
}
/* end ./application/controllers/home.php */
