<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Banners_model extends BF_Model {

	protected $table_name	= "banners";
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
			"field"		=> "banners_type_id",
			"label"		=> "lang:label_banner_type",
			"rules"		=> "required"
		),
		array(
			"field"		=> "banners_title",
			"label"		=> "lang:label_title",
			"rules"		=> "required|trim|max_length[100]|sanitize"
		),
		array(
			"field"		=> "banners_url",
			"label"		=> "lang:label_url",
			"rules"		=> "trim|valid_url"
		),
		array(
			"field"		=> "banners_target",
			"label"		=> "lang:label_target",
			"rules"		=> "trim"
		),
		array(
			"field"		=> "banners_start_date",
			"label"		=> "lang:label_start_date",
			"rules"		=> "trim|valid_date"
		),
		array(
			"field"		=> "banners_end_date",
			"label"		=> "lang:label_end_date",
			"rules"		=> "trim|valid_date"
		),
		array(
			"field"		=> "banners_max_impressions",
			"label"		=> "lang:label_max_impressions",
			"rules"		=> "trim|is_numeric"
		),
		array(
			"field"		=> "banners_max_clicks",
			"label"		=> "lang:label_max_clicks",
			"rules"		=> "trim|is_numeric"
		),
		array(
			"field"		=> "banners_slider_heading",
			"label"		=> "lang:label_slider_heading",
			"rules"		=> "trim"
		),
		array(
			"field"		=> "banners_html_text",
			"label"		=> "lang:label_text_html",
			"rules"		=> "trim"
		),
		array(
			"field"		=> "banners_all_pages",
			"label"		=> "lang:label_all_pages",
			"rules"		=> "trim"
		),
		array(
			"field"		=> "banners_active",
			"label"		=> "lang:label_status",
			"rules"		=> "trim"
		)
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= FALSE;

	//--------------------------------------------------------------------
	
	/**
	 * GET ALL BANNERS FOR INDEX PAGE
	 */
	public function get_all() {
		$this->table_name = 'banners'; //IMPORTANT OTHERWISE QUERY WILL RUN FOR ALL TABLES
		$this->db->select('banners.*, banner_types.type, banner_types.location');
		$this->db->join('banner_types', 'banner_types.id = banners.type_id', 'inner');
		return $this->banners_model->find_all();
	}

	/**
	 * GET BANNER FOR EDIT OPERATION
	 * @param number $id for banner ID
	 */
	public function get_banner($id) {
		$this->table_name = 'banners'; //IMPORTANT OTHERWISE QUERY WILL RUN FOR ALL TABLES
		return $this->banners_model->find($id);
	}
	
	/**
	 * INSERT BANNER
	 * @param array $data
	 */
	public function insert_banner($data) {
		$this->table_name = 'banners'; //IMPORTANT OTHERWISE QUERY WILL RUN FOR ALL TABLES
		return $this->banners_model->insert($data);
	}
	
	/**
	 * UPDATE BANNER
	 * @param number $id
	 * @param array $data 
	 */
	public function update_banner($id, $data) {
		$this->table_name = 'banners'; //IMPORTANT OTHERWISE QUERY WILL RUN FOR ALL TABLES
		return $this->banners_model->update($id, $data);
	}
	
	/**
	 * DELETE BANNER
	 * @param number $id
	 */
	public function delete_banner($id) {
		$this->table_name = 'banners'; //IMPORTANT OTHERWISE QUERY WILL RUN FOR ALL TABLES
		return $this->banners_model->delete($id);
	} 
	
	/**
	 * IF BANNER TYPE IS DELETED, DELETE ALL RELATED BANNERS
	 * @param number $type_id
	 */
	public function delete_banner_types($type_id) {
		$this->table_name = 'banners'; //IMPORTANT OTHERWISE QUERY WILL RUN FOR ALL TABLES
		$where['type_id'] = $type_id;
		return $this->banners_model->delete_where($where);
	}
	
	/**
	 * GET BANNERS OF SPECIFIED TYPE ID FOR DELETION
	 * @param number $type_id
	 */
	public function get_banner_types($type_id) {
		$this->table_name = 'banners';
		$where['type_id'] = $type_id;
		return $this->banners_model->select('id')->find_all_by($where);
	}
	
	/**
	 * DELETE FROM BANNER TYPES
	 * @param array $where
	 */
	public function delete_from_banner_categories($where) {
		$this->table_name = 'banner_categories';
		$this->banners_model->delete_where($where);
	}

	/*----------------------------------------------------*/
	/*	DEAL WITH CATEGORIES
	/*----------------------------------------------------*/
	
	/**
	 * GET ALL PARENTS
	 */
	public function get_parents() {
		$this->table_name = 'categories';
		return $this->banners_model->select('id, name')->where('parent_id', 0)->find_all();
	}
	
	/**
	 * GET ALL SUBCATEGORIES
	 */
	public function get_subs() {
		$this->table_name = 'categories';
		return $this->banners_model->select('id, parent_id, name')->where('parent_id > 0')->find_all();
	}
	
	/*----------------------------------------------------*/
	/*	BANNER CATEGORIES (ASSOCIATION)
	/*----------------------------------------------------*/
	
	/**
	 * FIND BANNER CATEGORIES FROM banner_categories TABLE
	 * @param number $banner_id
	 */
	public function get_banner_categories($banner_id = NULL) {
		$this->table_name = 'banner_categories';
		return $this->banners_model->find_all_by(array('banner_id' => $banner_id));
	}
	
	/**
	 * Insert categories in banner_categories TABLE
	 * @param unknown $banner_categories
	 */
	public function insert_banner_categories($banner_categories) {
		$this->table_name = 'banner_categories';
		$this->set_created	= false;
		$this->set_modified = false;
		$this->banners_model->insert_batch($banner_categories);
	}
	
	/**
	 * DELETE TAGS FROM banner_categories TABLE
	 * @param number $banner_id
	 */
	public function delete_banner_categories($banner_id) {
		$this->table_name = 'banner_categories';
		$where['banner_id'] = $banner_id;
		return $this->banners_model->delete_where($where);
	}
	
	/*----------------------------------------------------*/
	/*	BANNER LOCATIONS (ASSOCIATION)
	/*----------------------------------------------------*/

	/**
	 * FIND BANNER CATEGORIES FROM banner_categories TABLE
	 * @param number $banner_id
	 */
	public function get_banner_locations($banner_id = NULL) {
		$this->table_name = 'banner_locations';
		return $this->banners_model->find_all_by(array('banner_id' => $banner_id));
	}
	
	/**
	 * Insert locations information in banner_locations
	 * @param array $banner_locations
	 */
	public function insert_banner_locations($banner_locations) {
		$this->table_name = 'banner_locations';
		$this->set_created	= false;
		$this->set_modified = false;
		$this->banners_model->insert_batch($banner_locations);
	}
	
	/**
	 * Delete all information from banner_locations table 
	 * @param unknown $banner_id
	 */
	public function delete_banner_locations($banner_id) {
		$this->table_name = 'banner_locations';
		$where['banner_id'] = $banner_id;
		return $this->banners_model->delete_where($where);
	}
	
	/**
	 * Category Banners
	 * @param int $category_id
	 * @return array
	 */
	
	public function get_frontend_category_banners($category_id) {
		$sql = "SELECT B.*, BT.type, BT.width, BT.height,";
		$sql .= " BT.location FROM " . $this->db->dbprefix . "banners B";
		$sql .= " INNER JOIN " . $this->db->dbprefix . "banner_types BT ON B.type_id = BT.id";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "banner_categories BC ON B.id = BC.banner_id";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "banner_locations BL ON B.id = BL.banner_id";
		$sql .= " WHERE (BC.category_id = ". $category_id ." OR B.all_pages = 1)";
		if($this->session->userdata('search_city')) {
			$sql .= " AND BL.city_id =" .$this->session->userdata('search_city');
		}
		$sql .=	" AND ((B.start_date <= '".date("Y/m/d") ."') || (B.start_date = '0000-00-00')) AND ((B.end_date >= '".date("Y/m/d") ."') || (B.end_date = '0000-00-00'))";
		$sql .= " AND ( B.impressions <= B.max_impressions OR B.max_impressions =0 ) AND ( B.clicks <= B.max_clicks OR B.max_clicks =0 )";
		$sql .= " AND ( B.all_pages = 1 OR B.all_pages = 0) AND B.active =1";
		$sql .= " GROUP BY B.id";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}
	
	/**
	 * Location Banners
	 * @param int $category_id
	 * @return array
	 */
	
	public function get_banners_by_city($city_id) {
		$sql = "SELECT B.*, BT.type, BT.width, BT.height,";
		$sql .= " BT.location FROM " . $this->db->dbprefix . "banners B";
		$sql .= " INNER JOIN " . $this->db->dbprefix . "banner_types BT ON B.type_id = BT.id";
		$sql .= " INNER JOIN " . $this->db->dbprefix . "banner_categories BC ON B.id = BC.banner_id";
		$sql .= " INNER JOIN " . $this->db->dbprefix . "banner_locations BL ON B.id = BL.banner_id";
		$sql .= " WHERE BL.city_id = ". $city_id;
		$sql .=	" AND ((B.start_date <= '".date("Y/m/d") ."') || (B.start_date = '0000-00-00')) AND ((B.end_date >= '".date("Y/m/d") ."') || (B.end_date = '0000-00-00'))";
		$sql .= " AND ( B.impressions <= B.max_impressions OR B.max_impressions =0 ) AND ( B.clicks <= B.max_clicks OR B.max_clicks =0 )";
		$sql .= " AND ( B.all_pages = 1 OR B.all_pages = 0) AND B.active =1";
		$sql .= " GROUP BY B.id";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}
	
	/**
	 * Display Banners for Frontend
	 */
	
	public function get_frontend_banners($listing_id) {
		$sql = "SELECT B.*, BT.type, BT.width, BT.height, BT.location FROM " . $this->db->dbprefix . "banners B";
		$sql .= " INNER JOIN " . $this->db->dbprefix . "banner_categories BC ON B.id = BC.banner_id";
		$sql .= " INNER JOIN " . $this->db->dbprefix . "banner_types BT ON B.type_id = BT.id";
		$sql .= " INNER JOIN " . $this->db->dbprefix . "listings L ON BC.category_id = L.category_id";
		$sql .= " WHERE ((B.start_date <= '" .date("Y/m/d") ."') || (B.start_date = '0000-00-00'))";
		$sql .=	" AND ((B.end_date >= '" .date("Y/m/d") ."') || (B.end_date = '0000-00-00'))";
		$sql .= " AND ( B.impressions <= B.max_impressions OR B.max_impressions =0 )";
		$sql .= " AND ( B.clicks <= B.max_clicks OR B.max_clicks =0 )";
		$sql .= " AND ( B.all_pages =1 OR B.all_pages =0 ) AND L.id = " .$listing_id ." AND B.active =1";
		$sql .= " GROUP BY B.id";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}
	
	/**
	 * Tags and Search Page Banners
	 * Banners which are selected as on all_pages will only be shown on tags and search page
	 */
	
	public function get_frontend_banners_all() {
		$sql = "SELECT B.*, BT.type, BT.width, BT.height,";
		$sql .= " BT.location FROM " . $this->db->dbprefix . "banners B";
		$sql .= " INNER JOIN " . $this->db->dbprefix . "banner_types BT ON B.type_id = BT.id";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "banner_locations BL ON B.id = BL.banner_id";
		$sql .= " WHERE ((B.start_date <= '".date("Y/m/d") ."') || (B.start_date = '0000-00-00')) AND ((B.end_date >= '".date("Y/m/d") ."') || (B.end_date = '0000-00-00'))";
		/*if($this->session->userdata('search_city')) {
			$sql .= " AND BL.city_id =" .$this->session->userdata('search_city');
		}*/
		$sql .= " AND ( B.impressions <= B.max_impressions OR B.max_impressions =0 ) AND ( B.clicks <= B.max_clicks OR B.max_clicks =0 )";
		$sql .= " AND ( B.all_pages = 1) AND B.active =1";
		$sql .= " GROUP BY B.id";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}
	
	/**
	 * Get all slider banners for frontpage
	 * @return arrays
	 */	
	public function get_frontend_slider() {
		$sql = "SELECT B.id, B.title, B.image, B.url, B.target, B.slider_heading, B.html_text FROM " . $this->db->dbprefix . "banners B";
		$sql .= " INNER JOIN " . $this->db->dbprefix . "banner_types BT ON B.type_id = BT.id AND BT.location = 'slider'";
		$sql .= " LEFT JOIN " . $this->db->dbprefix . "banner_locations BL ON B.id = BL.banner_id";
		$sql .= " WHERE ((B.start_date <= '".date("Y/m/d") ."') || (B.start_date = '0000-00-00')) AND ((B.end_date >= '".date("Y/m/d") ."') || (B.end_date = '0000-00-00'))";
		/*if($this->session->userdata('search_city')) {
			$sql .= " AND BL.city_id =" .$this->session->userdata('search_city');
		}*/
		$sql .= " AND ( B.impressions <= B.max_impressions OR B.max_impressions =0 ) AND ( B.clicks <= B.max_clicks OR B.max_clicks =0 )";
		$sql .= " AND B.active =1 GROUP BY B.id ORDER BY B.id";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

}
