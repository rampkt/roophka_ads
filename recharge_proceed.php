<?php
error_reporting(0);
include_once("./config/config.php");

if($setting['recharge'] == 1) {
	header("Location:underconstruction.php?from=recharge");exit;
}

/***
 * initial setup
 */
$pagename = 'recharge'; 
$subname = 'recharge';
include("./functions/cms.php");
$cms = new cms;

include("./functions/user.php");
include("./functions/ads.php");
$user = new user;
$ads = new ads;
 
if((isset($_REQUEST['action'])) && ($_REQUEST['action']=='recharge'))
{
	$_SESSION['recharge_mobile']=$_REQUEST['mobile'];
	$_SESSION['recharge_operator']=$_REQUEST['operator'];
	$_SESSION['recharge_circle']=$_REQUEST['circle'];
	$_SESSION['recharge_amount']=$_REQUEST['amount'];
	//redirect(HTTP_PATH . 'recharge_proceed.php');
}
if((isset($_REQUEST['type'])) && ($_REQUEST['type']=='spl'))
{
	$_SESSION['spl_recharge_today']=$_REQUEST['type'];
	//redirect(HTTP_PATH . 'recharge_proceed.php');
}

if((isset($_REQUEST['action'])) && ($_REQUEST['action']=='recharge_now'))
{
	$_SESSION['recharge_mobile']=$_REQUEST['mobile'];
	$_SESSION['recharge_operator']=$_REQUEST['operator'];
	$_SESSION['recharge_circle']=$_REQUEST['circle'];
	$_SESSION['recharge_amount']=$_REQUEST['amount'];
	$_SESSION['action']=$_REQUEST['recharge_now'];
}
	
$login = check_login();
if($login === false) {
	redirect(HTTP_PATH . 'login.php');
}
			
if((isset($_REQUEST['action'])) && ($_REQUEST['action']=='recharge_now'))
{
	$_SESSION['recharge_mobile']=$_REQUEST['mobile'];
	$_SESSION['recharge_operator']=$_REQUEST['operator'];
	$_SESSION['recharge_circle']=$_REQUEST['circle'];
	$_SESSION['recharge_amount']=$_REQUEST['amount'];
	//redirect(HTTP_PATH . 'recharge_proceed.php');
	$mobile=$_REQUEST['mobile'];  
	$operator=$_REQUEST['operator'];  
	if($splrc=='1')	{
		$amount=10; 
	} else {
		$amount=$_REQUEST['amount']; 	
	}

	$sessuser_id = $_SESSION['roo']['user']['id'];
	//generating random unique orderid for your reference 
	$uniqueorderid = substr(number_format(time() * rand(),0,'',''),0,10);  
	$splrc=$_REQUEST['spl_rechr'];
	//inserting above 4 values in database first 
	//run your php query here to store values of user inputs in database 

	//now run joloapi.com api link for recharge 
	$ch = curl_init(); 
	$timeout = 100; // set to zero for no timeout 

	$apikey="104746188241741";
	$apiuserid="roophka";

	$myHITurl = "http://joloapi.com/api/recharge.php?mode=1&userid=$apiuserid&key=$apikey&operator=$operator&service=$mobile&amount=$amount&orderid=$uniqueorderid"; 

	//echo $myHITurl;
	curl_setopt ($ch, CURLOPT_URL, $myHITurl); 
	curl_setopt ($ch, CURLOPT_HEADER, 0); 
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout); 
	$file_contents = curl_exec($ch); 
	$curl_error = curl_errno($ch); 

	curl_close($ch); 

	//dump output of api if you want during test 
	//echo"$file_contents"; exit;
	$joloapiorderid='';
	// lets extract data from output for display to user and for updating databse 
	$maindata = explode(",", $file_contents); 
	$countdatas = count($maindata); 
	if($countdatas > 2) { 
		//recharge is success 
		$joloapiorderid = $maindata[0]; //it is joloapi.com generated order id 
		$txnstatus = $maindata[1]; //it is status of recharge SUCCESS,FAILED 
		$operator = $maindata[2]; //operator code 
		$service = $maindata[3]; //mobile number 
		$amount = $maindata[4]; //amount 
		$mywebsiteorderid = $maindata[5]; //your website order id 
		$errorcode = $maindata[6]; // api error code  
		$operatorid = $maindata[7]; //original operator transaction id 
		$myapibalance = $maindata[8];  //my joloapi.com remaining balance 
		$myapiprofit = $maindata[9]; //my earning on this recharge 
		$txntime = $maindata[10]; // recharge time 
	} else { 
		//recharge is failed 
		$txnstatus = $maindata[0]; //it is status of recharge FAILED 
		$errorcode= $maindata[1]; // api error code  
	} 

	//if curl request timeouts 
	if($curl_error=='28'){ 
		//Request timeout, consider recharge status as pending/success 
		$txnstatus = "PENDING"; 
	} 

	//cases 
	if($txnstatus=='SUCCESS'){ 
		//YOUR REST QUERY HERE 
		$qry="INSERT INTO roo_recharge(user_id,amount,mobile,apiorder_id,recharge_status,operator,myorder_id,date_added,status) values('$sessuser_id','$amount','$mobile','$joloapiorderid','$txnstatus','$operator','$mywebsiteorderid','".DATETIME24H."','0')";
		$ins=$db->query($qry);

		$balance=$_SESSION['roo']['user']['account_balance']-$amount;
		$_SESSION['roo']['user']['account_balance']=$balance;

		if($splrc=='1') {
			$qqry2="UPDATE roo_users SET spl_recharge='1' where id='$sessuser_id'";
			$qupd=$db->query($qqry2);
			$_SESSION['roo']['user']['spl_recharge']=1;
		} else {
			$qry2="UPDATE roo_users SET account_balance='$balance' where id='$sessuser_id'";
			$upd=$db->query($qry2);
		}

		$adminmail=$cms->getsetting('1','email');
		$opname=$user->getoperator_name($operator);
		//echo $opname; exit;

		$from = $adminmail;
		$to = array($_SESSION['roo']['user']['email']);
		$subject = "ROOPHKA: Your Recharge of $opname Mobile $mobile for Rs.$amount was successfull !";

		$message = '<div style="background-color: #fff;width: 650px;margin: 0 auto; box-shadow: 1px 6px 40px #aaa;border: 1px solid #ccc;padding: 10px;font-family: arial;font-size: 14px;"> 
		<table style="width:100%;border-bottom:1px dashed #ccc;font-size: 14px;" >
		<tr>
		<td style="width:55%;">
		<div>
		<a href="'.HTTP_PATH.'" target="_blank">
		<img src="'.HTTP_PATH.'assets/img/logo150X150.png" style="width:200px;height:100px;">
		<a>
		</div>
		<div>
		<h3>Transaction receipt</h3>
		<p>Order no: #'.$mywebsiteorderid.'</p>
		<p>Operator reference no: #'.$joloapiorderid.' </p>
		<p>'.date('d-m-Y h:i a').'</p>
		<br/>
		<p>'.$_SESSION['roo']['user']['phone'].'</p>
		<p><a href="mailto:'.$_SESSION['roo']['user']['email'].'">'.$_SESSION['roo']['user']['email'].'</a></p>
		</div>
		</td>
		<td style="width:38%;">
		<div>If you have any query or support! Please <a href="'.HTTP_PATH.'contactus.php">Click here</a> to reach us. </di>

		</td>
		<td style="width:12%;">
		<div>
		<img src="'.HTTP_PATH.'assets/img/r-logo.png">
		</div>

		</td>
		</tr>
		</table>

		<table style="width:100%;height:70px;border-bottom:1px dashed #ccc;font-size: 14px;">
		<tr >

		<td style="width:85%;">Recharge of '.$opname.' Mobile '.$mobile.' for</td>
		<td style="width:15%;"> Rs.'.$amount.'</td>

		</tr>
		</table>
		<table style="width:100%;height:70px;border-bottom:1px dashed #ccc;font-size: 14px;">
		<tr>

		<td style="width:85%;">Total</td>
		<td style="width:15%;"> Rs.'.$amount.'</td>

		</tr>
		</table>
		<table style="width:100%;height:70px;padding-bottom:10px;font-size: 14px;">
		<tr>

		<td style="width:85%;"><strong>Amount Paid</strong></td>
		<td style="width:15%;"><strong>Rs.'.$amount.'</strong></td>

		</tr>
		</table>


		<br/>

		Thanks & regards,<br />
		<a href="'.HTTP_PATH.'">roophka.com</a>
		</div>';

		//echo $message; exit;

		$mailler->sendmail($to, $from, $subject, $message);
		unset($_SESSION['recharge_mobile']);
		unset($_SESSION['recharge_operator']);
		unset($_SESSION['recharge_circle']);
		unset($_SESSION['recharge_amount']);
		redirect(HTTP_PATH . 'recharge_proceed.php?report=success&view=order');
	}  
	if($txnstatus=='PENDING'){ 
		//YOUR REST QUERY HERE 
		$qry="INSERT INTO roo_recharge(user_id,amount,mobile,apiorder_id,recharge_status,operator,myorder_id,date_added,status) values('$sessuser_id','$amount','$mobile','$joloapiorderid','$txnstatus','$operator','$uniqueorderid','".DATETIME24H."','0')";

		$ins=$db->query($qry);
		unset($_SESSION['recharge_mobile']);
		unset($_SESSION['recharge_operator']);
		unset($_SESSION['recharge_circle']);
		unset($_SESSION['recharge_amount']);
		redirect(HTTP_PATH . 'recharge_proceed.php?report=pending&view=order');
	} 
	if($txnstatus=='FAILED'){ 
		//YOUR REST QUERY HERE 
		$qry="INSERT INTO roo_recharge(user_id,amount,mobile,apiorder_id,recharge_status,operator,myorder_id,date_added,status) values('$sessuser_id','$amount','$mobile','$joloapiorderid','$txnstatus','$operator','$uniqueorderid','".DATETIME24H."','0')";

		//echo $qry; exit;

		$ins=$db->query($qry);
		unset($_SESSION['recharge_mobile']);
		unset($_SESSION['recharge_operator']);
		unset($_SESSION['recharge_circle']);
		unset($_SESSION['recharge_amount']);
		redirect(HTTP_PATH . 'recharge_proceed.php?report=failed&view=order');
	} 

	unset($_SESSION['recharge_mobile']);
	unset($_SESSION['recharge_operator']);
	unset($_SESSION['recharge_circle']);
	unset($_SESSION['recharge_amount']);

	redirect(HTTP_PATH . 'recharge_proceed.php?');			
}

//echo $_SESSION['recharge_mobile'];


$ads->resetAd();
$database = $user->dashboard();
$recharge = $user->recharge_order();
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<? include("./includes/head.php"); ?>
<link type="text/css" rel="stylesheet" href="./assets/css/dashboard.css" />
</head>

<body id="home">
  
	<!-- header area -->
	<? include("./includes/header.php"); ?>
    <!-- end header -->
 
 
<? include("./includes/head-wrap.php"); ?>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="./assets/js/tabs.js"></script>
  <script src="./assets/js/recharge.js"></script>
  <link type="text/css" rel="stylesheet" href="./assets/css/tabs.css" />
<!-- main content area -->   
<div id="main" class="wrapper dashboard"> 
	
    <!-- content area -->    
	<?php $apibalance=$cms->checkbalance();
	//echo $apibalance ?>
	<? if($apibalance == '0') { ?>
	<br>
    <div class="error-msg"><strong>Please Try again later !</strong> You not able to recharge now, because we need to add money in my Recharge Wallet.</div>
    <? } ?>
	
	<? if(isset($_REQUEST['report']) AND $_REQUEST['report'] == 'failed') { ?>
    <div class="error-msg"><strong>Order failed !</strong> Your order has been failed, please try again.</div>
    <? } ?>
    
    <? if(isset($_REQUEST['report']) AND $_REQUEST['report'] == 'pending') { ?>
    <div class="error-msg"><strong>Order Pending !</strong>Your order has been in pending, Please wait.</div>
    <? } ?>
    
    <? if(isset($_REQUEST['report']) AND $_REQUEST['report'] == 'success') { ?>
    <div class="success-msg"><strong>Order Success !</strong> Your Recharge is succesful, Please check your balance.</div>
    <? } ?>
	<section id="content">
	 <?php if((isset($_REQUEST['view'])) && ($_REQUEST['view']=='recharge')){ ?>
	 
	  <div id='rgsplid' class="grid_12" style="display:none;">
        	
        	
              <div class="spl-heading">Special Recharge</div>
			
			<img src="./assets/img/pay-per-click-advertising.jpg">
			<div class="grid_12">
        	<h4>User account summary:</h4>
        	<ol>
            	<li>Last login : <?=$_SESSION['roo']['user']['lastlogin']?></li>
                <li>Total ads viwed so far : <?=$database['total_ads']?></li>
                <li>Total amount earned so far : <i class="fa fa-inr" aria-hidden="true"></i> <?=$database['total_amount']?></li>
                <li>Total amount withdrawn : <i class="fa fa-inr" aria-hidden="true"></i> <?=$database['withdraw_amount']?></li>
            </ol>
        </div>
      </div>  
	 
	 
	 <div id='plandlid' class="grid_12 no-padding" >
             <div class="panel panel-primary" style="text-align:left;">
              <div class="panel-heading">Operator Plan Details</div>
              <div class="panel-body" style="height:405px;">
		       <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#topup" onclick="findoperatorplans('TUP')">Top Up</a></li>
    <li><a data-toggle="tab" href="#talk" onclick="findoperatorplans('FTT')">Full Talktime</a></li>
    <li><a data-toggle="tab" href="#2g" onclick="findoperatorplans('2G')">2G</a></li>
    <li><a data-toggle="tab" href="#3g" onclick="findoperatorplans('3G')">3G/4G</a></li>
	<li><a data-toggle="tab" href="#sms" onclick="findoperatorplans('SMS')">SMS</a></li>
	<li><a data-toggle="tab" href="#local" onclick="findoperatorplans('LSC')">Local/STD/ISD</a></li>
	<li><a data-toggle="tab" href="#roaming" onclick="findoperatorplans('RMG')">Roaming</a></li>
	<li><a data-toggle="tab" href="#other" onclick="findoperatorplans('OTR')">Other</a></li>
  </ul>

  <div class="tab-content" style="overflow-y:scroll;height:310px">
    <div id="topup" class="tab-pane fade in active">
      <div id="topupplansTUP"><br>Enter 10 digit mobile number in given form on the left to view plans.</div>
    </div>
    <div id="talk" class="tab-pane fade">
     <div id="topupplansFTT"><br>Enter 10 digit mobile number in given form on the left to view plans.</div>
    </div>
    <div id="2g" class="tab-pane fade">
     <div id="topupplans2G"><br>Enter 10 digit mobile number in given form on the left to view plans.</div>
    </div>
    <div id="3g" class="tab-pane fade">
      <div id="topupplans3G"><br>Enter 10 digit mobile number in given form on the left to view plans.</div>
    </div>
	 <div id="sms" class="tab-pane fade">
      <div id="topupplansSMS"><br>Enter 10 digit mobile number in given form on the left to view plans.</div>
    </div>
	<div id="local" class="tab-pane fade">
     <div id="topupplansLSC"><br>Enter 10 digit mobile number in given form on the left to view plans.</div>
    </div>
	<div id="roaming" class="tab-pane fade">
      <div id="topupplansRMG"><br>Enter 10 digit mobile number in given form on the left to view plans.</div>
    </div>
	<div id="other" class="tab-pane fade">
      <div id="topupplansOTR"><br>Enter 10 digit mobile number in given form on the left to view plans.</div>
    </div>
	
  </div>

		
			</div>
			</div>
        </div>

    	
        <!--<div class="panel panel-primary">
          <div class="panel-heading">Today Earned Amount</div>
          <div class="panel-body"><i class="fa fa-inr" aria-hidden="true"></i> <?=$database['today_amount']?></div>
        </div>-->
	 <?php }   ?>
       <?php if((isset($_REQUEST['view'])) && ($_REQUEST['view']=='order')){ ?>
      <div class="grid_12">
        	
        	<h3>Recharge Order Details</h3>
            
        	<table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Mobile Number</th>
                  <th>Amount (&#8377;)</th>
				  <th>Txn ID</th>
                  <th>Order ID</th>
				  <th>Operator</th>
                  <th>Status</th>
				  <th>Date</th>
                </tr>
              </thead>
              <tbody>
              	<? if(empty($recharge)) { ?>
                <tr><td colspan="7" class="text-danger" align="center">No Records details to show ...</td>
                <? } else { 
					$i=1;
					foreach($recharge as $data) {
				?>
                <tr>
                  <th scope="row"><?=$i?></th>
                  <td><?=$data['mobile']?></td>
                  <td><?=$data['amount']?></td>
				   <td><?=$data['apiorder_id']?></td>
				   <td><?=$data['myorder_id']?></td>
                  <td>
				  	<?=$data['operator_name']?>
                  </td>
				   <td>
				  	<?=$data['recharge_status']?>
                  </td>
				  
                  <td>
				  	<?=$data['date_added']?>
                  </td>
                </tr>
                <? $i++; } } ?>
              </tbody>
            </table>
        </div>
	   <?php } ?>
    </section><!-- #end content area -->
      
      
        
    </section><!-- #end content area -->
      
      
    <!-- sidebar -->    
	 <?php if((isset($_REQUEST['view'])) && ($_REQUEST['view']=='recharge')){ ?>
	<aside style="margin-bottom:-50px;">
	
	<form action="recharge_proceed.php" name="recharge_proceed" method="post">
	<input type="hidden" name="action" value="recharge_now">
	 <div class="grid_12 no-padding">
             <div class="panel panel-primary" style="text-align:left;">
              <div class="panel-heading">Recharge Details</div>
              <div class="panel-body" style="height:410px;">
			<div class="grid_12" style="margin-bottom:20px;">
			<div style="margin-bottom:5px;">Mobile Number</div>
			<div>
			<input type="text" id="mobile" name="mobile" class="rc-input numberOnly" onkeypress="findoperatorvalue(this.value)" onkeyup="findcirclevalue(this.value)" placeholder="Enter Numeric values" Autocomplete="OFF" required value="<?php if(isset($_SESSION['recharge_mobile'])){ echo $_SESSION['recharge_mobile']; }?>" />
			  
			</div>
			
			</div>
			
			<div class="grid_12" style="margin-bottom:20px;" >
			<div style="margin-bottom:5px;">Operator</div>
			<div>
			
			<select name="operator" id="operator" class="rc-input" required> 
                <?php echo $code; ?>				
               </select> 
			</div>
			
			</div>
			
			<div class="grid_12" style="margin-bottom:20px;">
              <!-- Circle -->
              <div style="margin-bottom:5px;">Circle</div>
             <div >
               <select name="circle" id="circle" class="rc-input" required> 
                <?php echo $circle; ?>				
               </select> 
            </div>
			</div>
			
			<input type="hidden" value="0" name="spl_rechr" id="spl_rechr">
			
			<div class="grid_12" style="margin-bottom:20px;">
			<div style="margin-bottom:5px;">Amount</div>
			<div>
			<input type="text" name="amount" id="amount" class="rc-input numberonly" onblur="return checkamount('<?=$_SESSION['roo']['user']['account_balance']?>');" placeholder="Enter Numeric values" required value="<?php if(isset($_SESSION['recharge_amount'])){ echo $_SESSION['recharge_amount']; }?>">
			
			</div>
			<span id="alertamt"></span>
			
			</div>
			
			<div class="grid_12">
			<div style="margin-top:25px;">
			<input type="submit" name="submit" value="Recharge Now" class="btn btn-primary" onclick="return checkamount('<?=$_SESSION['roo']['user']['account_balance']?>');">
			
			<a href="javascript:void(0);" onclick="openWin()" style="text-decoration:underline;font-size:14px;"> Terms & Conditions</a>
			</div>
			</div>
			
			</div>
			</div>
        </div>
	</form>
    	
       
	</aside>
	 <?php } ?>
	<?php if((isset($_REQUEST['view'])) && ($_REQUEST['view']=='order')){ ?>
    <? include("./includes/loginmenu.php"); ?>
	
	<?php }?>
    <!-- #end sidebar -->
   
  </div><!-- #end div #main .wrapper -->

<!-- footer area -->    
<? include("./includes/footer.php"); ?>
<!-- #end footer area --> 
<?php if((isset($_REQUEST['view'])) && ($_REQUEST['view']=='recharge')){ 
if($_SESSION['roo']['user']['spl_recharge']=='0'){
?>
<div class="modal hide fade" id="specialpopup" style="height: 200px;width:650px; overflow: hidden; display: block;left:47%;">
		<div class="modal-header">
			<h3>Special Recharge Offer</h3>
		</div>
		<div class="modal-body" id="Specialrge" style="overflow: hidden;margin:10px;padding:15px;">
			
			<div>
			You have a special offer for a first login, recharge worth is Rs.10.
			</div>
			
			<div style="margin-top:30px;">
			<input type="button" name="proceed_special" id="proceed_special" value="Proceed" class="btn btn-primary btn-small" onclick="specialfn();">
			&nbsp;<a href="#" class="btn btn-warning btn-small" data-dismiss="modal">Later</a>
			</div>
			
		</div>
		
	</div>
<?php } 
if($_SESSION['roo']['user']['spl_recharge']=='1'){
 if((isset($_REQUEST['type'])) && ($_REQUEST['type']=='spl'))
			{ ?>
<div class="modal hide fade" id="specialpopup" style="height: 200px;width:650px; overflow: hidden; display: block;left:47%;">
		<div class="modal-header">
			<h3>Special Recharge Offer</h3>
		</div>
		<div class="modal-body" id="Specialrge" style="overflow: hidden;margin:10px;padding:15px;">
			
			
		     <div style="color:red;">
			Special offer for a first login, recharge worth is Rs.10 is already done.
			</div>
		    <div style="margin-top:30px;">
			<a href="#" class="btn btn-warning btn-small" data-dismiss="modal">Close</a>
			</div>
		</div>
		
	</div>
<?php } }


}?>
<? include("./includes/footerinclude.php"); ?>
<script>
$( document ).ready(function() {
	 // alert(autovdval);
	 $('#specialpopup').modal('show');
});	 

function specialfn()
{
	$('#rgsplid').show();
	$('#plandlid').hide();
	$('#amount').val('10');
	$('#spl_rechr').val('1');
	$('#amount').attr('readonly','readonly');
	$('#specialpopup').modal('hide');
}

</script>
<script>
var myWindow;

function openWin() {
    myWindow = window.open("https://www.roophka.com/terms.php", "myWindow", "width=500,height=300");
    //myWindow.document.write("<p>This is 'myWindow'</p>");
}

function closeWin() {
    myWindow.close();
}
</script>
<style>
.modal-backdrop {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 1040;
  background-color: #000000;
}

.modal-backdrop.fade {
  opacity: 0;
}

.modal-backdrop,
.modal-backdrop.fade.in {
  opacity: 0.8;
  filter: alpha(opacity=80);
}

.modal {
  position: fixed;
  top: 10%;
  left: 50%;
  z-index: 1050;
  width: 560px;
  margin-left: -280px;
  background-color: #ffffff;
  border: 1px solid #999;
  border: 1px solid rgba(0, 0, 0, 0.3);
  *border: 1px solid #999;
  -webkit-border-radius: 6px;
     -moz-border-radius: 6px;
          border-radius: 6px;
  outline: none;
  -webkit-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
     -moz-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
          box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
  -webkit-background-clip: padding-box;
     -moz-background-clip: padding-box;
          background-clip: padding-box;
}

.modal.fade {
  top: -25%;
  -webkit-transition: opacity 0.3s linear, top 0.3s ease-out;
     -moz-transition: opacity 0.3s linear, top 0.3s ease-out;
       -o-transition: opacity 0.3s linear, top 0.3s ease-out;
          transition: opacity 0.3s linear, top 0.3s ease-out;
}

.modal.fade.in {
  top: 20%;
}

.modal-header {
  padding: 9px 15px;
  border-bottom: 1px solid #eee;
}

.modal-header .close {
  margin-top: 2px;
}

.modal-header h3 {
  margin: 0;
  line-height: 30px;
}

.modal-body {
  position: relative;
  max-height: 400px;
  padding: 5px;
  overflow-y: auto;
}

.modal-form {
  margin-bottom: 0;
}

.modal-footer {
  padding: 14px 15px 15px;
  margin-bottom: 0;
  text-align: right;
  background-color: #f5f5f5;
  border-top: 1px solid #ddd;
  -webkit-border-radius: 0 0 6px 6px;
     -moz-border-radius: 0 0 6px 6px;
          border-radius: 0 0 6px 6px;
  *zoom: 1;
  -webkit-box-shadow: inset 0 1px 0 #ffffff;
     -moz-box-shadow: inset 0 1px 0 #ffffff;
          box-shadow: inset 0 1px 0 #ffffff;
}

.modal-footer:before,
.modal-footer:after {
  display: table;
  line-height: 0;
  content: "";
}

.modal-footer:after {
  clear: both;
}

.modal-footer .btn + .btn {
  margin-bottom: 0;
  margin-left: 5px;
}

.modal-footer .btn-group .btn + .btn {
  margin-left: -1px;
}

.modal-footer .btn-block + .btn-block {
  margin-left: 0;
}
</style>
</body>
</html>