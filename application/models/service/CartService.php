<?php
/**
 * This class encapsulates shopping cart processings.
 * Cart is maintained with php session management.
 */
class CartService {
	private $products = array (); // maintains productlist in cart
	
	/*
	 * Constructor and clone methods are declared private, and users must use
	 * getIns() method in order to get an instance of this class. This
	 * implementation facilitates storing and retrieving CartService instance
	 * from session storage. An adaptation to singleton pattern to ensure single
	 * instance storage of cart in session cross pages.
	 */
	private function __construct() {
	}
	private function __clone() {
	}
	
	/**
	 * Gets an instance of CartService.
	 *
	 * CartService instance should be fetched from
	 * session storage if it is there. Otherwise,
	 * instantiate a new instance of it and store
	 * it in session.
	 *
	 * @return CartService CartService instance
	 */
	public static function getIns() {
		session_start ();
		if (! isset ( $_SESSION ['cart'] ) || ! ($_SESSION ['cart'] instanceof self)) {
			$_SESSION ['cart'] = new CartService ();
		}
		return $_SESSION ['cart'];
	}
	
	public function getCartProducts() {
		return $this->products;
	}
	
	public function addProduct($productID, $num = 1) {
		if ($this->hasProduct ( $productID )) {
			$this->increaseNum ( $productID, $num );
			$this->products ["$productID"] ['productTotalPrice'] = $this->products [$productID] ['num'] * $this->products [$productID] ['price'];
		} else {
			$productModel = new Product ();
			$productAdapter = $productModel->getAdapter ();
			$res = $productAdapter->query ( "SELECT Name, Price, Image, Description from product where ProductID=:ProductID", array ('ProductID' => $productID ) )->fetchAll ();
			
			if (count ( $res ) == 0) {
				return;
			}
			
			$productName = $res [0] ['Name'];
			$price = $res [0] ['Price'];
			$image = $res [0] ['Image'];
			$description = $res [0] ['Description'];
			
			$product = array ();
			$product ['id'] = $productID;
			$product ['name'] = $productName;
			$product ['price'] = $price;
			$product ['num'] = $num;
			$product ['image'] = $image;
			$product ['description'] = $description;
			$product ['productTotalPrice'] = $num * $price;
			
			$this->products ["$productID"] = $product;
		}
	}
	
	public function delProduct($productID) {
		unset ( $this->products [$productID] );
	}
	
	public function updateProduct($productID, $newNum) {
		$newNum = $newNum + 0;
		if ($newNum <= 0) {
			$this->delProduct ( $productID );
			return;
		}
		$this->products [$productID] ['num'] = $newNum;
		$this->products [$productID] ['productTotalPrice'] = $this->products [$productID] ['num'] * $this->products [$productID] ['price'];
	}
	
	public function increaseNum($productID, $num = 1) {
		$this->products [$productID] ['num'] += $num;
	
	}
	
	public function decreaseNum($productID) {
		$this->products [$productID] ['num'] --;
		$this->products [$productID] ['productTotalPrice'] = $this->products [$productID] ['num'] * $this->products [$productID] ['price'];
	}
	
	public function clearCart() {
		$this->products = array ();
	}
	
	// get the number of distinct products in cart
	public function getNum() {
		return count ( $this->products );
	}
	
	public function getTotalPrice() {
		if ($this->getNum () == 0) {
			return 0;
		}
		
		$price = 0.0;
		
		foreach ( $this->products as $product ) {
			$price += $product ['num'] * $product ['price'];
		}
		
		return $price;
	}
	
	protected function hasProduct($productID) {
		return array_key_exists ( $productID, $this->products );
	}
}

?>