<?php
include_once("../config/config.php");
is_admin_login();
include("./functions/bulkemail.php");
$bulkemail = new bulkemail();
include("./functions/location.php");
$location = new location();
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
  
$alltemplateList=$bulkemail->AllemailTemplate();
//echo json_encode($emails); exit;
if(isset($_REQUEST['action'])and ($_REQUEST['action']=="_composeemails")) {
	
	$bulkemail->subject=$_REQUEST['subject'];
	$bulkemail->category=$_REQUEST['category'];
	$bulkemail->eids=$_REQUEST['emailids'];
	//$bulkemail->emailexternal=$_FILES['emailexternal'];
	$bulkemail->emailinput=$_REQUEST['emailinput'];
	$bulkemail->userinput=$_REQUEST['userinput'];
	$bulkemail->adminemail=$location->getsetting('1','email');
	$bulkemail->batchno=rand('10000','99999');
	$eids=$_REQUEST['emailids'];
	//$tmpfile=$_FILES['emailexternal']['tmp_name'];
	$emailinput=$_REQUEST['emailinput'];
	
		if($bulkemail->userinput==1)
	{
		$bulkemail->message=$_REQUEST['textvalue'];
		
		if($emailinput==1){
		$ids=explode(",", $eids);
		    foreach($ids as $eid)
			{
				
			$sql="SELECT * FROM roo_emails where id='$eid'";
			//echo $sql; exit;
			$res=$db->query($sql);
			while($row=$db->fetch_array($res))
			{
			$b=base64_encode($row['email'].$bulkemail->batchno);
            $m=md5($b);
		    $httpPathlogo = HTTP_PATH."mailverify/".$m."/logo.jpg";
		
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
				
				<tr>
					<td><img src='.$httpPathlogo.' alt=""></td>
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
	
if($emailinput==2){
		
	$ids=explode(",", $eids);
		    foreach($ids as $eid)
			{
			$b=base64_encode($eid.$bulkemail->batchno);
            $m=md5($b);
		    $httpPathlogo = HTTP_PATH."mailverify/".$m."/logo.jpg";	
			
	        $to = array($eid);
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
				<tr>
					<td><img src='.$httpPathlogo.' alt=""></td>
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
		
		if($emailinput==1){
		$ids=explode(",", $eids);
		    foreach($ids as $eid)
			{
				
			$sql="SELECT * FROM roo_emails where id='$eid'";
			//echo $sql; exit;
			$res=$db->query($sql);
			while($row=$db->fetch_array($res))
			{
		    $b=base64_encode($row['email'].$bulkemail->batchno);
            $m=md5($b);
		    $httpPathlogo = HTTP_PATH."mailverify/".$m."/logo.jpg";
			
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
				<tr>
					<td><img src='.$httpPathlogo.' alt=""></td>
				</tr>
			</table>
			<br>
			Thanks & regards,<br>
			<a href="roophka.com">roophka.com</a>
			</div>';
			
			//echo $message; exit;
			
			
			$mailler->sendmail($to, $from, $subject, $message);
			}
			}
		}
		if($emailinput==2){
			$ids=explode(",", $eids);
		    foreach($ids as $eid)
			{
			$b=base64_encode($eid.$bulkemail->batchno);
            $m=md5($b);
		    $httpPathlogo = HTTP_PATH."mailverify/".$m."/logo.jpg";
			
	        $to = array($eid);
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
				<tr>
					<td><img src='.$httpPathlogo.' alt=""></td>
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
		//$bulkemail->message=$_FILES['fileemail']['name'];
		$bulkemail->file=$_FILES['fileemail'];
		
		 $org_filename = $bulkemail->file['name'];
				$extn = pathinfo($org_filename, PATHINFO_EXTENSION);
				$filehash = randomString(20);
				$filename = $filehash . '.'.$extn;
				$bulkemail->message=$filename;
				$path = DOCUMENT_PATH . "uploads/attachment/";
				
				$destination = $path . $filename;
				
				$httpPath = HTTP_PATH . "uploads/attachment/" . $filename;
				
				//echo $destination; exit;
				
				@move_uploaded_file($bulkemail->file['tmp_name'], $destination);
		if($emailinput==1)
		{
		$ids=explode(",", $eids);
		    foreach($ids as $eid)
			{
				
			$sql="SELECT * FROM roo_emails where id='$eid'";
			//echo $sql; exit;
			$res=$db->query($sql);
			while($row=$db->fetch_array($res))
			{
		    $b=base64_encode($row['email'].$bulkemail->batchno);
            $m=md5($b);
		    $httpPathlogo = HTTP_PATH."mailverify/".$m."/logo.jpg";
			
	        $to = array($row['email']);
			$from =$bulkemail->adminemail;
			$subject = $bulkemail->subject;
			$my_path = HTTP_PATH . "uploads/attachment/".$bulkemail->message;
			$message = '<div style="width:600px;">
			Dear<br>
			<p>Welcome to ROOPHKA.COM</p>
			<br>
			<table cellpadding="0" cellspacing="0" border="0">
			
				<tr>
					<td><img src='.$my_path.' style="width:300px;"></td>
				</tr>
				<tr>
					<td><img src='.$httpPathlogo.' alt=""></td>
				</tr>
			</table>
			<br>
			Thanks & regards,<br>
			<a href="roophka.com">roophka.com</a>
			</div>';
			
			//echo $message; exit;
			
			$mailler->sendmail($to, $from, $subject, $message);			
	}		
	
	}
		}
		
		if($emailinput==2){
			$ids=explode(",", $eids);
		    foreach($ids as $eid)
			{
			$b=base64_encode($eid.$bulkemail->batchno);
            $m=md5($b);
		    $httpPathlogo = HTTP_PATH."mailverify/".$m."/logo.jpg";
			
	        $to = array($eid);
			$from =$bulkemail->adminemail;
			$subject = $bulkemail->subject;
			$my_path = HTTP_PATH . "uploads/attachment/".$bulkemail->message;
			$message = '<div style="width:600px;">
			Dear<br>
			<p>Welcome to ROOPHKA.COM</p>
			<br>
			<table cellpadding="0" cellspacing="0" border="0">
			
				<tr>
					<td><img src='.$mypath.'></td>
				</tr>
				<tr>
					<td><img src='.$httpPathlogo.' alt=""></td>
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
	.dataTables_paginate
{
	float:right;
	padding:10px 0px
}
.dataTables_paginate .current
{
	border:1px solid #ccc;
	text-decoration:0px 5px;
	padding:0px 5px;
}
.dataTables_paginate span
{
	padding:0px 5px;
}
.dataTables_paginate span a
{
	padding:0px 5px;
	cursor:pointer;
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
                                      <label class="control-label" for="content"> Email Input Type:</label>
                                      <div class="controls">
                                      <div class="controls-label">
                                       <label for="database" style="width:180px;margin-top: 8px;margin-left:-20px;" class="pull-left">
										<input type="radio" name="emailinput" id="database" value="1" onclick="emailinputfn(1);" checked> From our database
										</label>
										<label for="filein" style="width:130px;margin-top: 8px;" class="pull-left">
										<input type="radio" name="emailinput" id="filein" value="2" onclick="emailinputfn(2);"> External file
										</label>
                                      </div>
                                      </div>
                                    </div>
								 
								 
                                    <div class="control-group" id="ourcategory" style="display:block;">
                                      <label class="control-label" for="name">Category:</label>
                                      <div class="controls">
                                      <select name="category[]" id="category" class="input-xlarge" Onclick="emailsfn();" style="width:285px;" multiple  required>
									  <?php echo $bulkemail->getallcategory(); ?>
									  </select>
									  
									  </div>
                                    </div>
									
									<div class="control-group " id="externalinput" style="display:none;">
                                      <label class="control-label" for="content">Upload file:</label>
                                      <div class="controls">
                                      <!-- <input type="file" name="emailexternal" id="emailexternal" class="input-xlarge" onmouseout="externalfn();"  />-->
									  <input type="button" name="upbtn" id="upbtn" value="Browse" onclick="uplfn();" onmouseout="externalfn();"><span id="spanfile">&nbsp;</span>
									  
									  <p class="help-block">Sample CSV file <a href="./csv/sample.csv" style="color:blue;">here.</a></p>
                                     
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
									
									<div class="control-group " >
                                      <label class="control-label" for="content">Subject:</label>
                                      <div class="controls">
                                       <input type="text" name="subject" id="subject" placeholder="Enter subject here..." class="input-xlarge" required />
									  
                                      </div>
                                    </div>
									
											
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
                                       <input type="file" name="fileemail" id="fileemail" class="input-xlarge"  onchange="return ValidateFileUpload()" />
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
                            <div style="z-index:-1;visibility:hidden;overflow:hidden;height:1px;">
			<form id="uploadimage" action="" method="post" enctype="multipart/form-data">
		
		<input type="file" name="ajaxfile" id="ajaxfile" onchange="ValidateFileUploadCSV();">
		
		<input type="text" name="cmd" value="_getemailexternal">
		<input type="text" name="temp" value="emails">
		
		<input type="submit" name="submit" id="submit" value="Upload CSV Data" />
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
		<div class="modal-body" >
			<p>
			<div class="content">
				<table id="email_list" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>&nbsp;&nbsp;Emails</th>
							
						</tr>
					</thead>
					<tbody id="allemailsmodal">
					
					</tbody>
				</table>
					
			</div>
			</p>
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript">
  $(function() {
     $("#ajaxfile").change(function (){
       var fileName = $(this).val();
      // $("#spanfile").html(fileName);
	   var afile=document.getElementById("ajaxfile").files[0].name
       $("#spanfile").html(" "+afile);
	   $("#uploadimage").submit();
	   
     });
  });
</script>
	
		<script>
		
		$(document).ready(function (e) {
			
$("#uploadimage").on('submit',(function(e) {
	var t = $('#email_list').DataTable();
	 var trlen = $('#email_list tbody tr').length;
		  for(var a=0;a<trlen;a++)
		  {
			 t.row('#email_list tbody tr').remove().draw();  
		  }	  
	
e.preventDefault();
//$("#eids").empty();
$.ajax({
url: "template_ajax.php", // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
dataType:"JSON",
contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
success: function(result)   // A function to be called if request succeeds
{
$('#allemails').html("Total "+result.count+" emails in above selected category");
//$('#allemailsmodal').html(result.html);	
$("#emailids").val(result.ids);
for(var i=0; i<result.count;i++)
{
//alert(result.html);
t.row.add([result.html[i]]).draw(false);
}

//$('#email_list').DataTable();
}
});
}));

});


		
		function uplfn()
		{
			$('#ajaxfile').trigger('click');
			
		}
		
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
		
		
		function emailinputfn(val)
		{
			if(val=='1')
			{
				$('#ourcategory').show();
				$('#externalinput').hide();
				$('#allemails').html("Please choose category first...");
				$('#category').attr('required','required');
			$('#emailexternal').removeAttr('required');	
			$('#emailids').val("");
			$('#category').val("");
			}
			if(val=='2')
			{
				$('#ourcategory').hide();
				$('#externalinput').show();
				$('#allemails').html("Please upload file first...");
				$('#emailexternal').attr('required','required');
			$('#category').removeAttr('required');	
				$('#emailids').val("");
				$('#category').val("");
			}
			
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
	$(select).find("option:selected").each(function(){
		var $this = $(this);
	   if ($this.length) {
	    result.push($this.val());
	   }
	});
  /*
  var options = select && select.options;
  var opt;

  for (var i=0, iLen=options.length; i<iLen; i++) {
    opt = options[i];

    if (opt.selected) {
      result.push(opt.value || opt.text);
    }
  }
  console.log(result);*/
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
		 
		 
		  var t = $('#email_list').DataTable();
		  var trlen = $('#email_list tbody tr').length;
		  for(var a=0;a<trlen;a++)
		  {
			 t.row('#email_list tbody tr').remove().draw();  
		  }	  
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
						$('#emailids').val(result.ids);

						for(var i=0; i<result.count;i++)
						{
					//alert(result.arrvalue);
						t.row.add([result.arrvalue[i]]).draw(false);
						}
						//$('#email_list').DataTable();
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
	<SCRIPT type="text/javascript">
    function ValidateFileUpload() {
        var fuData = document.getElementById('fileemail');
        var FileUploadPath = fuData.value;

//To check if user upload any file
        if (FileUploadPath == '') {
            alert("Please upload an image");

        } else {
            var Extension = FileUploadPath.substring(
                    FileUploadPath.lastIndexOf('.') + 1).toLowerCase();

//The file uploaded is an image

if (Extension == "gif" || Extension == "png" || Extension == "jpeg" || Extension == "jpg") {

// To Display

            } 

//The file upload is NOT an image
else {
                alert("Upload only allows file types of GIF, PNG, JPG and JPEG. ");
				document.getElementById('fileemail').value="";

            }
        }
    }
	
	 function ValidateFileUploadCSV() {
        var fuData = document.getElementById('ajaxfile');
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
				document.getElementById('ajaxfile').value="";
				$('#spanfile').html("");

            }
        }
    }
	
	
</SCRIPT>
<!-- start: JavaScript-->
	<? include('./includes/footerinclude.php'); ?>
	<!-- end: JavaScript-->
	<script type="text/javascript" class="init">
	

function filterGlobal () {
	$('#email_list').DataTable().search( 
		$('#global_filter').val(),
		$('#global_regex').prop('checked'), 
		$('#global_smart').prop('checked')
	).draw();
}

function filterColumn ( i ) {
	$('#email_list').DataTable().column( i ).search( 
		$('#col'+i+'_filter').val(),
		$('#col'+i+'_regex').prop('checked'), 
		$('#col'+i+'_smart').prop('checked')
	).draw();
}

$(document).ready(function() {
	$('#email_list').DataTable();

	$('input.global_filter').on( 'keyup click', function () {
		filterGlobal();
	} );

	$('input.column_filter').on( 'keyup click', function () {
		filterColumn( $(this).parents('tr').attr('data-column') );
	} );
} );


	</script>
	
	
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js">
	</script>
</body>
</html>
