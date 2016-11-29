<?php
include_once("./config/config.php");

/***
 * initial setup
 */
$pagename = 'home';
$subname = '';

include("./functions/ads.php");
$ads = new ads();

$sliderAds = $ads->getHomeSliderAd();
if((isset($_REQUEST['action'])) && ($_REQUEST['action']=='_add_findlocation'))
{
	$zipcode=$_REQUEST['zipcode'];
$val = getLnt($zipcode);

$_SESSION['lat']=$val['lat'];
$_SESSION['lng']=$val['lng'];

 echo "Latitude: ".$_SESSION['lat']."<br>";
 echo "Longitude: ".$_SESSION['lng']."<br>"; exit;
}
echo "Latitude: ".$_SESSION['lat']."<br>";
echo "Longitude: ".$_SESSION['lng']."<br>"; 
 function getLnt($zip){
$url = "http://maps.googleapis.com/maps/api/geocode/json?address=
".urlencode($zip)."&sensor=false";
$result_string = file_get_contents($url);
$result = json_decode($result_string, true);
$result1[]=$result['results'][0];
$result2[]=$result1[0]['geometry'];
$result3[]=$result2[0]['location'];
return $result3[0];
}
 
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<? include("./includes/head.php"); ?>
</head>

<body id="home">
  
	<!-- header area -->
	<? include("./includes/header.php"); ?>
    <!-- end header -->
 
 
<!-- hero area (the grey one with a slider -->
    <section id="hero" class="clearfix">    
    <!-- responsive FlexSlider image slideshow -->
    <div class="wrapper">
       <div class="row"> 
        <div class="grid_5">
            <h1>Earn while you browse</h1>
            <p>Earn money while you browse. No age will stop your earning. Just sit in home and earn money. As well you can get your need also in here. We just not advertise the product. It was also your daily need and best of that.
            </p>
            <p>No more retirement are need work on hours. just stay where you are and make money for your internet...
            </p>
            <p><a href="#" class="buttonlink">Read More</a> <a href="#" class="buttonlink">How it works</a></p>
        </div>
        <div class="grid_7 rightfloat">
              <div class="flexslider">
                  <ul class="slides">
                  <? if(empty($sliderAds)) { ?>
                      <li>
                          <img src="./assets/img/banners/banner.jpg" />
                          <p class="flex-caption">Welcome to online earning</p>
                      </li>
                      <li>
                          <img src="./assets/img/banners/banner1.jpg" />
                          <p class="flex-caption">Detailed dashboard</p>
                      </li>
                      <li>
                          <img src="./assets/img/banners/banner2.jpg" />
                          <p class="flex-caption">Account balance on every page.</p>
                      </li>
                      <li>
                          <img src="./assets/img/banners/banner3.jpg" />
                          <p class="flex-caption">Withdraw your earnings easily.</p>
                      </li>
                      <li>
                          <img src="./assets/img/banners/banner4.jpg" />
                          <p class="flex-caption">Your transactions for your earning.</p>
                      </li>
                      <li>
                          <img src="./assets/img/banners/banner5.jpg" />
                          <p class="flex-caption">Very simple step for earning.</p>
                      </li>
                  <? } else { ?>
                  	  <? foreach($sliderAds as $ads) { ?>
                  	  <li>
                          <div style="background-color:black;">
                              <video class="slidervideo" src="<?=$ads['content']?>" width="680" height="283" poster="<?=HTTP_PATH?>assets/img/icons/play-btn.png"></video>
                          </div>
                          <p class="flex-caption"><?=$ads['name']?></p>
                      </li>
                      <? } ?>
                  <? } ?>
                  </ul>
                </div><!-- FlexSlider -->
              </div><!-- end grid_7 -->
        </div><!-- end row -->
       </div><!-- end wrapper -->
    </section><!-- end hero area -->





<!-- main content area -->   
<div id="main" class="wrapper">
    
    
<!-- content area -->    
	<section id="content" class="wide-content">
      <div class="row">	
        <div class="grid_4">
        	<h2 class="first-header text-primary" align="center">-- Place your ad here --</h2>
            <img src="./assets/img/business-380x150.png" />
            <p>Detail about your ad here. We place your ad in home page to get know about your product. And make femilier to all user who vist to our site. Also your external site link also redirected when clicked the banner. please contact our sale department for futher clarification. Please be the first one to view the ads here.</p>
        </div>
        
        <div class="grid_4">
        	<h2 class="first-header text-primary" align="center">-- Place your ad here --</h2>
            <img src="./assets/img/business-380x150.png" />
            <p>Detail about your ad here. We place your ad in home page to get know about your product. And make femilier to all user who vist to our site. Also your external site link also redirected when clicked the banner. please contact our sale department for futher clarification. Please be the first one to view the ads here.</p>
        </div>
        
        <div class="grid_4">
        	<h2 class="first-header text-primary" align="center">-- Place your ad here --</h2>
            <img src="./assets/img/business-380x150.png" />
            <p>Detail about your ad here. We place your ad in home page to get know about your product. And make femilier to all user who vist to our site. Also your external site link also redirected when clicked the banner. please contact our sale department for futher clarification. Please be the first one to view the ads here.</p>
        </div>
	  </div><!-- end row -->
      <div class="row">	
        <div class="grid_4">
        	<h2 class="first-header text-primary" align="center">-- Place your ad here --</h2>
            <img src="./assets/img/business-380x150.png" />
            <p>Detail about your ad here. We place your ad in home page to get know about your product. And make femilier to all user who vist to our site. Also your external site link also redirected when clicked the banner. please contact our sale department for futher clarification. Please be the first one to view the ads here.</p>
        </div>
        
        <div class="grid_4">
        	<h2 class="first-header text-primary" align="center">-- Place your ad here --</h2>
            <img src="./assets/img/business-380x150.png" />
            <p>Detail about your ad here. We place your ad in home page to get know about your product. And make femilier to all user who vist to our site. Also your external site link also redirected when clicked the banner. please contact our sale department for futher clarification. Please be the first one to view the ads here.</p>
        </div>
        
        <div class="grid_4">
        	<h2 class="first-header text-primary" align="center">-- Place your ad here --</h2>
            <img src="./assets/img/business-380x150.png" />
            <p>Detail about your ad here. We place your ad in home page to get know about your product. And make femilier to all user who vist to our site. Also your external site link also redirected when clicked the banner. please contact our sale department for futher clarification. Please be the first one to view the ads here.</p>
        </div>
	  </div><!-- end row -->
	</section><!-- end content area -->   
      
  </div><!-- #end div #main .wrapper -->
  
	<div id="light" class="white_content"> <a href = "javascript:void(0)" onclick = "locationaddfn(2);"><button type="button" class="close" data-dismiss="modal">x</button></a>
		<div style="border-bottom:2px solid #ccc;width100%;margin:5px;"><h2>Add Your Location</h2></div>
		<div id="alertmsg">Must be allow your location or enter your zipcode,then only you can view ads !!! </div>
		<form action="index.php" method="post">
		<input type="hidden" name="action" value="_add_findlocation">
		<div class="row-fluid" style="margin-top:20px;">
		<div class="pull-left" style="margin-right:10px;margin-top:10px;">Enter your zipcode :</div>
		<div class="pull-left">
		<input type="text" name="zipcode" id="zipcode" class="form-control " maxlength="6" placeholder="Enter zipcode here..." required>
		</div>
		<div class="pull-left"  style="margin-top:3px;margin-left:20px;">
		<input type="submit" name="submit" id="submit" value="submit" style="padding:5px 15px;" class="btn btn-small btn-primary add-new">
		</div>
		<div class="clearfix" style="margin-bottom:10px;"></div>
		</div>
		
		<div>(or)</div>
		
		<div class="row-fluid" style="margin-top:20px;">
		<div class="pull-left" style="margin-right:20px;margin-top:10px;"> Share your location</div>
		<div class="pull-left">
		<a href="javascript:void(0);" class="btn btn-primary" onclick="findlocation();">Find Location</a>
		</div>
		<div class="clearfix" style="margin-bottom:10px;"></div>
		</div>
		
		
		
		</form>
		<div></div>
		</div>
		<div id="fade" class="black_overlay"></div>

<!-- footer area -->    
<? include("./includes/footer.php"); ?>
<!-- #end footer area --> 

<? include("./includes/footerinclude.php"); ?>
<script>
var latval="<?php if(isset($_SESSION['lat'])) { echo $_SESSION['lat']; }else{ echo "";} ?>";
var lngval="<?php if(isset($_SESSION['lng'])) { echo $_SESSION['lng']; }else{ echo "";} ?>";
 function locationaddfn(val)
  {
	  //alert("adad");
	  if(val==1)
	  {
	  document.getElementById('light').style.display='block';
	  document.getElementById('fade').style.display='block';
	  }
	  
	   if(val==2)
	  {
	  document.getElementById('light').style.display='none';
	  document.getElementById('fade').style.display='none';
	  }
	  
	  
  }
  
  
  $( document ).ready(function() {
   // alert( "ready!" );
   if((latval=="")&&(lngval==""))
   {
	   locationaddfn(1);
   }else{

	locationaddfn(2);
   }
});
   
  
   
  function findlocation(){
	  
	  
navigator.geolocation.getCurrentPosition(function(position) {
	document.getElementById('light').style.display='none';
	  document.getElementById('fade').style.display='none';
	  findlocationvalue(position);
	  
    //alert('allow');
}, function() {
	//location.reload(true);
   $('#alertmsg').html('You blocked your share location, so clear cache and then try !!! ');
});

}
 
function findlocationvalue(position) {
	//alert("ada");
	x=position.coords.latitude;
    y=position.coords.longitude;
	//console.log(x);
	//$('.overlay').fadeIn();
	var params = { action : '_findlocation',lat:x, lng:y}
	$.ajax({
		url:"user_ajax.php",
		type:'POST',
		dataType:"JSON",
		data:params,
		success: function(result) {
			//$('.overlay').fadeOut();
			console.log(result);
			if(result.error) {
				
			} else {
			
			}
		}
	});
}
 
</script>

 <style>
        #alertmsg
		{
			color:red;
			text-align:center;
			font-size:13px;
		}
 
		.black_overlay{
			display: none;
			position: fixed;
			top: 0%;
			left: 0%;
			width: 100%;
			height: 100%;
			background-color: black;
			z-index:1001;
			-moz-opacity: 0.8;
			opacity:.80;
			filter: alpha(opacity=80);
		}
		.white_content {
			display: none;
			position: fixed;
			top: 25%;
			left: 25%;
			width: 50%;
			height: 45%;
			padding: 16px;
			border: 10px solid #578EBE;
			background-color: white;
			z-index:1002;
			overflow: auto;
			border-radius:10px;
		}
	</style>
</body>
</html
