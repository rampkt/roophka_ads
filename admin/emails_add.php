<?php
include_once("../config/config.php");
is_admin_login();
include("./functions/bulkemail.php");
$bulkemail = new bulkemail();
include("./includes/access.php");
$page_name ="Bulkmail";

if (in_array($page_name, $admin_access))
  {
  //echo "Match found";
  }
else
  {
 header("location:accessdenied.php");
  }
//echo json_encode($emails); exit;
if(isset($_REQUEST['action'])and ($_REQUEST['action']=="_addemails")) {
	$bulkemail->category=$_REQUEST['category'];
	$bulkemail->userinput=$_REQUEST['userinput'];
	if($bulkemail->userinput==1)
	{
		$bulkemail->email=$_REQUEST['email'];
		
	}
     if($bulkemail->userinput==2)
	{
		$bulkemail->email=$_FILES['fileemail'];
		
	}
	
	
		$bulkemail->emailssave();
		redirect(HTTP_PATH . "admin/emails.php?success=3");

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
					<a href="emails.php">Emails</a> 
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
						<h2><i class="halflings-icon white th"></i><span class="break"></span>Add New Emails</h2>
					</div>
					<div class="box-content">
						
						<div class="tab-content">
							<div class="tab-pane active id="textadd">
								<form class="form-horizontal" name="emailform" method="post" action="emails_add.php" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="_addemails" />
                             
                                  <fieldset>
								 <br>
                                    <div class="control-group">
                                      <label class="control-label" for="name">Category:</label>
                                      <div class="controls">
                                      <select name="category" id="category" class="input-xlarge"  required>
									  <option value="">Select Category</option>
									  <?php echo $bulkemail->getallcategory(); ?>
									  </select>
									  
									  </div>
                                    </div>
									
									 
									 <div class="control-group">
                                      <label class="control-label" for="userinput">Emails Input:</label>
                                      <div class="controls-label">
                                       <label for="emailuser" style="width:100px;margin-top: 8px;" class="pull-left">
										<input type="radio" name="userinput" id="emailuser" value="1" onclick="userinputfn(1);" checked> Text
										</label>
										<label for="iduser" style="width:120px;margin-top: 8px;" class="pull-left">
										<input type="radio" name="userinput" id="iduser" value="2" onclick="userinputfn(2);"> File upload
										</label>
                                      </div>
                                    </div>
									 
									 
									 <div class="control-group " id="textinput" style="display:block;">
                                      <label class="control-label" for="content">Email Address:</label>
                                      <div class="controls">
                                       <input type="text" name="email" id="email" placeholder="Enter email address here..." class="input-xlarge" required />
									   <p class="help-block">Emails separated by , symbol.</p>
                                      </div>
                                    </div>
									
									<div class="control-group " id="fileinput" style="display:none;">
                                      <label class="control-label" for="content">Upload Emails:</label>
                                      <div class="controls">
                                       <input type="file" name="fileemail" id="fileemail" class="input-xlarge" onchange="ValidateFileUploadCSV();" />
									   <p class="help-block">Sample CSV file <a href="./csv/sample.csv" style="color:blue;">here.</a></p>
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
		<script>
		 function ValidateFileUploadCSV() {
        var fuData = document.getElementById('fileemail');
        var FileUploadPath = fuData.value;

//To check if user upload any file
        if (FileUploadPath == '') {
            alert("Please upload CSV File");

        } else {
            var Extension = FileUploadPath.substring(
                    FileUploadPath.lastIndexOf('.') + 1).toLowerCase();

//The file uploaded is an image

if (Extension == "csv") {

// To Display

            } 

//The file upload is NOT an image
else {
                alert("Upload only allows file types of CSV");
				document.getElementById('fileemail').value="";
			//	$('#spanfile').html("");

            }
        }
    }
	
		
		function userinputfn(val)
	{
	//	alert(val);
		if(val==1)
		{
			$('#textinput').show();
			$('#fileinput').hide();	
			$('#email').attr('required','required');
			$('#fileemail').removeAttr('required');	
		}
	    if(val==2)
		{
			$('#textinput').hide();
			$('#fileinput').show();	
			$('#fileemail').attr('required','required');
			$('#email').removeAttr('required');	
		}
	}
		</script>
	
	<!-- start: JavaScript-->
	<? include('./includes/footerinclude.php'); ?>
	<!-- end: JavaScript-->
	
</body>
</html>