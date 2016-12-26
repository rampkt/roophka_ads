<?php
include_once("../config/config.php");
is_admin_login();
include("./includes/access.php");
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
				<li>Dashboard</li>
			</ul>
			

			<div class="row-fluid">
			<div class="pull-left"><h4 style="line-height:6px;">Today Count</h4></div>
			<div class="pull-right"><h4 style="line-height:6px;"><?php echo date("d-M-Y");?></h4></div>
			<div class="clearfix"></div>
			</div>
			
			
			<hr style="margin:5px 0px;border-bottom:2px solid #CCC;" />
			<div class="row-fluid">
				
                <div class="span3 statbox green" onTablet="span6" onDesktop="span3">
					<div class="boxchart">5,6,7,2,0,4,2,4,8,2,3,3,2</div>
					<div class="number"><?=$totalstoday['users']?><i class="icon-arrow-up"></i></div>
					<div class="title">Today Users</div>
					<div class="footer">
						<a href="users_report.php"> read full report</a>
					</div>	
				</div>
				<!--<div class="span3 statbox purple" onTablet="span6" onDesktop="span3">
					<div class="boxchart">5,6,7,2,0,4,2,4,8,2,3,3,2</div>
					<div class="number">854<i class="icon-arrow-up"></i></div>
					<div class="title">visits</div>
					<div class="footer">
						<a href="#"> read full report</a>
					</div>	
				</div>-->
				<div class="span3 statbox purple" onTablet="span6" onDesktop="span3">
					<div class="boxchart">1,2,6,4,0,8,2,4,5,3,1,7,5</div>
					<div class="number"><?=$totalstoday['ads']?><i class="icon-arrow-up"></i></div>
					<div class="title">Today Post Ads</div>
					<div class="footer">
						<a href="ads.php"> read full report</a>
					</div>
				</div>
				<div class="span3 statbox yellow noMargin" onTablet="span6" onDesktop="span3">
					<div class="boxchart">5,6,7,2,0,-4,-2,4,8,2,3,3,2</div>
					<div class="number"><?=$totalstoday['transaction']?><i class="icon-arrow-up"></i></div>
					<div class="title">Today View ads</div>
					<div class="footer">
						<a href="ads_report.php"> read full report</a>
					</div>
				</div>
				<div class="span3 statbox red" onTablet="span6" onDesktop="span3">
					<div class="boxchart">7,2,2,2,1,-4,-2,4,8,,0,3,3,5</div>
					<div class="number"><?=$totalstoday['withdraw']?><i class="icon-arrow-down"></i></div>
					<div class="title">Today Withdrawn</div>
					<div class="footer">
						<a href="#"> read full report</a>
					</div>
				</div>	
				
			</div>		
	
			
			<div><h4>Total Count</h4></div>
			<hr style="margin:5px 0px;border-bottom:2px solid #CCC;" />
			<div class="row-fluid">
			
				
                <div class="span3 statbox purple" onTablet="span6" onDesktop="span3">
					<div class="boxchart">5,6,7,2,0,4,2,4,8,2,3,3,2</div>
					<div class="number"><?=$totals['users']?><i class="icon-arrow-up"></i></div>
					<div class="title">Total Users</div>
					<div class="footer">
						<a href="users.php"> View full Users</a>
					</div>	
				</div>
				<!--<div class="span3 statbox purple" onTablet="span6" onDesktop="span3">
					<div class="boxchart">5,6,7,2,0,4,2,4,8,2,3,3,2</div>
					<div class="number">854<i class="icon-arrow-up"></i></div>
					<div class="title">visits</div>
					<div class="footer">
						<a href="#"> read full report</a>
					</div>	
				</div>-->
				<div class="span3 statbox green" onTablet="span6" onDesktop="span3">
					<div class="boxchart">1,2,6,4,0,8,2,4,5,3,1,7,5</div>
					<div class="number"><?=$totals['ads']?><i class="icon-arrow-up"></i></div>
					<div class="title">Total Ads</div>
					<div class="footer">
						<a href="ads.php"> View full ads</a>
					</div>
				</div>
				<div class="span3 statbox blue noMargin" onTablet="span6" onDesktop="span3">
					<div class="boxchart">5,6,7,2,0,-4,-2,4,8,2,3,3,2</div>
					<div class="number"><?=$totals['transaction']?><i class="icon-arrow-up"></i></div>
					<div class="title">Ads seen</div>
					<div class="footer">
						<a href="#"> views full ads</a>
					</div>
				</div>
				<div class="span3 statbox yellow" onTablet="span6" onDesktop="span3">
					<div class="boxchart">7,2,2,2,1,-4,-2,4,8,,0,3,3,5</div>
					<div class="number"><?=$totals['withdraw']?><i class="icon-arrow-down"></i></div>
					<div class="title">Total Withdrawn</div>
					<div class="footer">
						<a href="#"> View full withdrawn</a>
					</div>
				</div>	
				
			</div>		
			
					
			<div><h4>Sub Links</h4></div>
			<hr style="margin:5px 0px;border-bottom:2px solid #CCC;" />
			
			<div class="row-fluid">	

				<a href="adminusers.php" class="quick-button metro yellow span2">
					<i class="icon-group"></i>
					<p>Admin Users</p>
					<span class="badge"><?=$totals['adminusers']?></span>
				</a>
				<a href="advertise.php" class="quick-button metro red span2">
					<i class="icon-comments-alt"></i>
					<p>Advertise with us</p>
					<span class="badge"><?=$totals['advertise']?></span>
				</a>
				<a href="recharge_orders.php" class="quick-button metro blue span2">
					<i class="icon-shopping-cart"></i>
					<p>Recharge Orders</p>
					<span class="badge"><?=$totals['recharge']?></span>
				</a>
				<a href="ads_add.php" class="quick-button metro green span2">
					<i class="icon-barcode"></i>
					<p>Add Digital Ads</p>
				</a>
				<a href="contactus.php" class="quick-button metro pink span2">
					<i class="icon-envelope"></i>
					<p>Messages</p>
					<span class="badge"><?=$totals['contact']?></span>
				</a>
				<a href="profile.php" class="quick-button metro black span2">
					<i class="icon-calendar"></i>
					<p>View My Profile</p>
				</a>
				
				<div class="clearfix"></div>
								
			</div><!--/row-->
			
       

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