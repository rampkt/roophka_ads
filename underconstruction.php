<?php
error_reporting(0);
include_once("./config/config.php");

/***
 * initial setup
 */
$pagename = ''; 
$subname = '';
include("./functions/cms.php");
$cms = new cms;

include("./functions/user.php");
//include("./functions/ads.php");
$user = new user;
//$ads = new ads;

//$ads->resetAd();
//$database = $user->dashboard();
//$recharge = $user->recharge_order();
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<? include("./includes/head.php"); ?>
<link type="text/css" rel="stylesheet" href="./assets/css/dashboard.css" />
</head>

<body id="home">
  
	<!-- header area -->
	<? include("./includes/header.php"); ?>
    <!-- end header -->
 
 <? include("./includes/head-wrap.php");  ?>
 <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="./assets/js/tabs.js"></script>
  <script src="./assets/js/recharge.js"></script>
  <link type="text/css" rel="stylesheet" href="./assets/css/tabs.css" />-->
<!-- main content area -->   
<div id="main" class="wrapper dashboard"> 
	
    <!-- content area -->    
	<section id="content">
	<p>&nbsp;</p>
	 <center>
	 <img src="./assets/images/Achtung.gif"><h1>Under constructon</h1>
	 <div>We are working on this service. Please try some time later.</div>
       </center>
    </section><!-- #end content area -->
      
    <!-- sidebar -->    
	 <? include("./includes/loginmenu.php"); ?>
    <!-- #end sidebar -->
   
  </div><!-- #end div #main .wrapper -->

<!-- footer area -->    
<? include("./includes/footer.php"); ?>
<!-- #end footer area --> 

<? include("./includes/footerinclude.php"); ?>
</body>
</html>