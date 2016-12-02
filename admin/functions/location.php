<?php
class location
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
	
	
	public function getAlladvertise() 
	{
		
		//echo $datestr; exit;
		$result = array();
		
		$query = 'SELECT * FROM roo_advertise_request order by date_added asc LIMIT '.$this->start.','.$this->rowLimit;
		
		$queryCount = 'SELECT COUNT(id) AS cnt FROM roo_advertise_request '; 
		
		//echo $query; 
		$qry = $this->db->query($query);
		if($this->db->num_rows($qry) > 0) {
			while($row = $this->db->fetch_array($qry)) {
				
				$row['countryname']=$this->getcountryname($row['country']);
				$row['statename']=$this->getstatename($row['state']);
				$row['cityname']=$this->getcityname($row['city']);
				
				$result[] = $row;
			}
		}
		
		// pagination code
		$qryCount = $this->db->query($queryCount);
		$rowCount = $this->db->fetch_array($qryCount);
		
		$totalPage = getTotalPage($rowCount['cnt'],$this->rowLimit);
		$pagination = pagination("advertise.php", "", $this->page, $totalPage, 6);
		return array($result, $pagination);
	}
	
	
	public function getAllcontactus() 
	{
		
		//echo $datestr; exit;
		$result = array();
		
		$query = 'SELECT c.id, c.name, c.email, c.subject, c.message, c.date_added FROM roo_contactus AS c order by c.date_added asc LIMIT '.$this->start.','.$this->rowLimit;
		
		$queryCount = 'SELECT COUNT(c.id) AS cnt FROM roo_contactus AS c '; 
		
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
		$pagination = pagination("contactus.php", "", $this->page, $totalPage, 6);
		return array($result, $pagination);
	}
	
	public function getAllcountry($country) 
	{
		
		$field="";
		if($country!="")
		{
			$field.='and (c.name like '."'%$country%'".')';
		}
		//echo $datestr; exit;
		$result = array();
		
		$query = 'SELECT c.id, c.name, c.status, (SELECT COUNT(id) FROM roo_state AS st WHERE st.cid = c.id) AS state,(SELECT COUNT(id) FROM roo_city AS ct WHERE ct.cid = c.id) AS city  FROM roo_country AS c WHERE c.status IN (0,1) '.$field.' order by c.name asc LIMIT '.$this->start.','.$this->rowLimit;
		
		$queryCount = 'SELECT COUNT(c.id) AS cnt FROM roo_country AS c WHERE c.status IN (0,1)'.$field; 
		
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
		$pagination = pagination("country.php", "country=$country", $this->page, $totalPage, 6);
		return array($result, $pagination);
	}
	public function getAllstate($state,$cid) 
	{
		
		$field="and st.cid=$cid";
		if($state!="")
		{
			$field.=' and (st.name like '."'%$state%'".')';
		}
		//echo $datestr; exit;
		$result = array();
		
		$query = 'SELECT st.id, st.name, st.status,st.cid,(SELECT COUNT(id) FROM roo_city AS ct WHERE st.id = ct.sid) AS city  FROM roo_state AS st WHERE st.status IN (0,1) '.$field.' order by st.name asc LIMIT '.$this->start.','.$this->rowLimit;
		
		$queryCount = 'SELECT COUNT(st.id) AS cnt FROM roo_state AS st WHERE st.status IN (0,1)'.$field; 
		
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
		$pagination = pagination("state.php", "state=$state&id=$cid", $this->page, $totalPage, 6);
		return array($result, $pagination);
	}
	
		public function getAllcity($city,$cid,$sid) 
	{
		
		$field="and ct.cid=$cid and ct.sid=$sid";
		if($city!="")
		{
			$field.=' and (ct.name like '."'%$city%'".')';
		}
		//echo $datestr; exit;
		$result = array();
		
		$query = 'SELECT ct.id, ct.name, ct.status,ct.cid,ct.sid FROM roo_city AS ct WHERE ct.status IN (0,1) '.$field.' order by ct.name asc LIMIT '.$this->start.','.$this->rowLimit;
		
		$queryCount = 'SELECT COUNT(ct.id) AS cnt FROM roo_city AS ct WHERE ct.status IN (0,1)'.$field; 
		
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
		$pagination = pagination("city.php", "city=$city&cid=$cid&sid=$sid", $this->page, $totalPage, 6);
		return array($result, $pagination);
	}

	
	public function Activate($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_country SET status=0 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	public function getcountryname($id=0) {
		if($id > 0) {
			$qry=$this->db->query("select name from roo_country WHERE id='".$id."' LIMIT 1");
			$qryfetch=$this->db->fetch_array($qry);
			
			return $qryfetch['name'];
		}
		return false;
	}
	
	public function getstatename($id=0) {
		if($id > 0) {
			$qry=$this->db->query("select name from roo_state WHERE id='".$id."' LIMIT 1");
			$qryfetch=$this->db->fetch_array($qry);
			
			return $qryfetch['name'];
		}
		return false;
	}
	
	public function getcityname($id=0) {
		if($id > 0) {
			$qry=$this->db->query("select name from roo_city WHERE id='".$id."' LIMIT 1");
			$qryfetch=$this->db->fetch_array($qry);
			
			return $qryfetch['name'];
		}
		return false;
	}
	
	public function countryupdate($id=0,$cname) {
		if($id > 0) {
			$this->db->query("UPDATE roo_country SET name='".$cname."' WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	public function stateupdate($id=0,$cid,$sname) {
		if($id > 0) {
			$this->db->query("UPDATE roo_state SET name='".$sname."' WHERE id='".$id."' and cid='".$cid."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	public function cityupdate($id=0,$sid,$cid,$ctname) {
		if($id > 0) {
			$this->db->query("UPDATE roo_city SET name='".$ctname."' WHERE id='".$id."' and sid='".$sid."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	
	public function Deletecountry($id=0) {
		if($id > 0) {
			$this->db->query("Delete from roo_country WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	
	public function Deleteadvertise($id=0) {
		if($id > 0) {
			$this->db->query("Delete from roo_advertise_request WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	
	public function Deletecontact($id=0) {
		if($id > 0) {
			$this->db->query("Delete from roo_contactus WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	public function Deletestate($id=0) {
		if($id > 0) {
			$this->db->query("Delete from roo_state WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	public function Deletecity($id=0) {
		if($id > 0) {
			$this->db->query("Delete from roo_city WHERE id='".$id."' LIMIT 1");
			return true;
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
	
	public function Approveadvertise($id=0,$pass) {
		
		$encpassword = enc_password($pass);
		
		if($id > 0) {
			$this->db->query("UPDATE roo_advertise_request SET status='1' WHERE id='".$id."' LIMIT 1");
			
			$qry=$this->db->query("select * from roo_advertise_request where id='".$id."' LIMIT 1");
			$fetch=$this->db->fetch_array($qry);
			
			$username=$fetch['email'];
			
			//echo "INSERT INTO roo_admin_users(email,username,password,salt,firstname,lastname,phone,signupdate,type,status)values('".$fetch['email']."','".$username."','".$encpassword."','".SALT."','".$fetch['company_name']."','','".$fetch['mobile']."','".DATETIME24H."','3','0')"; exit;
			
			$qry2=$this->db->query("INSERT INTO roo_admin_users(email,username,password,salt,firstname,lastname,phone,signupdate,type,status)values('".$fetch['email']."','".$username."','".$encpassword."','".SALT."','".$fetch['company_name']."','','".$fetch['mobile']."','".DATETIME24H."','3','0')");
			
			return true;
		}
		return false;
	}
	

	public function Updatecountry($id,$country) {
		if($id > 0) {
			$this->db->query("UPDATE roo_country SET name='".$country."' WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	public function Deactivate($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_country SET status=1 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}

public function Activatestate($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_state SET status=0 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	public function Deactivatestate($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_state SET status=1 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}

public function Activatecity($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_city SET status=0 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	public function Deactivatecity($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_city SET status=1 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}

	public function countrysave($country) {
		if($country !="") {
			//echo $country; exit;
			$sql="INSERT INTO roo_country(name,status) values('$country','0')";
			//echo $sql; exit;
			$this->db->query($sql);
			return true;
		}
		return false;
	}
	
	public function statesave($cid,$state) {
		if($state !="") {
			//echo $state; exit;
			$sql="INSERT INTO roo_state(cid,name,status) values('$cid','$state','0')";
			//echo $sql; exit;
			$this->db->query($sql);
			return true;
		}
		return false;
	}
	
	public function citysave($cid,$sid,$city) {
		if($city !="") {
			//echo $city; exit;
			$sql="INSERT INTO roo_city(cid,sid,name,status) values('$cid','$sid','$city','0')";
			//echo $sql; exit;
			$this->db->query($sql);
			return true;
		}
		return false;
	}
	
	
}
?>