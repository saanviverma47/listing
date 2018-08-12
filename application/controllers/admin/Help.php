<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Help context controller
 * The controller which displays the homepage of the Help context in Bonfire site.
 */
class Help extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();

		Template::set('toolbar_title', lang('bf_context_help'));

		$this->auth->restrict('Manual.Help.View');
	}
	
	/**
	 * Displays the initial page of the Help context
	 */
	public function index()	{
		Template::redirect('/');
	}
}