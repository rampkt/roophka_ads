<?php
class plans
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
	
		public function getAllplancategory($name) 
	{
		
		$field="";
		if($name!="")
		{
			$field.=' and (e.category_name like '."'%$name%'".')';
		}
		//echo $datestr; exit;
		$result = array();
		
		$query = 'SELECT e.id, e.category_name, e.status FROM roo_plancategory AS e WHERE e.status IN (0,1) '.$field.' order by e.category_name asc LIMIT '.$this->start.','.$this->rowLimit;
		
		$queryCount = 'SELECT COUNT(e.id) AS cnt FROM roo_plancategory AS e WHERE e.status IN (0,1)'.$field; 
		
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
		$pagination = pagination("plancategory.php", "category=$name", $this->page, $totalPage, 6);
		return array($result, $pagination);
	}

		public function getAllplans($cid) 
	{
		
		$field="";
		
		if($cid!="")
		{
			$field.=' and (e.catid= '.$cid.')';
		}
		//echo $datestr; exit;
		$result = array();
		
		$query = 'SELECT * FROM roo_plan_details AS e WHERE e.status IN (0,1) '.$field.' order by e.catid,e.amount asc LIMIT '.$this->start.','.$this->rowLimit;
		
		$queryCount = 'SELECT COUNT(e.id) AS cnt FROM roo_plan_details AS e WHERE e.status IN (0,1)'.$field; 
		
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
		$pagination = pagination("plandetails.php", "categorysearch=$cid", $this->page, $totalPage, 6);
		return array($result, $pagination);
	}
		
	public function Activateplan($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_plan_details SET status=0 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	
	public function Deactivateplan($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_plan_details SET status=1 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}

	
	public function Deleteplan($id=0) {
		if($id > 0) {
			$this->db->query("Delete from roo_plan_details WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	
		public function getallcategory($cid = 0) 
	{
		$result = "";
		
		$query = "SELECT * FROM roo_plancategory WHERE status='0' order by category_name asc";
		
		$queryCount = "SELECT COUNT(id) AS cnt FROM roo_plancategory WHERE status='0'"; 
		
		//echo $query; 
		$qry = $this->db->query($query);
		if($this->db->num_rows($qry) > 0) {
			while($row = $this->db->fetch_array($qry)) {
				if($cid !="" && $cid==$row['id']){
					$select="selected=selected";
				}else
				{
					$select="";
				}
				
				$result.="<option value='".$row['id']."' $select>".$row['category_name']."</option>";
			}
		}
		
		
		return $result;
	}
	
		public function categoryname($id) 
	{
		$result = "";
		
		$query = "SELECT * FROM roo_plancategory WHERE id='$id'";
		
		$queryCount = "SELECT COUNT(id) AS cnt FROM roo_plancategory WHERE id='$id'"; 
		
		//echo $query; 
		$qry = $this->db->query($query);
		if($this->db->num_rows($qry) > 0) {
	     $row = $this->db->fetch_array($qry);
				
				$result=$row['category_name'];
			
		}
		
		
		
		return $result;
	}

	public function planedit($id)
	{
		$result = "";
		
		$query = "SELECT * FROM roo_plan_details WHERE id='$id'";
		
		$queryCount = "SELECT COUNT(id) AS cnt FROM roo_plan_details WHERE id='$id'"; 
		
		//echo $query; 
		$qry = $this->db->query($query);
		if($this->db->num_rows($qry) > 0) {
	     $row = $this->db->fetch_array($qry);
				
				$result=$row;
			
		}
		
		
		
		return $result;
	}
	
	public function planeditsave() {
		    
			$category=$this->db->escape_string($this->category);
			$fromsec=$this->db->escape_string($this->fromsec);
			$tosec=$this->db->escape_string($this->tosec);
			$amount=$this->db->escape_string($this->amount);
			$viewers=$this->db->escape_string($this->viewers);
		    $id=$this->id;
			$sql="Update roo_plan_details set catid='".$category."',from_sec='".$fromsec."',to_sec='".$tosec."',amount='".$amount."',viewers='".$viewers."' where id='".$id."'";
			//echo $sql; exit;
			$result=$this->db->query($sql);
		//echo $country; exit;
			
		if($result)	
		{
			return true;
		}
		return false;
	}
	
	public function plansave() {
		    
			$category=$this->db->escape_string($this->category);
			$fromsec=$this->db->escape_string($this->fromsec);
			$tosec=$this->db->escape_string($this->tosec);
			$amount=$this->db->escape_string($this->amount);
			$viewers=$this->db->escape_string($this->viewers);
		   
			$sql="INSERT INTO roo_plan_details(catid,from_sec,to_sec,amount,viewers,status) values('".$category."','".$fromsec."','".$tosec."','".$amount."','".$viewers."','0')";
			//echo $sql; exit;
			$result=$this->db->query($sql);
		//echo $country; exit;
			
		if($result)	
		{
			return true;
		}
		return false;
	}
		
	
public function Activatecategory($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_plancategory SET status=0 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	
	public function Deactivatecategory($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_plancategory SET status=1 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}

	
	public function Deletecategory($id=0) {
		if($id > 0) {
			$this->db->query("Delete from roo_plancategory WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	public function categorysave() {
		    
			$name=$this->categoryname;
		
			//echo $country; exit;
			$sql="INSERT INTO roo_plancategory(category_name,status) values('$name','0')";
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