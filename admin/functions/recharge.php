<?php
class recharge
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
	
	
	public function getusername($id) {
		//$result = array();
		if($id > 0) {
			$qry = $this->db->query("SELECT firstname FROM roo_users WHERE id = '".$id."'");
			$row = $this->db->fetch_array($qry);
		}
		return $row['firstname'];
	}
	
	
	public function getoperatorname($name) {
		//$result = array();
		if($name !="") {
			$qry = $this->db->query("SELECT operator_name FROM roo_mobile_operator WHERE operator_shortname = '".$name."'");
			$row = $this->db->fetch_array($qry);
		}
		return $row['operator_name'];
	}
	
	
		public function getAlloperator($name) 
	{
		
		$field="";
		if($name!="")
		{
			$field.=' and (o.operator_name like '."'%$name%'".')';
		}
		//echo $datestr; exit;
		$result = array();
		
		$query = 'SELECT o.id, o.operator_name, o.status, o.operator_shortname, o.operator_code FROM roo_mobile_operator AS o WHERE o.status IN (0,1) '.$field.' order by o.operator_name asc LIMIT '.$this->start.','.$this->rowLimit;
		
		$queryCount = 'SELECT COUNT(o.id) AS cnt FROM roo_mobile_operator AS o WHERE o.status IN (0,1)'.$field; 
		
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
		$pagination = pagination("operator_name.php", "operator=$name", $this->page, $totalPage, 6);
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

	
	
		public function getAllcircle($name) 
	{
		
		$field="";
		if($name!="")
		{
			$field.=' and (oc.circle_name like '."'%$name%'".')';
		}
		//echo $datestr; exit;
		$result = array();
		
		$query = 'SELECT oc.id, oc.circle_name, oc.status, oc.circle_code FROM roo_operator_circle AS oc WHERE oc.status IN (0,1) '.$field.' order by oc.circle_name asc LIMIT '.$this->start.','.$this->rowLimit;
		
		$queryCount = 'SELECT COUNT(oc.id) AS cnt FROM roo_operator_circle AS oc WHERE oc.status IN (0,1)'.$field; 
		
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
		$pagination = pagination("operator_circle.php", "circle=$name", $this->page, $totalPage, 6);
		return array($result, $pagination);
	}

	
	public function Activate($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_mobile_operator SET status=0 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	
	public function Deactivate($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_mobile_operator SET status=1 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}

	
	public function Deleteoperator($id=0) {
		if($id > 0) {
			$this->db->query("Delete from roo_mobile_operator WHERE id='".$id."' LIMIT 1");
			return true;
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
	

	public function operatorsave() {
		    
			$name=$this->name;
			$short=$this->short;
			$code=$this->code;
		
			//echo $country; exit;
			$sql="INSERT INTO roo_mobile_operator(operator_name,operator_shortname,operator_code,status) values('$name','$short','$code','0')";
			//echo $sql; exit;
			$result=$this->db->query($sql);
		if($result)	
		{
			return true;
		}
		return false;
	}
	
public function Activatecircle($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_operator_circle SET status=0 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	
	public function Deactivatecircle($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_operator_circle SET status=1 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}

	
	public function Deletecircle($id=0) {
		if($id > 0) {
			$this->db->query("Delete from roo_operator_circle WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	

	public function circlesave() {
		    
			$name=$this->circlename;
			$code=$this->circlecode;
		
			//echo $country; exit;
			$sql="INSERT INTO roo_operator_circle(circle_name,circle_code,status) values('$name','$code','0')";
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