<?PHP
	require_once("include/config.php");
	require('libs/Smarty.class.php');
	$smarty = new Smarty;
	$smarty->template_dir = 'templates';
	$smarty->compile_dir = 'temp';
	if(isset($_POST['username']) and ($_POST['password']) and ($_POST['key'])){
		$username = $_POST['username'];
		$password = md5($_POST['password']);
		$key = $_POST['key'];
			$query = mysql_query("SELECT * FROM `keys` WHERE `key`='{$key}'"); 
			if (mysql_num_rows($query) == 1) {   
			while($row = mysql_fetch_array($query)){
				$key1 = $row[0];
				$months = $row[1];
				$max = $row[2];
				$type = $row[3];
			}  
			if($months=="lifetime"){
				$months = "lifetime";
			}else{
				$months = 86400 * $months;
			}
			
			$query = mysql_query("INSERT INTO `users` (`login`, `passwd`, `max`, `attacks`, `expiry`, `type`, `key`) VALUES ('".$username."', '".$password."', '".$max."', '100', '".$months."', '".$type."', '{$key}');");
			$query = mysql_query("delete from `keys` where `key`='{$key}'");
			echo mysql_error();
			$smarty->assign("done", "Your account has been added, you can now login.");
		}else{
			die("Your key isn't valid, please contact support.");
		}
	}else{
		$smarty->assign("done", "");
	}
	
	$smarty->display("class.register.tpl");
?>