<?php
require_once 'BaseController.php';
require_once APPLICATION_PATH . '/models/service/ProductService.php';

class IndexController extends BaseController {
	public function indexAction() {
		$productService = new ProductService ();
		
		$latestProducts = $productService->getLatestProducts ();
		$this->view->latestProducts = $this->escape->htmlEscapeRecursively ( $latestProducts );
	}
}

