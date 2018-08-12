<?php if (! defined ( 'BASEPATH' ))exit ( 'No direct script access allowed' );
 
 
 
 
 
 
 
 
 
 
 
 

class Help extends Admin_Controller
{
	protected $permissionView   = 'Manual.Help.View';
	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		//$this->auth->restrict($this->permissionView);
	}

	/**
	 * Displays a list of all news.
	 *
	 * @return void
	 */
	public function index() {		
		//echo "<a href=\"some link here\" target=\"_blank\">";
		//redirect('http://manual.mbb.com/');
		Template::set('toolbar_title', lang('gc_menu_user_manual'));
		Template::render();
	}
}