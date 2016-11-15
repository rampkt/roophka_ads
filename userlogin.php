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

redirect(HTTP_PATH);
?>