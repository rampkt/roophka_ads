<? 
//now run joloapi.com api link for checking api balance 
$ch = curl_init(); 
$timeout = 100; // set to zero for no timeout 
$myHITurl = "http://joloapi.com/api/balance.php?userid=yourusername&key=apikey"; 
curl_setopt ($ch, CURLOPT_URL, $myHITurl); 
curl_setopt ($ch, CURLOPT_HEADER, 0); 
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout); 
$file_contents = curl_exec($ch); 
$curl_error = curl_errno($ch); 
curl_close($ch); 
//dump output of api if you want during test 
echo"$file_contents"; 
// lets extract data from output for display  
$maindata = explode(",", $file_contents); 
$countdatas = count($maindata); 
if($countdatas > 2) 
{ 
//recharge is success 
$apibal = $maindata[0]; //my current api balance 
$apiprofit = $maindata[1]; //my current total profit 
$apitime= $maindata[2]; //request time 
}else{ 
//reporting failed 
$txnstatus = $maindata[0]; //checking of balace failed FAILED 
$errorcode= $maindata[1]; // api error code  
} 
//if curl request timeouts 
if($curl_error=='28'){ 
//Request timeout 
echo "Request timeout";//reporting of transaction failed FAILED 
} 
 
?> 