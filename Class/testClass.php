<?php
// test class for use of new query builder class idea.
include "Database.php";

class testQueryBuilder extends DatabaseClass
{
  //create query values and return them as value.
  protected $dbC;
  private $host;
  private $dbName;
  private $dbUser;
  private $dbPassword;
  private $tablePrefix;
  private $dbport;

  function __construct($ndbhost = "localhost", $ndbname = "", $ndbusername = "", $ndbuserpassword = "", $ndbtableprefix = " ", $ndbport = 3600){
    //default Constructor
    $this->host = $ndbhost;
    $this->dbName = $ndbname;
    $this->dbUser = $ndbusername;
    $this->dbPassword = $ndbuserpassword;
    $this->tablePrefix = $ndbtableprefix;
    $this->dbport = $ndbport;

    parent::__construct($this->host, $this->dbName, $this->dbUser, $this->dbPassword, $this->tablePrefix, $this->dbport);
    $this->dbC = parent::getdbconnection();
  }
}
?>
