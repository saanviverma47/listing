<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['module_config'] = array(
	'description'	=> lang('gc_desc_manual'),
	'name'			=> lang('gc_menu_user_manual'),
	'version'		=> settings_item('site.version'),
	'author'		=> settings_item('site.author')
);