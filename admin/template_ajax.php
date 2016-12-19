<?php
include_once("../config/config.php");
$output = array('error' => true, 'msg' => 'Something went wrong, please try again...', 'html' => '');
$login = check_admin_login();
if($login === true) {
	if(isset($_REQUEST['cmd'])) {
		if($_REQUEST['cmd'] == '_gettemplate' AND $_REQUEST['temp'] > 0) {
			include("./functions/bulkemail.php");
			$bulkemail = new bulkemail();
			$preview = $bulkemail->templateedit($_REQUEST['temp']);
			$html = $preview['template_content'];
			$output['error'] = false;
			$output['html'] = $html;
			$output['msg'] = "Success";
		}
	}
}
echo json_encode($output);
?>