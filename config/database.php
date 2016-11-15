<?php

class database 
{
	private $connection = '';
	
	public function __construct() {
		$this->connection = mysqli_connect(HOST, USER, PASS, DATABASE);
	}
	
	public function query($sql) {
		return mysqli_query($this->connection,$sql);
	}
	
	public function num_rows($result) {
		return mysqli_num_rows($result);
	}
	
	public function fetch_array($result) {
		return mysqli_fetch_array($result,MYSQLI_ASSOC);
	}
	
	public function escape_string($string) {
		return mysqli_real_escape_string($this->connection, $string);
	}
	
	public function fetch_field($table, $where, $select) {
		
		if($table != '' AND $where != '' AND $select != '') { 
			
			$qry = mysqli_query($this->connection, "SELECT $select FROM $table WHERE $where");
			$row = mysqli_fetch_array($qry);
			return $row[0];
			
		} else {
			return "";
		}
	}
	
	public function close() {
		return mysqli_close($this->connection);
	}
	
	public function error() {
		return mysqli_error($this->connection);
	}

	public function insert_id() {
		return mysqli_insert_id($this->connection);
	}
}

?>