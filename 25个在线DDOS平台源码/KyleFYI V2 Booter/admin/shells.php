<?PHP
	require_once("header.php");
	
	if(isset($_POST['shell'])){
		$shell = clean($_POST['shell']);
		$query = mysql_query("INSERT INTO shells (url) values = '$shell'");
		echo "Shell added!";
	}
	
	if(isset($_POST['Submit'])) {
		$hosts = explode("\r\n", $_POST['url']);
		$values = array();
		foreach ($hosts as $host) 
		$values[] .= "('" . mysql_real_escape_string($host) . "')";
		$query = "INSERT INTO shells (url) VALUES " . implode(',', $values);
		$result = mysql_query($query) or die("mysql error " . mysql_error() . " in query $query");
		echo mysql_error();
		echo 'Added shells.';
	}
	
	$smarty->display("class.shells.tpl");
	$smarty->display("class.footer.tpl");
?>