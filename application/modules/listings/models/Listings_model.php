<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
 
 
 
 
 
 
 
 
 
 

class Listings_model extends BF_Model {
	
	protected $table_name	= "listings";
	protected $key			= "id";
	protected $soft_deletes	= true;
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
			"field"		=> "listings_title",
			"label"		=> "lang:label_business_title",
			"rules"		=> "trim|required|max_length[100]|alpha_extra|sanitize"
		),
		array(
			"field"		=> "listings_slug",
			"label"		=> "lang:label_slug",
			"rules"		=> "trim|max_length[100]"
		),
		array(
			"field"		=> "listings_category_id",
			"label"		=> "lang:label_select_category",
			"rules"		=> "trim|required|is_numeric"
		),
		array(
			"field"		=> "listings_subcategory_id",
			"label"		=> "lang:label_select_subcategory",
			"rules"		=> "trim|is_numeric"
		),
		array(
			"field"		=> "listings_country_id",
			"label"		=> "lang:label_select_country",
			"rules"		=> "trim|alpha_extra"
		),
		array(
			"field"		=> "listings_state_id",
			"label"		=> "lang:label_select_state",
			"rules"		=> "trim|required|is_numeric"
		),
		array(
			"field"		=> "listings_city_id",
			"label"		=> "lang:label_select_city",
			"rules"		=> "trim|required|is_numeric"
		),
		array(
			"field"		=> "listings_locality_id",
			"label"		=> "lang:label_select_locality",
			"rules"		=> "trim"
		),
		array(
			"field"		=> "listings_pincode",
			"label"		=> "lang:label_pincode",
			"rules"		=> "trim|required|is_numeric|sanitize"
		),
		array(
			"field"		=> "listings_address",
			"label"		=> "lang:label_address",
			"rules"		=> "trim|required|max_length[250]|sanitize"
		),
		array(
			"field"		=> "listings_latitude",
			"label"		=> "lang:label_latitude",
			"rules"		=> "trim|is_decimal"
		),
		array(
			"field"		=> "listings_longitude",
			"label"		=> "lang:label_longitude",
			"rules"		=> "trim|is_decimal"
		),
		array(
			"field"		=> "listings_contact_person",
			"label"		=> "lang:label_contact_person",
			"rules"		=> "trim|alpha_extra|max_length[50]|sanitize"
		),
		array(
			"field"		=> "listings_phone_number",
			"label"		=> "lang:label_phone_number",
			"rules"		=> "trim|us_phone_check|max_length[20]|sanitize"
		),
		array(
			"field"		=> "listings_mobile_number",
			"label"		=> "lang:label_mobile_number",
			"rules"		=> "required|trim|is_numeric|min_length[10]|max_length[10]|sanitize"
		),
		array(
			"field"		=> "listings_tollfree",
			"label"		=> "lang:label_tollfree",
			"rules"		=> "trim|alpha_extra|max_length[30]|sanitize"
		),
		array(
			"field"		=> "listings_fax",
			"label"		=> "lang:label_fax",
			"rules"		=> "trim|is_numeric|max_length[30]|sanitize"
		),
		array(
			"field"		=> "listings_email",
			"label"		=> "lang:label_email",
			"rules"		=> "trim|required|valid_email|max_length[100]|sanitize"
		),
		array(
			"field"		=> "listings_website",
			"label"		=> "lang:label_website",
			"rules"		=> "trim|valid_url"
		),
		array(
			"field"		=> "listings_featured",
			"label"		=> "lang:label_featured",
			"rules"		=> "trim"
		),
		array(
			"field"		=> "listings_active",
			"label"		=> "lang:label_active",
			"rules"		=> "trim"
		)
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= FALSE;

	//--------------------------------------------------------------------
	// !ACTIVATION
	//--------------------------------------------------------------------
	
	/**
	 * Count Inactive listings.
	 *
	 * @access public
	 *
	 * @return int Inactive listing count.
	 */
	public function count_inactive_listings()
	{
		$this->db->where('active',-1);
		return $this->count_all(FALSE);
	
	}//end count_inactive_listings()
	
	
	/**
	 * Activate Business Listing
	 * @access public
	 *
	 * @param int    $listing_id        The listing
	 * 
	 * @return int Listing Id on success, FALSE on error
	 */
	public function activate($listing_id)
	{
		$this->db->update($this->table_name, array('active'=>1), array('id' => $listing_id));
	
		if ($this->db->affected_rows() != 1)
		{
			return FALSE;
		}
	
		return TRUE;
		
	}//end activate()
	
	
	/**
	 * This function is triggered during listing set up to assure listing is not active.
	 * This function can be used to deactivate listings based on public view events.
	 *
	 * @param int    $listing_id    The listing or email to match to deactivate
	 *
	 * @return mixed $activate_hash on success, FALSE on error
	 */
	public function deactivate($listing_id)
	{
		$this->db->update($this->table_name, array('active'=>0), array('id' => $listing_id));
	
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
	 * @param int $listing_id The listing ID to activate
	 *
	 * @return bool TRUE on success, FALSE on error
	 */
	public function listing_activation($listing_id = FALSE)
	{
		if ($listing_id === FALSE)
		{
			$this->error = lang('ls_err_no_id');
			return FALSE;
		}
	
		if ($this->activate($listing_id, 'id', FALSE))
		{
			return $listing_id;
		}
		else
		{
			$this->error = lang('ls_err_listing_is_active');
			return FALSE;
		}
	
	}//end listing_activation()
	
	
	/**
	 * Admin only deactivation function.
	 *
	 * @access public
	 *
	 * @param int $listing_id The listing ID to deactivate
	 *
	 * @return bool TRUE on success, FALSE on error
	 */
	public function listing_deactivation($listing_id = FALSE)
	{
		if ($listing_id === FALSE)
		{
			$this->error = lang('ls_err_no_id');
			return FALSE;
		}
	
		if ($this->deactivate($listing_id, 'id', FALSE))
		{
			return $listing_id;
		}
		else
		{
			$this->error = lang('ls_err_listing_is_inactive');
			return FALSE;
		}
	
	}//end admin_deactivation()
	
	/**
	 * To update listing information
	 * @param int $id
	 * @param array $data
	 */
	public function update_listing($id=NULL, $data=array())
	{
		return $this->db->update($this->table_name, $data, array('id' => $id));
	}
	
	/**
	 * Delete all listing record permanently
	 * @param int $id
	 * @param boolean $purge
	 */
	public function delete($id=0, $purge=FALSE)
	{
		if ($purge === TRUE)
		{
			// temporarily set the soft_deletes to TRUE.
			$this->soft_deletes = FALSE;
		}
	
		return parent::delete($id);
	
	}//end delete()
	
	/**
	 * To update number of hits on a particular listing
	 * @param int $id
	 */
	public function updateHits($id) {
		$this->db->where('id', $id);
		$this->db->set('hits', 'hits + 1', FALSE);
		$this->db->update('listings');
	}
	
	
	//PHOTOS FILTER
	public function photos_filter() {
		$this->db->select('distinct(listing_id)');		
		return $this->db->get('images')->result();
	}
	
	/**
	 * Get parent categories using AJAX
	 * @return multitype:string NULL
	 */
	public function get_parent_categories(){
		$this->table_name = 'categories';
		$result = $this->listings_model->select('id, name')->where('parent_id', 0)->find_all();
	
		$options = array(); //FILL OPTION ARRAY
	
		$options[''] = '-- Select Parent Category --';
		// Format for passing into form_dropdown function
		foreach ($result as $option) {
			$options[$option->id] = $option->name;
		}	
		return $options;
	}
	
	/**
	 * Get sub categories using AJAX based on parent_id
	 * @param string $parent_id
	 * @return void|multitype:NULL
	 */
	public function get_sub_categories($parent_id = NULL){
		if(!is_null($parent_id)){			
			$this->table_name = 'categories';
			$results = $this->listings_model->select('id, name')->where('parent_id', $parent_id)->find_all();			
			$sub_categories = array();
			// if there are sub categories
			if($results){
				// Format for passing into jQuery loop	
				foreach ($results as $result) {
					$sub_categories[$result->id] = $result->name;
				}				
				return $sub_categories;
			}
		}	
		return;
	}
	
	/**
	 * Display countries to the user
	 * @return all countries iso and name
	 */
	public function get_countries() {
		$this->table_name = 'countries';
		return $this->listings_model->select('iso, name')->order_by('name', 'asc')->find_all_by('active', 1);
	}
	
	/**
	 * Display states information to the user based on country_iso 
	 * @param string $country_iso
	 */
	public function get_states($country_iso = NULL) {
		$this->table_name = 'states';
		if($country_iso != NULL) {
			return $this->listings_model->select('id, name')->where('country_iso', $country_iso)->order_by('name', 'asc')->find_all();
		}
		else {
			return;
		}
	}
	
	/**
	 * Display cities to the user based on State ID 
	 * @param int $state_id
	 */
	public function get_cities($state_id = NULL) {
		$this->table_name = 'cities';
		if($state_id != NULL)
		{
			return $this->listings_model->select('id, name')->where('state_id', $state_id)->order_by('name', 'asc')->find_all();
		}
		else {
			return;
		}
	}
	
	/**
	 * Get localities information based on City ID 
	 * @param int $city_id
	 */
	public function get_localities($city_id = NULL) {
		$this->table_name = 'localities';
		if($city_id != NULL)
		{
			return $this->listings_model->select('id, name')->where('city_id', $city_id)->order_by('name', 'asc')->find_all();
		}
		else {
			return;
		}
	}
	
	/**
	 * Populate location information using AJAX
	 * @param string $loadType for state or city 
	 * @param string/int $loadId
	 */
	public function getData($loadType,$loadId)
	{
		if($loadType=="state"){
			$this->table_name = 'states';
			return $this->listings_model->select('id, name')->where('country_iso', $loadId)->order_by('name', 'asc')->find_all();
			
		} elseif(($loadType=="city")) {
			$this->table_name = 'cities';
			$result = $this->listings_model->select('id, name')->where('state_id', $loadId)->order_by('name', 'asc')->find_all();
			return $result;
		} else {
			$this->table_name = 'localities';
			return $this->listings_model->select('id, name')->where('city_id', $loadId)->order_by('name', 'asc')->find_all();			
		}
	}
	

	/*----------------------------------------------------*/
	/*	Frontend Functions
	/*----------------------------------------------------*/
	
	/**
	 * Get listing information for detail page
	 * @param int $id
	 * @return listing information
	 */
	public function get_listing($id) {
		$sql = "SELECT L.id, L.category_id, L.user_id, L.package_id, L.title, L.logo_url, L.slug, L.address, L.city_id, L.latitude, L.longitude,";
		$sql .= " L.pincode, L.contact_person, L.phone_number, L.mobile_number, L.facebook_url, L.twitter_url, L.googleplus_url,";
		$sql .= " L.email, L.website, L.description, L.meta_title, L.meta_description, L.expires_on, L.featured, C.name as country,";
		$sql .= " S.name as state, CT.name as city,";
		$sql .= " GROUP_CONCAT(CASE WHEN TL.city_count > 0 THEN CONCAT('<a href=\"". base_url('search') ."/', (CONCAT(lower(CT.name), '/',replace( trim( lower( T.name ) ) , ' ', '-' ), '-a0t' ,T.id)), '\">', T.name, '</a>') ELSE T.name END SEPARATOR ', ') AS tags";
		$sql .= " FROM " . $this->db->dbprefix . "listings L";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "listing_tags LT ON L.id = LT.listing_id";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "tags T ON LT.tag_id = T.id AND T.active = 1";
		$sql .= " INNER JOIN " . $this->db->dbprefix . "countries C ON L.country_iso = C.iso";
		$sql .= " INNER JOIN " . $this->db->dbprefix . "states S ON L.state_id = S.id";
		$sql .= " INNER JOIN " . $this->db->dbprefix . "cities CT ON L.city_id = CT.id";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "tag_locations TL ON CT.id = TL.city_id AND T.id = TL.tag_id";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "localities LOC ON L.locality_id = LOC.id";
		$sql .= " WHERE L.id = " .$id . " AND L.deleted = 0 AND L.spammed = 0 AND L.active = 1";
		$query = $this->db->query($sql);		
		$result = $query->result();
		if($result) {
		foreach($result as $listing) {
			return $listing;
		}
		} else {
			return false;
		}
	}
	
	/**
	 * Get user information for detail page
	 * @param int $user_id
	 */
	public function get_user_info($user_id) {
		$this->table_name = "users";
		return $this->listings_model->find($user_id);
	}
	
	/**
	 * Listing information for PDF
	 * @param int $listing_id
	 */
	public function get_listing_detail($listing_id) {
		$this->db->select('*, c.name as city');
		$this->db->join('cities as c','c.id = listings.city_id', 'inner');
		return $this->listings_model->find($listing_id);
	}

	/**
	 * Get listings for category page
	 * @param number $category_id
	 * @param number $locality_id
	 * @param number $limit
	 * @param number $offset
	 * @return all listings belongs to specified category
	 */
	public function get_category_listings($category_id, $featured = 0, $locality_id = 0, $sort_by, $limit = 0, $offset = 0) {
		$site_url = base_url ( 'search/' );
		
		$offset = ! empty ( $offset ) ? $offset : 0; // set offset in case of first page as value is always 0
		$sql = "SELECT L.average_rating, L.total_users, L.id as listing_id, L.user_id, L.title, L.slug, L.logo_url, L.address, L.isAddress, L.isPhone, L.isEmail,";
		$sql .= " L.pincode, L.contact_person, L.phone_number, L.mobile_number, L.price, L.color_scheme, L.border_color,";
		$sql .= " L.email, L.website, L.description, L.priority, L.featured, L.created_on, CO.name as country,";
		$sql .= " S.name as state, CT.name as city, LOC.id as locality_id, LOC.name as locality,";
		$sql .= " GROUP_CONCAT(CASE WHEN TL.city_count > 1 THEN CONCAT('<a href=\"" . $site_url . "/', (CONCAT(replace( trim( lower( CT.name ) ) , ' ', '-' ))), '/', (CONCAT(replace( trim( lower( T.name ) ) , ' ', '-' ), '-a" . $locality_id . "t' ,T.id)), '\">', T.name, '</a>') ELSE T.name END SEPARATOR ', ') AS tags";
		
		$sql .= " FROM (SELECT LS.*, R.average_rating, R.total_users, RP.price, RP.color_scheme, RP.border_color, RP.address AS isAddress, RP.phone AS isPhone, RP.email AS isEmail FROM " . $this->db->dbprefix . "listings LS ";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "categories C ON C.id = LS.category_id";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "ratings R ON R.listing_id = LS.id";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "packages RP ON RP.id = LS.package_id";
		$sql .= " WHERE (LS.category_id = " .$category_id . " OR C.parent_id = " .$category_id . ") AND LS.deleted = 0 AND LS.spammed = 0 AND LS.active = 1";
        
        if($featured == 1) {
        	$sql .= " AND LS.featured = 1";
        } 
        // Sort by rating if user selected rating wise listings
	    if($sort_by == 'rating_highest') {
	       	$sql .= " ORDER BY R.average_rating DESC";
	    } else if ($sort_by == 'rating_lowest') {
	       	$sql .= " ORDER BY R.average_rating ASC";
	    } else {
	       	$sql .= " ORDER BY LS.created_on DESC";
	    }
        

        if ($limit != 0) {
        	$sql .= " LIMIT " . $offset . ", " . $limit;
        }
        
        $sql .= " ) L ";
        
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "listing_tags LT ON L.id = LT.listing_id";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "tags T ON LT.tag_id = T.id AND T.active = 1";
		$sql .= " INNER JOIN " . $this->db->dbprefix . "countries CO ON L.country_iso = CO.iso";
		$sql .= " INNER JOIN " . $this->db->dbprefix . "states S ON L.state_id = S.id";
		$sql .= " INNER JOIN " . $this->db->dbprefix . "cities CT ON L.city_id = CT.id";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "tag_locations TL ON CT.id = TL.city_id AND T.id = TL.tag_id";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "localities LOC ON L.locality_id = LOC.id";
		$sql .= " GROUP BY L.id";
		
		if($sort_by == 'rating_highest') {
			$sql .= " ORDER BY L.average_rating DESC";
		} else if ($sort_by == 'rating_lowest') {
			$sql .= " ORDER BY L.average_rating ASC";
		} else {
			$sql .= " ORDER BY L.created_on DESC";
		}
		
		$query = $this->db->query ( $sql );
		$result = $query->result_array ();
		return $result;
	}
	
	/**
	 * Count Total Listings in a particular category for pagination
	 * @param unknown $category_id
	 * @return number
	 */
	public function count_total_category_listings($category_id) {
		$sql = "SELECT COUNT(*) as count FROM " . $this->db->dbprefix . "categories C";
		$sql .= " JOIN " . $this->db->dbprefix . "listings L ON C.id = L.category_id";
		$sql .= " WHERE C.id = ". $category_id ." OR C.parent_id = " .$category_id;
		$query = $this->db->query ( $sql );
		foreach($query->result() as $result) {
			return (int)$result->count;
		}
	}
	
	/**
	 * Get listings for location page
	 * @param number $city_id
	 * @param number $locality_id
	 * @param number $limit
	 * @param number $offset
	 * @return all listings belongs to specified category
	 */
	public function get_location_listings($city_id, $featured = 0, $locality_id = 0, $sort_by, $limit = 0, $offset = 0) {
		$site_url = base_url ( 'search/' );
	
		$offset = ! empty ( $offset ) ? $offset : 0; // set offset in case of first page as value is always 0
		$sql = "SELECT L.id as listing_id, L.user_id, L.title, L.slug, L.average_rating, L.total_users, L.logo_url, L.address, L.isAddress, L.isPhone, L.isEmail,";
		$sql .= " L.pincode, L.contact_person, L.phone_number, L.mobile_number, L.price, L.color_scheme, L.border_color,";
		$sql .= " L.email, L.website, L.description, L.priority, L.featured, L.created_on, CO.name as country,";
		$sql .= " S.name as state, CT.name as city, LOC.id as locality_id, LOC.name as locality,";
		$sql .= " GROUP_CONCAT(CASE WHEN TL.city_count > 1 THEN CONCAT('<a href=\"" . $site_url . "/', (CONCAT(replace( trim( lower( CT.name ) ) , ' ', '-' ))), '/', (CONCAT(replace( trim( lower( T.name ) ) , ' ', '-' ), '-a" . $locality_id . "t' ,T.id)), '\">', T.name, '</a>') ELSE T.name END SEPARATOR ', ') AS tags";
	
		$sql .= " FROM (SELECT LS.*, R.average_rating, R.total_users, RP.price, RP.color_scheme, RP.border_color, RP.address AS isAddress, RP.phone AS isPhone, RP.email AS isEmail FROM " . $this->db->dbprefix . "listings LS ";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "ratings R ON R.listing_id = LS.id";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "packages RP ON RP.id = LS.package_id";
		$sql .= " WHERE LS.city_id = " .$city_id." AND LS.deleted = 0 AND LS.spammed = 0 AND LS.active = 1";
	
		if($featured == 1) {
			$sql .= " AND LS.featured = 1";
		}
	
		// Sort by rating if user selected rating wise listings
		if($sort_by == 'rating_highest') {
			$sql .= " ORDER BY R.average_rating DESC";
		} else if ($sort_by == 'rating_lowest') {
			$sql .= " ORDER BY R.average_rating ASC";
		} else {
			$sql .= " ORDER BY LS.created_on DESC";
		}
	
		if ($limit != 0) {
			$sql .= " LIMIT " . $offset . ", " . $limit;
		}
	
		$sql .= " ) L ";
	
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "listing_tags LT ON L.id = LT.listing_id";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "tags T ON LT.tag_id = T.id AND T.active = 1";
		$sql .= " INNER JOIN " . $this->db->dbprefix . "countries CO ON L.country_iso = CO.iso";
		$sql .= " INNER JOIN " . $this->db->dbprefix . "states S ON L.state_id = S.id";
		$sql .= " INNER JOIN " . $this->db->dbprefix . "cities CT ON L.city_id = CT.id";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "tag_locations TL ON CT.id = TL.city_id AND T.id = TL.tag_id";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "localities LOC ON L.locality_id = LOC.id";
		$sql .= " GROUP BY L.id";
		// Sort by rating if user selected rating wise listings
		if($sort_by == 'rating_highest') {
			$sql .= " ORDER BY L.average_rating DESC";
		} else if ($sort_by == 'rating_lowest') {
			$sql .= " ORDER BY L.average_rating ASC";
		} else {
			$sql .= " ORDER BY L.created_on DESC";
		}
	
		$query = $this->db->query ( $sql );
		$result = $query->result_array ();
		return $result;
	}
	
	/**
	 * Count Total Listings in a particular city for pagination
	 * @param number $city_id
	 * @return number
	 */
	public function count_total_location_listings($city_id) {
		$sql = "SELECT COUNT(C.*) as count FROM " . $this->db->dbprefix . "cities C";
		$sql .= " JOIN " . $this->db->dbprefix . "listings L ON C.id = L.city_id";
		$sql .= " WHERE C.id = " .$city_id;
		$query = $this->db->query ( $sql );
		foreach($query->result() as $result) {
			return (int)$result->count;
		}
	}
	
	/**
	 * State, City and Zip Search
	 * @param string $keyword
	 * @return object
	 */
	public function ajax_search_location($keyword) {
		$limit = 10;
		$sql = "SELECT * FROM (SELECT S.name FROM " . $this->db->dbprefix . "states S WHERE S.country_iso = '".$this->session->userdata('search_country')."' AND S.name LIKE '%". $keyword. "%' LIMIT " .$limit;
		$sql .= " UNION SELECT C.name FROM " . $this->db->dbprefix . "cities C INNER JOIN " . $this->db->dbprefix . "states ON " . $this->db->dbprefix . "states.id = C.state_id";
		$sql .= " WHERE " . $this->db->dbprefix . "states.country_iso = '".$this->session->userdata('search_country')."' AND C.name LIKE '%". $keyword. "%' LIMIT " .$limit ." UNION";
		$sql .= " SELECT DISTINCT(pincode) FROM " . $this->db->dbprefix . "listings L WHERE L.pincode LIKE '%". $keyword. "%' LIMIT " .$limit .") SR LIMIT 10";
		$query = $this->db->query ( $sql );
		$result = $query->result_array ();
		return $result;	
	}
	
	/**
	 * Get listinsg based on user entered keywords
	 * @param string $keyword
	 * @param string $search_city
	 * @param string $locality_id for tag URL
	 * @param int $tag_id for tag browsing
	 * @param number $limit for pagination
	 * @param number $offset for pagination
	 * @return listings
	 */
	public function search_listings($keyword, $search_city, $locality_id = 0, $category_id = 0, $tag_id = 0, $featured = 0, $sort_by, $limit = 0, $offset = 0) {
		$site_url = site_url ( 'search/' ); 
		if($locality_id = -1){
			$locality_id = 0;
		}
		$search_city = str_replace("_"," ", $search_city);
		$offset = ! empty ( $offset ) ? $offset : 0; // set offset in case of first page as value is always 0
		$this->load->model ( 'tags/tags_model' );
		// when user search for a particular tag
		if ($tag_id == 0) {
			$get_tag_id = $this->tags_model->select ( 'id, name' )->find_by ( 'name', $keyword );
			if ($get_tag_id) {
				$tag_id = ( int ) $get_tag_id->id;
				$tag_name = $get_tag_id->name;
			}
		} else if ($tag_id != 0) { // user clicked on tag id
			$tag_name = $keyword;
		}
		
		$sql = "SELECT L.id as listing_id, L.user_id, L.title, L.slug, L.average_rating, L.total_users, L.logo_url, L.address, L.isAddress, L.isPhone, L.isEmail,";
		$sql .= " L.pincode, L.contact_person, L.phone_number, L.mobile_number, L.price, L.color_scheme, L.border_color,";
		$sql .= " L.email, L.website, L.description, L.priority, L.featured, L.created_on, CO.name as country,";
		$sql .= " S.name as state, CT.name as city, LOC.id as locality_id, LOC.name as locality,";
		
		if ($tag_id != 0) {
			$sql .= " CONCAT(max(CASE WHEN T.id = " . $tag_id . " THEN CONCAT('<strong>', T.name, '</strong>') END),";
			$sql .= " (CASE WHEN  COUNT(T.id) > 1 THEN ',' ELSE '' END),";
			$sql .= " IFNULL(GROUP_CONCAT(CASE WHEN TL.city_count > 1 AND T.id <> " . $tag_id . " THEN CONCAT('<a href=\"" . $site_url . "/', (CONCAT(replace( trim( lower( CT.name ) ) , ' ', '-' ))), '/', (CONCAT(replace( trim( lower( T.name ) ) , ' ', '-' ), '-a" . $locality_id . "t' ,T.id)), '\">', T.name, '</a>')";
			$sql .= " WHEN T.id <> " . $tag_id . " THEN T.name END SEPARATOR ', '),'')) AS tags";
		} else {
			$sql .= " GROUP_CONCAT(CASE WHEN TL.city_count > 1 THEN CONCAT('<a href=\"" . $site_url . "/', (CONCAT(replace( trim( lower( CT.name ) ) , ' ', '-' ))), '/', (CONCAT(replace( trim( lower( T.name ) ) , ' ', '-' ), '-a" . $locality_id . "t' ,T.id)), '\">', T.name, '</a>') ELSE T.name END SEPARATOR ', ') AS tags";
		}
		
		$sql .= " FROM (SELECT LS.*, R.average_rating, R.total_users, RP.price, RP.color_scheme, RP.border_color, RP.address AS isAddress, RP.phone AS isPhone, RP.email AS isEmail FROM " . $this->db->dbprefix . "listings LS";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "ratings R ON R.listing_id = LS.id";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "packages RP ON RP.id = LS.package_id";
		if($category_id != 0) {
			$sql .= " LEFT JOIN " . $this->db->dbprefix . "categories ON " . $this->db->dbprefix . "categories.id = LS.category_id";
		}
		
		if(settings_item('adv.search_blocks') != 1) {
			$sql .= " LEFT JOIN " . $this->db->dbprefix . "states ON " . $this->db->dbprefix . "states.id = LS.state_id";
			$sql .= " LEFT JOIN " . $this->db->dbprefix . "cities ON " . $this->db->dbprefix . "cities.id = LS.city_id";
		}
		
		$sql .= " WHERE LS.deleted = 0 AND LS.spammed = 0 AND LS.active = 1 AND LS.country_iso = '" .$this->session->userdata('search_country') . "'";
		
		if(settings_item('adv.search_blocks') == 1) {
			$sql .= " AND LS.city_id = " . $search_city;
		} else {
			$sql .= " AND (" . $this->db->dbprefix . "states.name LIKE '%" .$search_city ."%' OR " . $this->db->dbprefix . "cities.name LIKE '%" . $search_city . "%' OR LS.pincode LIKE '%" . $search_city ."%')";
		}
		
		if($category_id != 0) {
			$sql .= " AND (LS.category_id = " . $category_id ." OR " . $this->db->dbprefix . "categories.parent_id = " . $category_id .")";
		}
		
		/**
		 * Get all featured item, merge them with other results and show them on the top
		 */
		if($featured == 1) {
			$sql .= " AND LS.featured = 1";
		}
		
		if ($locality_id != 0) {
			$sql .= " AND LS.locality_id = " . $locality_id;
		}
		$sql .= " AND (LS.title LIKE '%" . $keyword . "%' OR LS.description LIKE '%" . $keyword . "%'";
		if ($tag_id != 0) {
			$sql .= " OR EXISTS (SELECT 1 FROM " . $this->db->dbprefix . "listing_tags LT WHERE LT.tag_id = " . $tag_id . " AND LS.id = LT.listing_id)";
		} else {
			$sql .= " OR EXISTS (SELECT 1 FROM " . $this->db->dbprefix . "tags INNER JOIN " . $this->db->dbprefix . "listing_tags ON " . $this->db->dbprefix . "listing_tags.tag_id = " . $this->db->dbprefix . "tags.id WHERE " . $this->db->dbprefix . "tags.name LIKE '%" . $keyword . "%' AND " . $this->db->dbprefix . "tags.active = 1 AND " . $this->db->dbprefix . "listing_tags.listing_id = LS.id)";
		}
		$sql .= " OR EXISTS (SELECT 1 FROM " . $this->db->dbprefix . "categories WHERE (" . $this->db->dbprefix . "categories.name LIKE '%" . $keyword . "%' OR " . $this->db->dbprefix . "categories.description) LIKE '%" . $keyword . "%' AND " . $this->db->dbprefix . "categories.id = LS.category_id)";
		$sql .= " OR EXISTS (SELECT 1 FROM " . $this->db->dbprefix . "products WHERE (" . $this->db->dbprefix . "products.title LIKE '%" . $keyword . "%' OR " . $this->db->dbprefix . "products.description LIKE '%" . $keyword . "%') AND " . $this->db->dbprefix . "products.listing_id = LS.id)";
		$sql .= " OR EXISTS (SELECT 1 FROM " . $this->db->dbprefix . "classifieds WHERE (" . $this->db->dbprefix . "classifieds.title LIKE '%" . $keyword . "%' OR " . $this->db->dbprefix . "classifieds.description LIKE '%" . $keyword . "%') AND " . $this->db->dbprefix . "classifieds.listing_id = LS.id)";		
		$sql .= " )";
		// Sort by rating if user selected rating wise listings
		if($sort_by == 'rating_highest') {
			$sql .= " ORDER BY R.average_rating DESC";
		} else if ($sort_by == 'rating_lowest') {
			$sql .= " ORDER BY R.average_rating ASC";
		} else {
			$sql .= " ORDER BY LS.created_on DESC";
		}
		
		/**
		 * For featured, there should be no limit as we have to select random values from the final result
		 */
		if($featured == 0) {
			if ($limit != 0) {
				$sql .= " LIMIT " . $offset . ", " . $limit;
			} else {
				$sql .= " LIMIT $limit";
			}
		}
		
		$sql .= " ) L";
		
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "listing_tags LT ON L.id = LT.listing_id";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "tags T ON LT.tag_id = T.id AND T.active = 1";
		$sql .= " INNER JOIN " . $this->db->dbprefix . "categories C ON C.id = L.category_id";
		$sql .= " INNER JOIN " . $this->db->dbprefix . "countries CO ON L.country_iso = CO.iso";
		$sql .= " INNER JOIN " . $this->db->dbprefix . "states S ON L.state_id = S.id";
		$sql .= " INNER JOIN " . $this->db->dbprefix . "cities CT ON L.city_id = CT.id";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "tag_locations TL ON CT.id = TL.city_id AND T.id = TL.tag_id";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "localities LOC ON L.locality_id = LOC.id";
		$sql .= " GROUP BY L.id";
		// Sort by rating if user selected rating wise listings
		if($sort_by == 'rating_highest') {
			$sql .= " ORDER BY L.average_rating DESC";
		} else if ($sort_by == 'rating_lowest') {
			$sql .= " ORDER BY L.average_rating ASC";
		} else {
			$sql .= " ORDER BY L.created_on DESC";
		}
		$query = $this->db->query ( $sql );
		$result = $query->result_array ();
		return $result;
	}
	
	/**
	 * Count total results for pagination
	 * @param string $keyword
	 * @param string $search_city
	 * @param number $category_id
	 * @return number
	 */
	public function search_results_count($keyword, $search_city, $locality_id = 0, $category_id = 0, $tag_id = 0) {
		$search_city = str_replace("_"," ", $search_city);
		if($category_id = -1){
			$category_id = 0;
		}
		if($locality_id = -1){
			$locality_id = 0;
		}
		$sql = "SELECT COUNT(LS.id) as total_count FROM " . $this->db->dbprefix . "listings LS";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "ratings R ON R.listing_id = LS.id";
		
		if($category_id != 0) {
			$sql .= " LEFT JOIN " . $this->db->dbprefix . "categories ON " . $this->db->dbprefix . "categories.id = LS.category_id";
		}
		
		if(settings_item('adv.search_blocks') != 1) {
			$sql .= " LEFT JOIN " . $this->db->dbprefix . "states ON " . $this->db->dbprefix . "states.id = LS.state_id";
			$sql .= " LEFT JOIN " . $this->db->dbprefix . "cities ON " . $this->db->dbprefix . "cities.id = LS.city_id";
		}
		
		$sql .= " WHERE LS.deleted = 0 AND LS.spammed = 0 AND LS.active = 1 AND LS.country_iso = '" .$this->session->userdata('search_country') . "'";
		
		if(settings_item('adv.search_blocks') == 1) {
			$sql .= " AND LS.city_id = " . $search_city;
		} else {
			$sql .= " AND (" . $this->db->dbprefix . "states.name LIKE '%" .$search_city ."%' OR " . $this->db->dbprefix . "cities.name LIKE '%" . $search_city . "%' OR LS.pincode LIKE '%" . $search_city ."%')";
		}
		
		if($category_id != 0) {
			$sql .= " AND (LS.category_id = " . $category_id ." OR " . $this->db->dbprefix . "categories.parent_id = " . $category_id .")";
		}
		
		if ($locality_id != 0) {
			$sql .= " AND LS.locality_id = " . $locality_id;
		}
		$sql .= " AND (LS.title LIKE '%" . $keyword . "%' OR LS.description LIKE '%" . $keyword . "%'";
		if ($tag_id != 0) {
			$sql .= " OR EXISTS (SELECT 1 FROM " . $this->db->dbprefix . "listing_tags LT WHERE LT.tag_id = " . $tag_id . " AND LS.id = LT.listing_id)";
		} else {
			$sql .= " OR EXISTS (SELECT 1 FROM " . $this->db->dbprefix . "tags INNER JOIN " . $this->db->dbprefix . "listing_tags ON " . $this->db->dbprefix . "listing_tags.tag_id = " . $this->db->dbprefix . "tags.id WHERE " . $this->db->dbprefix . "tags.name LIKE '%" . $keyword . "%' AND " . $this->db->dbprefix . "tags.active = 1 AND " . $this->db->dbprefix . "listing_tags.listing_id = LS.id)";
		}
		$sql .= " OR EXISTS (SELECT 1 FROM " . $this->db->dbprefix . "categories WHERE (" . $this->db->dbprefix . "categories.name LIKE '%" . $keyword . "%' OR " . $this->db->dbprefix . "categories.description) LIKE '%" . $keyword . "%' AND " . $this->db->dbprefix . "categories.id = LS.category_id)";
		$sql .= " OR EXISTS (SELECT 1 FROM " . $this->db->dbprefix . "products WHERE (" . $this->db->dbprefix . "products.title LIKE '%" . $keyword . "%' OR " . $this->db->dbprefix . "products.description LIKE '%" . $keyword . "%') AND " . $this->db->dbprefix . "products.listing_id = LS.id)";
		$sql .= " OR EXISTS (SELECT 1 FROM " . $this->db->dbprefix . "classifieds WHERE (" . $this->db->dbprefix . "classifieds.title LIKE '%" . $keyword . "%' OR " . $this->db->dbprefix . "classifieds.description LIKE '%" . $keyword . "%') AND " . $this->db->dbprefix . "classifieds.listing_id = LS.id)";		
		$sql .= " )";
		$sql .= " ORDER BY LS.created_on DESC";
		$query = $this->db->query ( $sql );
		$result = $query->result_array ();
		$total_count = "";
		if($result) {
			foreach($result as $count) {
				$total_count = $count['total_count'];
			}
		}
		return $total_count;
	}
	
	/**
	 * Get listings as user type keyword using AJAX
	 * @param string $keyword
	 * @param number $locality
	 * @return all listings
	 */
	public function ajax_search($keyword, $search_city, $locality_id = 0, $category_id = 0, $tag_id = 0) {
		if(settings_item('adv.search_blocks') == 1) {
			$search_city = $this->session->userdata('search_city');
		}
		if($category_id == -1) {
			$category_id = 0;
		}
		$sql = "SELECT LS.id, LS.title FROM " . $this->db->dbprefix . "listings LS";
		if($category_id != 0) {
			$sql .= " LEFT JOIN " . $this->db->dbprefix . "categories ON " . $this->db->dbprefix . "categories.id = LS.category_id";
		}
		
		if(settings_item('adv.search_blocks') != 1) {
			$sql .= " LEFT JOIN " . $this->db->dbprefix . "states ON " . $this->db->dbprefix . "states.id = LS.state_id";
			$sql .= " LEFT JOIN " . $this->db->dbprefix . "cities ON " . $this->db->dbprefix . "cities.id = LS.city_id";
		}
		
		$sql .= " WHERE LS.deleted = 0 AND LS.spammed = 0 AND LS.active = 1 AND LS.country_iso = '" .$this->session->userdata('search_country') . "'";
		
		if(settings_item('adv.search_blocks') == 1) {
			$sql .= " AND LS.city_id = " . $search_city;
		} else {
			$sql .= " AND (" . $this->db->dbprefix . "states.name LIKE '%" .$search_city ."%' OR " . $this->db->dbprefix . "cities.name LIKE '%" . $search_city . "%' OR LS.pincode LIKE '%" . $search_city ."%')";
		}
		
		if($category_id != 0) {
			$sql .= " AND (LS.category_id = " . $category_id ." OR " . $this->db->dbprefix . "categories.parent_id = " . $category_id .")";
		}
		
		if ($locality_id != 0) {
			$sql .= " AND LS.locality_id = " . $locality_id;
		}
		$sql .= " AND (LS.title LIKE '%" . $keyword . "%' OR LS.description LIKE '%" . $keyword . "%'";
		if ($tag_id != 0) {
			$sql .= " OR EXISTS (SELECT 1 FROM " . $this->db->dbprefix . "listing_tags LT WHERE LT.tag_id = " . $tag_id . " AND LS.id = LT.listing_id)";
		} else {
			$sql .= " OR EXISTS (SELECT 1 FROM " . $this->db->dbprefix . "tags INNER JOIN " . $this->db->dbprefix . "listing_tags ON " . $this->db->dbprefix . "listing_tags.tag_id = " . $this->db->dbprefix . "tags.id WHERE " . $this->db->dbprefix . "tags.name LIKE '%" . $keyword . "%' AND " . $this->db->dbprefix . "tags.active = 1 AND " . $this->db->dbprefix . "listing_tags.listing_id = LS.id)";
		}
		$sql .= " OR EXISTS (SELECT 1 FROM " . $this->db->dbprefix . "categories WHERE (" . $this->db->dbprefix . "categories.name LIKE '%" . $keyword . "%' OR " . $this->db->dbprefix . "categories.description) LIKE '%" . $keyword . "%' AND " . $this->db->dbprefix . "categories.id = LS.category_id)";
		$sql .= " OR EXISTS (SELECT 1 FROM " . $this->db->dbprefix . "products WHERE (" . $this->db->dbprefix . "products.title LIKE '%" . $keyword . "%' OR " . $this->db->dbprefix . "products.description LIKE '%" . $keyword . "%') AND " . $this->db->dbprefix . "products.listing_id = LS.id)";
		$sql .= " OR EXISTS (SELECT 1 FROM " . $this->db->dbprefix . "classifieds WHERE (" . $this->db->dbprefix . "classifieds.title LIKE '%" . $keyword . "%' OR " . $this->db->dbprefix . "classifieds.description LIKE '%" . $keyword . "%') AND " . $this->db->dbprefix . "classifieds.listing_id = LS.id)";		
		$sql .= " )";
		$sql .= " ORDER BY LS.created_on DESC";
		$query = $this->db->query ( $sql );
		$result = $query->result_array ();
		return $result;
	}
	
	/**
	 * Get featured listings for home page below category section
	 * @return object of featured listings
	 */
	public function frontend_featured_listings() {
		$limit = 4;
		$count_featured = $this->listings_model->count_by(array('featured' => 1));
		$sql = "SELECT L.id, L.title, L.slug, L.pincode, L.address, L.description, L.logo_url, P.address AS isAddress, P.phone As isPhone, P.email AS isEmail,";
		$sql .= " L.created_on, CO.name as country, S.name as state, CT.name as city FROM " . $this->db->dbprefix . "listings L";
		$sql .= " INNER JOIN " . $this->db->dbprefix . "countries CO ON L.country_iso = CO.iso";
		$sql .= " INNER JOIN " . $this->db->dbprefix . "states S ON L.state_id = S.id";
		$sql .= " INNER JOIN " . $this->db->dbprefix . "cities CT ON L.city_id = CT.id";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "packages P ON L.package_id = P.id";
		$sql .= " WHERE L.featured = 1 AND L.deleted = 0 AND L.spammed = 0 AND L.active = 1 LIMIT ". $limit;
		if($limit < $count_featured) {
			$rand = rand(0,$count_featured - $limit);
			$sql .= " OFFSET $rand";
		}
		$query = $this->db->query ( $sql );
		$result = $query->result_array ();
		return $result;
	}
	
	/**
	 * Get featured listings for right hand side
	 * @param int $limit
	 * @return object
	 */
	public function featured_listings($limit) {
		$count_featured = $this->listings_model->count_by(array('featured' => 1));
		$sql = "SELECT L.id, L.title, L.slug, L.pincode, L.address, L.description, L.logo_url, P.address AS isAddress, P.phone As isPhone, P.email AS isEmail,";
		$sql .= " L.created_on, CO.name as country, S.name as state, CT.name as city FROM " . $this->db->dbprefix . "listings L";
		$sql .= " INNER JOIN " . $this->db->dbprefix . "countries CO ON L.country_iso = CO.iso";
		$sql .= " INNER JOIN " . $this->db->dbprefix . "states S ON L.state_id = S.id";
		$sql .= " INNER JOIN " . $this->db->dbprefix . "cities CT ON L.city_id = CT.id";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "packages P ON L.package_id = P.id";
		$sql .= " WHERE L.deleted = 0 AND L.spammed = 0 AND L.active = 1 AND L.featured = 1 LIMIT " . $limit;
		if($limit < $count_featured) {
			$rand = rand(0,$count_featured - $limit);
			$sql .= " OFFSET $rand";
		}
		$query = $this->db->query ( $sql );
		$result = $query->result_array ();
		return $result;
	}
	
	/**
	 * Get popular listings information based on number of hits
	 * @param int $limit
	 * @return object
	 */
	public function popular_listings($limit) {
		$sql = "SELECT L.id, L.title, L.slug, L.address, L.pincode, L.description, L.logo_url, L.created_on, CO.name AS country, S.name AS state, CT.name AS city, P.address AS isAddress, P.phone As isPhone, P.email AS isEmail";
		$sql .= " FROM ( SELECT id, package_id, title, slug, address, pincode, description, logo_url, created_on, country_iso, state_id, city_id FROM " . $this->db->dbprefix . "listings WHERE deleted =0 AND spammed =0 AND active =1 ORDER BY hits DESC";
		$sql .= " LIMIT " . $limit . ")L";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "countries CO ON L.country_iso = CO.iso";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "states S ON L.state_id = S.id";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "cities CT ON L.city_id = CT.id";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "packages P ON L.package_id = P.id";
		$query = $this->db->query ( $sql );
		$result = $query->result_array ();
		return $result;
	}
	
	/**
	 * Get recently added listings using date in descending order
	 * @param int $limit
	 * @return object
	 */
	public function recently_added($limit) {
		$sql = "SELECT L.id, L.title, L.slug, L.address, L.pincode, L.description, L.logo_url, L.created_on, CO.name AS country, S.name AS state, CT.name AS city, P.address AS isAddress, P.phone As isPhone, P.email AS isEmail";
		$sql .= " FROM ( SELECT id, package_id, title, slug, address, pincode, description, logo_url, created_on, country_iso, state_id, city_id FROM " . $this->db->dbprefix . "listings WHERE deleted =0 AND spammed =0 AND active =1 ORDER BY id DESC";
		$sql .= " LIMIT " . $limit . ")L";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "countries CO ON L.country_iso = CO.iso";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "states S ON L.state_id = S.id";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "cities CT ON L.city_id = CT.id";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "packages P ON L.package_id = P.id";
		$query = $this->db->query ( $sql );
		$result = $query->result_array ();
		return $result;
	}
	
	/**
	 * Get related listings for detail page based on same category id
	 * @param number $listing_id
	 * @param number $category_id
	 * @param number $limit
	 * @return object
	 */
	public function related_listings($listing_id, $category_id, $limit) {
		$sql = "SELECT L.id, L.title, L.slug, L.address,";
		$sql .= " L.pincode, L.description, L.logo_url, L.created_on,";
		$sql .= " CT.name as city FROM " . $this->db->dbprefix . "listings L";
		$sql .= " INNER JOIN " . $this->db->dbprefix . "cities CT ON L.city_id = CT.id";
		$sql .= " WHERE L.id <> " . $listing_id . " AND L.category_id = " . $category_id . " AND L.deleted = 0 AND L.spammed = 0 AND L.active = 1";
		if($this->session->userdata('search_city')) {
			$sql .= " AND L.city_id = " .$this->session->userdata('search_city');
		}
		$sql .= " ORDER BY L.id DESC LIMIT " . $limit;
		$query = $this->db->query ( $sql );
		$result = $query->result_array ();
		return $result;
	}
	
	/**
	 * Admin products or services, photos, videos and classifieds counting for listing index page
	 * so that admin can come to know which of the above are not activated
	 */
	public function get_admin_listings($offset = 0, $limit = 25, $where, $order_by) {
		$sql = "SELECT L.id, L.title, L.email, L.hits, L.created_on, L.active, COUNT(DISTINCT p.id) as inactive_products,";
		$sql .= " COUNT(DISTINCT i.id) as inactive_images, COUNT(DISTINCT v.id) as inactive_videos, COUNT(DISTINCT c.id) as inactive_classifieds";
		$sql .= " FROM (SELECT LS.id, LS.title, LS.email, LS.hits, LS.created_on, LS.active FROM " . $this->db->dbprefix . "listings LS";
		if(!empty($where) && (strpos($where,'SUBSTRING') !== false)) {
			$sql .= " WHERE ".$where;
		} else if(!empty($where)) {
			$sql .= " WHERE LS.".$where;
		}
		$sql .= " ORDER BY LS.".$order_by." LIMIT " . $offset . ", " . $limit .") L";
		$sql .= " LEFT JOIN `" . $this->db->dbprefix . "products` as p ON `p`.`listing_id` = L.id AND p.active = 0";
		$sql .= " LEFT JOIN `" . $this->db->dbprefix . "images` as i ON `i`.`listing_id` = L.id AND i.active = 0"; 
		$sql .= " LEFT JOIN `" . $this->db->dbprefix . "videos` as v ON `v`.`listing_id` = L.id AND v.active = 0";
		$sql .= " LEFT JOIN `" . $this->db->dbprefix . "classifieds` as c ON `c`.`listing_id` = L.id AND c.active = 0";
		$sql .= " GROUP BY L.id ORDER BY L." .$order_by;
		$query = $this->db->query ( $sql );
		$result = $query->result_array ();
		return $result;
	}
	
	/**
	 * Common upload image function for product and classified
	 * @param string $upload_path
	 * @param string $field_name
	 * @param string $type
	 * @return multitype:NULL
	 */
	public function upload_image($upload_path, $field_name){
		$config['upload_path'] = realpath(FCPATH.'/assets/images/'. $upload_path .'/'); //Make SURE that you chmod this directory to 777!
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']= settings_item('lst.image_file_size');
		$config['max_width']=settings_item('lst.image_width');
		$config['max_height']=settings_item('lst.image_height');
		$config['remove_spaces']=TRUE; //Remove spaces from the file name
		$this->load->library('upload', $config);
	
		if (!$this->upload->do_upload($field_name)) { // Image name is necessary
			$this->session->set_flashdata('upload_image_error', $this->upload->display_errors());
			return false;
		} else {
			$data = array('upload_data' => $this->upload->data());
		}
		return $data;
	}
}
