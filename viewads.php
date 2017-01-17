<?php
include_once("./config/config.php");
/***
 * initial setup
 */
$pagename = 'viewads';
$subname = 'viewads';

$login = check_login();
if($login === false) {
	redirect(HTTP_PATH . 'login.php');
}

include("./functions/ads.php");
$ads = new ads;

 if(isset($_REQUEST['type']))
 {
	 $typ=$_REQUEST['type'];
 }
 else
 {
	$typ='all'; 
 }


if(isset($_REQUEST['id']))
{
	 $currentAd = $ads->getAd($_REQUEST['id'],$typ);
}else {
if($_SESSION['roo']['user']['demo'] == 1) {
    $currentAd = $ads->getDemoAd(false);
} else {
    $currentAd = $ads->getAd(0,$typ);
}
}

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
    <div class="timer-wrap">
    	<span class="pull-right">Hint: Do not refresh or focus out from this window. Please wait untill the timer running.</span>
    	<div class="timer">
    		Please wait <span id="countdown">0 sec</span>
        </div>
        <div class="loader hide">
        	<img src="./assets/img/ajax-loader-bar.gif" />
        </div>
        <div class="continue hide"><button class="btn btn-primary" onClick="window.location = './viewads.php?type=<?=$typ?>'">Next Ad</button></div>
    </div>
    <div id="content">
    <? if(empty($currentAd)) { ?>
    	<div class="empty-ad" align="center">
        	<p style="color:red;">Sorry!!! Currently no <?=$typ?> ads to display now.</p>
            <button class="btn btn-danger" onClick="window.location = './viewadslist.php'">Try Again</button>
            <p>OR</p>
            <p>Please try again later</p>
        </div>
    <? } else {

       if($currentAd['type']=="scroll")	{?>
	<div style="width:400px;margin-left:20px;"><img src="./uploads/ads/<?=$currentAd['filehash']?>.attach" /></div>
	<?=$currentAd['html']?>
	   <?php } else {?>
    	<?=$currentAd['html']?>
    <? }} ?>
    </div>
    </section>
    <!-- #end content area -->
      
      
    <!-- sidebar -->    
    <? include("./includes/loginmenu.php"); ?>
    <!-- #end sidebar -->
    <div class="clearfix"></div>
  </div><!-- #end div #main .wrapper -->
<div class="modal hide fade" id="light" style=" padding:0px !important;height:264px;overflow:hidden;">
		<div class="modal-header" style="padding:0px;height:270px;">
			<div class="grid_12 no-padding" style="margin-bottom:0px;">
             <div class="panel panel-primary" style="text-align:left;margin-bottom:0px;">
              <div class="panel-heading">Share your location</div>
              <div class="panel-body" >
		
		<div class="modal-body" id="bankAjaxResult">
			<div id="alertmsg">Must be allow your location or enter your zipcode,then only you can view ads !!! </div>
		<form action="viewads.php" method="post">
		<input type="hidden" name="action" value="_add_findlocation">
		<div class="row-fluid" style="margin-top:20px;border-bottom:1px dashed #ccc;padding-bottom:30px;">
		<div class="pull-left" style="font-size:14px;padding:5px 20px 0px 0px;">Enter your zipcode :</div>
		<div class="pull-left">
		<input type="text" name="zipcode" id="zipcode" class="form-control numberOnly" style="height:30px;width:280px;font-size:14px;" maxlength="6" placeholder="Enter numbers only..." required>
		</div>
		<div class="pull-right" >
		<input type="submit" name="submit" id="submit" value="Submit" style="font-size:14px;margin-bottom:0px;" class="btn btn-small btn-success add-new">
		</div>
		<div class="clearfix" ></div>
		</div>
		
		
		
		<div class="row-fluid" style="margin-top:10px;padding-top:20px;">
		<div class="pull-left" style="margin-right:20px;margin-top:5px; font-size:14px;"> Share your location using browsers tracking</div>
		<div class="pull-right">
		<a href="javascript:void(0);" class="btn btn-small btn-success" style="font-size:14px;" onclick="findlocation();">Find Location</a>
		</div>
		<div class="clearfix" style="margin-bottom:5px;"></div>
		</div>
		
		
		
		</form>

		</div>
		
	</div>
</div>
</div>
</div>
</div>
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
	  // pauseTimer();
   }else{

	locationaddfn(2);
	//timerInit();
   }
});
   
  
   
  function findlocation(){
	  
	  
navigator.geolocation.getCurrentPosition(function(position) {
	$('#light').modal('hide');
	  findlocationvalue(position);
	  location.reload(true);
    //alert('allow');
}, function() {
	//location.reload(true);
   $('#alertmsg').html('You blocked your share location, so clear cache and then try !!! ');
},{enableHighAccuracy: true});

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
  video::-webkit-media-controls-fullscreen-button {
    display: none;
}
 
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