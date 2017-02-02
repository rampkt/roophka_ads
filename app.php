<?php
include_once("./config/config.php");

$output = array('error' => '', 'session_id'=>'','msg' => '');


if(isset($_REQUEST['action'])) {

	if($_REQUEST['action'] == 'login')
	{
		$user = $db->escape_string($_REQUEST['username']);
	$pass = $db->escape_string($_REQUEST['password']);
	
	if($user == '' || $pass == '') {
		//redirect(HTTP_PATH . 'login.php?error=1');
		$output['error']="empty";
	}
	$pass = enc_password($pass);
	
	//echo "SELECT id,email,firstname,account_balance,lastlogin,status,phone,demo,spl_recharge FROM `roo_users` WHERE email='".$user."' AND pass='".$pass."'"; exit;
	
	$userQry = $db->query("SELECT id,email,firstname,account_balance,lastlogin,status,phone,demo,spl_recharge FROM `roo_users` WHERE email='".$user."' AND pass='".$pass."'");
	$num = $db->num_rows($userQry);
	if($num == 1) {
		$userRow = $db->fetch_array($userQry);
		
		if($userRow['status'] > 0) {
			$output['error']="inactive";
		}else{
		
		$db->query("UPDATE `roo_users` SET lastlogin='".DATETIME24H."' WHERE id='".$userRow['id']."'");
		
		$output['session_id'] = $userRow['id'];
				
		//redirect(HTTP_PATH . 'dashboard.php');
	
	   $output['msg']="success";
	}
	}
		
	} else {
		$output['error']="not exist";
	}
	
	
	}
	
echo json_encode($output); exit;
?>