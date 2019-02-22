<?PHP
	require_once("header.php");
	
	$result = mysql_query ("SELECT * FROM `iplogger` where `username`='".$_SESSION['SESS_MEMBER_ID']."' ORDER BY i DESC"); 
	while ($new = mysql_fetch_assoc($result)){
		$news[] = $new;
	}  
	$smarty->assign("iplogged", $news);

	$smarty->display("class.logger.tpl");
	$smarty->display("class.footer.tpl");
?>