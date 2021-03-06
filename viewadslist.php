<?php
include_once("./config/config.php");
/***
 * initial setup
 */
$pagename = 'viewads';
$subname = 'allads';

$login = check_login();
if($login === false) {
	redirect(HTTP_PATH . 'login.php');
}

include("./functions/ads.php");
$ads = new ads;

if($_SESSION['roo']['user']['demo'] == 1) {
   // $currentAd = $ads->getDemoAd(false);
$Adstext = $ads->getdemoAdlist("text");
$Adsscroll = $ads->getdemoAdlist("scroll");
$Adsvideo = $ads->getdemoAdlist("video");
$Adsimage = $ads->getdemoAdlist("image");	
	
} else {
$Adstext = $ads->getAdlist("text");
$Adsscroll = $ads->getAdlist("scroll");
$Adsvideo = $ads->getAdlist("video");
$Adsimage = $ads->getAdlist("image");
}





//session_destroy();
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<? include("./includes/head.php"); ?>
<link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="./assets/css/viewads.css" />
</head>

<body id="home">
  
	<!-- header area -->
	<? include("./includes/header.php"); ?>
    <!-- end header -->
 
 <? include("./includes/head-wrap.php"); ?>

<!-- main content area -->   
<div id="main" class="wrapper viewads"> 
	
	<!-- content area -->    
	<section>
    
    <div id="content">
   <div class="grid_12 no-padding" >
      <div class="grid_12 no-padding">
	  <div class="adsbox">

     <div class="ribbon" >
    <a href="#">Image Ads</a>
    </div>
  <div style="margin-bottom:70px;">&nbsp;</div>
   <div class="grid_12 no-padding" style="overflow-y:auto;height:175px">
  <?php if(empty($Adstext) && empty($Adsimage)) { ?>
  <div class="alertmsgads">
  No ads to show here ...
  </div>
	 <?php } foreach($Adstext as $text) { ?>
	  <div class="grid_4" style="margin-bottom: 30px;" >
	   <a href="viewads.php?id=<?=$text['id']?>&type=text">
	   <div class="viewadlistbox">
	      <div class="adnamebox"><?=substr($text['name'],0,20)?></div>
		  <div class="adcountboxcss"><?=$text['amount']?></div>
	   </div>
	   </a>
     </div>
	 <?php } foreach($Adsimage as $text) { ?>
	 <a href="viewads.php?id=<?=$text['id']?>&type=image">
	  <div class="grid_4" style="margin-bottom: 30px;" >
	   <div class="viewadlistbox">
	      <div class="adnamebox"><?=substr($text['name'],0,20)?></div>
		  <div class="adcountboxcss"><?=$text['amount']?></div>
	   </div>
     </div>
	 </a>
	 <?php } ?>
	  
	</div> 
	 
	  </div>
	  
	  
   </div>
      
	   <div class="grid_12 no-padding">
	  <div class="adsbox">

     <div class="ribbon" >
    <a href="#">Animation & Scroll Ads</a>
    </div>
  <div style="margin-bottom:70px;">&nbsp;</div>
   <div class="grid_12 no-padding" style="overflow-y:auto;height:175px">
  <?php if(empty($Adsscroll)) { ?>
  <div class="alertmsgads">
  No premium ads to show here ...
  </div>
	 <?php } foreach($Adsscroll as $text) { ?>
	 <a href="viewads.php?id=<?=$text['id']?>&type=scroll">
	  <div class="grid_4" style="margin-bottom: 30px;" >
	   <div class="viewadlistbox">
	      <div class="adnamebox"><?=substr($text['name'],0,20)?></div>
		  <div class="adcountboxcss"><?=$text['amount']?></div>
	   </div>
     </div>
	 </a>
	 <?php } ?>
	  
	</div> 
	 
	  </div>
	  
	  
   </div>
     
	   <div class="grid_12 no-padding">
	  <div class="adsbox">

     <div class="ribbon" >
    <a href="#">Video Ads</a>
    </div>
  <div style="margin-bottom:70px;">&nbsp;</div>
   <div class="grid_12 no-padding" style="overflow-y:auto;height:175px">
  <?php if(empty($Adsvideo)) { ?>
  <div class="alertmsgads">
  No deluxe ads to show here ...
  </div>
	 <?php } foreach($Adsvideo as $text) { ?>
	 <a href="viewads.php?id=<?=$text['id']?>&type=video">
	  <div class="grid_4" style="margin-bottom: 30px;" >
	   <div class="viewadlistbox">
	      <div class="adnamebox"><?=substr($text['name'],0,20)?></div>
		  <div class="adcountboxcss"><?=$text['amount']?></div>
	   </div>
     </div>
	 </a>
	 <?php } ?>
	  
	</div> 
	 
	  </div>
	  
	  
   </div>
     
    </div>
    </section>
    <!-- #end content area -->
      
      
    <!-- sidebar -->    
    <? include("./includes/loginmenu.php"); ?>
    <!-- #end sidebar -->
    <div class="clearfix"></div>
  </div><!-- #end div #main .wrapper -->
<!-- footer area -->    
<? include("./includes/footer.php"); ?>
<!-- #end footer area --> 

<? include("./includes/footerinclude.php"); ?>

<!--<script src="./assets/js/jquery-canvas-sparkles.js"></script>-->


</body>
</html>