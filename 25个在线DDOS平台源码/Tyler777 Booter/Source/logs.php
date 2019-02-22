<?php
require("header.php");

if(!checkAdmin()) {
die("<div class=\"box\">
    <h2>Administration Panel &bull; Access Denied</h2>
<div class=\"box-content\">
<p>You are not an administrator.</p>
</div></div>");
exit();
}

$query="SELECT * FROM logs ORDER BY DATE DESC";
$result=mysql_query($query);
$num=mysql_numrows($result);
?>

<div class="box">
    <h2>Attack Information</h2>
    <div class="box-content">
        <strong><center><img src="images/info.png"> <font color="white">Information:</font></strong> Newest attacks are shown at the top, most recent format.</center>
    </div>
</div>


<?php
$i=0;
while ($i < $num) {
    ?>

<div class="box">
    <h2>Recent Attacks</h2>
    <div class="box-content">
<table border="0" style="background-color:#000000" width="100%" cellpadding="1" cellspacing="2">
<tr>
<td><center><font color="blue"><strong>Username</strong></font></center></td>
<td><center><font color="blue"><strong>DNS / IP</strong></font></center></td>
<td><center><font color="blue"><strong>Duration</strong></font></center></td>
<td><center><font color="blue"><strong>Port</strong></font></center></td>
<td><center><font color="blue"><strong>Date</strong></font></center></td>

</tr>
</table>
    <?php

$f1=mysql_result($result,$i,"username");
$f2=mysql_result($result,$i,"ip");
$f3=mysql_result($result,$i,"time");
$f4=mysql_result($result,$i,"port");
$f5=mysql_result($result,$i,"date");

?>
<table>
<?php echo "<tr><td><center> $f1  |  </center></td><td><center> $f2  |  </center></td><td><center> $f3  |  </center></td><td><center> $f4  |  </center></td><td><center> $f5</center></td><tr/>"; ?>
</table>
</div>
</div>
<?php
$i++;
}
?>
</tr>
</table>
    <?php

if($i == 0) {
   ?>
<div class="box">
<h2>No Logs Available</h2>
<div class="box-content">
<p>The logs are currently empty!</p>
</div>
</div>
   <?php
}

?>
















	

<br>


<br>

<?php 
include 'footer.php';
?>