<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
 
 
 
 
 
 
 
 
 
 

class Products_model extends BF_Model {

	protected $table_name	= "products";
	protected $key			= "id";
	protected $soft_deletes	= false;
	protected $date_format	= "datetime";

	protected $log_user 	= FALSE;

	protected $set_created	= true;
	protected $set_modified = true;
	protected $created_field = "created_on";
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
			"field"		=> "products_title",
			"label"		=> "lang:label_title",
			"rules"		=> "required|max_length[100]|alpha_title|sanitize"
		),
		array(
			"field"		=> "products_type",
			"label"		=> "lang:label_type",
			"rules"		=> "required"
		),
		array(
			"field"		=> "products_price",
			"label"		=> "lang:label_price",
			"rules"		=> "trim|required|is_numeric|greater_than[0.99]|sanitize"
		),
		array(
			"field"		=> "products_description",
			"label"		=> "Description",
			"rules"		=> "xss_clean|max_length[4500]"
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= FALSE;

	/**
	 * Get products information with total count of services and title
	 * @param number $listing_id
	 * @return object
	 */
	public function get_products($listing_id) {
		$sql = "SELECT *, ";
		$sql .= "(SELECT COUNT(*) FROM " . $this->db->dbprefix . "products WHERE type = 'product' AND listing_id = " .$listing_id ." AND active = 1) as Total_Product,";
		$sql .= " (SELECT COUNT(*) FROM " . $this->db->dbprefix . "products WHERE type = 'service' AND listing_id = " .$listing_id ." AND active = 1) as Total_Service";
		$sql .= " FROM " . $this->db->dbprefix . "products WHERE listing_id = " .$listing_id ." AND active = 1";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}
	
	/**
	 * Get a single product related to a particular listing
	 * @param number $id
	 * @param number $user_id
	 */
	public function get_products_member($id, $user_id) {
		$this->db->select('products.*');
		$this->db->join('listings L','L.id = products.listing_id AND L.deleted = 0', 'INNER');
		return $this->products_model->find_by(array('products.id' => $id, 'L.user_id'=> $user_id));
	}
	
	/**
	 * Get all products related to a particular listing
	 * @param number $listing_id
	 * @param number $user_id
	 */
	public function get_listing_products($listing_id, $user_id) {
		$this->db->select('products.*');
		$this->db->join('listings L','L.id = products.listing_id AND L.deleted = 0', 'INNER');
		return $this->products_model->find_all_by(array('products.listing_id' => $listing_id, 'L.user_id'=> $user_id));
	}
}
