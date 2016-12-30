<?php
include_once("./config/config.php");
/***
 * initial setup
 */
$pagename = 'allads';
$subname = 'allads';

$login = check_login();
if($login === false) {
	redirect(HTTP_PATH . 'login.php');
}

include("./functions/ads.php");
$ads = new ads;


$Adstext = $ads->getAdlist("text");
$Adsscroll = $ads->getAdlist("scroll");
$Adsvideo = $ads->getAdlist("video");
$Adsimage = $ads->getAdlist("image");


if((isset($_REQUEST['action'])) && ($_REQUEST['action']=='_add_findlocation'))
{
$zipcode=trim($_REQUEST['zipcode']);
$val = getLnt($zipcode);

$_SESSION['lat']=$val['lat'];
$_SESSION['lng']=$val['lng'];

 //echo "Latitude: ".$_SESSION['lat']."<br>";
 //echo "Longitude: ".$_SESSION['lng']."<br>"; exit;
}
 function getLnt($zip){
$url = "http://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($zip)."&sensor=false";
//$result_string = file_get_contents($url);
$ch = curl_init();
// Disable SSL verification
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($ch, CURLOPT_URL,$url);
// Execute
$result_string=curl_exec($ch);
// Closing
curl_close($ch);
//$output=json_decode($result, true);
//$result_string = file_get_contents($url);
$result = json_decode($result_string, true);
$result1[]=$result['results'][0];
$result2[]=$result1[0]['geometry'];
$result3[]=$result2[0]['location'];
return $result3[0];
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
    <a href="#">Text Ads</a>
    </div>
  <div style="margin-bottom:70px;">&nbsp;</div>
   <div class="grid_12 no-padding" style="overflow-y:scroll;height:175px">
  <?php if(empty($Adstext)) { ?>
  <div class="alertmsgads">
  No text ads to show here ...
  </div>
	 <?php } foreach($Adstext as $text) { ?>
	  <div class="grid_4" style="margin-bottom: 30px;" >
	   <a href="viewads.php?id=<?=$text['id']?>">
	   <div class="viewadlistbox">
	      <div class="adnamebox"><?=substr($text['name'],0,20)?></div>
		  <div class="adcountboxcss"><?=$text['amount']?></div>
	   </div>
	   </a>
     </div>
	 <?php } ?>
	  
	</div> 
	 
	  </div>
	  
	  
   </div>
      
	    <div class="grid_12 no-padding">
	  <div class="adsbox">

     <div class="ribbon" >
    <a href="#">Image Ads</a>
    </div>
  <div style="margin-bottom:70px;">&nbsp;</div>
   <div class="grid_12 no-padding" style="overflow-y:scroll;height:175px">
  <?php if(empty($Adsimage)) { ?>
  <div class="alertmsgads">
  No image ads to show here ...
  </div>
	 <?php } foreach($Adsimage as $text) { ?>
	  <div class="grid_4" style="margin-bottom: 30px;" >
	   <div class="viewadlistbox">
	      <div class="adnamebox"><?=substr($text['name'],0,20)?></div>
		  <div class="adcountboxcss"><?=$text['amount']?></div>
	   </div>
     </div>
	 <?php } ?>
	  
	</div> 
	 
	  </div>
	  
	  
   </div>
     
	 
	   <div class="grid_12 no-padding">
	  <div class="adsbox">

     <div class="ribbon" >
    <a href="#">Scroll Ads</a>
    </div>
  <div style="margin-bottom:70px;">&nbsp;</div>
   <div class="grid_12 no-padding" style="overflow-y:scroll;height:175px">
  <?php if(empty($Adsscroll)) { ?>
  <div class="alertmsgads">
  No scroll ads to show here ...
  </div>
	 <?php } foreach($Adsscroll as $text) { ?>
	  <div class="grid_4" style="margin-bottom: 30px;" >
	   <div class="viewadlistbox">
	      <div class="adnamebox"><?=substr($text['name'],0,20)?></div>
		  <div class="adcountboxcss"><?=$text['amount']?></div>
	   </div>
     </div>
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
   <div class="grid_12 no-padding" style="overflow-y:scroll;height:175px">
  <?php if(empty($Adsvideo)) { ?>
  <div class="alertmsgads">
  No video ads to show here ...
  </div>
	 <?php } foreach($Adsvideo as $text) { ?>
	  <div class="grid_4" style="margin-bottom: 30px;" >
	   <div class="viewadlistbox">
	      <div class="adnamebox"><?=substr($text['name'],0,20)?></div>
		  <div class="adcountboxcss"><?=$text['amount']?></div>
	   </div>
     </div>
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

</script>

 <style>
 
 
        #alertmsg
		{
			color:red;
			text-align:center;
			font-size:13px;
		}
 
		.modal-backdrop {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 1040;
  background-color: #000000;
}

.modal-backdrop.fade {
  opacity: 0;
}

.modal-backdrop,
.modal-backdrop.fade.in {
  opacity: 0.8;
  filter: alpha(opacity=80);
}

.modal {
  position: fixed;
  top: 10%;
  left: 50%;
  z-index: 1050;
  width: 560px;
  margin-left: -280px;
  background-color: #ffffff;
  border: 1px solid #999;
  border: 1px solid rgba(0, 0, 0, 0.3);
  *border: 1px solid #999;
  -webkit-border-radius: 6px;
     -moz-border-radius: 6px;
          border-radius: 6px;
  outline: none;
  -webkit-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
     -moz-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
          box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
  -webkit-background-clip: padding-box;
     -moz-background-clip: padding-box;
          background-clip: padding-box;
}

.modal.fade {
  top: -25%;
  -webkit-transition: opacity 0.3s linear, top 0.3s ease-out;
     -moz-transition: opacity 0.3s linear, top 0.3s ease-out;
       -o-transition: opacity 0.3s linear, top 0.3s ease-out;
          transition: opacity 0.3s linear, top 0.3s ease-out;
}

.modal.fade.in {
  top: 10%;
}

.modal-header {
  padding: 9px 15px;
  border-bottom: 1px solid #eee;
}

.modal-header .close {
  margin-top: 2px;
}

.modal-header h3 {
  margin: 0;
  line-height: 30px;
}

.modal-body {
  position: relative;
  max-height: 400px;
  padding: 5px;
  overflow-y: auto;
}

.modal-form {
  margin-bottom: 0;
}

.modal-footer {
  padding: 14px 15px 15px;
  margin-bottom: 0;
  text-align: right;
  background-color: #f5f5f5;
  border-top: 1px solid #ddd;
  -webkit-border-radius: 0 0 6px 6px;
     -moz-border-radius: 0 0 6px 6px;
          border-radius: 0 0 6px 6px;
  *zoom: 1;
  -webkit-box-shadow: inset 0 1px 0 #ffffff;
     -moz-box-shadow: inset 0 1px 0 #ffffff;
          box-shadow: inset 0 1px 0 #ffffff;
}

.modal-footer:before,
.modal-footer:after {
  display: table;
  line-height: 0;
  content: "";
}

.modal-footer:after {
  clear: both;
}

.modal-footer .btn + .btn {
  margin-bottom: 0;
  margin-left: 5px;
}

.modal-footer .btn-group .btn + .btn {
  margin-left: -1px;
}

.modal-footer .btn-block + .btn-block {
  margin-left: 0;
}
	</style>

</body>
</html>