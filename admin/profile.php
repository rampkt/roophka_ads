<?php
include_once("../config/config.php");
is_admin_login();
include("./functions/adminusers.php");
include("./includes/access.php");
$user = new adminusers();
$userDetails = $user->getUser(0);

$view = 'profile';
if(isset($_REQUEST['view'])) {
	$view = $_REQUEST['view'];
}

if(isset($_REQUEST['action'])) { 
	if($_REQUEST['action'] == '_profile_edit') {
		
		if($_REQUEST['firstname'] == '' || $_REQUEST['lastname'] == '' || $_REQUEST['email'] == '' || $_REQUEST['phone'] == '') {
			redirect(HTTP_PATH . 'admin/profile.php?error=empty');
		}
		
		$data = array();
		$data['firstname'] = $db->escape_string($_REQUEST['firstname']);
		$data['lastname'] = $db->escape_string($_REQUEST['lastname']);
		$data['email'] = $db->escape_string($_REQUEST['email']);
		$data['phone'] = $db->escape_string($_REQUEST['phone']);
		
		$add = $user->save($data, 0);
		if($add) {
			
			/*$to = array($data['email']);
			$from = 'info@roophka.com';
			$subject = "Roophka : Advertiser account success.";
			$message = '<div style="width:600px;">
			Dear '.$data['firstname'].'<br>
			<p>Welcome to ROOPHKA.COM</p>
			<p>Your adversiter account is now created. please click below link to login to your account. Also your login credntials added below.</p>
			<br><a href=""></a>
			<br>
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td align="right">Username : </td>
					<td>'.$data['username'].'</td>
				</tr>
				<tr>
					<td align="right">Password : </td>
					<td>'.$data['password'].'</td>
				</tr>
			</table>
			<br>
			Thanks & regards,<br>
			<a href="roophka.com">roophka.com</a>
			</div>';
			
			$mailler->sendmail($to, $from, $subject, $message);*/
			
			redirect(HTTP_PATH . 'admin/profile.php?success=1');
		} else {
			redirect(HTTP_PATH . 'admin/profile.php?error=failed');
		}
		
	}
	if($_REQUEST['action'] == '_change_password') {
		
		$data = array();
		
		$data['current'] = $db->escape_string($_REQUEST['current']);
		$data['new'] = $db->escape_string($_REQUEST['new']);
		$data['confirm'] = $db->escape_string($_REQUEST['confirm']);
		
		$result = $user->changepassword($data);
		
		if($result['error']) {
			if($result['msg'] == 'empty')
				redirect(HTTP_PATH . "admin/profile.php?error=empty&view=password");
			elseif($result['msg'] == 'insert')
				redirect(HTTP_PATH . "admin/profile.php?error=insert&view=password");
			elseif($result['msg'] == 'currentpassword')
				redirect(HTTP_PATH . "admin/profile.php?error=currentpassword&view=password");
			elseif($result['msg'] == 'mismatch')
				redirect(HTTP_PATH . "admin/profile.php?error=mismatch&view=password");
			else
				redirect(HTTP_PATH . "admin/profile.php?error=1&view=password");
		} else {
			redirect(HTTP_PATH . "admin/profile.php?success=1&password=1");
		}
		
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
			
			<?// include('./includes/breadcrumb.php'); ?>
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="dashboard.php">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li>Admin Profile</li>
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
						<h2><i class="halflings-icon white th"></i><span class="break"></span>Admin User Profile</h2>
					</div>
					<div class="box-content">
						<ul class="nav tab-menu nav-tabs" id="myTab">
							<li class="active"><a href="#profile">Profile</a></li>
							<li class=""><a href="#password">Change password</a></li>
						</ul>
						 
						<div id="myTabContent" class="tab-content">
							<div class="tab-pane active " id="profile">
                            	<form class="form-horizontal" method="post" name="adminusers">
                                <input type="hidden" name="action" value="_profile_edit" />
                                  <fieldset>
                                    <div class="control-group">
                                      <label class="control-label" for="firstname">First Name </label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge" id="firstname" name="firstname" value="<?=$userDetails['firstname']?>" required />
                                      </div>
                                    </div>
                                    <div class="control-group">
                                      <label class="control-label" for="lastname">Last Name</label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge" id="lastname" name="lastname" value="<?=$userDetails['lastname']?>" />
                                      </div>
                                    </div>
                                    
                                    <div class="control-group">
                                      <label class="control-label" for="email">Email</label>
                                      <div class="controls">
                                        <input type="email" class="input-xlarge" id="email" name="email" value="<?=$userDetails['email']?>" required />
                                      </div>
                                    </div>
        
                                    <div class="control-group">
                                      <label class="control-label" for="phone">Mobile</label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge numberOnly" id="phone" name="phone" maxlength="10" value="<?=$userDetails['phone']?>" required />
                                        <p class="help-block">10 digit Number only</p>
                                      </div>
                                    </div>
                                    
                                    <!--<div class="control-group">
                                      <label class="control-label" for="username">Username</label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge" id="username" name="username" value="" required />
                                      </div>
                                    </div>-->
                                    
                                    <div class="form-actions">
                                      <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                  </fieldset>
                                </form>
							</div>
                            
							<div class="tab-pane" id="password">
								<form class="form-horizontal" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="_change_password" />
                                  <fieldset>
                                    <div class="control-group">
                                      <label class="control-label" for="current">Current Password </label>
                                      <div class="controls">
                                        <input type="password" class="input-xlarge" id="current" name="current" required />
                                      </div>
                                    </div>
                                    <div class="control-group">
                                      <label class="control-label" for="new">New Password</label>
                                      <div class="controls">
                                        <input type="password" class="input-xlarge" id="new" name="new" required />
                                      </div>
                                    </div>
                                    
                                    <div class="control-group">
                                      <label class="control-label" for="confirm">Confirm New Password</label>
                                      <div class="controls">
                                        <input type="password" class="input-xlarge" id="confirm" name="confirm" required />
                                      </div>
                                    </div>
        
                                    <div class="form-actions">
                                      <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                  </fieldset>
                                </form>
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