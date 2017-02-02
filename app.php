<?php
include_once("./config/config.php");
include("./functions/register.php");
include("./functions/location.php");

$reg = new register();




if(isset($_REQUEST['action'])) {

	if($_REQUEST['action'] == 'login')
	{
		
	$output = array('error' => '', 'session_id'=>'','msg' => '');
		
	$user = $db->escape_string($_REQUEST['username']);
	$pass = $db->escape_string($_REQUEST['password']);
	
	if($user == '' || $pass == '') {
		//redirect(HTTP_PATH . 'login.php?error=1');
		$output['error']="empty";
	}
	$pass = enc_password($pass);
	
	//echo "SELECT id,email,firstname,account_balance,lastlogin,status,phone,demo,spl_recharge FROM `roo_users` WHERE email='".$user."' AND pass='".$pass."'"; exit;
	
	$userQry = $db->query("SELECT id,email,firstname,account_balance,lastlogin,status,phone,demo,spl_recharge FROM `roo_users` WHERE email='".$user."' AND pass='".$pass."'");
	$num = $db->num_rows($userQry);
	if($num == 1) {
		$userRow = $db->fetch_array($userQry);
		
		if($userRow['status'] > 0) {
			$output['error']="inactive";
		}else{
		
		$db->query("UPDATE `roo_users` SET lastlogin='".DATETIME24H."' WHERE id='".$userRow['id']."'");
		
		$output['session_id'] = $userRow['id'];
				
		//redirect(HTTP_PATH . 'dashboard.php');
	
	   $output['msg']="success";
	}
		
	} else {
		$output['error']="not exist";
	}
	echo "[".json_encode($output)."]"; exit;
}
	
	if($_REQUEST['action'] == 'register')
	{
		
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
		$result['verify'] == 'Please check and verify your email';
	}
	echo "[".json_encode($result)."]";exit;
	}
	
}
?>