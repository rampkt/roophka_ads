<?php
class adminusers
{
	private $db;
	
	public function __construct() {
		global $db;
		$this->db = $db;
		
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
	
	public function add($data) {
		
		$encPassword = enc_password($data['password']);
		
		$insert = $this->db->query("INSERT INTO roo_admin_users (email, username, password, salt, firstname, lastname, phone, signupdate, type, status) VALUES ('".$data['email']."', '".$data['username']."', '".$encPassword."', '".SALT."', '".$data['firstname']."', '".$data['lastname']."', '".$data['phone']."', '".DATETIME24H."', '".$data['type']."', 0)");
		
		if($insert) {
			return true;
		} else {
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