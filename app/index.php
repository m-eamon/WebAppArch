<?php
require_once "../Slim/Slim.php";
Slim\Slim::registerAutoloader ();

$app = new \Slim\Slim (); // slim run-time object

require_once "conf/config.inc.php";

function authenticate (\Slim\Route $route) {

	$appInstance = \Slim\Slim::getInstance();
	
	$headers = $appInstance->request->headers;
	
	// extract username and password to send to controller
	$parameters["UserName"] = $headers["UserName"];
	$parameters["Password"] = $headers["Password"];
		
	$action = ACTION_AUTHENTICATE;
	
	// set up a new model, controller, and view to handle authentication
	include_once "models/AuthenticateModel.php";
	include_once "controllers/AuthenticateController.php";
	include_once "views/AuthenticateView.php";
	
	$model = new AuthenticateModel (); // authentication model
	$controller = new AuthenticateController( $model, $action, $appInstance, $parameters ); // authentication controller
	$view = new AuthenticateView ( $controller, $model, $appInstance); // authentication view - not used
	
	
	if ($model->authResponse == GENERAL_SUCCESS_MESSAGE) {
		return (true);
	}
	else 
		$appInstance->halt(401,GENERAL_FORBIDDEN);		
}


$app->map ( "/statistics/students(/:nationality)", "authenticate", function($nationality = null) use($app) {

	$parameters["nationality"] = $nationality;
	if ( $nationality != null && is_string( $nationality ) ) {
			$action = ACTION_STUDENT_STATS_NAT;
	}
	else 
		$action = ACTION_STUDENT_STATS;

	$headers = $app->request->headers;
	
	if ( $headers["Content-Type"] == "application/xml" ) {
		return new loadRunMVCComponents ( "StatisticsModel", "StatisticsController", "xmlView", $action, $app, $parameters);
	}
	// else return a json object
	else
		return new loadRunMVCComponents ( "StatisticsModel", "StatisticsController", "jsonView", $action, $app, $parameters);
} )->via ( "GET" );

$app->map ( "/statistics/tasks", "authenticate", function() use($app) {
	$headers = $app->request->headers;
	$action = ACTION_TASK_STATS;
	if ( $headers["Content-Type"] == "application/xml" ) {
		return new loadRunMVCComponents ( "StatisticsModel", "StatisticsController", "xmlView", $action, $app, $parameters=null);
	}
	// else return a json object
	else
		return new loadRunMVCComponents ( "StatisticsModel", "StatisticsController", "jsonView", $action, $app, $parameters=null);
} )->via ( "GET" );

$app->map ( "/statistics/questionnaires(/:taskID)", "authenticate", function($taskID = null) use($app) {
	
	$parameters["taskID"] = $taskID;
	if ( $taskID != null ) {
		$action = ACTION_QUESTIONNAIRE_STATS_TASKID;
	} 
	else
		$action = ACTION_QUESTIONNAIRE_STATS;
	
	$headers = $app->request->headers;
	if ( $headers["Content-Type"] == "application/xml" ) {
		return new loadRunMVCComponents ( "StatisticsModel", "StatisticsController", "xmlView", $action, $app, $parameters);
	}
	// else return a json object
	else
		return new loadRunMVCComponents ( "StatisticsModel", "StatisticsController", "jsonView", $action, $app, $parameters);
} )->via ( "GET" );


// set up common headers for every response
$app->response ()->header ( "Content-Type", "application/json; charset=utf-8" );
//$app->response ()->header ( "Content-Type", "application/xml; charset=utf-8" );

/*
 * enabling Cross-site HTTP requests (Cross-site requests are requests for resources from a different domain than the domain of the resource making the request)
 */
$app->response ()->header ( 'Access-Control-Allow-Origin', '*' );

/*
 * Specifies the method or methods allowed when accessing the resources.
 */
$app->response ()->header ( "Access-Control-Allow-Methods: GET" );

/*
 * Set a standard error message if the requested route does not exist. This will overwrite the SLIM standard message.
 */

$app->notFound ( function () use($app) {	
	echo GENERAL_INVALIDROUTE;
	$app->response ()->setStatus ( HTTPSTATUS_BADREQUEST);
	$Message = array (
			GENERAL_MESSAGE_LABEL => GENERAL_INVALIDROUTE 
	);
	$jsonResponse = json_encode ( $Message );
	$app->response->write ( $jsonResponse );
	
} );

$app->run ();

class loadRunMVCComponents {
	public $model, $controller, $view;
	public function __construct($modelName, $controllerName, $viewName, $action, $app, $parameters = null) {
		include_once "models/" . $modelName . ".php";
		include_once "controllers/" . $controllerName . ".php";
		include_once "views/" . $viewName . ".php";
		
		$model = new $modelName (); // common model
		$controller = new $controllerName ( $model, $action, $app, $parameters );
		$view = new $viewName ( $controller, $model, $app ); // common view
		$view->output (); // this returns the response to the requesting client
	}
}

?>