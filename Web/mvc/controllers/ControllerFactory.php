<?php

class ControllerFactory {
	public function __construct( $controller = NULL ) {
		if( isset($controller) && $controller == 'addData') {
			require_once("mvc/controllers/ReceiverController.php");
			return new ReceiverController();
		}
		else {
			require_once("mvc/controllers/SamplesController.php");
			return new SamplesController();
		}
	}
}