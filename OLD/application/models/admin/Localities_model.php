<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Localities_model extends CI_Model {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}

	public function get_localities_by_cities($cityID=null){
		$this->db->select('*');
		$this->db->from("localities");
		if($cityID != 0) {
			$this->db->where(array('city_id' => $cityID));
		}
		$query = $this->db->get();
		return $query->result();
	}

	
}
