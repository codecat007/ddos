<?PHP
	require_once("header.php");
	if($type!="reseller"){
		die("Your not a reseller!");
	}
	if(isset($_POST['max']) and ($_POST['expiry'])){
		$max = $_POST['max'];
		$expiry = $_POST['expiry'];
		$type = $_POST['type'];
		$length = 10;
		$characters = "0123456789abcdefghijklmnopqrstuvwxyz";
		$string = ""; 
		for ($p = 0; $p < $length; $p++) {
			$string .= $characters[mt_rand(0, strlen($characters))];
		}
		$string = genRandomString()."-".genRandomString()."-".genRandomString()."-".genRandomString()."-".genRandomString();
		$string = strtoupper($string);
		$query = mysql_query("INSERT INTO `keys` (`key`, `month`, `max`, `type1) VALUES ('".$string."', '".$expiry."', '".$max."', '".$type."');");

		$smarty->assign("check", "Key added, the key is: ".$string);
	}else{
		$smarty->assign("check", "");
	}
	
	$result = mysql_query ("SELECT * FROM `users` where `reseller`='".$username."'"); 
	while ($new = mysql_fetch_assoc($result)){ $news[] = $new; }  
	$smarty->assign('iplogged', $news);
	if(isset($_GET['remove'])){
		$username = clean($_GET['remove']);
		mysql_query("DELETE FROM `users` where login='".$username."'");
	}
	if(isset($_GET['ban'])){
		$username = $_GET['ban'];
		mysql_query("UPDATE `users` SET  `type` =  'banned' WHERE  login='".$username."'");
	}
	
	$smarty->display("class.reseller.tpl");
?>