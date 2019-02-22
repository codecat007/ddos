<?php

require('Smarty.class.php');
$smarty = new Smarty;

require_once('inc/db.php');
require_once('inc/functions.php');
require_once('inc/secur.php');
require_once('right.php');

$page = basename($_SERVER['PHP_SELF']);
$page = substr($page, 0, -4);

if(isset($_GET['error'])){
    switch($_GET['error']){
        case 'blank':
            $error = 'Please fill in all required fields';
            break;
        case 'error':
            $error = 'And error occured and your message could not be sent';
            break; 
        case 'succes':
            $error = 'Your message has sucessfully been sent';
            break;
    }
}

$smarty->assign('page', $page);
$smarty->assign('pageTitle', 'Contact');

$smarty->assign('error', $error);

$smarty->display('templates/contact.tpl');
?>