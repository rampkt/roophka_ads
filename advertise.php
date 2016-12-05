<?php
include_once("./config/config.php");
/***
 * initial setup
 */
$pagename = 'advertise';
$subname = 'advertise';

include("./functions/location.php");
include("./functions/cms.php");

$cms=new cms();
if(isset($_REQUEST['action'])) {
	if(($_REQUEST['action'])=='advertiseus') {
	
	$cms->companyname = $db->escape_string($_REQUEST['companyname']);
	$cms->email = $db->escape_string($_REQUEST['email']);
	$cms->contact_person = $db->escape_string($_REQUEST['contact_person']);
	$cms->mobile = $db->escape_string($_REQUEST['mobile']);
	$cms->state = $db->escape_string($_REQUEST['state']);
	$cms->city = $db->escape_string($_REQUEST['city']);
	$cms->address1 = $db->escape_string($_REQUEST['address1']);
	$cms->address2 = $db->escape_string($_REQUEST['address2']);
	$cms->pincode = $db->escape_string($_REQUEST['pincode']);
	
	$cms->ipaddr=$_SERVER['REMOTE_ADDR'];
	$adminmail=$cms->getsetting('1','email');
	//echo $adminmail; exit;
	
	$result = $cms->advertisesave();
 // print_r($result);exit;
	
	     
	if($result)
	{
		$from = $cms->email;
		$to = array($adminmail);
		$subject = "ROOPHKA: Advertise with us";
   
    $message = '<div style="width:600px;">
    Dear Admin<br><br>
   
    <p>'.$cms->companyname.' Company are interested to advertise with us, please check and contact this customer as soon as possible</p>
    <br><br>
	
	
    Thanks & regards,<br />
    <a href="'.HTTP_PATH.'">roophka.com</a>
    </div>';
		
		$mailler->sendmail($to, $from, $subject, $message);
		
		
		$from1 = $adminmail;
		$to1 = array($cms->email);
		$subject1 = "ROOPHKA: Advertise with us";
   
    $message1 = '<div style="width:600px;">
    Dear '.$cms->contact_person.'<br><br>
   
    <p>Advertise with us request has been sent to our administator, They will contact as soon.</p>
    <br><br>
	
	
    Thanks & regards,<br />
    <a href="'.HTTP_PATH.'">roophka.com</a>
    </div>';
		
		$mailler->sendmail($to1, $from1, $subject1, $message1);
		
		redirect(HTTP_PATH . "advertise.php?success=1");
	}
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
	<h1>Advertise With Us</h1>
    </div>

</section>

<!-- main content area -->   
<div id="main" class="wrapper register"> 

	<? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == 'empty') { ?>
    <div class="error-msg"><strong>Register failed!</strong> All fields should be filled...</div>
    <? } ?>
    <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '1') { ?>
    <br><div class="success-msg"><strong> Success ! </strong>Your company details has been sent to our administator, they will contact you soon.</div>
    <? } ?>
	<!-- content area -->    
	<section id="content">
    	<form class="form-horizontal" action='' name="advertiseus" method="POST" data-parsley-validate="">
          <fieldset>
            <div class="control-group">
              <!-- Username -->
              <span class="pull-right" id="companyname-error"></span>
              <label class="control-label"  for="companyname">Company Name</label>
              <div class="controls">
                <input type="text" id="companyname" name="companyname" placeholder="" class="form-control input-lg" required data-parsley-errors-container="#name-error" />
                <p class="help-block">Company Name can contain only Characters</p>
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
              <!-- contact_person-->
              <span class="pull-right" id="contact_person-error"></span>
              <label class="control-label" for="contact_person">Contact Person</label>
              <div class="controls">
                <input type="text" id="contact_person" name="contact_person" placeholder="" class="form-control input-lg" required data-parsley-errors-container="#contact_person-error" />
                <p class="help-block">Please enter contact person name here</p>
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
              <!-- address1 -->
              <span class="pull-right" id="address1-error"></span>
              <label class="control-label"  for="dob">Address Line 1</label>
              <div class="controls">
                <input type="text" id="address1" name="address1" placeholder="" class="form-control input-lg" required data-parsley-errors-container="#dob-error" />
                <p class="help-block">Please enter address here</p>
              </div>
            </div>
            
            <div class="control-group">
              <!-- address2 -->
              <span class="pull-right" id="address2-error"></span>
              <label class="control-label"  for="address">Address Line 2</label>
              <div class="controls">
                <input type="text" id="address2" name="address2" placeholder="" class="form-control input-lg"  data-parsley-errors-container="#address2-error" />
                <p class="help-block">Address Line 2 (Optional)</p>
              </div>
            </div>
            
			
            <div class="control-group">
              <!-- Mobile -->
              <span class="pull-right" id="state-error"></span>
              <label class="control-label" for="state">State</label>
              <div id="state_container" class="controls">
                <?=$stateDropDown?>
                <p class="help-block">Choose your state</p>
              </div>
            </div>
            
            <div class="control-group">
              <!-- Mobile -->
              <span class="pull-right" id="city-error"></span>
              <label class="control-label"  for="city">City</label>
              <div id="city_container" class="controls">
                <?=$cityDropDown?>
                <p class="help-block">Choose your city</p>
              </div>
            </div>
            
            <div class="control-group">
              <!-- Mobile -->
              <span class="pull-right" id="pincode-error"></span>
              <label class="control-label"  for="pincode">Pincode</label>
              <div class="controls">
                <input type="text" id="pincode" name="pincode" placeholder="" maxlength="6" class="form-control input-lg numberOnly" required data-parsley-errors-container="#pincode-error" />
                <p class="help-block">Pincode can contain only numbers with 6 digit</p>
              </div>
            </div>
         
            <div class="control-group">
              <!-- Button -->
              <div class="controls">
                <button type="submit" name="action" value="advertiseus" class="btn btn-success">Submit</button>
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