<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
 
 
 
 
 
 
 
 
 
 

class Pages_model extends BF_Model {

	protected $table_name	= "pages";
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
	protected $validation_rules = array(
		array(
			"field"		=> "pages_title",
			"label"		=> "lang:label_title",
			"rules"		=> "required|max_length[100]"
		),
		array(
			"field"		=> "pages_slug",
			"label"		=> "lang:label_slug",
			"rules"		=> "unique[pages.slug,pages.id]|max_length[100]|alpha_extra|sanitize"
		),
		array(
			"field"		=> "pages_body",
			"label"		=> "lang:label_body",
			"rules"		=> "required|xss_clean"
		),
		array(
			"field"		=> "pages_meta_title",
			"label"		=> "lang:label_meta_title",
			"rules"		=> "max_length[100]|sanitize"
		),
		array(
			"field"		=> "pages_meta_keywords",
			"label"		=> "lang:label_meta_keywords",
			"rules"		=> "max_length[250]|sanitize"
		),
		array(
			"field"		=> "pages_meta_description",
			"label"		=> "lang:label_meta_description",
			"rules"		=> "max_length[250]|sanitize"
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= FALSE;

	//--------------------------------------------------------------------
	/**
	 * Get all parent pages
	 * @return multitype:string NULL
	 */
	public function get_no_parents () {
		// Fetch pages without parents
		$this->db->select('id, title');
		$this->db->where('parent_id', 0);
		$pages = $this->db->get('pages')->result();
	
		// Return key => value pair array
		$array = array(
				0 => 'No parent'
		);
		if (count($pages)) {
			foreach ($pages as $page) {
				$array[$page->id] = $page->title;
			}
		}
	
		return $array;
	}
	
	/*----------------------------------------------------*/
	/*	Order Pages using Ajax NestedSortable
	/*----------------------------------------------------*/
	
	/**
	 * Save pages only when user clicks on save button
	 * @param unknown $pages
	 */
	public function save_order ($pages)
	{
		if (count($pages)) {
			foreach ($pages as $order => $page) {
				if ($page['item_id'] != '') {
					$data = array('parent_id' => (int) $page['parent_id'], 'order' => $order);
					$this->db->set($data)->where('id', $page['item_id'])->update($this->table_name);
				}
			}
		}
	}
	
	/**
	 * Display all pages to the user
	 * @return multitype:unknown
	 */
	public function get_nested () {
		$pages = $this->db->order_by('order')->get('pages')->result_array();
		return $this->prepareList($pages);
	}
	
	/**
	 * Prepare list to get parents and its children
	 * @param array $items
	 * @param number $pid
	 * @return multitype:multitype:unknown
	 */
	private function prepareList(array $items, $pid = 0) {
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
		 * Display pages link at frontend
		 */
		public function get_links () {
			$this->db->select('pages.id, pages.title as sub_page, pages.slug, pages.parent_id, pages.location, pp.title as parent_page');
			$this->db->join('pages pp','pages.parent_id = pp.id', 'left');
			$this->db->where('pages.active', 1);
			return $this->pages_model->order_by('pages.order', 'asc')->find_all();
		}
}
