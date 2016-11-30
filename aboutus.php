<?php
include_once("./config/config.php");
/***
 * initial setup
 */
$pagename = 'aboutus';
$subname = 'aboutus';

include("./functions/cms.php");
$cms = new cms();
$aboutus=$cms->getcms(1,'aboutus');

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
	<h1>About Us</h1>
    </div>

</section>

<!-- main content area -->   
<div id="main" class="wrapper register"> 
	
    
	<!-- content area -->    
	<section id="content">

          <div class="row-fluid">
		  <div class="pull-left">
		  <p>
		  
		  <?=html_entity_decode($aboutus)?>
		  </p>
		  </div>
		  </div>	

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