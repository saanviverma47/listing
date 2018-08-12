<?php defined('BASEPATH') || exit('No direct script access allowed');

$config['module_config'] = array(
	'description'	=> lang('gc_desc_email_queue'),
	'name'			=> lang('gc_menu_email_queue'),
	'version'		=> settings_item('site.version'),
	'author'		=> 'Bonfire Team',
	'menus'			=> array(
		'settings'	=> 'emailer/settings/menu'
	)
);
