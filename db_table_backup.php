
<?php

  $db_user = $db_pass = $db_name = $db_table = $backup_filename = "";

  if (isset($_POST['db_user']) and isset($_POST['db_pass']) and isset($_POST['db_name']) and isset($_POST['db_table']) ) {
    $db_user = $_POST['db_user'];
    $db_pass = $_POST['db_pass'];
    $db_name = $_POST['db_name'];
    $db_table = $_POST['db_table'];
  }

  if (isset($_GET['db_user']) and isset($_GET['db_pass']) and isset($_GET['db_name']) and isset($_GET['db_table']) ) {
    $db_user = $_GET['db_user'];
    $db_pass = $_GET['db_pass'];
    $db_name = $_GET['db_name'];
    $db_table = $_GET['db_table'];
  }

  // set a fix export filename to download the export via script
  if (isset($_GET['export_file'])) {
      $backup_filename =  $_GET['export_file'];
      echo "<pre>filename postfix set [" . $backup_filename . "]</pre>";
  }

  // if all parameters set, make a backup
  if ($db_user != "" && $db_pass != "" && $db_name != "" && $db_table != "") {
    create_backup($db_user, $db_pass, $db_name, $db_table, $backup_filename);
  } else {
    echo "not all parameters set";
  }

 ?>

<html>
<head>
  <title>database backup</title>
</head>

<body>
<pre>
  <p>
    <table>
    <form action="" method="post">
      <tr>
        <td>database user</td><td><input type="text" name="db_user" value="<?php echo $db_user ?>"></td>
        <td>database password</td><td><input type="text" name="db_pass" value="<?php echo $db_pass ?>"></td>
      </tr>
      <tr>
        <td>database name</td><td><input type="text" name="db_name" value="<?php echo $db_name ?>"><br></td>
        <td>database table</td><td><input type="text" name="db_table" value="<?php echo $db_table ?>"><br></td>
      </tr>
      <tr>
        <td><input type="submit" name="submit" value="go !" /></td>
      </tr>
    </form>
    </table>
  </p>
</pre>
</body>

</html>

<?php

/*
 * houskeeping, remove old backup files
 */
function remove_old_backup_files() {
  $all_files = scandir(".");
  foreach($all_files as $file) {
    if (is_file($file)) {
      if (preg_match("#^db_backup_.*\.sql#", basename($file))) {
        echo "<pre>delete old backup file [" . basename($file) . "]</pre>";
        unlink($file);
      }
    }
  }
}
/*
 * backup some tables or the complete database
 */
function create_backup($db_user, $db_pass, $db_name, $db_table = "*", $export_file = "") {

  remove_old_backup_files();
  $mysqli = new mysqli('localhost', $db_user, $db_pass, $db_name);
  if ($mysqli->connect_errno) {
    die("can not connect to database : " . $mysqli->connect_error);
  } else {
    print "<pre>database connection established ...</pre>";
  }
/*
  $conn = mysql_connect('localhost', $db_user, $db_pass);
  if (!$conn) {
    die ('can not connect to database : ' . mysql_error());
  }

  $db_selected = mysql_select_db($db_name, $conn);
  if (!$db_selected) {
    die ('can not select databse : ' . mysql_error());
  }
*/
  print "<pre>user [" . $db_user . "]  pass [" . $db_pass . "]  db_name [" . $db_name . "]  db_table [" . $db_table . "]</pre>";

  // get the table name array
  if ($db_table == '*') {
    //print "<pre>get all</pre>";
    $tables = array();
    //$result = mysql_query('show tables');
    $result = $mysqli->query('show tables');
    
    if ($result->num_rows === 0) {
        die("no table for backup found, exit ...");
    } else {
        print "<pre>backup " . $result->num_rows . " tables</pre>";
    }
    
    while ($row = $result->fetch_array()) {
        //print_r($row);
        //print "<pre>add table : " . $row[0]. "</pre>";
        //$tables[] = $row->Tables_in_fcb;
        $tables[] = $row[0];
    }
        
/*    while ($row = mysql_fetch_row($result)) {
      $tables[] = $row[0];
      
    }*/
  } else {
    $tables = is_array($db_table) ? $db_table : explode(',', $db_table);
  }

  // backup the table array
  $return = "";
  foreach ($tables as $table) {
    echo "<pre>export table [" . $table . "]</pre>";
    //$result = mysql_query('SELECT * FROM '.$table);
    $result = $mysqli->query('SELECT * FROM '.$table);
		//$num_fields = mysql_num_fields($result);
		$num_fields = $result->num_rows;
        echo "<pre>export table [" . $table . "] table size [" . $num_fields . "]</pre>";

		$return.= 'DROP TABLE '.$table.';';
		//$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
		$result2 = $mysqli->query('SHOW CREATE TABLE '.$table);
		$row2 = $result2->fetch_assoc();
		//print_r($row2);
		//print "<pre>" . $row2['Create Table']. "</pre>";
		$create_table_statement = $row2['Create Table'];
		
		$return.= "\n\n".$create_table_statement.";\n\n";

		for ($i = 0; $i < $num_fields; $i++) {
			//while($row = mysql_fetch_row($result)) {
            while($row = $result->fetch_array()) {
                
                $num_fields = sizeof($row)/2;
                //print "<pre>" . $num_fields . "</pre>";
                
                //$num_fields = $row->num_rows;
                //print_r($row);
                //print "num rows: " . $row->num_rows;
                //print_r($row[0]);
                
                //print_r($row[1]);
                
                //if($row->num_rows != $num_fields) {
                //    die("selected table rows are different " . $row->num_rows . "!=" . $num_fields);
                //}
                
                //print_r($row);
                //print "<pre>" . $row[0] . "</pre>";
                $return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j < $num_fields; $j++) {
					$row[$j] = addslashes($row[$j]);
					//$row[$j] = ereg_replace("\n","\\n",$row[$j]);
                    //$row[$j] = preg_replace("\n","\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j < ($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
  }

  // save the data into a file
  $file_name = "";

  if ($export_file != "") {
    $file_name = 'db_backup_'.$export_file.'.sql';
  } else {
    $file_name = 'db_backup_'.date('Y-m-d_H-i-s').'_'.(md5(implode(',',$tables))).'.sql';
  }

  echo "<pre>backup file [" . $file_name . "] </pre>";
  $file_handle = fopen($file_name, 'w+') or die ('ERROR : unable to open backup file!');
  fwrite($file_handle, $return);
  fclose($file_handle);

  // compress sql file
  //exec("gzip $file_name");
  //$zipfile = $file_name . ".gz";
  $size = filesize($file_name);

  // calculate file size
  $i = 0;
  while ($size > 1024) {
    $i++;
    $size = $size / 1024;
  }
  $file_size_names = array(" Bytes", " KiloBytes", " MegaBytes", " GigaBytes", " TerraBytes");
  $size = round($size,2);
  $size = str_replace(".", ",", $size);
  $size_name = "$size $file_size_names[$i]";
  echo "<pre>file size : " . $size_name . "</pre>";

  echo '<pre><a href="http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/'.$file_name.'">download link</a></pre>';

  // finally close the db connection
  //mysql_close($conn);
}

 ?>
