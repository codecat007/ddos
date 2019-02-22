<?php
require 'includes/db.php';
if (isset($_GET['id']))
{
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
	$ip = getRealIpAddr();
	if (filter_var($ip, FILTER_VALIDATE_IP))
	{
		$id = intval($_GET['id']);
		$SQL = $odb -> prepare('INSERT INTO `iplogs` VALUES(NULL, :id, :ip, UNIX_TIMESTAMP())');
		$SQL -> execute(array('id' => $id, ':ip' => $ip));
		header('location: http://google.com');
	}
	else
	{
		header('location: http://google.com');
	}
}
else
{
	header('location: http://google.com');
}
?>