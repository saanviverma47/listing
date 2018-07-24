<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Cities_model extends CI_Model {

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

	public function get_cities_by_state($stateID=null){
		$this->db->select('*');
		$this->db->from("cities");
		if($stateID != 0) {
			$this->db->where(array('state_id' => $stateID));
		}
		$query = $this->db->get();
		return $query->result();
	}

	
}
