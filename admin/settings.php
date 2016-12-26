<?php
include_once("../config/config.php");
is_admin_login();
include("./functions/setting.php");
$settings = new settings();
include("./includes/access.php");
$page_name ="Settings";

if (in_array($page_name, $admin_access))
  {
  //echo "Match found";
  }
else
  {
 header("location:accessdenied.php");
  }


$settings->getsetting(1);
if(isset($_REQUEST['action']) AND $_REQUEST['action'] == '_add_settings') {
	//print_r($_REQUEST);
	
	$settings->website_name = $db->escape_string($_REQUEST['website_name']);
	$settings->website_title = $db->escape_string($_REQUEST['website_title']);
	$settings->keywords = $db->escape_string($_REQUEST['keywords']);
	$settings->description = $db->escape_string($_REQUEST['description']);
	$settings->admin_mail = $db->escape_string($_REQUEST['admin_mail']);
	$settings->website_url = $db->escape_string($_REQUEST['website_url']);
	
	$settings->file = $_FILES['logo'];
	
	//$emptycheck = $settings->emptycheck();
	if($emptycheck === false) {
		
			redirect(HTTP_PATH . 'admin/settings.php?error=empty');
	}
	
	$save = $settings->save();
	if($save === false) {
			redirect(HTTP_PATH . 'admin/settings.php?error=failed');
	}
	
	redirect(HTTP_PATH . 'admin/settings.php?success=1');
	
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
				<li>Settings</li>
			</ul>
			
			<? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '1') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> Settings is updated successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
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
            
            
            <!--<div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Oh snap!</strong> Change a few things up and try submitting again.
            </div>
            <div class="clearfix"></div>-->
            
            <div class="row-fluid">
				
				<div class="box span12">
					<div class="box-header">
						<h2><i class="halflings-icon white th"></i><span class="break"></span>Site Settings</h2>
					</div>
					<div class="box-content">
						
						<div class="tab-content">
							<div class="tab-pane active id="textadd">
								<form class="form-horizontal" method="post" action="settings.php" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="_add_settings" />
                             
                                  <fieldset>
                                    <div class="control-group">
                                      <label class="control-label" for="website_name">Website Name: </label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge" id="website_name" name="website_name" value="<?=$settings->webname?>" placeholder="Enter website name here" required />
                                      </div>
                                    </div>
									<div class="control-group">
                                      <label class="control-label" for="website_name">Website Title: </label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge" id="website_title" name="website_title" value="<?=$settings->title?>"  placeholder="Enter website name here" required />
                                      </div>
                                    </div>
									
                                    <div class="control-group">
                                      <label class="control-label" for="keywords">Website Keywords:</label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge" id="keywords" name="keywords" value="<?=$settings->webkeyword?>"  placeholder="Enter website keywords here"  required />
                                      </div>
                                    </div>
                                    
                                    <div class="control-group">
                                      <label class="control-label" for="website_url">Website Url:</label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge" id="website_url" name="website_url" value="<?=$settings->weburl?>" placeholder="Enter website url here"  required />
                                      </div>
                                    </div>
        
                                   <div class="control-group">
                                      <label class="control-label" for="admin_mail">Admin E-mail:</label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge" id="admin_mail" name="admin_mail" value="<?=$settings->email?>" placeholder="Enter admin email here"  required />
                                      </div>
                                    </div>
                                    
									 <div class="control-group">
                                      <label class="control-label" for="admin_mail">Upload image:</label>
                                      <div class="controls">
                                        <input type="file" class="input-xlarge" id="logo" name="logo"  />
                                      </div>
                                    </div>
                                    
									 <div class="control-group">
                                      <label class="control-label" for="admin_mail">Existing image:</label>
                                      <div class="controls">
                                        <img src="<?=HTTP_PATH?>uploads/logo/<?=$settings->filehash?>.attach" alt="logo" style="width:100px; height:100px;">
                                      </div>
                                    </div>
                                              
                                    <div class="control-group ">
                                      <label class="control-label" for="description">Description:</label>
                                      <div class="controls">
                                        <textarea class="cleditor" id="description" rows="3" name="description"required><?=$settings->description?></textarea>
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
	
</body>
</html>