<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
############################################################## ||
 
 
 
 
 
 
 
 
 
 

class Packages_model extends BF_Model {

	protected $table_name	= "packages";
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
			"field"		=> "packages_title",
			"label"		=> "lang:label_title",
			"rules"		=> "max_length[100]|trim|required"
		),
		array(
			"field"		=> "packages_description",
			"label"		=> "lang:label_description",
			"rules"		=> "trim"
		),
		array(
			"field"		=> "packages_duration",
			"label"		=> "lang:label_duration",
			"rules"		=> "max_length[3]|is_numeric"
		),
		array(
			"field"		=> "packages_price",
			"label"		=> "lang:label_price",
			"rules"		=> "max_length[5]|is_decimal"
		),
		array(
			"field"		=> "packages_claim_price",
			"label"		=> "lang:label_claim_price",
			"rules"		=> "max_length[5]|is_decimal"
		),
		array(
			"field"		=> "packages_listings_limit",
			"label"		=> "lang:label_listings_limit",
			"rules"		=> "max_length[2]|is_numeric"
		),
		array(
			"field"		=> "packages_keywords_limit",
			"label"		=> "lang:label_keywords_limit",
			"rules"		=> "max_length[2]|is_numeric"
		),
		array(
			"field"		=> "packages_keywords_length",
			"label"		=> "lang:label_keywords_length",
			"rules"		=> "max_length[5]|is_numeric"
		),
		array(
			"field"		=> "packages_description_length",
			"label"		=> "lang:label_description_length",
			"rules"		=> "max_length[8]|is_numeric"
		),
		array(
			"field"		=> "packages_images_limit",
			"label"		=> "lang:label_images_limit",
			"rules"		=> "max_length[4]|is_numeric"
		),
		array(
			"field"		=> "packages_videos_limit",
			"label"		=> "lang:label_videos_limit",
			"rules"		=> "max_length[4]|is_numeric"
		),
		array(
			"field"		=> "packages_products_limit",
			"label"		=> "lang:label_products_limit",
			"rules"		=> "max_length[2]|is_numeric"
		),
		array(
			"field"		=> "packages_classifieds_limit",
			"label"		=> "lang:label_classifieds_limit",
			"rules"		=> "max_length[2]|is_numeric"
		),
		array(
			"field"		=> "packages_info_limit",
			"label"		=> "lang:label_info_limit",
			"rules"		=> "max_length[2]|is_numeric"
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= FALSE;


	/**
	 * MEMBER AREA
	 * Get package information for member add business
	 * @param number $listing_id
	 */
	public function get_package_info($listing_id) {
		$this->db->select('packages.*');
		$this->db->join('listings L','packages.id = L.package_id', 'inner');
		return $this->packages_model->find_by(array('L.id' => $listing_id));
	}
}
