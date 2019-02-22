<?php
error_reporting(0);
ob_start();
require_once 'includes/db.php';
require_once 'includes/init.php';
if (!($user -> LoggedIn()))
{
	header('location: login.php');
	die();
}
if (!($user->hasMembership($odb)))
{
	header('location: purchase.php');
	die();
}
if (!($user -> notBanned($odb)))
{
	header('location: login.php');
	die();
}
function get_host($ip){
        $ptr= implode(".",array_reverse(explode(".",$ip))).".in-addr.arpa";
        $host = dns_get_record($ptr,DNS_PTR);
        if ($host == null) return $ip;
        else return $host[0]['target'];
} 
function isCloudflare($ip)
{
	$host = get_host($ip);
	if($host=="cf-".implode("-", explode(".", $ip)).".cloudflare.com")
	{
		return true;
	} else {
		return false;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $title_prefix; ?>Cloudflare Resolver</title>
<?php include 'includes/css.php';?>
</head>
<body>
<?php
include 'sidebar.php';
?>
<!-- Right side -->
<div id="rightSide">
<?php include 'header.php';?>
    
    

    
    <!-- Title area -->
    <div class="titleArea">
        <div class="wrapper">
            <div class="pageTitle">
                <h3>Cloudflare Resolver</h3>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    
    <div class="line"></div>
    

    
    <!-- Main content wrapper -->
    <div class="wrapper">
        <!-- Form -->
		<?php
		$resolved = '';
		if (isset($_POST['resolveBtn']))
		{
			$resolved = $_POST['toResolve'];
			$lookupArr = array("mail.", "direct.", "direct-connect.", "direct-connect-mail.", "cpanel.", "ftp.");
			$output = array();
			foreach ($lookupArr as $lookupKey)
			{
				$lookupHost = $lookupKey . $resolved;
				$foundHost = gethostbyname($lookupHost);
				
				if ($foundHost == $lookupHost)
				{
					$output[] = "No DNS Found";
				}
				else
				{
					$extra = "<font color=\"green\">(Not Cloudflare)</font>";
					if(isCloudflare($foundHost))
					{
						$extra = "<font color=\"red\">(Cloudflare)</font>";
					}
					$output[] = $foundHost." ".$extra;
				}
			}

		}
		?>
		<form class="form" method="POST" action="">
            <fieldset>
                <div class="widget">
                    <div class="title"><img src="images/icons/dark/list.png" alt="" class="titleIcon" /><h6>Cloudflare Resolver</h6></div>
                    <div class="formRow">
                        <label>Cloudflare Domain</label>
                        <div class="formRight"><input type="text" name="toResolve" value="" id="toResolve"/></div>
                        <div class="clear"></div>
					</div>
					<div class="formRow">
						<input type="submit" value="Resolve" name="resolveBtn" class="dblueB logMeIn" />
						<div class="clear"></div>
                    </div>
                </div>
            </fieldset>
        </form> 
		<div class="widget">
          <div class="title"><img src="images/icons/dark/frames.png" alt="" class="titleIcon" /><h6>IP Info</h6></div>
            <table cellpadding="0" cellspacing="0" width="100%" class="sTable">
                <tbody>
					<tr>
                        <td><strong>Domain:</strong></td>
						<td><?php echo $resolved;?></td>
                    </tr>
                    <tr>
                        <td><strong>Mail:</strong></td>
						<td><?php echo $output[0];?></td>
                    </tr>
                    <tr>
						<td><strong>Direct:</strong></td>
						<td><?php echo $output[1];?></td>
                    </tr>
                    <tr>
                        <td><strong>Direct-Connect:</strong></td>
						<td><?php echo $output[2];?></td>
                    </tr>
		    <tr>
                        <td><strong>Direct-Connect-Mail:</strong></td>
                                                <td><?php echo $output[3];?></td>
                    </tr>

                    <tr>
                        <td><strong>CPanel:</strong></td>
						<td><?php echo $output[4];?></td>
                    </tr><tr>
                        <td><strong>FTP:</strong></td>
						<td><?php echo $output[5];?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Footer line -->
    <?php include 'footer.php';?>

</div>

<div class="clear"></div>
</body>

</html>
