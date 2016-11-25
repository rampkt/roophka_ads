<?php
include_once("../config/config.php");
is_admin_login();
include("./functions/adminusers.php");
$user = new adminusers();
$userDetails = $user->getUserdetails($_REQUEST['id']);
$start = $user->start;
$view = 'profile';
list($bankList,$pagination) = $user->getAllbankdetails($_REQUEST['id']);

list($adslist,$pagination) = $user->getAlltransaction($_REQUEST['id']);


if(isset($_REQUEST['action']) AND isset($_REQUEST['id']) AND $_REQUEST['id'] > 0) 
{
	if($_REQUEST['action'] != 'view') {
	$uid=$_REQUEST['uid'];
	
	if($_REQUEST['action'] == 'bankactivate') {
		$user->bankActivate($_REQUEST['id']);
		redirect(HTTP_PATH . "admin/viewprofile.php?id=$uid&success=2");
	}
	if($_REQUEST['action'] == 'bankdeactivate') {
		$user->bankDeactivate($_REQUEST['id']);
		redirect(HTTP_PATH . "admin/viewprofile.php?id=$uid&success=3");
	}
	if($_REQUEST['action'] == 'bankdelete') {
		$user->bankDelete($_REQUEST['id']);
		redirect(HTTP_PATH . "admin/viewprofile.php?id=$uid&success=4");
	}
	redirect(HTTP_PATH . "admin/viewprofile.php?id=$uid");
	
}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<? include('./includes/head.php'); ?>
    <style type="text/css">
	.form-horizontal .form-actions { margin: 0 0 -20px 0; }
	.tab-menu.nav-tabs > li > a {
		color:#FFF;
	}
	.tab-menu.nav-tabs > li > a:hover {
		color:#555;
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
				
				<li>
					<a href="users.php">Users</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li>Profile</li>
			</ul>
			
            <? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == 'currentpassword') { ?>
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Error!</strong> Invalid current password...
            </div>
            <div class="clearfix"></div>
            <? } ?>
            
            <? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == 'mismatch') { ?>
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Error!</strong> New password and confirm password mismatch, Please try again...
            </div>
            <div class="clearfix"></div>
            <? } ?>
            
            <? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == 'insert') { ?>
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Error!</strong> Data update issue, Please try again or after some time later.
            </div>
            <div class="clearfix"></div>
            <? } ?>
            
            <? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == '1') { ?>
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Error!</strong> Some thing went wrong, Please try again later.
            </div>
            <div class="clearfix"></div>
            <? } ?>
            
            <? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == 'empty') { ?>
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Error!</strong> All field should be filled.
            </div>
            <div class="clearfix"></div>
            <? } ?>
            
            <? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == 'failed') { ?>
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Error!</strong> Insert failed, Please contact developer regarding this issue.
            </div>
            <div class="clearfix"></div>
            <? } ?>
            
			 <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '2') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong>Banks details activated successfully!
            </div>
            <div class="clearfix"></div>
            <? } ?>
            
			 <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '3') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong>Banks details deactivated successfully!
            </div>
            <div class="clearfix"></div>
            <? } ?>
			
			 <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '4') { ?>
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong>Banks details deleted successfully!
            </div>
            <div class="clearfix"></div>
            <? } ?>
			
            <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '1') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> <? if(isset($_REQUEST['password'])) { ?>Password changed successfully....<? } else { ?>User profile updated successfully.<? } ?>
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
            
            <div class="row-fluid">
				
				<div class="box span12">
					<div class="box-header">
						<h2><i class="halflings-icon white th"></i><span class="break"></span>View User Profile</h2>
					</div>
					<div class="box-content">
						<ul class="nav tab-menu nav-tabs" id="myTab">
						<li class="active"><a href="#profile">View Profile</a></li>
							<li class=""><a href="#bankdetails">Bank Details</a></li>
							<li class=""><a href="#transactions">Transactions</a></li>
							
						</ul>
						 
						<div id="myTabContent" class="tab-content">
							<div class="tab-pane active " id="profile">
                            	<form class="form-horizontal" method="post" name="adminusers">
                                <input type="hidden" name="action" value="_profile_edit" />
                                  <fieldset>
                                    <div class="control-group">
                                      <label class="control-label" for="firstname">First Name: </label>
                                      <div class="control-label" style="text-align:left; padding-left:25px;" for="firstnameval">
                                       <?=$userDetails['firstname']?>
                                      </div>
                                    </div>
                                    <div class="control-group">
                                      <label class="control-label" for="lastname">Last Name:</label>
                                      <div class="control-label" for="lastnameval" style="text-align:left; padding-left:25px;">
                                        <?=$userDetails['lastname']?>
                                      </div>
                                    </div>
                                    
                                    <div class="control-group">
                                      <label class="control-label" for="email">Email:</label>
                                      <div class="control-label" for="emailval" style="text-align:left; padding-left:25px;">
                                       <?=$userDetails['email']?>
                                      </div>
                                    </div>
        
                                    <div class="control-group">
                                      <label class="control-label" for="phone">Mobile:</label>
                                      <div class="control-label" for="phoneval" style="text-align:left; padding-left:25px;">
                                        <?=$userDetails['phone']?>
                                      </div>
                                    </div>
									
									<div class="control-group">
                                      <label class="control-label" for="dob">DOB:</label>
                                      <div class="control-label" for="dobval" style="text-align:left; padding-left:25px;">
                                        <?=$userDetails['dob']?>
                                      </div>
                                    </div>
									
                                    <div class="control-group">
                                      <label class="control-label" for="address">Address:</label>
                                      <div class="control-label" for="addressval" style="text-align:left; padding-left:25px;">
                                        <?=$userDetails['address']?>
                                      </div>
                                    </div>
									
									 <div class="control-group">
                                      <label class="control-label" for="pincode">Pincode:</label>
                                      <div class="control-label" for="pincodeval" style="text-align:left; padding-left:25px;">
                                        <?=$userDetails['pincode']?>
                                      </div>
                                    </div>
									
									 <div class="control-group">
                                      <label class="control-label" for="country">Country:</label>
                                      <div class="control-label" for="countryval" style="text-align:left; padding-left:25px;">
                                       <?php $country= $user->getcountry($userDetails['country']); ?>
									   <?=$country['name']?>
                                      </div>
                                    </div>
									
									<div class="control-group">
                                      <label class="control-label" for="state">State:</label>
                                      <div class="control-label" for="stateval" style="text-align:left; padding-left:25px;">
									  <?php $state= $user->getstate($userDetails['state']); ?>
                                        <?=$state['name']?>
                                      </div>
                                    </div>
									
									<div class="control-group">
                                      <label class="control-label" for="city">City:</label>
                                      <div class="control-label" for="cityval" style="text-align:left; padding-left:25px;">
									  <?php $city= $user->getcity($userDetails['city']); ?>
                                        <?=$city['name']?>
                                      </div>
                                    </div>
									
									<div class="control-group">
                                      <label class="control-label" for="account">Account Balance:</label>
                                      <div class="control-label" for="accountval" style="text-align:left; padding-left:25px;">
                                        &#8377;&nbsp;<?=$userDetails['account_balance']?>
                                      </div>
                                    </div>
									
									<div class="control-group">
                                      <label class="control-label" for="lastlogin">Last Login:</label>
                                      <div class="control-label" for="lastloginval" style="text-align:left; padding-left:25px;">
                                        <?=$userDetails['lastlogin']?>
                                      </div>
                                    </div>
									
									<div class="control-group">
                                      <label class="control-label" for="signup">Signup Date:</label>
                                      <div class="control-label" for="signupdateval" style="text-align:left; padding-left:25px;">
                                        <?=$userDetails['signupdate']?>
                                      </div>
                                    </div>
									
									<div class="control-group">
                                      <label class="control-label" for="demo">Demo:</label>
                                      <div class="control-label" for="demoval" style="text-align:left; padding-left:25px;">
                                      <? if($userDetails['demo'] == 0) { ?>
										<span class="label label-success" style="padding:6px;">Normal</span>
                                        <? } elseif($userDetails['demo'] == 1) { ?>
                                        <span class="label" style="padding:6px;">Active</span>
                                        <? } ?>
                                      </div>
                                    </div>
									
									
									<div class="control-group">
                                      <label class="control-label" for="status">Status:</label>
                                      <div class="control-label" for="statusval" style="text-align:left; padding-left:25px;">
									  <? if($userDetails['status'] == 0) { ?>
										<span class="label label-success" style="padding:6px;">Active</span>
                                        <? } elseif($userDetails['status'] == 1) { ?>
                                        <span class="label" style="padding:6px;">Inactive</span>
                                        <? } ?>
                                       
                                      </div>
                                    </div>
                                    <!--<div class="control-group">
                                      <label class="control-label" for="username">Username</label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge" id="username" name="username" value="" required />
                                      </div>
                                    </div>-->
                                    
                                    <div class="form-actions">
                                      &nbsp;
                                    </div>
                                  </fieldset>
                                </form>
							</div>
                            
							<div class="tab-pane" id="bankdetails">
								<div class="box-content">
						<table class="table table-bordered table-striped table-condensed">
							  <thead>
								  <tr>
									  <th>Sno</th>
                                      <th>Name</th>
                                      <th>Bank Name</th>
                                      <th>Account Name</th>
                                      <th>Number</th>
									  <th>Branch</th>
									  <th>Ifsc</th>
									  <th>Date</th>
									  <th>Status</th>
                                      <th style="width:235px;">Action</th>
								  </tr>
							  </thead>   
							  <tbody>
                              <?
							  if(empty($bankList)){
							  ?>
                              <tr><td colspan="10" style="text-align:center;" class="text-error">No bank details to show....</td></tr>
                              <?
							  } else {
								  $sno = $start + 1;
								  foreach($bankList as $bank) {
							  ?>
								<tr>
									<td><?=$sno?></td>
                                    <td ><?=$bank['name']?></td>
                                    <td><?=$bank['bank']?></td>
                                    <td class="center"><?=$bank['ac_name']?></td>
                                    <td class="center">
										<?=$bank['number']?></td>
									<td class="center">
										<?=$bank['branch']?></td>	
									<td class="center">
										<?=$bank['ifsc']?></td>	
									<td class="center"><?=date('d-M-Y h:i A', strtotime($bank['date_added']))?></td>
									<td class="center">
                                    	<? if($bank['status'] == 0) { ?>
										<span class="label label-success" style="padding:6px;">Active</span>
                                        <? } elseif($bank['status'] == 1) { ?>
                                        <span class="label" style="padding:6px;">Inactive</span>
                                        <? } ?>
									</td>
                                    <td>
                                    	<? if($bank['status'] == 0) { ?>
                                        <a href="./viewprofile.php?action=bankdeactivate&id=<?=$bank['id']?>&uid=<?=$bank['userid']?>" onClick="return confirm('Do you realy want to deactivate this account?');" class="btn btn-small"><i class="halflings-icon white remove"></i>Deactiavte</a>
                                        <? } elseif($bank['status'] == 1) { ?>
                                        <a href="./viewprofile.php?action=bankactivate&id=<?=$bank['id']?>&uid=<?=$bank['userid']?>" onClick="return confirm('Do you realy want to activate this account?');" class="btn btn-small btn-success"><i class="halflings-icon white ok">&nbsp;</i>Actiavte</a>
                                        <? } ?>
                                       <a href="./viewprofile.php?action=bankdelete&id=<?=$bank['id']?>&uid=<?=$bank['userid']?>" onClick="return confirm('Do you realy want to delete this account?');" class="btn btn-small btn-primary"><i class="halflings-icon white ok">&nbsp;</i>Delete</a>
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
				
				
								
								</div>
                          
                             <div class="tab-pane" id="transactions">
                             <div class="box-content">
						<table class="table table-bordered table-striped table-condensed">
							  <thead>
								   <tr>
									  <th>SNO</th>
                                      <th>Ads Name</th>
									  <th>Type</th>
									  <th>Amount</th>
									  <th>details</th>
									  <th>ip</th>
									  <th>Visitor Location</th>
									  <th>view Time</th>
                                      <th>Demo</th>
								  </tr>
							  </thead>   
							  <tbody>
                              <?
							  if(empty($adslist)){
							  ?>
                              <tr><td colspan="9" style="text-align:center;" class="text-error">No transactions available to show....</td></tr>
                              <?
							  } else {
								  $sno = $start + 1;
								  foreach($adslist as $ad) {
							  ?>
								<tr>
									<td><?=$sno?></td>
									<td><?=$ad['adname']?></td>
									<td class="center"><?=$ad['type']?></td>
                                    <td class="center"><?=$ad['amount']?></td>
									<td class="center"><?=$ad['detail']?></td>
									<td class="center"><?=$ad['ipaddr']?></td>
									<td class="center"><?=$ad['visitor_location']?></td>
									<td class="center"><?=date('d-M-Y h:i A', strtotime($ad['date_added']))?></td>
									
									<td class="center">
                                    	<? if($ad['demo'] == 0) { ?>
										<span class="label label-success">Available</span>
                                        <? } elseif($ad['demo'] == 1) { ?>
                                        <span class="label">Not-Available</span>
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
				
							 
							 </div>							 
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
	<script type="text/javascript">
	var tabtype = '<?=$view?>';
	$(document).ready(function(e) {
        if(tabtype == 'password') {
			$('.nav-tabs a[href="#password"]').tab('show');
		} 
    });
	</script>
</body>
</html>