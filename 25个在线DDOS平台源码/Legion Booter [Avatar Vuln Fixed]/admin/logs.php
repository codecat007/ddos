<?php
$query="SELECT * FROM logs ORDER BY DATE DESC";
$result=mysql_query($query);
$num=mysql_numrows($result);
?>

<div class="box">
    <h2>Attack Information</h2>
    <div class="box-content">
    </div>
</div>


<?php
$i=0;
while ($i < $num) {
    ?>

<div class="box">
    <div class="box-content">
<center>
<table cellpadding="0" cellspacing="0" class="display">
<thead>
<tr>
      <th>Username</th>
      <th>DNS / IP</th>
      <th>Duration</th>
      <th>Port</th>
      <th>Date</th>
    </tr>
</thead>
<tr>
</tr>
<tr>
<?php

$f1=mysql_result($result,$i,"username");
$f2=mysql_result($result,$i,"ip");
$f3=mysql_result($result,$i,"time");
$f4=mysql_result($result,$i,"port");
$f5=mysql_result($result,$i,"date");

?>

<?php echo "<tr><td><center>$f1</td><td><center>$f2</td><td><center>$f3</td><td><center>$f4</td><td><center>$f5</td><tr/>"; ?>

<?php
$i++;
}
?>
        </div>
</div>
</tr>
</table>
    <?php

if($i == 0) {
   ?>
</br><center><div class="box">
<center><h2>No Logs Available</h2></center>
<div class="box-content">
<p>The logs are currently empty!</p>
</div>
</div></center>
   <?php
}

?>
















	
</table>
<br>
</DIV>


<br>