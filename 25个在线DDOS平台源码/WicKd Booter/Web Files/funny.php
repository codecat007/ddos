<?php
require 'config.php';
if (isset($_GET['id']))
{
	$userID = (int)$_GET['id'];
	if (filter_var($userIP, FILTER_VALIDATE_IP))
	{
		$SQL = $odb -> prepare("INSERT INTO `iplogs` VALUES(NULL, :userid, :userIP, :time)");
		$SQL -> execute(array(':userid' => $userID, ':userIP' => $userIP, ':time' => time()));
	}
	header('location: http://google.com');
}
?>