<?php
class bulkemail
{
	private $db;
	public $page = 1;
	public $start = 0;
	public $rowLimit = 10;
	
	public function __construct() {
		global $db;
		$this->db = $db;
		
		// For pagination
		$this->page = (isset($_REQUEST['page']) ? $_REQUEST['page'] : 1);
		if($this->page > 1) {
			$this->start = ($this->page - 1) * $this->rowLimit;
		}
	}
	
		public function getAllemailcategory($name) 
	{
		
		$field="";
		if($name!="")
		{
			$field.=' and (o.category_name like '."'%$name%'".')';
		}
		//echo $datestr; exit;
		$result = array();
		
		$query = 'SELECT e.id, e.category_name, e.status FROM roo_email_category AS e WHERE e.status IN (0,1) '.$field.' order by e.category_name asc LIMIT '.$this->start.','.$this->rowLimit;
		
		$queryCount = 'SELECT COUNT(e.id) AS cnt FROM roo_email_category AS e WHERE e.status IN (0,1)'.$field; 
		
		//echo $query; 
		$qry = $this->db->query($query);
		if($this->db->num_rows($qry) > 0) {
			while($row = $this->db->fetch_array($qry)) {
				$result[] = $row;
			}
		}
		
		// pagination code
		$qryCount = $this->db->query($queryCount);
		$rowCount = $this->db->fetch_array($qryCount);
		
		$totalPage = getTotalPage($rowCount['cnt'],$this->rowLimit);
		$pagination = pagination("emailcategory.php", "operator=$name", $this->page, $totalPage, 6);
		return array($result, $pagination);
	}

	
		public function getAllorders($date) 
	{
		
		$field="";
		
		$datef=date("Y-m-d",strtotime($date));
		
		if($date!="")
		{
			$field.=' and (date_added like '."'%$datef%'".')';
		}
		//echo $datestr; exit;
		$result = array();
		
		$query = 'SELECT * FROM roo_recharge WHERE status IN (0,1) '.$field.' order by date_added desc LIMIT '.$this->start.','.$this->rowLimit;
		
		$queryCount = 'SELECT COUNT(id) AS cnt FROM roo_recharge WHERE status IN (0,1)'.$field; 
		
		//echo $query; 
		$qry = $this->db->query($query);
		if($this->db->num_rows($qry) > 0) {
			while($row = $this->db->fetch_array($qry)) {
				$result[] = $row;
			}
		}
		
		// pagination code
		$qryCount = $this->db->query($queryCount);
		$rowCount = $this->db->fetch_array($qryCount);
		
		$totalPage = getTotalPage($rowCount['cnt'],$this->rowLimit);
		$pagination = pagination("recharge_orders.php", "Order=$date", $this->page, $totalPage, 6);
		return array($result, $pagination);
	}

	
	
		public function getAllemailtemplate($name) 
	{
		
		$field="";
		if($name!="")
		{
			$field.=' and (template_name like '."'%$name%'".')';
		}
		//echo $datestr; exit;
		$result = array();
		
		$query = 'SELECT * FROM roo_email_template WHERE status IN (0,1) '.$field.' order by template_name asc LIMIT '.$this->start.','.$this->rowLimit;
		
		$queryCount = 'SELECT COUNT(id) AS cnt FROM roo_email_template WHERE status IN (0,1)'.$field; 
		
		//echo $query; 
		$qry = $this->db->query($query);
		if($this->db->num_rows($qry) > 0) {
			while($row = $this->db->fetch_array($qry)) {
				$result[] = $row;
			}
		}
		
		// pagination code
		$qryCount = $this->db->query($queryCount);
		$rowCount = $this->db->fetch_array($qryCount);
		
		$totalPage = getTotalPage($rowCount['cnt'],$this->rowLimit);
		$pagination = pagination("templates.php", "template=$name", $this->page, $totalPage, 6);
		return array($result, $pagination);
	}

	
	public function Activatetemplate($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_email_template SET status=0 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	
	public function Deactivatetemplate($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_email_template SET status=1 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}

	
	public function Deletetemplate($id=0) {
		if($id > 0) {
			$this->db->query("Delete from roo_email_template WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
		public function templatesave() {
		    
			$name=$this->db->escape_string($this->name);
			$content=$this->db->escape_string($this->content);
		
			//echo $country; exit;
			$sql="INSERT INTO roo_email_template(template_name,template_content,date_added,status) values('".$name."','".$content."','".DATETIME24H."','0')";
			//echo $sql; exit;
			$result=$this->db->query($sql);
		if($result)	
		{
			return true;
		}
		return false;
	}
	public function templateupdate() {
		    $id=$this->id;
			$name=$this->db->escape_string($this->name);
			$content=$this->db->escape_string($this->content);
		
			//echo $country; exit;
			$sql="UPDATE roo_email_template set template_name='".$name."',template_content='".$content."' where id='".$id."'";
			//echo $sql; exit;
			$result=$this->db->query($sql);
		if($result)	
		{
			return true;
		}
		return false;
	}
	
	public function templateedit($id) {
		    
			
			//echo $country; exit;
			$sql="SELECT * FROM roo_email_template where id='$id'";
			//echo $sql; exit;
			$result=$this->db->query($sql);
			$row=$this->db->fetch_array($result);
			
			
		if($result)	
		{
			return $row;
		}
		return false;
	}
	
	
	public function Activateorder($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_recharge SET status=0 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	
	public function Deactivateorder($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_recharge SET status=1 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}

	
	public function Deleteorder($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_recharge SET status=2 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	


public function Activatecategory($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_email_category SET status=0 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	
	public function Deactivatecategory($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_email_category SET status=1 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}

	
	public function Deletecategory($id=0) {
		if($id > 0) {
			$this->db->query("Delete from roo_email_category WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	

	public function categorysave() {
		    
			$name=$this->categoryname;
		
			//echo $country; exit;
			$sql="INSERT INTO roo_email_category(category_name,status) values('$name','0')";
			//echo $sql; exit;
			$result=$this->db->query($sql);
		if($result)	
		{
			return true;
		}
		return false;
	}
	
	
}
?>