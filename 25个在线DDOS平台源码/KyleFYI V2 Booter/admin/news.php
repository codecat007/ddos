<?PHP
	require_once("header.php");
	
	if(isset($_POST['subject']) and ($_POST['message'])){
		$subject = $_POST['subject'];
		$message = $_POST['message'];
		$date = date("F j, Y, g:i a");
		$query = mysql_query("INSERT INTO `news` (`subject`, `message`, `date`, `username`) VALUES ('$subject', '$message', '$date', '".$_SESSION['SESS_login']."');");
		$smarty->assign("check", "Added this to news!");
	}else{
		$smarty->assign("check", "");
	}
	
	$smarty->display("class.news.tpl");
	$smarty->display("class.footer.tpl");
?>