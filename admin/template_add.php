<?php
include_once("../config/config.php");
is_admin_login();
include("./functions/bulkemail.php");
$bulkemail = new bulkemail();

//echo json_encode($emails); exit;
if(isset($_REQUEST['action'])and ($_REQUEST['action']=="_addtemplate")) {
	$bulkemail->name=$_REQUEST['name'];
	$bulkemail->content=$_REQUEST['content'];
		$bulkemail->templatesave();
		redirect(HTTP_PATH . "admin/templates.php?success=3");

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
				<li>
					<i class="icon-home"></i>
					<a href="templates.php">Template</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li>Add</li>
			</ul>
            
            <!--<div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Oh snap!</strong> Change a few things up and try submitting again.
            </div>
            <div class="clearfix"></div>-->
            
            <div class="row-fluid">
				
				<div class="box span12">
					<div class="box-header">
						<h2><i class="halflings-icon white th"></i><span class="break"></span>Add New Template</h2>
					</div>
					<div class="box-content">
						
						<div class="tab-content">
							<div class="tab-pane active id="textadd">
								<form class="form-horizontal" name="templateform" method="post" action="template_add.php" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="_addtemplate" />
                             
                                  <fieldset>
								 <br>
                                    <div class="control-group">
                                      <label class="control-label" for="name">Template Name:</label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge" id="name" name="name" placeholder="Enter template name here..."  required />
                                      </div>
                                    </div>
									
									 <div class="control-group ">
                                      <label class="control-label" for="content">Template content:</label>
                                      <div class="controls">
                                        <textarea cols="50" class="cleditor" id="content" name="content" rows="10" required ></textarea>

                                      </div>
                                    </div>
                                    
                                    <div class="form-actions">
									<button type="button" class="btn btn-success" onclick="templatepreviewfn();">Preview</button>
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
	<div class="modal hide fade" id="templatepreview" style="width:60%;left:40%;">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">x</button>
			<h3>Template Preview</h3>
		</div>
		<div class="modal-body" id="categoryResult">
			
			<div id="preview">&nbsp;</div>
			
		</div>
		<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Close</a>
		</div>
		
	</div>
		
	<!-- start: JavaScript-->
	<? include('./includes/footerinclude.php'); ?>
	<!-- end: JavaScript-->
	
	<script>
	  function templatepreviewfn()
  {
	  //alert("adad");
	 var val= document.templateform.content.value;
	  if(val=="")
	  {
		  alert("please add content first!");
		  $('#content').focus();
		  
	  }else{
	  $('#preview').html(val);
	  $('#templatepreview').modal('show');
	  }
	  
	  
  }
	
	</script>
</body>
</html>