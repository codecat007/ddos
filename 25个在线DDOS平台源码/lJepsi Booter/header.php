<?php 
include "dbc.php";
page_protect();
include "includes/functions.php";
getBooterTitle();

$file = basename(__FILE__);
if(eregi($file,$_SERVER['REQUEST_URI'])) {
    die("Sorry but you cannot access this file directly for security reasons.");
}
?>
<link href="images/styles.css" rel="stylesheet" type="text/css">
	<body>
		<div id="container">
			<div id="header">
			</div>
<?php 
if (isset($_SESSION['user_id'])) { 
?>

<div id="navigation">

					<dl class="dropdown">
					<dt style="width: 75px" class="single"><a href="index.php" style="height: 18px; padding-top: 5px;"><img border=0 src="images/home.gif"> Home</a></dt>
					</dl>

					<dl class="dropdown">
					<dt style="width: 95px" class="single"><a href="hub.php" style="height: 18px; padding-top: 5px;"><img border=0 src="images/hub.png"> UDP Flood</a></dt>
					</dl>

					<dl class="dropdown">
					<dt style="width: 85px" class="single"><a href="updates.php" style="height: 18px; padding-top: 5px;"><img border=0 src="images/news.gif"> Updates</a></dt>
					</dl>

					<dl class="dropdown">
					<dt style="width: 95px" class="single"><a href="mysettings.php" style="height: 18px; padding-top: 5px;"><img border=0 src="images/account.png"> My Account</a></dt>
					</dl>
					 
					<?php  if (checkAdmin()) { 
                                        // Admin only links should go below here    
                                        ?>


					
					<dl class="dropdown">
					<dt style="width: 95px" class="single"><a href="addshell.php" style="height: 18px; padding-top: 5px;"><img border=0 src="images/add.png"> Add Shells</a></dt>
					</dl>

					<dl class="dropdown">
					<dt style="width: 75px" class="single"><a href="logs.php" style="height: 18px; padding-top: 5px;"><img border=0 src="images/info.png"> Logs</a></dt>
					</dl>
					
					<dl class="dropdown">
					<dt style="width: 110px" class="single"><a href="admin.php" style="height: 18px; padding-top: 5px;"><img border=0 src="images/admin.png"> Admin Panel</a></dt>
					</dl>
					
					<?php } ?>
					
					<dl class="dropdown">
					<dt style="width: 85px" class="single"><a href="logout.php" onclick='return confirm("Are you sure you want to logout?");' style="height: 18px; padding-top: 5px;"><img border=0 src="images/delete.png"> Logout</a></dt>
					</dl>

                                        <?php } ?>

</div>

<div id="main">
<div id="left">
</div>

<div id="right">
<div class="small-box"><h2>Welcome, <?php echo $username; ?>!</h2>
    <div class="small-box-content">
        <p>
        Profile ID: <font color="white"><?php echo $id; ?></font> <br />
        Rank: <font color="white"><?php echo $level; ?></font> <br />
        My Attacks: <font color="white">Unfinished</font>
        </p>

    </div></div>

        <div class="small-box"><h2>Members Statistics</h2>
    <div class="small-box-content">
        <p>


                    <table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" class="forms">
                        <font size=1>
          <tr>
            <td><font color="white">Total Users</font></td>
            <td><?php echo $all; ?></font></td>
          </tr>

          <tr>
            <td><font color="white">Active Users</font></td>
            <td><?php echo $active; ?></font></td>
          </tr>

          <tr>
            <td><font color="white">Pending Users</font></td>
            <td><?php echo $total_pending; ?></font></td>
          </tr>
                    </font>
                    </table>
        </p>


    </div></div>

    <div class="small-box"><h2>Shells Statistics</h2>
    <div class="small-box-content">
        <p>


                    <table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" class="forms">
                        <font size="1">
                                      <tr>
            <td><font color="white">Shell Rotation</font></td>
            <?php
            if($shellRotation == 0) { ?>
            <td><font color="red">(Off)</font></td>
            <?php } else { ?>
            <td><font color="lime">(On)</font></td>
            <?php
            }
            ?>
           
          </tr>
          
          <tr>
            <td><font color="white">Shells Online</font></td>
            <td><font color="lime"><?php echo $shellsOnline; ?></font></td>
          </tr>

          <tr>
            <td><font color="white">GET Shells</font></td>
            <td><font color="lime"><?php echo $num_rows; ?></font></td>
          </tr>

          <tr>
            <td><font color="white">POST Shells</font></td>
            <td><font color="lime"><?php echo $num_rows2; ?></font></td>
          </tr>

          <tr>
            <td><font color="white">Slowloris Shells</font></td>
            <td><font color="lime"><?php echo $num_rows3; ?></font></td>
          </tr>
                        </font>
                    </table>
        </p>


    </div></div>
</div>



	
	
