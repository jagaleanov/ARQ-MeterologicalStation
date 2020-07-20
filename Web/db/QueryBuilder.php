<?php
class QueryBuilder {

	private $db;
	private $query;
	private $result;
	private $samples;

	private $select;
	private $table;
	private $where;
	private $limit;
	private $offset;
	private $orderBy;
	
	private $insert_id;

	public
	function __construct( $db ) {

		$this->db = $db;;
		$this->query = null;
		$this->result = null;
		$this->samples = array();

		$this->select = null;
		$this->table = null;
		$this->where = null;
		$this->limit = null;
		$this->offset = null;
		$this->order_by = null;
		
		$this->data = array();
	}

	public
	function select( $select ) {
		$this->select = ( string )$select;
		return $this;
	}

	public
	function from( $table ) {
		$this->table = ( string )$table;
		return $this;
	}

	public
	function where( $where ) {
		$this->where = ( string )$where;
		return $this;
	}

	public
	function limit( $limit ) {
		$this->limit = ( int )$limit;
		return $this;
	}

	public
	function offset( $offset ) {
		$this->offset = ( int )$offset;
		return $this;
	}

	public
	function orderBy( $orderBy ) {
		$this->orderBy = ( string )$orderBy;
		return $this;
	}

	public
	function data( $data ) {
		$this->data = ( array )$data;
		return $this;
	}

	public
	function get() {

		$selectFields = explode( ',', $this->select );

		if ( $this->select == null ) {
			return 'No existe select en la consulta';
		}

		if ( $this->table == null ) {
			return 'No existe tabla en la consulta';
		}
		
		$this->query = 'SELECT ' . $this->select;

		$this->query .= ' FROM ' . $this->table;

		if ( $this->where != null ) {
			$this->query .= ' WHERE ' . $this->where;
		}

		if ( $this->orderBy != null ) {
			$this->query .= ' ORDER BY ' . $this->orderBy;
		}

		if ( $this->limit != null ) {
			$this->query .= ' LIMIT ' . $this->limit;
		}

		if ( $this->offset != null ) {
			$this->query .= ' OFFSET ' . $this->offset;
		}
		
		$this->query = $this->query . ';';

		$this->result = $this->db->query( $this->query ) or trigger_error($this->query.' <br><br> '.$this->db->error);

		return $this;
	}

	public
	function resultArray() {
		$resultArray = array();
		
        while($rowArray = $this->result->fetch_array(MYSQLI_ASSOC)){
            $resultArray[]=$rowArray;
        }
		
		return $resultArray;
	}

	public
	function rowArray() {
		$rowArray = $this->result->fetch_array(MYSQLI_ASSOC);
		
		return $rowArray;
	}

	public
	function insert( $table , $data) {
		
		$this->table = ( string ) '`'.$table.'`';
		
		$string_fields = array();
		$string_values = array();
		
		if(is_array($data) && count($data)>0) 
		{
			foreach($data as $field => $value)
			{
				$string_fields[] .= '`'.$field.'`';
				$string_values[] .= '"'.$value.'"';
			}
			
			$string_fields = implode(',',$string_fields);
			$string_values = implode(',',$string_values);
		}
		
		$this->query = 'INSERT INTO '.$this->table.' ('.$string_fields.') VALUES ('.$string_values.');';

		$this->db->query( $this->query ) or trigger_error($this->query.' <br><br> '.$this->db->error);
		
		$this->set_insert_id();
	}

	public
	function set_insert_id() {
		$this->insert_id = $this->db->insert_id;;
	}

	public
	function get_insert_id() {
		
		return $this->insert_id;
	}


}