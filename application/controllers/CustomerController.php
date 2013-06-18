<?php
require_once 'BaseController.php';
require_once APPLICATION_PATH . '/models/service/CustomerService.php';

class CustomerController extends BaseController {
	
	public function registeruiAction() {
	
	}
	
	public function loginuiAction() {
	
	}
	
	public function accountAction() {
		$customerService = new CustomerService ();
		if (! $customerService->isLoggedIn ()) {
			$this->_forward ( 'loginui' );
			return;
		}
	}
	
	public function editAction() {
		$customerService = new CustomerService ();
		if (! $customerService->isLoggedIn ()) {
			$this->_forward ( 'loginui' );
			return;
		}
		$customerDetails = $customerService->getCustomerDetails ();
		$this->view->customerDetails = $this->escape->htmlEscapeRecursively ( $customerDetails );
	}
	
	public function updateAction() {
		$data = $this->getRequest ()->getParam ( 'Customer' );
		
		$customerService = new CustomerService ();
		$isUpdateSuccessful = $customerService->updateCustomer ( $data ['name'], $data ['telephone'], $data ['address'], $data ['password'], $data ['mobile'] );
		if ($isUpdateSuccessful) {
			$this->_forward ( 'account' );
		} else {
			$this->view->info = "Update Failed!";
			$this->_redirect ( "/global/err" );
		}
	
	}
	
	public function orderhistoryAction() {
	
	}
	public function logoutAction() {
		$cs = new CustomerService ();
		$cs->logout ();
		$this->_redirect ( 'index/index' );
	}
	
	public function loginAction() {
		// receive data
		$arr = $this->getRequest ()->getParams ();
		$data = $arr ['LoginForm'];
		
		$name = $data ['email'];
		$password = $data ['password'];
		
		// process request
		$customerService = new CustomerService ();
		$isLoginSuccessful = $customerService->login ( $name, $password );
		
		// forward to relevant pages
		if ($isLoginSuccessful) {
			$this->_forward ( 'index', 'index' );
		} else {
			$this->view->errMsg = "邮箱或密码错误";
			$this->render ( 'loginui' );
		}
	
	}
	
	public function checkdataAction() {
		// makes disable renderer
		$this->_helper->viewRenderer->setNoRender ();
		
		// makes disable layout
		$this->_helper->getHelper ( 'layout' )->disableLayout ();
		
		$arr = $this->getRequest ()->getParams ();
		
		$email = $arr ['email'];
		
		$customerService = new CustomerService ();
		
		$isEmailDuplicated = $customerService->checkEmail ( $email );
		
		if ($isEmailDuplicated) {
			echo "Email已存在";
		} else {
			echo "ok";
		}
	}
	
	public function registerAction() {
		
		// receive data
		$arr = $this->getRequest ()->getParams ();
		$data = $arr ['Customer'];
		
		$name = $data ['name'];
		$email = $data ['email'];
		$telephone = $data ['telephone'];
		$mobile = $data ['mobile'];
		$address = $data ['address'];
		$password = $data ['password'];
		
		// save in database
		$customerService = new CustomerService ();
		$isRegistrationSuccessful = $customerService->register ( $name, $email, $telephone, $mobile, $address, $password );
		
		// forward to relevant pages
		if ($isRegistrationSuccessful) {
			$this->_forward ( 'index', 'index' );
		} else {
			$this->view->info = "Register Failed!";
			$this->_redirect ( "/global/err" );
		}
	}
}

