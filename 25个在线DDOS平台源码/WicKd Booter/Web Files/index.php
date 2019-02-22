<?php
include 'config.php';
include 'includes/functions.php';
if (!$user -> loggedIn())
{
	header('location: login.php');
	die();
}
else
{
	header('location: boot.php');
}
?>