<?PHP
	require_once("header.php");
	
	$result = mysql_query ("SELECT * FROM `logs` where `username`='".$_SESSION['SESS_login']."'"); 
	while ($new = mysql_fetch_assoc($result)){ $news[] = $new; }  
	$smarty->assign('iplogged', $news);
	
	$smarty->display("class.logs.tpl");
	$smarty->display("class.footer.tpl");
?>