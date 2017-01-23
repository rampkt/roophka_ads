<?php
include_once("../config/config.php");
is_admin_login();
include("./functions/plans.php");
$plans = new plans();

include("./includes/access.php");
$page_name ="plan";

if (in_array($page_name, $admin_access))
  {
  //echo "Match found";
  }
else
  {
 header("location:accessdenied.php");
  }

$start = $plans->start;

if(isset($_REQUEST['action']) AND isset($_REQUEST['id']) AND $_REQUEST['id'] > 0) {
	$plan=$_REQUEST['plan'];
	if($_REQUEST['action'] == 'activate') {
		$plans->Activateplan($_REQUEST['id']);
		redirect(HTTP_PATH . "admin/plandetails.php?plan=$plan&success=1");
	}
	if($_REQUEST['action'] == 'deactivate') {
		$plans->Deactivateplan($_REQUEST['id']);
		redirect(HTTP_PATH . "admin/plandetails.php?plan=$plan&success=2");
	}
	if($_REQUEST['action'] == 'delete') {
		$plans->Deleteplan($_REQUEST['id']);
		redirect(HTTP_PATH . "admin/plandetails.php?success=4");
	}


	redirect(HTTP_PATH . "admin/plandetails.php");
}




if((isset($_REQUEST['search'])) && $_REQUEST['search']=='search')
{
	$categorysearch=$_REQUEST['categorysearch'];
}
else{
$categorysearch="";
}
//echo $date;

list($planList,$pagination) = $plans->getAllplans($categorysearch);
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
				<li>plans</li>
			</ul>
			
			
            <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '1') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> plan is activated successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
            <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '2') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> plan is deactivated successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
			
			 <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '3') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> plan is added successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
			 <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '4') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> plan is deleted successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
			<? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '5') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> plan is updated successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
			
                 <a href="plan_add.php" class="btn btn-small btn-primary pull-right add-new" style="margin-bottom:10px;">Add new</a>
			<div class="row-fluid ">	
				<div class="box span12">
				
					<div class="box-header">
						<h2><i class="halflings-icon white align-justify"></i><span class="break"></span>plan Management</h2>
						<div class="box-icon">
						<form name="search" action="plandetails.php" method="get">
						
						<input type="hidden" name="search" value="search">
						<div class="row-fluid" style="height:30px;margin-top:-10px;">
			
			<div class="pull-right"><a href="javascript:void(0);" onclick="usersreportfn();"; class="btn btn-small ">Search</a></div>
			<div class="pull-right" style="margin-right:10px;">
			<select name="categorysearch" id="categorysearch">
			<option value="">Select Category</option>
			<?php echo $plans->getallcategory($categorysearch); ?>
			</select>
			</div>
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
									  <th>Category</th>
                                      <th>Seconds</th>
									  <th>Amount</th>
									  <th>Viewers</th>
									  <th>Status</th>
                                      <th style="width:250px;">Action</th>
								  </tr>
							  </thead>   
							  <tbody>
                              <?
							  if(empty($planList)){
							  ?>
                              <tr><td colspan="6" style="text-align:center;" class="text-error">No plan details available to show....</td></tr>
                              <?
							  } else {
								  $sno = $start + 1;
								  foreach($planList as $plan) {
							  ?>
								<tr>
									<td><?=$sno?></td>
									 <td ><?=$plans->categoryname($plan['catid'])?></td>
									 <td ><?=$plan['from_sec']?> to <?=$plan['to_sec']?> sec</td>
									 <td ><?=$plan['amount']?></td>
									<td ><?=$plan['viewers']?></td>
									<td class="center">
                                    	<? if($plan['status'] == 0) { ?>
										<span class="label label-success" style="padding:6px;">Active</span>
                                        <? } elseif($plan['status'] == 1) { ?>
                                        <span class="label" style="padding:6px;">Inactive</span>
                                        <? } ?>
									</td>
                                    <td>
                                    	<? if($plan['status'] == 0) { ?>
                                        <a href="./plandetails.php?action=deactivate&id=<?=$plan['id']?>" onClick="return confirm('Do you really want to deactivate this account?');" class="btn btn-small"><i class="halflings-icon white remove"></i>Deactiavte</a>
                                        <? } elseif($plan['status'] == 1) { ?>
                                        <a href="./plandetails.php?action=activate&id=<?=$plan['id']?>" onClick="return confirm('Do you really want to activate this account?');" class="btn btn-small btn-success"><i class="halflings-icon white ok">&nbsp;</i>Actiavte</a>
                                        <? } ?>
										
										<a href="./plan_edit.php?action=edit&id=<?=$plan['id']?>" class="btn btn-small btn-warning"><i class="halflings-icon white ok">&nbsp;</i>Edit</a>
                                        
										<a href="./plandetails.php?action=delete&id=<?=$plan['id']?>" onClick="return confirm('Do you really want to delete this account?');" class="btn btn-small btn-primary"><i class="halflings-icon white remove">&nbsp;</i>Delete</a>
										
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
  
  
  function categoryaddfn(val)
  {
	  //alert("adad");
	  
	  $('#categoryadd').modal('show');
	  
	  
  }
  function planpreviewfn(id) {
			var params = { cmd:'_getplan', temp:id }
            $.ajax({
				url:"./plan_ajax.php",
				dataType:"JSON",
				data:params,
				success: function(result) {
					if(result.error) {
						alert(result.msg);
					} else {
						$('#preview').html(result.html);
						$('#planpreview').modal('show');
					}
				}
			});
			return false;
		}
		$(document).ready(function(e) {
			
        });
  </script>  
  
  
 </body>
</html>