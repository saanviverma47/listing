<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['module_config'] = array(
	'description'	=> lang('gc_desc_cron_jobs'),
	'name'			=> lang('gc_menu_cron_jobs'),
	'version'		=> settings_item('site.version'),
	'author'		=> settings_item('site.author')
);