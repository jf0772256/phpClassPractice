<?php
//this is the database where we are going to be setting up the connection to the database created: phpClases
  require("./Class/Database.php");

  $host = 'localhost';
  $database = 'phpClasses';
  $dbuser = 'phpClases';
  $dbuserpw = 'test1234';
  $db_Prefix = '';
  //now I want to see that the connection has been made.
  $db = new DatabaseClass($host, $database, $dbuser, $dbuserpw);

  $db->setDBPrefix("test_");
  echo $db->getDBPrefix();
  echo "<br />";
  echo $db->checkConnection();
  $tablecol = array();
  $tablecol[0] = "testID INT UNSIGNED NOT NULL AUTO_INCREMENT";
  $tablecol[1] = "testUserName VARCHAR(30) NOT NULL";
  $tablecol[2] = "testFlag TINYINT(1) DEFAULT 0";
  $tablecol[3] = "PRIMARY KEY (testID)";
  $db->create_newTable("test", $tablecol);
?>
