<?php
  require("./Class/Database.php");
  require("./Class/testClass.php");

  $host = 'localhost';
  $database = 'phpclasses';
  $dbuser = 'phpClasses';
  $dbuserpw = 'test1234';

  $qb = new testQueryBuilder($host, $database, $dbuser, $dbuserpw);
  $qb->setDBPrefix("test_");

  $query = $qb->queryStart("ALTER")->ddlStatement("TABLE")->set_table_name("valueTable")->ddlStatement_Alter("alter")->selectColumn_name(["username","password"])->get_query_string();
  $qb->set_ClearQuery();
  //$query = $qb->get_query_string();
  echo $query;
  echo "<br />";
?>
