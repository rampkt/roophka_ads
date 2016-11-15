<?php
include_once("./config/config.php");
/***
 * initial setup
 */
$pagename = 'register';
$subname = 'register';

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
	<h1>Register Confirmation</h1>
    </div>

</section>

<? if($_REQUEST['verify'] == 1) { ?>
<!-- main content area -->   
<div id="main" class="wrapper register"> 
    
    <!-- content area -->    
    <section id="content">
        <center>
            <h2>REGISTRATION COMPLETED!!!</h2>
            <p>Still one step to complete the registration. Please verify your email and then login to proceed furthur.</p>
            <p>Please check your inbox or spam folder in your mail client.</p>
        </center>
    </section><!-- #end content area -->
      
      
    <!-- sidebar -->    
    <aside>
        <h2>Secondary Section menu</h2>
            <nav id="secondary-navigation">
                    <ul>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">How it works</a></li>
                    </ul>
             </nav>
      </aside><!-- #end sidebar -->
   
  </div><!-- #end div #main .wrapper -->

<? } else { ?>
<!-- main content area -->   
<div id="main" class="wrapper register"> 
    
	<!-- content area -->    
	<section id="content">
    	<center>
        	<h2>REGISTRATION COMPLETED!!!</h2>
            <p>Please login to proceed furthur...</p>
        </center>
    </section><!-- #end content area -->
      
      
    <!-- sidebar -->    
    <aside>
        <h2>Secondary Section menu</h2>
            <nav id="secondary-navigation">
                    <ul>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">How it works</a></li>
                    </ul>
             </nav>
      </aside><!-- #end sidebar -->
   
  </div><!-- #end div #main .wrapper -->

  <? } ?>

<!-- footer area -->    
<? include("./includes/footer.php"); ?>
<!-- #end footer area --> 

<? include("./includes/footerinclude.php"); ?>

</body>
</html>