<?php
error_reporting(E_ALL);
session_start();
ob_start();
define('HOST','localhost');
define('USER','root');
define('PASS','');
define('DATABASE','roophka_ads_live');

define('HTTP_PATH','http://localhost/roophka/git/');
define('HTTPS_PATH','https://localhost/roophka/git/');

define('DOCUMENT_PATH',$_SERVER['DOCUMENT_ROOT'].'/roophka/git/');
define('SUB_DIR','/roophka/git/');
define('SALT','12BC#@');

// ## database connection
include("database.php");
$db = new database;

include("global.php");
include("functions.php");

define('PAGENAME',get_pagename());

//include(DOCUMENT_PATH . "function/general_functions.php");
//include(DOCUMENT_PATH . "function/mailler.php");
?>