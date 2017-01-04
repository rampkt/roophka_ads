<?
error_reporting(E_ALL); 

// collecting details from html Form 
$mobile="9962980183";  
 
$apikey="104746188241741";
$userid="roophka";

$url="https://joloapi.com/api/findoperator.php?userid=$userid&key=$apikey&mob=$mobile&type=json";
echo $url;
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

echo $output['operator_code'];
print_r($output);

?> 