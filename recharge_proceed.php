<?php
error_reporting(0);
include_once("./config/config.php");
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
			
if((isset($_REQUEST['action'])) && ($_REQUEST['action']=='recharge_now'))
			{
				$_SESSION['recharge_mobile']=$_REQUEST['mobile'];
				$_SESSION['recharge_operator']=$_REQUEST['operator'];
				$_SESSION['recharge_circle']=$_REQUEST['circle'];
				$_SESSION['recharge_amount']=$_REQUEST['amount'];
				//redirect(HTTP_PATH . 'recharge_proceed.php');
				
				$mobile=$_REQUEST['mobile'];  
$operator=$_REQUEST['operator'];  
$amount=$_REQUEST['amount']; 
 $sessuser_id = $_SESSION['roo']['user']['id'];
//generating random unique orderid for your reference 
$uniqueorderid = substr(number_format(time() * rand(),0,'',''),0,10);  
 
//inserting above 4 values in database first 
//run your php query here to store values of user inputs in database 
 
//now run joloapi.com api link for recharge 
$ch = curl_init(); 
$timeout = 100; // set to zero for no timeout 

$apikey="104746188241741";
$apiuserid="roophka";

$myHITurl = "http://joloapi.com/api/recharge.php?mode=0&userid=$apiuserid&key=$apikey&operator=$operator&service=$mobile&amount=$amount&orderid=$uniqueorderid"; 

//echo $myHITurl;
curl_setopt ($ch, CURLOPT_URL, $myHITurl); 
curl_setopt ($ch, CURLOPT_HEADER, 0); 
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout); 
$file_contents = curl_exec($ch); 
$curl_error = curl_errno($ch); 

//print_r(curl_getinfo($ch));

curl_close($ch); 

//dump output of api if you want during test 
//echo"$file_contents"; exit;
 $joloapiorderid='';
// lets extract data from output for display to user and for updating databse 
$maindata = explode(",", $file_contents); 
$countdatas = count($maindata); 
if($countdatas > 2) 
{ 
//recharge is success 
$joloapiorderid = $maindata[0]; //it is joloapi.com generated order id 
$txnstatus = $maindata[1]; //it is status of recharge SUCCESS,FAILED 
$operator= $maindata[2]; //operator code 
$service= $maindata[3]; //mobile number 
$amount= $maindata[4]; //amount 
$mywebsiteorderid= $maindata[5]; //your website order id 
$errorcode= $maindata[6]; // api error code  
$operatorid= $maindata[7]; //original operator transaction id 
$myapibalance= $maindata[8];  //my joloapi.com remaining balance 
$myapiprofit= $maindata[9]; //my earning on this recharge 
$txntime= $maindata[10]; // recharge time 
}else{ 
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
$qry2="UPDATE roo_users SET account_balance='$balance' where id='$sessuser_id'";
$upd=$db->query($qry2);

$adminmail=$cms->getsetting('1','email');
$opname=$user->getoperator_name($operator);

//echo $opname; exit;

$from = $adminmail;
		$to = array($_SESSION['roo']['user']['email']);
		$subject = "ROOPHKA: Recharge order Details";
   
    $message = '<div style="width:600px;">
    Dear '.$_SESSION['roo']['user']['firstname'].'<br><br>
   
    <p> Ypur Recharge of '.$opname.' Mobile '.$mobile.' for Rs.'.$amount.' was succesful</p>
    <br>
	
	<table>
	<tr>
	<td><strong>Order ID: </strong></td>
	<td>'.$mywebsiteorderid.'</td>
	</tr>
	
	<tr>
	<td><strong>Order Reference Number: </strong></td>
	<td>'.$joloapiorderid.'</td>
	</tr>
	
	<tr>
	<td><strong>Date: </strong></td>
	<td>'.DATETIME24H.'</td>
	</tr>
	
	<tr>
	<td><strong>Status: </strong></td>
	<td>Success</td>
	</tr>
	
	</table>
	
	
	
    Thanks & regards,<br />
    <a href="'.HTTP_PATH.'">roophka.com</a>
    </div>';
		
		$mailler->sendmail($to, $from, $subject, $message);

redirect(HTTP_PATH . 'recharge_proceed.php?report=success&view=order');
}  
if($txnstatus=='PENDING'){ 
//YOUR REST QUERY HERE 
$qry="INSERT INTO roo_recharge(user_id,amount,mobile,apiorder_id,recharge_status,operator,myorder_id,date_added,status) values('$sessuser_id','$amount','$mobile','$joloapiorderid','$txnstatus','$operator','$uniqueorderid','".DATETIME24H."','0')";

$ins=$db->query($qry);
redirect(HTTP_PATH . 'recharge_proceed.php?report=pending&view=order');
} 
if($txnstatus=='FAILED'){ 
//YOUR REST QUERY HERE 
$qry="INSERT INTO roo_recharge(user_id,amount,mobile,apiorder_id,recharge_status,operator,myorder_id,date_added,status) values('$sessuser_id','$amount','$mobile','$joloapiorderid','$txnstatus','$operator','$uniqueorderid','".DATETIME24H."','0')";

//echo $qry; exit;

$ins=$db->query($qry);
redirect(HTTP_PATH . 'recharge_proceed.php?report=failed&view=order');
} 



redirect(HTTP_PATH . 'recharge_proceed.php?');
				
}			
			
			
$login = check_login();
if($login === false) {
	redirect(HTTP_PATH . 'login.php');
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
  <link type="text/css" rel="stylesheet" href="./assets/css/tabs.css" />
<!-- main content area -->   
<div id="main" class="wrapper dashboard"> 
	
    <!-- content area -->    
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
	 <div class="grid_12 no-padding">
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
			
			
			<div class="grid_12" style="margin-bottom:20px;">
			<div style="margin-bottom:5px;">Amount</div>
			<div>
			<input type="text" name="amount" id="amount" class="rc-input numberonly" placeholder="Enter Numeric values" required value="<?php if(isset($_SESSION['recharge_amount'])){ echo $_SESSION['recharge_amount']; }?>">
			
			</div>
			<span id="alertamt"></span>
			
			</div>
			
			<div class="grid_12">
			<div style="margin-top:15px;">
			<input type="submit" name="submit" value="Recharge Now" class="btn btn-primary" onclick="checkamount('<?=$_SESSION['roo']['user']['account_balance']?>');">
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

</style>
  <script>
  function checkamount(useramt)
  {
	var enteramt=document.recharge_proceed.amount.value;
	
	var eamt=parseInt(enteramt);
	
	var fullamt=parseInt(useramt);
	
	//alert(eamt+"<br>"+fullamt);
	//return false;
	  if(eamt>fullamt)
	  {
		  $('#alertamt').html("Please enter below "+useramt+" rupees");
		  document.recharge_proceed.amount.value="";
		  //$('#amount').css('outline-color','red')
		  document.recharge_proceed.amount.focus();
		  return false;
		  
	  }  
	  
  }
  
  function pickval(amt)
  {
	  
	  document.recharge_proceed.amount.value=amt;
	  
  }
  
  </script>
  
  <script>
  $( document ).ready(function() {
   // console.log( "ready!" );
   var mobileval=document.recharge_proceed.mobile.value;
	var opval=document.recharge_proceed.operator.value;
	var circleval=document.recharge_proceed.circle.value;
	
	//alert(mobileval+''+opval+''+circleval);
	if((mobileval!="")&&(opval!="")&&(circleval!="")){
		findoperatorplans('TUP');
	}
});
  
  
function findoperatorplans(val) {
	
	var htmlval=$('#topupplans'+val).html();
	if(htmlval=='<br>Enter 10 digit mobile number in given form on the left to view plans.')
	{
	//	alert(htmlval);
	
	
	
	//alert("devi");
	var mobileval=document.recharge_proceed.mobile.value;
	var opval=document.recharge_proceed.operator.value;
	var circleval=document.recharge_proceed.circle.value;
	
	//alert(mobileval+''+opval+''+circleval);
	if((mobileval!="")&&(opval!="")&&(circleval!="")){
		
		$('#topupplans'+val).html('<img src="./assets/images/loader.gif" />');
		
	var params = { action : '_findplans',circle:circleval,operator:opval,mobile:mobileval,type:val}
	$.ajax({
		url:"operatorplans.php",
		type:'POST',
		dataType:"text",
		data:params,
		success: function(result) {
		
			//alert(result);
			if(result.error) {
				
			} else {
			$('#topupplans'+val).html(result);
			}
		}
	});
	}
}
}
 
</script>

<!-- footer area -->    
<? include("./includes/footer.php"); ?>
<!-- #end footer area --> 

<? include("./includes/footerinclude.php"); ?>

</body>
</html>