<?php
define('DIRECT', TRUE);
function getRealIpAddr()
{
	if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	{
		$ip=$_SERVER['HTTP_CLIENT_IP'];
	}
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	{
		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else
	{
		$ip=$_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}
$_SERVER['REMOTE_ADDR'] = getRealIpAddr();
require 'functions.php';
$user = new user;
$stats = new stats;
$title_prefix = "RAGE BOOTER | ";
?>
