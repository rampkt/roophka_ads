<?php
include_once("./config/config.php");
/***
 * initial setup
 */
$pagename = 'viewads';
$subname = '';

$login = check_login();
if($login === false) {
	redirect(HTTP_PATH . 'login.php');
}

include("./functions/ads.php");
$ads = new ads;

if($_SESSION['roo']['user']['demo'] == 1) {
    $currentAd = $ads->getDemoAd(false);
} else {
    $currentAd = $ads->getAd();
}

if((isset($_REQUEST['action'])) && ($_REQUEST['action']=='_add_findlocation'))
{
	$zipcode=$_REQUEST['zipcode'];
$val = getLnt($zipcode);

$_SESSION['lat']=$val['lat'];
$_SESSION['lng']=$val['lng'];

 //echo "Latitude: ".$_SESSION['lat']."<br>";
 //echo "Longitude: ".$_SESSION['lng']."<br>"; exit;
}
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
    <div class="timer-wrap">
    	<span class="pull-right">Hint: Do not refresh or focus out from this window. Please wait untill the timer running.</span>
    	<div class="timer">
    		Please wait <span id="countdown">0 sec</span>
        </div>
        <div class="loader hide">
        	<img src="./assets/img/ajax-loader-bar.gif" />
        </div>
        <div class="continue hide"><button class="btn btn-primary" onClick="window.location = './viewads.php'">Next Ad</button></div>
    </div>
    <div id="content">
    <? if(empty($currentAd)) { ?>
    	<div class="empty-ad" align="center">
        	<p style="color:red;">Sorry!!! Currently no ads to display now.</p>
            <button class="btn btn-danger" onClick="window.location = './viewads.php'">Try Again</button>
            <p>OR</p>
            <p>Please try again later</p>
        </div>
    <? } else { ?>
    	<?=$currentAd['html']?>
    <? } ?>
    </div>
    </section>
    <!-- #end content area -->
      
      
    <!-- sidebar -->    
    <? include("./includes/loginmenu.php"); ?>
    <!-- #end sidebar -->
    <div class="clearfix"></div>
  </div><!-- #end div #main .wrapper -->
<div id="light" class="white_content"> <a href = "javascript:void(0)" onclick = "locationaddfn(2);"></a>
		<div style="border-bottom:2px solid #ccc;width100%;margin:5px;"><h2>Add Your Location</h2></div>
		<div id="alertmsg">Must be allow your location or enter your zipcode,then only you can view ads !!! </div>
		<form action="viewads.php" method="post">
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

<!--<script src="./assets/js/jquery-canvas-sparkles.js"></script>-->

<script type="text/javascript">
var adstype = '<?=$currentAd['type']?>';
var adscount = parseInt('<?=$currentAd['duration']?>');
var adsid = '<?=$currentAd['id']?>';
</script>

<script src="./assets/js/viewads.js"></script>
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
	  // pauseTimer();
   }else{

	locationaddfn(2);
	//timerInit();
   }
});
   
  
   
  function findlocation(){
	  
	  
navigator.geolocation.getCurrentPosition(function(position) {
	document.getElementById('light').style.display='none';
	  document.getElementById('fade').style.display='none';
	  findlocationvalue(position);
	  location.reload(true);
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
</html>