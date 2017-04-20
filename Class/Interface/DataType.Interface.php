<?php
// I am hoping to get this to implement the other datatype interfaces.

//Gathering Interfaces::
require_once('DateTime.Interface.php');
require_once('ForeignKey.Interface.php');
require_once('Index.Interface.php');
require_once('Numeric.Interface.php');
require_once('PrimaryKey.Interface.php');
require_once('String.Interface.php');
require_once('Text.Interface.php');

interface DataType extends DateTimeType,StringType,Text,Numeric,PrimaryKey,ForeignKey,Index {
  //I think that this will work...
  /**
  * interface: to set date
  * @param none
  * @return string of parsed and bound date
  */
  public function qb_date();

  /**
  * interface: to set time
  * @param none
  * @return string of parsed and bound time
  */
  public function qb_time();

  /**
  * interface: set timestamp fields
  * @param none
  * @return string representing a date time timestamp
  */
  public function qb_timestamps();

  /**
  * interface: sets up the foreign key
  * @param $RefKey is the local tabel reference
  * @param $AssocTableName is the referenced table name
  * @param $AssocKey is the field that the local key will bind to
  */
  public function qb_foreign($RefKey, $AssocTableName, $AssocKey);

  public function qb_index($IndexName, $IndexColName);

  public function qb_unique($UniqueColName);

  public function qb_primary($KeyValue);

  public function qb_char($ColName,$ColLen=1);

  public function qb_string($ColName, $ColLen=1);

  public function qb_byte($size1to127);

  public function qb_integer($sizetype);

  public function qb_decimal();

  public function qb_double();

  public function qb_boolean();

  public function qb_unsigned();

}
?>
