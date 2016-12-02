<?php
include_once("./config/config.php");

/***
 * initial setup
 */
$pagename = 'myprofile';
$subname = 'password';

$login = check_login();
if($login === false) {
	redirect(HTTP_PATH . 'login.php');
}

if(isset($_REQUEST['cmd'])) {
	if($_REQUEST['cmd'] == '_changePassword') {
		//print_r($_REQUEST);exit;
		include("./functions/register.php");
		$register = new register;
		
		$data = array();
		
		$data['current'] = $db->escape_string($_REQUEST['current']);
		$data['new'] = $db->escape_string($_REQUEST['new']);
		$data['confirm'] = $db->escape_string($_REQUEST['confirm']);
		//rint_r($reg);exit;
		
		$result = $register->changepassword($data);
		
		if($result['error']) {
			if($result['msg'] == 'empty')
				redirect(HTTP_PATH . "password.php?error=empty");
			elseif($result['msg'] == 'insert')
				redirect(HTTP_PATH . "password.php?error=insert");
			elseif($result['msg'] == 'currentpassword')
				redirect(HTTP_PATH . "password.php?error=currentpassword");
			elseif($result['msg'] == 'mismatch')
				redirect(HTTP_PATH . "password.php?error=mismatch");
			else
				redirect(HTTP_PATH . "password.php?error=1");
		} else {
			/*$to = array($reg->email);
			$from = 'info@roophka.com';
			$subject = "Roophka : Registration complete.";
			$message = '<div style="width:600px;">
			Dear '.$reg->name.'<br>
			<p>Welcome to ROOPHKA.COM</p>
			<p>Please login to site and continue earn by seeing advertisements and promotions</p>
			Thanks & regards,<br>
			<a href="roophka.com">roophka.com</a>
			</div>';
			
			$mailler->sendmail($to, $from, $subject, $message);*/
			redirect(HTTP_PATH . "password.php?success=1");
		}
		
	}
	redirect(HTTP_PATH . "password.php");
}

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<? include("./includes/head.php"); ?>
<link type="text/css" rel="stylesheet" href="./assets/css/myprofile.css" />
</head>

<body id="home">
  
	<!-- header area -->
	<? include("./includes/header.php"); ?>
    <!-- end header -->
 
 
<? include("./includes/head-wrap.php"); ?>

<!-- main content area -->   
<div id="main" class="wrapper myprofile"> 
	
    <? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == 'currentpassword') { ?>
    <div class="error-msg"><strong>Update failed!</strong> Invalid current password...</div>
    <? } ?>
    
    <? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == 'mismatch') { ?>
    <div class="error-msg"><strong>Update failed!</strong> New password and confirm password mismatch, Please try again...</div>
    <? } ?>
    
    <? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == 'empty') { ?>
    <div class="error-msg"><strong>Update failed!</strong> All fields should be filled...</div>
    <? } ?>
    
    <? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == 'insert') { ?>
    <div class="error-msg"><strong>Update failed!</strong> Data update issue, Please try again or after some time later.</div>
    <? } ?>
    
    <? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == '1') { ?>
    <div class="error-msg"><strong>Update failed!</strong> Some thing went wrong, Please try again later</div>
    <? } ?>
    
    <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '1') { ?>
    <div class="success-msg"><strong>Update Success!</strong> Password changed successfully....</div>
    <? } ?>
    
    <!-- content area -->    
	<section id="content">
        <div class="panel panel-primary">
          <div class="panel-heading">Change Password</div>
            <div class="panel-body">
            <p>&nbsp;</p>
            <form class="form-horizontal" action='password.php' name="changePassword" id="changePassword" method="POST" data-parsley-validate="">
            <input type="hidden" name="cmd" value="_changePassword" />
          	<div class="grid_12">
                <div class="grid_3 margin-clear">
                    Current Password : 
                </div>
                <div class="grid_9 margin-clear">
                    <input type="password" name="current" id="current" class="form-control width-50" required />
                </div>
            </div>
            <div class="clearfix"></div>
            
            <div class="grid_12">
                <div class="grid_3 margin-clear">
                    New Password : 
                </div>
                <div class="grid_9 margin-clear">
                    <input type="password" name="new" id="new" class="form-control width-50" required />
                </div>
            </div>
            <div class="clearfix"></div>
            
            <div class="grid_12">
                <div class="grid_3 margin-clear">
                    Confirm New Password : 
                </div>
                <div class="grid_9 margin-clear">
                    <input type="password" name="confirm" id="confirm" class="form-control width-50" data-parsley-equalto="#new" required data-parsley-equalto-message="This field should be equal to new password." />
                </div>
            </div>
            <div class="clearfix"></div>
            
            <div class="grid_12">
            	<center><button type="submit" class="btn btn-primary">Change</button></center>
            </div>
            <div class="clearfix"></div>
            </form>
          </div>
        </div>
    </section><!-- #end content area -->
      
      
    <!-- sidebar -->    
    <? include("./includes/loginmenu.php"); ?>
    <!-- #end sidebar -->
   
  </div><!-- #end div #main .wrapper -->


<!-- footer area -->    
<? include("./includes/footer.php"); ?>
<!-- #end footer area --> 

<? include("./includes/footerinclude.php"); ?>

<script src="./assets/js/myprofile.js"></script>

</body>
</html>