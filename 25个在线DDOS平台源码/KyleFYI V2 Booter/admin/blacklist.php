<?PHP
	require_once("header.php");
	
	
	
	if(isset($_POST['blacklist'])){
		$ip = $_POST['blacklist'];
		$query = mysql_query("INSERT INTO `blacklist` (`ip`) VALUES ('".$ip."');");
		$smarty->assign("check", "Added ".$ip." to black list.");
	}else{
		$smarty->assign("check", "");
	}
	
	if(isset($_GET['remove'])){
		$ip = $_GET['remove'];
		$query = mysql_query("DELETE FROM `blacklist` where `ip` = '".$ip."'");
		$smarty->assign("check", "Removed ".$ip." from blacklist.");
	}
	
	$result = mysql_query ("SELECT * FROM `blacklist`"); 
	while ($new = mysql_fetch_assoc($result)){ $news[] = $new; }  
	$smarty->assign('iplogged', $news);
	
	$smarty->display("class.blacklist.tpl");
	$smarty->display("class.footer.tpl");
?>