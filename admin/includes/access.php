<?php 
include_once("../config/config.php");
if($_SESSION['roo']['admin_user']['type'] == 0) 
{ 
    $admin_access=array('Resume','Ads','Withdraw','Users','Adminuser','Reports','Bulkmail','Manual_Transaction','Recharge','Location','CMS','Settings','Contact','Advertise','plan');
 }
 if($_SESSION['roo']['admin_user']['type'] == 1) 
{ 
     $admin_access=array('Resume','Ads','Withdraw','Users','Adminuser','Reports','Bulkmail','Manual_Transaction','Recharge','Location','CMS','Settings','Contact','Advertise','plan');
 }
 if($_SESSION['roo']['admin_user']['type'] == 2) 
{ 
     $admin_access=array('Resume','Ads','Withdraw','Users','Reports','Bulkmail','Manual_Transaction','Recharge','Location','Settings','Advertise','plan');
 }
 if($_SESSION['roo']['admin_user']['type'] == 3) 
{ 
     $admin_access=array('Ads');
 }

if($_SESSION['roo']['admin_user']['type'] == 4) 
{ 
     $admin_access=array('Resume','Ads','Withdraw','Users','Adminuser','Reports','Bulkmail','Manual_Transaction','Recharge','Location','CMS','Settings','Contact','Advertise','plan');
 }

?>