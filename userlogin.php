<?php
include_once("./config/config.php");

spl_autoload_register(function($file){
	include("./functions/".$file.".php");
});

$login = check_login();
if($login === true) {
	redirect(HTTP_PATH . 'dashboard.php');
}

if(isset($_REQUEST['enc'])) {
  $encarray = three_layer_decrypt('', $_REQUEST['enc']);
  $_REQUEST = $encarray;
}

if(!isset($_REQUEST['action'])) {
	redirect(HTTP_PATH . 'login.php');
}

if($_REQUEST['action'] == 'verify') {
	if($_REQUEST['type'] == 'email') {
		//include("./functions/user.php");
		$user = new user();
		$user->verify($_REQUEST['userid'], true);
		//echo "<pre>";print_r($user);echo "</pre>";exit;
		redirect(HTTP_PATH . "register_confirm.php");
	}
}

if($_REQUEST['action'] == 'dologin') {
	$user = $db->escape_string($_REQUEST['username']);
	$pass = $db->escape_string($_REQUEST['password']);
	
	if($user == '' || $pass == '') {
		redirect(HTTP_PATH . 'login.php?error=1');
	}
	$pass = enc_password($pass);
	$userQry = $db->query("SELECT id,email,firstname,account_balance,lastlogin,status,demo FROM `roo_users` WHERE email='".$user."' AND pass='".$pass."'");
	$num = $db->num_rows($userQry);
	if($num == 1) {
		$userRow = $db->fetch_array($userQry);
		
		if($userRow['status'] > 0) {
			redirect(HTTP_PATH . 'login.php?error=3');
		}
		
		$db->query("UPDATE `roo_users` SET lastlogin='".DATETIME24H."' WHERE id='".$userRow['id']."'");
		
		$_SESSION['roo']['user'] = $userRow;
				
		redirect(HTTP_PATH . 'dashboard.php');
		
	} else {
		redirect(HTTP_PATH . 'login.php?error=2');
	}
}

if($_REQUEST['action'] == 'resetpass') {
	$userid = $db->escape_string(base64_decode($_REQUEST['userid']));
	$pass=$db->escape_string($_REQUEST['newpass']);
	//echo $userid; exit;
	
	$pass = enc_password($pass);
	$userQry = $db->query("SELECT id,email,firstname,account_balance,lastlogin,status,demo FROM `roo_users` WHERE id='".$userid."'");
	$num = $db->num_rows($userQry);
	if($num == 1) {
		$userRow = $db->fetch_array($userQry);
		
		if($userRow['status'] > 0) {
			redirect(HTTP_PATH . 'login.php?error=3');
		}
		
		$db->query("UPDATE `roo_users` SET pass='".$pass."',salt='".SALT."' WHERE id='".$userRow['id']."'");
		
				$idd=$_REQUEST['userid'];
		redirect(HTTP_PATH . "reset_password.php?id=$idd&success=1");
		
	} else {
		redirect(HTTP_PATH . "reset_password.php?id=$idd&error=2");
	}
}

if($_REQUEST['action'] == 'forgotpass') {
	$user = $db->escape_string($_REQUEST['username']);
	
	if($user == '') {
		redirect(HTTP_PATH . 'forgot_password.php?error=1');
	}
	$userQry = $db->query("SELECT id,email,firstname,account_balance,lastlogin,status,demo FROM `roo_users` WHERE email='".$user."'");
	$num = $db->num_rows($userQry);
	if($num == 1) {
		$userRow = $db->fetch_array($userQry);
		
		if($userRow['status'] > 0) {
			redirect(HTTP_PATH . 'forgot_password.php?error=3');
		}
		//echo $userRow['id'];
		 $id =base64_encode($userRow['id']);
		//exit;
		
                $to = array($userRow['email']);
				$from = 'info@roophka.com';
				$subject = "Roophka : Reset Password link.";
				$message = '<div style="width:600px;">
				Dear '.$userRow['firstname'].'<br>
				<p>Welcome to ROOPHKA.COM</p>
				
				<p>Please click below link to reset your password and continue earn by seeing advertisements and promotions</p>
				
				<p><a href="'.HTTP_PATH.'reset_password.php?id='.$id.'">roophka.com reset password link</a></p>
				
				Thanks & regards,<br>
				<a href="'.HTTP_PATH.'">roophka.com</a>
				</div>';
			   $mailler->sendmail($to, $from, $subject, $message);
				
		redirect(HTTP_PATH . 'forgot_password.php?success=1');
		
	} else {
		redirect(HTTP_PATH . 'forgot_password.php?error=2');
	}
}

redirect(HTTP_PATH);
?>