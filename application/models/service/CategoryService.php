<?php
/**
	 *  This class encapsulates methods and logic dealing
	 *  with product categories in the shop
	 */
require_once APPLICATION_PATH . '/models/table/Category.php';
class CategoryService {
	
	// Instance of Class Category as a table model
	private $categoryModel;
	
	// Adapter for category model
	private $db;
	
	// Initializes variables
	public function CategoryService() {
		$this->categoryModel = new Category (); // category table model
		$this->db = $this->categoryModel->getAdapter (); // category table db
		                                                 // adapter
	}
	/**
	 * Retrieves all sub categories under the specified parent category
	 * in the shop recursively
	 *
	 * @param $categoryid id
	 *       	 for the parent category
	 *       	 An array of Category objects
	 *       	 represented in a tree format
	 *       	
	 * @return
	 *
	 *
	 */
	public function getCategoriesByID($categoryid) {
		$data = array ();
		$where = $this->db->quoteInto ( "ParentCatId=?", "$categoryid" );
		$categories = $this->categoryModel->fetchAll ( $where )->toArray ();
		
		foreach ( $categories as $category ) {
			$row ['text'] = $category ['Name'];
			$row ['id'] = $category ['CategoryID'];
			$row ['children'] = $this->getCategoriesByID ( $category ['CategoryID'] );
			$data [] = $row;
		}
		return $data;
	}
	
	public function hasChildren($categoryid) {
		$where = $this->db->quoteInto ( "ParentCatId=?", "$categoryid" );
		$categories = $this->categoryModel->fetchAll ( $where )->toArray ();
		
		return ! empty ( $categories );
	}
	
	public function getCatChildren($categoryid) {
		$data = array ();
		$where = $this->db->quoteInto ( "ParentCatId=?", "$categoryid" );
		$categories = $this->categoryModel->fetchAll ( $where )->toArray ();
		return $categories;
	}
	
	public function getAllCategories() {
		return $this->getCategoriesByID ( 1 );
	}

}
?>