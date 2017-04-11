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
}
?>
