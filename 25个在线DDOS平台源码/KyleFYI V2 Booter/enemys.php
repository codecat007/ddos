<?PHP
	require_once("header.php");
	
	if(isset($_POST['ip']) and ($_POST['reason'])){
		$ip = clean($_POST['ip']);
		$reason = clean($_POST['reason']);
		mysql_query("INSERT INTO `fae` (`id`, `type`, `ip`, `reason`) VALUES ('".$_SESSION['SESS_MEMBER_ID']."', 'enemys', '".$ip."', '".$reason."');");
		$smarty->assign("check", "Friend Added!");
	}else{
		$smarty->assign("check", "");
	}
	
	$result = mysql_query ("SELECT * FROM `fae` where `id`='".$_SESSION['SESS_MEMBER_ID']."' and `type`='enemys'"); 
	while ($new = mysql_fetch_assoc($result)){ $news[] = $new; }  
	$smarty->assign('iplogged', $news);
	
	$smarty->display("class.enemys.tpl");
	$smarty->display("class.footer.tpl");
?>