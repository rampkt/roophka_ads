<?php
include_once("./config/config.php");

//print_r($_REQUEST['email']); exit;

$email=$_REQUEST['email'];

$sql=$db->query("UPDATE roo_sent_emails SET sent='1',readmail='1' where md5_hash='$email' and readmail='0'");
//echo $row['email'];  exit;


$im = imagecreatetruecolor(1, 1);
imagefilledrectangle($im, 0, 0, 0, 0, 0xFb6b6F);
header('Content-Type: image/jpeg');
imagegif($im);
imagedestroy($im);
//echo $im;
?>