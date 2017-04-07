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
  private $mode;


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
    if ($mode == "SELECT") {
      $this->queryString = "SELECT ";
    }elseif ($mode == "UPDATE") {
      $this->queryString = "UPDATE ";
    }elseif ($mode == "DELETE") {
      $this->queryString = "DELETE ";
    }elseif ($mode == "INSERT") {
      $this->queryString = "INSERT ";
    }elseif ($mode == "CREATE") {
      $this->queryString = "CREATE ";
    }elseif ($mode == "DROP") {
      $this->queryString = "DROP ";
    }elseif ($mode == "ALTER") {
      $this->queryString = "ALTER ";
    }elseif ($mode == "RENAME") {
      $this->queryString = "RENAME ";
    }
    return $this;
  }

  public function ddlStatement($ddl2ndpart){
    //if a ddl statement then accept then second part of the ddl statement
    if ($this->queryString == "CREATE " || $this->queryString == "DROP " || $this->queryString == "ALTER " || $this->queryString == "RENAME "){
      $this->queryString .= $this->dbC->real_escape_string(htmlspecialchars($ddl2ndpart)) . " ";
    }
    return $this;
  }

  public function set_table_name($tablesArray="", $tableVar =""){
    //tablesArray needs array -> or will fail, it's optional
    //tableVar needs single value, it to is optional BUT
    //One or the other MUST be used.
    if (empty($tablesArray) && empty($tableVar)) {
      throw new Exception("Error Processing Request: Expecting an array or a string, none were sent with your request;");
    }elseif(!empty($tablesArray) && empty($tableVar)) {
      if (!is_array($tablesArray)) {
        throw new Exception("Error Processing Request: Expecting an Array containing only strings. If you are wishing to send one table sent an empty array param '[]' followed by your desired table name;");
      }else{
        //do array stuff
        foreach ($tablesArray as $tName) {
          $tName = $this->dbC->real_escape_string(htmlspecialchars($tName));
          $this->queryString .= $tName . ", ";
        }
        $this->queryString = parent::cropStringValue($this->queryString,2);
      }
    }elseif(empty($tablesArray) && !empty($tableVar)) {
      if (!is_string($tableVar)) {
        throw new Exception("Error Processing Request: Expecting a string value, but something else was passed. Please ensure that you are using a string. If you encounter further trouble please review the documentation;");
      }else{
        //do string stuff
        $tableVar = $this->dbC->real_escape_string(htmlspecialchars($tableVar));
        $this->queryString .= $tableVar;
      }
    }elseif (!empty($tablesArray) && !empty($tableVar)) {
      throw new Exception("Error Processing Request: Only one value can be accepted, either in array form or in string form, for further information see documentation;");
    }
    return $this;
  }

  public function get_query_string(){
    return $this->queryString;
  }
}
?>
