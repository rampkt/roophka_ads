<?php
class user
{
	private $db;
	
	public function __construct() {
		global $db;
		$this->db = $db;
	}
	
	public function dashboard() {
		
		$user_id = $_SESSION['roo']['user']['id'];
		$result = array();
		
		$transQry = $this->db->query("SELECT COUNT(adid) AS total_ads, SUM(amount) AS total_amount FROM roo_transaction WHERE userid = '".$user_id."'");
		$transRow = $this->db->fetch_array($transQry);
		
		/*echo "SELECT COUNT(ra.id) AS remaining_ads FROM roo_ads AS ra WHERE ra.clicks_remain > 0 AND ra.viewing = 0 AND ((SELECT COUNT(id) AS cnt FROM roo_transaction AS rt WHERE rt.adid = ra.id AND rt.userid = '".$user_id."' AND rt.date_added >= '".DATE_TODAY."') = 0) AND ra.status=0";exit;*/
		
		$newAdsQry = $this->db->query("SELECT COUNT(ra.id) AS remaining_ads FROM roo_ads AS ra WHERE ra.clicks_remain > 0 AND ra.viewing = 0 AND ((SELECT COUNT(id) AS cnt FROM roo_transaction AS rt WHERE rt.adid = ra.id AND rt.userid = '".$user_id."' AND rt.date_added >= '".DATE_TODAY."') = 0) AND ra.status=0");
		$newAdsRow = $this->db->fetch_array($newAdsQry);
		
		$todayAdsQry = $this->db->query("SELECT COUNT(adid) AS today_ads, SUM(amount) AS today_amount FROM roo_transaction WHERE userid = '".$user_id."' AND date_added >= '".DATE_TODAY."'");
		$todayAdsRow = $this->db->fetch_array($todayAdsQry);
		
		$withdrawQry = $this->db->query("SELECT COUNT(id) AS withdraw_count, SUM(amount) AS withdraw_amount FROM roo_withdraw WHERE userid = '".$user_id."' AND status = 1");
		$withdrawRow = $this->db->fetch_array($withdrawQry);
		
		$result['total_ads'] = $transRow['total_ads'];
		$result['total_amount'] = (($transRow['total_amount'] == '') ? 0 : $transRow['total_amount']);
		$result['remaining_ads'] = $newAdsRow['remaining_ads'];
		$result['today_ads'] = $todayAdsRow['today_ads'];
		$result['today_amount'] = (($todayAdsRow['today_amount'] == '') ? 0 : $todayAdsRow['today_amount']);
		$result['withdraw_amount'] = (($withdrawRow['withdraw_amount'] == '') ? 0 : $withdrawRow['withdraw_amount']);
		
		return $result;
		
	}
	
	public function fullDetails($user_id = 0) {
		
		if($user_id == 0) { 
			$user_id = $_SESSION['roo']['user']['id'];
		}
		
		$userQry = $this->db->query("SELECT * FROM roo_users WHERE id = '".$user_id."'");
		$userRow = $this->db->fetch_array($userQry);
		
		if($userRow['state'] > 0) {
			$userRow['state_name'] = $this->db->fetch_field("roo_state","id='".$userRow['state']."'","name");
		} else {
			$userRow['state_name'] = '';
		}
		
		if($userRow['city'] > 0) {
			$userRow['city_name'] = $this->db->fetch_field("roo_city","id='".$userRow['city']."'","name");
		} else {
			$userRow['city_name'] = '';
		}
		
		return $userRow;
	}
	
	public function transactions($user_id = 0) {
		if($user_id == 0) { 
			$user_id = $_SESSION['roo']['user']['id'];
		}
		
		$limit = 10;
		$result = array();
		
		$userQry = $this->db->query("SELECT * FROM roo_transaction WHERE userid = '".$user_id."' ORDER BY date_added DESC LIMIT 0,$limit");
		if($this->db->num_rows($userQry) > 0) {
			while($userRow = $this->db->fetch_array($userQry)) {
				$result[] = $userRow;
			}
		}
		return $result;
	}
	
	public function accounts($user_id = 0) {
		if($user_id == 0) { 
			$user_id = $_SESSION['roo']['user']['id'];
		}
		
		$limit = 10;
		$result = array();
		
		$userQry = $this->db->query("SELECT * FROM roo_user_accounts WHERE userid = '".$user_id."' ORDER BY date_added");
		if($this->db->num_rows($userQry) > 0) {
			while($userRow = $this->db->fetch_array($userQry)) {
				$userRow['number'] = stringMasking($userRow['number'], '*');
				$result[] = $userRow;
			}
		}
		return $result;
	}
	
	public function withdraw_status($user_id = 0) {
		if($user_id == 0) { 
			$user_id = $_SESSION['roo']['user']['id'];
		}
		
		$result = array();
		
		$temp = $ab = $this->db->fetch_field("roo_users","id = '".$user_id."'","account_balance");
		$temp = (($temp == '') ? 0 : $temp);
		$result['account_balance'] = number_format($temp,2);
		
		$result['withdraw_available'] = ($ab > 500) ? $result['account_balance'] : '0.00';
		
		$temp = $this->db->fetch_field("roo_withdraw","userid = '".$user_id."' AND status=0","SUM(amount) AS amt");
		$temp = (($temp == '') ? 0 : $temp);
		$result['withdraw_pending'] = number_format($temp,2);
		
		$temp = $this->db->fetch_field("roo_withdraw","userid = '".$user_id."' AND status=1","SUM(amount) AS amt");
		$temp = (($temp == '') ? 0 : $temp);
		$result['withdraw_total'] = number_format($temp,2);
		
		if($ab != $_SESSION['roo']['user']['account_balance']) {
			$_SESSION['roo']['user']['account_balance'] = $ab;
		}
		
		return $result;
	}
	
	public function bankEmptyCheck($data) {
		
		$result = true;
		
		foreach($data as $key => $val) {
			if($val == '' AND $key != 'ifsc') {
				$result = false;
			}
		}
		return $result;
	}
	
	public function addBank($data) {
		
		if(!isset($data['user_id']) || $data['user_id'] == 0 || $data['user_id'] == '') {
			$data['user_id'] = $_SESSION['roo']['user']['id'];
		}
		
		$output = array('error' => true, 'msg' => 'empty');
		$check = $this->bankEmptyCheck(false);
		if($check AND $data['user_id']>0) {
			$update = $this->db->query("UPDATE roo_user_accounts SET status = 1 WHERE userid = '".$data['user_id']."'");
			
			$reg = $this->db->query("INSERT INTO roo_user_accounts (userid, name, bank, ac_name, number, branch, ifsc, status, date_added) VALUES ('".$data['user_id']."', '".$data['name']."', '".$data['bank']."', '".$data['ac_name']."', '".$data['number']."', '".$data['branch']."', '".$data['ifsc']."', 0, '".DATETIME24H."')");
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
	
	public function addWithdraw($amt) {
		
		$user_id = $_SESSION['roo']['user']['id'];
		
		$output = array('error' => true, 'msg' => 'empty');		
		$ab = $this->db->fetch_field("roo_users","id = '".$user_id."'","account_balance");
		
		if($amt > $ab || $amt < 500) {
			$output['msg'] = 'amount';
			return $output;	
		}
		
		$tempInsert = $this->db->query("INSERT INTO roo_withdraw (userid, amount, date_added) VALUES ('".$user_id."', '".$amt."', '".DATETIME24H."')");
		if($tempInsert) {
			$currentBalance = $ab - $amt;
			$tempupdate = $this->db->query("UPDATE roo_users SET account_balance = '".$currentBalance."' WHERE id='".$user_id."' LIMIT 1");
			$_SESSION['roo']['user']['account_balance'] = $currentBalance;
			$output['error'] = false;
			$output['msg'] = 'success';
			return $output;
		} else {
			$output['msg'] = 'insert';
			return $output;	
		}
		
	}
	public function verify($userid, $mail = false) {
		global $mailler;

		$userQry = $this->db->query("SELECT firstname, email FROM roo_users WHERE id = '".$userid."'");
		if($this->db->num_rows($userQry) > 0) {
			$user = $this->db->fetch_array($userQry);
			$update = $this->db->query("UPDATE roo_users SET status = 0 WHERE id = '".$userid."'");

			if($mail == true) {
				$to = array($user['email']);
				$from = 'info@roophka.com';
				$subject = "Roophka : Registration complete.";
				$message = '<div style="width:600px;">
				Dear '.$user['firstname'].'<br>
				<p>Welcome to ROOPHKA.COM</p>
				<p>Your email verified successfully....</p>
				<p>Please login to site and continue earn by seeing advertisements and promotions</p>
				Thanks & regards,<br>
				<a href="'.HTTP_PATH.'">roophka.com</a>
				</div>';
			   $mailler->sendmail($to, $from, $subject, $message);
			}
		}
	}
}
?>