<?php
include_once("../config/config.php");
is_admin_login();
include("./functions/adminusers.php");
$users = new adminusers();
include("./includes/access.php");
$page_name ="Adminuser";

if (in_array($page_name, $admin_access))
  {
  //echo "Match found";
  }
else
  {
 header("location:accessdenied.php");
  }

if(isset($_REQUEST['action']) AND isset($_REQUEST['id']) AND $_REQUEST['id'] > 0) {
	if($_REQUEST['action'] == 'activate') {
		$users->Activate($_REQUEST['id']);
		redirect(HTTP_PATH . "admin/adminusers.php?success=2");
	}
	if($_REQUEST['action'] == 'deactivate') {
		$users->Deactivate($_REQUEST['id']);
		redirect(HTTP_PATH . "admin/adminusers.php?success=2");
	}
	redirect(HTTP_PATH . "admin/adminusers.php");
}

$userList = $users->getAllUsers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<? include('./includes/head.php'); ?>
    <style type="text/css">
	#bankAccount { width:700px; }
	.add-new { margin:-15px 0 10px 0; }
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
			
			<? //('./includes/breadcrumb.php'); ?>
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="dashboard.php">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li>Admin Users</li>
			</ul>
            
			
            
            <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '1') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> User account inserted successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
            <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '2') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> User account updated successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
			<a href="adminusers_add.php" class="btn btn-small btn-primary pull-right add-new">Add new</a>
			<div class="row-fluid sortable">	
				<div class="box span12">
					<div class="box-header">
						<h2><i class="halflings-icon white align-justify"></i><span class="break"></span>Sub Admin Users</h2>
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
									  <th>Sno</th>
                                      <th>Email</th>
                                      <th>Phone</th>
                                      <th>Account Type</th>
									  <th>Date registered</th>
									  <th>Status</th>
                                      <th>Action</th>
								  </tr>
							  </thead>   
							  <tbody>
                              <?
							  if(empty($userList)){
							  ?>
                              <tr><td colspan="7" style="text-align:center;" class="text-error">No User available to show....</td></tr>
                              <?
							  } else {
								  $sno = 1;
								  foreach($userList as $usr) {
							  ?>
								<tr>
									<td><?=$sno?></td>
                                    <td><?=$usr['email']?></td>
                                    <td><?=$usr['phone']?></td>
                                    <td>
                                    	<? if($usr['type'] == 1) { ?>
                                        Admin (Full Access)
                                        <? } elseif($usr['type'] == 2) { ?>
                                        Sub Admin (Limited Access)
                                        <? } elseif($usr['type'] == 3) { ?>
                                        Advertiser (Limited Access)
                                        <? } ?>
                                    </td>
									<td class="center"><?=date('d-M-Y h:i A', strtotime($usr['signupdate']))?></td>
									<td class="center">
                                    	<? if($usr['status'] == 0) { ?>
										<span class="label label-success">Active</span>
                                        <? } elseif($usr['status'] == 1) { ?>
                                        <span class="label">Inactive</span>
                                        <? } ?>
									</td>
                                    <td>
                                    	<? if($usr['status'] == 0) { ?>
                                        <a href="./adminusers.php?action=deactivate&id=<?=$usr['id']?>" onClick="return confirm('Do you realy want to deactivate this account?');" class="btn btn-small"><i class="halflings-icon white remove"></i>Deactiavte</a>
                                        <? } elseif($usr['status'] == 1) { ?>
                                        <a href="./adminusers.php?action=activate&id=<?=$usr['id']?>" onClick="return confirm('Do you realy want to activate this account?');" class="btn btn-small btn-success"><i class="halflings-icon white ok">&nbsp;</i>Actiavte</a>
                                        <? } ?>
                                        <a href="#" class="btn btn-small btn-primary"><i class="halflings-icon white lock"></i>Change Password</a>
                                    </td>
								</tr>
                              <? $sno++; } } ?>
							  </tbody>
						 </table>  
						 <div class="pagination pagination-centered hide">
						  <ul>
							<li><a href="#">Prev</a></li>
							<li class="active">
							  <a href="#">1</a>
							</li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">4</a></li>
							<li><a href="#">Next</a></li>
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
    
</body>
</html>