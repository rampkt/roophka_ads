<?php
include_once("./config/config.php");
unset($_SESSION['roo']['user']);
unset($_SESSION['recharge_mobile']);
unset($_SESSION['recharge_operator']);
unset($_SESSION['recharge_circle']);
unset($_SESSION['recharge_amount']);
unset($_SESSION['spl_recharge_today']);
//session_destroy();
redirect(HTTP_PATH . 'login.php?logout=1');
?>