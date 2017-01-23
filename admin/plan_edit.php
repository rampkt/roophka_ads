<?php
include_once("../config/config.php");
is_admin_login();
include("./functions/plans.php");
$plans = new plans();
include("./includes/access.php");
$page_name ="plan";
$id=$_REQUEST['id'];
$planedit=$plans->planedit($id);


if (in_array($page_name, $admin_access))
  {
  //echo "Match found";
  }
else
  {
 header("location:accessdenied.php");
  }
//echo json_encode($emails); exit;
if(isset($_REQUEST['action'])and ($_REQUEST['action']=="_addplan")) {
	$plans->category=$_REQUEST['category'];
	$plans->fromsec=$_REQUEST['fromsec'];
	$plans->tosec=$_REQUEST['tosec'];
	$plans->amount=$_REQUEST['amount'];
	$plans->viewers=$_REQUEST['viewers'];
	$plans->id=$_REQUEST['id'];
		$plans->planeditsave();
		
		redirect(HTTP_PATH . "admin/plandetails.php?success=5");

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
					<a href="plandetails.php">Plan Details</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li>Edit</li>
			</ul>
            
            <!--<div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Oh snap!</strong> Change a few things up and try submitting again.
            </div>
            <div class="clearfix"></div>-->
            
            <div class="row-fluid">
				
				<div class="box span12">
					<div class="box-header">
						<h2><i class="halflings-icon white th"></i><span class="break"></span>Edit Plan Details</h2>
					</div>
					<div class="box-content">
						
						<div class="tab-content">
							<div class="tab-pane active id="textadd">
								<form class="form-horizontal" name="emailform" method="post" action="plan_edit.php" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="_addplan" />
                             
                                  <fieldset>
								 <br>
                                    <div class="control-group">
                                      <label class="control-label" for="name">Category:</label>
                                      <div class="controls">
                                      <select name="category" id="category" class="input-xlarge"  required>
									  <option value="">Select Category</option>
									  <?php echo $plans->getallcategory($planedit['catid']); ?>
									  </select>
									  
									  </div>
                                    </div>
									
									 
									 <div class="control-group">
                                      <label class="control-label" for="sec">Seconds:</label>
                                      <div class="controls">
                                       <label for="fromsec" class="pull-left" >
										<input type="text" name="fromsec" id="fromsec" value="<?php echo $planedit['from_sec']; ?>" style="width:110px;" placeholder="From..." required> 
										&nbsp;&nbsp; to &nbsp;&nbsp;</label>
										<label for="tosec" class="pull-left" >
										<input type="text" name="tosec" id="tosec" value="<?php echo $planedit['to_sec']; ?>" style="width:107px;" placeholder="To..." required>
										</label>
                                      </div>
                                    </div>
									 
									 
									 <div class="control-group ">
                                      <label class="control-label" for="content">Amount:</label>
                                      <div class="controls">
                                       <input type="text" name="amount" id="amount" placeholder="Enter amount here..." value="<?php echo $planedit['amount']; ?>" class="input-xlarge" required />
									    <p class="help-block">Numeric Values only.</a></p>
                                      </div>
                                    </div>
									
									<div class="control-group ">
                                      <label class="control-label" for="content">Viewers:</label>
                                      <div class="controls">
                                        <input type="text" name="viewers" id="viewers" value="<?php echo $planedit['viewers']; ?>" placeholder="Enter viewers count here..." class="input-xlarge" required />
									   <p class="help-block">Numeric Values only.</a></p>
                                      </div>
                                    </div>
									
									<input type="hidden" name="id" value="<?php echo $id; ?>">
                                    
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