<?php
class xmlView
{
	private $model, $controller, $slimApp;

	public function __construct($controller, $model, $slimApp) {
		$this->controller = $controller;
		$this->model = $model;
		$this->slimApp = $slimApp;		
	}

	public function output(){
		//prepare xml response 
		$xmlResponse = "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"no\" ?>";
		$xmlResponse .= "<Results>";
		foreach($this->model->apiResponse as $key => $value)
		{
			$xmlResponse .= "<" . $key . ">"  
				 . $value . "</" . $key . ">";
		}
		$xmlResponse .= "</Results>";
		
		$this->slimApp->response->write($xmlResponse);
	}
}
?>