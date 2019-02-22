<?PHP
	require_once("header.php");

	if(isset($_POST['domain'])){
		$domain = $_POST['domain'];
		$lookupArr = array("mail.", "direct.", "direct-connect.", "cpanel.", "ftp.");
		$full = "";
		foreach ($lookupArr as $lookupKey){
			$result = gethostbyname($lookupKey.$domain);
			if ($result == $lookupKey.$domain)
			{
				$full = $full.$lookupKey.$domain.": Nothing found<br>";
			}else{
				$full = $full.$lookupKey.$domain.": ".$result."<br>";
			}
		}
		$smarty->assign("ips", $full);
	}else{
		$smarty->assign("ips", "");
	}

	$smarty->display("class.cfr.tpl");
	$smarty->display("class.footer.tpl");
?>