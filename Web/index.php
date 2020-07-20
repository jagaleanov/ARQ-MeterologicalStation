<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
date_default_timezone_set('America/Bogota');

require_once("mvc/controllers/ControllerFactory.php");

$controllerFactory = new ControllerFactory();
?>
