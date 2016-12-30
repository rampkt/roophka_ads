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

$start = $bulkemail->start;

if(isset($_REQUEST['action']) AND isset($_REQUEST['id']) AND $_REQUEST['id'] > 0) {
	$email=$_REQUEST['email'];
	if($_REQUEST['action'] == 'activate') {
		$bulkemail->Activateemail($_REQUEST['id']);
		redirect(HTTP_PATH . "admin/emails.php?email=$email&success=1");
	}
	if($_REQUEST['action'] == 'deactivate') {
		$bulkemail->Deactivateemail($_REQUEST['id']);
		redirect(HTTP_PATH . "admin/emails.php?email=$email&success=2");
	}
	if($_REQUEST['action'] == 'delete') {
		$bulkemail->Deleteemail($_REQUEST['id']);
		redirect(HTTP_PATH . "admin/emails.php?success=4");
	}


	redirect(HTTP_PATH . "admin/emails.php");
}




if((isset($_REQUEST['search'])) && $_REQUEST['search']=='search')
{
	$email=$_REQUEST['email'];
	$email2=$_REQUEST['email'];
	$categorysearch=$_REQUEST['categorysearch'];
}
else{
$email="";
$email2="";
$categorysearch="";
}
//echo $date;

list($emailList,$pagination) = $bulkemail->getAllemails($email,$categorysearch);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<? include('./includes/head.php'); ?>
    <style type="text/css">
	.add-search { margin:-15px 0 10px 0;}
    .btn-small{padding:4px 10px;}	
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
					<a href="dashoboard.php">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li>Emails</li>
			</ul>
			
			
            <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '1') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> email is activated successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
            <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '2') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> email is deactivated successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
			
			 <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '3') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> email is added successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
			 <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '4') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> email is deleted successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
			<? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '5') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> email is updated successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
			
                 <a href="emails_add.php" class="btn btn-small btn-primary pull-right add-new" style="margin-bottom:10px;">Add new</a>
			<div class="row-fluid ">	
				<div class="box span12">
				
					<div class="box-header">
						<h2><i class="halflings-icon white align-justify"></i><span class="break"></span>Email Management</h2>
						<div class="box-icon">
						<form name="search" action="emails.php" method="get">
						
						<input type="hidden" name="search" value="search">
						<div class="row-fluid" style="height:30px;margin-top:-10px;">
			
			<div class="pull-right"><a href="javascript:void(0);" onclick="usersreportfn();"; class="btn btn-small ">Search</a></div>
			<div class="pull-right"><input type="text" name="email" id="email" placeholder="Enter email here..." value="<?php echo $email;?>"></div>
			<div class="pull-right" style="margin-right:10px;">
			<select name="categorysearch" id="categorysearch">
			<option value="">Select Category</option>
			<?php echo $bulkemail->getallcategory($categorysearch); ?>
			</select>
			</div>
			 <div class="clearfix" style="margin-bottom:20px;"></div>
			
			</div>
			</form>
							<!--<a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>-->
						</div>
					</div>
					<div class="box-content">
						<table class="table table-bordered table-striped table-condensed">
							  <thead>
								  <tr>
									  <th>Sno</th>
									  <th>Category</th>
                                      <th>Email Address</th>
									  <th>Date</th>
									  <th>Status</th>
                                      <th style="width:235px;">Action</th>
								  </tr>
							  </thead>   
							  <tbody>
                              <?
							  if(empty($emailList)){
							  ?>
                              <tr><td colspan="6" style="text-align:center;" class="text-error">No email available to show....</td></tr>
                              <?
							  } else {
								  $sno = $start + 1;
								  foreach($emailList as $email) {
							  ?>
								<tr>
									<td><?=$sno?></td>
									 <td ><?=$bulkemail->categoryname($email['category'])?></td>
									 <td ><?=$email['email']?></td>
									 <td ><?=$email['date_added']?></td>
									
									<td class="center">
                                    	<? if($email['status'] == 0) { ?>
										<span class="label label-success" style="padding:6px;">Active</span>
                                        <? } elseif($email['status'] == 1) { ?>
                                        <span class="label" style="padding:6px;">Inactive</span>
                                        <? } ?>
									</td>
                                    <td>
                                    	<? if($email['status'] == 0) { ?>
                                        <a href="./emails.php?action=deactivate&id=<?=$email['id']?>&email=<?php echo $email2;?>" onClick="return confirm('Do you realy want to deactivate this account?');" class="btn btn-small"><i class="halflings-icon white remove"></i>Deactiavte</a>
                                        <? } elseif($email['status'] == 1) { ?>
                                        <a href="./emails.php?action=activate&id=<?=$email['id']?>&email=<?php echo $email2;?>" onClick="return confirm('Do you realy want to activate this account?');" class="btn btn-small btn-success"><i class="halflings-icon white ok">&nbsp;</i>Actiavte</a>
                                        <? } ?>
										
										
                                        
										<a href="./emails.php?action=delete&id=<?=$email['id']?>" onClick="return confirm('Do you realy want to delete this account?');" class="btn btn-small btn-primary"><i class="halflings-icon white remove">&nbsp;</i>Delete</a>
										
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
				</div><!--/span-->
			</div><!--/row-->
			
       

	</div><!--/.fluid-container-->
	
			<!-- end: Content -->
		</div><!--/#content.span10-->
		</div><!--/fluid-row-->
	
    <? include('./includes/footer.php'); ?>
	
    	
		
		
		<div class="modal hide fade" id="categoryadd">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">x</button>
			<h3>Add New email</h3>
		</div>
		<div class="modal-body" id="categoryResult">
			
			<form action="emails.php" method="post" name="addcategory">
			<input type="hidden" name="action" value="_addcategory" >
			
			 <fieldset>
                                    <div class="control-group">
                                      <label class="control-label" for="name">email Name </label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge" id="name" name="name" required placeholder="Enter email name ..." />
                                      </div>
                                    </div>
                                    
                                   
			</fieldset>
			
			
		</div>
		<div class="modal-footer">
		<input type="submit" name="submit" value="Save" class="btn btn-primary" />	<a href="#" class="btn" data-dismiss="modal">Close</a>
		</div>
		
		</form>
		
	</div>
		
	<!-- start: JavaScript-->
	<? include('./includes/footerinclude.php'); ?>
	<!-- end: JavaScript-->
	<div class="modal hide fade" id="emailpreview" style="width:60%;left:40%;">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">x</button>
			<h3>email Preview</h3>
		</div>
		<div class="modal-body" id="categoryResult">
			
			<div id="preview">&nbsp;</div>
			
		</div>
		<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Close</a>
		</div>
		
	</div>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  
  <script>
  
  function usersreportfn()
  {
	  document.search.submit();
  }
  
  
  function categoryaddfn(val)
  {
	  //alert("adad");
	  
	  $('#categoryadd').modal('show');
	  
	  
  }
  function emailpreviewfn(id) {
			var params = { cmd:'_getemail', temp:id }
            $.ajax({
				url:"./email_ajax.php",
				dataType:"JSON",
				data:params,
				success: function(result) {
					if(result.error) {
						alert(result.msg);
					} else {
						$('#preview').html(result.html);
						$('#emailpreview').modal('show');
					}
				}
			});
			return false;
		}
		$(document).ready(function(e) {
			
        });
  </script>  
  
  
 </body>
</html>