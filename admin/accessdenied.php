<?php
include_once("../config/config.php");
is_admin_login();

spl_autoload_register(function($file){
	include("./functions/".$file.".php");
});

$dash = new dashboard();
$date=date("Y-m-d");
$totals = $dash->totalCount();
$totalstoday = $dash->totalCounttoday($date);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<style>
 .breadcrumb a 
	{
		color:#08c !important;
	}
</style>

	<? include('./includes/head.php'); ?>
</head>

<body>
		<!-- start: Header -->
        <? include('./includes/header.php'); ?>
        <!-- start: Header -->
	
		<div class="container-fluid-full">
		<div class="row-fluid">
				
			<!-- start: Main Menu -->
			<? include('./includes/mainmenu.php'); ?>
			<!-- end: Main Menu -->
			
			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
				</div>
			</noscript>
			
			<!-- start: Content -->
			<div id="content" class="span10">
			
			<? //include('./includes/breadcrumb.php'); ?>
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="dashboard.php">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li>Access</li>
			</ul>
			

			<div class="row-fluid">
			<div class="pull-left"><h4 style="line-height:6px;">Page is not open, you dont have a Access to open this page, Access is denied !!!</h4></div>
			<div class="clearfix"></div>
			</div>
			

	</div><!--/.fluid-container-->
	
			<!-- end: Content -->
		</div><!--/#content.span10-->
		</div><!--/fluid-row-->
	
    <? include('./includes/footer.php'); ?>
	
	<!-- start: JavaScript-->
	<? include('./includes/footerinclude.php'); ?>
	<!-- end: JavaScript-->
	
</body>
</html>