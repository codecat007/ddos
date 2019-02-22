<?php

function random_string($noChar = 15)
{
    if (!is_numeric($noChar))
    {
        $noChar = 10;
    }
    $preHash = '';    
    for ($digit = 0; $digit < $noChar; $digit++)
    {
        $r = rand(0,2);
        if ($r == 0)
        {
            $cb = rand(65,90);
            $c = chr($cb);
        }
        else if ($r == 1)
        {
            $c = rand(0,9);
        }
        else
        {
            $cb = rand(97,122);
            $c = chr($cb);
        }
        $preHash .= $c;
    }
    return $preHash;
}

function get_user_ip($_SERVER)
{
	if (isset($_SERVER['HTTP_CF_CONNECTING_IP']))
	{
		$ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
	}
	else if (isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
	{
		$ip = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
	}
	else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	{
		$exForward = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']);
		$ip = $exForward[0];
	}
		
	if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false)
	{
		return $ip;
	}
	
	return false;
}


/*
 * is_admin()
 * Check if supplied user is admin.
 * returns boolean true or false
 */
function is_admin($uid, $dbLink)
{
	$SQL = "SELECT `group` FROM `users` WHERE `id`={$uid}";
	$query = mysql_query($SQL, $dbLink);
	$group = mysql_result($query, 0);
	
	if ($group == 5)
	{
		return true;
	}
	else
	{
		return false;
	}
}

?>