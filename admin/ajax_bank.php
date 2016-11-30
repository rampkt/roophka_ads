<?php
include_once("../config/config.php");


	if(isset($_REQUEST['cmd'])) {
		if($_REQUEST['cmd'] == '_currentbalance') {
			
			if($_REQUEST['inputtype']=='email')
			{
			$userQry = $db->query("SELECT id,email,account_balance FROM `roo_users` WHERE (email='".$_REQUEST['email']."') limit 1");
		$row=$db->fetch_array($userQry);
			}
		    if($_REQUEST['inputtype']=='id')
			{
			$userQry = $db->query("SELECT id,email,account_balance FROM `roo_users` WHERE (id='".$_REQUEST['email']."') limit 1");
		$row=$db->fetch_array($userQry);
			}
		
		echo $row['account_balance'];
		
		}
	}
?>