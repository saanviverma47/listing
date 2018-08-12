<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
 
 
 
 
 
 
 
 
 
 
 
 

class Cron_jobs extends Front_Controller {
	public function __construct() {
		parent::__construct ();
		
		$this->load->model ( 'cron_jobs_model', null, true );
		$this->load->model ( 'email_templates/email_templates_model' );
		$this->load->library('parser');
		$this->load->library ( 'emailer/emailer' );
	}
	
	/**
	 * Send notifications to customers whose listing is expiring in next few days
	 */
	public function send_notification() {
		// Find number of listings expiring in next few days
		$expiring_list = $this->cron_jobs_model->get_expiring_list ();
		if ($expiring_list) {
			// Retrieve template from database			
			$email_template = $this->email_templates_model->select ( 'subject, message' )->find ( 7 );
			$this->load->library ( 'parser' );
			foreach ( $expiring_list as $listing ) {
				$subject_data = array (
						'subject' => $email_template->subject,
						'listing_id' => $listing ['id'],
						'listing_title' => $listing ['title'],
						'expiring_on' => $listing ['expired_on']
				);
				$subject = $this->parser->parse ( 'email_templates/email_subject', $subject_data, TRUE );
				$message_data = array (
						'message' => $email_template->message,
						'listing_id' => $listing ['id'],
						'listing_title' => $listing ['title'],
						'contact_person' => !empty($listing['contact_person']) ? $listing['contact_person'] :'Sir',
						'email' => $listing ['email'],
						'expiring_on' => $listing ['expired_on'],
						'listing_url' => site_url ( '/detail/'  .$listing['slug']. '-in-' .strtolower(str_replace(" ","-", $listing['city'])) .'-' .$listing['id'] ),
						'site_title' => settings_item('site.title'),
						'url'	=> site_url()
				);
				$email = $this->parser->parse ( 'email_templates/email_body', $message_data, TRUE ); // TRUE is important to return string
				                                                                                  
				// Send Email				
				$data = array (
						'to' => $listing ['email'],
						'subject' => $subject,
						'message' => $email 
				);
				
				$this->emailer->send ( $data, FALSE );
			}
		}
	}
	
	public function reminder() {
		$expired_list = $this->cron_jobs_model->get_expired_list ();
		if($expired_list) {
			$reminder_template = $this->email_templates_model->select ( 'subject, message' )->find ( 8 );
			foreach ( $expired_list as $reminder ) {
				$reminder_subject = array (
						'subject' => $reminder_template->subject,
						'listing_id' => $reminder ['id'],
						'listing_title' => $reminder ['title']
				);
				$listing_subject = $this->parser->parse ( 'email_templates/email_subject', $reminder_subject, TRUE );
				$reminder_message = array (
						'message' => $reminder_template->message,
						'listing_id' => $reminder ['id'],
						'listing_title' => $reminder ['title'],
						'contact_person' => !empty($reminder['contact_person']) ? $reminder['contact_person'] :'Sir',
						'email' => $reminder ['email'],
						'listing_url' => site_url ( '/detail/'  .$reminder['slug']. '-in-' .strtolower(str_replace(" ","-", $reminder['city'])) .'-' .$reminder['id'] ),
						'site_title' => settings_item('site.title'),
						'url' => site_url()
				);
				$listing_message = $this->parser->parse ( 'email_templates/email_body', $reminder_message, FALSE ); // TRUE is important to return string
				// Send Email
				$reminder_data = array (
						'to' => $reminder ['email'],
						'subject' => $listing_subject,
						'message' => $listing_message
				);
				$this->emailer->send ( $reminder_data, FALSE );
			}
		}
	}
}