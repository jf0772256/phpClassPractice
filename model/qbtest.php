<?php
  require("./Class/Database.php");
  require("./Class/testClass.php");

  $host = 'localhost';
  $database = 'phpclasses';
  $dbuser = 'phpClasses';
  $dbuserpw = 'test1234';

  $qb = new testQueryBuilder($host, $database, $dbuser, $dbuserpw);
  $qb->setDBPrefix("test_");

  $query = $qb->queryStart("CREATE")->ddlStatement("TABLE")->set_table_name([],"valueTable")->get_query_string();
  //$query = $qb->get_query_string();
  echo $query;
?>
