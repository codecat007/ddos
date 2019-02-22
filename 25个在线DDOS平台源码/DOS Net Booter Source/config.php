<?php
#################
# Configuration #
#################
mysql_connect("localhost","root","") or die("Error ".mysql_error());
mysql_select_db("source") or die("Error ".mysql_error());
$site_title = "KoolSource v1";
return $site_title;
?>