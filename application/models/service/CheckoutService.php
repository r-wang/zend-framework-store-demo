<?php
/**
	 *  This class encapsulates methods and logic dealing
	 *  with checkout processes
	 */
require_once APPLICATION_PATH . '/models/table/ShippingMethod.php';
require_once APPLICATION_PATH . '/models/table/PaymentMethod.php';
require_once APPLICATION_PATH . '/models/service/CartService.php';

class CheckoutService {
	public function getShippingDetails() {
		session_start ();
		$details = array ('receivername' => $_SESSION ['loginuser'] ['Name'], 'tel' => $_SESSION ['loginuser'] ['TEL'], 'mobile' => $_SESSION ['loginuser'] ['Mobile'], 'email' => $_SESSION ['loginuser'] ['Email'], 'address' => $_SESSION ['loginuser'] ['Address'] = $_SESSION ['loginuser'] ['Email'], 'shippingMethod' => array ('1' => 'EMS快递', '2' => '普通邮寄' ), 'paymentMethod' => array ('1' => '支付宝' ), 'orderedItems' => CartService::getIns ()->getCartProducts (), 'totalPrice' => CartService::getIns ()->getTotalPrice () );
		return $details;
	
	}

}
?>
