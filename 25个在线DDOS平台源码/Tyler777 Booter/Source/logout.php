<?php
include 'dbc.php';
mysql_query("UPDATE users set status = 0 WHERE user_name = '" . $username . "'");
logout();
?>