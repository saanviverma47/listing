<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
 
 
 
 
 
 
 
 
 
 

class Cities_model extends BF_Model {

	protected $table_name	= "cities";
	protected $key			= "id";
	protected $soft_deletes	= false;
	protected $date_format	= "datetime";

	protected $log_user 	= FALSE;

	protected $set_created	= false;
	protected $set_modified = false;

	/*
		Customize the operations of the model without recreating the insert, update,
		etc methods by adding the method names to act as callbacks here.
	 */
	protected $before_insert 	= array();
	protected $after_insert 	= array();
	protected $before_update 	= array();
	protected $after_update 	= array();
	protected $before_find 		= array();
	protected $after_find 		= array();
	protected $before_delete 	= array();
	protected $after_delete 	= array();

	/*
		For performance reasons, you may require your model to NOT return the
		id of the last inserted row as it is a bit of a slow method. This is
		primarily helpful when running big loops over data.
	 */
	protected $return_insert_id 	= TRUE;

	// The default type of element data is returned as.
	protected $return_type 			= "object";

	// Items that are always removed from data arrays prior to
	// any inserts or updates.
	protected $protected_attributes = array();

	/*
		You may need to move certain rules (like required) into the
		$insert_validation_rules array and out of the standard validation array.
		That way it is only required during inserts, not updates which may only
		be updating a portion of the data.
	 */
	protected $validation_rules 		= array(
		array(
			"field"		=> "cities_name",
			"label"		=> "lang:label_name",
			"rules"		=> "required|unique[cities.name,cities.id]|max_length[40]|sanitize"
		),
		array(
			"field"		=> "cities_abbrev",
			"label"		=> "lang:label_code",
			"rules"		=> "alpha|max_length[3]"
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= FALSE;

	//--------------------------------------------------------------------
	
	/**
	 * Get all states
	 * @return Object
	 */
	public function get_states(){
		$this->db->select('id, name');
		return $this->db->get('states')->result();
	}
	
	/**
	 * Display state code on city page
	 * @param number $state_id
	 */
	public function get_cities_state($state_id = 0) {
		$this->db->select('cities.id, cities.name, cities.abbrev, cities.active, states.abbrev as states_abbrev');
		$this->db->join('states','states.id = cities.state_id', 'left');
		//USER ENTERED URL WITHOUT STATE ID
		if($state_id != 0) {
			$this->db->where('states.id', $state_id);
		}
		$this->db->order_by('states.abbrev', 'asc');
		return $this->cities_model->find_all();
	}
	
	/**
	 * Frontend search function to get city and locality ID
	 * @param string $city
	 * @param number $locality_id
	 */
	public function get_city_locality($city, $locality_id) {
		$this->db->select('cities.id as city_id, cities.name as city_name, localities.id as locality_id');
		$this->db->join('localities', 'cities.id = localities.city_id', 'INNER');
		return $this->cities_model->find_by(array('cities.name' => $city, 'localities.id' => $locality_id));
	}
	
	/**
	 * Get all cities when admin disables Country and State selection from settings
	 */
	public function get_all_cities($country_iso) {		
		$this->db->select('cities.id, cities.name');
		$this->db->join('states', 'states.id = cities.state_id', 'INNER');
		$this->db->where(array('cities.active' => 1, 'states.country_iso' => $country_iso));
		return $this->cities_model->find_all();
	}

}
