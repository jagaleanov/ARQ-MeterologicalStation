<?php
require_once( "mvc/controllers/MainController.php" );
require_once( "mvc/models/SamplesModel.php" );


class SamplesController extends MainController {
	
	private $data = array();

	public
	function __construct() {
		
		//Cargamos el modelo
		$this->model = new SamplesModel();
		
		//asignamos la vista
		$this->view = 'samples.php';
		
		//creamos un arreglo para pasarle datos al la vista
		$this->data = array();
		
		//instanciamos la fecha a buscar por defecto (la actual)
		$this->data['date'] = date('Y-m-d');
		
		//si existe fecha en la sesión sobreescribimos la fecha
		if(isset($_SESSION['date'])) {
			$this->data['date'] = $_SESSION['date'];
		}
		
		//Si existe la variable submit en el POST
		if(isset($_POST['submit'])) {
			//print '<pre>';print_r($_POST);print '</pre>';
			
			//sobreescribimos la fecha y la guardamos en la sesion
			$this->data['date'] = $_POST['date'];
			$_SESSION['date'] = $_POST['date'];
		}
		
		//le pedimos al modelo que consiga los datos y los recogemos en el arreglo data
		$this->data[ 'counter' ] = $this->model->getCountSamples($this->data['date']);
		
		$this->data[ 'maxAndMin' ] = $this->model->getMaxAndMin($this->data['date'], $where = null);
		
		$this->data[ 'samples' ] = $this->model->getSamples($this->data['date'], $where = null, $order = 'id DESC');
		
		//print '<pre>';print_r($this->data);print '</pre>';
		
		$this->setView();
	}

	public
	function setView() {
		
		//le pedimos al modelo que llame los datos para la grafica
		$samplesGr = $this->model->getSamples($this->data['date']);

		$timestamps = array();
		$t1 = array();
		$t2 = array();
		$h = array();
		$p = array();

		//organizamos los datos en arreglos separados para las graficas
		foreach ( $samplesGr as $pos => $row ) {
			
			$row['timestamp'] = '"' . date( 'g:i a', strtotime( $row[ 'timestamp' ] ) ) . '"';
			
			$timestamps[] = $row['timestamp'];
			$t1[] = $row['t1'];
			$t2[] = $row['t2'];
			$h[] = $row['h'];
			$p[] = $row['p'];
		}
		
		//convertimos los arreglos en strings separados por coma y recogemos los datos en el arreglo data
		$this->data[ 'timestamps' ] = implode( ",",  $timestamps ) ;
		$this->data[ 't1' ] = implode( ",",  $t1 ) ;
		$this->data[ 't2' ] = implode( ",",  $t2 ) ;
		$this->data[ 'h' ] = implode( ",",  $h ) ;
		$this->data[ 'p' ] = implode( ",",  $p ) ;

		//Llamamos a la vista y le pasamos el arreglo data
		$this->makeView($this->data);
	}
}