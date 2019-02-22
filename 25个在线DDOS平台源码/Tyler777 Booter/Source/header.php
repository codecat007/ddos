<?php 
include "dbc.php";
page_protect();
include "includes/functions.php";
getBooterTitle();
include "navigation.php";
$file = basename(__FILE__);
if(eregi($file,$_SERVER['REQUEST_URI'])) {
    die("Sorry but you cannot access this file directly for security reasons.");
}
?>
<link href="images/styles.css" rel="stylesheet" type="text/css">
	<body>

<div id="navigation">

</div>

<div id="main">
<div id="left">
</div>

<div id="right">
<div class="small-box"><h2>Welcome, <?php echo $username; ?>!</h2>
    <div class="small-box-content"><font size="1">
        <p>
        Profile ID: <font color="white"><?php echo $id; ?></font> <br />
        Rank: <font color="white"><?php echo $level; ?></font> <br />
        Payment Due(yyyymmdd): <font color="white"><?php
    $query = mysql_query("SELECT * FROM `users` WHERE id='$id' ");
    while($row = mysql_fetch_array($query)){
    $nextpay = $row['months'];
    echo $nextpay;
    }
?></font> <br />
        My IP: <font color="white"><?php echo $_SERVER["REMOTE_ADDR"]; ?></font> <br />
        My Attacks: <font color="white"><?php
    $query = mysql_query("SELECT * FROM `users` WHERE id='$id' ");
    while($row = mysql_fetch_array($query)){
    $attacks = $row['myAttacks'];
    echo $attacks;
    }
?></font>
        </p>
</font>
    </div></div>

        <div class="small-box"><h2>Members Statistics</h2>
    <div class="small-box-content"><font size="1">
        <p>


                    <table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" class="forms">
                        <font size=2>
          <tr>
            <td><font color="white" size="2">Total Users</font></td>
            <td><?php echo $all; ?></font></td>
          </tr>

          <tr>
            <td><font color="white" size="2">Active Users</font></td>
            <td><?php echo $active; ?></font></td>
          </tr>

          <tr>
            <td><font color="white" size="2">Pending Users</font></td>
            <td><?php echo $total_pending; ?></font></td>
          </tr>
          <tr>
            <td><font color="white" size="2">Total Attacks</font></td>
            <td><?php
                   $result = mysql_query("SELECT * FROM logs", $link);
                   $num_rows4 = mysql_num_rows($result);
                   echo "$num_rows4";
                ?></font></td>
          </tr>
                    </font>
                    </table>
        </p>

</font>
    </div></div>

    <div class="small-box"><h2>Shells Statistics</h2>
    <div class="small-box-content">
        <p>


                    <table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" class="forms">
                        <font size="2">
                                      <tr>
            <td><font color="white" size="2">Shell Rotation</font></td>
            <?php
            if($shellRotation == 0) { ?>
            <td><font color="red" size="2">(Off)</font></td>
            <?php } else { ?>
            <td><font color="lime" size="2">(On)</font></td>
            <?php
            }
            ?>
           
          </tr>
          
          <tr>
            <td><font color="white" size="2">Shells Online</font></td>
            <td><font color="lime" size="2"><?php echo $shellsOnline; ?></font></td>
          </tr>

          <tr>
            <td><font color="white" size="2">GET Shells</font></td>
            <td><font color="lime" size="2"><?php echo $num_rows; ?></font></td>
          </tr>

          <tr>
            <td><font color="white" size="2">POST Shells</font></td>
            <td><font color="lime" size="2"><?php echo $num_rows2; ?></font></td>
          </tr>

          <tr>
            <td><font color="white" size="2">Slowloris Shells</font></td>
            <td><font color="lime" size="2"><?php echo $num_rows3; ?></font></td>
          </tr>
                        </font>
                    </table>
        </p>


    </div></div>
</div>



	
	
