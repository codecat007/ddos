<?php
include ('config.php');
$os1 = $_POST['option_selection1'];
$os2 = $_POST['option_selection2'];
$now = date("Y-m-d");
$txn_id = $_POST['txn_id'];

//Declaring all the variables
$onets = time() + (2 * 24 * 60 * 60);
$onedate = date('Y-m-d', $onets);

$weekts = time() + (8 * 24 * 60 * 60);
$weekdate = date('Y-m-d', $weekts);

$monthts = time() + (31 * 24 * 60 * 60);
$monthdate = date('Y-m-d', $monthts);

if (isset($os2))
{
mysql_query("UPDATE `users` SET `group` = 'subscriber' WHERE `username` = '$os2'");
mysql_query("UPDATE users SET paid = '1' WHERE username = '$os2'");
}

//If 1 Day Trial
if ($os1 == '1_Day_Trial')
{
mysql_query("UPDATE `users` SET `sublength` = '1d', `start_date` = '$now', `end_date` = '$onedate', `transactionid` = '$txn_id' WHERE `username` = '$os2'");

echo '1 day trial';
}

//If 1 Week Sub
elseif ($os1 == '1_Week_Subscription')
{
mysql_query("UPDATE users SET `sublength` = '1w', `start_date` = '$now', `end_date` = '$weekdate', `transactionid` = '$txn_id' WHERE `username` = '$os2'");

echo '1 week sub';
}

elseif ($os1 == '1_Month_Subscription')
{
mysql_query("UPDATE users SET sublength = '1m', start_date = '$now', end_date = '$monthdate', transactionid = '$txn_id' WHERE username = '$os2'");

echo '1 month sub';
}

//If lifetime sub
elseif ($os1 == 'Lifetime_Subscription')
{
mysql_query("UPDATE users SET sublength = 'lifetime', start_date = '$now', end_date = '', transactionid = '$txn_id' WHERE username = '$os2'");

echo 'Lifetime sub';
}

else
{
echo 'Damn';
}

$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$item_colour = $_POST['custom'];  
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];         //full amount of payment. payment_gross in US
$payment_currency = $_POST['mc_currency'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];
?>