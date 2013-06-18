<?php

require_once 'BaseController.php';

require_once APPLICATION_PATH . '/models/service/CartService.php';



class CartController extends BaseController {


	public function addproductAction() {

		$productID = $this->getRequest ()->getParam ( 'id' );

		$num = $this->getRequest ()->getParam ( 'quantity', 1 );

		

		if ($productID != null) {

			$cartService = CartService::getIns ();

			$cartService->addProduct ( $productID, $num );

		}

		$this->view->cartProducts = $this->escape->htmlEscapeRecursively ( $cartService->getCartProducts () );

		$this->view->totalPrice = $this->escape->sanitize_html ( $cartService->getTotalPrice () );

		

		$this->_redirect ( $_SERVER ['HTTP_REFERER'] );

	}

	

	public function updatecartAction() {

		$cartService = CartService::getIns ();

		

		$data = $this->getRequest ()->getParam ( 'quantity' );

		foreach ( $data as $productID => $newNum ) {

			// update cart distinct product quantity

			$cartService->updateProduct ( $productID, $newNum + 0 );

		}

		

		$data = $this->getRequest ()->getParam ( 'remove' );

		

		foreach ( $data as $key => $value ) {

			// delete cart item with product id $key

			$cartService->delProduct ( $key );

		}

		

		$this->_forward ( "viewcartui", "cart" );

	}

	

	public function viewcartuiAction() {

		$cartProducts = CartService::getIns ()->getCartProducts ();

		$this->view->cartProducts = $this->escape->htmlEscapeRecursively ( $cartProducts );

		$this->view->totalPrice = $this->escape->sanitize_html ( CartService::getIns ()->getTotalPrice () );

	}


	public function removeAction() {

		

		// makes disable renderer

		$this->_helper->viewRenderer->setNoRender ();

		

		// makes disable layout

		$this->_helper->getHelper ( 'layout' )->disableLayout ();

		

		$id = $this->getRequest ()->getParam ( 'id' ) + 0;

		

		$cart = CartService::getIns ();

		$cart->delProduct ( $id );

		

		echo "ok";

	}



}



