<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
 
 
 
 
 
 
 
 
 
 

class Comments_model extends BF_Model {

	protected $table_name	= "comments";
	protected $key			= "id";
	protected $soft_deletes	= true;
	protected $date_format	= "datetime";

	protected $log_user 	= FALSE;

	protected $set_created	= true;
	protected $set_modified = false;
	protected $created_field = "created_on";

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
			"field"		=> "comments_comment",
			"label"		=> "lang:label_comment",
			"rules"		=> "required|max_length[2000]|sanitize"
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= TRUE;

	/**
	 * Display comments on index page
	 * @param int $id
	 */
	public function get_comments($id = NULL) {
		$this->db->select('comments.id, comments.username, comments.title as comment_title, comments.comment, comments.status, comments.created_on, listings.title');
		$this->db->join('listings','listings.id = comments.listing_id', 'left');
		return $this->comments_model->order_by('comments.id', 'DESC')->find_all();
	}
	
	/** Get comments for view page 
	 * @param int $id
	 */
	public function get_comment($id = NULL) {
		$this->db->select('comments.id, comments.username, comments.title, comments.comment, comments.ip, comments.status, comments.created_on, L.title');
		$this->db->join('listings L','L.id = comments.listing_id', 'left');
		return $this->comments_model->find($id);
	}
	
	/**
	 * Update comment information
	 * @param unknown $comment_id
	 * @param unknown $data
	 */
	public function update_comment($comment_id, $data) {
		//SINGLE QUERY FOR MULTIPLE ITEMS
		$where = "id IN (" . implode(",", $comment_id) . ")";
		$this->db->where($where);
		return $this->db->update('comments', $data);
	}
	
	/**
	 * Performs a standard delete, but also allows for purging of a record.
	 *
	 * @access public
	 *
	 * @param int  $id    An INT with the record ID to delete.
	 * @param bool $purge If FALSE, will perform a soft-delete. If TRUE, will permanently delete the record.
	 *
	 * @return bool TRUE/FALSE
	 */
	public function delete_comment($comment_id=0, $purge=FALSE)
	{
		if ($purge === TRUE)
		{
			// temporarily set the soft_deletes to TRUE.
			$this->soft_deletes = FALSE;
		}
		
		//SINGLE QUERY FOR MULTIPLE ITEMS
		$where = "id IN (" . implode(",", $comment_id) . ")";
		return $this->comments_model->delete_where($where);
	}//end delete()
	
	/*----------------------------------------------------*/
	/*	Member Area
	/*----------------------------------------------------*/
	/**
	 * Get all comment for member view comments section
	 * @param number $user_id
	 */
	public function get_listing_comments($user_id) {
		$this->db->select('comments.*, L.title as listing_title');
		$this->db->join('listings L','L.id = comments.listing_id AND L.deleted = 0', 'INNER');
		return $this->comments_model->find_all_by(array('comments.deleted' => 0, 'L.user_id'=> $user_id));
	}
	
	/**
	 * Count all comments related to a particular member
	 * @param number $user_id
	 */
	public function count_listing_comments($user_id) {
		$this->db->select('comments.*, L.title as listing_title');
		$this->db->join('listings L','L.id = comments.listing_id AND L.deleted = 0', 'INNER');
		return $this->comments_model->count_by(array('comments.deleted' => 0, 'L.user_id'=> $user_id));
	}
}
