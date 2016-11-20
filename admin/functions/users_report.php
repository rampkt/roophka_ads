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
	
	public function getAllUsers($date) {
		$datestr=date('Y-m-d',strtotime($date));
		//echo $datestr; exit;
		$result = array();
		
		$query = 'SELECT u.id, u.email, u.firstname, u.phone, u.status, u.account_balance, u.signupdate, u.demo,u.lastlogin FROM roo_users AS u WHERE u.lastlogin like '."'%$datestr%'".' and u.status IN (0,1) order by lastlogin desc LIMIT '.$this->start.','.$this->rowLimit;
		
		$queryCount = 'SELECT COUNT(u.id) AS cnt FROM roo_users AS u WHERE u.lastlogin like'. "'%$datestr%'".' and u.status IN (0,1)'; 
		
		$qry = $this->db->query($query);
		if($this->db->num_rows($qry) > 0) {
			while($row = $this->db->fetch_array($qry)) {
				$result[] = $row;
			}
		}
		
		// Pagination code
		$qryCount = $this->db->query($queryCount);
		$rowCount = $this->db->fetch_array($qryCount);
		
		$totalPage = getTotalPage($rowCount['cnt'],$this->rowLimit);
		$pagination = pagination("users_report.php", "todaydate=$date", $this->page, $totalPage, 6);
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