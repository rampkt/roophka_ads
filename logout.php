<?php
include_once("./config/config.php");
unset($_SESSION['roo']['user']);
session_destroy();
redirect(HTTP_PATH . 'login.php?logout=1');
?>