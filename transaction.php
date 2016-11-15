<?php
include_once("./config/config.php");
/***
 * initial setup
 */
$pagename = 'myprofile';
$subname = 'transaction';

$login = check_login();
if($login === false) {
	redirect(HTTP_PATH . 'login.php');
}

include("./functions/user.php");
$user = new user;

$database = $user->dashboard(0);
$trans = $user->transactions(0);

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
<div id="main" class="wrapper transaction"> 
	
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
        	<h3>Last 10 transaction of your account:</h3>
            
        	<table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Date/Time</th>
                  <th>Remark</th>
                  <th>Type</th>
                  <th>Amount</th>
                </tr>
              </thead>
              <tbody>
              	<? if(empty($trans)) { ?>
                
                <? } else { 
					$i=1;
					foreach($trans as $data) {
				?>
                <tr>
                  <th scope="row"><?=$i?></th>
                  <td><?=date('d, M Y h:i:s A',strtotime($data['date_added']))?></td>
                  <td><?=$data['detail']?></td>
                  <td><?=strtoupper($data['type'])?></td>
                  <td><i class="fa fa-inr" aria-hidden="true"></i> <?=$data['amount']?>/-</td>
                </tr>
                <? $i++; } } ?>
              </tbody>
            </table>
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