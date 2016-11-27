<?php
include_once("../config/config.php");

$login = check_admin_login();
if($login === true) {
	redirect(HTTP_PATH . 'admin/dashboard.php');
}

if(!isset($_REQUEST['action'])) {
	redirect(HTTP_PATH . 'admin/index.php');
}

if($_REQUEST['action'] == 'dologin') {
	$user = $db->escape_string($_REQUEST['username']);
	$pass = $db->escape_string($_REQUEST['password']);
	
	if($user == '' || $pass == '') {
		redirect(HTTP_PATH . 'admin/index.php?error=1');
	}
	$pass = enc_password($pass);
	
	$userQry = $db->query("SELECT id,email,firstname,lastname,status,type FROM `roo_admin_users` WHERE (username='".$user."' OR email='".$user."') AND password='".$pass."'");
	$num = $db->num_rows($userQry);
	if($num == 1) {
		$userRow = $db->fetch_array($userQry);
		
		if($userRow['status'] > 0) {
			redirect(HTTP_PATH . 'admin/index.php?error=3');
		}
		
		$db->query("UPDATE `roo_admin_users` SET lastlogin='".DATETIME24H."' WHERE id='".$userRow['id']."'");
		
		$_SESSION['roo']['admin_user'] = $userRow;
		$_SESSION['roo']['admin_user']['id'] = $userRow['id'];
		//$_SESSION['roo']['admin_user']['email'] = $userRow['email'];
		$_SESSION['roo']['admin_user']['fullname'] = $userRow['firstname'] . ' ' . $userRow['lastname'];
		
		redirect(HTTP_PATH . 'admin/dashboard.php');
		
	} else {
		redirect(HTTP_PATH . 'admin/index.php?error=2');
	}
}

redirect(HTTP_PATH . 'admin/index.php');
?>