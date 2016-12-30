<?php
include_once("../config/config.php");
is_admin_login();
include("./functions/location.php");
$location = new location();
include("./includes/access.php");
$page_name ="Contact";

if (in_array($page_name, $admin_access))
  {
  //echo "Match found";
  }
else
  {
 header("location:accessdenied.php");
  }

$start = $location->start;

if(isset($_REQUEST['action']) AND isset($_REQUEST['id']) AND $_REQUEST['id'] > 0) {
	if($_REQUEST['action'] == 'delete') {
		$location->Deletecontact($_REQUEST['id']);
		redirect(HTTP_PATH . "admin/contactus.php?success=4");
	}
	
	$msg=$_REQUEST['reply'];

	if($_REQUEST['action'] == 'reply') {
		$location->Replycontact($_REQUEST['id'],$msg);
		
		$adminemail=$location->getsetting('1','email');
			
			$from = $adminemail;
		$to = array($_REQUEST['replyemail']);
		$subject = "RE: ". $_REQUEST['replysubject'];
   
    $message = '<div style="width:600px;">
    Dear '.$_REQUEST['replyname'].'<br>
   <p>WELCOME TO ROOPHKA.COM</p>
   
    <p>Please Check reply mail for ROOPHKA.com, Have a good day.</p>
    <br>
	
	<p><strong>Message : </strong> '.$msg.'</p><br><br>
	
    Thanks & regards,<br />
    <a href="'.HTTP_PATH.'">roophka.com</a>
    </div>';
		
			
			$mailler->sendmail($to, $from, $subject, $message);
			
		
		
		redirect(HTTP_PATH . "admin/contactus.php?success=5");
	}

	redirect(HTTP_PATH . "admin/contactus.php");
}


//echo $date;

list($contactusList,$pagination) = $location->getAllcontactus();
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
	.replycss
    {
    background-color: #DDF;
    padding: 5px 10px;
    border-radius: 10px;
    line-height: 20px;
    margin-top: 5px;
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
				<li>Contact Us Managment</li>
			</ul>
			
			
			 <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '4') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> Record is deleted successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
			
			 <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '5') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> Reply mail is sent successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
			
               
			<div class="row-fluid ">	
				<div class="box span12">
				
					<div class="box-header">
						<h2><i class="halflings-icon white align-justify"></i><span class="break"></span>Contact us Management</h2>
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
                                      <th>name</th>
                                      <th>email</th>
                                      <th>subject</th>
									  <th>message</th>
									  <th>Date</th>
                                      <th>Action</th>
								  </tr>
							  </thead>   
							  <tbody>
                              <?
							  if(empty($contactusList)){
							  ?>
                              <tr><td colspan="7" style="text-align:center;" class="text-error">No contact us available to show....</td></tr>
                              <?
							  } else {
								  $sno = $start + 1;
								  foreach($contactusList as $contact) {
							  ?>
								<tr>
									<td><?=$sno?></td>
                                    <td><?=$contact['name']?></td>
                                    <td><?=$contact['email']?></td>
                                    <td><?=$contact['subject']?></td>
									<td><?=$contact['message']?>
									<?php if($contact['status']==1)
									{ ?><br><div class="replycss"> 
								 <?php
								 echo  "RE: ".$contact['reply_msg']."<br>";
								   
								    echo  "Date: ".$contact['reply_date'];
								   ?>
									</div>
									<?php }?>
									</td>
									<td><?=date("d-M-Y h:i:s",strtotime($contact['date_added']))?></td>
                                    <td>
                                    <?php if($contact['status']==0)
									{ ?>
										<a href="javascript:void(0);" onClick="replyfn('1','<?=$contact['id']?>','<?=$contact['email']?>','<?=$contact['name']?>','<?=$contact['subject']?>')" class="btn btn-small btn-primary"><i class="halflings-icon white ok">&nbsp;</i>Reply</a>
								     <?php } ?>
										
										<a href="./contactus.php?action=delete&id=<?=$contact['id']?>" onClick="return confirm('Do you really want to delete this record?');" class="btn btn-small"><i class="halflings-icon white remove">&nbsp;</i>Delete</a>
										
										
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
	
    	<div class="modal hide fade" id="replymsg">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">x</button>
			<h3>Reply Message</h3>
		</div>
		<form action="contactus.php" method="post" name="replyform">
		<input type="hidden" name="action" value="reply">
		<div class="modal-body" >
			<div>
			<textarea rows="6" cols="20" class="input-xlarge"  style="width:400px;" name="reply" id="reply" placeholder=" Please enter your reply message here ..." required></textarea>
			
			</div>
			
			<input type="hidden" name="id" id="replyid">
			
			<input type="hidden" name="replyemail" id="replyemail">
			
			<input type="hidden" name="replyname" id="replyname">
			
			<input type="hidden" name="replysubject" id="replysubject">
			
			
		</div>
		<div class="modal-footer">
			<a href="javascript:void(0);" onClick="replyfn(2)" class="btn btn-small btn-primary">Send</a>
		</div>
		</form>
	</div>
	
	<!-- start: JavaScript-->
	<? include('./includes/footerinclude.php'); ?>
	<!-- end: JavaScript-->
	
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script>
  function replyfn(type,val,email,name,sub)
  {
	  //alert(type+"-"+val+"-"+email+"-"+name+"-"+sub);
	  if(type==1)
	  {
      $('#replyid').val(val);	
      $('#replyemail').val(email);	 
      $('#replyname').val(name);
	  $('#replysubject').val(sub);
	 $('#replymsg').modal('show');
	  }
	  
	   if(type==2)
	  {
	  document.replyform.submit();	  
	  $('#replyid').val('');	
      $('#replyemail').val('');	
      $('#replyname').val('');
	  $('#replysubject').val(''); 	  
	  $('#replymsg').modal('hide');
	  }
	  
	  
  }
  </script>
</body>
</html>