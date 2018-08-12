<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
 
 
 
 
 
 
 
 
 
 

class Claim_reports_model extends BF_Model {

	protected $table_name	= "claim_reports";
	protected $key			= "id";
	protected $soft_deletes	= false;
	protected $date_format	= "datetime";

	protected $log_user 	= FALSE;

	protected $set_created	= true;
	protected $set_modified = true;
	protected $created_field = "reported_on";
	protected $modified_field = "modified_on";

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
			"field"		=> "claim_reports_description",
			"label"		=> "lang:label_description",
			"rules"		=> "max_length[450]|xss_clean"
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= FALSE;

	/**
	 * Get Claims and Incorrects for index page
	 */
	public function get_claim_reports() {
			$this->db->select('claim_reports.*, U.display_name, L.title as listing_title');
			$this->db->join('users U','U.id = claim_reports.user_id', 'left');
			$this->db->join('listings L','L.id = claim_reports.listing_id', 'inner');
			return $this->claim_reports_model->find_all();
	}
	
	/**
	 * Get Claim or Incorrect for view page
	 * @param number $id
	 */
	public function get_claim_incorrect($id) {
		$this->db->select('claim_reports.*, U.display_name, L.title as listing_title');
		$this->db->join('users U','U.id = claim_reports.user_id', 'left');
		$this->db->join('listings L','L.id = claim_reports.listing_id', 'inner');
		return $this->claim_reports_model->find($id);
	}
}
