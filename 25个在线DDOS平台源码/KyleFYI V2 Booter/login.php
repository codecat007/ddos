<?PHP
	require_once("include/config.php");
	require('libs/Smarty.class.php');
	$smarty = new Smarty;
	$smarty->template_dir = 'templates';
	$smarty->compile_dir = 'temp';
	if(isset($_GET['action'])){
		$action = $_GET['action'];
		if($action=="Invalid"){
			$smarty->assign("action", "Invalid");
		}elseif($action=="logout"){
			$smarty->assign("action", "logout");
		}else{
			$smarty->assign("action", "na");
		}
	}else{
		$smarty->assign("action", "other");
	}
	$smarty->assign("bootername", $bootername);
	$smarty->display("class.login.tpl");
?>