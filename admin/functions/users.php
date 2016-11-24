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
	
}
?>