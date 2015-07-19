<?php
//require_once "DB/pdoDbManager.php";
//require_once "DB/DAO/StatisticsDAO.php";
//require_once "models/Validation.php";
require_once "../app/DB/pdoDbManager.php";
require_once "../app/DB/DAO/StatisticsDAO.php";
require_once "../app/models/Validation.php";

class StatisticsModel {
	private $StatisticsDAO; // list of DAOs used by this model
	private $dbmanager; // dbmanager
	public $apiResponse; // api response
	private $validationSuite; // contains functions for validating inputs
	public function __construct() {
		$this->dbmanager = new pdoDbManager ();
		$this->StatisticsDAO = new StatisticsDAO ( $this->dbmanager );
		$this->dbmanager->openConnection ();
		$this->validationSuite = new Validation ();
	}
	
	public function studentStats( ) {
		return ($this->StatisticsDAO->studentStats ());
	}

	/**
	 * TODO create a test for this models and validate
	 * studentStatsByNationality ($nationality )
	 */
	
	public function studentStatsByNationality ($nationality ) {
		if ( is_string( $nationality ) && $this->validationSuite->isLengthStringValid( $nationality, TABLE_MAX_NATIONALITY_DESC_LENGTH ) ) 
			return ($this->StatisticsDAO->studentStatsByNationality( $nationality ));
		
		return false; 	
	}
	
	public function taskStats( ) {
		return ($this->StatisticsDAO->taskStats ());
	}
	
	
	public function questCount() {
		return ($this->StatisticsDAO->questCount());
	}
	
	public function questMWL_total() {
		return ($this->StatisticsDAO->questMWL_total());
	}
	
	public function questRSME() {
		return ($this->StatisticsDAO->questRSME());
	}
	
	public function questMWL_total_ID ( $taskID ) {
		if ( is_numeric( $taskID ) ) {
			return ( $this->StatisticsDAO->questMWL_total_ID($taskID) );
		}
		return false;
	}
	
	public function questRSME_ID( $taskID ) {
		if ( is_numeric( $taskID ) ) {
			return ($this->StatisticsDAO->questRSME( $taskID ) );
		}
		return false;
	}
	
	public function questIntru_ID ( $taskID ) {
		if ( is_numeric ( $taskID ) ) {
			return ( $this->StatisticsDAO->questIntru_ID( $taskID ));
		}
		return false;
	}
	
	public function __destruct() {
		$this->StatisticsDAO = null;
		$this->dbmanager->closeConnection ();
	}
}
?>