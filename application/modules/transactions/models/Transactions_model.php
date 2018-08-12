<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
 
 
 
 
 
 
 
 
 
 

class Transactions_model extends BF_Model {

	protected $table_name	= "transactions";
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
			"field"		=> "transactions_invoice",
			"label"		=> "Invoice No.",
			"rules"		=> "required|unique[transactions.invoice,transactions.id]|max_length[11]"
		),
		array(
			"field"		=> "transactions_user_id",
			"label"		=> "User",
			"rules"		=> "required"
		),
		array(
			"field"		=> "transactions_package_id",
			"label"		=> "Package",
			"rules"		=> "required"
		),
		array(
			"field"		=> "transactions_amount",
			"label"		=> "Amount",
			"rules"		=> "max_length[11]"
		)
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= FALSE;

	//--------------------------------------------------------------------
	
	/**
	 * Get all transactions for index page
	 * @return object
	 */
	public function find_transactions() {
		$this->db->select('transactions.id, transactions.invoice, transactions.amount, transactions.received_on, transactions.status, packages.title, users.display_name, listings.title as listing');
		$this->db->join('packages','packages.id = transactions.package_id', 'left');
		$this->db->join('users','users.id = transactions.user_id', 'left');
		$this->db->join('listings','listings.id = transactions.listing_id', 'left');
		$this->db->order_by('id', 'desc');
		return $this->transactions_model->find_all();
	}
	
	/**
	 * Get particular transaction detail for edit page
	 * @param int $id
	 */
	public function get_transaction($id = NULL) {
		$this->db->select('transactions.id, transactions.invoice, transactions.comments, transactions.amount, transactions.received_on, transactions.ip_address, transactions.status, P.id as package_id, P.title as package_title, U.id as user_id, U.display_name, L.id as listing_id, L.title as listing_title');
		$this->db->join('packages P','P.id = transactions.package_id', 'inner');
		$this->db->join('users U','U.id = transactions.user_id', 'inner');
		$this->db->join('listings L','L.id = transactions.listing_id', 'inner');
		return $this->transactions_model->find($id);
	}
	
	/**
	 * Get all packages from packages table
	 * @param string $id
	 */
	public function get_packages($id = NULL) {
		$this->table_name = 'packages';
		return $this->transactions_model->select('id, title')->find_all();
	}
	
	/**
	 * Get users information from users table
	 * @return object
	 */
	public function get_users() {
		$this->table_name = 'users';
		return $this->transactions_model->select('id, display_name')->find_all();
	}
	
	/**
	 * Get listings information from listing table
	 * @param string $id
	 */
	public function get_listings($id = NULL) {
		$this->table_name = 'listings';
		return $this->transactions_model->select('id, title')->find_all();
	}
	
	//--------------------------------------------------------------------
	// Member Page
	//--------------------------------------------------------------------
	/**
	 * GET TRANSACTION FOR MEMBER INVOICE PAGE
	 * @param int $user_id
	 */
	public function get_member_transactions($user_id) {
		$this->db->select('transactions.id, transactions.invoice, transactions.comments, transactions.amount, transactions.received_on, transactions.ip_address, transactions.status, P.title as package_title, U.display_name, L.title as listing_title');
		$this->db->join('packages P','P.id = transactions.package_id', 'inner');
		$this->db->join('users U','U.id = transactions.user_id', 'inner');
		$this->db->join('listings L','L.id = transactions.listing_id', 'inner');
		return $this->transactions_model->find_all_by(array('transactions.user_id' => $user_id));
	}
	
	/**
	 * Allow member to view or download invoice
	 * @param string $id
	 * @param unknown $user_id
	 */
	public function invoice($id = NULL, $user_id) {
		$this->db->select('transactions.id, transactions.invoice, transactions.comments, transactions.payment_method, transactions.currency, transactions.amount, transactions.received_on, transactions.ip_address, transactions.status, P.id as package_id, P.title as package_title, U.id as user_id, U.display_name, L.id as listing_id, L.title as listing_title, L.email');
		$this->db->join('packages P','P.id = transactions.package_id', 'inner');
		$this->db->join('users U','U.id = transactions.user_id', 'inner');
		$this->db->join('listings L','L.id = transactions.listing_id', 'inner');
		return $this->transactions_model->find_by(array('transactions.id' => $id, 'transactions.user_id' => $user_id));
	}

}
