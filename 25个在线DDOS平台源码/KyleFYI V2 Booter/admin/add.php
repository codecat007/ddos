<?PHP
	require_once("header.php");
	
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
		$query = mysql_query("INSERT INTO `keys` (`key`, `month`, `max`, `type`) VALUES ('".$string."', '".$expiry."', '".$max."', '".$type."');");
		
		$smarty->assign("check", "Key added, the key is: ".$string);
	}else{
		$smarty->assign("check", "");
	}
	
	function genRandomString() {
    $length = 5;
    $characters = "0123456789abcdefghijklmnopqrstuvwxyz";
    $string = ""; 
	$p = 0;
    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters))];
    }
    return $string;
}

	
	$smarty->display("class.add.tpl");
	$smarty->display("class.footer.tpl");
?>