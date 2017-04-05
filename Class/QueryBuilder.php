<?php
  //Class for query building.
  Class QueryBuilderClass extends DatabaseClass
  {
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

    // function __destruct(){
    //   parent::__desctruct();
    // }

    public function create_newTable($tableName, $tableParams){
      //Table name expects a valid string, Table params requires an array, minus commas of strings for each column in the table.
      if (!is_array($tableParams)){
        throw new ErrorException("Expected array of strings. Review documentation for further information.");
        exit();
      }else{
        $tableName = parent::getDBPrefix() . $tableName;
        $query="CREATE TABLE IF NOT EXISTS $tableName (";
        foreach ($tableParams as $params) {
          $query = $query . $params . ", ";
        }
        //now to crop the last comma off
        $query = parent::cropStringValue($query,2);
        $query = $query . ")";
        $stmnt = $this->dbC->prepare($query);
        if($stmnt){
          $stmnt->execute();
        }else{
          echo "error: " . $this->dbC->connect_error();
        }

      }
    }

    public function renameTableName($oldTableName, $newTableName){
      //assumes that you didnt include the prefix on the newTableName, Old table name now will add the database prefix. so you wont need to.
      // uses a simple request to change teh oldTableName to newTableName and prepend the prefix, This can be used individually
      // we will work on a renaming call for if you change the prefix.
      $oldTableName = parent::getDBPrefix() . $oldTableName;
      $table_exists = parent::check_preexisting_tables($oldTableName);
      if ($table_exists) {
        $newTableName = parent::getDBPrefix() . $newTableName;
        $query = "RENAME TABLE $oldTableName TO $newTableName";
        $stmnt = $this->dbC->prepare($query);
        $result = $stmnt->execute();
        if ($result) {
          return true;
        }else{
          return false;
        }
      }else{
        return false;
      }
    }

    public function dropTableByName($tableName){
      $table_exists = parent::check_preexisting_tables($tableName);
      if ($table_exists) {
        $tableName = parent::getDBPrefix() . $tableName;
        $query = "DROP $tableName";
        $stmnt = $this->dbC->prepare($query);
        $result = $stmnt->execute();
        if (!$result){
          return false;
        }else{
          return true;
        }
      }else{
        return false;
      }
    }

    public function build_select_query($queryArray, $tableArray, $whereArray=[], $groupArray=[], $orderBY=[]){
      //builds a query based on arrays sent from caller and that utilize SELECT.
      //Assumes that all params sent are arrays, queryArray and tableArray are mandetory,
      //optional arrays are the whereArray, and the groupArray to send special grouping select query statement
      //orderBY is special, acceptong one or two values in an array, either column name for assencnding ordering
      //or column name, and keyword 'DESC' for decending order.
      //failing to send arrays will throw exception!

      if (!is_array($queryArray) || !is_array($tableArray) || !is_array($whereArray) || !is_array($groupArray) || !is_array($orderBY)) {
        throw new ErrorException("Expected array of strings. Review documentation for further information.");
        exit();
      }else{
        $still_Connected = parent::checkConnection();
        if ($still_Connected == 1) {
          //execute query after build
          $query = 'SELECT ';
          foreach ($queryArray as $key => $value) {
            $query .= $value . ", ";
          }
          $query = parent::cropStringValue($query,2);
          $query .= " FROM ";
          foreach ($tableArray as $key => $value) {
            $query .= $value . " , ";
          }
          $query = parent::cropStringValue($query,2);
          if (!empty($whereArray)) {
            //iterate through the array and put the values to the query
            $query .= "WHERE ";
            foreach ($whereArray as $key => $value) {
              $query .= $value . " ";
            }
            //check if the group by array is empty and sdo the same... Only orderby can be done with out where clause.
            if (!empty($groupArray)) {
              //append to the end of the query string
              $query .= "GROUP BY ";
              foreach ($groupArray as $key => $value) {
                $query .= $value . " ";
              }
            }
          }
          if (!empty($orderBY)) {
            //append to the end of the query string.
            $query .= "ORDER BY ";
            foreach ($orderBY as $key => $value) {
              $query .= $value . " ";
            }
          }
          //return query string to caller to be executed.
          return $query;
        }else{
          // send to connection error page.
          $error_message = "Your connection to the database has either timed out, or you have somehow lost connection to the server. Refresh the page and try again.";
          include ("error/db_error.php");
          exit();
        }
      }
    }

    public function build_update_query($tableName,$updateArray,$whereArray){
      // build the query that would update the specified value in the column, in the table.
      // expects table name No pefix as it will be automatically added to the table. and an array of strings as update params, as well as a where array to specify condtions to use to update.
      $dbprefix = parent::getDBPrefix();
      if (empty($tableName) || !is_array($updateArray) || !is_array($whereArray)) {
        //there was an unexpected input paramert rceived and now will throw an error and exit the code.
        throw new ErrorException("Expected array of strings. Review documentation for further information.");
        exit();
      }
      $tableName = $dbprefix . $tableName;
      $query = "UPDATE $tableName SET ";
      foreach ($updateArray as $key => $value) {
        // parse array into query.
        $query .= $value . ", ";
      }
      $query = parent::cropStringValue($query,2) . " WHERE "; //
      foreach ($whereArray as $key => $value) {
        $query .= $value . ", ";
      }
      $query = parent::cropStringValue($query,2);
      return $query;
    }
  }
?>
