<? 
//now run joloapi.com api link for reporting status of txn 
$ch = curl_init(); 
$timeout = 100; // set to zero for no timeout 
$myHITurl = "http://joloapi.com/api/dispute.php?userid=yourusername&key=yourapikey&servicetype=1 &txn=apiorder"; 
curl_setopt ($ch, CURLOPT_URL, $myHITurl); 
curl_setopt ($ch, CURLOPT_HEADER, 0); 
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout); 
$file_contents = curl_exec($ch); 
$curl_error = curl_errno($ch); 
curl_close($ch); 
 
//dump output of api if you want during test 
echo"$file_contents"; 
 
// lets extract data from output for display to user and for updating databse 
$maindata = explode(",", $file_contents); 
$countdatas = count($maindata); 
 
if($countdatas > 2) 
{ 
//recharge is success 
$txnstatus = $maindata[0]; //it is status of transaction REPORTED 
$joloapiorderid = $maindata[1]; //joloapi.com order id 
$mywebsiteorderid= $maindata[2]; //your website order id 
$service= $maindata[3]; //mobile number 
$amount= $maindata[4]; //amount 
}else{ 
//reporting failed 
$txnstatus = $maindata[0]; //reporting of transaction failed FAILED 
$errorcode= $maindata[1]; // api error code  
} 
 
//if curl request timeouts 
 
if($curl_error=='28'){ 
//Request timeout 
echo "Request timeout";//reporting of transaction failed FAILED 
 
} 
?> 