<?php
class cms
{
	private $db = '';
	public $file = array();
	public $id = '';
	
	public function __construct() {
		global $db;
		$this->db = $db;
		$this->country='88';
	}
	
	
	public function contactussave() {
		
			
			$result = $this->db->query("INSERT INTO roo_contactus (name,email,subject, message, ipaddr, date_added) VALUES ('".$this->name."','".$this->email."', '".$this->subject."','".$this->message."', '".$this->ipaddr."','".DATETIME24H."')");
			if($result) {
				
				return true;
			} else {
				
				return false;
			}
		
		return false;
	}
	
	
	public function advertisesave() {
		
			
			$result = $this->db->query("INSERT INTO roo_advertise_request (company_name,email,contact_person, mobile,address1,address2,country,state,city,pincode, ipaddr, date_added,status) VALUES ('".$this->companyname."','".$this->email."', '".$this->contact_person."','".$this->mobile."','".$this->address1."','".$this->address2."','".$this->country."','".$this->state."','".$this->city."','".$this->pincode."', '".$this->ipaddr."','".DATETIME24H."','0')");
			if($result) {
				
				return true;
			} else {
				
				return false;
			}
		
		return false;
	}
	
	
	public function getcms($id,$field) {
		if($id > 0) {
			$qry = $this->db->query("SELECT * FROM roo_cms WHERE id='".$id."'");
			$row = $this->db->fetch_array($qry);
			
			return $row[$field];
			
		}
		return false;
	}
	
	public function getsetting($id,$field) {
		if($id > 0) {
			$qry = $this->db->query("SELECT * FROM roo_settings WHERE id='".$id."'");
			$row = $this->db->fetch_array($qry);
			
			return $row[$field];
			
		}
		return false;
	}
	
}
?>