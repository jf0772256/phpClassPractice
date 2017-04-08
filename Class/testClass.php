<?php
// test class for use of new query builder class idea.
// include ("Database.php");

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
  private $queryString;
  private $modeVal;


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

  public function queryStart($mode){
    // is the start of the query
    if (strtoupper($mode) == "SELECT") {
      $this->queryString = "SELECT ";
    }elseif (strtoupper($mode) == "UPDATE") {
      $this->queryString = "UPDATE ";
    }elseif (strtoupper($mode) == "DELETE") {
      $this->queryString = "DELETE ";
    }elseif (strtoupper($mode) == "INSERT") {
      $this->queryString = "INSERT ";
    }elseif (strtoupper($mode) == "CREATE") {
      $this->queryString = "CREATE ";
    }elseif (strtoupper($mode) == "DROP") {
      $this->queryString = "DROP ";
    }elseif (strtoupper($mode) == "ALTER") {
      $this->queryString = "ALTER ";
    }
    return $this;
  }

  public function ddlStatement($ddl2ndpart){
    //if a ddl statement then accept then second part of the ddl statement
    if ($this->queryString == "CREATE " || $this->queryString == "DROP " || $this->queryString == "ALTER "){
      $this->queryString .= $this->dbC->real_escape_string(htmlspecialchars($ddl2ndpart)) . " ";
      if ($this->queryString == "DROP TABLE ") {$this->queryString .= "IF EXISTS ";$this->modeVal = "ddl-drop";}
      if ($this->queryString == "CREATE TABLE "){$this->modeVal = "ddl-createTable";}
      if ($this->queryString == "ALTER TABLE ") { $this->modeVal = "ddl-alterTable"; }
      // $this->modeVal = "ddl-createTable";
    }else{
      $this->modeVal = "dml-" . $this->queryString;
    }
    return $this;
  }

  public function set_table_name($tableVar){
    //tableVar accepts either a string value, or an array of strings of table names
    if (empty($tableVar)) {
      throw new Exception("Error Processing Request: Expecting an array or a string, none were sent with your request;");
    }elseif(!empty($tableVar)) {
      if (!is_array($tableVar)) {
        //do string stuff
        $tableVar = $this->dbC->real_escape_string(htmlspecialchars($tableVar));
        $this->queryString .= $tableVar . " ";
      }else{
        //do array stuff
        foreach ($tableVar as $tName) {
          $tName = $this->dbC->real_escape_string(htmlspecialchars($tName));
          $this->queryString .= $tName . ", ";
        }
        $this->queryString = parent::cropStringValue($this->queryString,2);
      }
    }
    if ($this->modeVal == "ddl-createTable") {
      $this->queryString .= "(";
    } //there will be more added here to support DML querys
    return $this;
  }

  public function get_query_string(){
    return $this->queryString;
  }

  public function set_ClearQuery(){
    $this->queryString = "";
    $this->modeVal = "";
    return $this;
  }

  public function ddlStatement_Alter($alterCommand){
    if ($this->modeVal == "ddl-alterTable") {
      //means that Alter DDL was used.
      $alterCommand = $this->dbC->real_escape_string(htmlspecialchars(strtoupper($alterCommand)));
      if ($alterCommand == "ADD") {
        $this->modeVal .= "-ADD";
        $this->queryString .= $alterCommand . " ";
      }elseif ($alterCommand == "DROP") {
        $this->queryString .= $alterCommand . " ";
      }elseif ($alterCommand == "CHANGE") {
        $this->modeVal .= "-CHANGE";
        $this->queryString .= $alterCommand . " ";
      }elseif ($alterCommand == "MODIFY") {
        $this->modeVal .= "-MODIFY";
        $this->queryString .= $alterCommand . " ";
      }elseif ($alterCommand == "ALTER") {
        $this->modeVal .= "-ALTER";
        $this->queryString .= $alterCommand . " ";
      }elseif ($alterCommand == "RENAME"){
        $this->modeVal .= "-RENAME";
        $this->queryString .= $alterCommand . " TO ";
      }else{
        throw new Exception("Error Processing Request: Invalid response received Alter does not have method value " . $alterCommand);
      }
    }
    return $this;
  }
  public function ddlStatement_Alter_next($alterCommand){
    // watches for special later commands
  }

  public function selectColumn_name($colName, $colDefVal = ""){
    // collects colName(s) from user with either single string or array,
    // collects optional colDefVal(s) from a string or array of values.
    if (empty($colName)) {
      throw new Exception("Error Processing Request: ColumnName cannot be empty. May be an array or a string ");
    }elseif (is_array($colName)){
      if ($this->modeVal == "ddl-alterTable-ADD" || $this->modeVal == "ddl-alterTable-MODIFY" || $this->modeVal == "ddl-alterTable-ALTER") {
        throw new Exception("Error Processing Request: Alter mode does not support multiple columns - use single column string instead ");
      }else {
        foreach ($colName as $cName) {
          $this->queryString .= $this->dbC->real_escape_string(htmlspecialchars($cName)) . ", ";
        }
        $this->queryString = parent::cropStringValue($this->queryString,2);
        $this->queryString .= " ";
      }
    }elseif (is_string($colName)) {
      $colName = $this->dbC->real_escape_string(htmlspecialchars($colName));
      $this->queryString .= $colName . " ";
    }
    if (!empty($colDefVal)) {  //  mostly used when altering tables/columns
      if (is_array($colDefVal)) {
        foreach ($colDefVal as $value) {
          $value = $this->dbC->real_escape_string(htmlspecialchars($value));
          $this->queryString .= $value . " ";
        }
        $this->queryString = parent::cropStringValue($this->queryString,1);
      }elseif (is_string($colDefVal)) {
        $colDefVal = $this->dbC->real_escape_string(htmlspecialchars($colDefVal));
        $this->queryString .= $colDefVal;
      }
    } //if empty do nothing

    if ($this->modeVal == "ddl-createTable") {
      $this->queryString = parent::cropStringValue($this->queryString,1);
      $this->queryString .= ")";
    }
    return $this;
  }
}
?>
