<?php
include_once("../config/config.php");
is_admin_login();
include("./functions/users.php");
$users = new users();
include("./includes/access.php");
$page_name ="Manual_Transaction";

if (in_array($page_name, $admin_access))
  {
  //echo "Match found";
  }
else
  {
 header("location:accessdenied.php");
  }


$emails=$users->getAllUserstransaction();
//echo json_encode($emails); exit;

if(isset($_REQUEST['action']) AND $_REQUEST['action'] == '_add_transaction') {
	//print_r($_REQUEST);
	$users->userinput=$db->escape_string($_REQUEST['userinput']);
	$users->username = $db->escape_string($_REQUEST['username']);
	$users->amount = $db->escape_string($_REQUEST['amount']);
	$users->reason = $db->escape_string($_REQUEST['reason']);
	$users->trans_type = $db->escape_string($_REQUEST['trans_type']);
	$users->transid = $db->escape_string($_REQUEST['transid']);
	$users->debit = $db->escape_string($_REQUEST['debit']);
	$users->file = $_FILES['trans_image'];
	
	//$emptycheck = $settings->emptycheck();
	if($_REQUEST['userinput']=='2')
	{
    $users->email = $users->getemail($_REQUEST['userid']);
	}
	else{
		$users->email = $db->escape_string($_REQUEST['email']);
	}
	
	if($_REQUEST['userinput']=='1')
	{
    $users->userid = $users->getuserid($_REQUEST['email']);
	}
	else
	{
		$users->userid = $db->escape_string($_REQUEST['userid']);
	}
	
	
	
	
	$save = $users->savetransaction();
	if($users->trans_type==1)
	{
	$to = array($users->email);
			$from = 'info@roophka.com';
			$subject = "Manual deposit by admin";
			$message = '<div style="width:600px;">
			Dear '.$users->username.'<br>
			<p>Welcome to ROOPHKA.COM</p>
			<p>Admin manually deposited '.$users->amount.' rupees for your account.</p>
			<br>
			<table cellpadding="0" cellspacing="0" border="0">
			
				<tr>
					<td align="right"><h4>Reason : </h4> </td>
					<td>'.$users->reason.'</td>
				</tr>
				
			</table>
			<br>
			Thanks & regards,<br>
			<a href="roophka.com">roophka.com</a>
			</div>';
			
			$mailler->sendmail($to, $from, $subject, $message);
	}else{
		
		$to = array($users->email);
			$from = 'info@roophka.com';
			$subject = "Manual Withdrawn by admin";
			$message = '<div style="width:600px;">
			Dear '.$users->username.'<br>
			<p>Welcome to ROOPHKA.COM</p>
			<p>Admin manually withdraw amount '.$users->amount.' rupees your request has been approved.Herewith i have attached receipt also, please check it.</p>
			
			<br>
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td align="right">Transaction Id : </td>
					<td>'.$users->transid .'</td>
				</tr>
					<br>
					
				<tr>
					<td align="left">Description : </td>
					<td>'.$users->reason.'</td>
				</tr>
			</table>
			<br>
			Thanks & regards,<br>
			<a href="roophka.com">roophka.com</a>
			</div>';
			
			$my_file = $users->file['name'];
			$tempfile =$users->file['tmp_name'];
			$file_type=$users->file['type'];
$my_path = HTTP_PATH . "uploads/withdraw/";;
$my_name = "Roophka";

$mailler->sendmail_attachment($my_file,$tempfile,$file_type, $my_path, $to, $from, $my_name, $from, $subject, $message);
			
	}		
	
	if($save === false) {
			redirect(HTTP_PATH . 'admin/manual_transaction.php?error=failed');
	}
	
	redirect(HTTP_PATH . 'admin/manual_transaction.php?success=1');
	
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
				<li>Manual Transaction</li>
			</ul>
			
			<? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '1') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> Manual transaction is updated successfully.
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
						<h2><i class="halflings-icon white th"></i><span class="break"></span>Manual Transaction</h2>
					</div>
					<div class="box-content">
						
						<div class="tab-content">
							<div class="tab-pane active id="textadd">
								<form class="form-horizontal" method="post" action="manual_transaction.php" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="_add_transaction" />
                             
                                  <fieldset>
								  
								   <div class="control-group">
                                      <label class="control-label" for="userinput">User Input:</label>
                                      <div class="controls-label">
                                       <label for="emailuser" style="width:100px;margin-top: 8px;" class="pull-left">
										<input type="radio" name="userinput" id="emailuser" value="1" onclick="userinputfn(1);" checked> Email
										</label>
										<label for="iduser" style="width:120px;margin-top: 8px;" class="pull-left">
										<input type="radio" name="userinput" id="iduser" value="2" onclick="userinputfn(2);"> Id
										</label>
                                      </div>
                                    </div>
								  
                                    <div class="control-group">
                                      <label class="control-label" for="email">User Email: </label>
                                      <div class="controls">
                                       
									   <input type="text" name="email" id="email" autocomplete="off" class="input-xlarge" placeholder="Type user email here" style="margin: 0 auto;" data-provide="typeahead" data-items="4" data-source="<?=htmlentities(json_encode($emails));?>" required onblur="currentbalancefn(this.value,'email');">
									   
                                      </div>
                                    </div>
									<div style="padding-left:135px; padding-bottom:20px;">(or)</div>
									
									<div class="control-group">
                                      <label class="control-label" for="userid">User id: </label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge" id="userid" name="userid"  placeholder="Enter user id here" required disabled onblur="currentbalancefn(this.value,'id');" />
                                      </div>
                                    </div>
									
									<div class="control-group balanceid" style="display:none;">
                                      <label class="control-label" for="currentbalance"> Current Balance: </label>
                                      <div class="controls" style="margin-top: 5px;">
                                      <span class="accountspan"> &#8377; &nbsp;</span>
                                      </div>
                                    </div>
									
                                    <div class="control-group">
                                      <label class="control-label" for="amount">Amount:</label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge" id="amount" name="amount" placeholder="Enter amount in rupees here"  required />
                                      </div>
                                    </div>
									
									 <div class="control-group ">
                                      <label class="control-label" for="reason">Reason:</label>
                                      <div class="controls">
                                        <textarea  id="reason" rows="5" name="reason" style="width:270px;" placeholder="Enter reason for transaction" required></textarea>
                                      </div>
                                    </div>
                                    
                                    <div class="control-group">
                                      <label class="control-label" for="website_url">Type:</label>
                                      <div class="controls-label">
                                       <label for="deposit" style="width:100px;margin-top: 8px;" class="pull-left">
										<input type="radio" name="trans_type" id="deposit" value="1" onclick="withdrawvalfn(1);" checked> Deposit
										</label>
										<label for="withdrawn" style="width:120px;margin-top: 8px;" class="pull-left">
										<input type="radio" name="trans_type" id="withdrawn" value="2" onclick="withdrawvalfn(2);"> Withdrawn
										</label>
                                      </div>
                                    </div>
        
		                              <span id="withdrawid" style="display:none;">
                                   <div class="control-group" >
                                      <label class="control-label" for="transid">Transaction id:</label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge" id="transid" name="transid"  placeholder="Enter transaction id here" required />
                                      </div>
                                    </div>
                                    
									 <div class="control-group">
                                      <label class="control-label" for="admin_mail">Upload image:</label>
                                      <div class="controls">
                                        <input type="file" class="input-xlarge" id="trans_image" name="trans_image" onchange="return ValidateFileUpload()" />
										 <p class="help-block">jpg, png, gif</p>
                                      </div>
                                    </div>
                                   
                                   
									
									<div class="control-group">
                                      <label class="control-label" for="admin_mail">Debit user account:</label>
                                      <div class="controls-label">
                                        <label for="yes" style="width:80px;margin-top: 8px;" class="pull-left">
										<input type="radio" name="debit" id="yes" value="1" checked> Yes
										</label>
										<label for="No" style="width:80px;margin-top: 8px;" class="pull-left">
										<input type="radio" name="debit" id="No" value="2" checked> No
										</label>
                                      </div>
                                    </div>
                                    
									</span>
									
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
	
	<script>
	function withdrawvalfn(val)
	{
		if(val==1)
		{
			$('#withdrawid').hide();	
		}
	    if(val==2)
		{
			$('#withdrawid').show();
		}
	}
	function userinputfn(val)
	{
		//alert(val);
		if(val==1)
		{
			$('#userid').attr('disabled','disabled');
			$('#email').removeAttr('disabled');	
		}
	    if(val==2)
		{
			$('#email').attr('disabled','disabled');
			$('#userid').removeAttr('disabled');
		}
	}
	
	function currentbalancefn(val,type)
	{
		//alert(val);
		
		//console.log(val);
		var params = { cmd : '_currentbalance',inputtype:type,email:val}
	$.ajax({
		url:"ajax_bank.php",
		type:'POST',
		dataType:"JSON",
		data:params,
		success: function(result) {
			//$('.overlay').fadeOut();
			//location.reload(true);
			console.log(result);
			if(result.error) {
				
			} else {
			$('.balanceid').show();
			$('.accountspan').append(result);
			
			}
		}
	});
	}
	
	 function ValidateFileUpload() {
        var fuData = document.getElementById('trans_image');
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
				document.getElementById('trans_image').value="";

            }
        }
    }

	
	</script>
</body>
</html>