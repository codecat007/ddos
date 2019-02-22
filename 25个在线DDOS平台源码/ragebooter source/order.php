<?php
if(isset($_GET['id']) && Is_Numeric($_GET['id']))
{
session_start();
require_once("includes/db.php");
require_once("includes/init.php");
function getPath()
{
	$temp = "http://".$_SERVER['HTTP_HOST'];
	if($_SERVER['PHP_SELF'][strlen($_SERVER['PHP_SELF'])-1] == "/")
	{
		$temp.=$_SERVER['PHP_SELF'];
	} else {
		$temp.=dirname($_SERVER['PHP_SELF']);
	}
	if($temp[strlen($temp)-1]=="/")
	{
		$temp = substr($temp, 0, strlen($temp)-1);
	}
	return dirname($temp);
}
$id = (int)$_GET['id'];
$paypalemail = $odb -> query("SELECT `email` FROM `gateway` LIMIT 1") -> fetchColumn(0);
$plansql = $odb -> prepare("SELECT * FROM `plans` WHERE `ID` = :id");
$plansql -> execute(array(":id" => $id));
$row = $plansql -> fetch();
if($row === NULL) { die("Bad ID"); }
$paypalurl = "https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&amount=".urlencode($row['price'])."&business=".urlencode($paypalemail)."&item_name=".
urlencode($row['name'])."&item_number=".urlencode($row['ID']."_".$_SESSION['ID'])."&return=".urlencode(dirname(getPath())."/purchase.php")."&rm=2&notify_url=".
urlencode(dirname(getPath())."/gateway/paypalipn.php")."&cancel_return=".urlencode(dirname(getPath())."/purchase.php")."&no_note=1&currency_code=USD";

header("Location: ".$paypalurl);
}
?>
