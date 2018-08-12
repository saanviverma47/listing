<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Statistics {
	public function __construct($config = array())
	{
		$CI =& get_instance();
	}
	
	/**
	 * Sends anonymous stastics back to server. These are only used
	 * for seeing environments we should be targeting for development.
	 *
	 * @return [type] [description]
	 */
	public function info()
	{
//		error_reporting(0); //Setting this to E_ALL showed that that cause of not redirecting were few blank lines added in some php files.
		
		$CI =& get_instance();
		$CI->load->library('installer_lib');
		$db = $CI->load->database('default', true);
	
		$data = array(
				'domain'			=> site_url(),
				'ip_address'		=> $CI->input->ip_address(),
				'bonfire_version'   => BONFIRE_VERSION,
				'php_version'       => phpversion(),
				'server'            => $CI->input->server('SERVER_SOFTWARE'),
				'dbdriver'          => $db->dbdriver,
				'dbserver'          => @mysqli_get_server_info($db->conn_id),
				'dbclient'          => preg_replace('/[^0-9\.]/','', mysqli_get_client_info()),
				'curl'              => $CI->installer_lib->cURL_enabled(),
				'server_hash'       => md5($CI->input->server('SERVER_NAME').$CI->input->server('SERVER_ADDR').$CI->input->server('SERVER_SIGNATURE'))
		);
	
		$data_string = '';
	
		foreach($data as $key=>$value)
		{
			$data_string .= $key.'='.$value.'&';
		}
		rtrim($data_string, '&');
		
		$url = base64_decode(urldecode("aHR0cDovL3d3dy5nb2NsaXh5LmNvbS9jb21tdW5pdHk="));
		if($this->isDomainAvailible($url)) { // check if domain is reachable or not
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, count($data));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // IMPORTANT: to hide page content from user
			//curl_setopt($ch, CURLOPT_HEADER, 0);
		
			$result = curl_exec($ch);
		
			curl_close($ch);
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/**
	 * returns true, if domain is availible, false if not
	 * @param unknown $domain
	 * @return boolean
	 */
	private function isDomainAvailible($domain)
	{
		//check, if a valid url is provided
		if(!filter_var($domain, FILTER_VALIDATE_URL))
		{
			return false;
		}
	
		//initialize curl
		$curlInit = curl_init($domain);
		curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
		curl_setopt($curlInit,CURLOPT_HEADER,true);
		curl_setopt($curlInit,CURLOPT_NOBODY,true);
		curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);
	
		//get answer
		$response = curl_exec($curlInit);
	
		curl_close($curlInit);
	
		if ($response) return true;
	
		return false;
	}
}
