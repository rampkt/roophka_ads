<?php
include_once("../config/config.php");
is_admin_login();
include("./functions/ads.php");
$ads = new ads();
$emails=$ads->getAlladminUsersemail();
if(isset($_REQUEST['action']) AND isset($_REQUEST['id']) AND $_REQUEST['id'] > 0) {
	if($_REQUEST['action'] == 'activate') {
		$ads->adActivate($_REQUEST['id']);
		redirect(HTTP_PATH . "admin/ads.php?success=2");
	}
	if($_REQUEST['action'] == 'deactivate') {
		$ads->adDeactivate($_REQUEST['id']);
		redirect(HTTP_PATH . "admin/ads.php?success=2");
	}
	if($_REQUEST['action'] == 'delete') {
		$ads->adDelete($_REQUEST['id']);
		redirect(HTTP_PATH . "admin/ads.php?success=3");
	}
	
	if($_REQUEST['action'] == '_change_user') {
		$ads->adChangeUser($_REQUEST['id'],$_REQUEST['email']);
		redirect(HTTP_PATH . "admin/ads.php?success=4");
	}
	
	redirect(HTTP_PATH . "admin/ads.php");
}

$page = (isset($_REQUEST['page']) ? $_REQUEST['page'] : 1);
list($adslist, $pagination) = $ads->getAllAds($page);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<? include('./includes/head.php'); ?>
    <style type="text/css">
	.add-new { margin:-15px 0 10px 0; }
	 .breadcrumb a 
	{
		color:#08c !important;
	}
	.typeahead 
	{
		width:282px;
		border-radius:0px;
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
					<a href="dashboard.php">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li>Ads</li>
			</ul>
            
            
            <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '1') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> Ad inserted successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
            <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '2') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> Ad updated successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
            <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '3') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> Ad deleted successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
			<? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '4') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> Ad User changed successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
			
			<a href="ads_add.php" class="btn btn-small btn-primary pull-right add-new">Add new</a>
			<div class="row-fluid ">	
				<div class="box span12">
					<div class="box-header">
						<h2><i class="halflings-icon white align-justify"></i><span class="break"></span>Ads list</h2>
						<div class="box-icon">
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
									 
                                      <th style="width: 150px;">AD NAME</th>
									   <th>USERNAME</th>
									   <th>USEREMAIL</th>
									  <th>TYPE</th>
									  <th>COUNT</th>
									  <th>STATUS</th>
                                      <th>ACTION</th>
								  </tr>
							  </thead>   
							  <tbody>
                              	<? if(empty($adslist)) { ?>
                                <tr><td style="text-align:center;" colspan="8"><font color="red">No records to show</font></td></tr>
                                <? } else { 
									$sno = 1;
									foreach($adslist as $ad) {
								?>
								<tr id="adrow<?=$ad['id']?>">
                                	<td><?=$sno?></td>
									
									<td><a href="./ads_details.php?action=details&id=<?=$ad['id']?>" style="color:#08c;"> <?=$ad['name']?></a></td>
									<td><?=$ad['username']?></td>
									<td><?=$ad['email']?></td>
									
									<td class="center"><?=$ad['type']?></td>
									<td class="center"><?=$ad['clicks_remain']?>/<?=$ad['watch_count']?></td>
									<td class="center status_column">
                                    	<? if($ad['status'] == 0) { ?>
										<span class="label label-success">Active</span>
                                        <? } else { ?>
                                        <span class="label">Inactive</span>
                                        <? } ?>
									</td>
                                    <td>
                                    	<? if($ad['status'] == 1) { ?>
                                        	<a href="./ads.php?action=activate&id=<?=$ad['id']?>" onClick="return confirm('Do you want to activate this record?')" class="btn btn-small btn-success"><i class="halflings-icon white ok">&nbsp;</i> Activate</a>
                                        <? } else { ?>
                                        	<a href="./ads.php?action=deactivate&id=<?=$ad['id']?>" onClick="return confirm('Do you want to deactivate this                            record?')" class="btn btn-small"><i class="halflings-icon white remove"></i> Deactivate</a>
                                        <? } ?>
                                    	
                                    	<a href="./ads_add.php?action=edit&id=<?=$ad['id']?>" class="btn btn-small btn-primary"><i class="halflings-icon white edit"></i> Edit</i></a>
                                        <a href="./ads.php?action=delete&id=<?=$ad['id']?>" onClick="return confirm('Do you want to delete this record?')" class="btn btn-small btn-danger"><i class="halflings-icon white trash"></i> Delete</i></a>
										
										<a href="javascript:void(0);" onClick="changeidfn(<?=$ad['id']?>)" class="btn btn-small btn-warning" id="changeidfn"><i class="halflings-icon white edit"></i> Change User</i></a>
										
                                    </td>
								</tr>
                                <? $sno++; } } ?>                                   
							  </tbody>
						 </table>  
						 <div class="pagination pagination-centered">
                         	<?=$pagination?>
						  <!--<ul>
							<li><a href="#">Prev</a></li>
							<li class="active">
							  <a href="#">1</a>
							</li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">4</a></li>
							<li><a href="#">Next</a></li>
						  </ul>-->
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
	 <div class="modal hide fade" id="changeuserid">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">x</button>
			<h3>Change ad user</h3>
		</div>
		<div class="modal-body" id="AjaxResult" style="overflow:visible;">
			
			<form class="form-horizontal" method="post" action="ads.php" name="changeuserform" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="_change_user" />
                             
                                  <fieldset>
                                    <div class="control-group">
                                      <label class="control-label" for="email">User Email: </label>
                                      <div class="controls">
                                       
									   <input type="text" name="email" id="email" autocomplete="off" class="input-xlarge" placeholder="Type user email here" style="margin: 0 auto;" data-provide="typeahead" data-items="4" data-source="<?=htmlentities(json_encode($emails));?>" required>
									   
                                      </div>
                                    </div>
									
									<input type="hidden" name="id" id="adid">
									</fieldset>

			</form>
		</div>
		<div class="modal-footer">
		<a href="javascript:void(0)" class="btn btn-primary" data-dismiss="modal" id="changeusersubmit">Submit</a>	<a href="#" class="btn" data-dismiss="modal">Close</a>
		</div>
	</div>
	
	<script>
	function changeidfn(id){
		//alert("sdfsdf");
		//e.preventDefault();
		$('#adid').val(id);
		$('#changeuserid').modal('show');
	}
	
	$('#changeusersubmit').click(function()
	{
		document.changeuserform.submit();
		
	});
	
	</script>
	
</body>
</html>