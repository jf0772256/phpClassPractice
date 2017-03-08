<?php
//this is a class that will open, close db connections and other actions that should make the process simpler.
/**
 *
 */
class DatabaseClass
{
  private $dbhost;
  private $dbname;
  private $dbusername;
  private $dbuserpassword;
  private $dbtableprefix;
  private $dbport;
  protected $dbC;
  public function __construct($ndbhost = "localhost", $ndbname = "", $ndbusername = "", $ndbuserpassword = "", $ndbtableprefix = " ", $ndbport = 3600)
  {
    $this->dbhost = $ndbhost; // Default = localhost
    $this->dbname = $ndbname; // Default = None
    $this->dbusername = $ndbusername; //Default = None
    $this->dbuserpassword = $ndbuserpassword; // Default = None
    $this->dbtableprefix = $ndbtableprefix; //Default = None sets the prefix before the table name so that it can be used with the same db with different tables.
    $this->dbport = $ndbport; // Default  = 3600
    //echo var_dump($this->dbport);
    @ $this->dbC = new mysqli($this->dbhost, $this->dbusername, $this->dbuserpassword, $this->dbname);//, $this->dbport);
    //$this->dbCon = $dbC;
    if ($this->dbC->connect_error) {
      //catch error connecting.
      die("There was a connection error while attempting to connect to the database " . $this->dbname . " on " . $this->dbhost . ":" . $this->dbport . ". The following is the error that we received back: <strong>" . $this->dbC->connect_errno . ": " . $this->dbC->connect_error . "</strong>\n Please correct this issue, if you need assistance see your database or IT administrator.");
    }else{
      //echo "Connected to " . $this->dbname . " on " . $this->dbhost . ":" . $this->dbport;
    }
  }
  public function __destruct(){
    @ $this->dbC->close();
  }
  // get properties All but the prefix are unchangable until a new connection is made.
  public function getHost(){
    return $this->dbhost;
  }
  public function getDatabase(){
    return $this->dbname;
  }
  public function getUsername(){
    return $this->dbusername;
  }
  public function getPassword(){
    return $this->dbuserpassword;
  }
  public function getPort(){
    return $this->dbport;
  }
  public function getDBPrefix(){
    return $this->dbtableprefix;
  }
  // the one setter property
  public function setDBPrefix($prefixValue){
    $this->dbtableprefix = $prefixValue;
  }
}

?>
