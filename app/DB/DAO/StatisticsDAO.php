<?php
/**
 * @author Eamon
 * definition of the Statistics DAO (database access object)
 */
class StatisticsDAO {
	private $dbManager;
	function StatisticsDAO($DBMngr) {
		$this->dbManager = $DBMngr;
	}
	
	public function studentStats() {
		$sql = "SELECT students.age ";
		$sql .= "FROM " . DB_NAME .  " .students ";
	    $sql .= "ORDER BY students.student_number ";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
		
		return ($rows);
		
	}
	
	public function studentStatsByNationality($nationality) {
		$sql = "SELECT s.age ";
		$sql .= "FROM " . DB_NAME .  " .students s, " . DB_NAME . " .nationalities n ";
		$sql .= "WHERE s.id_nationality = n.id ";
		$sql .= "AND n.description = ? ";		
		$sql .= "ORDER BY s.student_number ";
	
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $nationality, $this->dbManager->STRING_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
	
		return ($rows);
		
	}
	
	public function taskStats() {
		$sql = "SELECT duration_mins ";
		$sql .= "FROM " . DB_NAME .  " .tasks ";
		$sql .= "ORDER BY task_id ";
	
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
	
		return ($rows);
	}
	
	public function questCount() {
		$sql = "SELECT student_number ";
		$sql .= "FROM " . DB_NAME .  " .questionnaire ";
		$sql .= "ORDER BY id ";
	
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
	
		return ($rows);
	}
	
	public function questMWL_total() {
		$sql = "SELECT MWL_total ";
		$sql .= "FROM " . DB_NAME .  " .questionnaire ";
		$sql .= "ORDER BY id ";
	
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
	
		return ($rows);
	}
	
	public function questRSME() {
		$sql = "SELECT RSME ";
		$sql .= "FROM " . DB_NAME .  " .questionnaire ";
		$sql .= "ORDER BY id ";
	
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
	
		return ($rows);
	}
	
	public function questMWL_total_ID( $taskID ) {
		$sql = "SELECT MWL_total ";
		$sql .= "FROM " . DB_NAME .  " .questionnaire ";
		$sql .= "WHERE task_number = ? ";
		$sql .= "ORDER BY id ";
	
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $taskID, $this->dbManager->INT_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
	
		return ($rows);
	}
	
	public function questRSME_ID( $taskID ) {
		$sql = "SELECT RSME ";
		$sql .= "FROM " . DB_NAME .  " .questionnaire ";
		$sql .= "WHERE task_number = ? ";
		$sql .= "ORDER BY id ";
	
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $taskID, $this->dbManager->INT_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
	
		return ($rows);
	}

	public function questIntru_ID( $taskID ) {
		$sql = "SELECT intrusiveness ";
		$sql .= "FROM " . DB_NAME .  " .questionnaire ";
		$sql .= "WHERE task_number = ? ";
		$sql .= "ORDER BY id ";
	
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $taskID, $this->dbManager->INT_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
	
		return ($rows);
	}
	
}
?>
