<?php
class StatisticsController {
	private $slimApp;
	private $model;
	private $requestBody;
	private $statAnalysis;
	// TODO why is action=null here?
	public function __construct($model, $action = null, $slimApp, $parameters=null) {
		$this->model = $model;
		$this->slimApp = $slimApp;
		
		//require_once "tools/StatAnalysis.php";
		require_once "../app/tools/StatAnalysis.php";
		$this->statAnalysis = new StatAnalysis();
		
		if (! empty ( $parameters ["nationality"] ) )
			// TODO check that nationality is a string
			$nationality = $parameters ["nationality"];
		

		if (! empty ( $parameters ["taskID"] ) )
			$taskID = $parameters ["taskID"];
		
		
		switch ($action) {
			case ACTION_STUDENT_STATS :
				$this->studentStats ();
				break;
			case ACTION_STUDENT_STATS_NAT :
				$this->studentStatsByNationality ( $nationality );
				break;
			case ACTION_TASK_STATS :
				$this->taskStats ( );
				break;
			case ACTION_QUESTIONNAIRE_STATS :
				$this->questStats ( );
				break;
			case ACTION_QUESTIONNAIRE_STATS_TASKID :
				$this->questStatsByTaskID ( $taskID );
				break;				
			case null :
				$this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
				$Message = array (
						GENERAL_MESSAGE_LABEL => GENERAL_CLIENT_ERROR 
				);
				$this->model->apiResponse = $Message;
				break;
		}
	}
	
	/**
	 * Get average and standard deviation of student ages
	 *
	 */
	public function studentStats() {
		$answer = $this->model->studentStats ();
		if ($answer != null) {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
			$arrResult = $this->statAnalysis->toIntArray( $answer );
			$this->generateApiRepsonse(1, $arrResult, $arg3=null, $arg4=null);
		} else 
			$this->setNoContentMsg();		
	}
	
	
	/**
	 * Get average and standard deviation of student ages
	 * based on a given nationality
	 * @param string
	 */
	public function studentStatsByNationality( $nationality ) {
		$answer = $this->model->studentStatsByNationality ( $nationality );
		if ($answer != null) {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
			$arrResult = $this->statAnalysis->toIntArray( $answer );					
			$this->generateApiRepsonse(1, $arrResult, $arg3=null, $arg4=null);
		} else 
			$this->setNoContentMsg();
	}
	
	/**
	 * Get number of tasks, standard deviation 
	 * of the duration of tasks, and the 
	 * average duration of tasks.
	 */
	public function taskStats() {
		$answer = $this->model->taskStats ();
		if ($answer != null) {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
			$arrResult = $this->statAnalysis->toIntArray( $answer );
			$this->generateApiRepsonse(2, $arrResult, $arg3=null, $arg4=null);
		} else 
			$this->setNoContentMsg();
	}
	
	/**
	 * Get the amount of questionnaires filled,  the standard 
	 * deviation of the MWL_total, the average of the MWL_total,
	 * and the standard deviation and average of the RSME.
	 */
	public function questStats() {
		$answer1 = $this->model->questCount();
		$answer2 = $this->model->questMWL_total();
		$answer3 = $this->model->questRSME();		
		if ( ( $answer1 != null ) || ( $answer2 == null) 
		|| ( $answer3 == null) ) {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
			//TODO loop?
			$arrResult1 = $this->statAnalysis->toIntArray( $answer1 );
			$arrResult2 = $this->statAnalysis->toIntArray( $answer2 );
			$arrResult3 = $this->statAnalysis->toIntArray( $answer3 );
			$this->generateApiRepsonse(3, $arrResult1, $arrResult2, $arrResult3);
		} else 
			$this->setNoContentMsg();
	}
	
	/**
	 * For a given taskID, get the standard deviation of the MWL_total, 
	 * the average of the MWL_total, the standard deviation of RSME, 
	 * the average of the RSME, the standard deviation of 
	 * the intrusiveness, and the average of the intrusiveness.
	 * @param int
	 */
	public function questStatsByTaskID( $taskID ) {
		if ( is_numeric( $taskID ) && ( $taskID > 0 ) ) {
			$answer1 = $this->model->questMWL_total_ID( $taskID );
			$answer2 = $this->model->questRSME_ID( $taskID );
			$answer3 = $this->model->questIntru_ID( $taskID );
			if ( ( $answer1 != null ) 
				|| ( $answer2 != null ) || ( $answer3 != null ) ) { 
				$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
				// for loop
				$arrResult1 = $this->statAnalysis->toIntArray( $answer1 );
				$arrResult2 = $this->statAnalysis->toIntArray( $answer2 );
				$arrResult3 = $this->statAnalysis->toIntArray( $answer3 );
				$this->generateApiRepsonse(4, $arrResult1, $arrResult2, $arrResult3);
			} 
			else {
				$this->setNoContentMsg();
			}
		}
		else {
			$this->setNoContentMsg();
		}
	}
	
	/**
	 * Format output response
	 * @param array
	 */
	public function generateApiRepsonse($arg1, $arg2, $arg3, $arg4) {
		
		switch ($arg1) {
			case 1 :
				$this->model->apiResponse["Avg"] = $this->statAnalysis->calcAverage( $arg2 );
				$this->model->apiResponse["StdDev"] = $this->statAnalysis->calcStandardDeviation( $arg2 );		
				break;
			case 2 :
				$this->model->apiResponse["Num"] = count( $arg2 );
				$this->model->apiResponse["Avg"] = $this->statAnalysis->calcAverage( $arg2 );
				$this->model->apiResponse["StdDev"] = $this->statAnalysis->calcStandardDeviation( $arg2 );
				break;
			case 3 :
				$this->model->apiResponse["Num"] = count( $arg2 );
				$this->model->apiResponse["MWL Avg"] = $this->statAnalysis->calcAverage( $arg3 );
				$this->model->apiResponse["MWL StdDev"]= $this->statAnalysis->calcStandardDeviation( $arg3 );
				$this->model->apiReponse["RSME Avg"] = $this->statAnalysis->calcAverage( $arg4 );
				$this->model->apiReponse["RSME StdDev"] = $this->statAnalysis->calcStandardDeviation( $arg4 );
				break;
			case 4 :
				$this->model->apiResponse["MWL Avg"] = $this->statAnalysis->calcAverage( $arg2 );
				$this->model->apiResponse["MWL StdDev"]= $this->statAnalysis->calcStandardDeviation( $arg2 );
				$this->model->apiResponse["RSME Avg"] = $this->statAnalysis->calcAverage( $arg3 );
				$this->model->apiResponse["RSME StdDev"] = $this->statAnalysis->calcStandardDeviation( $arg3 );
				$this->model->apiResponse["Int Avg"] = $this->statAnalysis->calcAverage( $arg4 );
				$this->model->apiResponse["Int StdDev"] = $this->statAnalysis->calcStandardDeviation( $arg4 );
				break;
			default: 
				$this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
				$Message = array (
						GENERAL_MESSAGE_LABEL => GENERAL_CLIENT_ERROR
				);
				$this->model->apiResponse = $Message;
				break;
		}	
	}
	
	/**
	 * Set the No-Content error message
	 */
	public function setNoContentMsg() {
		$this->slimApp->response ()->setStatus ( HTTPSTATUS_NOCONTENT );
		$Message = array (
				GENERAL_MESSAGE_LABEL => GENERAL_NOCONTENT_MESSAGE
		);
		$this->model->apiResponse = $Message;
	}
	
	/**
	 * Get the apiResponse for testing
	 */
	public function getApiResponse() {
		return $this->model->apiResponse;
	}
	
}
?>