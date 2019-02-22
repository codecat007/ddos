<?php

require('Smarty.class.php');
$smarty = new Smarty;

require_once('inc/db.php');
require_once('inc/functions.php');
require_once('inc/secur.php');
require_once('right.php');

$page = basename($_SERVER['PHP_SELF']);
$page = substr($page, 0, -4);
$smarty->assign('page', $page);

$smarty->assign('emailError', $emailError);
$smarty->assign('passwordError', $passwordError);
$smarty->assign('pageTitle', 'Account');

$smarty ->display('templates/account.tpl')

?>