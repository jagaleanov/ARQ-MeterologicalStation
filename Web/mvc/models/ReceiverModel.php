<?php
require_once( "db/DB.php" );
require_once( "db/QueryBuilder.php" );

class ReceiverModel {
	private $query_builder;

	public
	function __construct() {
		$db = db::connection();

		$this->queryBuilder = new QueryBuilder( $db );
	}

	public
	function insertSample( $data = array()) {
		
		$data['timestamp'] = date('Y-m-d H:i:s');
		
		$this->queryBuilder->insert( "samples" , $data);
		
		return $this->queryBuilder->get_insert_id();
	}
}