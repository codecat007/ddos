<?php

require('Smarty.class.php');
$smarty = new Smarty;

require_once('inc/db.php');
require_once('inc/functions.php');
require_once('inc/secur.php');
require_once('right.php');

$page = basename($_SERVER['PHP_SELF']);
$page = substr($page, 0, -4);

$getIP = $_GET['ip'];
if (isset($_GET['ip']) && filter_var($_GET['ip'], FILTER_VALIDATE_IP))
{
	$smarty->assign('getIP', $_GET['ip']);
}
	
$smarty->assign('page', $page);
$smarty->assign('pageTitle', 'Boot');

$smarty->display('templates/boot.tpl');
?>