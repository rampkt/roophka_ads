<?php
include_once("./config/config.php");
/***
 * initial setup
 */
$pagename = 'Forgot Password';
$subname = 'forgot';

$login = check_login();
if($login === true) {
	redirect(HTTP_PATH . 'dashboard.php');
}
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
	<h1>Forgot Password</h1>
    </div>

</section>

<!-- main content area -->   
<div id="main" class="wrapper register"> 
	<? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == '1') { ?>
    <div class="error-msg"><strong> Failed!</strong> email shouldn't empty.</div>
    <? } ?>
    
    <? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == '2') { ?>
    <div class="error-msg"><strong>Failed!</strong> email is mismatch.</div>
    <? } ?>
    
    <? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == '3') { ?>
    <div class="error-msg"><strong>Failed!</strong> Your account has been blocked, Contact admin.</div>
    <? } ?>
    
	<? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '1') { ?>
    <div class="success-msg"><strong>Success!</strong> Please check your email and click link to reset your password.</div>
    <? } ?>
	
	<!-- content area -->    
	<section id="content">
    	<form class="form-horizontal" action='userlogin.php' name="login" method="POST" data-parsley-validate="">
          <fieldset>
            <div class="control-group">
              <!-- Username -->
              <span class="pull-right" id="name-error"></span>
              <label class="control-label"  for="name">Email</label>
              <div class="controls">
                <input type="email" id="username" name="username" placeholder="Please enter your email address here ..." class="form-control input-lg" required data-parsley-errors-container="#name-error" />
              </div>
            </div>
         	<div class="clearfix"></div><br>
            
			<div class="control-group">
			<div class="pull-left">
			<a href="login.php">Login ?</a>
			</div>
			<div class="pull-left">
			<a href="register.php">&nbsp;Register Now</a>
			</div>
			</div>
           <div class="clearfix"></div><br>
		   
		   
            <div class="control-group">
              <!-- Button -->
              <div class="controls">
                <button type="submit" name="action" value="forgotpass" class="btn btn-success">Submit</button>
              </div>
            </div>
          </fieldset>
        </form>
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