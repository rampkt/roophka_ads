<?php
include_once("./config/config.php");
/***
 * initial setup
 */
$pagename = 'contact';
$subname = 'contact';
include("./functions/cms.php");

$cms=new cms();
if(isset($_REQUEST['action'])) {
	if(($_REQUEST['action'])=='contactus') {
	
	$cms->name = $db->escape_string($_REQUEST['name']);
	$cms->email = $db->escape_string($_REQUEST['email']);
	$cms->subject = $db->escape_string($_REQUEST['subject']);
	$cms->message = $db->escape_string($_REQUEST['message']);
	$cms->ipaddr=$_SERVER['REMOTE_ADDR'];
	$adminmail=$cms->getsetting('1','email');
	//echo $adminmail; exit;
	
	$result = $cms->contactussave();
 // print_r($result);exit;
	
	     
	if($result)
	{
		$from = $cms->email;
		$to = array($adminmail);
		$subject = $cms->subject;
   
    $message = '<div style="width:600px;">
    Dear Admin<br>
    <p>Welcome to ROOPHKA.COM</p>
    <p>Please check below mentioned customer query. revert back to user as soon as possible</p>
    <br/>
	<table>
	<tr>
	<td>Name :</td>
	<td>'.$cms->name.'</td>
	
	</tr>
	<tr>
	<td>Message :</td>
	<td>'.$cms->message.'</td>
	
	</tr>
	
	</table><br><br>
	
    Thanks & regards,<br />
    <a href="'.HTTP_PATH.'">roophka.com</a>
    </div>';
		
		$mailler->sendmail($to, $from, $subject, $message);
		
		$from1 = $adminmail;
		$to1 = array($cms->email);
		$subject1 = "ROOPHKA: Contact us";
   
    $message1 = '<div style="width:600px;">
    Dear '.$cms->name.'<br><br>
   
    <p>Your Message has been sent to our administator, They will contact as soon.</p>
    <br><br>
	
	
    Thanks & regards,<br />
    <a href="'.HTTP_PATH.'">roophka.com</a>
    </div>';
		
		$mailler->sendmail($to1, $from1, $subject1, $message1);
		
		
		redirect(HTTP_PATH . "contactus.php?success=1");
	}
}
}

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
	<h1>Contact Us</h1>
    </div>

</section>

<!-- main content area -->   
<div id="main" class="wrapper register"> 
	<? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == 'empty') { ?>
    <div class="error-msg"><strong>Failed!</strong> All fields should be filled...</div>
    <? } ?>
    
    <? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == 'insert') { ?>
    <div class="error-msg"><strong> Failed!</strong> Data update issue, Please try again or after some time later.</div>
    <? } ?>
    
      <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '1') { ?>
    <div class="success-msg"><strong> Success ! </strong>Message has been sent to our administator, they will contact you soon.</div>
    <? } ?>
	<!-- content area -->    
	<section id="content">
    	<form class="form-horizontal" action='' name="contactus" method="POST" data-parsley-validate="">
          <fieldset>
            <div class="control-group">
              <!-- Username -->
              <span class="pull-right" id="name-error"></span>
              <label class="control-label"  for="name">Name</label>
              <div class="controls">
                <input type="text" id="name" name="name" placeholder="" class="form-control input-lg" required data-parsley-errors-container="#name-error" />
                <p class="help-block">Name can contain only Characters</p>
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
              <!-- subject -->
              <span class="pull-right" id="subject-error"></span>
              <label class="control-label"  for="subject">Subject</label>
              <div class="controls">
                <input type="text" id="subject" name="subject" placeholder="" class="form-control input-lg" required data-parsley-errors-container="#subject-error"  />
                <p class="help-block">Please enter subject here</p>
              </div>
            </div>
            
            <div class="control-group">
              <!-- subject -->
              <span class="pull-right" id="message-error"></span>
              <label class="control-label"  for="message">Message</label>
              <div class="controls">
                <textarea id="message" name="message" style="height:150px;" placeholder="" class="form-control input-lg" required data-parsley-errors-container="#message-error"></textarea>
                <p class="help-block">Please enter your message here</p>
              </div>
            </div>
            
         
            <div class="control-group">
              <!-- Button -->
              <div class="controls">
                <button type="submit" name="action" value="contactus" class="btn btn-success">Submit</button>
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