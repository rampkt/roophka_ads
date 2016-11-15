<?php
include_once("./config/config.php");
/***
 * initial setup
 */
$pagename = '';
$subname = '';

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<? include("./includes/head.php"); ?>
<link type="text/css" rel="stylesheet" href="./assets/css/registration.css" />
</head>

<body id="home">
  
	<!-- header area -->
	<? include("./includes/header.php"); ?>
    <!-- end header -->
 
 
<section id="page-header" class="clearfix">    
<!-- responsive FlexSlider image slideshow -->
<div class="wrapper">
	<!--<h1>404 Page Not found....</h1>-->
    </div>

</section>

<!-- main content area -->   
<div id="main" class="wrapper register"> 
	<? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == '1') { ?>
    <div class="error-msg"><strong>Login failed!</strong> username and password shouldn't empty.</div>
    <? } ?>
    
    <? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == '2') { ?>
    <div class="error-msg"><strong>Login failed!</strong> username or password mismatch.</div>
    <? } ?>
    
    <? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == '3') { ?>
    <div class="error-msg"><strong>Login failed!</strong> Your account has been blocked, Contact admin.</div>
    <? } ?>
    
	<!-- content area -->    
	<section id="content">
    	<a href="http://www.roophka.com"><img src="./assets/img/404-Error-new.png" width="100%" /></a>
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