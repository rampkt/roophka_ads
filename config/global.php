<?php
date_default_timezone_set("Asia/Kolkata");
// Get settings table
$setQry = $db->query("SELECT * FROM roo_settings WHERE id=1");
$setting = $db->fetch_array($setQry);
$setting['salt_password'] = SALT;

define('DATETIME24H',date('Y-m-d H:i:s'));
define('DATE_TODAY',date('Y-m-d'));
define('MAX_DOB',date('Y-m-d',strtotime(DATE_TODAY . " -10 year")));
define('MIN_DOB',date('Y-m-d',strtotime(DATE_TODAY . " -100 year")));

if(!isset($_SESSION['roo'])) {
	$_SESSION['roo'] = array();
	$_SESSION['roo']['ip'] = $_SERVER['REMOTE_ADDR'];
	$_SESSION['roo']['client'] = $_SERVER['HTTP_USER_AGENT'];
}

include(DOCUMENT_PATH . "functions/mailler.php");
$mailler = new mailler();

?>