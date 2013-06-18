<?php

/**

	 *  This class encapsulates methods and logic dealing

	 *  with products in the shop

	 */

require_once APPLICATION_PATH . '/models/table/Product.php';

class ProductService {

	

	public function getSearchCount($keyword) {

		$productModel = new Product ();

		$productAdapter = $productModel->getAdapter ();

		$products = $productAdapter->query ( "select count(*) as c from product where

				Name like :keyword", array ('keyword' => "%$keyword%" ) )->fetchAll ();

		return $products [0] ['c'];

	}

	public function search($keyword, $pagenow, $pagesize) {

		$productModel = new Product ();

		$productAdapter = $productModel->getAdapter ();

		$escape = new StringSanitization ();

		$start = $pagenow * $pagesize; 
		$start = $escape->mysql_fix_string ( $start );

		$pagesize = $escape->mysql_fix_string ( $pagesize );



		$products = $productAdapter->query ( "select * from product where

					Name like :keyword  limit $start, $pagesize", array ('keyword' => "%$keyword%" ) )->fetchAll ();

		return $products;

	}

	

	public function searchWithSort($keyword, $orderby, $order, $pagenow, $pagesize) {

		$escape = new StringSanitization ();

		$orderby = $escape->mysql_fix_string ( $orderby );

		$order = $escape->mysql_fix_string ( $order );

		

		if (empty ( $orderby ) || empty ( $order )) {

			$this->search ();

		}

		$productModel = new Product ();

		$productAdapter = $productModel->getAdapter ();

		$escape = new StringSanitization ();

		$start = $pagenow * $pagesize;

		$start = $escape->mysql_fix_string ( $start );

		$pagesize = $escape->mysql_fix_string ( $pagesize );

		$products = $productAdapter->query ( "select * from product where

					Name like :keyword order by $orderby $order  limit $start, $pagesize", array ('keyword' => "%$keyword%" ) )->fetchAll ();

		return $products;

	}

	

	public function getLatestProducts() {

		$productModel = new Product ();

		$productAdapter = $productModel->getAdapter ();

		$res = $productAdapter->query ( "select Name, Price, Promoted, Image, ProductID from product order by Date_Added desc limit 8" )->fetchAll ();

		return $res;

	}

	

	public function getPromotedProducts() {

		$productModel = new Product ();

		$productAdapter = $productModel->getAdapter ();

		$res = $productAdapter->query ( "select ProductID, Name, Price, Promoted, Image, ProductID from product where Promoted=true" )->fetchAll ();

		return $res;

	}

	

	public function getHotProducts() {

		$productModel = new Product ();

		$productAdapter = $productModel->getAdapter ();

		$res = $productAdapter->query ( "select Name, Price, Promoted, Image, ProductID from product order by QuantitySold desc limit 8" )->fetchAll ();

		return $res;

	}

	

	public function getProductDetails($productID) {

		$productModel = new Product ();

		$productAdapter = $productModel->getAdapter ();

		

		$productDetails = $productAdapter->query ( "select * from product where ProductID=:id", array ('id' => $productID ) )->fetchAll ();

		return $productDetails [0];

	}

	

	public function getCount($categoryid) {

		$productModel = new Product ();

		$productAdapter = $productModel->getAdapter ();

		$res = $productAdapter->query ( "select count(*) as c from product where Category=:categoryid", array ("categoryid" => $categoryid ) )->fetchAll ();

		return $res [0] ['c'];

	}

	

	public function getCatProductsByPage($categoryid, $pagenow, $pagesize) {

		$productModel = new Product ();

		$productAdapter = $productModel->getAdapter ();

		$escape = new StringSanitization ();

		$start = $pagenow * $pagesize;

		$start = $escape->mysql_fix_string ( $start );

		$pagesize = $escape->mysql_fix_string ( $pagesize );

		$res = $productAdapter->query ( "select Name, Price, Image, ProductID from product where Category=:categoryid limit $start, $pagesize", array ('categoryid' => $categoryid ) )->fetchAll ();

		return $res;

	}

	public function getCatProducts($categoryid) {

		$productModel = new Product ();

		$productAdapter = $productModel->getAdapter ();

		$res = $productAdapter->query ( "select Name, Price, Image, ProductID from product where Category=:categoryid", array ('categoryid' => $categoryid ) )->fetchAll ();

		return $res;

	}



}