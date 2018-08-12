<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Bonfire
 *
 * An open source project to allow developers get a jumpstart their development of CodeIgniter applications
 *
 * @package   Bonfire
 * @author    Bonfire Dev Team
 * @copyright Copyright (c) 2011 - 2013, Bonfire Dev Team
 * @license   http://guides.cibonfire.com/license.html
 * @link      http://cibonfire.com
 * @since     Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Form Validation
 *
 * This class extends the CodeIgniter core Form_validation library to add
 * extra functionality used in Bonfire.
 *
 * @package    Bonfire
 * @subpackage Libraries
 * @category   Libraries
 * @author     Bonfire Dev Team
 * @link       http://guides.cibonfire.com/core/form_validation.html
 *
 */
class MY_Form_validation extends CI_Form_validation
{


	/**
	 * Stores the CodeIgniter core object.
	 *
	 * @access public
	 *
	 * @var object
	 */
	public $CI;

	//--------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @return void
	 */
	function __construct($config = array())
	{
		// Merged super-global $_FILES to $_POST to allow for better file validation inside of Form_validation library
		$_POST = (isset($_FILES) && is_array($_FILES) && count($_FILES) > 0) ? array_merge($_POST,$_FILES) : $_POST;
		parent::__construct($config);

	}//end __construct()

	//--------------------------------------------------------------------

	/**
	 * Returns Form Validation Errors in a HTML Un-ordered list format.
	 *
	 * @access public
	 *
	 * @return string Returns Form Validation Errors in a HTML Un-ordered list format.
	 */
	public function validation_errors_list()
	{
		if (is_array($this->CI->form_validation->_error_array))
		{
			$errors = (array) $this->CI->form_validation->_error_array;
			$error  = '<ul>' . PHP_EOL;

			foreach ($errors as $error)
			{
				$error .= "	<li>{$error}</li>" . PHP_EOL;
			}

			$error .= '</ul>' . PHP_EOL;
			return $error;
		}

		return FALSE;

	}//end validation_errors_list()
	
	/**
	 * Check that a string only contains array values
	 *
	 * @access public
	 *
	 * @param string $str The string value to check
	 *
	 * @return	bool
	 */
	function is_array($str)
	{
		$this->CI->form_validation->set_message('is_array', lang('gc_form_is_array'));
		return ( is_array($str)) ? FALSE : TRUE;
	
	}//end is_array()

	//--------------------------------------------------------------------

	/**
	 * Performs the actual form validation
	 *
	 * @access public
	 *
	 * @param string $module Name of the module
	 * @param string $group  Name of the group array containing the rules
	 *
	 * @return bool Success or Failure
	 */
	public function run($module='', $group='')
	{
		(is_object($module)) AND $this->CI =& $module;
		return parent::run($group);

	}//end run()

	//--------------------------------------------------------------------



	/**
	 * Checks that a value is unique in the database
	 *
	 * i.e. '…|required|unique[users.name.id.4]|trim…'
	 *
	 * @abstract Rule to force value to be unique in table
	 * @usage "unique[tablename.fieldname.(primaryKey-used-for-updates).(uniqueID-used-for-updates)]"
	 * @access public
	 *
	 * @param mixed $value  The value to be checked
	 * @param mixed $params The table and field to check against, if a second field is passed in this is used as "AND NOT EQUAL"
	 *
	 * @return bool
	 */
	function unique($value, $params)
	{
		$this->CI->form_validation->set_message('unique', lang('bf_form_unique'));

		// allow for more than 1 parameter
		$fields = explode(",", $params);

		// extract the first parameter
		list($table, $field) = explode(".", $fields[0], 2);

		// setup the db request
		$this->CI->db->select($field)->from($table)
			->where($field, $value)->limit(1);

		// check if there is a second field passed in
		if (isset($fields[1]))
		{
			// this field is used to check that it is not the current record
			// eg select * from users where username='test' AND id != 4

			list($where_table, $where_field) = explode(".", $fields[1], 2);

			$where_value = $this->CI->input->post($where_field);
			if (isset($where_value))
			{
				// add the extra where condition
				$this->CI->db->where($where_field.' !=', $this->CI->input->post($where_field));
			}
		}

		// make the db request
		$query = $this->CI->db->get();

		if ($query->row())
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}

	}//end unique()

	// --------------------------------------------------------------------

	/**
	 * Check that a string only contains Alpha-numeric characters with
	 * periods, underscores, spaces and dashes
	 *
	 * @abstract Alpha-numeric with periods, underscores, spaces and dashes
	 * @access public
	 *
	 * @param string $str The string value to check
	 *
	 * @return	bool
	 */
	function alpha_extra($str)
	{
		$this->CI->form_validation->set_message('alpha_extra', lang('bf_form_alpha_extra'));
		return ( ! preg_match("/^([\.\s-a-z0-9_-])+$/i", $str)) ? FALSE : TRUE;

	}//end alpha_extra()
	
	/**
	 * Check that a string only contains Alpha-numeric characters with no
	 * periods, underscores, spaces and dashes
	 *
	 * @abstract Alpha-numeric with periods, underscores, spaces and dashes
	 * @access public
	 *
	 * @param string $str The string value to check
	 *
	 * @return	bool
	 */
	function alpha_title($str)
	{
		$this->CI->form_validation->set_message('alpha_title', lang('bf_form_alpha_title'));
		return ( ! preg_match("/^([A-Za-z0-9])+$/i", $str)) ? FALSE : TRUE;
	
	}//end alpha_extra()
	
	/**
	 * Check that a string only contains Alpha-numeric characters with
	 * periods, underscores, spaces and dashes
	 *
	 * @abstract Alpha-numeric with periods, underscores, spaces and dashes
	 * @access public
	 *
	 * @param string $str The string value to check
	 *
	 * @return	bool
	 */
	function alpha_keyword($str)
	{
		$this->CI->form_validation->set_message('alpha_keyword', lang('bf_form_alpha_keyword'));
		return ( ! preg_match("/^([\s-a-z0-9,])+$/i", $str)) ? FALSE : TRUE;
	
	}//end alpha_keyword()
	
	/**
	 * Check that a string only contains valid values, there should be 
	 * no extra space and commas
	 *
	 * @abstract Alpha-numeric with spaces and commas
	 * @access public
	 *
	 * @param string $str The string value to check
	 *
	 * @return	bool
	 */
	function tag_handling($str)
	{
		/* "/\s+/", "/\s([?.!])/" to remove extra spaces used, 
		"/\,+/", "/\,([?.!])/" to remove extra commas if any between each keyword
		"/\s,+/", "/\,([?.!])/" to remove space between word and comma*/
		//Get keywords with minimum length of four including space
		preg_match_all('/([\s-a-z0-9]{4,})/i', $str, $matches, PREG_PATTERN_ORDER); 
		// Retrieve only first array from multidimensional array
		$keywords_with_minimum_length = implode(',', $matches[0]);
		// Match below given pattern and replace specified information
		$patterns = array("/\s+/", "/\s([?.!])/", "/\,+/", "/\,([?.!])/", "/\s,+/", "/\,([?.!])/");
		$replacer = array(" ","$1", ",","$1");
		// Convert keywords to lower character
		return strtolower(trim(preg_replace( $patterns, $replacer, $keywords_with_minimum_length))); //REMOVE WHITE SPACES BEFORE AND AFTER COMMAS
	}

	// --------------------------------------------------------------------

	/**
	 * Check that the string matches a specific regex pattern
	 *
	 * @access public
	 *
	 * @param string $str     The string to check
	 * @param string $pattern The pattern used to check the string
	 *
	 * @return bool
	 */
	function matches_pattern($str, $pattern)
	{
		if (preg_match('/^' . $pattern . '$/', $str))
		{
			return TRUE;
		}

		$this->CI->form_validation->set_message('matches_pattern', lang('bf_form_matches_pattern'));

		return FALSE;

	}//end matches_pattern()

	// --------------------------------------------------------------------

	/**
	 * Check if the field has an error associated with it.
	 *
	 * @access public
	 *
	 * @param string $field The name of the field
	 *
	 * @return bool
	 */
	public function has_error($field=null)
	{
		if (empty($field))
		{
			return FALSE;
		}

		return !empty($this->_field_data[$field]['error']) ? TRUE : FALSE;

	}//end has_error()

	//--------------------------------------------------------------------


	/**
	 * Check the entered password against the password strength settings.
	 *
	 * @access public
	 *
	 * @param string $str The password string to check
	 *
	 * @return bool
	 */
	public function valid_password($str)
	{
		// get the password strength settings from the database
		$min_length	= $this->CI->settings_lib->item('auth.password_min_length');
		$use_nums   = $this->CI->settings_lib->item('auth.password_force_numbers');
		$use_syms   = $this->CI->settings_lib->item('auth.password_force_symbols');
		$use_mixed  = $this->CI->settings_lib->item('auth.password_force_mixed_case');

		// Check length
		if (strlen($str) < $min_length)
		{
			$this->CI->form_validation->set_message('valid_password', str_replace('{min_length}', $min_length, lang('bf_form_valid_password') ) );
			return FALSE;
		}

		// Check numbers
		if ($use_nums)
		{
			if (0 === preg_match('/[0-9]/', $str))
			{
				$this->CI->form_validation->set_message('valid_password', lang('bf_form_valid_password_nums'));
				return FALSE;
			}
		}

		// Check Symbols
		if ($use_syms)
		{
			if (0 === preg_match('/[!@#$%^&*()._]/', $str))
			{
				$this->CI->form_validation->set_message('valid_password', lang('bf_form_valid_password_syms'));
				return FALSE;
			}
		}

		// Mixed Case?
		if ($use_mixed)
		{
			if (0 === preg_match('/[A-Z]/', $str))
			{
				$this->CI->form_validation->set_message('valid_password', lang('bf_form_valid_password_mixed_1'));
				return FALSE;
			}

			if (0 === preg_match('/[a-z]/', $str))
			{
				$this->CI->form_validation->set_message('valid_password', lang('bf_form_valid_password_mixed_2'));
				return FALSE;
			}
		}

		return TRUE;

	}//end valid_password()

	//--------------------------------------------------------------------

	/**
	 * Allows setting allowed file-types in your form_validation rules.
	 * Please separate the allowed file types with a pipe or |.
	 *
	 * @author Shawn Crigger <support@s-vizion.com>
	 * @access public
	 *
	 * @param string $str   String field name to validate
	 * @param string $types String allowed types
	 *
	 * @return bool If files are in the allowed type array then TRUE else FALSE
	 */
	public function allowed_types($str, $types = NULL)
	{
		if (!$types)
		{
			log_message('debug', 'form_validation method allowed_types was called without any allowed types.');
			return FALSE;
		}

		$type = explode('|', $types);
		$filetype = pathinfo($str['name'],PATHINFO_EXTENSION);

		if (!in_array($filetype, $type))
		{
			$this->CI->form_validation->set_message('allowed_types', lang('bf_form_allowed_types'));
			return FALSE;
		}

		return TRUE;

	}//end allowed_types()

	//--------------------------------------------------------------------

	/**
	 * Checks that the entered string is one of the values entered as the second parameter.
	 * Please separate the allowed file types with a comma.
	 *
	 * @access public
	 *
	 * @param string $str      String field name to validate
	 * @param string $options String allowed values
	 *
	 * @return bool If files are in the allowed type array then TRUE else FALSE
	 */
	public function one_of($str, $options = NULL)
	{
		if (!$options)
		{
			log_message('debug', 'form_validation method one_of was called without any possible values.');
			return FALSE;
		}

		log_message('debug', 'form_validation one_of options:'.$options);

		$possible_values = explode(',', $options);

		if (!in_array($str, $possible_values))
		{
			$this->CI->form_validation->set_message('one_of', lang('bf_form_one_of'));
			return FALSE;
		}

		return TRUE;

	}//end one_of()

	//--------------------------------------------------------------------

	/**
	 * Allows Setting maximum file upload size in your form validation rules.
	 *
	 * @author Shawn Crigger <support@s-vizion.com>
	 * @access public
	 *
	 * @param string  $str  String field name to validate
	 * @param integer $size Integer maximum upload size in bytes
	 *
	 * @return bool
	 */
	public function max_file_size($str, $size = 0)
	{
		if ($size == 0)
		{
			log_message('error', 'Form_validation rule, max_file_size was called without setting a allowable file size.');
			return FALSE;
		}

		return (bool) ($str['size']<=$size);

	}//end max_file_size()
	
	/**
	 * Check that captcha is valid
	 *
	 * @access public
	 *
	 * @param string $str Name of the field
	 *
	 * @return bool
	 */
	public function valid_captcha($str) {
		$this->CI->load->library ( 'securimage/securimage' );
		$securimage = new Securimage();
		if ((! $securimage->check ($str))) {
			$this->CI->form_validation->set_message('valid_captcha', '%s should be valid');
			return FALSE;
		}
		return TRUE;
	}
	
	/**
	 * Validate phone number
	 *
	 * @access public
	 *
	 * @param string $phone_number Name of the field
	 *
	 * @return bool
	 */
	public function phone_check($phone_number)
	{
		$regex = '^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$^';
		//$regex = '^\+(9[976]\d|8[987530]\d|6[987]\d|5[90]\d|42\d|3[875]\d|2[98654321]\d|9[8543210]|8[6421]|6[6543210]|5[87654321]|4[987654310]|3[9643210]|2[70]|7|1)\W*\d\W*\d\W*\d\W*\d\W*\d\W*\d\W*\d\W*\d\W*(\d{1,2})$^'; // validates 123 123 1234 123
		if (!preg_match($regex, $phone_number)) {
			$this->CI->form_validation->set_message('phone_check', lang('bf_form_not_valid'));
			return false;
		}
		return true;
	}
	
	/**
	 * Validate US phone number
	 *
	 * @access public
	 *
	 * @param string $phone_number Name of the field
	 *
	 * @return bool
	 */
	public function us_phone_check($phone_number)
	{
		$regex = '^((((\(\d{3}\))|(\d{3}-))\d{3}-\d{4})|(\+?\d{2}((-| )\d{1,8}){1,5}))(( x| ext)\d{1,5}){0,1}$^'; // validates 123 123 1234 123
		if (!preg_match($regex, $phone_number)) {
			$this->CI->form_validation->set_message('us_phone_check', lang('bf_form_not_valid'));
			return false;
		}
		return true;
	}
	
	/**
	 * Use sanitize function defined in MY_Form_Helper
	 * @param unknown $string
	 * @return Ambigous <string, mixed>
	 */
	public function sanitize($string)
	{
		return textile_sanitize($string);
	}
	
	/**
	 * Validate date and time
	 * @param datetime $datetime
	 * @return boolean
	 */
	public function valid_datetime($datetime)
	{
		$pattern = '[\d{4}-(0[1-9]|1[0-2])-(0[1-9]|1[0-9]|2[0-9]|3(0|1))]';
		if(preg_match($pattern, $datetime)) {
			return true;
		}
		else {
			$this->CI->form_validation->set_message('valid_datetime', lang('bf_form_valid_date_time'));
			return false;
		}
	}
	
	/**
	 * Check whether date is in the correct format or not
	 * @param unknown $date
	 * @return boolean
	 */
	public function valid_date($date, $time = 'FALSE') {
		/*
		 * $regex = '/^((((19|[2-9]\d)\d{2})\-(0[13578]|1[02])\-(0[1-9]|[12]\d|3[01]))|(((19|[2-9]\d)\d{2})\-(0[13456789]|1[012])\-(0[1-9]|[12]\d|30))|(((19|[2-9]\d)\d{2})\-02\-(0[1-9]|1\d|2[0-8]))|(((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))\-02\-29))$/';
		if ( preg_match($regex, $date) ) {
		return true;
		} else {
		}
		*/
		$format = 'Y-m-d';
		if($time == 'TRUE') {
			$format = 'Y-m-d H:i:s';
			if(empty($date) || $date == '0000-00-00 00:00:00') {
				return true;
			}
		} else if(empty($date) || $date == '0000-00-00') {
			return true;
		}
	
		$d = DateTime::createFromFormat($format, $date);
		//Check for valid date in given format
		if($d && $d->format($format) == $date) {
			return true;
		} else {
			$this->CI->form_validation->set_message('valid_date', lang('gc_valid_date'));
			return false;
		}
	}
	/**
	 * Check URL fields.
	 *
	 * @access public
	 * @param mixed $fields
	 * @param string $err_msg (default: '')
	 * @return void
	 */
	public function valid_url($str) {
		$regexp =  "/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i";
		//$regexp = "/((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)/i";
		//$regexp = "/^((http|ftp|https):\/\/|((www|WWW)\.)){1}?([a-zA-Z0-9]+(\.[a-zA-Z0-  9]+)+(\.[a-zA-Z0-9]+)*)$/";
		if(preg_match($regexp, $str)) {
			return true;
		} else {
			$this->CI->form_validation->set_message('valid_url', lang('bf_form_not_valid'));
			return false;
		}
	}
	
	/**
	 * Maximum number of keywords allowed for a user
	 * @param string $keywords
	 * @param number $max_count
	 * @return boolean
	 */
	public function keywords_limit($keywords, $max_count = 0) {
		$count = substr_count($keywords, ',') + 1;
		if(($count <= $max_count) || ($max_count == 0)) {
			return true;
		} else {
			$this->CI->form_validation->set_message('keywords_limit', sprintf(lang('bf_form_max_keywords'), lang('label_keywords'), $max_count));
			return false;
		}
	}
	
	/**
	 * Check whether integer value is greater than a specific value
	 *
	 * @access public
	 *
	 * @param string $int_field Name of the field
	 * @param integer $val specific value of the field
	 * @return bool
	 */
	
	public function max_val($int_field, $val) {
		if (intval ( $int_field ) > $val) {
			$this->CI->form_validation->set_message ( 'max_val', lang('bf_max_value') );
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	/**
	 * Check whether integer value is lesser than a specific value
	 *
	 * @access public
	 *
	 * @param string $int_field Name of the field
	 * @param integer $val specific value of the field
	 * @return bool
	 */
	
	public function min_val($int_field, $val) {
		if (($val > 0) && (intval ( $int_field ) < $val)) {
			$this->CI->form_validation->set_message ( 'min_val', lang('bf_min_value'));
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	/**
	 * Check whether first field is less than second field
	 *
	 * @access public
	 *
	 * @param string $second_field Name of the second field
	 * @param string $first_field Name of the first field
	 * @return bool
	 */
	
	public function compare_fields($second_field, $first_field) {
		if ($second_field < $first_field) {
			$this->CI->form_validation->set_message('compare_fields', lang('bf_compare_fields'));
			return false;
		} else {
			return true;
		}
	}
	
	/**
	 * Check whether two particular fields difference is greater than a particular value
	 *
	 * @access public
	 *
	 * @param string $second_field Name of the second field
	 * @param string $first_field Name of the first field
	 * @return bool
	 */
	
	public function diff_between($second_field, $first_field) {
		// diff_between[first_field, value]
		$param = preg_split('/,/', $first_field);
		$first_field = $param[0];
		$val = $param[1];
	
		$fields_difference = $second_field - $first_field;
		if (($fields_difference) > $val) {
			$this->CI->form_validation->set_message('diff_between', lang('bf_diff_between'));
			return false;
		} else {
			return true;
		}
	}
	
	/**
	 * Check that a string only contains decimal values
	 * FOR TAX RATES, TOOLS AND SETTINGS
	 * @access public
	 *
	 * @param string $str The string value to check
	 *
	 * @return	bool
	 */
	function is_decimal($str) {
		//$regex = "/^([\.0-9])+$/i";
		$regex = '/^[+\-]?(?:\d+(?:\.\d*)?|\.\d+)$/';
		$this->CI->form_validation->set_message('is_decimal', lang('gc_form_decimal_extra'));
		return ( ! preg_match($regex, $str)) ? FALSE : TRUE;
	
	}//end is_decimal()
	
	/**
	 * File upload error message
	 */
	function valid_file_upload($filename) {
		if(!empty($filename)) {
			$this->CI->form_validation->set_message('valid_file_upload', $this->CI->session->flashdata('upload_image_error'));
			return false;
		}
		return true;
	}

	//--------------------------------------------------------------------

}//end class

//--------------------------------------------------------------------
// Helper Functions for Form Validation LIbrary
//--------------------------------------------------------------------

	/**
	 * Check if the form has an error
	 *
	 * @access public
	 *
	 * @param string $field Name of the field
	 *
	 * @return bool
	 */
	function form_has_error($field=null)
	{

		if (FALSE === ($OBJ =& _get_validation_object()))
		{
			return FALSE;
		}

		$return = $OBJ->has_error($field);

		return $return;
	}//end form_has_error()
//--------------------------------------------------------------------


/* Author :  http://net.tutsplus.com/tutorials/php/6-codeigniter-hacks-for-the-masters/ */
/* End of file : ./libraries/MY_Form_validation.php */