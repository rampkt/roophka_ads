<?php
include_once("./config/config.php");
/***
 * initial setup
 */
$pagename = 'register';
$subname = 'register';

$login = check_login();
if($login === true) {
	redirect(HTTP_PATH . 'dashboard.php');
}
include("./functions/register.php");
include("./functions/location.php");

$reg = new register();

if(isset($_REQUEST['action'])) {
	$reg->name = $db->escape_string($_REQUEST['name']);
	$reg->email = $db->escape_string($_REQUEST['email']);
	$reg->password = $db->escape_string($_REQUEST['password']);
	$reg->mobile = $db->escape_string($_REQUEST['mobile']);
	$reg->dob = $db->escape_string($_REQUEST['dob']);
	$reg->address = $db->escape_string($_REQUEST['address']);
	$reg->state = $db->escape_string($_REQUEST['state']);
	$reg->city = $db->escape_string($_REQUEST['city']);
	$reg->pincode = $db->escape_string($_REQUEST['pincode']);
	
	$result = $reg->save();
  //print_r($result);exit;
	if($result['error']) {
		if($result['msg'] == 'empty')
			redirect(HTTP_PATH . "register.php?error=empty");
		elseif($result['msg'] == 'insert')
			redirect(HTTP_PATH . "register.php?error=insert");
		elseif($result['msg'] == 'duplicate')
			redirect(HTTP_PATH . "register.php?error=duplicate");
		else
			redirect(HTTP_PATH . "register.php?error=1");
	} else {
		$to = array($reg->email);
		$from = 'info@roophka.in';
		$subject = "Roophka : Registration complete.";
		/*$message = '<div style="width:600px;">
		Dear '.$reg->name.'<br>
		<p>Welcome to ROOPHKA.IN</p>
		<p>Please login to site and continue earn by seeing advertisements and promotions</p>
		Thanks & regards,<br>
		<a href="'.HTTP_PATH.'">roophka.in</a>
		</div>';*/
    $encarray = array('userid'=>$result['userid'], 'action'=>'verify', 'type'=>'email');
    $enc = three_layer_encrypt('',$encarray);
    $message = '<div style="width:600px;">
    Dear '.$reg->name.'<br>
    <p>Welcome to ROOPHKA.IN</p>
    <p>Please verify your mail address by clicking below link.</p>
    <a href="'.HTTP_PATH.'userlogin.php?enc='.$enc.'">Click here to verify</a><br /><br />
    Thanks & regards,<br />
    <a href="'.HTTP_PATH.'">roophka.in</a>
    </div>';
		
		$mailler->sendmail($to, $from, $subject, $message);
		redirect(HTTP_PATH . "register_confirm.php?verify=1");
	}
}

$location = new location;

$stateDropDown = $location->getStateDropdown($location->country_id, 0, '', true, 'data-parsley-errors-container="#state-error"');
$cityDropDown = $location->getCityDropdown(0, 0, '', true, 'data-parsley-errors-container="#city-error"');

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<? include("./includes/head.php"); ?>
<link type="text/css" rel="stylesheet" href="./assets/css/registration.css" />
</head>

<body id="home">
  
	<!-- header area -->
	<? include("./includes/header.php"); ?>
    <!-- end header -->
 
 
<section id="page-header" class="clearfix">    
<!-- responsive FlexSlider image slideshow -->
<div class="wrapper">
	<h1>Registration</h1>
    </div>

</section>

<!-- main content area -->   
<div id="main" class="wrapper register"> 
	<? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == 'empty') { ?>
    <div class="error-msg"><strong>Register failed!</strong> All fields should be filled...</div>
    <? } ?>
    
    <? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == 'duplicate') { ?>
    <div class="error-msg"><strong>Register failed!</strong> Email id already exists...</div>
    <? } ?>
    
    <? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == 'insert') { ?>
    <div class="error-msg"><strong>Register failed!</strong> Data update issue, Please try again or after some time later.</div>
    <? } ?>
    
    <? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == '1') { ?>
    <div class="error-msg"><strong>Register failed!</strong> Some thing went wrong, Please try again later</div>
    <? } ?>
    
	<!-- content area -->    
	<section id="content">
    	<form class="form-horizontal" action='' name="registration" method="POST" data-parsley-validate="">
          <fieldset>
            <div class="control-group">
              <!-- Username -->
              <span class="pull-right" id="name-error"></span>
              <label class="control-label"  for="name">Name</label>
              <div class="controls">
                <input type="text" id="name" name="name" placeholder="" class="form-control input-lg" required data-parsley-errors-container="#name-error" />
                <p class="help-block">Name can contain only letters</p>
              </div>
            </div>
         
            <div class="control-group">
              <!-- E-mail -->
              <span class="pull-right" id="email-error"></span>
              <label class="control-label" for="email">E-mail</label>
              <div class="controls">
                <input type="email" id="email" name="email" placeholder="" class="form-control input-lg" required data-parsley-errors-container="#email-error" />
                <p class="help-block">Please provide your E-mail</p>
              </div>
            </div>
         
            <div class="control-group">
              <!-- Password-->
              <span class="pull-right" id="password-error"></span>
              <label class="control-label" for="password">Password</label>
              <div class="controls">
                <input type="password" id="password" name="password" placeholder="" class="form-control input-lg" required data-parsley-errors-container="#password-error" />
                <p class="help-block">Password should be at least 4 characters</p>
              </div>
            </div>
         
            <div class="control-group">
              <!-- Password -->
              <span class="pull-right" id="re-pass-error"></span>
              <label class="control-label"  for="password_confirm">Password (Confirm)</label>
              <div class="controls">
                <input type="password" id="password_confirm" name="password_confirm" placeholder="" class="form-control input-lg" required data-parsley-errors-container="#re-pass-error" data-parsley-equalto="#password" data-parsley-equalto-message="This field should equal to password." />
                <p class="help-block">Please confirm password</p>
              </div>
            </div>
            
            <div class="control-group">
              <!-- Mobile -->
              <span class="pull-right" id="mobile-error"></span>
              <label class="control-label"  for="mobile">Mobile</label>
              <div class="controls">
                <input type="text" id="mobile" name="mobile" placeholder="" class="form-control input-lg numberOnly" required data-parsley-errors-container="#mobile-error" maxlength="10" />
                <p class="help-block">Mobile can contain only numbers with 10 digit</p>
              </div>
            </div>
            
            <div class="control-group">
              <!-- Mobile -->
              <span class="pull-right" id="dob-error"></span>
              <label class="control-label"  for="dob">D O B</label>
              <div class="controls">
                <input type="date" id="dob" name="dob" placeholder="" class="form-control input-lg" required data-parsley-errors-container="#dob-error" />
                <p class="help-block">Must be 13 years old</p>
              </div>
            </div>
            
            <div class="control-group">
              <!-- Mobile -->
              <span class="pull-right" id="address-error"></span>
              <label class="control-label"  for="address">Address</label>
              <div class="controls">
                <input type="text" id="address" name="address" placeholder="" class="form-control input-lg" required data-parsley-errors-container="#address-error" />
                <p class="help-block">Full address</p>
              </div>
            </div>
            
            <div class="control-group">
              <!-- Mobile -->
              <span class="pull-right" id="state-error"></span>
              <label class="control-label" for="state">State</label>
              <div id="state_container" class="controls">
                <?=$stateDropDown?>
                <p class="help-block">&nbsp;</p>
              </div>
            </div>
            
            <div class="control-group">
              <!-- Mobile -->
              <span class="pull-right" id="city-error"></span>
              <label class="control-label"  for="city">City</label>
              <div id="city_container" class="controls">
                <?=$cityDropDown?>
                <p class="help-block">&nbsp;</p>
              </div>
            </div>
            
            <div class="control-group">
              <!-- Mobile -->
              <span class="pull-right" id="pincode-error"></span>
              <label class="control-label"  for="pincode">Pincode</label>
              <div class="controls">
                <input type="text" id="pincode" name="pincode" placeholder="" class="form-control input-lg" required data-parsley-errors-container="#pincode-error" />
                <p class="help-block">Mobile can contain only numbers with 10 digit</p>
              </div>
            </div>
         
            <div class="control-group">
              <!-- Button -->
              <div class="controls">
                <button type="submit" name="action" value="register" class="btn btn-success">Register</button>
              </div>
            </div>
          </fieldset>
        </form>
    </section><!-- #end content area -->
      
      
    <!-- sidebar -->    
    <? include("./includes/loginmenu.php"); ?>
    <!-- #end sidebar -->
   
  </div><!-- #end div #main .wrapper -->


<!-- footer area -->    
<? include("./includes/footer.php"); ?>
<!-- #end footer area --> 

<? include("./includes/footerinclude.php"); ?>

<script src="./assets/js/register.js"></script>

</body>
</html>