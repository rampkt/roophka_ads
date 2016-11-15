<?php
error_reporting(E_ALL);
session_start();
ob_start();
define('HOST','localhost');
define('USER','root');
define('PASS','');
define('DATABASE','roophka_ads');

define('HTTP_PATH','http://localhost/project/roophka/ads/');
define('HTTPS_PATH','https://localhost/project/roophka/ads/');

define('DOCUMENT_PATH',$_SERVER['DOCUMENT_ROOT'].'/project/roophka/ads/');
define('SUB_DIR','/project/roophka/ads/');
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