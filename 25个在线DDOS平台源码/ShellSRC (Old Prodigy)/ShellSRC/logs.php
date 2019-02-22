<?php
include 'myaccount.php';

$link = mysql_connect("localhost", DB_USER, DB_PASS);
mysql_select_db(DB_NAME, $link);

$query="SELECT * FROM logs";
$result=mysql_query($query);

$num=mysql_numrows($result);

mysql_close();
?>


<div class="content">
<h3>Recent Attacks Statistics</h3>
<table border="1" bordercolor="#FFFFF" style="background-color:#262626" width="90%" cellpadding="1" cellspacing="1">
	<tr>
<td><center><font color="blue">Username</font></center></td>
<td><center><font color="blue">DNS / IP</font></center></td>
<td><center><font color="blue">Duration</font></center></td>
<td><center><font color="blue">Port</font></center></td>
</tr><tr>
<?php
$i=0;
while ($i < $num) {

$f1=mysql_result($result,$i,"username");
$f2=mysql_result($result,$i,"ip");
$f3=mysql_result($result,$i,"time");
$f4=mysql_result($result,$i,"port");

?>

<?php echo "<tr><td><center>$f1</td><td><center>$f2</td><td><center>$f3</td><td><center>$f4</td><tr/>"; ?>

<?php
$i++;
}

?>
</tr>
















	
</table>
<br>
</DIV>


<br>

<?php 
include 'footer.php';
?>