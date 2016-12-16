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
	
	
	public function save($id=0) {
			
				
				
				//if(file_exists($destination)) {
					$result=$this->db->query("UPDATE roo_cms set aboutus='".$this->aboutus."',privacy='".$this->privacy."',terms='".$this->terms."',howitworks='".$this->howitworks."',scrolling_content='".$this->scroll_text."' where id='1'");
					
					
					if($result) { 
						return true;
					} else {
						return false;
					}
				//}
				//return false;
			
		
		
	}
	
	public function getcms($id) {
		if($id > 0) {
			$qry = $this->db->query("SELECT * FROM roo_cms WHERE id='".$id."'");
			$row = $this->db->fetch_array($qry);
			
			$this->id = $id;
			$this->aboutus = $row['aboutus'];
			$this->privacy = $row['privacy'];
			$this->howitworks = $row['howitworks'];
			$this->terms = $row['terms'];
			$this->scroll_text=$row['scrolling_content'];
			
		}
		return false;
	}
	
	
}
?>