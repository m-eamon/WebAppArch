<?php
require_once "../app/models/Validation.php";

class AuthenticateModel {
	public $authResponse; // api response
	private $validationSuite; // contains functions for validating inputs
	public function __construct() {
		$this->validationSuite = new Validation ();
	}
	
	public function authenticate($userName, $password) {
		if ( is_string( $userName) && is_string( $password ) ) {
			if ( ( $userName == CONST_USER ) && ( $password == CONST_PASS ) ) {
				return true;
			}
		}
		return false;
	}
	
	
	public function __destruct() {
		$this->validationSuite = null;	
	}
}
?>