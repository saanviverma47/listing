<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
 
 
 
 
 
 
 
 
 
 

class Cron_jobs_model extends BF_Model {
	
	// Find all listing expiring in the next few days
	public function get_expiring_list() {
		$sql = "SELECT L.id, title, L.slug, email, expired_on, contact_person, C.name as country, S.name as state, CT.name as city FROM " . $this->db->dbprefix . "listings L";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "countries C ON L.country_iso = C.iso";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "states S ON L.state_id = S.id";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "cities CT ON L.city_id = CT.id";
		$sql .= " WHERE expired_on = DATE( CURDATE() + INTERVAL ". settings_item('fin.days_before_email') ." DAY ) + INTERVAL 0 SECOND";
		$query = $this->db->query ( $sql );
		$result = $query->result_array ();
		return $result;
	}
	
	// Find all expired listings
	public function get_expired_list() {
		$sql = "SELECT L.id, title, L.slug, email, expired_on, contact_person, C.name as country, S.name as state, CT.name as city FROM " . $this->db->dbprefix . "listings L";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "countries C ON L.country_iso = C.iso";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "states S ON L.state_id = S.id";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "cities CT ON L.city_id = CT.id";
		$sql .= " WHERE expired_on = DATE( CURDATE() + INTERVAL 0 DAY ) + INTERVAL 0 SECOND";
		$query = $this->db->query ( $sql );
		$result = $query->result_array ();
		return $result;
	}
}