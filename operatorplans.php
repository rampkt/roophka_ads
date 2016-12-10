<?
error_reporting(0); 
include_once("./config/config.php");

if(isset($_REQUEST['action'])) {
	
// find operator	
if($_REQUEST['action']=='_findplans')
	{
		
// collecting details from html Form 
$circle=$_REQUEST['circle']; 
$mobile=$_REQUEST['mobile'];  
$operator=$_REQUEST['operator'];
$apikey="104746188241741";
$userid="roophka";
$type=$_REQUEST['type'];

$qry = $db->query("SELECT * FROM roo_mobile_operator where status='0' and operator_shortname='$operator'");
			$count=$db->num_rows($qry);
			$row = $db->fetch_array($qry);
$opval=$row['operator_code'];
$url="https://joloapi.com/api/findplan.php?userid=$userid&key=$apikey&opt=$opval&cir=$circle&typ=$type";
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

//print_r($output); exit;


$html='<table class="table">
              <thead>
                <tr>
                  <th>Detail</th>
                  <th>Amount (&#8377;)</th>
				  <th>Validity (days)</th>
                  <th>Pick</th>
                </tr>
              </thead>
              <tbody>';
			  
					$i=1;
					foreach($output as $data) {
						$detail=$data['Detail'];
						$amount=$data['Amount'];
						$validity=$data['Validity'];
				
               $html.= '<tr>
                  <td style="width:400px;word-break:break-all;">'.$detail.'</td>
                  <td>'.$amount.'</td>
				   <td>'.$validity.'</td>
				   <td><input type="checkbox" name="pick" id="pick" onclick="pickval('.$amount.');"></td>
                </tr>';
                $i++; } 
              $html.= '</tbody>
            </table>';

echo $html;

}


}
//print_r($output);

?> 