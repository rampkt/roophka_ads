<?php
include_once("./config/config.php");
/***
 * initial setup
 */
$pagename = 'dashboard'; 
$subname = '';

$login = check_login();
if($login === false) {
	redirect(HTTP_PATH . 'login.php');
}

include("./functions/user.php");
include("./functions/ads.php");
$user = new user;
$ads = new ads;

$ads->resetAd();
$database = $user->dashboard();

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
 
 
<? include("./includes/head-wrap.php"); ?>

<!-- main content area -->   
<div id="main" class="wrapper dashboard"> 
	
    <!-- content area -->    
	<section id="content">
    	
        <div class="grid_3 no-padding">
            <div class="panel panel-primary">
              <div class="panel-heading">Total Ads Viewed</div>
              <div class="panel-body"><?=$database['total_ads']?></div>
            </div>
        </div>
        
        <div class="grid_3 no-padding">
            <div class="panel panel-primary">
              <div class="panel-heading">Total Amount</div>
              <div class="panel-body"><i class="fa fa-inr" aria-hidden="true"></i> <?=$database['total_amount']?></div>
            </div>
        </div>
        
        <div class="grid_3 no-padding">
            <div class="panel panel-primary">
              <div class="panel-heading">Today viewed Ads</div>
              <div class="panel-body"><?=$database['today_ads']?></div>
            </div>
        </div>
        
        <!--<div class="panel panel-primary">
          <div class="panel-heading">Today Earned Amount</div>
          <div class="panel-body"><i class="fa fa-inr" aria-hidden="true"></i> <?=$database['today_amount']?></div>
        </div>-->
        
        <div class="grid_3 no-padding">
            <div class="panel panel-primary">
              <div class="panel-heading">Remining Ads Today</div>
              <div class="panel-body"><?=$database['remaining_ads']?></div>
            </div>
        </div>
        
        <div class="grid_12">
        	<h4>User account summary:</h4>
        	<ol>
            	<li>Last login : <?=$_SESSION['roo']['user']['lastlogin']?></li>
                <li>Total ads viwed so far : <?=$database['total_ads']?></li>
                <li>Total amount earned so far : <i class="fa fa-inr" aria-hidden="true"></i> <?=$database['total_amount']?></li>
                <li>Total amount withdrawn : <i class="fa fa-inr" aria-hidden="true"></i> <?=$database['withdraw_amount']?></li>
            </ol>
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