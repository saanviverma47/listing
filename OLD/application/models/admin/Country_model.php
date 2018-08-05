<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Country_model extends CI_Model {

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

	public function get_all_countries() {		
		$this->db->select('*');
		$this->db->from("countries");
		//$this->db->where(array('country.status' => 1));
		$query = $this->db->get();
		return $query->result();
	}

	public function get_country_by_id($countryId) {		
		$this->db->select('countries.name');
		$this->db->from("countries");
		$this->db->where(array('countries.id' =>$countryId));
		return $this->db->get()->row()->name;
		//return $query->result();
	}
	
}
