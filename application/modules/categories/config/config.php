<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['module_config'] = array(
	'description'	=> lang('gc_desc_categories'),
	'name'			=> lang('gc_menu_categories'),
	'version'		=> settings_item('site.version'),
	'author'		=> settings_item('site.author')
	/*'menus'			=> array(
		'content'	=> 'categories/content/menu'
	),*/
);