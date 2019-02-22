<?php

$stats = array();
$userstats = array();

//Counts the amount of users
$SQL = "SELECT * FROM `users`";
$query = mysql_query($SQL, $dbLink) OR die(mysql_error());
$stats['usercount'] = mysql_num_rows($query);

//Grabs the user's last target
$SQL = "SELECT * FROM `boot_logs` WHERE `uid`='{$uid}' ORDER BY `id` DESC LIMIT 1";
$query = mysql_query($SQL, $dbLink) OR die(mysql_error());
$result = mysql_fetch_array($query);
$userstats['latestip'] = $result['target'];

//Grabs last time logged in
$SQL = "SELECT * FROM `log_ins` WHERE `uid`='{$uid}' ORDER BY `id` DESC LIMIT 1,1";
$query = mysql_query($SQL, $dbLink) OR die(mysql_error());
$result = mysql_fetch_array($query);
$userstats['lastonline'] = $result['time'];

//Grabs count of IP booted
$SQL = "SELECT * FROM `users` WHERE `id`='{$uid}'";
$query = mysql_query($SQL, $dbLink) OR die(mysql_error());
$result = mysql_fetch_array($query);
$userstats['sitesbooted'] = $result['boot_count'];

//Grabs total sites booted
$SQL = "SELECT SUM(`boot_count`) FROM `users` AS BOOTSUM";
$query = mysql_query($SQL, $dbLink) OR die(mysql_error());
$result = mysql_result($query, 0);
$stats['sitesbooted'] = $result;

//Grabs currently online user count. (Online = last active in last 15 minutes / 900 seconds)
$SQL = "SELECT * FROM `users` WHERE '{$timeNow}'-`last_active` <= 900";
$query = mysql_query($SQL, $dbLink) OR die(mysql_error());
$stats['usersonline'] = mysql_num_rows($query);


$smarty->assign('userstats', $userstats);
$smarty->assign('stats', $stats);

?>