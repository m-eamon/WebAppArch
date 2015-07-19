<?php
/**
 * @author eamon
 * test case class for StatisticsController
 **/

require_once "../Slim/Slim.php";
Slim\Slim::registerAutoloader ();

require_once '../simpletest/autorun.php';

require_once "../app/conf/config.inc.php";

class StatisticsControllerTests extends UnitTestCase {
	private $statisticsControllerOBJ;
	private $model;
	private $app;
	private $action;
	private $parameters;
	
	private $errorMessage = array (
				GENERAL_MESSAGE_LABEL => GENERAL_NOCONTENT_MESSAGE
	);
	
	public function setUp()  {
		require_once '../app/controllers/StatisticsController.php';
		require_once '../app/models/StatisticsModel.php';
		$app = new \Slim\Slim (); // slim run-time object
		$model = new StatisticsModel();

		$this->statisticsControllerOBJ = new StatisticsController($model, $action=null, $app, $parameters=null);
	}
	
	public function tearDown() {
		$this->statisticsControllerlOBJ = null;
	}
	
	/**
	 * Test the studentStats function
	 */
	public function testStudentStats() {
		$this->statisticsControllerOBJ->studentStats();
		$this->assertNotEqual($this->errorMessage, $this->statisticsControllerOBJ->getApiResponse());
	}
	
	/**
	 * Test the studentStatsByNationality function
	 */
	public function testStudentStatsByNationality() {
		$this->statisticsControllerOBJ->studentStatsByNationality("ireland");
		$this->assertNotEqual($this->errorMessage, $this->statisticsControllerOBJ->getApiResponse());
		$this->statisticsControllerOBJ->studentStatsByNationality("china");
		$this->assertNotEqual($this->errorMessage, $this->statisticsControllerOBJ->getApiResponse());
		$this->statisticsControllerOBJ->studentStatsByNationality("country");
		$this->assertEqual($this->errorMessage, $this->statisticsControllerOBJ->getApiResponse());
		$this->statisticsControllerOBJ->studentStatsByNationality(1);
		$this->assertEqual($this->errorMessage, $this->statisticsControllerOBJ->getApiResponse());
	}
	
	/**
	 * Test the taskStats function
	 */
	public function testTaskStats() {
		$this->statisticsControllerOBJ->taskStats();
		$this->assertNotEqual($this->errorMessage, $this->statisticsControllerOBJ->getApiResponse());
	}
	
	/**
	 * Test the questStats function
	 */
	public function testQuestStats() {
		$this->statisticsControllerOBJ->questStats();
		$this->assertNotEqual($this->errorMessage, $this->statisticsControllerOBJ->getApiResponse());
	}
	
	/**
	 * Test the questStatsByTaskID function
	 */
	public function testQuestStatsByTaskID() {
		$this->statisticsControllerOBJ->questStatsByTaskID(1);
		$this->assertNotEqual($this->errorMessage, $this->statisticsControllerOBJ->getApiResponse());
		$this->statisticsControllerOBJ->questStatsByTaskID("a");
		$this->assertEqual($this->errorMessage, $this->statisticsControllerOBJ->getApiResponse());
		$this->statisticsControllerOBJ->questStatsByTaskID(0);
		$this->assertEqual($this->errorMessage, $this->statisticsControllerOBJ->getApiResponse());
	}
	
			
}
?>