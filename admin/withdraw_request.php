<?php
include_once("../config/config.php");
is_admin_login();
include("./functions/withdraw_request.php");
$withdraw = new withdraw();

$start = $withdraw->start;

if(isset($_REQUEST['todaydate']))
{
	$date=$_REQUEST['todaydate'];
}
else{
$date=date("d-M-Y");
}

list($withdrawList,$pagination) = $withdraw->getAllwithdraw($date);
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
		<div class="row-fluid" style="min-height:570px;height:auto;">
				
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
				<li>Withdraw Request</li>
			</ul>
            
            <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '1') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> Withdraw Request has been Approved successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
            <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '2') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> Withdraw Request has been Declined successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>

			
			
			<div class="row-fluid sortable">	
				<div class="box span12">
					<div class="box-header">
						<h2><i class="halflings-icon white align-justify"></i><span class="break"></span>Withdraw Request</h2>
						<div class="box-icon">
						<form name="search" action="withdraw_request.php" method="get">
						<div class="row-fluid" style="height:30px;margin-top:-10px;">
			
			<div class="pull-right"><a href="javascript:void(0);" onclick="withdrawreportfn();"; class="btn btn-small ">Search</a></div>
			<div class="pull-right"><input type="text" name="todaydate" id="datepicker" value="<?php echo $date;?>"></div>
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
									  <th>Action</th>
								  </tr>
							  </thead>   
							  <tbody>
                              <?
							  if(empty($withdrawList)){
							  ?>
                              <tr><td colspan="9" style="text-align:center;" class="text-error">No withdraw request available to show....</td></tr>
                              <?
							  } else {
								  $sno = $start + 1;
								  foreach($withdrawList as $wdrw) {
							  ?>
								<tr>
									<td><?=$sno?></td>
									 <td><?=$wdrw['username']?></td>
                                    <td><?=$wdrw['email']?></td>
                                    <td><?=$wdrw['amount']?></td>
									<td><?=$wdrw['details']?></td>
									
									<td class="center"><?=date('d-M-Y h:i A', strtotime($wdrw['date_added']))?></td>
									
                                    <td>
									<? if($wdrw['status'] == 0) { ?>
									<a href="./withdraw_approve.php?action=approve&id=<?=$wdrw['id']?>&todaydate=<?php echo $date; ?>" onClick="return confirm('Do you realy want to Approve this withdraw request?');" class="btn btn-small btn-success" style="padding:0px 10px;"><i class="halflings-icon white ok">&nbsp;</i>Approve</a>
                                    	
                                        <a href="./withdraw_decline.php?action=deactivate&id=<?=$wdrw['id']?>&todaydate=<?php echo $date; ?>" onClick="return confirm('Do you realy want to deactivate this account?');" class="btn btn-small" style="padding:0px 10px;"><i class="halflings-icon white remove"></i>Decline</a>
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
	
    <div class="modal hide fade" id="bankAccount">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">x</button>
			<h3>Settings</h3>
		</div>
		<div class="modal-body" id="bankAjaxResult">
			<p>Nothing to show here...</p>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Close</a>
		</div>
	</div>
    
	<!-- start: JavaScript-->
	<? include('./includes/footerinclude.php'); ?>
	<!-- end: JavaScript-->
	
    <script type="text/javascript">
		function getAccount(id) {
			var params = { cmd:'_getAccount', user:id }
            $.ajax({
				url:"./ajax.php",
				dataType:"JSON",
				data:params,
				success: function(result) {
					if(result.error) {
						alert(result.msg);
					} else {
						$('#bankAjaxResult').html(result.html);
						$('#bankAccount').modal('show');
					}
				}
			});
			return false;
		}
		$(document).ready(function(e) {
			
        });
	</script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker(
	{
		dateFormat: "dd-M-yy"
	}
	);
  } );
  
  function withdrawreportfn()
  {
	  document.search.submit();
  }
  
  </script>
</body>
</html>