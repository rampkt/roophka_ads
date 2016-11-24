<?php
class cms
{
	private $db = '';
	public $file = array();
	public $id = '';
	
	public function __construct() {
		global $db;
		$this->db = $db;
		
	}
	
	
	
	
	public function getcms($id,$field) {
		if($id > 0) {
			$qry = $this->db->query("SELECT * FROM roo_cms WHERE id='".$id."'");
			$row = $this->db->fetch_array($qry);
			
			return $row[$field];
			
		}
		return false;
	}
	
	
}
?>