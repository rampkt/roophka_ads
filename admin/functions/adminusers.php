<?php
class adminusers
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
	
	public function getAllUsers() {
		$result = array();
		$qry = $this->db->query("SELECT u.id, u.email, u.firstname, u.phone, u.status, u.type, u.signupdate FROM roo_admin_users AS u WHERE u.status IN (0,1) AND u.type IN (1, 2, 3)");
		if($this->db->num_rows($qry) > 0) {
			while($row = $this->db->fetch_array($qry)) {
				
				$result[] = $row;
			}
		}
		return $result;
	}
	
	public function getAllbankdetails($id) 
	{
		//echo $datestr; exit;
		$result = array();
		
		$query = 'SELECT ua.id, ua.userid, ua.name, ua.bank, ua.ac_name, ua.number, ua.branch, ua.status,ua.ifsc,ua.date_added FROM roo_user_accounts AS ua WHERE ua.status IN (0,1) and ua.userid='."$id".' order by ua.date_added desc LIMIT '.$this->start.','.$this->rowLimit;
		
		$queryCount = 'SELECT COUNT(ua.id) AS cnt FROM roo_user_accounts AS ua WHERE ua.status IN (0,1) and ua.userid='.$id; 
		
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
		$pagination = pagination("viewprofile.php", "action=view&id=$id", $this->page, $totalPage, 6);
		return array($result, $pagination);
	}
	public function getAlltransaction($id=0)
	{
		
		$result = array();
		
		$query = 'SELECT ad.id,ad.userid,ad.adid,ad.detail,ad.type,ad.date_added,ad.demo,ad.visitor_location,ad.ipaddr,ad.amount FROM roo_transaction AS ad WHERE ad.userid = '."'$id'".' order by ad.date_added desc LIMIT '.$this->start.','.$this->rowLimit;
		
		//echo $query; exit;
		$queryCount = 'SELECT COUNT(ad.id) AS cnt FROM roo_transaction AS ad WHERE ad.userid = '.$id; 
		//echo $queryCount;
		$qry = $this->db->query($query);
		
		if($this->db->num_rows($qry) > 0) {
			while($row = $this->db->fetch_array($qry)) {
			
			          $adid=$row['adid'];
					  $userid=$row['userid'];
				   $qry2 = $this->db->query("SELECT * FROM roo_ads WHERE id='".$adid."'");
			       $row2 = $this->db->fetch_array($qry2);
				   
				   $qry3 = $this->db->query("SELECT * FROM roo_users WHERE id='".$userid."'");
			       $row3 = $this->db->fetch_array($qry3);
				   
				$row['adname']=$row2['name']; 
				$row['adstatus']=$row2['status'];
				$row['username']=$row3['firstname'];
				$row['email']=$row3['email'];
				//print_r($row);
				$result[] = $row;
			}
			//exit;
		}
		
		// Pagination code
		$qryCount = $this->db->query($queryCount);
		$rowCount = $this->db->fetch_array($qryCount);
		
		$totalPage = getTotalPage($rowCount['cnt'],$this->rowLimit);
		$pagination = pagination("viewprofile.php", "action=view&id=$id", $this->page, $totalPage, 6);
		return array($result, $pagination);
	}
	
	
	public function Activate($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_admin_users SET status=0 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	public function Deactivate($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_admin_users SET status=1 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	public function bankDelete($id=0) {
		if($id > 0) {
			$this->db->query("DELETE FROM roo_user_accounts WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	public function bankActivate($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_user_accounts SET status=0 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	public function bankDeactivate($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_user_accounts SET status=1 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	
	public function add($data) {
		
		$encPassword = enc_password($data['password']);
		
		$insert = $this->db->query("INSERT INTO roo_admin_users (email, username, password, salt, firstname, lastname, phone, signupdate, type, status) VALUES ('".$data['email']."', '".$data['username']."', '".$encPassword."', '".SALT."', '".$data['firstname']."', '".$data['lastname']."', '".$data['phone']."', '".DATETIME24H."', '".$data['type']."', 0)");
		
		if($insert) {
			return true;
		} else {
			//$error = $this->db->error();
			//print_r($error);
			return false;
		}
		
	}
	
	public function save($data, $user_id = 0) {
		
		if($user_id < 1) {
			$user_id = $_SESSION['roo']['admin_user']['id'];
		}
		
		$update = $this->db->query("UPDATE roo_admin_users SET email='".$data['email']."', firstname='".$data['firstname']."', lastname='".$data['lastname']."', phone='".$data['phone']."' WHERE id = '".$user_id."'");
		
		if($update) {
			return true;
		} else {
			return false;
		}
		
	}
	
	public function getUser($user_id = 0) {
		
		if($user_id < 1) {
			$user_id = $_SESSION['roo']['admin_user']['id'];
		}
		
		$qry = $this->db->query("SELECT id, email, username, firstname, lastname, phone FROM roo_admin_users WHERE id = '".$user_id."'");
		$row = $this->db->fetch_array($qry);
		
		return $row;
		
	}
	
	public function getcountry($id = 0) {
		
		
		$qry = $this->db->query("SELECT name FROM roo_country WHERE id = '".$id."'");
		$row = $this->db->fetch_array($qry);
		
		return $row;
		
	}
	public function getstate($id = 0) {
		
		
		$qry = $this->db->query("SELECT name FROM roo_state WHERE id = '".$id."'");
		$row = $this->db->fetch_array($qry);
		
		return $row;
		
	}
	
	public function getcity($id = 0) {
		
		
		$qry = $this->db->query("SELECT name FROM roo_city WHERE id = '".$id."'");
		$row = $this->db->fetch_array($qry);
		
		return $row;
		
	}
	
	public function getUserdetails($user_id = 0) {
		
		$qry = $this->db->query("SELECT id, email,firstname, lastname, phone,dob,address,pincode,city,state,country,account_balance,lastlogin,signupdate,demo,status FROM roo_users WHERE id = '".$user_id."'");
		$row = $this->db->fetch_array($qry);
		
		return $row;
		
	}
	
	public function changepassword($data, $user_id = 0) {
		$output = array('error' => true, 'msg' => 'empty');
		if($user_id < 1) {
			$user_id = $_SESSION['roo']['admin_user']['id'];
		}
		if($data['new'] != '' AND $data['confirm'] !='' AND $data['current'] !='') {
			$currentpassword = enc_password($data['current']);
			$currentCheck = $this->db->fetch_field("roo_admin_users", "password='".$currentpassword."' AND id='".$user_id."'", "COUNT(id) AS cnt");
			
			if($currentCheck < 1) {
				$output['msg'] = 'currentpassword';
			} elseif($data['new'] != $data['confirm']) {
				$output['msg'] = 'mismatch';
			} else {
				$password = enc_password($data['new']);
				$update = $this->db->query("UPDATE roo_admin_users SET password='".$password."' WHERE id='".$user_id."' LIMIT 1");
				if($update) {
					$output['error'] = false;
					$output['msg'] = 'success';
				} else {
					$output['msg'] = 'insert';
				}
			}
		}
		return $output;
	}
	
}
?>