<?php
include_once("./config/config.php");
/***
 * initial setup
 */
$pagename = 'newsads';
$subname = '';

/*$login = check_login();
if($login === false) {
	redirect(HTTP_PATH . 'login.php');
}*/

include("./functions/ads.php");
$ads = new ads;

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<? include("./includes/head.php"); ?>
<link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="./assets/css/newsad.css" />
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
      <div class="main_content floatleft">
        <div class="left_coloum floatleft">
          <div class="single_left_coloum_wrapper">
            <h2 class="title">from   around   the   world</h2>
            <a class="more" href="#">more</a>
            <div class="single_left_coloum floatleft"> <img src="./assets/images/single_featured.png" alt="" />
              <h3>Lorem ipsum dolor sit amet, consectetur</h3>
              <p>Nulla quis lorem neque, mattis venenatis lectus. In interdum ullamcorper 
                dolor eu mattis.</p>
              <a class="readmore" href="#">read more</a> </div>
            <div class="single_left_coloum floatleft"> <img src="./assets/images/single_featured.png" alt="" />
              <h3>Lorem ipsum dolor sit amet, consectetur</h3>
              <p>Nulla quis lorem neque, mattis venenatis lectus. In interdum ullamcorper 
                dolor eu mattis.</p>
              <a class="readmore" href="#">read more</a> </div>
            <div class="single_left_coloum floatleft"> <img src="./assets/images/single_featured.png" alt="" />
              <h3>Lorem ipsum dolor sit amet, consectetur</h3>
              <p>Nulla quis lorem neque, mattis venenatis lectus. In interdum ullamcorper 
                dolor eu mattis.</p>
              <a class="readmore" href="#">read more</a> </div>
          </div>
          <div class="single_left_coloum_wrapper">
            <h2 class="title">latest  articles</h2>
            <a class="more" href="#">more</a>
            <div class="single_left_coloum floatleft"> <img src="./assets/images/single_featured.png" alt="" />
              <h3>Lorem ipsum dolor sit amet, consectetur</h3>
              <p>Nulla quis lorem neque, mattis venenatis lectus. In interdum ullamcorper 
                dolor eu mattis.</p>
              <a class="readmore" href="#">read more</a> </div>
            <div class="single_left_coloum floatleft"> <img src="./assets/images/single_featured.png" alt="" />
              <h3>Lorem ipsum dolor sit amet, consectetur</h3>
              <p>Nulla quis lorem neque, mattis venenatis lectus. In interdum ullamcorper 
                dolor eu mattis.</p>
              <a class="readmore" href="#">read more</a> </div>
            <div class="single_left_coloum floatleft"> <img src="./assets/images/single_featured.png" alt="" />
              <h3>Lorem ipsum dolor sit amet, consectetur</h3>
              <p>Nulla quis lorem neque, mattis venenatis lectus. In interdum ullamcorper 
                dolor eu mattis.</p>
              <a class="readmore" href="#">read more</a> </div>
          </div>
          <div class="single_left_coloum_wrapper gallery">
            <h2 class="title">gallery</h2>
            <a class="more" href="#">more</a> <img src="./assets/images/single_featured.png" alt="" /> <img src="images/single_featured.png" alt="" /> <img src="images/single_featured.png" alt="" /> <img src="images/single_featured.png" alt="" /> <img src="images/single_featured.png" alt="" /> <img src="images/single_featured.png" alt="" /> </div>
          <div class="single_left_coloum_wrapper single_cat_left">
            <h2 class="title">tech news</h2>
            <a class="more" href="#">more</a>
            <div class="single_cat_left_content floatleft">
              <h3>Lorem ipsum dolor sit amet conse ctetur adipiscing elit </h3>
              <p>Nulla quis lorem neque, mattis venenatis lectus. In interdum ullamcorper dolor ...interdum</p>
              <p class="single_cat_left_content_meta">by <span>John Doe</span> |  29 comments</p>
            </div>
            <div class="single_cat_left_content floatleft">
              <h3>Lorem ipsum dolor sit amet conse ctetur adipiscing elit </h3>
              <p>Nulla quis lorem neque, mattis venenatis lectus. In interdum ullamcorper dolor ...interdum</p>
              <p class="single_cat_left_content_meta">by <span>John Doe</span> |  29 comments</p>
            </div>
            <div class="single_cat_left_content floatleft">
              <h3>Lorem ipsum dolor sit amet conse ctetur adipiscing elit </h3>
              <p>Nulla quis lorem neque, mattis venenatis lectus. In interdum ullamcorper dolor ...interdum</p>
              <p class="single_cat_left_content_meta">by <span>John Doe</span> |  29 comments</p>
            </div>
            <div class="single_cat_left_content floatleft">
              <h3>Lorem ipsum dolor sit amet conse ctetur adipiscing elit </h3>
              <p>Nulla quis lorem neque, mattis venenatis lectus. In interdum ullamcorper dolor ...interdum</p>
              <p class="single_cat_left_content_meta">by <span>John Doe</span> |  29 comments</p>
            </div>
          </div>
        </div>
        <div class="right_coloum floatright">
          <div class="single_right_coloum">
            <h2 class="title">from the desk</h2>
            <ul>
              <li>
                <div class="single_cat_right_content">
                  <h3>Lorem ipsum dolor sit amet conse ctetur adipiscing elit</h3>
                  <p>Nulla quis lorem neque, mattis venen atis lectus. In interdum ull amcorper dolor eu mattis.</p>
                  <p class="single_cat_right_content_meta"><a href="#"><span>read more</span></a> 3 hours ago</p>
                </div>
              </li>
              <li>
                <div class="single_cat_right_content">
                  <h3>Lorem ipsum dolor sit amet conse ctetur adipiscing elit</h3>
                  <p>Nulla quis lorem neque, mattis venen atis lectus. In interdum ull amcorper dolor eu mattis.</p>
                  <p class="single_cat_right_content_meta"><a href="#"><span>read more</span></a> 3 hours ago</p>
                </div>
              </li>
              <li>
                <div class="single_cat_right_content">
                  <h3>Lorem ipsum dolor sit amet conse ctetur adipiscing elit</h3>
                  <p>Nulla quis lorem neque, mattis venen atis lectus. In interdum ull amcorper dolor eu mattis.</p>
                  <p class="single_cat_right_content_meta"><a href="#"><span>read more</span></a> 3 hours ago</p>
                </div>
              </li>
            </ul>
            <a class="popular_more" href="#">more</a> </div>
          <div class="single_right_coloum">
            <h2 class="title">editorial</h2>
            <div class="single_cat_right_content editorial"> <img src="images/editorial_img.png" alt="" />
              <h3>Lorem ipsum dolor sit amet con se cte tur adipiscing elit</h3>
            </div>
            <div class="single_cat_right_content editorial"> <img src="images/editorial_img.png" alt="" />
              <h3>Lorem ipsum dolor sit amet con se cte tur adipiscing elit</h3>
            </div>
            <div class="single_cat_right_content editorial"> <img src="images/editorial_img.png" alt="" />
              <h3>Lorem ipsum dolor sit amet con se cte tur adipiscing elit</h3>
            </div>
            <div class="single_cat_right_content editorial"> <img src="images/editorial_img.png" alt="" />
              <h3>Lorem ipsum dolor sit amet con se cte tur adipiscing elit</h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- #end content area -->
  
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
<script src="./assets/js/newsad.js"></script>

</body>
</html>