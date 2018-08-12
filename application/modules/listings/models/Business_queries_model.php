<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
 
 
 
 
 
 
 
 
 
 

class Business_queries_model extends BF_Model {

	protected $table_name	= "business_queries";
	protected $key			= "id";
	protected $soft_deletes	= true;
	protected $date_format	= "datetime";

	protected $log_user 	= FALSE;

	protected $set_created	= true;
	protected $set_modified = false;
	protected $created_field = "posted_on";
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
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= TRUE;

	//--------------------------------------------------------------------

	/**
	 * Display all queries to the member using logged in session value
	 * @param number $user_id
	 */
	public function get_business_queries($user_id) {
		$this->db->select('business_queries.*, L.title');
		$this->db->join('listings L','L.id = business_queries.listing_id AND L.deleted = 0', 'INNER');
		return $this->business_queries_model->find_all_by(array('business_queries.deleted' => 0, 'L.user_id'=> $user_id));
	}

	/**
	 * To display total number of business queries (at left hand side) received by a particular business owner
	 * For pagination and count display
	 * @param number $user_id
	 */
	public function count_business_queries($user_id) {
		$this->db->select('business_queries.*');
		$this->db->join('listings L','L.id = business_queries.listing_id AND L.deleted = 0', 'INNER');
		return $this->business_queries_model->count_by(array('business_queries.deleted' => 0, 'L.user_id'=> $user_id));
	}
	
	/**
	 * Get sender email address and name from database in order to send a business query reply
	 * @param int $id
	 * @return object
	 */
	public function get_email_addresses($id) {
		$this->db->select('business_queries.email as email_to, business_queries.name, L.email as email_from, L.title');
		$this->db->join('listings L','L.id = business_queries.listing_id AND L.deleted = 0', 'INNER');
		return $this->business_queries_model->find_by(array('business_queries.id' => $id));
	}

}
