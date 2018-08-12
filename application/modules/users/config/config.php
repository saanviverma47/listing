<?php defined('BASEPATH') || exit('No direct script access allowed');

$config['module_config'] = array(
	'description'	=> lang('gc_desc_users'),
	'name'			=> lang('gc_menu_users'),
	'version'		=> settings_item('site.version'),
	'author'		=> 'Bonfire Team',
	'weights'		=> array(
		'settings'	=> 1
	)
);
