<?php
include_once("../config/config.php");
is_admin_login();
include("./functions/users.php");
$users = new users();

$start = $users->start;

if(isset($_REQUEST['action']) AND isset($_REQUEST['id']) AND $_REQUEST['id'] > 0) {
	if($_REQUEST['action'] == 'activate') {
		$users->Activate($_REQUEST['id']);
		redirect(HTTP_PATH . "admin/users.php?success=2");
	}
	if($_REQUEST['action'] == 'deactivate') {
		$users->Deactivate($_REQUEST['id']);
		redirect(HTTP_PATH . "admin/users.php?success=2");
	}
	if($_REQUEST['action'] == 'demo') {
		$users->DemoAccount($_REQUEST['id']);
		redirect(HTTP_PATH . "admin/users.php?success=2");
	}
	redirect(HTTP_PATH . "admin/users.php");
	
}

if(isset($_REQUEST['action']))
{
	if($_REQUEST['action'] == '_changepassword')
    {
		$users->changepass($_REQUEST['userid'],$_REQUEST['newpassword']);
		redirect(HTTP_PATH . "admin/users.php?success=3");
		
	}
}

if(isset($_REQUEST['search']))
{
	$date=$_REQUEST['todaydate'];
	$name=$_REQUEST['name'];
	$email=$_REQUEST['email'];
	$phone=$_REQUEST['phone'];
	
}
else{
$date="";
$name="";
$email="";
$phone="";
}
//echo $date;

list($userList,$pagination) = $users->getAllUsers($date,$name,$email,$phone);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<? include('./includes/head.php'); ?>
    <style type="text/css">
	#bankAccount { width:700px;}
    
	#ui-datepicker-div
	{
		z-index:100 !important;
	}
	.pull-left
	{
		margin-right:27px
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
				<li>Users</li>
			</ul>
            
            
            <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '1') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> User account inserted successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
            <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '2') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> User account updated successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
			
			<? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '3') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> User password changed successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>

			<div class="row-fluid ">	
				<div class="box span12">
				<form name="search" action="users.php" method="get">
						<div class="row-fluid" style="height:30px;margin:8px 8px -10px 30px;">
			<input type="hidden" name="search" value="user">
			<div class="pull-left"><input type="text" name="name" id="name" placeholder="Name" value="<?php echo $name;?>"></div>
			<div class="pull-left"><input type="text" name="email" id="email" placeholder="Email" value="<?php echo $email;?>"></div>
			<div class="pull-left"><input type="text" name="phone" id="phone" placeholder="Phone" value="<?php echo $phone;?>"></div>
			<div class="pull-left"><input type="text" name="todaydate" class="datepicker" placeholder="Registered Date" value="<?php echo $date;?>"></div>
			<div class="pull-left">
			<a href="javascript:void(0);" onclick="usersreportfn();"; class="btn btn-small " style="padding:4px 10px;">Search</a>
			</div>
			 <div class="clearfix" style="margin-bottom:20px;"></div>
			
			</div>
			</form>
					<div class="box-header">
						<h2><i class="halflings-icon white align-justify"></i><span class="break"></span>Users</h2>
						<div class="box-icon">
						
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
                                      <th>Email</th>
                                      <th>Phone</th>
                                      <th>Account Balance</th>
                                      <th>Bank</th>
									  <th>Date registered</th>
									  <th>Demo</th>
									  <th>Status</th>
                                      <th style="width:235px;">Action</th>
								  </tr>
							  </thead>   
							  <tbody>
                              <?
							  if(empty($userList)){
							  ?>
                              <tr><td colspan="9" style="text-align:center;" class="text-error">No User available to show....</td></tr>
                              <?
							  } else {
								  $sno = $start + 1;
								  foreach($userList as $usr) {
							  ?>
								<tr>
									<td><?=$sno?></td>
                                    <td ><a href="./viewprofile.php?action=view&id=<?=$usr['id']?>" style="color:#08c;"><?=$usr['email']?></a></td>
                                    <td><?=$usr['phone']?></td>
                                    <td class="center"><?=$usr['account_balance']?>/-</td>
                                    <td class="center">
										( <?=$usr['bank']?> ) 
                                        <? if($usr['bank'] > 0) { ?>
                                        <a href="#" onClick="return getAccount('<?=$usr['id']?>');">View</a>
										<? } ?>
                                        </td>
									<td class="center"><?=date('d-M-Y h:i A', strtotime($usr['signupdate']))?></td>
									<td class="center">
										<? if($usr['demo'] == 1) { ?>
											<span class="label label-info">Demo Account</span>
										<? } else { ?>
											<a href="./users.php?action=demo&id=<?=$usr['id']?>" onClick="return confirm('Do you realy want to make this account as demo?');" class="btn btn-small"><i class="halflings-icon white send"></i>Make as demo</a>
										<? } ?>
									</td>
									<td class="center">
                                    	<? if($usr['status'] == 0) { ?>
										<span class="label label-success" style="padding:6px;">Active</span>
                                        <? } elseif($usr['status'] == 1) { ?>
                                        <span class="label" style="padding:6px;">Inactive</span>
                                        <? } ?>
									</td>
                                    <td>
                                    	<? if($usr['status'] == 0) { ?>
                                        <a href="./users.php?action=deactivate&id=<?=$usr['id']?>" onClick="return confirm('Do you realy want to deactivate this account?');" class="btn btn-small"><i class="halflings-icon white remove"></i>Deactiavte</a>
                                        <? } elseif($usr['status'] == 1) { ?>
                                        <a href="./users.php?action=activate&id=<?=$usr['id']?>" onClick="return confirm('Do you realy want to activate this account?');" class="btn btn-small btn-success"><i class="halflings-icon white ok">&nbsp;</i>Actiavte</a>
                                        <? } ?>
                                        <a href="javascript:void(0);" onClick="changepassfn('1',<?=$usr['id']?>)" class="btn btn-small btn-primary"><i class="halflings-icon white lock"></i>Change Password</a>
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
	
	<div id="light1" class="white_content"> <a href = "javascript:void(0)" onclick = "changepassfn(2);"><button type="button" class="close" data-dismiss="modal">x</button></a>
		<div style="border-bottom:2px solid #ccc;width100%;margin:5px;"><h2>Change User Password</h2></div>
		<form action="users.php" method="post">
		<input type="hidden" name="action" value="_changepassword">
		<div class="row-fluid" style="margin-top:20px;">
		<div class="pull-left col-md-6" style="margin-right:40px;">New Password:</div>
		<div class="pull-left col-md-6">
		<input type="password" name="newpassword" id="newpassword"  class="input-xlarge" placeholder="Enter new password here..." required>
		</div>
		<div class="clearfix" style="margin-bottom:10px;"></div>
		</div>
		
		<div class="row-fluid" style="margin-top:20px;">
		<div class="pull-left col-md-6" style="margin-right:15px;">Confirm Password:</div>
		<div class="pull-left col-md-6">
		<input type="password" name="conpassword" id="conpassword"  class="input-xlarge" placeholder="Enter confirm password here..." required>
		</div>
		<div class="clearfix" style="margin-bottom:10px;"></div>
		</div>
		
		<input type="hidden" name="userid" id="userid">
		<div>
		<input type="submit" name="submit" id="submit" value="submit" onClick="validatefn();" style="padding:5px 15px;" class="btn btn-small btn-primary add-new">
		</div>
		
		</form>
		<div></div>
		</div>
		<div id="fade1" class="black_overlay"></div>
    <div class="modal hide fade" id="bankAccount">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">x</button>
			<h3>Settings</h3>
		</div>
		<div class="modal-body" id="bankAjaxResult">
			<p>Nothing to show here...</p>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Close</a>
		</div>
	</div>
    
	<!-- start: JavaScript-->
	<? include('./includes/footerinclude.php'); ?>
	<!-- end: JavaScript-->
	
    <script type="text/javascript">
		function getAccount(id) {
			var params = { cmd:'_getAccount', user:id }
            $.ajax({
				url:"./ajax.php",
				dataType:"JSON",
				data:params,
				success: function(result) {
					if(result.error) {
						alert(result.msg);
					} else {
						$('#bankAjaxResult').html(result.html);
						$('#bankAccount').modal('show');
					}
				}
			});
			return false;
		}
		$(document).ready(function(e) {
			
        });
	</script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <script>
  
  
  function usersreportfn()
  {
	  document.search.submit();
  }
  
   function changepassfn(val,uid)
  {
	  //alert(cid);
	  if(val==1)
	  {
	  document.getElementById('light1').style.display='block';
	  document.getElementById('fade1').style.display='block';
	  document.getElementById('userid').value=uid;
	  }
	  
	   if(val==2)
	  {
	  document.getElementById('light1').style.display='none';
	  document.getElementById('fade1').style.display='none';
	   document.getElementById('userid').value="";
	  }
	  
	  
  }
  
  function validatefn()
  {
	  
	  var newpass=document.getElementById('newpassword').value;
	  var conpass=document.getElementById('conpassword').value;
	  
	  if(newpass !="" && conpass !="")
	  {
	  if(newpass != conpass)
	  {
		  alert("Password is doesnot match !!!");
		  document.getElementById('conpassword').value="";
		  document.getElementById('conpassword').focus();
		  
	  }
	  }
	  
  }
  
  </script>  
  
    
  <style>
		.black_overlay{
			display: none;
			position: absolute;
			top: 0%;
			left: 0%;
			width: 100%;
			height: 100%;
			background-color: black;
			z-index:1001;
			-moz-opacity: 0.8;
			opacity:.80;
			filter: alpha(opacity=80);
		}
		.white_content {
			display: none;
			position: absolute;
			top: 25%;
			left: 25%;
			width: 50%;
			height: 35%;
			padding: 16px;
			border: 10px solid #578EBE;
			background-color: white;
			z-index:1002;
			overflow: auto;
			border-radius:10px;
		}
	</style>
</body>
</html>