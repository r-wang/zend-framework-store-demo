<?php

require_once 'BaseController.php';

require_once APPLICATION_PATH . '/models/service/ProductService.php';
require_once APPLICATION_PATH . '/models/utils/Pagination.php';

class ShoppingController extends BaseController {

 public function productdetailsAction(){

		$productID = $this->getRequest ()->getParam ( 'id' ) + 0;
		$productService = new ProductService ();
		$productDetails = $productService->getProductDetails ( $productID );
		if ($productDetails == null) {
			$this->_redirect ( '/index/index' );
		}
		$this->view->productDetails = $this->escape->htmlEscapeRecursively($productDetails);
}
	public function searchAction() {
		$keyword = $this->getRequest ()->getParam ( 'keyword' );
		
		$productService = new ProductService ();
		
		$pagenow = $this->getRequest ()->getParam ( 'page', 0 ) + 0;
		$pagesize = 8;
		
		$res = $productService->search ( $keyword, $pagenow, $pagesize );
		$paging = new Pagination ( $pagenow, $pagesize, ceil ( $productService->getSearchCount ( $keyword ) / $pagesize ), "/shopping/search?keyword=" . urlencode ( $keyword ) );
		
		$this->view->searchproducts = $this->escape->htmlEscapeRecursively ( $res );
		$this->view->keyword = $this->escape->sanitize_html ( $keyword );
		$this->view->paging = $paging->paging ();
		$this->view->keyword = $this->escape->sanitize_html( $keyword );
		$this->render ( "searchui" );
	
	}
	public function searchuiAction() {
	
	}
	
	public function searchwithsortAction() {
		$keyword = $this->getRequest ()->getParam ( 'keyword' );
		
		$productService = new ProductService ();
		
		if ($this->_getParam ( 'psort', null ) == null) {
			$this->_redirect ( "shopping/search" );
		}
		$psort = explode ( ":", $this->_getParam ( 'psort' ) );
		$orderby = $psort [0];
		$order = $psort [1];
		
		$pagenow = $this->getRequest ()->getParam ( 'page', 0 ) + 0;
		$pagesize = 8;
		
		$res = $productService->searchWithSort ( $keyword, $orderby, $order, $pagenow, $pagesize );
		$paging = new Pagination ( $pagenow, $pagesize, ceil ( $productService->getSearchCount ( $keyword ) / $pagesize ), "/shopping/searchwithsort?keyword=" . urlencode ( $keyword ) );
		
		$this->view->searchproducts = $this->escape->htmlEscapeRecursively ( $res );
		$this->view->keyword = $this->escape->htmlEscapeRecursively ( $keyword );
		$this->view->paging = $this->escape->htmlEscapeRecursively ( $paging->paging () );
		$this->view->keyword = $this->escape->htmlEscapeRecursively ( $keyword );
		
		$this->render ( "searchui" );
	}
	
	public function categoryAction() {
		$categoryid = $this->getRequest ()->getParam ( 'id' ) + 0;
		
		$productService = new ProductService ();
		$categoryService = new CategoryService ();
		
		$latestProducts = $productService->getLatestProducts ();
		$this->view->latestProducts = $this->escape->htmlEscapeRecursively ( $latestProducts );
		
		if ($categoryService->hasChildren ( $categoryid )) {
			$this->view->message = "请继续选择子类";
			$this->render ( 'categoryinfo' );
		}
		
		$pagenow = $this->getRequest ()->getParam ( 'page', 0 ) + 0;
		$pagesize = 4;
		
		$data = $productService->getCatProductsByPage ( $categoryid, $pagenow, $pagesize );
		if (empty ( $data )) {
			$this->view->message = "这个分类暂时没有商品上架";
			$this->render ( 'categoryinfo' );
		}
		
		$this->view->productsByCat = $data;
		
		$page = new Pagination ( $pagenow, 4, ceil ( $productService->getCount ( $categoryid ) / $pagesize ), "/shopping/category?id=" . urlencode ( $categoryid ) );
		$this->view->paging = $page->paging ();
	
	}
	
}
?>