<?php
class users
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
	
	public function getAllUserstransaction() 
	{
		$field=array();
		
		//echo $datestr; exit;
		$result = array();
		
		$query = 'SELECT u.id, u.email, u.firstname, u.phone, u.status, u.account_balance, u.signupdate, u.demo FROM roo_users AS u WHERE u.status IN (0,1)  order by u.email asc';
		
		$queryCount = 'SELECT COUNT(u.id) AS cnt FROM roo_users AS u WHERE u.status IN (0,1)'; 
		
		//echo $query; 
		$qry = $this->db->query($query);
		if($this->db->num_rows($qry) > 0) {
			while($row = $this->db->fetch_array($qry)) {
				
				$field[]=($row['email']);
				
				$result[] = $row;
			}
		}
		//print_r(json_encode($field)); 
		// pagination code
		return $field;
	}
	
	
	public function getAllUsers($date,$name,$email,$phone) 
	{
		$datestr=date('Y-m-d',strtotime($date));
		$field="";
		if($date!="")
		{
			$field.='and (u.signupdate like '."'%$datestr%'".')';
		}
		if($name!="")
		{
			$field.='and (u.firstname like '."'%$name%'".')';
		}
		
		if($email!="")
		{
			$field.='and (u.email like '."'%$email%'".')';
		}
		if($phone!="")
		{
			$field.='and (u.phone like '."'%$phone%'".')';
		}
		
		//echo $datestr; exit;
		$result = array();
		
		$query = 'SELECT u.id, u.email, u.firstname, u.phone, u.status, u.account_balance, u.signupdate, u.demo, (SELECT COUNT(id) FROM roo_user_accounts AS ua WHERE ua.userid = u.id) AS bank FROM roo_users AS u WHERE u.status IN (0,1) '.$field.' order by u.signupdate desc LIMIT '.$this->start.','.$this->rowLimit;
		
		$queryCount = 'SELECT COUNT(u.id) AS cnt FROM roo_users AS u WHERE u.status IN (0,1)'.$field; 
		
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
		$pagination = pagination("users.php", "search=user&name=$name&email=$email&phone=$phone&todaydate=$date", $this->page, $totalPage, 6);
		return array($result, $pagination);
	}
	
	public function Activate($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_users SET status=0 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	public function changepass($id=0,$pass) {
		
		$encpassword = enc_password($pass);
		
		if($id > 0) {
			$this->db->query("UPDATE roo_users SET pass='".$encpassword."',salt='".SALT."' WHERE id='".$id."' LIMIT 1");
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
	
	public function getUserBanks($userid) {
		$result = array();
		if($userid > 0) {
			$qry = $this->db->query("SELECT * FROM roo_user_accounts WHERE userid = '".$userid."'");
			if($this->db->num_rows($qry) > 0) {
				while($row = $this->db->fetch_array($qry)) {
					$result[] = $row;
				}
			}
		}
		return $result;
	}
	
	
	public function savetransaction()
	{
		$admin=$_SESSION['roo']['admin_user']['id'];
		
		$userQry = $this->db->query("SELECT id,email,account_balance FROM `roo_users` WHERE (email='".$this->email."') limit 1");
		$row=$this->db->fetch_array($userQry);
		
		 
		
		//echo "INSERT INTO roo_transaction (userid,type,detail,amount,date_added,adminid) values ('".$row['id']."','add','".$this->reason."','".$this->amount."','".DATETIME24H."','".$admin."')"; exit;
		if($this->trans_type=='1')
		{
			$account_balance=$row['account_balance']+$this->amount;
			
			//echo "INSERT INTO roo_transaction (userid,adid,type,detail,amount,date_added,admin) values ('".$row['id']."','0','add','".$this->reason."','".$this->amount."','".DATETIME24H."','".$admin."')"; 
			//echo "UPDATE roo_users set account_balance=  '". $account_balance ."' where id='".$row['id']."'";
			//exit;
			
			
			$qry=$this->db->query("INSERT INTO roo_transaction (userid,adid,type,detail,amount,date_added,admin,withdrawid) values ('".$row['id']."','0','add','".$this->reason."','".$this->amount."','".DATETIME24H."','".$admin."','0')");
			
			$result=$this->db->query("UPDATE roo_users set account_balance=  '". $account_balance ."' where id='".$row['id']."'");
		}
		else{
		
		
		$org_filename = $this->file['name'];
				//echo $org_filename; exit;
				
				$extn = pathinfo($org_filename, PATHINFO_EXTENSION);
				
				$path = DOCUMENT_PATH . "uploads/withdraw/";
				$filehash = randomString(20);
				
					$filename = $filehash . '.attach';
				
				$destination = $path . $org_filename;
				
				$httpPath = HTTP_PATH . "uploads/withdraw/" . $org_filename;
				
				@move_uploaded_file($this->file['tmp_name'], $destination);
				
				//$account_balance=$row['account_balance']+$this->amount;
				
				$qry1=$this->db->query("INSERT INTO roo_withdraw (userid,status,details,amount,date_added,transaction_id,description,approve_date,upload_image,filehash) values ('".$row['id']."','1','".$this->reason."','".$this->amount."','".DATETIME24H."','".$this->transid."','".$this->reason."','".DATETIME24H."','".$org_filename."','".$filehash."')");
				$withdrawid=$this->db->insert_id();;
			
			//echo "INSERT INTO roo_transaction (userid,adid,type,detail,amount,date_added,admin,withdrawid) values ('".$row['id']."','0','witdrawn','".$this->reason."','".$this->amount."','".DATETIME24H."','".$admin."','".$withdrawid."')"; exit;
			
			$qry=$this->db->query("INSERT INTO roo_transaction (userid,adid,type,detail,amount,date_added,admin,withdrawid) values ('".$row['id']."','0','witdrawn','".$this->reason."','".$this->amount."','".DATETIME24H."','".$admin."','".$withdrawid."')");
			
			if(($this->debit)==1)
		{
		$account_balance=$row['account_balance']-$this->amount;
		$result=$this->db->query("UPDATE roo_users set account_balance=  '". $account_balance ."' where id='".$row['id']."'");
				
		}
		
		//if(file_exists($destination)) {
					
					if($qry) { 
						return true;
					} else {
						return false;
					}
				//}
				return false;

	}
	}
	
}
?>