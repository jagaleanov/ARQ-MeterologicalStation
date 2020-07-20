<?php
class Sample
{
	private $id;
	private $timestamp;
	private $t1;
	private $t2;
	private $h;
	private $p;
	
	public function __construct() {
		
	}
	
	public function get_id() {
		return $this->id;
	}
	
	public function get_timestamp() {
		return $this->timestamp;
	}
	
	public function get_t1() {
		return $this->t1;
	}
	
	public function get_t2() {
		return $this->t2;
	}
	
	public function get_h() {
		return $this->h;
	}
	
	public function get_p() {
		return $this->p;
	}
	
	public function set_id($id) {
		$this->id = $id;
	}
	
	public function set_timestamp($timestamp) {
		$this->timestamp = $timestamp;
	}
	
	public function set_t1($t1) {
		$this->t1 = $t1;
	}
	
	public function set_t2($t2) {
		$this->t2 = $t2;
	}
	
	public function set_h($h) {
		$this->h = $h;
	}
	
	public function set_p($p) {
		$this->p = $p;
	}
}