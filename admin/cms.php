<?php
include_once("../config/config.php");
is_admin_login();
include("./functions/cms.php");
$cms = new cms();
include("./includes/access.php");
$page_name ="CMS";

if (in_array($page_name, $admin_access))
  {
  //echo "Match found";
  }
else
  {
 header("location:accessdenied.php");
  }


$cms->getcms(1);
if(isset($_REQUEST['action']) AND $_REQUEST['action'] == '_add_cms') {
	//print_r($_REQUEST);
	
	$cms->aboutus = $db->escape_string($_REQUEST['aboutus']);
	$cms->privacy = $db->escape_string($_REQUEST['privacy']);
	$cms->terms = $db->escape_string($_REQUEST['terms']);
	$cms->howitworks = $db->escape_string($_REQUEST['howitworks']);
	$cms->scroll_text = $db->escape_string($_REQUEST['scroll_text']);
	
	$save = $cms->save();
	if($save === false) {
			redirect(HTTP_PATH . 'admin/cms.php?error=failed');
	}
	
	redirect(HTTP_PATH . 'admin/cms.php?success=1');
	
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
				<li>CMs Page</li>
			</ul>
			
			<? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '1') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> CMS Page content is updated successfully.
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
						<h2><i class="halflings-icon white th"></i><span class="break"></span>Site cms</h2>
					</div>
					<div class="box-content">
						
						<div class="tab-content">
							<div class="tab-pane active id="textadd">
								<form class="form-horizontal" method="post" action="cms.php" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="_add_cms" />
                             
                                  <fieldset>
                                   
									 <div class="control-group ">
                                      <label class="control-label" for="aboutus">About Us:</label>
                                      <div class="controls">
                                        <textarea class="cleditor" id="aboutus" rows="3" name="aboutus" required><?=$cms->aboutus?></textarea>
                                      </div>
                                    </div>
                                     <div class="control-group ">
                                      <label class="control-label" for="privacy">Privacy Policy:</label>
                                      <div class="controls">
                                        <textarea class="cleditor" id="privacy" rows="3" name="privacy" required><?=$cms->privacy?></textarea>
                                      </div>
                                    </div>
        
                                    <div class="control-group ">
                                      <label class="control-label" for="terms">Terms & Conditions:</label>
                                      <div class="controls">
                                        <textarea class="cleditor" id="terms" rows="3" name="terms" required><?=$cms->terms?></textarea>
                                      </div>
                                    </div>
                                   
                                    <div class="control-group ">
                                      <label class="control-label" for="scroll_text">Header Scrolling text:</label>
                                      <div class="controls">
                                        <textarea class="cleditor" id="scroll_text" rows="3" name="scroll_text" required><?=$cms->scroll_text?></textarea>
                                      </div>
                                    </div>								   
									
                                    <div class="control-group ">
                                      <label class="control-label" for="howitworks">How it Works:</label>
                                      <div class="controls">
                                        <textarea class="cleditor" id="howitworks" rows="3" name="howitworks" required><?=$cms->howitworks?></textarea>
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