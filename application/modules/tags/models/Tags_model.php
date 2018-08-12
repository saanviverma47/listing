<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
 
 
 
 
 
 
 
 
 
 

class Tags_model extends BF_Model {

	protected $table_name	= "tags";
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
			"field"		=> "tags_name",
			"label"		=> "name",
			"rules"		=> "required|unique[tags.name,tags.id]|trim|alpha_extra|max_length[255]"
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= FALSE;

	//--------------------------------------------------------------------
	
	/**
	 * Count Inactive tags.
	 *
	 * @access public
	 *
	 * @return int Inactive tag count.
	 */
	public function count_inactive_tags()
	{
		$this->db->where('active',-1);
		return $this->count_all(FALSE);
	
	}//end count_inactive_tags()
	
	
	/**
	 * Activate Business tag
	 * @access public
	 *
	 * @param int    $tag_id        The tag
	 *
	 * @return int tag Id on success, FALSE on error
	 */
	public function activate($tag_id)
	{
		$this->db->update($this->table_name, array('active'=>1), array('id' => $tag_id));
	
		if ($this->db->affected_rows() != 1)
		{
			return FALSE;
		}
	
		return TRUE;
	
	}//end activate()
	
	
	/**
	 * This function is triggered during tag set up to assure tag is not active.
	 * This function can be used to deactivate tags based on public view events.
	 *
	 * @param int    $tag_id    The tag or email to match to deactivate
	 *
	 * @return mixed $activate_hash on success, FALSE on error
	 */
	public function deactivate($tag_id)
	{
		$this->db->update($this->table_name, array('active'=>0), array('id' => $tag_id));
	
		if ($this->db->affected_rows() != 1)
		{
			return FALSE;
		}
	
		return TRUE;
	
	}//end deactivate()
	
	
	/**
	 * Admin specific activation function for admin approvals or re-activation.
	 *
	 * @access public
	 *
	 * @param int $tag_id The tag ID to activate
	 *
	 * @return bool TRUE on success, FALSE on error
	 */
	public function tag_activation($tag_id = FALSE)
	{
		if ($tag_id === FALSE)
		{
			$this->error = lang('ls_err_no_id');
			return FALSE;
		}
	
		if ($this->activate($tag_id, 'id', FALSE))
		{
			return $tag_id;
		}
		else
		{
			$this->error = lang('ls_err_tag_is_active');
			return FALSE;
		}
	
	}//end tag_activation()
	
	
	/**
	 * Admin only deactivation function.
	 *
	 * @access public
	 *
	 * @param int $tag_id The tag ID to deactivate
	 *
	 * @return bool TRUE on success, FALSE on error
	 */
	public function tag_deactivation($tag_id = FALSE)
	{
		if ($tag_id === FALSE)
		{
			$this->error = lang('ls_err_no_id');
			return FALSE;
		}
	
		if ($this->deactivate($tag_id, 'id', FALSE))
		{
			return $tag_id;
		}
		else
		{
			$this->error = lang('ls_err_tag_is_inactive');
			return FALSE;
		}
	
	}//end admin_deactivation()
	
	/**
	 * Get listing tags from listing_tags association table
	 * @param number $listing_id
	 */
	public function find_listing_tags($listing_id) {
		$this->table_name = 'tags';
		$this->db->select('tags.id, tags.name');
		$this->db->join('listing_tags','listing_tags.tag_id = tags.id');
		$this->db->where('listing_tags.listing_id', $listing_id);
		$this->db->order_by('id', 'asc');
		return $this->tags_model->find_all();
	}
	
	/**
	 * Get Tag information
	 * @param string $string
	 */
	public function find_tags($string) {
		$where = 'name IN (' . $string . ')';
		return $this->tags_model->select('id, name')->find_all_by($where);
	}
	
	/**
	 * To add new tag information
	 * @param unknown $listing_tags
	 */
	public function insert_tags($listing_tags) {
		$this->tags_model->insert_batch($listing_tags);;
	}
	
	/**
	 * Add association information
	 * @param unknown $listing_tags
	 */
	public function insert_listing_tags($listing_tags) {
		$this->table_name = 'listing_tags';
		$this->set_created	= false;
		$this->set_modified = false;
		$this->tags_model->insert_batch($listing_tags);
	}
	
	/**
	 * Delete association from listing_tags table on listing delete
	 * @param unknown $listing_id
	 */
	public function delete_listing_tags($listing_id) {
		$this->table_name = 'listing_tags';
		$this->soft_deletes = FALSE;
		$where['listing_id'] = $listing_id;
		return $this->tags_model->delete_where($where);
	}
	
	/**
	 * Count total number of listings on which a particular tag is used
	 * @param number $tag_id
	 * @param number $listing_id
	 */
	public function get_tag_count($tag_id, $listing_id) {
		$this->table_name = 'listing_tags';
		$where = 'tag_id = '. $tag_id .' AND NOT listing_id = ' .$listing_id;
		return $this->tags_model->count_by($where);
	}
	
	/**
	 * Get all listings based on a particular tag id
	 * @param unknown $id
	 */
	public function get_listings_id($id) {
		$this->table_name = 'listing_tags';
		return $this->tags_model->select('listing_id')->find_all_by(array('tag_id' => $id));
	}
	
	/**
	 * Function to decrement tag count from tag_locations association table on insert and update
	 * @param string $existing_tags_id_string
	 * @param number $selected_city_id
	 */
	public function decrement_tag_locations_count ($existing_tags_id_string, $selected_city_id) {
		$this->db->where('tag_id IN ('.$existing_tags_id_string.') AND city_id = ' .$selected_city_id);
		$this->db->set('city_count', 'city_count - 1', FALSE);
		$this->db->set('state_count', 'state_count - 1', FALSE);
		$this->db->set('country_count', 'country_count -1', FALSE);
		$this->db->update('tag_locations');
	}
	
	/**
	 * Add information in tag_locations association table
	 * Single function to handle insert and update on duplicate
	 * @param string $data
	 */
	public function insert_update_tag_locations ($data) {
		$sql = "INSERT INTO " . $this->db->dbprefix . "tag_locations (tag_id, city_id, city_count, state_id, state_count, country_iso, country_count)"; 
  		$sql .= " VALUES " .$data. "";
    	$sql .= " ON DUPLICATE KEY UPDATE city_count = city_count + 1, state_count = state_count + 1, country_count = country_count + 1";
		return $this->db->query($sql);		
	}	
}
