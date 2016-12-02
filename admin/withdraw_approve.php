<?php
include_once("../config/config.php");
is_admin_login();
include("./functions/withdraw_request.php");
$withdraw = new withdraw();

if(isset($_REQUEST['action'])) { 
global $mailler;
	if($_REQUEST['action'] == 'approve_request') {
		
		$todaydate=$_REQUEST['searchdate'];
		//$data = array();
		$withdraw->trans_id = $db->escape_string($_REQUEST['transactionid']);
		$withdraw->file = $_FILES['upload_image'];
		//echo $_FILES['upload_image']['name']; exit;
		
		$withdraw->addcontent=encodehtml($_REQUEST['addcontent']);
		$withdraw->id=$_REQUEST['id'];
		
		$qry1 = $db->query("SELECT * FROM roo_withdraw WHERE id='".$withdraw->id."'");
			       $row1 = $db->fetch_array($qry1);
				   $userid=$row1['userid'];
		 $qry3 = $db->query("SELECT * FROM roo_users WHERE id='".$userid."'");
			       $row3 = $db->fetch_array($qry3);
				   
		$add = $withdraw->update(); 
		if($add) {
			
			$to = array($row3['email']);
			$from = 'info@roophka.com';
			$subject = "Withdraw Request approved";
			$message = '<div style="width:600px;">
			Dear '.$row3['firstname'].'<br>
			<p>Welcome to ROOPHKA.COM</p>
			<p>Your withdraw request has been approved.Herewith i have attached receipt also, please check it.</p>
			
			<br>
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td align="right">Transaction Id : </td>
					<td>'.$withdraw->trans_id .'</td>
				</tr>
					<br>
					
				<tr>
					<td align="left">Description : </td>
					<td>'.$withdraw->addcontent.'</td>
				</tr>
			</table>
			<br>
			Thanks & regards,<br>
			<a href="roophka.com">roophka.com</a>
			</div>';
			
			$my_file = $withdraw->file['name'];
			$tempfile =$withdraw->file['tmp_name'];
			$file_type=$withdraw->file['type'];
$my_path = HTTP_PATH . "uploads/withdraw/";;
$my_name = "Roophka";

$mailler->sendmail_attachment($my_file,$tempfile,$file_type, $my_path, $to, $from, $my_name, $from, $subject, $message);
			
			//$mailler->sendmail($to, $from, $subject, $message);
			
			redirect(HTTP_PATH . 'admin/withdraw_request.php?todaydate='."$todaydate".'&success=1');
		} else {
			redirect(HTTP_PATH . 'admin/withdraw_request.php?todaydate='."$todaydate".'&error=failed');
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
				<li>Withdraw Approve</li>
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
						<h2><i class="halflings-icon white th"></i><span class="break"></span>Withdraw Request Approve</h2>
					</div>
					<div class="box-content">
						
                        <div class="tab-content">
							<div class="tab-pane active">
								<form class="form-horizontal" method="post" action="withdraw_approve.php" name="adminusers" enctype="multipart/form-data" >
                                <input type="hidden" name="action" value="approve_request" />
                                  <fieldset>
                                    
        
                                    <div class="control-group">
                                      <label class="control-label" for="phone">Transaction Id</label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge" id="transactionid" name="transactionid" value="" placeholder="Please enter transaction id here" required style="font-size:13px;" />
                                        
                                      </div>
                                    </div>
                                    
                                    <div class="control-group ">
                                      <label class="control-label" for="banner">Upload Image</label>
                                      <div class="controls">
                                        <input type="file" name="upload_image" id="upload_image" />
                                        <p class="help-block">jpg, png, gif</p>
                                      </div>
                                    </div>
									
									<input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
                                              
                                    <div class="control-group ">
                                      <label class="control-label" for="addcontent">Description</label>
                                      <div class="controls">
                                        <textarea class="cleditor" id="addcontent" rows="3" name="addcontent"></textarea>
                                      </div>
                                    </div>
                                    
                                   <input type="hidden" name="searchdate" value="<?php echo $_REQUEST['todaydate'];  ?>">
                                    
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