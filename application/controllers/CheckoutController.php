<?php

require_once 'BaseController.php';

require_once APPLICATION_PATH . '/models/service/CheckoutService.php';

require_once APPLICATION_PATH . '/models/service/CustomerService.php';

require_once APPLICATION_PATH . '/models/service/CartService.php';



class CheckoutController extends BaseController {

	public function init() {

		parent::init ();

		$cart = CartService::getIns ();

		if ($cart->getNum () == 0) {

			$this->_redirect ( 'global/checkouterr' );

		}

		

		$customerService = new CustomerService ();

		if (! $customerService->isLoggedIn ()) {

			$this->_redirect ( 'customer/loginui' );

		}

	}

	public function shippingAction() {

		$checkoutService = new CheckoutService ();

		$this->view->shippingDetails = $this->escape->htmlEscapeRecursively ( $checkoutService->getShippingDetails () );

	}

	

	public function submitorderAction() {

		$this->_redirect ( 'global/ordererr' );

	}



}



