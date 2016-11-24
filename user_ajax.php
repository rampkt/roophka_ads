<?php
include_once("./config/config.php");

$output = array('error' => true, 'msg' => 'Illeagal operation.');

if(isset($_REQUEST['action'])) {
	$login = check_login();

	if($_REQUEST['action'] == '_getAds') {
		
		if($login === false) {
			$output['msg'] = 'You are logged out. Please login and try again.';
			echo json_encode($output);exit;
		}
		
		include("./functions/ads.php");
		$ads = new ads;
		if($_SESSION['roo']['user']['demo'] == 1) {
			$currentAd = $ads->getDemoAd(false);
		} else {
			$currentAd = $ads->getAd();
		}
		
		if($currentAd) {
			$output['error'] = true;
			$output['msg'] = '';
			$output['ad'] = $currentAd;
		} else {
			$output['msg'] = 'No records found';
			$output['ad'] = array();
		}
		echo json_encode($output);exit;
	}
	
	if($_REQUEST['action'] == '_submitAd') {
		
		$ip_addr=$_SERVER['REMOTE_ADDR'];
		$lat=$_REQUEST['lat'];
		$lng=$_REQUEST['lng'];
		
		$conlatlng=$lat.",".$lng;
		//echo $conlatlng; 
		
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
$varea=$visitexp[$vcount-4];
//echo $vistorlocation; exit;
		
		if($login === false) {
			$output['msg'] = 'You are logged out. Please login and try again.';
			echo json_encode($output);exit;
		} elseif(!isset($_REQUEST['adid']) OR $_REQUEST['adid'] < 1) {
			$output['msg'] = 'Something went wrong. Please referesh the page or try again later.';
		} else {
			$adid = $_REQUEST['adid'];
			$qry = $db->query("SELECT * FROM roo_ads WHERE id = '".$adid."'");
			if($db->num_rows($qry) > 0) {
				
				$adRow = $db->fetch_array($qry);
				
				$balance = $_SESSION['roo']['user']['account_balance'];
				$user_id = $_SESSION['roo']['user']['id'];
				
				//echo "INSERT INTO roo_transaction (userid, adid, type, detail, amount, date_added, demo,ipaddr,visitor_city,visitor_area,visitor_location) VALUES ('".$user_id."', '".$adid."', 'add', 'Credit for watching ad', '".$adRow['amount']."', '".DATETIME24H."', 1,'".$ip_addr."','".$vcity."','".$varea."','".$vistorlocation."')"; exit;
				
				if($_SESSION['roo']['user']['demo'] == 1) {
					$db->query("INSERT INTO roo_transaction (userid, adid, type, detail, amount, date_added, demo,ipaddr,visitor_city,visitor_area,visitor_location) VALUES ('".$user_id."', '".$adid."', 'add', 'Credit for watching ad', '".$adRow['amount']."', '".DATETIME24H."', 1,'".$ip_addr."','".$vcity."','".$varea."','".$vistorlocation."')");
				} else {
					$db->query("INSERT INTO roo_transaction (userid, adid, type, detail, amount, date_added,demo,ipaddr,visitor_city,visitor_area,visitor_location) VALUES ('".$user_id."', '".$adid."', 'add', 'Credit for watching ad', '".$adRow['amount']."', '".DATETIME24H."','0','".$ip_addr."','".$vcity."','".$varea."','".$vistorlocation."')");
				}
				
				$db->query("UPDATE roo_ads SET clicks_remain = (clicks_remain - 1), viewing = 0 WHERE id = '".$adid."' LIMIT 1");
				$db->query("UPDATE roo_users SET account_balance = (account_balance + ".$adRow['amount'].") WHERE id = '".$user_id."' LIMIT 1");
				
				$_SESSION['roo']['user']['account_balance'] = number_format(($balance + $adRow['amount']), 2);
				
				$output['error'] = false;
				$output['msg'] = '';
				$output['account_balance'] = $_SESSION['roo']['user']['account_balance'];
			} else {
				$output['msg'] = 'Something went wrong. Please referesh the page or try again later.';
			}
		}
		echo json_encode($output);exit;
	}
}

if(isset($_REQUEST['cmd'])) {
	if($_REQUEST['cmd'] == '_getCity') {
		include("./functions/location.php");
		$location = new location;
		$req = ((isset($_REQUEST['required']) AND $_REQUEST['required'] == 1) ? true : false );
		$attr = (isset($_REQUEST['attr']) ? $_REQUEST['attr'] : '' );
		$stateDropDown = $location->getCityDropdown($_REQUEST['state'], $_REQUEST['city'], $_REQUEST['class'], $req, $attr);
		$output['error'] = false;
		$output['msg'] = "";
		$output['html'] = $stateDropDown;
		echo json_encode($output);exit;
	}
}
echo json_encode($output);exit;
?>