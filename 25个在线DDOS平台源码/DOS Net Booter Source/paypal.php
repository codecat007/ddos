<?php

require_once "config.php";

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}

// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = strtolower(trim($_POST['payer_email']));

if (!$fp) {
// HTTP ERROR
} else {
fputs ($fp, $header . $req);
while (!feof($fp)) {
$res = fgets ($fp, 1024);
if (strcmp ($res, "VERIFIED") == 0) {

if ($payment_status == "Completed") {
	$string = genRandomString()."-".genRandomString()."-".genRandomString()."-".genRandomString()."-".genRandomString();
	$string = strtoupper($string);
	$rand0m = md5("f3030laks02lo1204kalso264674;1==mm242;");
	mysql_query("INSERT INTO `users` (`id`, `username`, `password`, `status`, `membership_type`, `membership_expires`, `maxboot`) VALUES (NULL, '".$payer_email."', '".$rand0m."', '2', 'active', 'lifetime', '120');");
	echo "Thanks for your order. You may now login using this info:";
	echo "<br>";
	echo "Username: ".$payer_email."<br>";
	echo "Password: ".$rand0m."<br>";
}
else if (strcmp ($res, "INVALID") == 0) {
// log for manual investigation
	echo "IP logged for possible fraud payment.";
}
}
fclose ($fp);
}



?>