<?php
//this is a class that will open, close db connections and other actions that should make the process simpler.
/**
 *
 */
class DatabaseClass
{
  private $dbhost, $dbname, $dbusername, $dbuserpassword, $dbtableprefix, $dbport;
  public function __construct($dbhost = NULL, $dbname = "", $dbusername = NULL, $dbuserpassword = NULL, $dbtableprefix = NULL, $dbport = "3600")
  {
    $this -> $dbhost = $dbhost;
    $this -> $dbname = $dbname;
    $this -> $dbusername = $dbusername;
    $this -> $dbuserpassword = $dbuserpassword;
    $this -> $dbtableprefix = $dbtableprefix; // sets the prefix before the table name so that it can be used with the same db with different tables.
    $this -> $dbport = $dbport;
    @ $dbC = new mysqli($this->$dbhost, $this->$dbusername, $this->$dbuserpassword, $this->$dbname, $this->$dbport);
    if ($dbC -> connect_error) {
      //catch error connecting.
      die("There was a connection error while attempting to connect to the database " . $this->$dbname . " on " . $this->$dbhost . ":" . $this->$dbport . ". The following is the error that we received back: " . $dbC->connect_errno . ": " . $dbC->connect_error . "\nPlease correct this issue, if you need assistance see your database or IT administrator.");
    }else{
      echo "Connected to " . $this->$dbname . " on " . $this->$dbhost . ":" . $this->$dbport;
    }
  }
  public function __destruct(){
    $this -> $dbC -> close();
  }
  // get properties All but the prefix are unchangable until a new connection is made.
  public function getHost(){ return $this->$dbhost; }
  public function getDatabase(){ return $this->$dbname; }
  public function getUsername(){ return $this->$dbusername; }
  public function getPassword(){ return $this->$dbuserpassword; }
  public function getPort(){ return $this->$dbport; }
  public function getDBPrefix(){ return $this->$dbtableprefix; }
  // the one setter property
  public function setDBPrefix($prefixValue){ $this->$dbtableprefix = $prefixValue; }
}

?>
