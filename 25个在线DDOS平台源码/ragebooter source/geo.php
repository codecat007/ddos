<?php
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $title_prefix; ?>Geolocation</title>
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
                <h3>Geolocation</h3>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    
    <div class="line"></div>
    

    
    <!-- Main content wrapper -->
    <div class="wrapper">
        <!-- Form -->
		<?php 
		$ip = '';
		if(isset($_POST['lookupBtn']))
		{
			$ip = $_POST['ipAddress'];
			$ip = (filter_var($ip, FILTER_VALIDATE_IP)) ? $ip : $_SERVER['REMOTE_ADDR'];
		}
		else 
		{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		$xml = simplexml_load_file('http://api.ipinfodb.com/v2/ip_query.php?key=d8dc071351f3b1882b26d5b6820df28eaf2528a2746d78ea4fcbfbe5fe52089d&ip='.$ip.'&timezone=true');

		$ip = $xml->Ip;
		$status = $xml->Status;
		$country = $xml->CountryName;
		$region = $xml->RegionName;
		$city = $xml->City;
		$latitude = $xml->Latitude;
		$longitude = $xml->Longitude;
		$timezone = $xml->TimezoneName;
		?>
		<form action="" class="form" method="POST">
            <fieldset>
                <div class="widget">
                    <div class="title"><img src="images/icons/dark/list.png" alt="" class="titleIcon" /><h6>IP To Lookup</h6></div>
                    <div class="formRow">
                        <label>IP Address</label>
                        <div class="formRight"><input type="text" name="ipAddress"/></div>
                        <div class="clear"></div>
                    </div>
					<div class="formRow">
						<input type="submit" value="Lookup" name="lookupBtn" class="dblueB logMeIn" />
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
                        <td><strong>IP Address:</strong></td>
						<td><?php echo $ip;?></td>
                    </tr>
                    <tr>
						<td><strong>Status:</strong></td>
						<td><?php echo $status;?></td>
                    </tr>
                    <tr>
                        <td><strong>Country:</strong></td>
						<td><?php echo $country;?></td>
                    </tr>
                    <tr>
                        <td><strong>Region:</strong></td>
						<td><?php echo $region;?></td>
                    </tr><tr>
                        <td><strong>City:</strong></td>
						<td><?php echo $city;?></td>
                    </tr><tr>
                        <td><strong>Latitude:</strong></td>
						<td><?php echo $latitude;?></td>
                    </tr><tr>
                        <td><strong>Longitude:</strong></td>
						<td><?php echo $longitude;?></td>
                    </tr><tr>
                        <td><strong>Timezone:</strong></td>
						<td><?php echo $timezone;?></td>
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
