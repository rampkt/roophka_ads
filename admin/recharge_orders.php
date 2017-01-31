<?php
include_once("../config/config.php");
is_admin_login();
include("./functions/recharge.php");
$recharge = new recharge();
include("./includes/access.php");
$page_name ="Recharge";

if (in_array($page_name, $admin_access))
  {
  //echo "Match found";
  }
else
  {
 header("location:accessdenied.php");
  }


$start = $recharge->start;

if(isset($_REQUEST['action']) AND isset($_REQUEST['id']) AND $_REQUEST['id'] > 0) {
	$Order=$_REQUEST['Order'];
	if($_REQUEST['action'] == 'activate') {
		$recharge->Activateorder($_REQUEST['id']);
		redirect(HTTP_PATH . "admin/recharge_orders.php?Order=$Order&success=1");
	}
	if($_REQUEST['action'] == 'deactivate') {
		$recharge->Deactivateorder($_REQUEST['id']);
		redirect(HTTP_PATH . "admin/recharge_orders.php?Order=$Order&success=2");
	}
	if($_REQUEST['action'] == 'delete') {
		$recharge->DeleteOrder($_REQUEST['id']);
		redirect(HTTP_PATH . "admin/recharge_orders.php?success=4");
	}


	redirect(HTTP_PATH . "admin/recharge_orders.php");
}


if(isset($_REQUEST['Order']))
{
	$Order=$_REQUEST['Order'];
	$Order2=$_REQUEST['Order'];
}
else{
$Order="";
$Order2="";
}
//echo $date;

list($orderList,$pagination) = $recharge->getAllorders($Order);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<? include('./includes/head.php'); ?>
    <style type="text/css">
	.add-search { margin:-15px 0 10px 0;}
    .btn-small{padding:4px 10px;}	
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
					<a href="dashoboard.php">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li>Orders</li>
			</ul>
			
			
            <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '1') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> Order is activated successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
            <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '2') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> Order is deactivated successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
			
			
			 <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '4') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> Order is deleted successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
			
			
			<div class="row-fluid ">	
				<div class="box span12">
				
					<div class="box-header">
						<h2><i class="halflings-icon white align-justify"></i><span class="break"></span>Recharge Orders Management</h2>
						<div class="box-icon">
						<form name="search" action="recharge_orders.php" method="get">
						<div class="row-fluid" style="height:30px;margin-top:-10px;">
			
			<div class="pull-right"><a href="javascript:void(0);" onclick="usersreportfn();"; class="btn btn-small ">Search</a></div>
			<div class="pull-right"><input type="text" name="Order" id="Order" class="datepicker" placeholder="Choose Date here..." value="<?php echo $Order;?>"></div>
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
									  <th>Sno</th>
                                      <th>User Name</th>
                                      <th>Mobile No</th>
                                      <th>Amount</th>
									   <th>Txn ID</th>
									    <th>Order ID</th>
										 <th>Recharge Status</th>
										  <th>Operator</th>
										   <th>Date</th>
									  <th>Status</th>
                                      <th style="width:175px;">Action</th>
								  </tr>
							  </thead>   
							  <tbody>
                              <?
							  if(empty($orderList)){
							  ?>
                              <tr><td colspan="11" style="text-align:center;" class="text-error">No Orders available to show....</td></tr>
                              <?
							  } else {
								  $sno = $start + 1;
								  foreach($orderList as $order) {
							  ?>
								<tr>
									<td><?=$sno?></td>
                                    <td> <a href="viewprofile.php?action=view&id=<?=$order['user_id']?>" style="color:blue;"><?=$recharge->getusername($order['user_id'])?></a></td>
                                    <td><?=$order['mobile']?></td>
                                    <td><?=$order['amount']?></td>
									<td><?=$order['apiorder_id']?></td>
									<td><?=$order['myorder_id']?></td>
									<td><?=$order['recharge_status']?></td>
									<td><?=$recharge->getoperatorname($order['operator'])?></td>
									<td><?=$order['date_added']?></td>
									<td class="center">
                                    	<? if($order['status'] == 0) { ?>
										<span class="label label-success" style="padding:6px;">Active</span>
                                        <? } elseif($order['status'] == 1) { ?>
                                        <span class="label" style="padding:6px;">Inactive</span>
                                        <? } ?>
									</td>
                                    <td>
                                    	<? if($order['status'] == 0) { ?>
                                        <a href="./recharge_orders.php?action=deactivate&id=<?=$order['id']?>&Order=<?php echo $Order2;?>" onClick="return confirm('Do you really want to deactivate this account?');" class="btn btn-small"><i class="halflings-icon white remove"></i>Deactiavte</a>
                                        <? } elseif($order['status'] == 1) { ?>
                                        <a href="./recharge_orders.php?action=activate&id=<?=$order['id']?>&Order=<?php echo $Order2;?>" onClick="return confirm('Do you really want to activate this account?');" class="btn btn-small btn-success"><i class="halflings-icon white ok">&nbsp;</i>Actiavte</a>
                                        <? } ?>
                                        
										<a href="./recharge_orders.php?action=delete&id=<?=$order['id']?>" onClick="return confirm('Do you really want to delete this account?');" class="btn btn-small btn-primary"><i class="halflings-icon white remove">&nbsp;</i>Delete</a>
										
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
  
  function usersreportfn()
  {
	  document.search.submit();
  }
  

  
  </script>  
 <style>
 .ui-datepicker 
 {
	 z-index:100 !important;
 }
</style> 
  
 </body>
</html>