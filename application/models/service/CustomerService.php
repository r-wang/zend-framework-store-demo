<?php
/**
	 *  This class encapsulates methods and logic dealing
	 *  with customer account processes
	 */
require_once APPLICATION_PATH . '/models/table/Customer.php';
require_once APPLICATION_PATH . '/models/utils/Validation.php';
class CustomerService {
	
	/**
	 * Encode password
	 *
	 * @param $p string
	 *       	 plain text of the password
	 * @return string encoded text of the password
	 */
	protected function encPasswd($p) {
		return md5 ( $p );
	}
	public function isLoggedIn() {
		session_start ();
		return isset ( $_SESSION ['loginuser'] );
	}
	
	public function getCustomerDetails() {
		session_start ();
		$customerID = $_SESSION ['loginuser'] ['CustomerID'];
		$customer = new Customer ();
		$details = $customer->fetchAll ( "CustomerID=$customerID" )->toArray ();
		return $details [0];
	
	}
	
	public function updateCustomer($name, $telephone, $address, $password, $mobile) {
		// update details in database
		$customer = new Customer ();
		$set = array ('Name' => $name, 'TEL' => $telephone, 'Address' => $address, 'Password' => $this->encPasswd ( $password ), 'Mobile' => $mobile, 'Date_modified' => time () );
		$customerID = $_SESSION ['loginuser'] ['CustomerID'];
		
		$validation = new Validation ();
		$validation->setRules ( array ('require', 'require', 'require', 'require', null ) );
		$validation->_validate ( $set );
		$errors = $validation->getErrors ();
		if (! empty ( $errors )) {
			$this->view->info = "update Failed!";
			return false;
		}
		$escape = new StringSanitization ();
		$set = $escape->mysqlEscapeRecursively ( $set );
		
		$where = "CustomerID='$customerID'";
		$customer->update ( $set, $where );
		
		// update details in session
		$customerModel = new Customer ();
		$db = $customerModel->getAdapter ();
		$where = $db->quoteInto ( "CustomerID=?", $customerID ) . $db->quoteInto ( " AND Password=?", $this->encPasswd ( $password ) );
		
		$loginuser = $customerModel->fetchAll ( $where )->toArray ();
		if (! empty ( $loginuser )) {
			
			session_start ();
			$_SESSION ['loginuser'] = $loginuser [0];
			return true;
		} else {
			return false;
		}
	}
	
	public function logout() {
		session_start ();
		unset ( $_SESSION ['loginuser'] );
	}
	/**
	 * Login user.
	 *
	 *
	 * If successful save user to session storage.
	 * Password needs to be encoded first before comparing
	 * to encoded password in database.
	 *
	 *
	 * @param $email string       	
	 * @param $password string       	
	 * @return boolean
	 */
	public function login($email, $password) {
		
		$customerModel = new Customer ();
		$db = $customerModel->getAdapter ();
		$where = $db->quoteInto ( "Email=?", $email ) . $db->quoteInto ( " AND Password=?", $this->encPasswd ( $password ) );
		
		$loginuser = $customerModel->fetchAll ( $where )->toArray ();
		
		if (count ( $loginuser ) == 1) {
			session_start ();
			$_SESSION ['loginuser'] = $loginuser [0];
			return true;
		} else {
			return false;
		}
	}
	
	public function checkEmail($email) {
		$customerModel = new Customer ();
		$db = $customerModel->getAdapter ();
		$where = $db->quoteInto ( "Email=?", $email );
		$res = $customerModel->fetchAll ( $where )->toArray ();
		if (count ( $res ) > 0) {
			return true;
		}
		return false;
	}
	public function register($name, $email, $telephone, $mobile, $address, $password) {
		$data = array ('Email' => $email, 'TEL' => $telephone, 'Name' => $name, 'Address' => $address, 'Password' => $this->encPasswd ( $password ), 'Mobile' => $mobile, "Date_added" => time () );
		
		$validation = new Validation ();
		$validation->setRules ( array ('email', 'require', 'require', 'require', 'require', null ) );
		$validation->_validate ( $data );
		$errors = $validation->getErrors ();
		if (! empty ( $errors )) {
			return false;
		}
		
		$customerModel = new Customer ();
		$escape = new StringSanitization ();
		$data = $escape->mysqlEscapeRecursively ( $data );
		if ($customerModel->insert ( $data ) > 0) {
			return true;
		}
		return false;
	}

}