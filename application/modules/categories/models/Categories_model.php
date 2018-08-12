<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Categories_model extends BF_Model {

	protected $table_name	= "categories";
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
			"field"		=> "categories_name",
			"label"		=> "lang:label_name",
			"rules"		=> "required|unique[categories.name,categories.id]|max_length[100]|sanitize"
		),
		array(
			"field"		=> "categories_slug",
			"label"		=> "lang:label_slug",
			"rules"		=> "unique[categories.slug,categories.id]|max_length[100]|sanitize"
		),
		array(
			"field"		=> "categories_meta_title",
			"label"		=> "lang:label_meta_title",
			"rules"		=> "max_length[100]|sanitize"
		),
		array(
			"field"		=> "categories_meta_keywords",
			"label"		=> "lang:label_meta_keywords",
			"rules"		=> "trim|sanitize|alpha_keyword|tag_handling"
		),
		array(
			"field"		=> "categories_description",
			"label"		=> "lang:label_description",
			"rules"		=> "max_length[1000]"
		)
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= FALSE;

	//--------------------------------------------------------------------
	
	/**
	 * Get categories without parent
	 * @return multitype:string NULL
	 */
	public function get_no_parents ()
	{
		// Fetch categories without parents
		$this->db->select('id, name');
		$this->db->where('parent_id', 0);
		$categories = $this->categories_model->find_all();
	
		// Return key => value pair array
		$array = array(
				0 => 'No Parent'
		);
		if (count($categories)) {
			foreach ($categories as $category) {
				$array[$category->id] = $category->name;
			}
		}
	
		return $array;
	}
	
	/**
	 * Save categories only when user clicks on save button
	 * @param array $categories
	 */
	public function save_order ($categories)
	{
		if (count($categories)) {
			foreach ($categories as $order => $category) {
				if ($category['item_id'] != '') {
					$data = array('parent_id' => (int) $category['parent_id'], 'order' => $order);
					$this->db->set($data)->where('id', $category['item_id'])->update($this->table_name);
				}
			}
		}
	}
	
	/**
	 * To display all categories to the admin
	 * @return multitype:multitype:unknown
	 */
	public function get_nested ()
	{
		$categories = $this->db->get('categories')->result_array();
		return $this->prepareList($categories);
	}
	
	/**
	 * PREPARE LIST TO GET PARENTS AND ITS CHILDREN
	 * @param array $items
	 * @param number $pid
	 * @return multitype:multitype:unknown
	 */
	private function prepareList(array $items, $pid = 0)
	{
		$output = array();
	
		# loop through the items
		foreach ($items as $item) {
	
			# Whether the parent_id of the item matches the current $pid
			if ((int) $item['parent_id'] == $pid) {
	
				# Call the function recursively, use the item's id as the parent's id
				# The function returns the list of children or an empty array()
				if ($children = $this->prepareList($items, $item['id'])) {
	
					# Store all children of the current item
					$item['children'] = $children;
				}
	
				# Fill the output
				$output[] = $item;
			}
			}
	
			return $output;
	}

	/**
	 * Get parent categories using AJAX
	 * @return multitype:string NULL
	 */
	public function get_parent_categories(){
		$result = $this->categories_model->select('id, name')->where(array('parent_id' => 0, 'active' => 1))->find_all();
	
		$options = array(); //FILL OPTION ARRAY
	
		$options[''] = lang('label_select_parent');
		// Format for passing into form_dropdown function
		foreach ($result as $option) {
			$options[$option->id] = $option->name;
		}
	
		return $options;
	}
	
	/**
	 * Get sub categories using AJAX
	 * @param string $parent_id
	 * @return void|multitype:NULL
	 */
	public function get_sub_categories($parent_id = NULL){
		if(!is_null($parent_id)){
			$results = $this->categories_model->select('id, name')->where(array('parent_id' => $parent_id, 'active' => 1))->find_all();
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
	 * To display breadcrumb on detail page
	 * @param unknown $id
	 */
	public function get_breadcrumb ($id) {
		$this->db->select('categories.id AS subsub_id, categories.name AS subsub_category,  categories.slug AS subsub_slug, sub.id AS sub_id, sub.name AS sub_category, sub.slug AS sub_slug, pc.id AS parent_id, pc.name AS parent_category, pc.slug AS parent_slug');
		$this->db->join('categories sub','categories.parent_id = sub.id', 'left');
		$this->db->join('categories pc','sub.parent_id = pc.id', 'left');
		$this->db->where('categories.active', 1);
		return $this->categories_model->find($id);
	}

	/**
	 * Get categories for home page
	 */
	public function get_home_categories () {
		$count_sql = "";//UPDATE " . $this->db->dbprefix . "categories LEFT JOIN ( ";
		if(settings_item('lst.categories_level') == 1) {
			$count_sql .= "SELECT C.id AS category_id, TotalCounts FROM " . $this->db->dbprefix . "categories C";
			$count_sql .= " LEFT JOIN (SELECT category_id, COUNT('id') AS TotalCounts FROM " . $this->db->dbprefix . "listings GROUP BY category_id) L ON L.category_id = C.id";
			$count_sql .= " WHERE C.parent_id = 0";
		} else if(settings_item('lst.categories_level') == 2) {
			$count_sql .= "SELECT parent.id AS category_id, COUNT( " . $this->db->dbprefix . "listings.id )";
			$count_sql .= " + (SELECT COUNT( " . $this->db->dbprefix . "listings.id ) FROM " . $this->db->dbprefix . "categories AS subcategory";
			$count_sql .= " LEFT JOIN " . $this->db->dbprefix . "listings ON " . $this->db->dbprefix . "listings.category_id = subcategory.id AND " . $this->db->dbprefix . "listings.deleted = 0 AND " . $this->db->dbprefix . "listings.spammed = 0 AND " . $this->db->dbprefix . "listings.active = 1 WHERE parent.id = subcategory.parent_id) AS TotalCounts";
			$count_sql .= " FROM " . $this->db->dbprefix . "categories AS parent";
			$count_sql .= " LEFT JOIN " . $this->db->dbprefix . "listings ON " . $this->db->dbprefix . "listings.category_id = parent.id AND " . $this->db->dbprefix . "listings.deleted = 0 AND " . $this->db->dbprefix . "listings.spammed = 0 AND " . $this->db->dbprefix . "listings.active = 1 GROUP BY parent.id ORDER BY parent.id";
		} else if(settings_item('lst.categories_level') == 3) {
			/**
			 * Level 3 Categories Count Steps
			 * Empty categories_count table
			 * Empty categories_level table
			 * Get records from listings table and insert count into categories_count table
			 * Get records from categories table in hierarichal order and fill categories_level table 
			 * Count records and fill categories table counts column
			 */
		
			// STEP 1: Empty categories_count table
			$truncate_categories_count_sql = "TRUNCATE TABLE " . $this->db->dbprefix . "categories_count";
			$this->db->simple_query($truncate_categories_count_sql);
			
			// STEP 2: Empty categories_level table
			$truncate_categories_level_sql = "TRUNCATE TABLE " . $this->db->dbprefix . "categories_level";
			$this->db->simple_query($truncate_categories_level_sql);
			
			// STEP 3: Get records from listings table and insert count into categories_count table
			$fill_categories_count_sql = "INSERT INTO " . $this->db->dbprefix . "categories_count (SELECT id AS category_id, (CASE WHEN TotalCounts IS NULL THEN 0 ELSE TotalCounts END) AS counts FROM " . $this->db->dbprefix . "categories";
			$fill_categories_count_sql .= " LEFT JOIN (SELECT category_id, COUNT(id) AS TotalCounts FROM " . $this->db->dbprefix . "listings L WHERE L.deleted = 0 AND L.spammed = 0 AND L.active = 1";
			$fill_categories_count_sql .= " GROUP BY category_id) B ON B.category_id = " . $this->db->dbprefix . "categories.id)";
			$this->db->simple_query($fill_categories_count_sql);
			
			// STEP 4: Get records from categories table in hierarichal order and fill categories_level table
			$fill_categories_level_sql = "INSERT INTO " . $this->db->dbprefix . "categories_level (SELECT PARENT.id AS parent_id, CASE WHEN SUB.sub_id IS NULL THEN 0 ELSE SUB.sub_id END, CASE WHEN SUBSUB.subsub_id IS NULL THEN 0 ELSE SUBSUB.subsub_id END FROM " . $this->db->dbprefix . "categories AS PARENT";
			$fill_categories_level_sql .= " LEFT JOIN (SELECT id AS sub_id, parent_id FROM " . $this->db->dbprefix . "categories) SUB ON PARENT.id = SUB.parent_id AND SUB.parent_id != 0";
			$fill_categories_level_sql .= " LEFT JOIN (SELECT id AS subsub_id, parent_id FROM " . $this->db->dbprefix . "categories) SUBSUB ON SUB.sub_id = SUBSUB.parent_id WHERE PARENT.parent_id = 0)";
			$this->db->simple_query($fill_categories_level_sql);
			
			// STEP 5: Count records and fill categories table counts column
			$count_sql .= "(SELECT  W.category_id , IFNULL(V.s1_sum,0) + W.counts TotalCounts FROM";
			$count_sql .= " (SELECT U.parent_id , SUM(U.s1_count) s1_sum FROM (SELECT * FROM";
			$count_sql .= " (SELECT C.category_id s1_id, IFNULL(B.ct,0) + C.counts s1_count FROM";
			$count_sql .= " (SELECT A.sub_id si,SUM( A.counts) ct FROM";
			$count_sql .= " (SELECT * FROM " . $this->db->dbprefix . "categories_level JOIN " . $this->db->dbprefix . "categories_count ON category_id = subsub_id) A";
			$count_sql .= " GROUP BY A.sub_id) B RIGHT JOIN " . $this->db->dbprefix . "categories_count C ON C.category_id = B.si ) s1_lvl JOIN";
			$count_sql .= "	(SELECT DISTINCT parent_id, sub_id FROM " . $this->db->dbprefix . "categories_level) T ON T.sub_id = s1_lvl.s1_id) U";
			$count_sql .= " GROUP BY  U.parent_id ) V RIGHT JOIN " . $this->db->dbprefix . "categories_count W ON W.category_id = V.parent_id";
			$count_sql .= "	WHERE W.category_id IN (SELECT DISTINCT parent_id FROM " . $this->db->dbprefix . "categories_level ))";
			$count_sql .= "	UNION (SELECT C.category_id s1_id, IFNULL(B.Ct,0) + C.counts s1_count FROM";
			$count_sql .= " (SELECT A.sub_id si,SUM( A.counts) ct FROM";
			$count_sql .= "	(SELECT * FROM  " . $this->db->dbprefix . "categories_level JOIN " . $this->db->dbprefix . "categories_count ON category_id = subsub_id) A";
			$count_sql .= "	GROUP BY A.sub_id) B RIGHT JOIN " . $this->db->dbprefix . "categories_count C ON C.category_id = B.si";
			$count_sql .= "	WHERE C.category_id IN (SELECT DISTINCT sub_id FROM " . $this->db->dbprefix . "categories_level ))";
			$count_sql .= " UNION (SELECT subsub_id , counts FROM  " . $this->db->dbprefix . "categories_level JOIN " . $this->db->dbprefix . "categories_count ON category_id = subsub_id)";	
		}
		//$count_sql .= " ) AS D ON D.category_id = " . $this->db->dbprefix . "categories.id SET " . $this->db->dbprefix . "categories.counts = D.TotalCounts";
		$query = $this->db->query ( $count_sql );
		$result = $query->result_array ();
		return $result;
	}
	
	/**
	 * To update number of hits of visited category
	 * @param int $id
	 */
	public function updateHits($id) {
		$this->db->where('id', $id);
		$this->db->set('hits', 'hits + 1', FALSE);
		$this->db->update('categories');
	}
}
