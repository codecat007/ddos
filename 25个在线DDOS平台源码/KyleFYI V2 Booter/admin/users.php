<?PHP
	require_once("header.php");
	
	$result = mysql_query ("SELECT * FROM `users`"); 
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
	$smarty->display("class.users.tpl");
	$smarty->display("class.footer.tpl");
?>