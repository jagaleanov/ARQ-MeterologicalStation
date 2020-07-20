<?php
class DB {
	public static function connection() {
		//connection = new mysqli( "localhost", "root", "", "sensores" );
		$connection = new mysqli("mysql-arduino.jk75.com", "arduino19", "A123456.", "arduino");

		if ( $connection->connect_error ) {
			die( 'Error de Conexión (' . $connection->connect_errno . ') '
				. $connection->connect_error );
		}

		$connection->query( "SET NAMES 'utf8'" );
		return $connection;
	}
}