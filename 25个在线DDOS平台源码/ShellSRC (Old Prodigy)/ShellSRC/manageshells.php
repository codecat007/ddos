<?php
include 'myaccount.php';

$link = mysql_connect("localhost", DB_USER, DB_PASS);
mysql_select_db(DB_NAME, $link);

$query="SELECT * FROM getshells";
$result=mysql_query($query) or die(mysql_error());

$num=mysql_numrows($result);

mysql_close();
?>


<div class="content">
<h3>Recent Attacks Statistics</h3>
<table border="1" bordercolor="#FFFFF" style="background-color:#262626" width="90%" cellpadding="1" cellspacing="1">
	<tr>
<td><center><font color="blue">Shell URL</font></center></td>
</tr><tr>
<?php
$i=0;
while ($i < $num) {

$f1 = mysql_result($result,$i,"URL");

?>

<?php echo "<tr><td><center>$f1</td><td><center></td><td><center></td><td><center></td><tr/>"; ?>

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