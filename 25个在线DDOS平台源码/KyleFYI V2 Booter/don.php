<?PHP
	require_once("header.php");
	
	if(isset($_POST['ip'])){
		$host = $_POST['ip'];
		$port=80;
		$timeout=6;
		$fsock = fsockopen($host, $port, $errno, $errstr, $timeout);
		if ( ! $fsock ){
			$smarty->assign("check", "The IP Address: " .$host." Is OFFLINE");
		}else{
			$smarty->assign("check", "The IP Address: " .$host." Is ONLINE");
		}
		
	}else{
		$smarty->assign("check", "");
	}
	$smarty->display("class.don.tpl");
	$smarty->display("class.footer.tpl");
?>