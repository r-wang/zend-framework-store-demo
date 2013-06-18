<?php
/**
 * This class encapsulates string validation logics
 * 
 */
class Validation {
	// array to store validaton rules
	protected $_valid = array ();
	
	// array to store errors out of validation
	protected $error = array ();
	
	/**
	 * Sets validation rules.
	 *
	 * @param $rules Array       	
	 */
	public function setRules($rules) {
		$this->_valid = $rules;
	}
	
	public function getErrors() {
		return $this->error;
	}
	
	/**
	 * Validates an array of values against an array of rules and
	 * save validation results in an array.
	 *
	 * @param $data string       	
	 * @param $rules string       	
	 */
	public function _validate($data, $rules) {
		for($i = 0; $i < count ( $data ); $i ++) {
			if ($this->check ( $data [$i], $rules [$i] )) {
				$this->error [] = $rules [$i];
			}
		}
	}
	
	/**
	 *
	 * @param $value string
	 *       	 value to be validated
	 * @param $rule string
	 *       	 rule against which value is to be validated
	 *       	
	 * @return boolean true represents that errors exist and false represents
	 *         that
	 *         no error exists
	 */
	protected function check($value, $rule) {
		switch ($rule) {
			case "require" :
				return ! empty ( $value );
				break;
			case "email" :
				return ! $this->isEmail ( $value );
				break;
		}
		return false;
	}
	
	/**
	 * Checks if a string is a valid email address
	 *
	 * @param $value string       	
	 * @return boolean
	 */
	protected function isEmail($value) {
		return preg_match ( "/^[a-zA-Z0-9_]+@[a-zA-Z]+(.[a-zA-Z]+)+$/i", $value );
	}
}

?>