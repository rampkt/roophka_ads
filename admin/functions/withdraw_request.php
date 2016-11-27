<?php
class withdraw
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
	
	public function getAllwithdraw($date) {
		$datestr=date('Y-m-d',strtotime($date));
		//echo $datestr; exit;
		$result = array();
		
		$query = 'SELECT w.id, w.userid, w.amount,w.details,w.date_added, w.status FROM roo_withdraw AS w WHERE w.date_added like '."'%$datestr%'".'  order by w.date_added desc LIMIT '.$this->start.','.$this->rowLimit;
		
		//echo $query; 
		
		$queryCount = 'SELECT COUNT(w.id) AS cnt FROM roo_withdraw AS w WHERE w.date_added like'. "'%$datestr%'"; 
		
		$qry = $this->db->query($query);
		if($this->db->num_rows($qry) > 0) {
			while($row = $this->db->fetch_array($qry)) {
				$userid=$row['userid'];
				 $qry3 = $this->db->query("SELECT * FROM roo_users WHERE id='".$userid."'");
			       $row3 = $this->db->fetch_array($qry3);
				   $row['username']=$row3['firstname'];
				$row['email']=$row3['email'];
				   
				$result[] = $row;
			}
		}
		
		// Pagination code
		$qryCount = $this->db->query($queryCount);
		$rowCount = $this->db->fetch_array($qryCount);
		
		$totalPage = getTotalPage($rowCount['cnt'],$this->rowLimit);
		$pagination = pagination("withdraw_request.php", "todaydate=$date", $this->page, $totalPage, 6);
		return array($result, $pagination);
	}
	
	
	public function getAllwithdrawreport($date) {
		$datestr=date('Y-m-d',strtotime($date));
		//echo $datestr; exit;
		$result = array();
		
		$query = 'SELECT w.id, w.userid, w.amount,w.details,w.date_added, w.status FROM roo_withdraw AS w WHERE w.date_added like '."'%$datestr%'".'  order by w.date_added desc LIMIT '.$this->start.','.$this->rowLimit;
		
		$queryCount = 'SELECT COUNT(w.id) AS cnt FROM roo_withdraw AS w WHERE w.date_added like'. "'%$datestr%'"; 
		
		$qry = $this->db->query($query);
		if($this->db->num_rows($qry) > 0) {
			while($row = $this->db->fetch_array($qry)) {
				$userid=$row['userid'];
				 $qry3 = $this->db->query("SELECT * FROM roo_users WHERE id='".$userid."'");
			       $row3 = $this->db->fetch_array($qry3);
				   $row['username']=$row3['firstname'];
				$row['email']=$row3['email'];
				   
				$result[] = $row;
			}
		}
		
		// Pagination code
		$qryCount = $this->db->query($queryCount);
		$rowCount = $this->db->fetch_array($qryCount);
		
		$totalPage = getTotalPage($rowCount['cnt'],$this->rowLimit);
		$pagination = pagination("withdraw_report.php", "todaydate=$date", $this->page, $totalPage, 6);
		return array($result, $pagination);
	}
	
	
	public function Activate($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_users SET status=0 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	public function Deactivate($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_users SET status=1 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}

	public function DemoAccount($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_users SET demo=1 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	public function update()
	{ 
				$org_filename = $this->file['name'];
				//echo $org_filename; exit;
				
				$extn = pathinfo($org_filename, PATHINFO_EXTENSION);
				
				$path = DOCUMENT_PATH . "uploads/withdraw/";
				$filehash = randomString(20);
				
					$filename = $filehash . '.attach';
				
				$destination = $path . $org_filename;
				
				$httpPath = HTTP_PATH . "uploads/withdraw/" . $org_filename;
				
				@move_uploaded_file($this->file['tmp_name'], $destination);
				
				$userQry1 = $this->db->query("SELECT userid,amount FROM `roo_withdraw` WHERE (id='".$this->id."') limit 1");
		$row1=$this->db->fetch_array($userQry1);
		//echo "SELECT userid,amount FROM `roo_withdraw` WHERE (id='".$this->id."') limit 1";
				
				$userQry = $this->db->query("SELECT id,email,account_balance FROM `roo_users` WHERE (id='".$row1['userid']."') limit 1");
		$row=$this->db->fetch_array($userQry);
		
		//echo "SELECT id,email,account_balance FROM `roo_users` WHERE (id='".$row1['userid']."') limit 1";
		
		$account_balance=$row['account_balance']-$row1['amount'];
		$result1=$this->db->query("UPDATE roo_users set account_balance=  '". $account_balance ."' where id='".$row['id']."'");
				//echo "UPDATE roo_users set account_balance=  '". $account_balance ."' where id='".$row['id']."'"; exit;
				//if(file_exists($destination)) {
					$result=$this->db->query("UPDATE roo_withdraw set approve_date=  '". DATETIME24H ."', upload_image='".$org_filename."',filehash='".$filehash."', transaction_id='".$this->trans_id."',description='".$this->addcontent."',status='1' where id='".$this->id."'");
					
					if($result) { 
						return true;
					} else {
						return false;
					}
				//}
				return false;
		
	}
	public function updatedecline()
	{ 
				
					$result=$this->db->query("UPDATE roo_withdraw set approve_date=  '". DATETIME24H ."', description='".$this->addcontent."',status='2' where id='".$this->id."'");
					
					if($result) { 
						return true;
					} else {
						return false;
					}
			
		
	}
	
}
?>