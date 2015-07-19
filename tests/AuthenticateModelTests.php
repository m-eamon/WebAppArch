<?php
/**
 * @author eamon
 * test case class for AuthenticateModel
 **/


require_once '../simpletest/autorun.php';

class AuthenticateModelTests extends UnitTestCase {
	private $authenticateModelOBJ;
	
	public function setUp()  {
		require_once '../app/models/AuthenticateModel.php';
		$this->authenticateModelOBJ = new AuthenticateModel();
	}
	
	public function tearDown() {
		$this->authenticateModelOBJ = null;
	}
	
	/**
	 * Test the authenticate function
	 */
	public function testAuthenticate() {
		$this->assertFalse($this->authenticateModelOBJ->authenticate("a", 1));
		$this->assertFalse($this->authenticateModelOBJ->authenticate(1, "a"));
		$this->assertFalse($this->authenticateModelOBJ->authenticate(1, 1));
		
		require_once "../app/conf/config.inc.php";
		$this->assertTrue($this->authenticateModelOBJ->authenticate(CONST_USER, CONST_PASS));
	}
		
		
}
?>