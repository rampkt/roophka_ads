<?
error_reporting(0); 
include_once("./config/config.php");

if(isset($_REQUEST['action'])) {
	
// find operator	
if($_REQUEST['action']=='_findoperator')
	{
		
// collecting details from html Form 
$mobile=$_REQUEST['mobile'];  
 
$apikey="104746188241741";
$userid="roophka";

$url="https://joloapi.com/api/findoperator.php?userid=$userid&key=$apikey&mob=$mobile&type=json";
//echo $url;
//  Initiate curl
$ch = curl_init();
// Disable SSL verification
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($ch, CURLOPT_URL,$url);
// Execute
$result=curl_exec($ch);
// Closing
curl_close($ch);

// Will dump a beauty json :3

$output=json_decode($result, true);

$opcode=$output['operator_code'];
if($opcode!=0){
  $code="";
			$qry = $db->query("SELECT * FROM roo_mobile_operator where status='0' and operator_code='$opcode' order by operator_name asc");
			$count=$db->num_rows($qry);
			$i=1;
			if($count>0)
			{
			while($row = $db->fetch_array($qry))
			{
			
			$code.="<option value='".$row['operator_shortname']."'>".($row['operator_name'])."</option>";
			 
			$i++;
			}
			echo $code;
			}		
	}
	else
	{
		$code="<option value=''>Select Operator</option>";
			$qry = $db->query("SELECT * FROM roo_mobile_operator where status='0' order by operator_name asc");
			$count=$db->num_rows($qry);
			$i=1;
			if($count>0)
			{
			while($row = $db->fetch_array($qry))
			{
			
			$code.="<option value='".$row['operator_shortname']."'>".$row['operator_name']."</option>";
			 
			$i++;
			}
			echo $code;
			}
	}
	
}


// find circle

if($_REQUEST['action']=='_findcircle')
	{
		
// collecting details from html Form 
$mobile=$_REQUEST['mobile'];  
 
$apikey="104746188241741";
$userid="roophka";

$url="https://joloapi.com/api/findoperator.php?userid=$userid&key=$apikey&mob=$mobile&type=json";
//echo $url;
//  Initiate curl
$ch = curl_init();
// Disable SSL verification
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($ch, CURLOPT_URL,$url);
// Execute
$result=curl_exec($ch);
// Closing
curl_close($ch);

// Will dump a beauty json :3

$output=json_decode($result, true);

$ccode=$output['circle_code'];
if($ccode!=0){
  $code="";
			$qry = $db->query("SELECT * FROM roo_operator_circle where status='0' and circle_code='$ccode' order by circle_name asc");
			$count=$db->num_rows($qry);
			$i=1;
			if($count>0)
			{
			while($row = $db->fetch_array($qry))
			{
			
			$code.="<option value='".$row['circle_code']."'>".($row['circle_name'])."</option>";
			 
			$i++;
			}
			echo $code;
			}		
	}
	else
	{
		$code="<option value=''>Select Circle</option>";
			$qry = $db->query("SELECT * FROM roo_operator_circle where status='0' order by circle_name asc");
			$count=$db->num_rows($qry);
			$i=1;
			if($count>0)
			{
			while($row = $db->fetch_array($qry))
			{
			
			$code.="<option value='".$row['circle_code']."'>".$row['circle_name']."</option>";
			 
			$i++;
			}
			echo $code;
			}
	}
	
}
}
//print_r($output);

?> 