<?php
class AuthenticateController {
	private $slimApp;
	private $model;
	public function __construct($model, $action, $app, $parameters) {
		$this->model = $model;
		$this->slimApp = $app;
		
		$userName = $parameters ["UserName"];
		$password = $parameters ["Password"];
		
		if ( $userName != null && $password != null ) {
			switch ($action) {
				case ACTION_AUTHENTICATE :
					$this->authenticate($userName, $password);
					break;
				case null :
					$this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
					$Message = array (
							GENERAL_MESSAGE_LABEL => GENERAL_CLIENT_ERROR
					);
					$this->model->authResponse = $Message;
					break;
			}
		}	
		else {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_UNAUTHORIZED );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_FORBIDDEN
			);
			$this->model->authReponse = $Message;
		}	
	}
	
	private function authenticate($userName, $password) {
		// validate that userName and password are strings
		$answer = $this->model->authenticate ($userName, $password);
		if ($answer == true) {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
			$this->model->authResponse = GENERAL_SUCCESS_MESSAGE;
		} else {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_UNAUTHORIZED );				
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_FORBIDDEN
			);
			$this->model->authResponse = $Message;
		}
	}
	
}
?>