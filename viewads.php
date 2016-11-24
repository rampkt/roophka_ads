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


<!-- footer area -->    
<? include("./includes/footer.php"); ?>
<!-- #end footer area --> 

<? include("./includes/footerinclude.php"); ?>

<!--<script src="./assets/js/jquery-canvas-sparkles.js"></script>-->

<script type="text/javascript">
var adstype = '<?=$currentAd['type']?>';
var adscount = parseInt('<?=$currentAd['duration']?>');
var adsid = '<?=$currentAd['id']?>';

$( document ).ready(function() {
navigator.geolocation.getCurrentPosition(function(position) {
    //alert('allow');
}, function() {
    alert('Must be click allow to share your location,then only you can view this ad');
});

});


</script>

<script src="./assets/js/viewads.js"></script>

</body>
</html>