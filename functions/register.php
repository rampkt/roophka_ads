<?php

class register
{
	private $db = '';
	public $name = '';
	public $email = '';
	public $mobile = '';
	public $password = '';
	public $userid = '';
	public $dob = '';
	public $address = '';
	public $country = '';
	public $state = '';
	public $city = '';
	public $pincode = '';
	
	public function __construct() {
		
		global $db;
		$this->db = $db;
		
		$this->country = 88;
		
	}
	
	public function emptycheck($edit = false) {
		if($edit) {
			if($this->userid == '' || $this->name == '' || $this->mobile == '' || $this->dob == '' || $this->address == '' || $this->country == '' || $this->state == '' || $this->city == '' || $this->pincode == '') {
				return false;
			} else {
				return true;
			}
		} else {
			if($this->name == '' || $this->email == '' || $this->mobile == '' || $this->password == '' || $this->dob == '' || $this->address == '' || $this->state == '' || $this->city == '' || $this->pincode == '') {
				return false;
			} else {
				return true;
			}
		}
	}
	
	public function emailAvailable($email) {
		$currentCheck = $this->db->fetch_field("roo_users", "email='".$email."'", "COUNT(id) AS cnt");
		if($currentCheck == 1) {
			return false;
		} else {
			return true;
		}
	}
	
	public function save() {
		$output = array('error' => true, 'msg' => 'empty');
		
		$check = $this->emptycheck(false);
		if($check) {
			
			$emailCheck = $this->emailAvailable($this->email);
			if($emailCheck === false) {
				$output['msg'] = 'duplicate';
				return $output;
			}
			
			$encpassword = enc_password($this->password);
			$reg = $this->db->query("INSERT INTO roo_users (email, pass, salt, firstname, phone, signupdate, status, dob, address, country, state, city, pincode) VALUES ('".$this->email."', '".$encpassword."', '".SALT."', '".$this->name."', '".$this->mobile."', '".DATETIME24H."', 1, '".$this->dob."', '".$this->address."', '".$this->state."', '".$this->state."', '".$this->city."', '".$this->pincode."')");
			if($reg) {
				$output['error'] = false;
				$output['msg'] = 'success';
				$output['userid'] = $this->db->insert_id();
				return $output;
			} else {
				$output['msg'] = 'insert';
				return $output;
			}
		} 
		return $output;
	}
	
	public function update() {
		$output = array('error' => true, 'msg' => 'empty');
		$check = $this->emptycheck(true);
		if($check) {
			$reg = $this->db->query("UPDATE roo_users SET firstname='".$this->name."', phone='".$this->mobile."', dob='".$this->dob."', address='".$this->address."', country='".$this->country."', state='".$this->state."', city='".$this->city."', pincode='".$this->pincode."' WHERE id='".$this->userid."'");
			if($reg) {
				$output['error'] = false;
				$output['msg'] = 'success';
				return $output;
			} else {
				$output['msg'] = 'insert';
				return $output;
			}
		} 
		return $output;
	}
	
	public function changepassword($data) {
		$output = array('error' => true, 'msg' => 'empty');
		
		if($data['new'] != '' AND $data['confirm'] !='' AND $data['current'] !='') {
			$user_id = $_SESSION['roo']['user']['id'];
			$currentpassword = enc_password($data['current']);
			$currentCheck = $this->db->fetch_field("roo_users", "pass='".$currentpassword."' AND id='".$user_id."'", "COUNT(id) AS cnt");
			
			if($currentCheck < 1) {
				$output['msg'] = 'currentpassword';
			} elseif($data['new'] != $data['confirm']) {
				$output['msg'] = 'mismatch';
			} else {
				$password = enc_password($data['new']);
				$update = $this->db->query("UPDATE roo_users SET pass='".$password."' WHERE id='".$user_id."' LIMIT 1");
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