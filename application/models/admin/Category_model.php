<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Category_model class.
 * 
 * @extends CI_Model
 */
class Category_model extends CI_Model {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function save($data) {
	}
	
	/**
	 * will use to get the all categories 
	 * 0 : active
	 * 1 : inactive
	 * 2 : deleted
	 * 
	 */
	public function getAll() {
		$query = $this->db->query('SELECT c1.id as id, c1.name category, c2.name as parent, c1.status as status from categories c1 LEFT OUTER JOIN categories c2 ON c1.parent_id = c2.id');
		return $query->result();
	}
	
	public function getCategoryCombo($id=0) {
		static $class = array();
		static $times = 0;
		$times++;
		$query = $this->db->query("SELECT id, name FROM categories WHERE `parent_id` ='".$id."'");
		foreach ($query->result() as $row)
		{
			$class[$row->id] = str_repeat("-   ",$times-1)."->".$row->name;
			$this->getCategoryCombo($row->id);
		}
		$times--;
		return $class;
	}
	
}