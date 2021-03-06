<?php
include_once("../config/config.php");
is_admin_login();
include("./functions/withdraw_request.php");
$withdraw = new withdraw();
include("./includes/access.php");

$page_name ="Reports";

if (in_array($page_name, $admin_access))
  {
  //echo "Match found";
  }
else
  {
 header("location:accessdenied.php");
  }
  
$start = $withdraw->start;

if(isset($_REQUEST['todaydate']))
{
	$date=$_REQUEST['todaydate'];
}
else{
$date=date("d-M-Y");
}

list($withdrawList,$pagination) = $withdraw->getAllwithdrawreport($date);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<? include('./includes/head.php'); ?>
    <style type="text/css">
	#bankAccount { width:700px; }
	.add-search { margin:-15px 0 10px 0;}
    .btn-small{padding:4px 10px;}	
	#ui-datepicker-div
	{
		z-index:100 !important;
	}
	 .breadcrumb a 
	{
		color:#08c !important;
	}
	</style>
</head>

<body>
		<!-- start: Header -->
        <? include('./includes/header.php'); ?>
        <!-- start: Header -->
	
		<div class="container-fluid-full">
		<div class="row-fluid" >
				
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
			
			<? // include('./includes/breadcrumb.php'); ?>
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="dashboard.php">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li>Withdraw Report</li>
			</ul>
            
            <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '1') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> Withdraw Report has been Approved successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
            <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '2') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> Withdraw Report has been Declined successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>

			
			
			<div class="row-fluid ">	
				<div class="box span12">
					<div class="box-header">
						<h2><i class="halflings-icon white align-justify"></i><span class="break"></span>Withdraw Report</h2>
						<div class="box-icon">
						<form name="search" action="withdraw_report.php" method="get">
						<div class="row-fluid" style="height:30px;margin-top:-10px;">
			
			<div class="pull-right"><a href="javascript:void(0);" onclick="withdrawreportfn();"; class="btn btn-small ">Search</a></div>
			<div class="pull-right"><input type="text" name="todaydate" class="datepicker" value="<?php echo $date;?>"></div>
			 <div class="clearfix" style="margin-bottom:20px;"></div>
			
			</div>
			</form>
							<!--<a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>-->
						</div>
					</div>
					<div class="box-content">
						<table class="table table-bordered table-striped table-condensed">
							  <thead>
								   <tr>
									  <th>SNO</th>
                                      <th>User Name</th>
									  <th>Email</th>
									  <th>Amount</th>
									  <th>Details</th>
									  <th>Date</th>
                                      <th>Status</th>
									 
								  </tr>
							  </thead>   
							  <tbody>
                              <?
							  if(empty($withdrawList)){
							  ?>
                              <tr><td colspan="9" style="text-align:center;" class="text-error">No withdraw Report available to show....</td></tr>
                              <?
							  } else {
								  $sno = $start + 1;
								  foreach($withdrawList as $wdrw) {
							  ?>
								<tr>
									<td><?=$sno?></td>
									 <td><a href="viewprofile.php?action=view&id=<?=$wdrw['userid']?>" style="color:#08c;"><?=$wdrw['username']?></a></td>
                                    <td><?=$wdrw['email']?></td>
                                    <td><?=$wdrw['amount']?></td>
									<td><?=$wdrw['details']?></td>
									
									<td class="center"><?=date('d-M-Y h:i A', strtotime($wdrw['date_added']))?></td>
									<td class="center">
                                    	<? if($wdrw['status'] == 0) { ?>
										<span class="label label-success">Pending</span>
                                        <? } elseif($wdrw['status'] == 1) { ?>
                                        <span class="label">Approved</span>
                                        <? }  elseif($wdrw['status'] == 2) { ?>
                                        <span class="label">Declined</span>
                                        <? } ?>
									</td>
                                   
								</tr>
                              <? $sno++; } } ?>
							  </tbody>
						 </table>  
						 <div class="pagination pagination-centered">
						  <ul>
                          	<?=$pagination?>
						  </ul>
						</div>     
					</div>
				</div><!--/span-->
			</div><!--/row-->
			
       

	</div><!--/.fluid-container-->
	
			<!-- end: Content -->
		</div><!--/#content.span10-->
		</div><!--/fluid-row-->
	
    <? include('./includes/footer.php'); ?>
	
    
    
	<!-- start: JavaScript-->
	<? include('./includes/footerinclude.php'); ?>
	<!-- end: JavaScript-->
	
   
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  
  <script>
 
  
  function withdrawreportfn()
  {
	  document.search.submit();
  }
  
  </script>
</body>
</html>