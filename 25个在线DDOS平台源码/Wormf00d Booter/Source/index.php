<?php 
require("header.php");

$query = "SELECT * FROM news ORDER BY id DESC LIMIT 5";
$results = mysql_query($query);
$number = mysql_numrows($results);

$i=0;
while ($i < $number) {
$f1 = mysql_result($results,$i,"title");
$f2 = mysql_result($results,$i,"message");
$f3 = mysql_result($results,$i,"date");
$f4 = mysql_result($results,$i,"author");
?>

<div class="box">
<h2><?php echo $f1; ?></h2>
<div class="box-content">
<p><?php echo nl2br($f2); ?></p>
</div>
<div class="divider"><p>Posted by <font color="white"><?php echo $f4; ?></font>.<span class="right"><?php echo $f3; ?></span></p></div>
</div>


<?php
$i++;
}

if($i == 0) {
   ?>
<div class="box">
<h2>No news to be displayed</h2>
<div class="box-content">
<p>There are currently no news posts! Create one in the administration panel to remove this message.</p>
</div>
</div>
   <?php
}
?>


<br>

<?php 
include 'footer.php';
?>