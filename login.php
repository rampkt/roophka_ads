<?php
include_once("./config/config.php");
/***
 * initial setup
 */
$pagename = 'login';
$subname = 'login';
//echo $_SESSION['recharge_mobile'];
$login = check_login();
if($login === true) {
	
	if(isset($_SESSION['recharge_mobile']))
	{
		redirect(HTTP_PATH . 'recharge_proceed.php');
	}
	else
	{
	redirect(HTTP_PATH . 'dashboard.php');
	}
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
	<h1>Login</h1>
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
    	<form class="form-horizontal" action='userlogin.php' name="login" method="POST" data-parsley-validate="">
          <fieldset>
            <div class="control-group">
              <!-- Username -->
              <span class="pull-right" id="name-error"></span>
              <label class="control-label"  for="name">Email</label>
              <div class="controls">
                <input type="email" id="username" name="username" placeholder="" class="form-control input-lg" required data-parsley-errors-container="#name-error" />
              </div>
            </div>
         	<div class="clearfix"></div><br>
            
            <div class="control-group">
              <!-- E-mail -->
              <span class="pull-right" id="email-error"></span>
              <label class="control-label" for="email">Password</label>
              <div class="controls">
                <input type="password" id="password" name="password" placeholder="" class="form-control input-lg" required data-parsley-errors-container="#email-error" />
                <p class="help-block">&nbsp;</p>
              </div>
            </div>
			
			<div class="control-group">
			<div class="pull-left">
			<a href="forgot_password.php">Forgot Password ?</a>
			</div>
			<div class="pull-left">
			<a href="register.php"> &nbsp;Register Now</a>
			</div>
			</div>
           <div class="clearfix"></div><br>
			
            <div class="control-group">
              <!-- Button -->
              <div class="controls">
                <button type="submit" name="action" value="dologin" class="btn btn-success">Login</button>
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