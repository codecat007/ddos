<div id="content">
<?php

$query="SELECT * FROM getshells";
$result = mysql_query($query) or die(mysql_error());
$num = mysql_numrows($result);

$link = mysql_connect("localhost", DB_USER, DB_PASS);
mysql_select_db(DB_DATABASE, $link);

$query="SELECT * FROM getshells";
$result=mysql_query($query) or die(mysql_error());

	if(isset($_GET['delid'])){
		$f1 = mysql_real_escape_string($_GET['delid']);

		if(mysql_query("DELETE FROM getshells WHERE url LIKE '$f1'")){
			echo '<meta http-equiv="refresh" content="0; URL=shells.php">';
		}else {
		die(mysql_error());
		}
	}

?>
<h1>Manage Shells</h1>
<table cellpadding="0" cellspacing="0" class="display">
<thead>
<tr>
      <th>ID</th>
      <th>Link</th>
      <th>Shell URL</th>
      <th>Manage</th>
    </tr>
</thead>

<?php
$i = 0;
while ($i < $num) {

$id++;
$f1 = mysql_result($result,$i,"URL");

?>
<?php echo "<tr><td width=\"10%\"><center>{$id}</center></td><td width=\"20%\"><a target=_new href=\"{$f1}\"><center><image alt=\"{$f1}\" border=0 src=\"../images/visit.png\"></a></center></td><td width=\"80%\"><center>$f1</td><td><a href=\"shells.php?delid={$f1}\"><center><image border=0 src=\"../images/cancel.png\"></a></td></center><tr/>"; ?>

<?php
$i++;
}

?>
</tr>
</div>