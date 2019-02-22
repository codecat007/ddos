<?php
if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
  define('nl', "\r\n");
  
  class dbTools
  {
      private $tables = array();
      private $suffix = 'd-M-Y_H-i-s';
      
      
      /**
       * dbTools::doBackup()
       * 
       * @param string $fname
       * @param bool $gzip
       * @return
       */
      function doBackup($fname = '', $gzip = true)
      {
          global $db, $wojosec;
          
          if (!($sql = $this->fetch())) {
              return false;
          } else {
              $fname = BASEPATH . 'admin/backups/';
              $fname .= date($this->suffix);
              $fname .= ($gzip ? '.sql.gz' : '.sql');
              
              $this->save($fname, $sql, $gzip);
              
			  $ext = ($gzip ? '.sql.gz' : '.sql'); 
              $data['backup'] = date($this->suffix) . $ext;
              $db->update("settings", $data);
              
              if ($db->affected()) {
                  redirect_to("index.php?do=backup&backupok=1");
			  }
          }
      }

      /**
       * dbTools::doRestore()
       * 
       * @param string $fname
       * @return
       */
	  function doRestore($fname){
		  global $db, $msgError, $wojosec;
		  
		  $filename = BASEPATH . 'admin/backups/'.trim($fname);
		  $templine = '';
		  $lines = file($filename);
		  foreach ($lines as $line_num => $line) {
			  if (substr($line, 0, 2) != '--' && $line != '') {
				  $templine .= $line;
				  if (substr(trim($line), -1, 1) == ';') {
					  if (!$db->query($templine)) {
						  $msgError = false;
						  $msgError =  "<div class=\"qerror\">'".mysql_errno()." ".mysql_error()."' during the following query:</div> 
						  <div class=\"query\">{$templine} </div>";
					  }
					  $templine = '';
				  }
			  }
		  }
		  redirect_to("index.php?do=backup&restore=1");
	  }
        
      /**
       * dbTools::getTables()
       * 
       * @return
       */
      function getTables()
      {
          global $db;
          
          $value = array();
          if (!($result = $db->query('SHOW TABLES'))) {
              return false;
          }
          while ($row = $db->fetchrow($result)) {
              if (empty($this->tables) or in_array($row[0], $this->tables)) {
                  $value[] = $row[0];
              }
          }
          if (!sizeof($value)) {
              $db->error("No tables found in database");
              return false;
          }
          return $value;
      }
      
      
      /**
       * dbTools::dumpTable()
       * 
       * @param mixed $table
       * @return
       */
      function dumpTable($table)
      {
          global $db;
          $damp = '';
          $db->query('LOCK TABLES ' . $table . ' WRITE');
          
          $damp .= '-- --------------------------------------------------' . nl;
          $damp .= '# -- Table structure for table `' . $table . '`' . nl;
          $damp .= '-- --------------------------------------------------' . nl;
          $damp .= 'DROP TABLE IF EXISTS `' . $table . '`;' . nl;
          
          if (!($result = $db->query('SHOW CREATE TABLE ' . $table))) {
              return false;
          }
          $row = $db->fetch($result);
          $damp .= str_replace("\n", nl, $row['Create Table']) . ';';
          $damp .= nl . nl;
          $damp .= '-- --------------------------------------------------' . nl;
          $damp .= '# Dumping data for table `' . $table . '`' . nl;
          $damp .= '-- --------------------------------------------------' . nl . nl;
          $damp .= $this->insert($table);
          $damp .= nl . nl;
          $db->query('UNLOCK TABLES');
          return $damp;
      }
      
      
      /**
       * dbTools::insert()
       * 
       * @param mixed $table
       * @return
       */
	  function insert($table)
	  {
		  global $db;
		  
		  $output = '';
		  if (!$query = $db->fetch_all("SELECT * FROM `" . $table . "`")) {
			  return false;
		  }
		  foreach ($query as $result) {
			  $fields = '';
			  
			  foreach (array_keys($result) as $value) {
				  $fields .= '`' . $value . '`, ';
			  }
			  $values = '';
			  
			  foreach (array_values($result) as $value) {
				  $value = str_replace(array("\x00", "\x0a", "\x0d", "\x1a"), array('\0', '\n', '\r', '\Z'), $value);
				  $value = str_replace(array("\n", "\r", "\t"), array('\n', '\r', '\t'), $value);
				  $value = str_replace('\\', '\\\\', $value);
				  $value = str_replace('\'', '\\\'', $value);
				  $value = str_replace('\\\n', '\n', $value);
				  $value = str_replace('\\\r', '\r', $value);
				  $value = str_replace('\\\t', '\t', $value);
				  
				  $values .= '\'' . $value . '\', ';
			  }
			  
			  $output .= 'INSERT INTO `' . $table . '` (' . preg_replace('/, $/', '', $fields) . ') VALUES (' . preg_replace('/, $/', '', $values) . ');' . "\n";
		  }
		  return $output;
	  }
      
      /**
       * dbTools::fetch()
       * 
       * @return
       */
      function fetch()
      {
          global $db;
          $dump = '';
          
		  $database = $db->getDB();
		  $server = $db->getServer();
		  
          $dump .= '-- --------------------------------------------------------------------------------' . nl;
          $dump .= '-- ' . nl;
          $dump .= '-- @version: ' . $database . '.sql ' . date('M j, Y') . ' ' . date('H:i') . ' gewa' . nl;
          $dump .= '-- @package CMS Pro' . nl;
          $dump .= '-- @author wojoscripts.com.' . nl;
          $dump .= '-- @copyright 2010' . nl;
          $dump .= '-- ' . nl;
          $dump .= '-- --------------------------------------------------------------------------------' . nl;
          $dump .= '-- Host: ' . $server . nl;
          $dump .= '-- Database: ' . $database . nl;
          $dump .= '-- Time: ' . date('M j, Y') . '-' . date('H:i') . nl;
          $dump .= '-- MySQL version: ' . mysql_get_server_info() . nl;
          $dump .= '-- PHP version: ' . phpversion() . nl;
          $dump .= '-- --------------------------------------------------------------------------------' . nl . nl;
          
		  $database = $db->getDB();
          if (!empty($database)) {
              $dump .= '#' . nl;
              $dump .= '# Database: `' . $database . '`' . nl;
          }
          $dump .= '#' . nl . nl . nl;
          
          if (!($tables = $this->getTables())) {
              return false;
          }
          foreach ($tables as $table) {
              if (!($table_dump = $this->dumpTable($table))) {
                  $db->error("mySQL Error : ");
                  return false;
              }
              $dump .= $table_dump;
          }
          return $dump;
      }
      
      
      /**
       * dbTools::save()
       * 
       * @param mixed $fname
       * @param mixed $sql
       * @param mixed $gzip
       * @return
       */
      function save($fname, $sql, $gzip)
      {
          global $msgError;
          if ($gzip) {
              if (!($zf = gzopen($fname, 'w9'))) {
                  $msgError = "<span>Error!</span>can not write to " . $fname;
                  return false;
              }
              gzwrite($zf, $sql);
              gzclose($zf);
          } else {
              if (!($f = fopen($fname, 'w'))) {
                  $msgError = "<span>Error!</span>can not write to " . $fname;
                  return false;
              }
              fwrite($f, $sql);
              fclose($f);
          }
          return true;
      }
      
      /**
       * dbTools::showTables()
       * 
       * @param mixed $dbtable
       * @return
       */
      function showTables($dbtable)
      {
          global $db;
		  $database = $db->getDB();
		  
          $sql = "SHOW TABLES FROM " . $database;
          $result = $db->query($sql);
          $show = '';
          
          while ($row = $db->fetchrow($result))
              : $selected = ($row[0] == $dbtable) ? " selected=\"selected\"" : "";
          $show .= "<option value=\"" . $row[0] . "\"" . $selected . ">" . $row[0] . "</option>\n";
          endwhile;
          
          $db->free($result);
          
          return($show);
      }
  }
?>