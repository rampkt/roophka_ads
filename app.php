<?php
include_once("./config/config.php");
include("./functions/register.php");
include("./functions/location.php");
include("./functions/cms.php");

$reg = new register();
$cms=new cms();

if((isset($_REQUEST['action']))&&($_REQUEST['appkey']=='Roo2017App'))
	{

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
?>