<?php
include_once("../config/config.php");
is_admin_login();
include("./functions/bulkemail.php");
$bulkemail = new bulkemail();
include("./functions/location.php");
$location = new location();


$alltemplateList=$bulkemail->AllemailTemplate();
//echo json_encode($emails); exit;
if(isset($_REQUEST['action'])and ($_REQUEST['action']=="_composeemails")) {
	
	$bulkemail->subject=$_REQUEST['subject'];
	$bulkemail->category=$_REQUEST['category'];
	$bulkemail->eids=$_REQUEST['emailids'];
	$eids=$_REQUEST['emailids'];
	$bulkemail->userinput=$_REQUEST['userinput'];
	$bulkemail->adminemail=$location->getsetting('1','email');
	
		if($bulkemail->userinput==1)
	{
		$bulkemail->message=$_REQUEST['textvalue'];
		$ids=explode(",", $eids);
		    foreach($ids as $eid)
			{
				
			$sql="SELECT * FROM roo_emails where id='$eid'";
			//echo $sql; exit;
			$res=$db->query($sql);
			while($row=$db->fetch_array($res))
			{
		
	        $to = array($row['email']);
			$from =$bulkemail->adminemail;
			$subject = $bulkemail->subject;
			$message = '<div style="width:600px;">
			Dear<br>
			<p>Welcome to ROOPHKA.COM</p>
			<br>
			<table cellpadding="0" cellspacing="0" border="0">
			
				<tr>
					<td>'.$bulkemail->message.'</td>
				</tr>
				
			</table>
			<br>
			Thanks & regards,<br>
			<a href="roophka.com">roophka.com</a>
			</div>';
			
			$mailler->sendmail($to, $from, $subject, $message);
			}
			}
			
	}
	if($bulkemail->userinput==3)
	{
		$bulkemail->message=$_REQUEST['tempid'];
		$tem=$bulkemail->templateedit($_REQUEST['tempid']);
		$temname=$tem['template_name'];
		$temcont=$tem['template_content'];
		
		$ids=explode(",", $eids);
		    foreach($ids as $eid)
			{
				
			$sql="SELECT * FROM roo_emails where id='$eid'";
			//echo $sql; exit;
			$res=$db->query($sql);
			while($row=$db->fetch_array($res))
			{
		
	        $to = array($row['email']);
			$from =$bulkemail->adminemail;
			$subject = $bulkemail->subject;
			$message = '<div style="width:600px;">
			Dear<br>
			<p>Welcome to ROOPHKA.COM</p>
			<br>
			<table cellpadding="0" cellspacing="0" border="0">
			
				<tr>
					<td>'.$temname.'</td>
				</tr>
				<tr>
					<td>'.$temcont.'</td>
				</tr>
				
			</table>
			<br>
			Thanks & regards,<br>
			<a href="roophka.com">roophka.com</a>
			</div>';
			
			$mailler->sendmail($to, $from, $subject, $message);
			}
			}
			
	}
	if($bulkemail->userinput==2)
	{
		$bulkemail->message=$_FILES['fileemail']['name'];
		$bulkemail->file=$_FILES['fileemail'];
		
		 $org_filename = $bulkemail->file['name'];
				$extn = pathinfo($org_filename, PATHINFO_EXTENSION);
				
				$path = DOCUMENT_PATH . "admin/attachment/";
				
				$destination = $path . $org_filename;
				
				$httpPath = HTTP_PATH . "admin/attachment/" . $org_filename;
				
				//echo $destination; exit;
				
				@move_uploaded_file($bulkemail->file['tmp_name'], $destination);
		
		$ids=explode(",", $eids);
		    foreach($ids as $eid)
			{
				
			$sql="SELECT * FROM roo_emails where id='$eid'";
			//echo $sql; exit;
			$res=$db->query($sql);
			while($row=$db->fetch_array($res))
			{
		
	        $to = array($row['email']);
			$from =$bulkemail->adminemail;
			$subject = $bulkemail->subject;
			$my_path = HTTP_PATH . "admin/attachment/".$bulkemail->message;
			$message = '<div style="width:600px;">
			Dear<br>
			<p>Welcome to ROOPHKA.COM</p>
			<br>
			<table cellpadding="0" cellspacing="0" border="0">
			
				<tr>
					<td><img src='.$mypath.'></td>
				</tr>
				
			</table>
			<br>
			Thanks & regards,<br>
			<a href="roophka.com">roophka.com</a>
			</div>';
			
			$mailler->sendmail($to, $from, $subject, $message);			
	}		
	
	}
	}	
		
		$bulkemail->composesave();
		redirect(HTTP_PATH . "admin/sentemails.php?success=3");

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
	.multicls
	{
		border:1px solid #ccc;
		height:150px;
		overflow-y:scroll;
		width:267px;
		padding:5px 8px;
	}
	#allemails
	{
		margin-top:5px;
		padding-right:20px;
		width:217px;
	}
	.tempbox
	{
    padding: 10px 10px 10px 10px;
    margin-right: 20px;
    border: 1px solid #CCC;
    width: 153px;
    background-color: #eee;
	height:80px;
	margin-bottom:20px;
	border-radius:25px 0px;
	}
	.tempboxselect
	{
    background-color:#468847;
	color:#fff;
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
				
				<li>Compose</li>
			</ul>
            
            <!--<div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Oh snap!</strong> Change a few things up and try submitting again.
            </div>
            <div class="clearfix"></div>-->
            
            <div class="row-fluid">
				
				<div class="box span12">
					<div class="box-header">
						<h2><i class="halflings-icon white th"></i><span class="break"></span>Compose New Emails</h2>
					</div>
					<div class="box-content">
						
						<div class="tab-content">
							<div class="tab-pane active id="textadd">
								<form class="form-horizontal" name="composeform" method="post" action="compose.php" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="_composeemails" />
                             
                                  <fieldset>
								 <br>
								 
								 
									 <div class="control-group " >
                                      <label class="control-label" for="content">Subject:</label>
                                      <div class="controls">
                                       <input type="text" name="subject" id="subject" placeholder="Enter subject here..." class="input-xlarge" required />
									  
                                      </div>
                                    </div>
								 
								 
                                    <div class="control-group">
                                      <label class="control-label" for="name">Category:</label>
                                      <div class="controls">
                                      <select name="category[]" id="category" class="input-xlarge" Onclick="emailsfn();" style="width:285px;" multiple  required>
									  <?php echo $bulkemail->getallcategory(); ?>
									  </select>
									  
									  </div>
                                    </div>
																		 
									 <div class="control-group">
                                      <label class="control-label" for="name">Emails:</label>
                                      <div class="controls">
                                      <div id="allemails" class="pull-left">Please choose category first...</div>
									  <a href="javascript:void(0);" onclick="emailpopupfn();">
									  <div class="btn btn-small btn-primary pull-left">View</div>
									  </a>
									  </div>
                                    </div>
									<input type="hidden" name="emailids" id="emailids">
											
									 <div class="control-group">
                                      <label class="control-label" for="userinput">Content Type:</label>
                                      <div class="controls-label">
                                       <label for="text" style="width:80px;margin-top: 8px;" class="pull-left">
										<input type="radio" name="userinput" id="text" value="1" onclick="userinputfn(1);" checked> Text
										</label>
										<label for="image" style="width:100px;margin-top: 8px;" class="pull-left">
										<input type="radio" name="userinput" id="image" value="2" onclick="userinputfn(2);"> Image
										</label>
										<label for="template" style="width:120px;margin-top: 8px;" class="pull-left">
										<input type="radio" name="userinput" id="template" value="3" onclick="userinputfn(3);"> Template
										</label>
                                      </div>
                                    </div>
									
									<div class="control-group " id="textinput" >
                                      <label class="control-label" for="content">Message:</label>
                                      <div class="controls">
                                       <textarea rows='10' name="textvalue" id="textvalue" class="cleditor"></textarea>
                                      </div>
                                    </div>
									
									<div class="control-group " id="fileinput" style="display:none;">
                                      <label class="control-label" for="content">Upload Image:</label>
                                      <div class="controls">
                                       <input type="file" name="fileemail" id="fileemail" class="input-xlarge"  />
									   <p class="help-block">Upload png,jpg,gif images below 10MB size</p>
                                      </div>
                                    </div>
									
									
									<div class="control-group " id="templateinput" style="display:none;">
                                      <label class="control-label" for="content">Select Template:</label>
                                      <div class="controls">
                                       <div id="alltempbox">
									<?php foreach($alltemplateList as $tempall) { ?>
									<div id="tempselect<?=$tempall['id']?>" class="pull-left tempbox">
									<div style="margin-bottom:10px;height:45px;"><?=$tempall['template_name']?></div>
									<div>
									<div class="pull-left" style="margin-right:10px;">
									<a href="javascript:void(0);" class="btn btn-small btn-warning" onclick="templateselectfn(<?=$tempall['id']?>)">
									<i class="halflings-icon white ok">&nbsp;</i>Select</a></div>
									<div class="pull-left">
									<a href="javascript:void(0);" onclick="templatepreviewfn(<?=$tempall['id']?>)">
										<span class="label label-important" style="padding:6px;"><i class="icon-zoom-in">&nbsp;</i>Preview</span>
										</a>
									</div>
									<div class="clearfix"></div>
									</div>
									
									</div>
									<?php } ?>
									</div>
                                      </div>
                                    </div>
									
									<input type="hidden" name="tempid" id="tempid">
									
									
                                    
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
		
		<!-- [emails  popup] -->
		  <div class="modal hide fade" id="emailcountpopup">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">x</button>
			<h3>Emails</h3>
		</div>
		<div class="modal-body" id="allemailsmodal">
			<p>Nothing to show here...</p>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Close</a>
		</div>
	</div>
	
	<!-- [preview popup] -->
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
		<script>
		function templateselectfn(id)
		{
			//alert(id);
			$('#tempid').val(id);
			
			$('#alltempbox div').removeClass('tempboxselect');
			$('#alltempbox #tempselect'+id).addClass('tempboxselect');
			//$('#tempselect'+id).removeClass('tempbox');
			
		}
		
		
		function emailpopupfn()
		{
		$('#emailcountpopup').modal('show');	
		}
		
		
		function userinputfn(val)
	{
	//	alert(val);
		if(val==1)
		{
			$('#textinput').show();
			$('#fileinput').hide();	
			$('#templateinput').hide();	
			$('#email').attr('required','required');
			$('#fileemail').removeAttr('required');	
		}
	    if(val==2)
		{
			$('#textinput').hide();
			$('#fileinput').show();	
			$('#templateinput').hide();	
			$('#fileemail').attr('required','required');
			$('#email').removeAttr('required');	
		}
		 if(val==3)
		{
			$('#textinput').hide();
			$('#fileinput').hide();	
			$('#templateinput').show();	
			$('#fileemail').removeAttr('required');
			$('#email').removeAttr('required');	
		}
	}
	
	function getSelectValues(select) {
  var result = [];
  var options = select && select.options;
  var opt;

  for (var i=0, iLen=options.length; i<iLen; i++) {
    opt = options[i];

    if (opt.selected) {
      result.push(opt.value || opt.text);
    }
  }
  return result;
}

function checkedValues(val)
{
	//alert(val);
	var check=document.getElementById("eid"+val).checked;
	//alert(check);
	var ids=$('#emailids').val();
	var params = { cmd:'_getemailids', temp:val, ids:ids, select:check }
            $.ajax({
				url:"./template_ajax.php",
				dataType:"JSON",
				data:params,
				success: function(result) {
					if(result.error) {
						alert(result.msg);
					} else {
						//alert(result.ids);
						$('#emailids').val(result.ids);
						//checkedValues();
					}
				}
			});
			return false;
	
}
		
	
	function emailsfn() {
		 var el = document.getElementsByTagName('select')[0];
         var id=getSelectValues(el);
		// alert(id);
			var params = { cmd:'_getemails', temp:id }
            $.ajax({
				url:"./template_ajax.php",
				dataType:"JSON",
				data:params,
				success: function(result) {
					if(result.error) {
						alert(result.msg);
					} else {
						$('#allemails').html("Total "+result.count+" emails in above selected category");
						$('#allemailsmodal').html(result.html);
						$('#emailids').val(result.ids);
						//checkedValues();
					}
				}
			});
			return false;
		}
		
		
		 function templatepreviewfn(id) {
			var params = { cmd:'_gettemplate', temp:id }
            $.ajax({
				url:"./template_ajax.php",
				dataType:"JSON",
				data:params,
				success: function(result) {
					if(result.error) {
						alert(result.msg);
					} else {
						$('#preview').html(result.html);
						$('#templatepreview').modal('show');
					}
				}
			});
			return false;
		}

		
		</script>
	
	<!-- start: JavaScript-->
	<? include('./includes/footerinclude.php'); ?>
	<!-- end: JavaScript-->
	
</body>
</html>