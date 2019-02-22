<?php

//Put the while before the <div class="newsContent"> and end the while after </div> :)

require('Smarty.class.php');
$smarty = new Smarty;

require_once('inc/db.php');
require_once('inc/functions.php');
require_once('inc/secur.php');
require_once('right.php');

$page = basename($_SERVER['PHP_SELF']);
$page = substr($page, 0, -4);

$smarty->assign('page', $page);
$smarty->assign('pageTitle', 'News');

$smarty->display('templates/news.tpl');
?>