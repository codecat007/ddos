<?php
require("header.php");

$query = "SELECT * FROM updates ORDER BY id DESC LIMIT 15";
$results = mysql_query($query);
$number = mysql_numrows($results);

$i=0;
while ($i < $number) {
$f1 = mysql_result($results,$i,"message");
$f2 = mysql_result($results,$i,"date");
?>

<div class="box">
<h2>New Update (<?php echo $f2; ?>)</h2>
<div class="box-content">
<p><?php echo $f1; ?></p>
</div>
</div>


<?php
$i++;
}

if($i == 0) {
   ?>
<div class="box">
<h2>No updates to be displayed</h2>
<div class="box-content">
<p>There are currently updates! Create one in the administration panel to remove this message.</p>
</div>
</div>
   <?php
}
?>


<br>

<?php
include 'footer.php';
?>