<?PHP
	require_once("header.php");
	if(isset($_POST['password']) and ($_POST['repassword'])){
		$password = $_POST['password'];
		$repassword = $_POST['repassword'];
		if($password==$repassword){
			$password = md5($password);
			$username = clean($_SESSION['SESS_login']);
			$query = mysql_query("UPDATE `users` SET passwd='".$password."', WHERE login='$username'");
			$smarty->assign("password", "Password changed, please logout and log back in.");
		}else{
			$smarty->assign("password", "Passwords didn't match.");
		}
	}else{
		$smarty->assign("password", "");
	}
	$smarty->display("class.profile.tpl");
	$smarty->display("class.footer.tpl");
?>