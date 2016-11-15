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


<!-- footer area -->    
<? include("./includes/footer.php"); ?>
<!-- #end footer area --> 

<? include("./includes/footerinclude.php"); ?>

</body>
</html>