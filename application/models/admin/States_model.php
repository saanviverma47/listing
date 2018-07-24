<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class States_model extends CI_Model {

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

	public function get_states_by_country($countryId = 0) {		
		$this->db->select('*');
		$this->db->from("states");
		if($countryId != 0) {
			$this->db->where(array('country_id' => $countryId));
		}
		$query = $this->db->get();
		return $query->result();
	}

	public function get_state_by_id($stateID){
		$this->db->select('states.name');
		$this->db->from("states");
		$this->db->where(array('states.id' =>$stateID));
		return $this->db->get()->row()->name;
	}

	
}
