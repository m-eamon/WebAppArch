<?php
class AuthenticateView
{
	private $model, $controller, $slimApp;

	public function __construct($controller, $model, $app) {
		$this->controller = $controller;
		$this->model = $model;	
		$this->slimApp = $app;	
	}

	public function output(){
		//prepare json response
		$jsonResponse = json_encode($this->model->authResponse);
		$this->slimApp->response->write($jsonResponse);
	}
}
?>