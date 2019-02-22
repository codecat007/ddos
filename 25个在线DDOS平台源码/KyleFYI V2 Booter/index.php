<?PHP
	require_once("header.php");
	
	$result = mysql_query ("SELECT * FROM news ORDER BY i DESC"); 
	while ($new = mysql_fetch_assoc($result)){ $news[] = $new; }  
	$smarty->assign('iplogged', $news);
	$smarty->display("class.index.tpl");
	$smarty->display("class.footer.tpl");
?>