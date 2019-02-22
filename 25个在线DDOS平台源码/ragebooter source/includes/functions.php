<?php
class user
{
	function isAdmin($odb)
	{
		$SQL = $odb -> prepare("SELECT `rank` FROM `users` WHERE `ID` = :id");
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
	function LoggedIn()
	{
		@session_start();
		if (isset($_SESSION['username'], $_SESSION['ID']))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function hasMembership($odb)
	{
		$SQL = $odb -> prepare("SELECT `expire` FROM `users` WHERE `ID` = :id");
		$SQL -> execute(array(':id' => $_SESSION['ID']));
		$expire = $SQL -> fetchColumn(0);
		if (time() < $expire)
		{
			return true;
		}
		else
		{
			$SQLupdate = $odb -> prepare("UPDATE `users` SET `membership` = 0 WHERE `ID` = :id");
			$SQLupdate -> execute(array(':id' => $_SESSION['ID']));
			return false;
		}
	}
	function notBanned($odb)
	{
		$SQL = $odb -> prepare("SELECT `status` FROM `users` WHERE `ID` = :id");
		$SQL -> execute(array(':id' => $_SESSION['ID']));
		$result = $SQL -> fetchColumn(0);
		if ($result == 0)
		{
			return true;
		}
		else
		{
			session_destroy();
			return false;
		}
	}
}
class stats
{
	function totalUsers($odb)
	{
		$SQL = $odb -> query("SELECT COUNT(*) FROM `users`");
		return $SQL->fetchColumn(0);
	}
	function totalBoots($odb)
	{
		$SQL = $odb -> query("SELECT COUNT(*) FROM `logs`");
		return $SQL->fetchColumn(0);
	}
	function runningBoots($odb)
	{
		$SQL = $odb -> query("SELECT COUNT(*) FROM `logs` WHERE `time` + `date` > UNIX_TIMESTAMP()");
		return $SQL->fetchColumn(0);
	}
	function totalBootsForUser($odb, $user)
	{
		$SQL = $odb -> prepare("SELECT COUNT(*) FROM `logs` WHERE `user` = :user");
		$SQL -> execute(array(":user" => $user));
		return $SQL->fetchColumn(0);
	}
}
?>
