<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['module_config'] = array(
	'description'	=> lang('gc_desc_packages'),
	'name'			=> lang('gc_menu_packages'),
	'version'		=> settings_item('site.version'),
	'author'		=> settings_item('site.author')
);