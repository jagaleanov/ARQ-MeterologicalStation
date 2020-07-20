<?php
require_once( "mvc/controllers/MainController.php" );
require_once( "mvc/models/ReceiverModel.php" );


class ReceiverController extends MainController {

	public
	function __construct() {
		
		//Cargamos el modelo
		$this->model = new ReceiverModel();
		
		//Preparamos los datos
		$data = array(
			'h' => $_GET["h"],
			't1' => $_GET["t"],
			't2' => $_GET["t2"],
			'p' => $_GET["p"]
		);
		
		//Guardamos los datos
		$sampleId = $this->model->insertSample($data);
		
		//Imprimimos una respuesta para que la reciba el arduino
		print '<pre>';print_r($_GET);print '</pre>';
		print '<pre>';print_r($sampleId);print '</pre>';
		
	}
}