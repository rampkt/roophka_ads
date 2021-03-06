<?php
include_once("./config/config.php");
/***
 * initial setup
 */
$pagename = 'plans';
$subname = 'plans';

include("./functions/ads.php");
$ads = new ads;


$Adstext = $ads->getplanlist("text");
$Adsscroll = $ads->getplanlist("scroll");
$Adsvideo = $ads->getplanlist("video");
$Adsimage = $ads->getplanlist("image");


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
 <section id="page-header" class="clearfix">    
<!-- responsive FlexSlider image slideshow -->
<div class="wrapper">
	<h1>Advertisement Plan Details</h1>
    </div>

</section>
<!-- main content area -->   
<div id="main" class="wrapper viewads"> 
	
	<!-- content area -->    
	<section>
    
    <div id="content">
   <div class="grid_12 no-padding" >
      <div class="grid_12 no-padding">
	  <div class="adsbox" style="margin-bottom:30px;">

     <div class="ribbon" >
    <a href="#">Image Ads</a>
    </div>
  <div style="margin-bottom:70px;">&nbsp;</div>
   <div class="grid_12 no-padding">
  
	 <div class="grid_12" style="margin-bottom: 30px;" >
  <table cellpadding='7' cellspacing='7' style="border:1px solid #0099ff;font-size:13px;text-align:center;width:100%;">
  <tr style="background-color:#0099ff;color:#FFF;height:30px;">
  <th style="text-align:center;border-right:1px solid #ccc;">S.No</th>
  <th style="text-align:center;border-right:1px solid #ccc;">Duration (sec)</th>
  <th style="text-align:center;border-right:1px solid #ccc;">Amount (Per Month)</th>
  <!--<th style="text-align:center;">Viewers</th>-->
  </tr>
  
  <?php if(empty($Adsimage)) { ?>
  <tr>
  <td colspan="4">
  <div class="alertmsgads">
  No Plans to show here ...
  </div>
  </td>
  </tr>
	 <?php } 
	 ?>
  <?php
	 
	 $i=1;
	 foreach($Adsimage as $image) { ?>
	  
	   
	  <tr style="border:1px solid #ccc;">
  <td style="border-right:1px solid #ccc;"><?=$i?></td>
  <td style="border-right:1px solid #ccc;"><?=$image['to_sec']?></td>
  <td style="border-right:1px solid #ccc;"><?=$image['amount']?></td>
  <!--<td><?=$image['viewers']?></td>-->
  </tr>
     
	 <?php $i++;}?> 
	 </table>
	 
	</div> 
	 
	  </div>
	  
	   
    </div>
 <div class="adsbox" style="margin-bottom:30px;">

     <div class="ribbon" >
    <a href="#">Animation & Scroll Ads</a>
    </div>
  <div style="margin-bottom:70px;">&nbsp;</div>
   <div class="grid_12 no-padding">
 
	 <div class="grid_12" style="margin-bottom: 30px;" >
  <table cellpadding='7' cellspacing='7' style="border:1px solid #0099ff;font-size:13px;text-align:center;width:100%;">
  <tr style="background-color:#0099ff;color:#FFF;height:30px;">
  <th style="text-align:center;border-right:1px solid #ccc;">S.No</th>
   <th style="text-align:center;border-right:1px solid #ccc;">Duration (Sec)</th>
  <th style="text-align:center;border-right:1px solid #ccc;">Amount (Per Month)</th>
  <!--<th style="text-align:center;">Viewers</th>-->
  </tr>
  <?php if(empty($Adsscroll)) { ?>
  <tr>
  <td colspan="3">
  <div class="alertmsgads">
  No Plans to show here ...
  </div>
  </td>
  </tr>
	 <?php } 
	 ?>
  <?php
	 
	 $i=1;
	 foreach($Adsscroll as $image) { ?>
	  
	   
	  <tr style="border:1px solid #ccc;">
  <td style="border-right:1px solid #ccc;"><?=$i?></td>
  <td style="border-right:1px solid #ccc;"><?=$image['to_sec']?></td>
  <td style="border-right:1px solid #ccc;"><?=$image['amount']?></td>
  <!--<td><?=$image['viewers']?></td>-->
  </tr>
     
	 <?php $i++;}?> 
	 </table>
	 
	</div> 
	 
	  </div>
	  
	   
    </div>
      
<div class="adsbox2">

     <div class="ribbon" >
    <a href="#">Video Ads </a>
    </div>
  <div style="margin-bottom:70px;">&nbsp;</div>
   <div class="grid_12 no-padding">
  
	 <div class="grid_12" style="margin-bottom: 30px;" >
  <table cellpadding='7' cellspacing='7' style="border:1px solid #0099ff;font-size:13px;text-align:center;width:100%;">
  <tr style="background-color:#0099ff;color:#FFF;height:30px;">
  <th style="text-align:center;border-right:1px solid #ccc;">S.No</th>
  <th style="text-align:center;border-right:1px solid #ccc;">Duration (Sec)</th>
  <th style="text-align:center;border-right:1px solid #ccc;">Amount (Per Month)</th>
  <!--<th style="text-align:center;">Viewers</th>-->
  </tr>
  <?php if(empty($Adsvideo)) { ?>
  <tr>
  <td colspan="3">
  <div class="alertmsgads">
  No Plans to show here ...
  </div>
  </td>
  </tr>
	 <?php } 
	 ?>
  
  <?php
	 
	 $i=1;
	 foreach($Adsvideo as $image) { ?>
	  
	   
	  <tr style="border:1px solid #ccc;">
  <td style="border-right:1px solid #ccc;"><?=$i?></td>
  <td style="border-right:1px solid #ccc;"><?=$image['to_sec']?></td>
  <td style="border-right:1px solid #ccc;"><?=$image['amount']?></td>
  <!--<td><?=$image['viewers']?></td>-->
  </tr>
     
	 <?php $i++;}?> 
	 </table>
	 
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