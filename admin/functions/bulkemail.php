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

		public function getAllemails($name,$cid) 
	{
		
		$field="";
		if($name!="")
		{
			$field.=' and (e.email like '."'%$name%'".')';
		}
		
		if($cid!="")
		{
			$field.=' and (e.category= '.$cid.')';
		}
		//echo $datestr; exit;
		$result = array();
		
		$query = 'SELECT e.id, e.email, e.category, e.status,e.date_added FROM roo_emails AS e WHERE e.status IN (0,1) '.$field.' order by e.category asc LIMIT '.$this->start.','.$this->rowLimit;
		
		$queryCount = 'SELECT COUNT(e.id) AS cnt FROM roo_emails AS e WHERE e.status IN (0,1)'.$field; 
		
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
		$pagination = pagination("emails.php", "email=$name", $this->page, $totalPage, 6);
		return array($result, $pagination);
	}
		public function getAllsentemails($name) 
	{
		
		$field="";
		if($name!="")
		{
			$field.=' and (e.email like '."'%$name%'".')';
		}
		
		//echo $datestr; exit;
		$result = array();
		
		$query = 'SELECT e.id, e.email, e.subject,e.type, e.status,e.date_added FROM roo_sent_emails AS e WHERE e.status IN (0,1) '.$field.' order by e.email asc LIMIT '.$this->start.','.$this->rowLimit;
		
		$queryCount = 'SELECT COUNT(e.id) AS cnt FROM roo_sent_emails AS e WHERE e.status IN (0,1)'.$field; 
		
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
		$pagination = pagination("sentemails.php", "email=$name", $this->page, $totalPage, 6);
		return array($result, $pagination);
	}
	
	public function Activateemail($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_emails SET status=0 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	
	public function Deactivateemail($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_emails SET status=1 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}

	
	public function Deleteemail($id=0) {
		if($id > 0) {
			$this->db->query("Delete from roo_emails WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	
		public function getallcategory($cid) 
	{
		$result = "";
		
		$query = "SELECT * FROM roo_email_category WHERE status='0' order by category_name asc";
		
		$queryCount = "SELECT COUNT(id) AS cnt FROM roo_email_category WHERE status='0'"; 
		
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
		
		$query = "SELECT * FROM roo_email_category WHERE id='$id'";
		
		$queryCount = "SELECT COUNT(id) AS cnt FROM roo_email_category WHERE id='$id'"; 
		
		//echo $query; 
		$qry = $this->db->query($query);
		if($this->db->num_rows($qry) > 0) {
	     $row = $this->db->fetch_array($qry);
				
				$result=$row['category_name'];
			
		}
		
		
		
		return $result;
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
	
	public function emailssave() {
		    
			$category=$this->db->escape_string($this->category);
			$userinput=$this->db->escape_string($this->userinput);
		   
			
			if($userinput=='1')
			{	
		     $email=$this->email;
		
			$addresses = array();
            $addresses = explode(",",$email);
			foreach ($addresses as $Email_to)
           {
			   $query = "SELECT * FROM roo_emails AS e WHERE e.category='$category' and e.email='$Email_to'"; 
		
		//echo $query; 
		
		$qry = $this->db->query($query);
		//echo $this->db->num_rows($qry); exit;
		
		
		if($this->db->num_rows($qry) == 0) {

			   $sql="INSERT INTO roo_emails(category,email,date_added,status) values('".$category."','".$Email_to."','".DATETIME24H."','0')";
			//echo $sql; exit;
			$result=$this->db->query($sql);
		}
		   }
			}
			
			if($userinput=='2')
			{	
		     $file=$this->email['name'];
			 $tmpfile=$this->email['tmp_name'];
		
			//Import uploaded file to Database
            $handle = fopen($tmpfile, "r");
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				
				$query = "SELECT * FROM roo_emails AS e WHERE e.category='$category' and e.email='$data[0]'"; 
		
		//echo $query; 
		$qry = $this->db->query($query);
		if($this->db->num_rows($qry) == 0) {
           $sql="INSERT INTO roo_emails(category,email,date_added,status) values('".$category."','".$data[0]."','".DATETIME24H."','0')";
			//echo $sql; exit;
			$result=$this->db->query($sql);
           }
			}
			}
			//echo $country; exit;
			
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
	public function emailsvalue($id) {
		    $html="";
			
			//foreach($id as $cid)
			//{
				$sql="SELECT * FROM roo_emails where category IN ($id)";
			//echo $sql; exit;
			$result=$this->db->query($sql);
			while($row=$this->db->fetch_array($result))
			{
		    $html.="<div><input type='checkbox' name='eid[]' id='eid$row[id]' value='$row[id]' style='margin-top:0px;' checked onclick='checkedValues(this.value)'> ".$row['email']."</div>";
			}
			//echo $country; exit;
			
			
			
		if($result)	
		{
			return $html;
		}
		return false;
	}
	
	public function emailids($id) {
		    $ids="";
			
			//foreach($id as $cid)
			//{
				$sql="SELECT * FROM roo_emails where category IN ($id)";
			//echo $sql; exit;
			$result=$this->db->query($sql);
			while($row=$this->db->fetch_array($result))
			{
			
             if($ids=="")
			 {
				$ids.=$row['id']; 
			 }else{
				 $ids.=",".$row['id'];
			 }				 
				
		    
			}
			//echo $country; exit;
			
			
			
		if($result)	
		{
			return $ids;
		}
		return false;
	}
	
	public function AllemailTemplate() {
		
			$tempalate = array();
				$sql="SELECT * FROM roo_email_template where status=0";
			//echo $sql; exit;
			$result=$this->db->query($sql);
			while($row=$this->db->fetch_array($result))
			{
		    $tempalate[]=$row;
			}
			//echo $country; exit;
			
			
			
		if($result)	
		{
			return $tempalate;
		}
		return false;
	}
	
	public function emailscount($id) {
		    $html="";
			
			//foreach($id as $cid)
			//{
				$sql="SELECT * FROM roo_emails where category IN ($id)";
			//echo $sql; exit;
			$result=$this->db->query($sql);
			$html=$this->db->num_rows($result);
			//echo $country; exit;
			
			
			
		if($result)	
		{
			return $html;
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
	
	public function composesave() {
		    
			$subject=$this->subject;
			$category=$this->category;
			$eids=$this->eids;
			$message=$this->message;
			$type=$this->userinput;
			$adminemail=$this->adminemail;
			
			$ids=explode(",", $eids);
		    foreach($ids as $eid)
			{
				
			$sql="SELECT * FROM roo_emails where id='$eid'";
			//echo $sql; exit;
			$res=$this->db->query($sql);
			while($row=$this->db->fetch_array($res))
			{	
			//echo $country; exit;
			$sql="INSERT INTO roo_sent_emails(subject,from_email,email,type,message,subscribe,date_added,status) values('$subject','$adminemail','$row[email]','$type','$message','0','".DATETIME24H."','0')";
			//echo $sql; exit;
			$result=$this->db->query($sql);
			
			}
			}
		if($result)	
		{
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