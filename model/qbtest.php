<?php
  require("./Class/Database.php");
  require("./Class/testClass.php");

  $host = 'localhost';
  $database = 'phpclasses';
  $dbuser = 'root';
  $dbuserpw = '';

  $qb = new testQueryBuilder($host, $database, $dbuser, $dbuserpw);
  $qb->setDBPrefix("test_");

  $query = $qb->queryStart("alter")->ddlStatement("TABLE")->set_table_name("TableName")->ddlStatement_Alter("change")->selectColumn_name(["mainColumn","newNameCol"],"VARCHAR(100) NOT NULL")->get_query_string();
  //$query = $qb->get_query_string();
  echo $query;
  echo "<br />";
?>
