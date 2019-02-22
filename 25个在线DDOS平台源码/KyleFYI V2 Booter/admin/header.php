<?PHP
	require_once("../include/config.php");
	require_once("../include/auth.php");
	require_once("../reg.php");
	
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
	
	require('../libs/Smarty.class.php');
	$smarty = new Smarty;
	$smarty->template_dir = '../templates';
	$smarty->compile_dir = '../temp';
	$smarty->assign("template", "../templates");
	
	$timeleft =  clean($_SESSION['SESS_expiry']);
	$time = time();
	$type = clean($_SESSION['SESS_type']);
	if($type=="banned"){
		die("Your account has been banned.");
	}
	if($type!="admin"){
		die("You must be a admin");
	}
	$username = $_SESSION['SESS_login'];
	if($timeleft=="lifetime"){
		$timeleft = "Lifetime";
	}elseif($timeleft <= $time){
		die("Your membership has ran out!");
	}else{
		$timeleft = date('d M Y', $timeleft);
	}
	
	$users = 0;
	$result = mysql_query ("SELECT * FROM `users`"); 
	while ($new = mysql_fetch_assoc($result)){
		$users = $users + 1;
	}
	$shells = 0;
	$result = mysql_query ("SELECT * FROM `shells`"); 
	while ($new = mysql_fetch_assoc($result)){
		$shells = $shells + 1;
	}  
	
	$smarty->assign("username", clean($_SESSION['SESS_login']));
	$smarty->assign("type", clean($_SESSION['SESS_type']));
	$smarty->assign("maxboot", clean($_SESSION['SESS_max']));
	$smarty->assign("attacks_left", clean($_SESSION['SESS_attacks']));
	$smarty->assign("member_ID", clean($_SESSION['SESS_MEMBER_ID']));
	$smarty->assign("total_users", clean($users));
	$smarty->assign("timeleft", clean($timeleft));
	$smarty->assign("bootername", clean($bootername));
	$smarty->assign("shells", clean($shells));
	$smarty->assign("booterURL", clean($booterURL));
	
	$smarty->display("class.admin-header.tpl");
?>