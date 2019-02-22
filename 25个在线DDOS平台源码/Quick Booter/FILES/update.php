<?php
	session_start();
	include('config.php');

	mysql_connect(DB_HOST, DB_USER, DB_PASS) or die(mysql_error());
	mysql_select_db(DATABASE) or die(mysql_error());
	

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
$payer_email = $_POST['payer_email'];
$user_id = $_POST['custom']; 



if (!$fp) {
   // HTTP ERROR
} else {
  fputs ($fp, $header . $req);
  while (!feof($fp)) {
    $res = fgets ($fp, 1024);
    if (strcmp ($res, "VERIFIED") == 0) {
		if($payment_status == 'Completed')
		{
			$txn_id_check = mysql_query("SELECT `txn_id` FROM `payments` WHERE `txn_id` = '" . $txn_id . "'");
			
			if(mysql_num_rows($txn_id_check != 1))
			{
				if($receiver_email == PAYPAL_EMAIL)
				{
					$log_query = mysql_query("INSERT INTO `payments` VALUES ('', '" . $txn_id . "', '" . $item_number . "', '" . $user_id . "', '" . $payment_currency . "', '" . $payment_amount ."', '" . time() ."', '" . $_SERVER['REMOTE_ADDR'] . "', '" . $payer_email . "', '" . $payment_status  . "')")
					or die(file_put_contents('error_log.txt', mysql_error()));
					
					$expire_date = time() + 2592000;
					mysql_query("UPDATE `users` SET membership='" . $item_number . "' WHERE `member_id` = '" . $user_id . "'")
					or die(file_put_contents('error_log2.txt', mysql_error()));
					
					mysql_query("UPDATE `users` SET expire_date='" . $expire_date ."' WHERE `member_id` = '" . $user_id . "'")
					or die(file_put_contents('error_log3.txt', mysql_error()));

				}
			}
		}


    }
    else if (strcmp ($res, "INVALID") == 0) {
         // log for manual investigation
    }
  }
  fclose ($fp);
}

header('Location: index.php');
?>
