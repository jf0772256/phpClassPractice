<?php
  require("./Class/Database.php");
  require("./Class/testClass.php");

  $host = 'localhost';
  $database = 'phpclasses';
  $dbuser = 'phpClasses';
  $dbuserpw = 'test1234';

  $qb = new testQueryBuilder($host, $database, $dbuser, $dbuserpw);
  $qb->setDBPrefix("test_");

  $query = $qb->queryStart("create")->ddlStatement("TABLE")->set_table_name("test_Table")->selectColumn_name(["col1 INT UNSIGNED NOT NULL AUTO_INCREMENT","col2 VARCHAR(100) NOT NULL","col3 VARCHAR(25) NOT NULL", "PRIMARY KEY (col1)"])->get_query_string();
  $qb->set_ClearQuery();
  //$query = $qb->get_query_string();
  echo $query;
  echo "<br />";
?>
