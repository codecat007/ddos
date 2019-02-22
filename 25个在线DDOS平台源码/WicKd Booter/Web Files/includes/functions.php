<?php
$show = new show();
$user = new user($odb);
$status = new status($odb);
class show
{
	function showError($error)
	{
		echo '<div class="alert alert-error"><a class="close" data-dismiss="alert" href="#">&times;</a><h4 class="alert-heading">Error!</h4>'.$error.'</div>';
	}
	function showSuccess($success)
	{
		echo '<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#">&times;</a><h4 class="alert-heading">Success!</h4>'.$success.'</div>';
	}
}
class user
{
	var $odb;
	function __CONSTRUCT($odb)
	{
		$this -> odb = $odb;
	}
	function loggedIn()
	{
		session_start();
		if (isset($_SESSION['username'], $_SESSION['ID']))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function isAdmin()
	{
		$SQL = $this -> odb -> prepare("SELECT `rank` FROM `users` WHERE `ID` = :id");
		$SQL -> execute(array(':id' => $_SESSION['ID']));
		$rank = $SQL -> fetchColumn(0);
		if ($rank == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
class status
{
	var $odb;
	function __CONSTRUCT($odb)
	{
		$this -> odb = $odb;
	}
	function registered()
	{
		$SQL = $this -> odb -> query("SELECT COUNT(*) FROM `users`");
		$count = $SQL -> fetchColumn(0);
		return $count;
	}
	function totalBoots()
	{
		$SQL = $this -> odb -> query("SELECT COUNT(*) FROM `logs`");
		$count = $SQL -> fetchColumn(0);
		return $count;
	}
	function userBoots()
	{
		$SQL = $this -> odb -> prepare("SELECT COUNT(*) FROM `logs` WHERE `user` = :user");
		$SQL -> execute(array(':user' => $_SESSION['username']));
		$count = $SQL -> fetchColumn(0);
		return $count;
	}
	function running()
	{
		$SQL = $this -> odb -> query("SELECT COUNT(*) FROM `logs` WHERE `time` + `date` > UNIX_TIMESTAMP()");
		$count = $SQL -> fetchColumn(0);
		return $count;
	}
	function expire()
	{
		$SQL = $this -> odb -> prepare("SELECT `expire` FROM `users` WHERE `ID` = :id");
		$SQL -> execute(array(':id' => $_SESSION['ID']));
		$date = $SQL -> fetchColumn(0);
		return date('j-M-Y', $date);
	}
	function maxBoot()
	{
		$SQL = $this -> odb -> prepare("SELECT `mbt` FROM `users` WHERE `ID` = :id");
		$SQL -> execute(array(':id' => $_SESSION['ID']));
		$count = $SQL -> fetchColumn(0);
		return $count;
	}
}
?>