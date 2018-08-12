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
 * Content context controller
 *
 * The controller which displays the homepage of the Content context in Bonfire site.
 *
 * @package    Bonfire
 * @subpackage Controllers
 * @category   Controllers
 * @author     Bonfire Dev Team
 * @link       http://guides.cibonfire.com/helpers/file_helpers.html
 *
 */
class Content extends Admin_Controller
{


	/**
	 * Controller constructor sets the Title and Permissions
	 *
	 */
	public function __construct()
	{
		parent::__construct();

		Template::set('toolbar_title', lang('bf_context_content'));

		$this->auth->restrict('Site.Content.View');
	}//end __construct()

	//--------------------------------------------------------------------

	/**
	 * Displays the initial page of the Content context
	 *
	 * @return void
	 */
	public function index() {
		$links = array(
			array(
				'name' => lang('gc_menu_categories'),
				'icon' => 'fa-list',
				'link' => '/content/categories',
				'color'=> 'primary'
			),
			array(
				'name' => lang('gc_menu_comments'),
				'icon' => 'fa-comments',
				'link' => '/content/comments',
				'color'=> 'warning'
			),
			array(
				'name' => lang('gc_menu_listings'),
				'icon' => 'fa-th-list',
				'link' => '/content/listings',
				'color'=> 'success'
			),
			array(
				'name' => lang('gc_menu_pages'),
				'icon' => 'fa-pencil-square',
				'link' => '/content/pages',
				'color'=> 'info'
			),
			array(
				'name' => lang('gc_menu_tags'),
				'icon' => 'fa-tags',
				'link' => '/content/tags',
				'color'=> 'inverse'
			)
		);
		Template::set('links', $links);
		Template::set_view('context');
		Template::render();
	}//end index()

	//--------------------------------------------------------------------


}//end class