<?php
include_once("./config/config.php");

/***
 * initial setup
 */
$pagename = 'myprofile';
$subname = '';
$view = (isset($_REQUEST['view']) ? $_REQUEST['view'] : '');


$login = check_login();
if($login === false) {
	redirect(HTTP_PATH . 'login.php');
}

if(isset($_REQUEST['cmd'])) {
	if($_REQUEST['cmd'] == '_editProfile') {
		//print_r($_REQUEST);exit;
		include("./functions/register.php");
		$register = new register;
		
		$decrpt = three_layer_decrypt('', $_REQUEST['enc']);
		
		$register->userid = $_SESSION['roo']['user']['id'];
		$register->name = $db->escape_string($_REQUEST['name']);
		$register->mobile = $db->escape_string($_REQUEST['mobile']);
		$register->dob = $db->escape_string($_REQUEST['dob']);
		$register->address = $db->escape_string($_REQUEST['address']);
		$register->state = $db->escape_string($_REQUEST['state']);
		$register->city = $db->escape_string($_REQUEST['city']);
		$register->pincode = $db->escape_string($_REQUEST['pincode']);
		
		//rint_r($reg);exit;
		
		$result = $register->update();
		if($result['error']) {
			if($result['msg'] == 'empty')
				redirect(HTTP_PATH . "myprofile.php?view=_edit&error=empty");
			elseif($result['msg'] == 'insert')
				redirect(HTTP_PATH . "myprofile.php?view=_edit&error=insert");
			else
				redirect(HTTP_PATH . "myprofile.php?view=_edit&error=1");
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
			redirect(HTTP_PATH . "myprofile.php?success=1");
		}
		
	}
	redirect(HTTP_PATH . "myprofile.php");
}

include("./functions/user.php");
include("./functions/location.php");
$user = new user;
$location = new location;

$user = $user->fullDetails();
$stateDropDown = $location->getStateDropdown($location->country_id, $user['state'], 'width-50', true, '');
$cityDropDown = $location->getCityDropdown($user['state'], $user['city'], 'width-50', true, '');

$enc = three_layer_encrypt('',array("userid" => $_SESSION['roo']['user']['id']));

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
<div id="main" class="wrapper dashboard"> 
	
    <? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == 'empty') { ?>
    <div class="error-msg"><strong>Register failed!</strong> All fields should be filled...</div>
    <? } ?>
    
    <? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == 'insert') { ?>
    <div class="error-msg"><strong>Register failed!</strong> Data update issue, Please try again or after some time later.</div>
    <? } ?>
    
    <? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == '1') { ?>
    <div class="error-msg"><strong>Register failed!</strong> Some thing went wrong, Please try again later</div>
    <? } ?>
    
    <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '1') { ?>
    <div class="success-msg"><strong>Update Success!</strong> Profile updated successfully....</div>
    <? } ?>
    
    <!-- content area -->    
	<section id="content">
    	<? if($view == '') { ?>
        <div class="panel panel-primary">
          <div class="panel-heading">
          	User Details
            <a href="./myprofile.php?view=_edit" style="color:#FFF;" class="pull-right">Edit</a>
          </div>
          <div class="panel-body">
          	<div class="grid_12">
                <div class="grid_3 margin-clear">
                    Name : 
                </div>
                <div class="grid_9 margin-clear">
                    <?=$user['firstname']?>
                </div>
            </div>
            <div class="clearfix"></div>
            
            <div class="grid_12">
                <div class="grid_3 margin-clear">
                    Email : 
                </div>
                <div class="grid_9 margin-clear">
                    <?=$user['email']?>
                </div>
            </div>
            <div class="clearfix"></div>
            
            <div class="grid_12">
                <div class="grid_3 margin-clear">
                    Mobile : 
                </div>
                <div class="grid_9 margin-clear">
                    <?=$user['phone']?>
                </div>
            </div>
            <div class="clearfix"></div>
            
            <div class="grid_12">
                <div class="grid_3 margin-clear">
                    D O B : 
                </div>
                <div class="grid_9 margin-clear">
                    <?=date("d-M-Y",strtotime($user['dob']))?>
                </div>
            </div>
            <div class="clearfix"></div>
            
            <div class="grid_12">
                <div class="grid_3 margin-clear">
                    Address : 
                </div>
                <div class="grid_9 margin-clear">
                    <?=$user['address']?>
                </div>
            </div>
            <div class="clearfix"></div>
            
            <div class="grid_12">
                <div class="grid_3 margin-clear">
                    State : 
                </div>
                <div class="grid_9 margin-clear">
                    <?=$user['state_name']?>
                </div>
            </div>
            <div class="clearfix"></div>
            
            <div class="grid_12">
                <div class="grid_3 margin-clear">
                    City : 
                </div>
                <div class="grid_9 margin-clear">
                    <?=$user['city_name']?>
                </div>
            </div>
            <div class="clearfix"></div>
            
            <div class="grid_12">
                <div class="grid_3 margin-clear">
                    Pincode : 
                </div>
                <div class="grid_9 margin-clear">
                    <?=$user['pincode']?>
                </div>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <? } if($view == '_edit') { ?>
        <div class="panel panel-primary">
          <div class="panel-heading">Edit Uset Details</div>
            <div class="panel-body">
            <form class="form-horizontal" action='myprofile.php' name="profile_edit" id="profile_edit" method="POST" data-parsley-validate="" onSubmit="return editprofile();">
            <input type="hidden" name="enc" value="<?=$enc?>" /> 
            <input type="hidden" name="cmd" value="_editProfile" />
          	<div class="grid_12">
                <div class="grid_3 margin-clear">
                    Name : 
                </div>
                <div class="grid_9 margin-clear">
                    <input type="text" name="name" id="name" value="<?=$user['firstname']?>" class="form-control width-50" required />
                </div>
            </div>
            <div class="clearfix"></div>
            
            <!--<div class="grid_12">
                <div class="grid_3 margin-clear">
                    Email : 
                </div>
                <div class="grid_9 margin-clear">
                    <input type="email" name="email" id="email" value="<?=$user['email']?>" class="form-control width-50" required />
                </div>
            </div>
            <div class="clearfix"></div>-->
            
            <div class="grid_12">
                <div class="grid_3 margin-clear">
                    Mobile : 
                </div>
                <div class="grid_9 margin-clear">
                    <input type="tel" name="mobile" id="mobile" value="<?=$user['phone']?>" class="form-control width-50" required />
                </div>
            </div>
            <div class="clearfix"></div>
            
            <div class="grid_12">
                <div class="grid_3 margin-clear">
                    D O B : 
                </div>
                <div class="grid_9 margin-clear">
                    <input type="date" name="dob" id="dob" value="<?=$user['dob']?>" class="form-control width-50" required />
                </div>
            </div>
            <div class="clearfix"></div>
            
            <div class="grid_12">
                <div class="grid_3 margin-clear">
                    Address : 
                </div>
                <div class="grid_9 margin-clear">
                    <input type="text" name="address" id="address" value="<?=$user['address']?>" class="form-control width-50" required />
                </div>
            </div>
            <div class="clearfix"></div>
            
            <div class="grid_12">
                <div class="grid_3 margin-clear">
                    State : 
                </div>
                <div id="state_container" class="grid_9 margin-clear">
                    <?=$stateDropDown?>
                </div>
            </div>
            <div class="clearfix"></div>
            
            <div class="grid_12">
                <div class="grid_3 margin-clear">
                    City : 
                </div>
                <div id="city_container" class="grid_9 margin-clear">
                    <?=$cityDropDown?>
                </div>
            </div>
            <div class="clearfix"></div>
            
            <div class="grid_12">
                <div class="grid_3 margin-clear">
                    Pincode : 
                </div>
                <div class="grid_9 margin-clear">
                    <input type="text" name="pincode" id="pincode" value="<?=$user['pincode']?>" class="form-control width-50" required />
                </div>
            </div>
            <div class="clearfix"></div>
            
            <div class="grid_12">
            	<center><button type="submit" class="btn btn-primary">Save</button> <button type="button" class="btn btn-default" onClick="window.location='./myprofile.php'">Cancel</button></center>
            </div>
            <div class="clearfix"></div>
            </form>
          </div>
        </div>
        <? } ?>
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