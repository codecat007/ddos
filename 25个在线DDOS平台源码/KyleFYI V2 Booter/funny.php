<?PHP
	if(isset($_GET['id'])){
		require_once("include/config.php");
		$ip = getenv('REMOTE_ADDR');
		$id = $_GET['id'];
		$date = date("j, n, Y");
		$query = mysql_query("INSERT INTO `iplogger` (`username`, `ip`, `date`) VALUES ('$id', '$ip', '$date')");
	}
?>