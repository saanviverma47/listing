<?php
/**
 * This class extends the core Encrypt class, and allows you
 * to use encrypted strings in your URLs.
 */
class MY_Encrypt extends CI_Encrypt
{
	private $encryptionKey = '';
	
	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->CI =& get_instance();
		$CI =& get_instance();
		$this->encryptionKey = $this->CI->config->item('encryption_key');
	}
	
    /**
	 * Base64 URL Encode
	 * @param string $plainText
	 * @return string
	 */
	public function base64url_encode($plainText) {
		$base64 = base64_encode($plainText);
		$base64url = strtr($base64, '+/=', '-_,');
		return $base64url;
	}
	
	/**
	 * Base64 URL Decode
	 * @param string $plainText
	 * @return string
	 */
	public function base64url_decode($plainText) {
		$base64url = strtr($plainText, '-_,', '+/=');
		$base64 = base64_decode($base64url);
		return $base64;
	}
	
	/**
	 * Encode URL ID
	 * @see CI_Encrypt::encode()
	 */
	public function encode($int, $key = '') {
		return $this->base64url_encode($int.'-'.substr(sha1($this->encryptionKey), 0, 6));
	}
	
	/**
	 * Decode URL ID
	 * @see CI_Encrypt::decode()
	 */
	public function decode($string, $key = '') {
		$parts = explode('-', $this->base64url_decode($string));
		if (count($parts) != 2) {			 
			return 0;
		}
		$int = $parts[0];
		return substr(sha1($this->encryptionKey), 0, 6) === $parts[1] ? (int)$int : 0;
	}
}

// End of file: MY_Encrypt.php
// Location: ./system/application/helpers/MY_Encrypt.php  