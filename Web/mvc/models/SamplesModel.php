<?php
require_once( "db/DB.php" );
require_once( "db/QueryBuilder.php" );

class SamplesModel {
	private $query_builder;

	private $samples;

	public
	function __construct() {
		$db = db::connection();

		$this->queryBuilder = new QueryBuilder( $db );

		$this->samples = array();
	}

	public
	function getSamples( $date = null, $where = null, $order = null, $limit = null, $offset = null ) {

		if ( $date == null ) {
			$date = date( 'Y-m-d' );
		}

		$dateOut = $date . ' 23:59:59';

		$where = 'timestamp BETWEEN "' . $date . '" AND "' . $dateOut . '" ' . ( $where != null ? 'AND ' . $where : null );

		return $this->queryBuilder->select( "*" )->from( "samples" )->where( $where )->orderBy( $order )->limit( $limit )->offset( $offset )->get()->resultArray();
	}

	public
	function getCountSamples( $where = null ) {
		return $this->queryBuilder->select( "count(id) as total_samples" )->from( "samples" )->where( $where )->get()->rowArray();
	}

	public
	function getMaxAndMin( $date = null, $where = null ) {

		if ( $date == null ) {
			$date = date( 'Y-m-d' );
		}

		$dateOut = $date . ' 23:59:59';

		$where = 'timestamp BETWEEN "' . $date . '" AND "' . $dateOut . '" ' . ( $where != null ? 'AND ' . $where : null );

		$fields = array( 't1', 't2', 'h', 'p' );
		$results = array();

		foreach ( $fields as $field ) {

			$result[ 'max' ] = $this->queryBuilder->select( 'MAX(' . $field . ') as max' . ucwords( $field ) )->from( "samples" )->where( $where )->get()->rowArray();

			$result[ 'max' ] = $result[ 'max' ][ 'max' . ucwords( $field ) ];

			$result[ 'min' ] = $this->queryBuilder->select( 'MIN(' . $field . ') as min' . ucwords( $field ) )->from( "samples" )->where( $where )->get()->rowArray();

			$result[ 'min' ] = $result[ 'min' ][ 'min' . ucwords( $field ) ];
			
			$results[$field] = $result;
		}
		
		return $results;
	}
}