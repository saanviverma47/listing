<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
$config ['general_settings_fields'] = array (
		array (
				'name' => 'general_settings_test',
				'label' => 'Test Label',
				'rules' => 'trim',
				'form_detail' => array (
						'type' => 'dropdown',
						'settings' => array (
								'name' => 'general_settings_test',
								'id' => 'general_settings_test' 
						),
						'options' => array (
								'0' => 'Passed',
								'1' => 'Failed' 
						) 
				),
				'permission' => 'This.Shouldnt.ShowUp' 
		),
		array (
				'name' => 'meta_title',
				'label' => lang ( 'meta_title' ),
				'rules' => 'trim|max_length[100]',
				'form_detail' => array (
						'type' => 'input',
						'settings' => array (
								'name' => 'meta_title',
								'id' => 'meta_title',
								'maxlength' => '100',
								'class' => 'span6' 
						) 
				),
				'permission' => 'Site.Settings.View' 
		),
		array (
				'name' => 'meta_keywords',
				'label' => lang ( 'meta_keywords' ),
				'rules' => 'trim|max_length[250]',
				'form_detail' => array (
						'type' => 'textarea',
						'settings' => array (
								'name' => 'meta_keywords',
								'id' => 'meta_keywords',
								'class' => 'span6'
						)
				),
				'permission' => 'Site.Settings.View'
		),
		array (
				'name' => 'meta_description',
				'label' => lang ( 'meta_description' ),
				'rules' => 'trim|max_length[200]',
				'form_detail' => array (
						'type' => 'textarea',
						'settings' => array (
								'name' => 'meta_description',
								'id' => 'meta_description',
								'maxlength' => '200',
								'class' => 'span6'
						)
				),
				'permission' => 'Site.Settings.View'
		),
		array (
				'name' => 'footer_text',
				'label' => lang ( 'footer_text' ),
				'rules' => 'trim|max_length[250]',
				'form_detail' => array (
						'type' => 'textarea',
						'settings' => array (
								'name' => 'footer_text',
								'id' => 'footer_text',
								'maxlength' => '250',
								'class' => 'span6'
						)
				),
				'permission' => 'Site.Settings.View'
		),		
		array (
				'name' => 'footer_partner',
				'label' => lang ( 'footer_our_partners' ),
				'rules' => 'trim|max_length[250]',
				'form_detail' => array (
						'type' => 'textarea',
						'settings' => array (
								'name' => 'footer_partner',
								'id' => 'footer_partner',
								'maxlength' => '250',
								'class' => 'span6'
						)
				),
				'permission' => 'Site.Settings.View'
		),
		array (
				'name' => 'analytics_tracking_id',
				'label' => lang ( 'analytics_tracking_id' ),
				'rules' => 'trim|max_length[15]',
				'form_detail' => array (
						'type' => 'input',
						'settings' => array (
								'name' => 'analytics_tracking_id',
								'id' => 'analytics_tracking_id',
								'maxlength' => '15',
								'class' => 'span6'
						)
				),
				'permission' => 'Site.Settings.View'
		),
		array (
				'name' => 'facebook_url',
				'label' => lang ( 'facebook_url' ),
				'rules' => 'trim|max_length[100]',
				'form_detail' => array (
						'type' => 'input',
						'settings' => array (
								'name' => 'facebook_url',
								'id' => 'facebook_url',
								'maxlength' => '100',
								'class' => 'span6' 
						) 
				),
				'permission' => 'Site.Settings.View' 
		),
		array (
				'name' => 'twitter_url',
				'label' => lang ( 'twitter_url' ),
				'rules' => 'trim|max_length[100]',
				'form_detail' => array (
						'type' => 'input',
						'settings' => array (
								'name' => 'twitter_url',
								'id' => 'twitter_url',
								'maxlength' => '100',
								'class' => 'span6'
						)
				),
				'permission' => 'Site.Settings.View'
		),
		array (
				'name' => 'googleplus_url',
				'label' => lang ( 'googleplus_url' ),
				'rules' => 'trim|max_length[100]',
				'form_detail' => array (
						'type' => 'input',
						'settings' => array (
								'name' => 'googleplus_url',
								'id' => 'googleplus_url',
								'maxlength' => '100',
								'class' => 'span6'
						)
				),
				'permission' => 'Site.Settings.View'
		),
		array (
				'name' => 'youtube_url',
				'label' => lang ( 'youtube_url' ),
				'rules' => 'trim|max_length[100]',
				'form_detail' => array (
						'type' => 'input',
						'settings' => array (
								'name' => 'youtube_url',
								'id' => 'youtube_url',
								'maxlength' => '100',
								'class' => 'span6' 
						) 
				),
				'permission' => 'Site.Settings.View' 
		),
		array (
				'name' => 'display_footer_popular',
				'label' => lang ( 'display_footer_popular' ),
				'rules' => '',
				'form_detail' => array (
						'type' => 'checkbox',
						'settings' => array (
								'name' => 'display_footer_popular',
								'id' => 'display_footer_popular',
								'value' => '1'
						)
				),
				'permission' => 'Site.Settings.View'
		)
		
);
