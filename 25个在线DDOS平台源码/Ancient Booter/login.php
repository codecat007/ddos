<?php 
include 'dbc.php';

$err = array();

foreach($_GET as $key => $value) {
	$get[$key] = filter($value); 
}

if ($_POST['doLogin']=='Login')
{

foreach($_POST as $key => $value) {
	$data[$key] = filter($value); 
}


$user_email = $data['usr_email'];
$pass = $data['pwd'];


if (strpos($user_email,'@') === false) {
    $user_cond = "user_name='$user_email'";
} else {
      $user_cond = "user_email='$user_email'";
    
}

	
$result = mysql_query("SELECT `id`,`pwd`,`full_name`,`approved`,`user_level` FROM users WHERE $user_cond AND `banned` = '0'") or die (mysql_error()); 
$num = mysql_num_rows($result);

    if ( $num > 0 ) { 
	
	list($id,$pwd,$full_name,$approved,$user_level) = mysql_fetch_row($result);
	
	if(!$approved) {
	$err[] = "Account not activated. This community requires approval by an administrator. If you have purchased access to this website simply contact the vendor with your login details and payment information.";
	 }

	if ($pwd === PwdHash($pass,substr($pwd,0,9))) { 
	if(empty($err)){			
  
       session_start();
	   session_regenerate_id (true); //prevent against session fixation attacks.

		$_SESSION['user_id']= $id;  
		$_SESSION['user_name'] = $full_name;
		$_SESSION['user_level'] = $user_level;
		$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
		$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
		
		$stamp = time();
		$ckey = GenKey();
		mysql_query("update users set `ctime`='$stamp', `ckey` = '$ckey' where id='$id'") or die(mysql_error());
		
		
                if(isset($_POST['remember']))
			{
				  setcookie("user_id", $_SESSION['user_id'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				  setcookie("user_key", sha1($ckey), time()+60*60*24*COOKIE_TIME_OUT, "/");
				  setcookie("user_name",$_SESSION['user_name'], time()+60*60*24*COOKIE_TIME_OUT, "/");
			}
		  header("Location: index.php");
		 }
       } else {
            $err[] = "You have supplied an invalid password for this username.";
        }
                    } else {
		$err[] = "The username provided does not exist in our database.";
	  }		
}
					 
					 

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
<link href="styles/login.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body>
<center><?php echo $err[0]; ?></center>
	<div id="logincontainer">
    	<h1>Ancient<span>Booter</span></h1>
        <div id="loginbox">
        	<form action="login.php" method="post" name="logForm" id="logForm" >
                <div class="inputcontainer">
                    <img src="images/icons/icon_username.png" alt="Username" />
                    <label for="username">Username:</label>
                    <input name="usr_email" type="text" class="required" id="txtbox" size="25">
                </div>
                <div class="inputcontainer">
                    <img src="images/icons/icon_locked.png" alt="Password" />
                    <label for="password">Password:  </label>
                            <input name="pwd" type="password" class="required password" id="txtbox" size="25">
                </div>
                <input name="doLogin" type="submit" id="doLogin3" value="Login" class="loginsubmit">
                <p><a href="register.php">Register an account</a></p>
            </form>
        </div>
    </div>
</body>
</html>
