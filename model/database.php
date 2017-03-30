<?php
//this is the database where we are going to be setting up the connection to the database created: phpClases
  require("./Class/Database.php");
  require("./Class/QueryBuilder.php");

  $result=false;

  $host = 'localhost';
  $database = 'phpclasses';
  $dbuser = 'root';
  $dbuserpw = '';

  //now I want to see that the connection has been made.
  $db = new DatabaseClass($host, $database, $dbuser, $dbuserpw);
  $qb = new QueryBuilderClass($host, $database, $dbuser, $dbuserpw);

  //$db->setDBPrefix("test_");
  //echo $db->getDBPrefix();
  //echo "<br />";
  //echo $db->checkConnection();

  //sets the prefix to the desired value.
  $db->setDBPrefix("test_");

  //$broken = "testID INT UNSIGNED NOT NULL AUTO_INCREMENT,testUserName VARCHAR(30) NOT NULL,testFlag TINYINT(1) DEFAULT 1,PRIMARY KEY (testID)"; //shows the break when you try to send wrong data type.
  // Table col uses line by line, just the parameters, like as shown below. Do not use eol commas.

  $tablecol = array();
  $tablecol[0] = "testID INT UNSIGNED NOT NULL AUTO_INCREMENT";
  $tablecol[1] = "testUserName VARCHAR(30) NOT NULL";
  $tablecol[2] = "testFlag TINYINT(1) DEFAULT 0";
  $tablecol[3] = "PRIMARY KEY (testID)";

  //$db->create_newTable("test", $tablecol);

  //table createion function returns success or fail.
  try {
    //create_newTable accepts 2 parameters, the first is the prefixless table name, and the second is the array for the table structure.
    $result = $db->create_newTable("testTableFromClass", $tablecol);
  } catch (Exception $e) {
    $message_error = "Message: " . $e->getMessage();
    echo "<div class='well'>";
    echo "<p class='alert alert-danger'>$message_error</p>";
    echo "<p class='alert alert-info'>Your table column values should be stored in an array, with out leading or trailing commas, then pass that array to the table creator.</p>";
    echo "</div>";
  }

  // code to drop table from db
  // $result = $db->dropTableByName("testTableFromClass");

  //rename table due to something like a need, here we only have one table, we can change the prefix.
  //just remember that the new table name will not need the prefix, but the old table name will only need the prefix added if the prefix is being changed.

  //$db->setDBPrefix("");
  //$result = $db->renameTableName("test_testTableFromClass","jesses_Table");

  //just cleaning up :)
  // $result = $db->dropTableByName("jesses_Table");
  $table_Name = $db->getDBPrefix() . "testTableFromClass";
  $selectQuery = ['testUserName'];
  $fromQuery = ["$table_Name"];
  $whereQuery = ['testFlag = 1'];
  $groupQuery = [];
  $OrderQuery = ['testUserName','DESC'];
  $retQuery = $qb->build_select_query($selectQuery,$fromQuery,$whereQuery,$groupQuery,$OrderQuery);
  echo $retQuery;
  echo "<br />";

  $table_Name = "testTableFromClass";
  $update_query = ['testFlag = 0',"testUserName = 'Jesse'"];
  $whereQuery =['testID = 1'];
  $retQuery = $qb->build_update_query($table_Name,$update_query,$whereQuery);
  echo $retQuery;

?>
