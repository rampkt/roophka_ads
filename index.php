<?php
include_once("./config/config.php");

/***
 * initial setup
 */
$pagename = 'home';
$subname = '';
include("./functions/cms.php");
$cms = new cms();
$aboutus=$cms->getcms(1,'aboutus');

include("./functions/ads.php");
$ads = new ads();

$sliderAds = $ads->getHomeSliderAd();
if((isset($_REQUEST['action'])) && ($_REQUEST['action']=='_add_findlocation'))
{
	$zipcode=$_REQUEST['zipcode'];
$val = getLnt($zipcode);

$_SESSION['lat']=$val['lat'];
$_SESSION['lng']=$val['lng'];

 //echo "Latitude: ".$_SESSION['lat']."<br>";
 //echo "Longitude: ".$_SESSION['lng']."<br>"; exit;
}

//echo "Latitude: ".$_SESSION['lat']."<br>";
 //echo "Longitude: ".$_SESSION['lng']."<br>"; 
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
            <?=substr(html_entity_decode($aboutus),0,540)?>
            <p><a href="aboutus.php" class="buttonlink">Read More</a> <a href="howitworks.php" class="buttonlink">How it works</a></p>
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
        	<h2 class="first-header text-primary" align="center">Saravana Stores Gold Jewellery</h2>
            <img src="./assets/img/homepageads/saravana_stores_jewellery.jpg" />
            
        </div>
        
        <div class="grid_4">
        	<h2 class="first-header text-primary" align="center">Yesbond Construction Chemicals</h2>
           <img src="./assets/img/homepageads/yesbond.jpg" />
            
        </div>
        
        <div class="grid_4">
        	<h2 class="first-header text-primary" align="center">Kalaikutty Semiya</h2>
           <img src="./assets/img/homepageads/kalaikutty.jpg" />
        </div>
	  </div><!-- end row -->
      <div class="row">	
        <div class="grid_4">
        	<h2 class="first-header text-primary" align="center">Bharathi Kovai Cotton</h2>
           <img src="./assets/img/homepageads/bharathikathi.jpg" />
        </div>
        
        <div class="grid_4">
        	<h2 class="first-header text-primary" align="center">Supreme Mobiles</h2>
            <img src="./assets/img/homepageads/supreme.jpg" />
        </div>
        
        <div class="grid_4">
        	<h2 class="first-header text-primary" align="center">Vijaya Dhayaa Realtors</h2>
            <img src="./assets/img/homepageads/realtors.jpg" />
        </div>
	  </div><!-- end row -->
	</section><!-- end content area -->   
      
  </div><!-- #end div #main .wrapper -->
  
	

<!-- footer area -->    
<? include("./includes/footer.php"); ?>
<!-- #end footer area --> 
 <div class="modal hide fade" id="light" style="height:310px;">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">x</button>
			<h3>Add Your Location</h3>
		</div>
		<div class="modal-body" id="bankAjaxResult">
			<div id="alertmsg">Must be allow your location or enter your zipcode,then only you can view ads !!! </div>
		<form action="index.php" method="post">
		<input type="hidden" name="action" value="_add_findlocation">
		<div class="row-fluid" style="margin-top:20px;">
		<div class="pull-left" style="margin-right:10px;margin-top:10px;font-size:14px;">Enter your zipcode :</div>
		<div class="pull-left">
		<input type="text" name="zipcode" id="zipcode" class="form-control" style="height:30px;margin-top:5px;font-size:14px;" maxlength="6" placeholder="Enter zipcode here..." required>
		</div>
		<div class="pull-left"  style="margin-top:5px;margin-left:20px;">
		<input type="submit" name="submit" id="submit" value="Submit" style="padding:5px;font-size:14px;border-radius:0px;" class="btn btn-small btn-success add-new">
		</div>
		<div class="clearfix" style="margin-bottom:10px;"></div>
		</div>
		
		<div style="font-size:13px;">(or)</div>
		
		<div class="row-fluid" style="margin-top:10px;">
		<div class="pull-left" style="margin-right:20px;margin-top:5px; font-size:14px;"> Share your location</div>
		<div class="pull-left">
		<a href="javascript:void(0);" class="btn btn-small btn-success" style="padding:5px;font-size:14px;border-radius:0px;" onclick="findlocation();">Find Location</a>
		</div>
		<div class="clearfix" style="margin-bottom:10px;"></div>
		</div>
		
		
		
		</form>
		</div>
		<div class="modal-footer">
			<a href="#" class="btncss" data-dismiss="modal">Close</a>
		</div>
	</div>

<? include("./includes/footerinclude.php"); ?>
<script>
var latval="<?php if(isset($_SESSION['lat'])) { echo $_SESSION['lat']; }else{ echo "";} ?>";
var lngval="<?php if(isset($_SESSION['lng'])) { echo $_SESSION['lng']; }else{ echo "";} ?>";
 function locationaddfn(val)
  {
	  //alert("adad");
	  if(val==1)
	  {
	  //document.getElementById('light').style.display='block';
	 // document.getElementById('fade').style.display='block';
	 $('#light').modal('show');
	  }
	  
	   if(val==2)
	  {
	  $('#light').modal('hide');
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
	  
	var options = {
  enableHighAccuracy: true
};  
navigator.geolocation.getCurrentPosition(function(position) {
	$('#light').modal('hide');
	  findlocationvalue(position);
	  
    //alert('allow');
},function() {
	//location.reload(true);
   $('#alertmsg').html('You blocked your share location, so clear cache and then try !!! ');
},{enableHighAccuracy: true});

}
 
function findlocationvalue(position) {
	//alert("ada");
	x=position.coords.latitude;
    y=position.coords.longitude;
	//alert(x);
	//$('.overlay').fadeIn();
	var params = { action : '_findlocation',lat:x, lng:y}
	$.ajax({
		url:"user_ajax.php",
		type:'POST',
		dataType:"JSON",
		data:params,
		success: function(result) {
			//$('.overlay').fadeOut();
			location.reload(true);
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
  top: 20%;
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
  padding: 15px;
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
.btncss {
    color: #ffffff !important;
    background-color: #a7a9aa;
    border-color: #a7a9aa;
    background-image: none;
    filter: none;
    text-shadow: none;
	padding:10px;
	font-size:14px;
	
}

	</style>
</body>
</html
