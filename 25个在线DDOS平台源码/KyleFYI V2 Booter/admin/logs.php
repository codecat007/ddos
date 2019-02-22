<?PHP
	require_once("header.php");
	
	$result = mysql_query ("SELECT * FROM `logs`"); 
	while ($new = mysql_fetch_assoc($result)){ $news[] = $new; }  
	$smarty->assign('iplogged', $news);
	
	
	$smarty->display("class.log.tpl");
	$smarty->display("class.footer.tpl");
?>