<?php

abstract class MainController {
	protected $model;
	protected $view;
	
	public function __construct() {
		
	}
	
	protected function makeView($data) {
		require_once( "mvc/views/".$this->view );
	}
}
