<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
 
 
 
 
 
 
 
 
 
 

class Pages extends Front_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('pages_model', null, true);
		$this->load->model('banners/banners_model');
		
		//Assets::add_module_js('pages', 'pages.js');
	}

	/**
	 * Display pages information to the user
	 * @param string $slug
	 */
	public function detail($slug = NULL)
	{	
		if($slug == NULL)	{
			redirect(site_url());
		} else {
			$banners = $this->banners_model->get_frontend_banners_all(); // retrieve banners
			$page_detail = $this->pages_model->select('title, body, meta_title, meta_keywords, meta_description')->find_by('slug', $slug);
			if($page_detail) {
				//footer pages link
				Template::set(array(
					'page_detail'=> $page_detail,
					'page_title' => $page_detail->meta_title,
					'page_keywords' => $page_detail->meta_keywords,
					'page_description' => $page_detail->meta_description,
					'banners' => $banners
					));
				Template::render();
			} else {
				redirect(site_url());
			}
		}
	}
	
	/**
	 * Contact Us Page
	 */
	public function contact() {
		Assets::add_js( $this->load->view('contact_js', null, true ), 'inline' );
		$banners = $this->banners_model->get_frontend_banners_all(); // retrieve banners
		Template::set('banners', $banners);
		Template::render();
	}
	
	/**
	 * CONTACT US FORM
	 * Send enquiry to site owner
	 *
	 */
	public function contact_query()
	{
		//important to include because of json
		header('Content-Type: application/x-json; charset=utf-8');
	
		//do Captcha check, make sure the submitter is not a robot:)...
		if(!$this->check_captcha('captcha_code')) {
			$this->errorResponse(lang('error_invalid_captcha'));
		}
		
		$name = escape($this->input->post ( 'name' ));
		$phone = escape($this->input->post ( 'phone' ));
		$email = escape($this->input->post ( 'email' ));
		$message = escape($this->input->post ( 'message' ));
		// insert into database
		$data = array (
				'name' => $name,
				'phone' => $phone,
				'email' => $email,
				'message' => $message,
				'ip'	=> $this->input->ip_address(),
				'posted_on' => date('Y-m-d H:m:s')
		);
	
		if($this->session->userdata('user_id')) {
			$data['user_id'] = $this->session->userdata('user_id');
		}
		
		// Retrieve template from database
		$this->load->model('email_templates/email_templates_model');
		$email_template = $this->email_templates_model->select('subject, message')->find(6);
		
		// Message
		$this->load->library('parser');
		$subject_data = array(
				'subject' => $email_template->subject
		);
		$subject = $this->parser->parse('email_templates/email_subject', $subject_data, TRUE);
		
		$message_data = array(
				'message' => $email_template->message,
				'name' => $name,
				'url' => site_url(),
				'phone_number' => settings_item('site.call_us')
		);
		$user_message = $this->parser->parse('email_templates/email_body', $message_data, TRUE); //TRUE is important to return string
		
		// Send User Email
		$this->load->library('emailer/emailer');
		$user_email = array(
				'to'		=> escape($this->input->post('email')),
				'subject'	=> $subject,
				'message'	=> $user_message
		);		
	
		$this->emailer->send($user_email, FALSE);
		$admin_message = '<strong>Name</strong>: ' . $name .'<br /><strong>Phone</strong>: ' . $phone .'<br /><strong>Email</strong>: ' . $email .'<br /><strong>Message</strong>: ' . $message .'<br /><strong>IP</strong>: ' . $this->input->ip_address() .'<br />';
		// Send Admin Email
		$admin_email = array(
				'from'		=> $email,
				'to'		=> settings_item('site.system_email'),
				'subject'	=> 'New query received',
				'message'	=> $admin_message
		);
		
		$this->emailer->send($admin_email, FALSE);
		
		if ($this->db->insert('contact_queries', $data )) {
			echo json_encode ( array (
					'message' => lang('success_message')
			) );
		} else {
			echo json_encode ( array (
					'message' => lang('failure_message')
			) );
		}
	}
	
	/**
	 * Check user entered captcha against provided image
	 * @param string $fieldname ($this->input->post())
	 * @return boolean
	 */
	public function check_captcha($fieldname) {
		$this->load->library ( 'securimage/securimage' );
		$securimage = new Securimage ();
		if (! $securimage->check ( $this->input->post ( $fieldname ) )) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
}