<?PHP
	require_once("header.php");
	
	$result = mysql_query ("SELECT * FROM `tickets` where `replyed`='no'"); 
	while ($new = mysql_fetch_assoc($result)){
		$news[] = $new;
	}  
	$smarty->assign("tickets", $news);
	
	$smarty->display("class.support.tpl");
	$smarty->display("class.footer.tpl");
?>