<?php
 
 
 
 
 
 
 
 
 
 
 
 

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Summary_model extends BF_Model {
	/**
	 * Get summary or total number of counts of all modules
	 * @return counts
	 */
	public function get_dashboard() {
		$sql = " SELECT count(id) as TotalListings,";
		$sql .= " (SELECT COUNT(*) FROM " . $this->db->dbprefix . "listings WHERE deleted = 1) as DeletedListings,";
		$sql .= " (SELECT COUNT(*) FROM " . $this->db->dbprefix . "listings WHERE spammed = 1 AND deleted = 0) as SpammedListings,";
		$sql .= " (SELECT COUNT(*) FROM " . $this->db->dbprefix . "listings WHERE active = 0 AND deleted = 0) as InactiveListings,";
		$sql .= " (SELECT COUNT(DISTINCT listing_id) FROM " . $this->db->dbprefix . "business_hours) as ListingsWithBusinessHours,";
		$sql .= " (SELECT COUNT(*) FROM " . $this->db->dbprefix . "products) as TotalProductsServices,";
		$sql .= " (SELECT COUNT(DISTINCT listing_id) FROM " . $this->db->dbprefix . "products) as ListingsWithProductsServices,";
		$sql .= " (SELECT COUNT(*) FROM " . $this->db->dbprefix . "products WHERE active = 0) as InactiveProductsServices,";
		$sql .= " (SELECT COUNT(*) FROM " . $this->db->dbprefix . "images) as TotalImages,";
		$sql .= " (SELECT COUNT(DISTINCT listing_id) FROM " . $this->db->dbprefix . "images) as ListingsWithImages,";
		$sql .= " (SELECT COUNT(*) FROM " . $this->db->dbprefix . "images WHERE active = 0) as InactiveImages,";
		$sql .= " (SELECT COUNT(*) FROM " . $this->db->dbprefix . "videos) as TotalVideos,";
		$sql .= " (SELECT COUNT(DISTINCT listing_id) FROM " . $this->db->dbprefix . "videos) as ListingsWithVideos,";
		$sql .= " (SELECT COUNT(*) FROM " . $this->db->dbprefix . "videos WHERE active = 0) as InactiveVideos,";
		$sql .= " (SELECT COUNT(*) FROM " . $this->db->dbprefix . "classifieds) as TotalClassifieds,";
		$sql .= " (SELECT COUNT(DISTINCT listing_id) FROM " . $this->db->dbprefix . "classifieds) as ListingsWithClassifieds,";
		$sql .= " (SELECT COUNT(*) FROM " . $this->db->dbprefix . "classifieds WHERE active = 0) as InactiveClassifieds,";
		$sql .= " (SELECT COUNT(*) FROM " . $this->db->dbprefix . "comments) as TotalComments,";
		$sql .= " (SELECT COUNT(*) FROM " . $this->db->dbprefix . "comments WHERE status = 0) as InactiveComments,";
		$sql .= " (SELECT COUNT(*) FROM " . $this->db->dbprefix . "tags) as TotalTags,";
		$sql .= " (SELECT COUNT(*) FROM " . $this->db->dbprefix . "tags WHERE active = 0) as InactiveTags,";
		$sql .= " (SELECT COUNT(*) FROM " . $this->db->dbprefix . "users) as TotalUsers,";
		$sql .= " (SELECT COUNT(*) FROM " . $this->db->dbprefix . "users WHERE active = 0) as InactiveUsers,";
		$sql .= " (SELECT COUNT(*) FROM " . $this->db->dbprefix . "transactions) as TotalTransactions,";
		$sql .= " (SELECT COUNT(*) FROM " . $this->db->dbprefix . "transactions WHERE status = 0) as CancelledTransactions,";
		$sql .= " (SELECT COUNT(*) FROM " . $this->db->dbprefix . "transactions WHERE status = 1) as PaidTransactions,";
		$sql .= " (SELECT COUNT(*) FROM " . $this->db->dbprefix . "categories) as TotalCategories,";
		$sql .= " ((SELECT COUNT(*) FROM " . $this->db->dbprefix . "countries) + (SELECT COUNT(*) FROM " . $this->db->dbprefix . "states) + (SELECT COUNT(*) FROM " . $this->db->dbprefix . "cities) + (SELECT COUNT(*) FROM " . $this->db->dbprefix . "localities)) as TotalLocations,";
		$sql .= " (SELECT COUNT(*) AS `numrows` FROM (`" . $this->db->dbprefix . "email_queue`) WHERE `date_sent` IS NOT NULL) as EmailsInQueue";
		$sql .= " FROM " . $this->db->dbprefix . "listings;";
		$query = $this->db->query ( $sql );
		$result = $query->row ();
		return $result;
	}
}