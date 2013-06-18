<?php

require_once APPLICATION_PATH . '/models/service/ProductService.php';

require_once APPLICATION_PATH . '/models/service/CartService.php';

require_once APPLICATION_PATH . '/models/service/CustomerService.php';

require_once APPLICATION_PATH . '/models/service/CategoryService.php';

require_once APPLICATION_PATH . '/models/utils/StringSanitization.php';



class BaseController extends Zend_Controller_Action {

	protected $escape;

	public function init() {

		// for sanitizing input data

		$this->escape = new StringSanitization ();

		

		// for mysql access

		$url = constant ( "APPLICATION_PATH" ) . DIRECTORY_SEPARATOR . 'configs' . DIRECTORY_SEPARATOR . 'application.ini';

		$dbconfig = new Zend_Config_Ini ( $url, "mysql" );

		$db = Zend_Db::factory ( $dbconfig->db );

		$db->query ( 'SET NAMES UTF8' );

		Zend_Db_table::setDefaultAdapter ( $db );

		

		// for layout data

		$productService = new ProductService ();

		$hotProducts = $productService->getHotProducts ();

		$this->view->hotProducts = $this->escape->htmlEscapeRecursively ( $hotProducts );

		$promotedProducts = $productService->getPromotedProducts ();

		$this->view->promotedProducts = $this->escape->htmlEscapeRecursively ( $promotedProducts );

		$this->view->cartProducts = $this->escape->htmlEscapeRecursively ( CartService::getIns ()->getCartProducts () );

		$this->view->totalPrice = $this->escape->sanitize_html( CartService::getIns ()->getTotalPrice () );

		

		// check if user is logged in

		$customerService = new CustomerService ();

		$this->view->loginflag = $this->escape->sanitize_html( $customerService->isLoggedIn () );

		

		// category data

		$categoryService = new CategoryService ();

		$this->view->categories = $this->escape->htmlEscapeRecursively ( $categoryService->getAllCategories () );

	}

}



?>