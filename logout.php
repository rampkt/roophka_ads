<?php
include_once("./config/config.php");
unset($_SESSION['roo']['user']);
redirect(HTTP_PATH . 'login.php?logout=1');
?>