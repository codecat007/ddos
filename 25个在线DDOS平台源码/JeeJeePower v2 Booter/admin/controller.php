<?php
define("_VALID_PHP", true);
  
  require_once("../init.php");
  if (!$user->is_Admin())
   redirect_to("../login.php");
?>
<?php
  /* == Proccess Configuration == */
  if (isset($_POST['processConfig']))
      : if (intval($_POST['processConfig']) == 0 || empty($_POST['processConfig']))
      : redirect_to("index.php?do=config");
  endif;
  $core->processConfig();
  endif;
?>
<?php
  /* == Proccess Newsletter == */
  if (isset($_POST['processNewsletter']))
      : if (intval($_POST['processNewsletter']) == 0 || empty($_POST['processNewsletter']))
      : redirect_to("index.php?do=newsletter");
  endif;
  $core->processNewsletter();
  endif;
?>
<?php
  /* == Proccess Email Template == */
  if (isset($_POST['processEmailTemplate']))
      : if (intval($_POST['processEmailTemplate']) == 0 || empty($_POST['processEmailTemplate']))
      : redirect_to("index.php?do=newsletter");
  endif;
  $core->id = (isset($_POST['id'])) ? $_POST['id'] : 0; 
  $core->processEmailTemplate();
  endif;
?>
<?php
  /* == Proccess News == */
  if (isset($_POST['processNews']))
      : if (intval($_POST['processNews']) == 0 || empty($_POST['processNews']))
      : redirect_to("index.php?do=news");
  endif;
  $core->id = (isset($_POST['id'])) ? $_POST['id'] : 0; 
  $core->processNews();
  endif;
?>
<?php
  /* == Delete News == */
  if (isset($_POST['deleteNews']))
      : if (intval($_POST['deleteNews']) == 0 || empty($_POST['deleteNews']))
      : redirect_to("index.php?do=news");
  endif;
  
  $id = intval($_POST['deleteNews']);
  $db->delete("news", "id='" . $id . "'");
  $title = sanitize($_POST['newstitle']);
  
  print ($db->affected()) ? $core->msgOk('News <strong>'.$title.'</strong> deleted successfully!') : $core->msgAlert('<span>Alert!</span>Nothing to process.');
  endif;
?>
<?php
  /* == Proccess User == */
  if (isset($_POST['processUser']))
      : if (intval($_POST['processUser']) == 0 || empty($_POST['processUser']))
      : redirect_to("index.php?do=users");
  endif;
  $user->userid = (isset($_POST['userid'])) ? $_POST['userid'] : 0; 
  $user->processUser();
  endif;
?>
<?php
  /* == Delete User == */
  if (isset($_POST['deleteUser']))
      : if (intval($_POST['deleteUser']) == 0 || empty($_POST['deleteUser']))
      : redirect_to("index.php?do=users");
  endif;
  
  $id = intval($_POST['deleteUser']);
	if($id == 1):
	$core->msgError("<span>Error!</span>You cannot delete main Super Admin account!");
	else:
	$db->delete("users", "id='" . $id . "'");
	
	$username = sanitize($_POST['username']);
	
	print ($db->affected()) ? $core->msgOk('User <strong>'.$username.'</strong> deleted successfully!') : $core->msgAlert('<span>Alert!</span>Nothing to process.');  
  endif;
  endif;
?>
<?php
  /* == User Search == */
  if (isset($_POST['userSearch']))
      : $string = sanitize($_POST['userSearch'],15);
  
  if (strlen($string) > 3)
      : $sql = "SELECT id, username, email, CONCAT(fname,' ',lname) as name" 
	  . "\n FROM users"
	  . "\n WHERE MATCH (username) AGAINST ('" . $db->escape($string) . "*' IN BOOLEAN MODE)"
	  . "\n ORDER BY username LIMIT 10";
  $display = '';
  if($result = $db->fetch_all($sql)):
  $display .= '<ul id="searchresults">';
	foreach($result as $row):
	  $link = 'index.php?do=users&amp;action=edit&amp;userid=' . (int)$row['id'];
	  $display .= '<li><a href="'.$link.'">'.$row['username'].'<small>'.$row['name'].' - '.$row['email'].'</small></a></li>';
	endforeach;
  $display .= '</ul>';
  print $display;
  endif;
  endif;
  endif;
?>
<?php
  /* == Check Username == */
  if (isset($_POST['checkUsername'])): 
  
  $username = trim(strtolower($_POST['checkUsername']));
  $username = $db->escape($username);
  
  $sql = "SELECT username FROM users WHERE username = '".$username."' LIMIT 1";
  $result = $db->query($sql);
  $num = $db->numrows($result);
  
  echo $num;
  
  endif;
?>
<?php
  /* == Site Maintenance == */
  if (isset($_POST['processMaintenance']))
      : if (intval($_POST['processMaintenance']) == 0 || empty($_POST['processMaintenance']))
      : redirect_to("index.php?do=maintenance");
  endif;

	if(isset($_POST['inactive'])):
	  $now = date('Y-m-d H:i:s');
	  $diff = intval($_POST['days']);
	  $expire = date("Y-m-d H:i:s", strtotime($now . - $diff . " days"));
	  $db->delete("users","lastlogin < '".$expire."' AND active = 'y' AND userlevel !=9");
	  
	  print ($db->affected()) ? $core->msgOk('All ('.$db->affected().') inactive user(s) deleted successfully!') : $core->msgAlert('<span>Alert!</span>Nothing to process.'); 
	  
	elseif(isset($_POST['banned'])):
	$db->delete("users","active = 'b'");
	
	print ($db->affected()) ? $core->msgOk('All banned users deleted successfully!') : $core->msgAlert('<span>Alert!</span>Nothing to process.');  
  endif;
  
  endif;
?>
<?php
  /* == Proccess Membership == */
  if (isset($_POST['processMembership']))
      : if (intval($_POST['processMembership']) == 0 || empty($_POST['processMembership']))
      : redirect_to("index.php?do=pages");
  endif;
  $core->id = (isset($_POST['id'])) ? $_POST['id'] : 0; 
  $member->processMembership();
  endif;
?>
<?php
  /* == Delete Membership == */
  if (isset($_POST['deleteMembership']))
      : if (intval($_POST['deleteMembership']) == 0 || empty($_POST['deleteMembership']))
      : redirect_to("index.php?do=memberships");
  endif;
  
  $id = intval($_POST['deleteMembership']);
  $db->delete("memberships", "id='" . $id . "'");
  $title = sanitize($_POST['posttitle']);
  
  print ($db->affected()) ? $core->msgOk('Membership <strong>'.$title.'</strong> deleted successfully!') : $core->msgAlert('<span>Alert!</span>Nothing to process.');
  endif;
?>
<?php
  /* == Proccess Gateway == */
  if (isset($_POST['processGateway']))
      : if (intval($_POST['processGateway']) == 0 || empty($_POST['processGateway']))
      : redirect_to("index.php?do=gateways");
  endif;
  $core->id = (isset($_POST['id'])) ? $_POST['id'] : 0; 
  $member->processGateway();
  endif;
?>
<?php
  /* == Delete Transaction == */
  if (isset($_POST['deleteTransaction']))
      : if (intval($_POST['deleteTransaction']) == 0 || empty($_POST['deleteTransaction']))
      : redirect_to("index.php?do=transactions");
  endif;
  
  $id = intval($_POST['deleteTransaction']);
  $db->delete("payments", "id='" . $id . "'");
  $title = sanitize($_POST['posttitle']);
  
  print ($db->affected()) ? $core->msgOk('Transaction <strong>'.$title.'</strong> deleted successfully!') : $core->msgAlert('<span>Alert!</span>Nothing to process.');
  endif;
?>
<?php
  /* == Export Transactions == */
  if (isset($_GET['exportTransactions'])) {
      $sql = "SELECT * FROM payments";
      $result = $db->query($sql);
      
      $type = "vnd.ms-excel";
	  $date = date('m-d-Y H:i');
	  $title = "Exported from the " . $core->site_name . " on $date";

      header("Pragma: public");
      header("Expires: 0");
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      header("Content-Type: application/force-download");
      header("Content-Type: application/octet-stream");
      header("Content-Type: application/download");
	  header("Content-Type: application/$type");
      header("Content-Disposition: attachment;filename=temp_" . time() . ".xls");
      header("Content-Transfer-Encoding: binary ");
      
      echo("$title\n");
      $sep = "\t";
      
      for ($i = 0; $i < $db->numfields($result); $i++) {
          echo mysql_field_name($result, $i) . "\t";
      }
      print("\n");
      
      while ($row = $db->fetchrow($result)) {
          $schema_insert = "";
          for ($j = 0; $j < $db->numfields($result); $j++) {
              if (!isset($row[$j]))
                  $schema_insert .= "NULL" . $sep;
              elseif ($row[$j] != "")
                  $schema_insert .= "$row[$j]" . $sep;
              else
                  $schema_insert .= "" . $sep;
          }
          $schema_insert = str_replace($sep . "$", "", $schema_insert);
          $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
          $schema_insert .= "\t";
          print(trim($schema_insert));
          print "\n";
      }
	  exit();
  }
?>
<?php
  /* == Page Builder == */
  if (isset($_POST['processBuilder']))
      : if (intval($_POST['processBuilder']) == 0 || empty($_POST['processBuilder']))
      : redirect_to("index.php?do=builder");
  endif;
  $member->processBuilder();
  endif;
?>
<?php
  /* == Delete SQL Backup == */
  if (isset($_POST['deleteBackup'])) :
  $action = @unlink(BASEPATH . 'admin/backups/'.sanitize($_POST['deleteBackup']));
  
  print ($action) ? $core->msgOk('<span>Success!</span>Backup deleted successfully!') : $core->msgAlert('<span>Alert!</span>Nothing to process.');
  endif;
?>