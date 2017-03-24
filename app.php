<?php
include_once("./config/config.php");
include("./functions/register.php");
include("./functions/location.php");
include("./functions/cms.php");


$output = array('response_code' => -1, 'error' => 'Invalid Request', 'session_id'=>'','msg' => 'No action performed for your request, Please send valid information.');

$cms=new cms();

if((isset($_REQUEST['action']))&&($_REQUEST['appkey']=='Roo2017App')) {
	
	if($_REQUEST['action'] == 'cms')
	{
      $page=$_REQUEST['page'];
	  $pagecontent=html_entity_decode($cms->getcms(1,$page));
	  $data = array();
	  $data['pagecontent']=$pagecontent;
	  sendJson(1,$data);	
	}
	
	if($_REQUEST['action'] == 'recharge')
	{
	if(!isset($_REQUEST['session_id']) || $_REQUEST['session_id'] =='' || $_REQUEST['session_id'] <=0) {
	sendJson(-5,array('request'=>$_REQUEST),'Not valid information');
	}	
	$circle=$_REQUEST['circle'];
	$splrc=$_REQUEST['spl_rechr'];
	$mobile=$_REQUEST['mobile'];  
	$operator=$_REQUEST['operator'];  
	if($splrc=='1')	{
		$amount=10; 
	} else {
		$amount=$_REQUEST['amount']; 	
	}

	$sessuser_id = $_REQUEST['session_id'];
	//generating random unique orderid for your reference 
	$uniqueorderid = substr(number_format(time() * rand(),0,'',''),0,10);  

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
		$mailler->sendmail($to, $from, $subject, $message);
		$data['status']="Success";
	    sendJson(1,$data);
	}  
	if($txnstatus=='PENDING'){ 
		//YOUR REST QUERY HERE 
		$qry="INSERT INTO roo_recharge(user_id,amount,mobile,apiorder_id,recharge_status,operator,myorder_id,date_added,status) values('$sessuser_id','$amount','$mobile','$joloapiorderid','$txnstatus','$operator','$uniqueorderid','".DATETIME24H."','0')";
		$ins=$db->query($qry);
		$data['status']="Pending";
	    sendJson(1,$data);
	} 
	if($txnstatus=='FAILED'){ 
		$qry="INSERT INTO roo_recharge(user_id,amount,mobile,apiorder_id,recharge_status,operator,myorder_id,date_added,status) values('$sessuser_id','$amount','$mobile','$joloapiorderid','$txnstatus','$operator','$uniqueorderid','".DATETIME24H."','0')";
		$ins=$db->query($qry);
		$data['status']="Failed";
	    sendJson(1,$data);
	} 			
	
	}

	if($_REQUEST['action'] == 'getadlist')	{
		
		if(!isset($_REQUEST['session_id']) || $_REQUEST['session_id'] =='' || $_REQUEST['session_id'] <=0) {
			sendJson(-5,array('request'=>$_REQUEST),'Not valid information');
		}
		include("./functions/ads.php");
		include("./functions/user.php");

		$usr = new user();
		$ads = new ads;

		$user = $usr->fulldetails($_REQUEST['session_id']);
		$data = array();

		if($user['demo'] == 1) {
			$data['text'] = $ads->getdemoAdlist("text");
			$data['scroll'] = $ads->getdemoAdlist("scroll");
			$data['video'] = $ads->getdemoAdlist("video");
			$data['image'] = $ads->getdemoAdlist("image");	
		} else {
			$data['text'] = $ads->getAdlist("text");
			$data['scroll'] = $ads->getAdlist("scroll");
			$data['video'] = $ads->getAdlist("video");
			$data['image'] = $ads->getAdlist("image");
		}
		sendJson(1,$data);
	}


	if($_REQUEST['action'] == 'getad')	{
		include("./functions/ads.php");
		include("./functions/user.php");

		$ads = new ads;
		$usr = new user();
		$_SESSION['roo'] = array();

		if(!isset($_REQUEST['session_id']) || $_REQUEST['session_id'] =='' || $_REQUEST['session_id'] <=0) {
			sendJson(-5,array('request'=>$_REQUEST),'Not valid information');
		}

		$user = $usr->fulldetails($_REQUEST['session_id']);
		$_SESSION['roo']['user'] = $user;
		
		if(isset($_REQUEST['type']))
		{
		 	$typ=$_REQUEST['type'];
		}
		else
		{
			$typ='all'; 
		}

		if(isset($user['demo']) && $user['demo'] == 1) {
			if(isset($_REQUEST['adid'])) {
			    $currentAd = $ads->getDemoAd($_REQUEST['adid'],$typ,false,true);
			} else {
			    $currentAd = $ads->getDemoAd(0,$typ,false,true);
			}
		} else {
			if(isset($_REQUEST['adid'])) {
				 $currentAd = $ads->getAd($_REQUEST['adid'],$typ,true);
			} else {
			    $currentAd = $ads->getAd(0,$typ,true);
			}	
		}
		$currentAd['user_balance'] = $user['account_balance'];
		$data = $currentAd;
		sendJson(1,$data);
		//exit;
	}

	if($_REQUEST['action'] == 'submitad')	{
		include("./functions/user.php");
		$usr = new user();
		
		if(!isset($_REQUEST['session_id']) || $_REQUEST['session_id'] =='' || $_REQUEST['session_id'] <=0) {
			sendJson(-5,array('request'=>$_REQUEST),'Not valid information');
		}

		$user = $usr->fulldetails($_REQUEST['session_id']);

		$ip_addr=$_REQUEST['ip'];
		/*$lat=$_REQUEST['lat'];
		$lng=$_REQUEST['lng'];
		
		$conlatlng=$lat.",".$lng;
		// Get the string from the URL
		$url="https://maps.googleapis.com/maps/api/geocode/json?latlng=$conlatlng";
		//echo $url;
        $json = file_get_contents($url);
		// Decode the JSON string into an object
		$obj = json_decode($json);
		// In the case of this input, do key and array lookups to get the values
		$vistorlocation=$obj->results[0]->formatted_address; 

		$visitexp=explode(',',$vistorlocation);
		$vcount=count($visitexp);
		$vcity=$visitexp[$vcount-3];
		$varea=$visitexp[$vcount-4];*/

		$vistorlocation='';
		$vcity='';
		$varea='';
		
		if(!isset($_REQUEST['adid']) OR $_REQUEST['adid'] < 1) {
			$output['msg'] = 'Something went wrong. Please referesh the page or try again later.';
		} else {
			$adid = $_REQUEST['adid'];
			$qry = $db->query("SELECT * FROM roo_ads WHERE id = '".$adid."'");
			if($db->num_rows($qry) > 0) {
				
				$adRow = $db->fetch_array($qry);
				
				$balance = $user['account_balance'];
				$user_id = $user['id'];
				
				//echo "INSERT INTO roo_transaction (userid, adid, type, detail, amount, date_added, demo,ipaddr,visitor_city,visitor_area,visitor_location) VALUES ('".$user_id."', '".$adid."', 'add', 'Credit for watching ad', '".$adRow['amount']."', '".DATETIME24H."', 1,'".$ip_addr."','".$vcity."','".$varea."','".$vistorlocation."')"; exit;
				
				if($user['demo'] == 1) {
					$db->query("INSERT INTO roo_transaction (userid, adid, type, detail, amount, date_added, demo,ipaddr,visitor_city,visitor_area,visitor_location) VALUES ('".$user_id."', '".$adid."', 'add', 'Credit for watching ad', '".$adRow['amount']."', '".DATETIME24H."', 1,'".$ip_addr."','".$vcity."','".$varea."','".$vistorlocation."')");
				} else {
					$db->query("INSERT INTO roo_transaction (userid, adid, type, detail, amount, date_added,demo,ipaddr,visitor_city,visitor_area,visitor_location) VALUES ('".$user_id."', '".$adid."', 'add', 'Credit for watching ad', '".$adRow['amount']."', '".DATETIME24H."','0','".$ip_addr."','".$vcity."','".$varea."','".$vistorlocation."')");
				}
				
				$db->query("UPDATE roo_ads SET clicks_remain = (clicks_remain - 1), viewing = 0 WHERE id = '".$adid."' LIMIT 1");
				$db->query("UPDATE roo_users SET account_balance = (account_balance + ".$adRow['amount'].") WHERE id = '".$user_id."' LIMIT 1");
				
				$user['account_balance'] = number_format(($balance + $adRow['amount']), 2);

				$output['response_code']=2;
				$output['error'] = false;
				$output['msg'] = '';
				$output['account_balance'] = $user['account_balance'];
			} else {
				$output['response_code']=-2;
				$output['msg'] = 'Something went wrong. Please referesh the page or try again later.';
			}
		}
		echo "[".json_encode($output)."]";exit;
	}

	/****
	 * get dashboard details
	 */
	if($_REQUEST['action'] == 'dashboard')	{

		if(!isset($_REQUEST['session_id']) || $_REQUEST['session_id'] =='' || $_REQUEST['session_id'] <=0) {
			sendJson(-5,array('request'=>$_REQUEST),'Not valid information');
		}

		include("./functions/user.php");
		include("./functions/ads.php");
		$user = new user;
		$ads = new ads;

		$ads->resetAd();
		$database = $user->dashboard($_REQUEST['session_id']);
		$database['account_balance'] = $user->getAccountBalance($_REQUEST['session_id']);
		sendJson(1,$database);
	}

	/****
	 * get list of transaction details
	 */
	if($_REQUEST['action'] == 'transaction')	{

		if(!isset($_REQUEST['session_id']) || $_REQUEST['session_id'] =='' || $_REQUEST['session_id'] <=0) {
			sendJson(-5,array('request'=>$_REQUEST),'Not valid information');
		}

		include("./functions/user.php");
		include("./functions/ads.php");
		$user = new user;
		//$ads = new ads;

		//$ads->resetAd();
		$database = $user->transactions($_REQUEST['session_id']);
		$database['account_balance'] = $user->getAccountBalance($_REQUEST['session_id']);
		sendJson(1,$database);
	}

	/****
	 * my profile details
	 */
	if($_REQUEST['action'] == 'profile') {

		if(!isset($_REQUEST['session_id']) || $_REQUEST['session_id'] =='' || $_REQUEST['session_id'] <=0) {
			sendJson(-5,array('request'=>$_REQUEST),'Not valid information');
		}

		include("./functions/user.php");
		$user = new user;
		
		$userdetails = $user->fulldetails($_REQUEST['session_id']);
		unset($userdetails['id'], $userdetails['pass'], $userdetails['salt'], $userdetails['lastname'], $userdetails['lastlogin'], $userdetails['signupdate'], $userdetails['demo'], $userdetails['spl_recharge'], $userdetails['status']);

		sendJson(1,$userdetails);
	}

	/****
	 * update profile details
	 */
	if($_REQUEST['action'] == 'upate_profile') {
		
		if(!isset($_REQUEST['session_id']) || $_REQUEST['session_id'] =='' || $_REQUEST['session_id'] <=0 || !isset($_REQUEST['name']) || !isset($_REQUEST['mobile']) || !isset($_REQUEST['dob']) || !isset($_REQUEST['address']) || !isset($_REQUEST['state']) || !isset($_REQUEST['city']) || !isset($_REQUEST['pincode'])) {
			sendJson(-5,array('request'=>$_REQUEST),'Not valid information');
		}
		
		include("./functions/register.php");
		include("./functions/user.php");

		$register = new register;
		$user = new user;
		
		$register->userid = $_REQUEST['session_id'];
		$register->name = $db->escape_string($_REQUEST['name']);
		$register->mobile = $db->escape_string($_REQUEST['mobile']);
		$register->dob = $db->escape_string($_REQUEST['dob']);
		$register->address = $db->escape_string($_REQUEST['address']);
		$register->state = $db->escape_string($_REQUEST['state']);
		$register->city = $db->escape_string($_REQUEST['city']);
		$register->pincode = $db->escape_string($_REQUEST['pincode']);
		
		$result = $register->update();
		if($result['error']) {
			if($result['msg'] == 'empty')
				sendJson(-5,array('request'=>$_REQUEST),'All fields should be filled...');
			elseif($result['msg'] == 'insert')
				sendJson(-5,array('request'=>$_REQUEST),'Data update issue, Please try again or after some time later.');
			else
				sendJson(-5,array('request'=>$_REQUEST),'Some thing went wrong, Please try again later.');
		} else {
			$userdetails = $user->fulldetails($_REQUEST['session_id']);
			unset($userdetails['id'], $userdetails['pass'], $userdetails['salt'], $userdetails['lastname'], $userdetails['lastlogin'], $userdetails['signupdate'], $userdetails['demo'], $userdetails['spl_recharge'], $userdetails['status']);

			sendJson(1,$userdetails);
		}
	}

	/****
	 * Add bank in list
	 */
	if($_REQUEST['action'] == 'viewbank') {
		
		if(!isset($_REQUEST['session_id']) || $_REQUEST['session_id'] =='' || $_REQUEST['session_id'] <=0) {
			sendJson(-5,array('request'=>$_REQUEST),'Not valid information');
		}
		include("./functions/user.php");
		$user = new user;
		$bankdetails = $user->accounts($_REQUEST['session_id']);
		sendJson(1,$bankdetails);
	}

	/****
	 * withdraw request in list
	 */
	 if($_REQUEST['action'] == 'addwithdraw') {
		 
	 if(!isset($_REQUEST['session_id']) || $_REQUEST['session_id'] =='' || $_REQUEST['session_id'] <=0 || !isset($_REQUEST['amount'])) {
			sendJson(-5,array('request'=>$_REQUEST),'Not valid information');
		}	 
	 include("./functions/user.php");
     $user = new user; 
	 $data = array();
	 $amount = $_REQUEST['amount'];
	 $data['amount']=$amount;
			$result = $user->addWithdraw($amount,$_REQUEST['session_id']);
			
			print_r($result); 
			
			if($result['error']) {
	        if($result['msg'] == 'amount')
				sendJson(-5,array('request'=>$_REQUEST),'Not eligible for withdraw..');
			elseif($result['msg'] == 'insert')
				sendJson(-5,array('request'=>$_REQUEST),'Data update issue, Please try again or after some time later.');
			} else {
				$data['status']="Success";
				sendJson(1,$data);
			}		
		 
	 }
	 /****
	 * Add bank in list
	 */
	 
	if($_REQUEST['action'] == 'addbank') {
		
		if(!isset($_REQUEST['session_id']) || $_REQUEST['session_id'] =='' || $_REQUEST['session_id'] <=0 || !isset($_REQUEST['name']) || !isset($_REQUEST['bankname']) || !isset($_REQUEST['accname']) || !isset($_REQUEST['accnumber']) || !isset($_REQUEST['branch']) || !isset($_REQUEST['ifsc'])) {
			sendJson(-5,array('request'=>$_REQUEST),'Not valid information');
		}
		include("./functions/user.php");
		$user = new user;

		$data = array();
		$data['user_id'] = $_REQUEST['session_id'];
		$data['name'] = $db->escape_string($_REQUEST['name']);
		$data['bank'] = $db->escape_string($_REQUEST['bankname']);
		$data['ac_name'] = $db->escape_string($_REQUEST['accname']);
		$data['number'] = $db->escape_string($_REQUEST['accnumber']);
		$data['branch'] = $db->escape_string($_REQUEST['branch']);
		$data['ifsc'] = $db->escape_string($_REQUEST['ifsc']);
		$result = $user->addBank($data);
		if($result['error']) {
			if($result['msg'] == 'empty')
				sendJson(-5,array('request'=>$_REQUEST),'All fields should be filled...');
			elseif($result['msg'] == 'insert')
				sendJson(-5,array('request'=>$_REQUEST),'Data update issue, Please try again or after some time later.');
			else
				sendJson(-5,array('request'=>$_REQUEST),'Some thing went wrong, Please try again later.');
		} else {
			$bankdetails = $user->accounts($_REQUEST['session_id']);
			sendJson(1,$bankdetails);
		}
	}

	/****
	 * User login
	 */
	if($_REQUEST['action'] == 'login')	{
			
		$output = array('error' => '', 'session_id'=>'','msg' => '');
			
		$user = $db->escape_string($_REQUEST['username']);
		$pass = $db->escape_string($_REQUEST['password']);
		
		if($user == '' || $pass == '') {
			//redirect(HTTP_PATH . 'login.php?error=1');
			$output['error']="empty";
		}
		$pass = enc_password($pass);
		
		$userQry = $db->query("SELECT id,email,firstname,account_balance,lastlogin,status,phone,demo,spl_recharge FROM `roo_users` WHERE email='".$user."' AND pass='".$pass."'");
		$num = $db->num_rows($userQry);
		if($num == 1) {
			$userRow = $db->fetch_array($userQry);
			
			if($userRow['status'] > 0) {
				$output['error']="inactive";
			}else{
			
				$db->query("UPDATE `roo_users` SET lastlogin='".DATETIME24H."' WHERE id='".$userRow['id']."'");
				
				$output['session_id'] = $userRow['id'];
				
			   	$output['msg']="success";
			}
			
		} else {
			$output['error']="not exist";
		}
		echo "[".json_encode($output)."]"; exit;
	}
	
	/****
	 *
	 */
	if($_REQUEST['action'] == 'advertiseus')
	{
    	$output=array("error" => false,"msg"=>"");	 
	
		$cms->companyname = $db->escape_string($_REQUEST['companyname']);
		$cms->email = $db->escape_string($_REQUEST['email']);
		$cms->contact_person = $db->escape_string($_REQUEST['contact_person']);
		$cms->mobile = $db->escape_string($_REQUEST['mobile']);
		$cms->state = $db->escape_string($_REQUEST['state']);
		$cms->city = $db->escape_string($_REQUEST['city']);
		$cms->address1 = $db->escape_string($_REQUEST['address1']);
		$cms->address2 = $db->escape_string($_REQUEST['address2']);
		$cms->pincode = $db->escape_string($_REQUEST['pincode']);
		$cms->email_status=0;
		$cms->ipaddr=$_SERVER['REMOTE_ADDR'];
		$adminmail=$cms->getsetting('1','email');
		//echo $adminmail; exit;
		
		$result = $cms->advertisesave();

  
		if($result)
		{
			$output['error']=false;
			$output['msg']="Your Request has been send to our administrator,they will contact you soon";
			
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
			
		}
		else
		{
			$output['error']=true;
			$output['msg']="Error, please try again !!!";
		}
		echo "[".json_encode($output)."]";exit;
	}
	
	
	if($_REQUEST['action'] == 'advertiseus')
	{
     
     $output=array("error" => false,"msg"=>"");	 
	
	$cms->companyname = $db->escape_string($_REQUEST['companyname']);
	$cms->email = $db->escape_string($_REQUEST['email']);
	$cms->contact_person = $db->escape_string($_REQUEST['contact_person']);
	$cms->mobile = $db->escape_string($_REQUEST['mobile']);
	$cms->state = $db->escape_string($_REQUEST['state']);
	$cms->city = $db->escape_string($_REQUEST['city']);
	$cms->address1 = $db->escape_string($_REQUEST['address1']);
	$cms->address2 = $db->escape_string($_REQUEST['address2']);
	$cms->pincode = $db->escape_string($_REQUEST['pincode']);
	$cms->email_status=0;
	$cms->ipaddr=$_SERVER['REMOTE_ADDR'];
	$adminmail=$cms->getsetting('1','email');
	//echo $adminmail; exit;
	
	$result = $cms->advertisesave();

  
	if($result)
	{
		$output['error']=false;
		$output['msg']="Your Request has been send to our administrator,they will contact you soon";
		
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
		
//redirect(HTTP_PATH . "advertise.php?success=1");
	}
	else
	{
		$output['error']=true;
		$output['msg']="Error, please try again !!!";
	}
	
	
	echo "[".json_encode($output)."]";exit;
	}
	
	
	if($_REQUEST['action'] == 'register')
	{
		include("./functions/register.php");
		$reg = new register();
		
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
	  
		if($result['error']) {
			if($result['msg'] == 'empty')
				$result['error']="All input fields are mandatory";
			elseif($result['msg'] == 'insert')
				$result['msg']="Not inserted";
			elseif($result['msg'] == 'duplicate')
				$result['msg']="Email already exists";
			else
				$result['error']="Not inserted";
		}else {
			$result['error']=false;
				$result['msg']="Inserted Successfully";
			$to = array($reg->email);
			$from = 'info@roophka.com';
			$subject = "Roophka : Registration complete.";
	    $encarray = array('userid'=>$result['userid'], 'action'=>'verify', 'type'=>'email');
	    $enc = three_layer_encrypt('',$encarray);
	    $message = '<div style="width:600px;">
	    Dear '.$reg->name.'<br>
	    <p>Welcome to ROOPHKA.COM</p>
	    <p>Please verify your mail address by clicking below link.</p>
	    <a href="'.HTTP_PATH.'userlogin.php?enc='.$enc.'">Click here to verify</a><br /><br />
	    Thanks & regards,<br />
	    <a href="'.HTTP_PATH.'">roophka.com</a>
	    </div>';
			
			$mailler->sendmail($to, $from, $subject, $message);
			//$result['verify'] = 'Please check and verify your email';
		}
		echo "[".json_encode($result)."]";exit;
     }
	
	if($_REQUEST['action']=='state')
	{
		$output=array("error" => false,"state"=>"");
		
		
		$cid=$_REQUEST['cid'];
		if($cid > 0) {
			$stateQry = $db->query("SELECT id, name FROM roo_state WHERE cid = '".$cid."' AND status=0 order by name asc");
			if($db->num_rows($stateQry) > 0) {
				while($stateRow = $db->fetch_array($stateQry)) {
				// $output['statename']=$stateRow['name'];
				//	$output['sid']=$stateRow['id'];
				 $state[]=array("name"=>$stateRow['name'],"sid"=>$stateRow['id']); 
				//json_encode($state);
				}
				$output['state']=$state;
				
			}
			else
			{
				$output['error']=true;
				$output['state']="No States found";
			}
			
		}
		echo "[".json_encode($output)."]";exit;
	}
	if($_REQUEST['action']=='city')
	{
		$output=array("error" => false,"city"=>"");
		
		$sid=$_REQUEST['sid'];
		if($sid > 0) {
			$cityQry = $db->query("SELECT id, name FROM roo_city WHERE sid = '".$sid."' AND status=0 order by name asc");
			if($db->num_rows($cityQry) > 0) {
				while($cityRow = $db->fetch_array($cityQry)) {
				 $city[]=array("name"=>$cityRow['name'],"cityid"=>$cityRow['id']); 
				//json_encode($state);
				}
				$output['city']=$city;
				
			}
			else
			{
				$output['error']=true;
				$output['city']="No Cities found";
			}
			
		}
		echo "[".json_encode($output)."]";exit;
	}
	
	
}

sendJson(-1);
?>