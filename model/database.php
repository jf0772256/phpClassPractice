<?php
//this is the database where we are going to be setting up the connection to the database created: phpClases
  require("./Class/Database.php");

  $result=false;

  $host = 'localhost';
  $database = 'phpClasses';
  $dbuser = 'phpClases';
  $dbuserpw = 'test1234';
  $db_Prefix = '';
  //now I want to see that the connection has been made.
  $db = new DatabaseClass($host, $database, $dbuser, $dbuserpw);

  //sets the prefix to the desired value.
  $db->setDBPrefix("test_");
  //$broken = "testID INT UNSIGNED NOT NULL AUTO_INCREMENT,testUserName VARCHAR(30) NOT NULL,testFlag TINYINT(1) DEFAULT 1,PRIMARY KEY (testID)"; //shows the break when you try to send wrong data type.
  // Table col uses line by line, just the parameters, like as shown below. Do not use eol commas.
  $tablecol = array();
  $tablecol[0] = "testID INT UNSIGNED NOT NULL AUTO_INCREMENT";
  $tablecol[1] = "testUserName VARCHAR(30) NOT NULL";
  $tablecol[2] = "testFlag TINYINT(1) DEFAULT 0";
  $tablecol[3] = "PRIMARY KEY (testID)";
  //table createion function returns success or fail.
  try {
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


?>
