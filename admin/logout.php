<?php
include_once("../config/config.php");
unset($_SESSION['roo']['admin_user']);
redirect(HTTP_PATH . 'admin/index.php?logout=1');
?>