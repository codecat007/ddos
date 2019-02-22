<?PHP
	if(isset($_GET['id'])){
		require_once("header.php");
		
		$id = $_GET['id'];
		$result = mysql_query ("SELECT * FROM `tickets` where `id`='".$id."'"); 
		while ($new = mysql_fetch_assoc($result)){
			$news[] = $new;
		}  
		$smarty->assign("thread", $news);
		
		$result = mysql_query ("SELECT * FROM `replys` where `id`='".$id."'"); 
		while ($new = mysql_fetch_assoc($result)){
			$news[] = $new;
		}  
		$smarty->assign("replys", $news);
		
		$smarty->display("class.view.tpl");
		$smarty->display("class.footer.tpl");
	}
?>