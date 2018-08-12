<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dashboard context controller
 *
 * The controller which displays the homepage of the Dashboard context in Bonfire site.
 *
 */
class Dashboard extends Admin_Controller
{


	/**
	 * Controller constructor sets the Title and Permissions
	 *
	 */
	public function __construct()
	{
		parent::__construct();

		Template::set('toolbar_title', 'Dashboard');

		$this->auth->restrict('Site.Dashboard.View');
	}//end __construct()

	//--------------------------------------------------------------------

	/**
	 * Displays the initial page of the Dashboard context
	 *
	 * @return void
	 */
	public function index()
	{
		redirect(SITE_AREA .'/dashboard/summary');
	}//end index()

	//--------------------------------------------------------------------


}//end class