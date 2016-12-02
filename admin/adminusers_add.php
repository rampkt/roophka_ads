<?php
include_once("../config/config.php");
is_admin_login();
include("./functions/adminusers.php");
$users = new adminusers();

if(isset($_REQUEST['action'])) { 
	if($_REQUEST['action'] == '_add_user') {
		$data = array();
		$data['firstname'] = $db->escape_string($_REQUEST['firstname']);
		$data['lastname'] = $db->escape_string($_REQUEST['lastname']);
		$data['email'] = $db->escape_string($_REQUEST['email']);
		$data['phone'] = $db->escape_string($_REQUEST['phone']);
		$data['username'] = $db->escape_string($_REQUEST['username']);
		$data['password'] = $db->escape_string($_REQUEST['password']);
		$data['type'] = $db->escape_string($_REQUEST['type']);
		
		$add = $users->add($data);
		if($add) {
			
			$to = array($data['email']);
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
			
			$mailler->sendmail($to, $from, $subject, $message);
			
			redirect(HTTP_PATH . 'admin/adminusers.php?success=1');
		} else {
			redirect(HTTP_PATH . 'admin/adminusers_add.php?error=failed');
		}
		
	}
}

$genPassword = randomString(10);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<? include('./includes/head.php'); ?>
    <style type="text/css">
	.form-horizontal .form-actions { margin: 0 0 -20px 0; }
	.radio { padding:0; }
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
					<a href="adminusers.php">Admin Users</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li>Add</li>
			</ul>
			
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
            
            <div class="row-fluid">
				
				<div class="box span12">
					<div class="box-header">
						<h2><i class="halflings-icon white th"></i><span class="break"></span>Add Admin Users</h2>
					</div>
					<div class="box-content">
						
                        <div class="tab-content">
							<div class="tab-pane active">
								<form class="form-horizontal" method="post" name="adminusers">
                                <input type="hidden" name="action" value="_add_user" />
                                  <fieldset>
                                    <div class="control-group">
                                      <label class="control-label" for="firstname">First Name </label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge" id="firstname" name="firstname" value="" required />
                                      </div>
                                    </div>
                                    <div class="control-group">
                                      <label class="control-label" for="lastname">Last Name</label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge" id="lastname" name="lastname" value="" />
                                      </div>
                                    </div>
                                    
                                    <div class="control-group">
                                      <label class="control-label" for="email">Email</label>
                                      <div class="controls">
                                        <input type="email" class="input-xlarge" id="email" name="email" value="" required />
                                      </div>
                                    </div>
        
                                    <div class="control-group">
                                      <label class="control-label" for="phone">Mobile</label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge numberOnly" id="phone" name="phone" maxlength="10" value="" required />
                                        <p class="help-block">10 digit Number only</p>
                                      </div>
                                    </div>
                                    
                                    <div class="control-group">
                                      <label class="control-label" for="username">Username</label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge" id="username" name="username" value="" required />
                                      </div>
                                    </div>
                                              
                                    <div class="control-group">
                                      <label class="control-label" for="password">Password</label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge" id="password" name="password" value="<?=$genPassword?>" required />
                                      </div>
                                    </div>
                                    
                                    <div class="control-group">
                                      <label class="control-label">User Type</label>
                                      <div class="controls">
                                          <div class="col-sm-2">
                                            <input type="radio" class="input-xlarge" id="type_admin" name="type" value="1" checked />
                                            <label for="type_admin" class="radio">Admin</label>
                                          </div>
                                          <div class="col-sm-2">
                                            <input type="radio" class="input-xlarge" id="type_subadmin" name="type" value="2" />
                                            <label for="type_subadmin" class="radio">Sub-Admin</label>
                                          </div>
                                          <div class="col-sm-2">
                                            <input type="radio" class="input-xlarge" id="type_adsadmin" name="type" value="3" />
                                            <label for="type_adsadmin" class="radio">Advertiser</label>
                                          </div>
                                      </div>
                                    </div>
                                    
                                    <div class="form-actions">
                                      <button type="submit" class="btn btn-primary">Save</button>
                                      <button type="reset" class="btn">Cancel</button>
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
	
	</script>
</body>
</html>